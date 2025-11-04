<?php

namespace App\Http\Controllers\Admin\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Razorpay\Api\Api;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;
use Auth;
use Hash;
use Str;
use Mail;

use App\Models\Payment;
use App\Models\Subscription;
use App\Models\User;
use App\Models\Block;
use App\Models\BussinessSetting;
use App\Models\Referral;
use App\Models\MemberCreation;
use App\Models\TaskUpdate;

use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Illuminate\Support\Facades\File;
use Barryvdh\DomPDF\Facade\Pdf;


use App\Mail\MemberVerification;
use App\Mail\SendDonationInvoiceMail2;
use App\Mail\SendDonationInvoiceMail;

class RazorpayController extends Controller
{
    protected $razorpayKey;
    protected $razorpaySecret;
    protected $api;

    public function __construct()
    {
        $this->razorpayKey = config('services.razorpay.key');
        $this->razorpaySecret = config('services.razorpay.secret');
        $this->api = new Api($this->razorpayKey, $this->razorpaySecret);
    }

    public function memberSave(Request $req){
        try{
                // dd($req->all());              
                // $this->offlinePaymentModule($req);
                //  DB::beginTransaction();
               $admin = Auth::guard('admin')->user(); 
               $rules = [
                   'email' => [
                        'required',
                        'email',
                        'unique:users,email',
                        'regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z.-]+\.[a-zA-Z]{2,}$/'
                    ],
                    'password' => 'required',
                    'mobile' => 'required|digits:10|unique:users,mobile',
                    'password' => 'required',    
                    'blood_group' => 'required',
                    'attachments' => 'nullable|array',
                    'attachments.*' => 'file|mimes:jpg,jpeg,png',
                    'profile_image' => 'nullable|mimes:jpg,jpeg,png',
                ];         

                if ($req->mode == 1) {
                    $rules['plan'] = 'required';
                }
                if ($req->mode == 3) {
                    $rules['donate_amount'] = 'required';
                    $rules['transaction_attachment'] = 'required';
                }
                $validator = Validator::make($req->all(), $rules);
                if ($validator->fails()) {
                    return back()->withErrors($validator)->withInput();
                }

                $points = 0;
                if ($req->mode == 1) {
                    $points = ($req->plan == 1) ? 10 : 100;
                } elseif ($req->mode == 3 && is_numeric($req->donate_amount)) {
                    $points = $req->donate_amount * 0.10;
                }

                

                $profile_image = null;
                if($req->profile_image != null){
                    $file = $req->profile_image;
                    $filename = time(). '.' . $file->getClientOriginalExtension();
                    $year = now()->year;
                    $month = now()->format('M');
                    $folderPath = public_path("app/member-profile/{$year}/{$month}");
                    if (!file_exists($folderPath)) {
                        mkdir($folderPath, 0777, true);
                    }
                    $file->move($folderPath, $filename);
                    $profile_image = "app/member-profile/{$year}/{$month}/" . $filename;
                }

                $attachments = null;
                $images = [];
                if ($req->hasFile('attachments')) {
                    foreach ($req->file('attachments') as $file) {
                        $filename = time() . '-' . uniqid() . '.' . $file->getClientOriginalExtension();
                        $year = now()->year;
                        $month = now()->format('M');
                        $folderPath = public_path("app/member-profile/attachments/{$year}/{$month}");
                        if (!file_exists($folderPath)) {
                            mkdir($folderPath, 0777, true);
                        }
                        $file->move($folderPath, $filename);
                        $images[] = "app/member-profile/attachments/{$year}/{$month}/" . $filename;
                    }
                    $attachments = json_encode($images);
                }

                $member = new User([
                    'name' => $req->name,
                    'email' => $req->email,
                    'mobile' => $req->mobile,
                    'password' => Hash::make($req->password),
                    'city' => $req->city,
                    'block' => $req->block,
                    'status' => '1',
                    'member_type' => 1,
                    'passport' => null,
                    'country' => 101,
                    'points' => $points,
                    'blood_group' => $req->blood_group,
                    'profile_image' => $profile_image ?? null,
                    'attachments'   => $attachments ?? null,
                ]);
                $member->save();
                Log::channel('razorpay')->info('New Member Created:', $member->toArray());

                // Save referral points for new member
                Referral::create([
                    'referrer_id' => $member->id,  
                    'referred_id' => $member->id,
                    'points' => $points,
                    'type'   => 1,
                ]);    


                // Save referral points for gaamraam employee
                Referral::create([
                    'user_type' => 2, 
                    'referrer_id' => $admin->id,  
                    'referred_id' => $member->id,
                    'points' => $points,
                    'type'   => 3,
                ]); 

                $admin->points += $points;
                $admin->save();

                if ($req->mode == 3) {
                    $this->offlinePaymentModule($req, [
                        'member_id'    => $member->id,
                        'member_name'  => $member->name,
                        'member_email' => $member->email,
                        'member_mobile'=> $member->mobile
                    ]);
                }else{                 
                   return $this->createSubscription($req->all(), $member);
                }
                 
                $data = [
                    'name' => $req->name,
                    'email' => $req->email,
                ];
                $email = $req->email;                
                // DB::commit();                
           
        }catch (ValidationException $e) {
            // DB::rollBack();
            Log::channel('member')->error('Validation Error', [
                'errors' => $e->validator->errors()->toArray()
            ]);
            return back()->withErrors($e->validator)->withInput();
        }catch(\Exception $e){
            // DB::rollBack();
            Log::channel('member')->error('Failed : ' . $e->getMessage());
            return back()->with('error', 'Warning : ' .$e->getMessage());   
        }
        try {
            Mail::to($email)->queue(new MemberVerification($data));
            Log::channel('member')->info('Success to send email to ' . $email);
        } catch (\Exception $mailException) {
            Log::channel('member')->error('Failed to send email to ' . $email . '. Error: ' . $mailException->getMessage());
        }
        return back()->with('success','Member Registration Successfully! Please check your email for verification.');
    }

