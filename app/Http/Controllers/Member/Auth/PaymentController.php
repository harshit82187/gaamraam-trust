<?php

namespace App\Http\Controllers\Member\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Auth;

use App\Models\User;
use App\Models\Payment;
use App\Models\Referral;

use App\Mail\SendDonationInvoiceMail;

use Hash;
use Str;
use Mail;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Illuminate\Support\Facades\File;
use Barryvdh\DomPDF\Facade\Pdf;
use Razorpay\Api\Api;
use Illuminate\Support\Facades\Http;
use App\Models\BussinessSetting;

class PaymentController extends Controller
{
    public function payment(Request $req){
        $id = Auth::user()->id;
        $member =  Auth::user();
        $query = Payment::with('member')->orderBy('created_at','desc')->where('user_id',$id)->whereIn('mode',[1,4,5]);
        if ($req->filled('invoice_no')) {
            $query->where('invoice_no', 'like', '%' . $req->invoice_no . '%');
        }
        $donations = $query->paginate(10)->appends($req->all());
        // dd($donations, Auth::User()->mobile,$member);
        return view('member.auth.payment.index', compact('donations','member'));    
    }

    public function paymentOffline(Request $req){
        $id = Auth::user()->id;
        $member =  Auth::user();
        $query = Payment::with('member')->orderBy('created_at','desc')->where('user_id',$id)->whereIn('mode',[3]);
        if ($req->filled('invoice_no')) {
            $query->where('invoice_no', 'like', '%' . $req->invoice_no . '%');
        }
        $donations = $query->paginate(10)->appends($req->all());
        // dd($donations, Auth::User()->mobile,$member);
        return view('member.auth.payment.index', compact('donations','member'));    
    }

    public function initiatePayment(Request $request){
        Log::channel('order')->info('Razorpay initiatePayment hit.', [
            'request_data' => $request->all(),
            'user' => auth()->user()
        ]);
        try {
            $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
            $amount = intval($request->amount * 100); 
            $order = $api->order->create([
                'amount' => $amount,
                'currency' => 'INR',
                'receipt' => Str::random(10)
            ]);
            Log::channel('order')->info('Razorpay order created successfully.', [
                'order_id' => $order['id'],
                'amount' => $amount,
                'request_amount' => $request->amount
            ]);
            return response()->json([
                'order_id' => $order['id'],
                'razorpay_key' => env('RAZORPAY_KEY'),
                'amount' => $request->amount,
                'currency' => 'INR',
                'customer' => [
                    'name' => $request->name,
                    'number' => $request->number ?? null,
                    'email' => $request->email
                ]
            ]);
        } catch (\Exception $e) {
            Log::channel('order')->error('Razorpay order creation failed.', ['error' => $e->getMessage()]);
            return response()->json([
                'status' => false,
                'message' => 'Unable to initiate Razorpay payment. Try again later.'
            ], 500);
        }
    } 

    public function proceedPayment($request){
        try {
            Log::info('Razorpay Payment Success Request', $request);

            $razorpayPaymentId = $request['razorpay_payment_id'];
            $merchant_order_id = $request['merchant_order_id'];

            $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
            $payment = $api->payment->fetch($razorpayPaymentId);

            $createdPayment = Payment::create([
                'mode' => '4',
                'r_payment_id' => $payment['id'],
                'r_order_id' => $payment['order_id'],
                'merchant_order_id' => $merchant_order_id,
                'method' => $payment['method'],
                'currency' => $payment['currency'],
                'user_id' => Auth::user()->id,
                'user_email' => Auth::user()->email ?? '',
                'user_name' => Auth::user()->name ?? '',
                'user_mobile' => Auth::user()->mobile ?? '',
                'amount' => $payment['amount'] / 100,
                'json_response' => json_encode($payment->toArray()),
            ]);

            return $createdPayment; // ✅ THIS IS IMPORTANT
        } catch (\Exception $e) {
            Log::channel('razorpay')->error('Razorpay payment processing failed.', ['error' => $e->getMessage()]);
            return false; // ❌ OR 'failed', as you're handling above
        }
    }



