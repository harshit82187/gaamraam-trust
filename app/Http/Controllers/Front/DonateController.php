<?php

namespace App\Http\Controllers\Front;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Auth;

use App\Models\User;
use App\Models\Payment;

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

class DonateController extends Controller
{
    public function razorpayIntitialPayment(Request $request){
        Log::channel('order')->info('Razorpay initiatePayment hit on donate now page.', [
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
            Log::channel('order')->info('Razorpay order created successfully on donate now page.', [
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
            Log::channel('order')->error('Razorpay order creation failed on donate now page.', ['error' => $e->getMessage()]);
            return response()->json([
                'status' => false,
                'message' => 'Unable to initiate Razorpay payment. Try again later.'
            ], 500);
        }
    } 

    public function proceedPayment($request)
    {
        try {
            Log::channel('order')->info('Razorpay Payment Success Request on donate now page', $request);

            $razorpayPaymentId = $request['razorpay_payment_id'] ?? null;
            $merchant_order_id = $request['merchant_order_id'] ?? null;
            $name = $request['name'] ?? 'Unknown Donor';
            $email = $request['email'] ?? 'unknowndonoremail@gmail.com';
            $mobile_no = $request['mobile_no'] ?? '0000000000';

            if (!$razorpayPaymentId || !$merchant_order_id) {
                Log::channel('order')->error('Missing payment ID or merchant order ID.', $request);
                return false;
            }

            $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
            $payment = $api->payment->fetch($razorpayPaymentId);

            if (!$payment || !isset($payment['id'])) {
                Log::channel('order')->error('Invalid Razorpay payment object.', ['response' => $payment]);
                return false;
            }

            $createdPayment = Payment::create([
                'mode' => '2',
                'r_payment_id' => $payment['id'],
                'r_order_id' => $payment['order_id'] ?? '',
                'merchant_order_id' => $merchant_order_id,
                'method' => $payment['method'] ?? 'unknown',
                'currency' => $payment['currency'] ?? 'INR',
                'user_id' => null,
                'user_email' => $email,
                'user_name' => $name,
                'user_mobile' => $mobile_no,
                'amount' => $payment['amount'] / 100,
                'json_response' => json_encode($payment->toArray()),
            ]);
            Log::channel('order')->info('✅ Payment record created successfully', [
                'id' => $createdPayment->id,
                'razorpay_id' => $createdPayment->r_payment_id,
                'amount' => $createdPayment->amount,
                'email' => $createdPayment->user_email,
                'mobile' => $createdPayment->user_mobile,
                'name' => $createdPayment->user_name,
                'order_id' => $createdPayment->r_order_id,
            ]);

            return $createdPayment;

        } catch (\Exception $e) {
            Log::channel('order')->error('Razorpay payment processing failed.', ['error' => $e->getMessage()]);
            return false;
        }
    }




    public function donateNowAmount(Request $request)
    {
        DB::beginTransaction();
        try {
            $mode = $request->input('mode');
            // Validation common to both modes
            $request->validate([
                'amount' => 'required|numeric',
                'mobile_no' => 'required|string',
                'merchant_order_id' => 'required|string',
                'mode' => 'required|in:1,2',
            ]);
            // Additional validation for Razorpay mode
            if ($mode == 1) {
                $request->validate([
                    'razorpay_payment_id' => 'required|string',
                    'razorpay_order_id' => 'required|string',
                    'transaction_via' => 'required|string',
                ]);
            }
            // Common Payment Data
            $paymentData = [
                'razorpay_payment_id' => $request->razorpay_payment_id,
                'merchant_order_id' => $request->merchant_order_id,
                'amount' => $request->amount,
                'name' => $request->name,
                'email' => $request->email,
                'mobile_no' => $request->mobile_no,
            ];

            if ($mode == 1) {
                $payment = $this->proceedPayment($paymentData);
                if (!$payment) {
                    throw new \Exception("Payment failed!");
                }
                $r_payment_id = $request->razorpay_payment_id;
                $payment_table = Payment::where('r_payment_id', $r_payment_id)->first();
            } else {
                // 👉 Offline Mode logic
                if($request->transaction_attachment != null){
                    $file = $request->transaction_attachment;
                    $filename = time(). '.' . $file->getClientOriginalExtension();
                    $year = now()->year;
                    $month = now()->format('M');
                    $folderPath = public_path("app/member-donation/attachment/{$year}/{$month}");
                    if (!file_exists($folderPath)) {
                        mkdir($folderPath, 0777, true);
                    }
                    $file->move($folderPath, $filename);
                    $attachment = "app/member-donation/attachment/{$year}/{$month}/" . $filename;
                    Log::channel('razorpay')->info('File uploaded successfully', ['filePath' => $attachment]);
                }
                $payment_table = Payment::create([
                    'r_payment_id' => null,
                    'merchant_order_id' => $request->merchant_order_id,
                    'amount' => $request->amount,
                    'user_id' => null,
                    'user_name' => $request->name ?? 'Unknown Donor',
                    'user_email' => $request->email ?? 'unknowndonoremail@gmail.com',
                    'user_mobile' => $request->mobile_no,
                    'mode' => 6, // Offline mode
                    'attachment' => $attachment,
                ]);
                $r_payment_id = $payment_table->id;
            }

            if (!$payment_table) {
                Log::channel('razorpay')->error("Payment record not found for r_payment_id: " . $r_payment_id);
                return back()->with('error', 'Record Not Found!');
            }

            // 🔄 Common Invoice, QR, Email, WhatsApp Logic
            $invoiceNumber = now()->format('Ym') . rand(100000, 999999);
            $year = now()->year;
            $month = now()->format('M');
            $today = Carbon::now()->format('d-M-Y');
            $fileName = "invoice_{$invoiceNumber}.pdf";
            $directoryPath = public_path("app/website-member-donation/{$year}/{$month}");
            $adminEmail = BussinessSetting::where('type', 'email')->value('value');

            if (!File::exists($directoryPath)) {
                File::makeDirectory($directoryPath, 0777, true);
            }

            // Generate QR code
            $qrCode = new QrCode(route('doner-receipt-detail', ['invoiceNumber' => $invoiceNumber]));
            $writer = new PngWriter();
            $qrCodeContent = $writer->write($qrCode)->getString();

            $qrCodeDirectory = public_path("app/website-member-donation/qr-codes/{$year}/{$month}");
            if (!File::exists($qrCodeDirectory)) {
                File::makeDirectory($qrCodeDirectory, 0777, true);
            }

            $qrCodeFilePath = "{$qrCodeDirectory}/{$invoiceNumber}-qr.jpg";
            file_put_contents($qrCodeFilePath, $qrCodeContent);

            $payment_table->update([
                'qr_image' => "app/website-member-donation/qr-codes/{$year}/{$month}/{$invoiceNumber}-qr.jpg",
                'invoice_no' => $invoiceNumber,
            ]);

            // Generate PDF
            $count = 1;
            $filePath = "{$directoryPath}/{$fileName}";
            $pdf = Pdf::loadView('pdf.member.donation-invoice', compact('payment_table', 'adminEmail', 'today', 'qrCodeFilePath', 'count', 'invoiceNumber'));
            $pdf->save($filePath);

            $payment_table->update([
                'donation_pdf' => "app/website-member-donation/{$year}/{$month}/{$fileName}",
            ]);

            // Send Email and WhatsApp
            if ($mode == 1) {
                $payment = Payment::where('r_payment_id', $r_payment_id)->firstOrFail();
            } elseif ($mode == 2) {
                $payment = Payment::findOrFail($r_payment_id);
            } else {
                abort(404, 'Invalid payment mode');
            }
            $this->sendEmail($request->email, $payment, 'member');
            $this->sendEmail($adminEmail, $payment, 'admin');
            $this->sendWhatsappMessage($payment);

            DB::commit();
            return back()->with('success', 'Payment successful! The receipt has been sent to your email address.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::channel('razorpay')->error('❌ Exception in donateNowAmount', [
                'error_message' => $e->getMessage(),
                'stack_trace' => $e->getTraceAsString(),
                'request_data' => $request->all()
            ]);
            return back()->with('error', 'Warning : ' . $e->getMessage());
        }
    }


    private function sendEmail($email, Payment $payment_table, $role)
    {
        try {
            $invoice_no = $payment_table->invoice_no;
            $subject = 'Gaam Raam Trust Donation Invoice #' . $invoice_no . ' | ' . now()->format('d-M-Y h:i A');
            $isAdmin = ($role === 'admin');
            $count = 1;
            $pdfPath = public_path($payment_table->donation_pdf);
            Log::channel('razorpay')->info('Invoice PDF Path: ' . $pdfPath);
            $mail = (new SendDonationInvoiceMail($payment_table, $isAdmin, $subject, $count))
                ->attach($pdfPath);
            if (!empty($payment_table->attachment)) {
                $attachmentPath = public_path($payment_table->attachment);
                if (file_exists($attachmentPath)) {
                    $mail->attach($attachmentPath);
                    Log::channel('razorpay')->info('Additional attachment added: ' . $attachmentPath);
                } else {
                    Log::channel('razorpay')->warning('Attachment file not found: ' . $attachmentPath);
                }
            }
            Mail::to($email)->queue($mail);
            Log::channel('razorpay')->info('Email Sent With PDF To ' . $email);
        } catch (\Exception $mailException) {
            Log::channel('razorpay')->error('Failed to send email to ' . $email . '. Error: ' . $mailException->getMessage());
        }
    }



    private function sendWhatsappMessage(Payment $payment_table)
    {
        $name = $payment_table->user_name ?? 'Unknown Donor';
        $pdfPath = env('ASSET_URL') . '/' . ltrim($payment_table->donation_pdf, '/');
        $attachmentPath = $payment_table->attachment ? env('ASSET_URL') . '/' . ltrim($payment_table->attachment, '/') : null;
        $MobileNo = $payment_table->user_mobile ?? '0000000000';

        $message = "🙏 *Thank you for your donation, $name!*\n\n" .
            "💸 *Amount Paid:* ₹" . $payment_table->amount . "\n" .
            ($payment_table->r_payment_id ? "🆔 *Razorpay Payment ID:* {$payment_table->r_payment_id}\n\n" : "") .
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
            Log::channel('whatsapp')->info('Sending WhatsApp Invoice PDF', ['pdfPath' => $pdfPath]);
            if ($attachmentPath) {
                Log::channel('whatsapp')->info('Additional attachment found for WhatsApp', ['attachmentPath' => $attachmentPath]);
            }
            $response = Http::get('http://api.textmebot.com/send.php', [
                'recipient' => $MobileNo,
                'apikey' => $apiKey,
                'text' => $message,
                'document' => $pdfPath,
            ]);

            if ($response->successful()) {
                $body = strtolower($response->body());
                if (str_contains($body, 'error') || str_contains($body, 'failed')) {
                    Log::channel('whatsapp')->error('Invoice API responded but failed: ' . $response->body());
                }
            } else {
                Log::channel('whatsapp')->error('Invoice API Error: ' . $response->status() . ' - ' . $response->body());
            }
            Log::channel('whatsapp')->info('Waiting 8 seconds before sending attachment...');
            sleep(8);
            if ($attachmentPath != null) {
                $extension = strtolower(pathinfo($attachmentPath, PATHINFO_EXTENSION));
                $mediaKey = in_array($extension, ['jpg', 'jpeg', 'png']) ? 'file' : 'document';
                $response2 = Http::get('http://api.textmebot.com/send.php', [
                    'recipient' => $MobileNo,
                    'apikey' => $apiKey,
                    'text' => "📎 Additional attachment for your donation.",
                    $mediaKey => $attachmentPath,
                ]);

                if ($response2->successful()) {
                    $body = strtolower($response2->body());
                    if (str_contains($body, 'error') || str_contains($body, 'failed')) {
                        Log::channel('whatsapp')->error('Attachment API responded but failed: ' . $response2->body());
                    }
                } else {
                    Log::channel('whatsapp')->error('Attachment API Error: ' . $response2->status() . ' - ' . $response2->body());
                }
            }
        } catch (Exception $e) {
            Log::channel('whatsapp')->error('WhatsApp API Exception', ['error' => $e->getMessage()]);
        }
    }



    

    public function donerReceiptDetail($invoiceNumber)
    {
        // dd($invoiceNumber);
        $payment_table = Payment::where('invoice_no',$invoiceNumber)->first();
        if (!$payment_table) {
            return abort(404, 'Invoice not found');
        }
        return view('member.auth.payment.qr-invoice-detail', compact('payment_table'));
    }
   

}