    public function offlinePaymentModule($req,  $memberData = []){
        // dd($req->all());
        try {
                Log::channel('member')->info('Starting offlinePaymentModule', ['req' => $req->all()]);
                $data = array_merge($req->all(), $memberData);
                $invoiceNumber = now()->format('Ym') . rand(100000, 999999);
                Log::channel('member')->info('Generated invoice number', ['invoiceNumber' => $invoiceNumber]);
                $insertData = [
                    'mode' => 3,
                    'invoice_no' => $invoiceNumber,
                    'user_id'  => $data['member_id'],
                    'user_name'   => $data['member_name'],
                    'user_mobile'    => $data['member_mobile'],
                    'user_email'   => $data['member_email'],
                    'amount'       => $req->donate_amount,
                ];
                Log::channel('member')->info('Insert data prepared', ['insertData' => $insertData]);
                if($req->transaction_attachment != null){
                    $file = $req->transaction_attachment;
                    $filename = time(). '.' . $file->getClientOriginalExtension();
                    $year = now()->year;
                    $month = now()->format('M');
                    $folderPath = public_path("app/member-donation/attachment/{$year}/{$month}");
                    if (!file_exists($folderPath)) {
                        mkdir($folderPath, 0777, true);
                    }
                    $file->move($folderPath, $filename);
                    $insertData['attachment'] = "app/member-donation/attachment/{$year}/{$month}/" . $filename;
                    Log::channel('member')->info('File uploaded successfully', ['filePath' => $insertData['attachment']]);
                }

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
                $qrCodeDirectory = public_path("app/member-donation/qr-codes/{$year}/{$month}");
                if (!File::exists($qrCodeDirectory)) {
                    File::makeDirectory($qrCodeDirectory, 0777, true);
                }
                $qrCodeFilePath = "{$qrCodeDirectory}/{$invoiceNumber}-qr.jpg";
                file_put_contents($qrCodeFilePath, $qrCodeContent);
                $qrScannerPath = "app/member-donation/qr-codes/{$year}/{$month}/{$invoiceNumber}-qr.jpg";
                Log::channel('member')->info('Qr Code Second Path', ['path' => $qrScannerPath]);

                 // Generate the PDF
                $filePath = "{$directoryPath}/{$fileName}";
                $pdf = Pdf::loadView('pdf.member.offline-donation-invoice', compact('insertData','adminEmail','invoiceNumber', 'today', 'qrScannerPath'));
                $pdf->save($filePath);
                $insertData = array_merge($insertData, [
                    'qr_image' => "app/member-donation/qr-codes/{$year}/{$month}/{$invoiceNumber}-qr.jpg",
                    'donation_pdf' => "app/member-donation/{$year}/{$month}/{$fileName}",
                    'invoice_no' => $invoiceNumber,
                ]);
                $payment = Payment::create($insertData);
                 DB::table('member_creations')->insert([
                    'employee_id' => Auth::guard('admin')->user()->id, 
                    'user_id' => $data['member_id'],
                    'created_at' => now(),
                ]);
                Log::channel('member')->info('Payment data inserted successfully', ['data' => $insertData]);
                Log::channel('member')->info('Payment Created:', $payment->toArray());
                $email = $data['member_email'];
                $this->sendEmailforOfflinePayment($email, $invoiceNumber,'member');
                $this->sendEmailforOfflinePayment($adminEmail, $invoiceNumber,'admin');                  
            } catch (\Exception $e) {
                Log::channel('member')->error('Error in offlinePaymentModule', [
                    'message' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
            }     

    }

     private function sendEmailforOfflinePayment($email, $invoiceNumber, $role)
    {
        try{
            $payment_table = Payment::where('invoice_no',$invoiceNumber)->first();
            $invoice_no = $payment_table->invoice_no;
            $subject = 'Gaam Raam Trust Donation Invoice #'.$invoice_no.' | '.\Carbon\Carbon::today()->format('d-M-Y').' | '.\Carbon\Carbon::now()->format('h:i A');
            $isAdmin = ($role === 'admin');
            if (!$payment_table) {
                Log::channel('member')->error('Payment record not found for Invoice No ID: ' . $invoice_no);
                return;
            }
            $count = 0;
            $pdfPath = public_path($payment_table->donation_pdf);           
            $adminEmail = BussinessSetting::where('type','email')->value('value');
            Log::channel('member')->info('Invoice PDF Path: ' . $pdfPath);     
             Log::channel('member')->info('Invoice subject : ' . $subject);         
            $mail = (new SendDonationInvoiceMail($payment_table, $isAdmin, $count, $subject))
                    ->attach($pdfPath);
            if (!empty($payment_table->attachment)) {
                $attachmentPath = public_path($payment_table->attachment);
                if (File::exists($attachmentPath)) {
                    $mail->attach($attachmentPath);
                    Log::channel('member')->info('Invoice attachment Path: ' . $attachmentPath);
                } else {
                    Log::channel('member')->warning('Attachment file not found at: ' . $attachmentPath);
                }
            }
            Mail::to($email)->cc($adminEmail)->queue($mail);
            Log::channel('member')->info('Email Sent With PDF To ' . $email);

        }catch (\Exception $mailException) {
            Log::channel('razorpay')->error('Failed to send email to ' . $email . '. Error: ' . $mailException->getMessage());
        }

    }

    public function createSubscription(array $InvoiceData,  User $member){
        // dd($InvoiceData);
        // DB::beginTransaction();
        try{
            $admin = Auth::guard('admin')->user(); 
            Log::channel('razorpay')->info('InvoiceData : ' . json_encode($InvoiceData));        
            $api = new Api($this->razorpayKey, $this->razorpaySecret);
            $email = $InvoiceData['email'];
            $contact = $InvoiceData['mobile'];
            $planType = $InvoiceData['plan']; // 1 for monthly, 2 for yearly
            $userName = $InvoiceData['name'] ?? 'Customer';
            $userId = $member->id;

            // Check plan details
            if ($planType == 1) {
                $planName = "Monthly Subscription Plan";
                $interval = "monthly";
                $amount = 100 * 100;
            } elseif ($planType == 2) {
                $planName = "Yearly Subscription Plan";
                $interval = "yearly";
                $amount = 1100 * 100;
            } else {
                return back()->with('error', 'Invalid plan selected.');
            }

            // Create or find customer
            $user = User::where('email', $email)->first();
            if ($user && $user->razorpay_customer_id) {
                $customer_id = $user->razorpay_customer_id;
            } else {
                try {
                    $customer = $api->customer->create([
                        'name'    => $userName,
                        'email'   => $email,
                        'contact' => $contact,
                    ]);
                } catch (\Exception $e) {
                    Log::channel('razorpay')->warning("Customer creation failed, trying to fetch existing: " . $e->getMessage());
                    $existingCustomers = $api->customer->all(['email' => $email]);
                    if (!empty($existingCustomers['items'])) {
                        $customer = $existingCustomers['items'][0]; 
                    }
                }
                if ($user) {
                    $user->razorpay_customer_id = $customer->id;
                    $user->save();
                }
                $customer_id = $customer->id;
            }

            // Create plan
            $plan = $api->plan->create([
                'period' => $interval,
                'interval' => 1,
                'item' => [
                    'name' => $planName,
                    'amount' => $amount,
                    'currency' => 'INR',
                ]
            ]);

            // Create subscription
            $subscription = $api->subscription->create([
                'plan_id' => $plan->id,
                'customer_id' => $customer_id,
                'customer_notify' => 1,
                'total_count' => ($interval == 'yearly') ? 1 : 12,
                'notes' => [
                    'userId' => $userId,
                    'userName' => $userName,
                    'plan_name' => $planName,
                    'plan_id' => $plan->id,
                    'interval' => $interval
                ]
            ]);

            $invoices = $api->invoice->all(['subscription_id' => $subscription->id]);
            if (!empty($invoices['items'])) {
                $firstInvoice = $invoices['items'][0];
                $subscriptionLink = $firstInvoice->short_url;
                Log::channel('razorpay')->info("invoices Details", ['invoices' => $invoices]);
                Log::channel('razorpay')->info("Hosted subscription link", ['link' => $subscriptionLink]);
            }

            Log::channel('razorpay')->info("Subscription saved", [
                'plan_id' => $plan->id,
                'subscription_id' => $subscription->id,
                'user_id' => $userId,
                'userName' => $userName,
                'email' => $email,
                'subscription_link' => $subscriptionLink,
            ]);

            // Return view with Razorpay Checkout data
            return view('admin.member.razorpay.checkout', [
                'subscription_id' => $subscription->id,
                'plan_name' => $planName,
                'plan_id' => $plan->id,
                'amount' => $amount,
                'interval' => $interval,
                'email' => $email,
                'contact' => $contact,
                'userName' => $userName,
                'userId'   => $userId,
                'admin_id_employee_id'   => $admin->id,
            ]);
        }catch (\Exception $e){
            // DB::rollBack();            
            Log::channel('razorpay')->error('Warning In createSubscription Function : ' . $e->getMessage());
            return back()->with('error', $e->getMessage());

        }
    }

    public function handleSuccess(Request $request){
        // dd($request->all());
          DB::beginTransaction();
        Log::channel('razorpay')->info('handleSuccess Request Data::', $request->all());
        $data = $request->all();
        $api = new \Razorpay\Api\Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
        try {
            // Fetch invoice using subscription_id
            $invoices = $api->invoice->all(['subscription_id' => $data['subscription_id']]);
            $subscriptionLink = null;

            if (!empty($invoices['items'])) {
                $subscriptionLink = $invoices['items'][0]->short_url ?? null;
            }
            $payment = $api->payment->fetch($data['razorpay_payment_id']);
            Log::channel('razorpay')->info('Fetched Razorpay Payment:', $payment->toArray());
            Log::channel('razorpay')->info('Insert Payment Debug:', [
                'r_payment_id' => $data['razorpay_payment_id'],
                'r_order_id' => $payment['order_id'],
                'method' => $payment['method'],
                'currency' => $payment['currency'],
            ]);

            Subscription::create([
                'razorpay_payment_id' => $data['razorpay_payment_id'],
                'plan_name'        => $data['plan_name'],
                'plan_id'          => $data['plan_id'],
                'subscription_id'  => $data['subscription_id'],
                'plan_amount'      => $data['plan_amount'] / 100,
                'interval'         => $data['interval'],
                'customer_email'   => $data['email'],
                'customer_contact' => $data['contact'],
                'subscription_link'=> $subscriptionLink,               
            ]);
            Payment::create([
                'mode'                 => 5,
                'r_payment_id'        => $data['razorpay_payment_id'],
                'r_order_id'          => $payment['order_id'],
                'method'              => $payment['method'],
                'currency'           => $payment['currency'],
                'merchant_order_id'   => rand(11111, 99999) . time(),
                'user_id'              => $data['userId'] ?? null,
                'user_name'           => $data['userName'] ?? null,
                'user_mobile'         => $data['contact'],
                'user_email'         => $data['email'],
                'amount'             => $data['plan_amount'] / 100,
                'json_response'       => json_encode($payment->toArray()),
            ]);         
            DB::table('member_creations')->insert([
                'employee_id' => Auth::guard('admin')->user()->id, 
                'user_id' => $data['userId'],
                'created_at' => now(),
            ]);
             DB::commit();
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
             DB::rollBack();
            Log::channel('razorpay')->error('Razorpay handleSuccess error: ' . $e->getMessage());
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }

    public function success(Request $request){
        $paymentId = $request->query('payment_id');
        $subscription = Subscription::where('razorpay_payment_id', $paymentId)->first();
        if (!$subscription) {
            return redirect('/')->with('error', 'Payment record not found.');
        }
        session()->flash('success', '🎉 Payment successfully completed!');
        $payment_table = Payment::where('r_payment_id',$paymentId)->first();
        // dd($payment_table);
        if(!$payment_table){
            Log::channel('razorpay')->error("Payment record not found for r_payment_id: " . $paymentId);
            return back()->with('error','Record Not Found!');
        }
        $invoiceNumber = now()->format('Ym') . rand(100000, 999999);
        Log::channel('razorpay')->info("Generating invoice", ['invoice_number' => $invoiceNumber]);
        $qrCodeFilePath = $this->generateQRCode($invoiceNumber);
        $payment_table->update([
            'qr_image' => $qrCodeFilePath,
            'invoice_no' => $invoiceNumber,
        ]);

        $invoicePdfPath = $this->generateInvoicePdf($invoiceNumber, $payment_table,$qrCodeFilePath);
        $payment_table->update([
            'donation_pdf' => $invoicePdfPath,
        ]);

        // Send emails
        $this->sendEmail($paymentId);
        $this->sendWhatsappMessage($paymentId);
        return view('admin.member.razorpay.thank-you', compact('subscription'));
    }

    private function generateQRCode($invoiceNumber){
        $year = now()->year;
        $month = now()->format('M');
        $qrCodeDirectory = public_path("app/member-donation/qr-codes/{$year}/{$month}");
        Log::channel('razorpay')->info("Generating QR code for invoice", ['invoice_no' => $invoiceNumber]);
        if (!File::exists($qrCodeDirectory)) {
            File::makeDirectory($qrCodeDirectory, 0777, true);
        }
        try {
            $qrCode = new QrCode(route('member-invoice', ['invoiceNumber' => $invoiceNumber]));
            $writer = new PngWriter();
            $qrCodeContent = $writer->write($qrCode)->getString();
            $qrCodeFilePath = "{$qrCodeDirectory}/{$invoiceNumber}-qr.jpg";
            file_put_contents($qrCodeFilePath, $qrCodeContent);
            Log::channel('razorpay')->info("QR code generated successfully", ['file_path' => $qrCodeFilePath]);
            return "app/member-donation/qr-codes/{$year}/{$month}/{$invoiceNumber}-qr.jpg";
        } catch (\Exception $e) {
            Log::channel('razorpay')->error("QR code generation failed", ['error' => $e->getMessage()]);
            return null;
        }
    }

    private function generateInvoicePdf($invoiceNumber, $payment_table, $qrCodeFilePath){
        $year = now()->year;
        $month = now()->format('M');
        $today = Carbon::now()->format('d-M-Y');
        $fileName = "invoice_{$invoiceNumber}.pdf";
        $directoryPath = public_path("app/member-donation/{$year}/{$month}");
        $adminEmail = BussinessSetting::where('type', 'email')->value('value');
        Log::channel('razorpay')->info("Generating invoice PDF", ['invoiceNumber' => $invoiceNumber]);
        if (!File::exists($directoryPath)) {
            File::makeDirectory($directoryPath, 0777, true);
        }
        try {
            $filePath = "{$directoryPath}/{$fileName}";
            $count = 0;
            $pdf = Pdf::loadView('pdf.member.donation-invoice', compact('payment_table', 'adminEmail', 'today', 'qrCodeFilePath','count'));
            $pdf->save($filePath);
            Log::channel('razorpay')->info("Invoice PDF generated successfully", ['file_path' => $filePath]);
            return "app/member-donation/{$year}/{$month}/{$fileName}";
        } catch (\Exception $e) {
            Log::channel('razorpay')->error("Invoice PDF generation failed", ['error' => $e->getMessage()]);
            return null;
        }
    }

    private function sendEmail($r_payment_id)
    {
        try{

            $payment_table = Payment::where('r_payment_id',$r_payment_id)->first();
            $invoice_no = $payment_table->invoice_no;
            $subject = 'Gaam Raam Trust Donation Invoice #'.$invoice_no.' | '.\Carbon\Carbon::today()->format('d-M-Y').' | '.\Carbon\Carbon::now()->format('h:i A');
            $adminEmail =  BussinessSetting::where('type','email')->value('value');
            $email =  $payment_table->user_email ?? $adminEmail;
            if (!$payment_table) {
                Log::channel('razorpay')->error('Payment record not found for R-Payment ID: ' . $r_payment_id);
                return;
            }
            $pdfPath = public_path($payment_table->donation_pdf);
            Log::channel('razorpay')->info('Invoice PDF Path: ' . $pdfPath);
            Mail::to($email)->cc($adminEmail)->queue(
                (new SendDonationInvoiceMail2($payment_table,$subject))
                    ->attach($pdfPath)
            );
            Log::channel('razorpay')->info('Email Sent With PDF To ' . $email);

        }catch (\Exception $mailException) {
            Log::channel('razorpay')->error('Failed to send email to ' . $email . '. Error: ' . $mailException->getMessage());
        }

    }

    private function sendWhatsappMessage($r_payment_id)
    {

        $payment_table = Payment::where('r_payment_id',$r_payment_id)->first();
        if (!$payment_table) {
            Log::channel('razorpay')->warning("Payment not found for Razorpay ID: $r_payment_id");
            return;
        }
        $name = $payment_table->user_name ?? 'Unknown Donor';
        $pdfPath = env('ASSET_URL') . '/' . ltrim($payment_table->donation_pdf, '/');
        Log::channel('razorpay')->info('Invoice PDF Path: ' . $pdfPath);
        $MobileNo = $payment_table->user_mobile ?? '0000000000';
        $message = "🙏 *Thank you for your donation, $name!*\n\n" .
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
                    Log::channel('razorpay')->error('API responded but failed to send message : ' . $response->body());
                }
            } else {
                Log::channel('razorpay')->error('API Error: ' . $response->status() . ' - ' . $response->body());
            }
        } catch (Exception $e) {
            Log::channel('razorpay')->error('WhatsApp API Exception', ['error' => $e->getMessage()]);
        }
    }


   
}