    public function donate(Request $request){
        // dd($request->all());      
        DB::beginTransaction();
        try{
            $request->validate([
                'razorpay_payment_id' => 'required|string',
                'razorpay_order_id' => 'required|string',
                'transaction_via' => 'required|string',
                'amount' => 'required|numeric',
                'merchant_order_id' => 'required|string',
            ]);

            $paymentData = [
                'razorpay_payment_id' => $request->razorpay_payment_id,
                'merchant_order_id' => $request->merchant_order_id,
                'amount' => $request->amount,
            ];
            $payment = $this->proceedPayment($paymentData);
            if ($payment) {

                $member = Auth::user();
                $referral_points  =  $request->amount * 0.10;
                if($referral_points < 1) {
                    $referral_points = 1;
                }
                $member->points += $referral_points;
                $member->save();
                Referral::create([
                    'referrer_id' => $member->id,  
                    'referred_id' => $member->id,
                    'points' => $referral_points,
                    'type'   => 4,
                ]);  

                $r_payment_id = $request->razorpay_payment_id;                
                $payment_table = Payment::where('r_payment_id',$r_payment_id)->first();
                if(!$payment_table){
                    Log::channel('razorpay')->error("Payment record not found for r_payment_id: " . $r_payment_id);
                    return back()->with('error','Record Not Found!');
                }
                $invoiceNumber = now()->format('Ym') . rand(100000, 999999);
                // Generate invoice and save PDF
                $year = now()->year;
                $month = now()->format('M');
                $today = Carbon::now()->format('d-M-Y');
                $fileName = "invoice_{$invoiceNumber}.pdf";
                $directoryPath = public_path("app/member-donation/{$year}/{$month}");
                $adminEmail = BussinessSetting::where('type','email')->value('value');

                if (!File::exists($directoryPath)) {
                    File::makeDirectory($directoryPath, 0777, true);
                }

                // Generate the QR code with the route
                $qrCode = new QrCode(route('member-invoice', ['invoiceNumber' => $invoiceNumber]));
                $writer = new PngWriter();
                $qrCodeContent = $writer->write($qrCode)->getString();

                // Save QR code to the local path
                $qrCodeDirectory = public_path("app/member-donation/qr-codes/{$year}/{$month}");
                if (!File::exists($qrCodeDirectory)) {
                    File::makeDirectory($qrCodeDirectory, 0777, true);
                }

                // Define the file path for the QR code
                $qrCodeFilePath = "{$qrCodeDirectory}/{$invoiceNumber}-qr.jpg"; 
                file_put_contents($qrCodeFilePath, $qrCodeContent);

                $payment_table->update([
                    'qr_image' => "app/member-donation/qr-codes/{$year}/{$month}/{$invoiceNumber}-qr.jpg",
                    'invoice_no' => $invoiceNumber,
                ]);

                 // Generate the PDF
                 $count = 0;
                 $filePath = "{$directoryPath}/{$fileName}";
                 $pdf = Pdf::loadView('pdf.member.donation-invoice', compact('payment_table','adminEmail', 'today', 'qrCodeFilePath','count'));
                 $pdf->save($filePath);

                // Update booking with generated PDF file path
                $payment_table->update([
                    'donation_pdf' => "app/member-donation/{$year}/{$month}/{$fileName}",
                ]);
                    
                // Send emails
                $this->sendEmail($member->email, $r_payment_id,'member');
                $this->sendEmail($adminEmail, $r_payment_id,'admin');
                $this->sendWhatsappMessage($r_payment_id);
                DB::commit();
                return back()->with('success', 'Donation Payment Successfully Complete!');
            }


        }catch (\Exception $e){
            DB::rollBack();
            return back()->with('error', 'Warning : ' .$e->getMessage());
        }
    }

    private function sendEmail($email, $r_payment_id, $role)
    {
        try{
            $member = Auth::user();
            $payment_table = Payment::where('r_payment_id',$r_payment_id)->first();
            $invoice_no = $payment_table->invoice_no;
            $subject = 'Gaam Raam Trust Donation Invoice #'.$invoice_no.' | '.\Carbon\Carbon::today()->format('d-M-Y').' | '.\Carbon\Carbon::now()->format('h:i A');
            $isAdmin = ($role === 'admin');
            if (!$payment_table) {
                Log::channel('razorpay')->error('Payment record not found for R-Payment ID: ' . $r_payment_id);
                return;
            }
            $count = 0;
            $pdfPath = public_path($payment_table->donation_pdf); 
            Log::channel('razorpay')->info('Invoice PDF Path: ' . $pdfPath);
            Mail::to($email)->queue(
                (new SendDonationInvoiceMail($payment_table,$isAdmin,$count,$subject))
                    ->attach($pdfPath)
            );     
            Log::channel('razorpay')->info('Email Sent With PDF To ' . $email);

        }catch (\Exception $mailException) {
            Log::channel('razorpay')->error('Failed to send email to ' . $email . '. Error: ' . $mailException->getMessage());
        }
        
    }

    private function sendWhatsappMessage($r_payment_id)
    {
   
        $member = Auth::user();
        $payment_table = Payment::where('r_payment_id',$r_payment_id)->first();
        if (!$payment_table) {
            Log::channel('order')->warning("Payment not found for Razorpay ID: $r_payment_id");
            return;
        }
        $pdfPath = env('ASSET_URL') . '/' . ltrim($payment_table->donation_pdf, '/');
        Log::channel('order')->info('Invoice PDF Path: ' . $pdfPath);
        $MobileNo = $member->mobile;
        $message = "🙏 *Thank you for your donation, $member->name!*\n\n" .
                "💸 *Amount Paid:* ₹" . $payment_table->amount . "\n" .
                "🆔 *Razorpay Payment ID:* {$payment_table->r_payment_id}\n\n" .
                "📄 Your donation invoice is attached with this message.\n\n" .
                "❤️ We truly appreciate your support to *GaamRaam NGO*.\n" .
                "Together, we are making a difference! 🌍\n\n" .
                "Warm Regards,\n" .
                "*GaamRaam NGO Team*";
        if (!str_starts_with($MobileNo, '+91')) {
            $MobileNo = '+91' . $MobileNo;
        }
        try {
            $apiKey = BussinessSetting::find(14)->value;
            $response = Http::get('http://api.textmebot.com/send.php', [
                'recipient' => $MobileNo,
                'apikey'    => $apiKey,
                'text'      => $message,
                'document' => $pdfPath,
            ]);
            if ($response->successful()) {
                $body = strtolower($response->body());
                if (str_contains($body, 'error') || str_contains($body, 'failed')) {
                    Log::channel('order')->error('API responded but failed to send message : ' . $response->body());
                }
            } else {
                Log::channel('order')->error('API Error: ' . $response->status() . ' - ' . $response->body());
            }
        } catch (Exception $e) {
            Log::channel('order')->error('WhatsApp API Exception', ['error' => $e->getMessage()]);
        }        
    }

    

    public function qrInvoice($invoiceNumber)
    {
        // dd($invoiceNumber);
        $payment_table = Payment::where('invoice_no',$invoiceNumber)->first();
        if (!$payment_table) {
            return abort(404, 'Invoice not found');
        }
        return view('member.auth.payment.qr-invoice-detail', compact('payment_table'));
    }

    public function donationDetail(Request $req){
        $months = ["January", "February", "March", "April", "May", "June",
                  "July", "August", "September", "October", "November", "December"];
        $earnings = DB::table('payments')
                  ->select(DB::raw('SUM(amount) as total'), DB::raw('MONTH(created_at) as month'))
                  ->groupBy(DB::raw('MONTH(created_at)'))
                  ->pluck('total', 'month');
        return view('member.donation.index', compact('months','earnings'));
    }

    public function donationPDF($month)
    {
        $monthName = date('F', mktime(0, 0, 0, $month, 1));

        // Get donation summary per user for the given month
        $donations = DB::table('payments')
                    ->leftJoin('users', 'payments.user_id', '=', 'users.id')
                    ->select(
                        'users.name as user_name',
                        DB::raw('SUM(payments.amount) as total_donation')
                    )
                    ->whereMonth('payments.created_at', $month)
                    ->groupBy('payments.user_id', 'users.name')
                    ->get();
        $total = $donations->sum('total_donation');
        $data = [
            'month' => $monthName,
            'donations' => $donations,
            'total' => $total,
        ];
        $pdf = Pdf::loadView('pdf.admin.donation.month-wise-donation-view', $data);
        return $pdf->download("donation_report_{$monthName}.pdf");
    }

    public function filterDonationDetail(Request $request){
      $query = Payment::query();

      if ($request->filter_values == 'this_year') {
         $query->whereYear('created_at', date('Y'));

         $payments = $query
               ->selectRaw('MONTH(created_at) as month, SUM(amount) as total')
               ->groupBy('month')
               ->pluck('total', 'month');

         $monthlyData = array_fill(1, 12, 0); 
         foreach ($payments as $month => $total) {
               $monthlyData[$month - 1] = $total; 
         }

         return response()->json(['monthlyData' => array_values($monthlyData)]);
      }

      elseif ($request->filter_values == 'this_month') {
         $query->whereYear('created_at', date('Y'))
               ->whereMonth('created_at', date('m'));

         $payments = $query
               ->selectRaw('DAY(created_at) as day, SUM(amount) as total')
               ->groupBy('day')
               ->pluck('total', 'day');

         $daysInMonth = cal_days_in_month(CAL_GREGORIAN, date('m'), date('Y'));
         $dailyData = array_fill(1, $daysInMonth, 0);

         foreach ($payments as $day => $total) {
               $dailyData[$day - 1] = $total; 
         }

         return response()->json(['monthlyData' => array_values($dailyData)]);
      }

      elseif ($request->filter_values == 'this_week') {
         $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);

         $payments = $query
               ->selectRaw('DAYOFWEEK(created_at) as day, SUM(amount) as total')
               ->groupBy('day')
               ->pluck('total', 'day');

         $weeklyData = array_fill(1, 7, 0); 

         foreach ($payments as $day => $total) {
               $weeklyData[$day - 1] = $total; 
         }

         return response()->json(['monthlyData' => array_values($weeklyData)]);
      }

      // Filter by Today
      elseif ($request->filter_values == 'today') {
         $query->whereDate('created_at', today());

         $earnings = $query->sum('amount');

         return response()->json(['monthlyData' => [$earnings]]);
      }

      // Filter by Custom Date Range (Show Data by Date)
      elseif ($request->filter_values == 'custom' && $request->startDate && $request->endDate) {
         $query->whereBetween('created_at', [$request->startDate, $request->endDate]);

         $payments = $query
               ->selectRaw('DATE(created_at) as date, SUM(amount) as total')
               ->groupBy('date')
               ->pluck('total', 'date');

         // Generate all dates within the selected range
         $dateRange = [];
         $currentDate = strtotime($request->startDate);
         $endDate = strtotime($request->endDate);

         while ($currentDate <= $endDate) {
               $formattedDate = date('Y-m-d', $currentDate);
               $dateRange[$formattedDate] = 0; // Default value if no earnings found
               $currentDate = strtotime("+1 day", $currentDate);
         }

         foreach ($payments as $date => $total) {
               $dateRange[$date] = $total;
         }

         return response()->json(['monthlyData' => array_values($dateRange)]);
      }

      return response()->json(['monthlyData' => []]);
   }

   

}