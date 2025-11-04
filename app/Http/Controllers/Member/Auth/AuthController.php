<?php

namespace App\Http\Controllers\Member\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Auth;

use App\Models\User;
use App\Models\Payment;
use App\Models\Block;
use App\Models\BussinessSetting;
use App\Models\Referral;
use App\Models\Task;
use App\Models\TaskUpdate;
use App\Models\Subscription;
use App\Models\Admin;

use App\Mail\MemberVerification;
use App\Mail\SendDonationInvoiceMail;


use Hash;
use Str;
use Mail;
use DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Illuminate\Support\Facades\File;
use Barryvdh\DomPDF\Facade\Pdf;
use Razorpay\Api\Api;

class AuthController extends Controller
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
  

    public function memberRegister(Request $req){
        try{
            if($req->isMethod('get')){
                // dd(121);
                // dd(session()->all());
                if ($req->has('showLogin')) {
                    return redirect()->route('member-register')->with('showLogin', true);
                }
                return view('member.auth.register');

            }else{
                // dd($req->all());
                $secretKey = "6LcdiiIrAAAAAPt3btL1JKybe8cNEuDtExyobWPG"; 
                $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
                    'secret' => $secretKey,
                    'response' => $req->input('g-recaptcha-response'),
                    'remoteip' => $req->ip(),
                ]);
            
                $responseData = $response->json();
            
                if (!$responseData['success']) {
                    session()->flash('error', 'reCAPTCHA verification failed. Please try again.');
                    return back()->withErrors(['captcha' => 'reCAPTCHA verification failed. Please try again.']);
                }
                
                // $this->offlinePaymentModule($req);
                $validator = Validator::make($req->all(), [
                   'email' => [
                        'required',
                        'email',
                        'unique:users,email',
                        'regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z.-]+\.[a-zA-Z]{2,}$/'
                    ],
                    'password' => 'required',
                    'mobile' => 'required|digits:10',
                    'blood_group' => 'required|in:A+,A-,B+,B-,AB+,AB-,O+,O-',
                    'attachments' => 'nullable|array',
                    'attachments.*' => 'file|mimes:jpg,jpeg,png',
                    'profile_image' => 'nullable|mimes:jpg,jpeg,png',
                ]);

                if($req->member_type == 2){
                    $validator = Validator::make($req->all(), [
                        'passport' => 'required',
                        'country' => 'required',
                     ]);
                }

                if($req->mode == 1){
                    $validator = Validator::make($req->all(), [
                        'currency' => 'required|in:INR,USD',
                         'plan' => 'required',
                     ]);
                }

                if($req->mode == 3){
                    $validator = Validator::make($req->all(), [
                        'donate_amount' => 'required|numeric|min:1',    
                        'attachment' => 'required|mimes:jpg,jpeg,png',
                     ]);
                }

                if ($validator->fails()) {
                    return back()->withErrors($validator)->withInput();
                }            
                Log::channel('member')->info('Request Data:', $req->all());

                $points = 0;
                if ($req->mode == 1) {
                    $points = ($req->plan == 1) ? 10 : 100;
                } elseif ($req->mode == 3 && is_numeric($req->donate_amount)) {
                    $points = $req->donate_amount * 0.10;
                }
                Log::channel('member')->info('Member Name is: ' . $req->name . ' and points is: ' . $points);

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
                    'status' => '1',
                    'member_type' => $req->member_type,
                    'passport' => $req->passport ?? null,
                    'country' => $req->country ?? null,
                    'points' => $points,
                    'blood_group' => $req->blood_group,
                    'profile_image' => $profile_image,
                    'attachments'   => $attachments ?? null,
                    'referral_code'   => $req->referral_code ?? null,
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
                if($req->referral_code != null){
                    $admin = Admin::where('referral_code', $req->referral_code)->first();
                    Referral::create([
                        'user_type' => 2, 
                        'referrer_id' => $admin->id,  
                        'referred_id' => $member->id,
                        'points' => $points,
                        'type'   => 3,
                    ]);
                    $admin->points += $points;
                    $admin->save();
                    DB::table('member_creations')->insert([
                        'employee_id' => $admin->id,   
                        'user_id' => $member->id,
                        'created_at' => now(),
                    ]);
                }
                     

                 // **Check Payment Mode**
                if ($req->mode == 3) {
                    $this->offlinePaymentModule($req, [
                        'member_id'    => $member->id,
                        'member_name'  => $member->name,
                        'member_email' => $member->email,
                        'member_mobile'=> $member->mobile
                    ]);
                }else{                 
                   return $this->sendInvoice($req->all(), $member);
                }

                $data = [
                    'name' => $req->name,
                    'email' => $req->email,
                ];
                $email = $req->email;
                try {
                    Mail::to($email)->queue(new MemberVerification($data));
                    Log::channel('member')->info('Success to send email to ' . $email);
                } catch (\Exception $mailException) {
                    Log::channel('member')->error('Failed to send email to ' . $email . '. Error: ' . $mailException->getMessage());
                }
                return redirect()->route('member-register')->with('success','Registration Successfully! Please check your email for verification.');
            }
        }catch (ValidationException $e) {
            return back()->withErrors($e->validator)->withInput();
        }catch(\Exception $e){
            return back()->with('error', 'Warning : ' .$e->getMessage());
            Log::channel('member')->error('Failed : ' . $e->getMessage());

        }
    }

    public function offlinePaymentModule($req,  $memberData = []){
        // dd($req->all());
        try {
                Log::channel('member')->info('Starting offlinePaymentModule', ['req' => $req->all()]);
                DB::beginTransaction();
                $data = array_merge($req->all(), $memberData);
                $invoiceNumber = now()->format('Ym') . rand(100000, 999999);
                Log::channel('member')->info('Generated invoice number', ['invoiceNumber' => $invoiceNumber]);
                $insertData = [
                    'mode' => '3',
                    'invoice_no' => $invoiceNumber,
                    'user_id'  => $data['member_id'],
                    'user_name'   => $data['member_name'],
                    'user_mobile'    => $data['member_mobile'],
                    'user_email'   => $data['member_email'],
                    'amount'       => $req->donate_amount,
                    'currency'     => $req->currency,
                ];
                Log::channel('member')->info('Insert data prepared', ['insertData' => $insertData]);
                if($req->attachment != null){
                    $file = $req->attachment;
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
                $qrCodeFilePath = "{$qrCodeDirectory}/{$invoiceNumber}-qr.jpg";
                file_put_contents($qrCodeFilePath, $qrCodeContent);
                $qrScannerPath = "app/member-donation/qr-codes/{$year}/{$month}/{$invoiceNumber}-qr.jpg";
                Log::channel('member')->info('Qr Code Second Path', ['path' => $qrScannerPath]);



                // Generate the PDF
                $count = 0;
                $filePath = "{$directoryPath}/{$fileName}";
                $pdf = Pdf::loadView('pdf.member.offline-donation-invoice', compact('insertData','adminEmail','invoiceNumber', 'today', 'qrScannerPath','count'));
                $pdf->save($filePath);
                $insertData = array_merge($insertData, [
                    'qr_image' => "app/member-donation/qr-codes/{$year}/{$month}/{$invoiceNumber}-qr.jpg",
                    'donation_pdf' => "app/member-donation/{$year}/{$month}/{$fileName}",
                ]);
                Payment::create($insertData);
                Log::channel('member')->info('Payment data inserted successfully', ['data' => $insertData]);
                $email = $data['member_email'];
                $this->sendEmailforOfflinePayment($email, $invoiceNumber,'member');
                $this->sendEmailforOfflinePayment($adminEmail, $invoiceNumber,'admin');
                $this->sendWhatsappMessage($invoiceNumber);
                
                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                Log::channel('member')->error('Error in offlinePaymentModule', [
                    'message' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
            }

         // Send emails
        //  $this->sendEmail($email, $r_payment_id,'member');
        //  $this->sendEmail($adminEmail, $r_payment_id,'admin');
        

    }

    public function sendInvoice(array $InvoiceData,  User $member){
        // dd($InvoiceData);
       
        try{
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
                'userName' => $userName,
                'email' => $email,
                'subscription_link' => $subscriptionLink,
            ]);

            // Return view with Razorpay Checkout data
            return view('member.auth.checkout', [
                'subscription_id' => $subscription->id,
                'plan_name' => $planName,
                'plan_id' => $plan->id,
                'amount' => $amount,
                'interval' => $interval,
                'email' => $email,
                'contact' => $contact,
                'userName' => $userName,
                'userId'   => $userId,
            ]);
        }catch (\Exception $e){
           
            Log::channel('razorpay')->error('Warning In sendInvoice Function : ' . $e->getMessage());
        }
    }

    public function handleSuccess(Request $request){
        // dd($request->all());
        Log::channel('razorpay')->info('handleSuccess Request Data:', $request->all());
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

            Log::channel('razorpay')->info('Razorpay Payment Fetched:', [
                'payment_id' => $data['razorpay_payment_id'],
                'payment_data' => $payment->toArray()
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
                'mode'                 => 1,
                'r_payment_id'        => $data['razorpay_payment_id'],
                'r_order_id'           => $payment['order_id'] ?? '',
                'merchant_order_id'   => rand(11111, 99999) . time(),
                'user_id'              => $data['userId'] ?? null,
                'user_name'           => $data['userName'] ?? null,
                'user_mobile'         => $data['contact'],
                'user_email'         => $data['email'],
                'amount'             => $data['plan_amount'] / 100,
                'json_response'       => json_encode($payment->toArray()),
            ]);
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
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
        $this->createInvoice($subscription);
        session()->flash('success', '🎉 Payment successfully completed!');
        return view('member.auth.thank-you', compact('subscription'));
    }   

    // RazorpayController.php
    public function webhookHandler(Request $request)
    {
        $payload = $request->getContent();
        $signature = $request->header('X-Razorpay-Signature');
        $secret = env('RAZORPAY_WEBHOOK_SECRET'); // Razorpay dashboard se lena h

        // 🔐 Verify webhook signature
        if (!hash_equals(hash_hmac('sha256', $payload, $secret), $signature)) {
            Log::channel('razorpay')->error('⚠️ Invalid Webhook Signature');
            return response('Invalid signature', 400);
        }
        $data = $request->all();
        Log::channel('razorpay')->info('📥 Webhook received', $data);

        // 🎯 Filter only required event
        if ($data['event'] === 'payment.captured') {
            try {
                $api = new \Razorpay\Api\Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
                $payment = $api->payment->fetch($data['payload']['payment']['entity']['id']);
                $subscriptionId = $payment['subscription_id'];

                // 🧾 Fetch invoice to get short_url
                $invoices = $api->invoice->all(['subscription_id' => $subscriptionId]);
                $subscriptionLink = !empty($invoices['items']) ? $invoices['items'][0]->short_url : null;

                // 🗃️ Save Subscription
                $subscription = Subscription::create([
                    'razorpay_payment_id' => $payment->id,
                    'plan_name'        => $payment['notes']['plan_name'] ?? 'N/A',
                    'plan_id'          => $payment['notes']['plan_id'] ?? null,
                    'subscription_id'  => $subscriptionId,
                    'plan_amount'      => $payment['amount'] / 100,
                    'interval'         => $payment['notes']['interval'] ?? 'monthly',
                    'customer_email'   => $payment['email'],
                    'customer_contact' => $payment['contact'],
                    'subscription_link'=> $subscriptionLink,
                ]);

                // 💰 Save Payment
                Payment::create([
                    'mode'               => 1,
                    'r_payment_id'       => $payment->id,
                    'merchant_order_id'  => rand(11111, 99999) . time(),
                    'user_id'            => $payment['notes']['userId'] ?? null,
                    'user_name'          => $payment['notes']['userName'] ?? null,
                    'user_mobile'        => $payment['contact'],
                    'user_email'         => $payment['email'],
                    'amount'             => $payment['amount'] / 100,
                    'json_response'      => json_encode($payment->toArray()),
                ]);

                // 🧾 Generate invoice PDF
                $this->createInvoice($subscription);

                return response('Webhook processed', 200);

            } catch (\Exception $e) {
                Log::channel('razorpay')->error('Webhook exception: ' . $e->getMessage());
                return response('Webhook error', 500);
            }
        }

        return response('Event not handled', 200);
    }


    public function createInvoice($subscription){
        $r_payment_id = $subscription->razorpay_payment_id;                
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
        $adminEmail =  BussinessSetting::where('type','email')->value('value');
        $email = $payment_table->user_email;

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
        $this->sendEmail($email, $r_payment_id,'member');
        $this->sendEmail($adminEmail, $r_payment_id,'admin');
        $this->sendWhatsappMessage($invoiceNumber);
        // DB::commit();
        Log::channel('razorpay')->info('Donation Payment Successfully Complete!');

    }  

     private function sendWhatsappMessage($invoiceNumber)
    {

        $payment_table = Payment::where('invoice_no',$invoiceNumber)->first();
        if (!$payment_table) {
            Log::channel('whatsapp')->warning("Payment not found for this invoice number: $invoiceNumber");
            return;
        }
        $name = $payment_table->user_name ?? 'Unknown Donor';
        $pdfPath = env('ASSET_URL') . '/' . ltrim($payment_table->donation_pdf, '/');
        Log::channel('whatsapp')->info('Invoice PDF Path: ' . $pdfPath);
        $MobileNo = $payment_table->user_mobile ?? '0000000000';
        $razorpayLine = '';
        if ($payment_table->mode != 3) {
            $razorpayLine = "🆔 *Razorpay Payment ID:* {$payment_table->r_payment_id}\n\n";
        }
        $message = "🙏 *Thank you for your donation, $name!*\n\n" .
                "💸 *Amount Paid:* ₹" . $payment_table->amount . "\n" .
                $razorpayLine .
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
                    Log::channel('whatsapp')->error('API responded but failed to send message : ' . $response->body());
                }
            } else {
                Log::channel('whatsapp')->error('API Error: ' . $response->status() . ' - ' . $response->body());
            }
        } catch (Exception $e) {
            Log::channel('whatsapp')->error('WhatsApp API Exception', ['error' => $e->getMessage()]);
        }
    }

    private function sendEmail($email, $r_payment_id, $role)
    {
        try{
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
            $adminEmail = BussinessSetting::where('type','email')->value('value');
            Log::channel('razorpay')->info('Invoice PDF Path: ' . $pdfPath);  
            Log::channel('razorpay')->info('Invoice subject : ' . $subject);        
            $mail = (new SendDonationInvoiceMail($payment_table, $isAdmin, $count, $subject))
                    ->attach($pdfPath);
            if (!empty($payment_table->attachment)) {
                $attachmentPath = public_path($payment_table->attachment);
                if (File::exists($attachmentPath)) {
                    $mail->attach($attachmentPath);
                    Log::channel('razorpay')->info('Invoice attachment Path: ' . $attachmentPath);
                } else {
                    Log::channel('razorpay')->warning('Attachment file not found at: ' . $attachmentPath);
                }
            }
            Mail::to($email)->cc($adminEmail)->queue($mail);
            Log::channel('razorpay')->info('Email Sent With PDF To ' . $email);

        }catch (\Exception $mailException) {
            Log::channel('razorpay')->error('Failed to send email to ' . $email . '. Error: ' . $mailException->getMessage());
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
                Log::channel('razorpay')->error('Payment record not found for Invoice No ID: ' . $invoice_no);
                return;
            }
            $count = 0;
            $pdfPath = public_path($payment_table->donation_pdf);           
            $adminEmail = BussinessSetting::where('type','email')->value('value');
            Log::channel('razorpay')->info('Invoice PDF Path: ' . $pdfPath);     
             Log::channel('razorpay')->info('Invoice subject : ' . $subject);         
            $mail = (new SendDonationInvoiceMail($payment_table, $isAdmin, $count, $subject))
                    ->attach($pdfPath);
            if (!empty($payment_table->attachment)) {
                $attachmentPath = public_path($payment_table->attachment);
                if (File::exists($attachmentPath)) {
                    $mail->attach($attachmentPath);
                    Log::channel('razorpay')->info('Invoice attachment Path: ' . $attachmentPath);
                } else {
                    Log::channel('razorpay')->warning('Attachment file not found at: ' . $attachmentPath);
                }
            }
            Mail::to($email)->cc($adminEmail)->queue($mail);
            Log::channel('razorpay')->info('Email Sent With PDF To ' . $email);

        }catch (\Exception $mailException) {
            Log::channel('razorpay')->error('Failed to send email to ' . $email . '. Error: ' . $mailException->getMessage());
        }

    }


    public function memberVerify($email)
    {
        $user = User::where('email', $email)->first();
        if (!$user) {
            return back()->with('error', 'Record Not Found!');
        }
        $mobileNo = str_starts_with($user->mobile, '+91') ? $user->mobile : '+91' . $user->mobile;
        $user->update(['email_verified_at' => now()]);
        Auth::login($user);

        $apiKey = 'eGyZ9B45gSXn';
        $whatsappApiUrl = 'http://api.textmebot.com/send.php';

        $websiteName = "Gaam Raam Test";
        $websiteUrl = "https://server1.pearl-developer.com/gaamraam/public";
        $message = "Hello {$user->name}, your email has been successfully verified. 🎉
        Welcome to {$websiteName}! You can now access your account here: {$websiteUrl}";


        $response = Http::get($whatsappApiUrl, [
            'recipient' => $mobileNo,
            'apikey' => $apiKey,
            'text' => $message
        ]);
        if ($response->failed()) {
            return response()->json([
                'errors' => ['message' => 'Failed to send WhatsApp message.']
            ], 500);
        }
        return redirect()->route('member.dashboard')->with('success', 'Your account has been verified successfully!');
    }

    public function validateEmail(Request $request)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'email' => [
                'required',
                'email',
                'unique:users,email',
                'regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z.-]+\.[a-zA-Z]{2,}$/'
            ]
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors()->first('email')]);
        }
        return response()->json(['status' => 'success']);
    }

    public function validateMobile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mobile' => ['required', 'regex:/^[0-9]{10,15}$/']
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->first('mobile')
            ]);
        }

        // Check if mobile number already exists
        $exists = \DB::table('users')->where('mobile', $request->mobile)->exists();
        if ($exists) {
            return response()->json([
                'status' => 'error',
                'message' => 'This mobile number is already taken.',
                'exists' => true
            ]);
        }

        return response()->json(['status' => 'success', 'exists' => false]);
    }

    public function validateReferralCode(Request $request){
        $validator = Validator::make($request->all(), [
            'referral_code' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status'  => 'error',
                'message' => $validator->errors()->first('referral_code')
            ]);
        }
        $exists = \DB::table('admins')->where('referral_code', $request->referral_code)->exists();
        if (!$exists) {
            return response()->json([
                'status'  => 'error',
                'message' => 'This referral code is invalid.',
                'exists'  => false
            ]);
        }
        return response()->json([
            'status' => 'success',
            'exists' => true
        ]);
    }



    public function memberLogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        if (Auth::attempt($request->only('email', 'password'))) {
            $member = Auth::user();

            if (is_null($member->email_verified_at)) {
                Auth::logout();
                return response()->json([
                    'status' => 'error',
                    'message' => 'Your account is not verified! Please check your email for verification or connect with admin!'
                ]);
            }

            if ($member->status == '0') {
                Auth::logout();
                return response()->json([
                    'status' => 'error',
                    'message' => 'Your account is not active! Please contact admin.'
                ]);
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Login Successfully!',
                'redirect_url' => route('member.dashboard')
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Wrong Credentials!'
        ]);
    }


    public function dashboard()
    {
        $member = Auth::user();
        $tasks = Task::where('assign_to', $member->id)->paginate(10);
        $totalTasks = Task::where('assign_to', $member->id)->count();
        $rejectedCount = Task::where('assign_to', $member->id)->where('status', 0)->count();
        $pendingCount  = Task::where('assign_to', $member->id)->where('status', 2)->count();
        $acceptedCount = Task::where('assign_to', $member->id)->where('status', 1)->count();
        $rejectedPercentage = $totalTasks > 0 ? round(($rejectedCount / $totalTasks) * 100) : 0;
        $pendingPercentage  = $totalTasks > 0 ? round(($pendingCount / $totalTasks) * 100) : 0;
        $acceptedPercentage = $totalTasks > 0 ? round(($acceptedCount / $totalTasks) * 100) : 0;
        $taskUpdatesCount = TaskUpdate::whereHas('task', function ($q) use ($member) {
            $q->where('assign_to', $member->id);
        })->count();
        $maxExpectedUpdates = 74; 
        $taskUpdatesPercentage = $maxExpectedUpdates > 0 ? round(($taskUpdatesCount / $maxExpectedUpdates) * 100) : 0;
        $point = $member->points;
        $levels = [
            ['level' => 1, 'points' => 100],
            ['level' => 2, 'points' => 20000],
            ['level' => 3, 'points' => 50000],
            ['level' => 4, 'points' => 100000],
        ];
        $currentLevel = 0;
        $minPoints = 0;
        $maxPoints = $levels[0]['points'];
        foreach ($levels as $index => $level) {
            if ($point >= $level['points']) {
                $currentLevel = $level['level'];
                $minPoints = $level['points'];
                $maxPoints = $levels[$index + 1]['points'] ?? $level['points']; // Next level or cap
            } else {
                $maxPoints = $level['points'];
                break;
            }
        }

       $progressPercent = ($maxPoints - $minPoints) > 0
        ? round((($point - $minPoints) / ($maxPoints - $minPoints)) * 100)
        : 0;
        $progressPercent = max(0, min(100, $progressPercent));

        // dd($point);
        return view('member.dashboard', compact(
            'member', 'tasks', 'rejectedCount', 'totalTasks',
            'rejectedPercentage', 'pendingPercentage', 'pendingCount',
            'acceptedCount', 'acceptedPercentage',
            'taskUpdatesCount', 'taskUpdatesPercentage', 'maxExpectedUpdates','point','levels','currentLevel','progressPercent'
        ));
    }


    public function profile(Request $request){
        if ($request->isMethod('get')) {
            return view('member.auth.profile.index', [
                'member' => Auth::user()
            ]);
        }

        $request->validate([
            'name'           => 'required|string|max:255',
            'dob'            => 'required|date',
            'gender'         => 'required|in:1,2,3',
            'address'        => 'required|string',
            'city'           => 'required|numeric',
            'block'          => 'required|numeric',
            'blood_group'    => 'required|string|max:5',
            'email'          => 'required|email|unique:users,email,' . Auth::id(),
            'mobile'         => 'required|numeric|unique:users,mobile,' . Auth::id(),
            'profile_image'  => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);
        $member = Auth::user();
        $member->fill($request->only([
            'name', 'email', 'mobile', 'dob', 'gender', 'address', 'city', 'block', 'blood_group'
        ]));

        if ($request->hasFile('profile_image')) {
            $file = $request->file('profile_image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $folderPath = "app/member-profile/" . now()->year . '/' . now()->format('M');
            $file->move(public_path($folderPath), $filename);
            $member->profile_image = "$folderPath/$filename";
        }
        if (empty($member->member_id)) {
            $member->member_id = 'GMT' . now()->format('Ym') . rand(1000000, 9999999);
            $member->save(); 
        }
        $qrCodePath = $this->generateIdCardQRCode($member->member_id);
        if ($qrCodePath) {
            $member->qr_code_path = $qrCodePath;
            $member->save();
        }
        $pdfPath = $this->generateIdCardPdf($member->member_id, $qrCodePath);
        if ($pdfPath) {
            $member->id_card_pdf_path = $pdfPath;
            $member->save();
        }
        return redirect()->route('member.profile')->with('success', 'Profile Updated Successfully!');
    }


    private function generateIdCardQRCode($memberId){
        $year = now()->year;
        $month = now()->format('M');
        $qrCodeDirectory = public_path("app/member-profile/qr-codes/{$year}/{$month}");
        Log::channel('email')->info("Generating QR code for id-card", ['member_id' => $memberId]);
        if (!File::exists($qrCodeDirectory)) {
            File::makeDirectory($qrCodeDirectory, 0777, true);
        }
          try {
            $qrCode = new QrCode(route('id-card-info', ['member_id' => $memberId]));
            $writer = new PngWriter();
            $qrCodeContent = $writer->write($qrCode)->getString();
            $qrCodeFilePath = "{$qrCodeDirectory}/{$memberId}-qr.jpg";
            file_put_contents($qrCodeFilePath, $qrCodeContent);
            Log::channel('email')->info("QR code generated successfully", ['file_path' => $qrCodeFilePath]);
            return "app/member-profile/qr-codes/{$year}/{$month}/{$memberId}-qr.jpg";
        } catch (\Exception $e) {
            Log::channel('email')->error("QR code generation failed", ['error' => $e->getMessage()]);
            return null;
        }
    }

    private function generateIdCardPdf($memberId, $qrCodeFilePath)
    {
        $year = now()->year;
        $month = now()->format('M');
        $fileName = "{$memberId}.pdf";
        $directoryPath = public_path("app/member-profile/id-cards/{$year}/{$month}");
        Log::channel('email')->info("Generating id-card PDF", ['memberId' => $memberId]);
        if (!File::exists($directoryPath)) {
            File::makeDirectory($directoryPath, 0777, true);
        }
        try {
            $filePath = "{$directoryPath}/{$fileName}";
            $member = User::where('member_id',$memberId)->first();
            if($member == null){
                Log::channel('email')->error("Member Not Found for this member id :", ['memberId' => $memberId]);
                return null;
            }
            $pdf = Pdf::loadView('member.auth.profile.id-card', compact('memberId','member','qrCodeFilePath'));
            $pdf->save($filePath);
            Log::channel('email')->info("Invoice PDF generated successfully", ['file_path' => $filePath]);
            return "app/member-profile/id-cards/{$year}/{$month}/{$fileName}";
        } catch (\Exception $e) {
            Log::channel('email')->error("Invoice PDF generation failed", ['error' => $e->getMessage()]);
            return null;
        }
    }

    public function viewIdCardInfo($member_id){
        $member = User::where('member_id', $member_id)->first();
        return view('member.auth.profile.website-id-card', compact('member'));
    }


    


    public function logout(){
        Auth::logout();
        session()->flush();
        // dd('Logged out');      
        return redirect('member-register?form=login')->with('error', 'Logout Successfully!');
    }

    public function memberDetail($id){
        return view('member.auth.detail');
    }

    public function getBlocksByCity(Request $request)
    {
        $cityId = $request->query('city_id');
        $blocks = Block::where('city_id', $cityId)->get(['id', 'name']);
        return response()->json($blocks);
    }


    public function changePasswordForm(){
        return view('member.auth.change-password');
    }

    public function changePassword(Request $req){    
        $student = Auth::user();       
        if($req->has('password') && $req->password != null){
            $data['password'] = Hash::make($req->password);
        }
        $student->update($data);
        return redirect()->back()->with('success', 'Password updated successfully!');
    }

    public function downloadIdCard($member_id){
        $member = User::where('member_id',decrypt($member_id))->first();
        $pdfPath = public_path($member->id_card_pdf_path);
        if (!file_exists($pdfPath)) {
            abort(404, 'ID Card PDF not found.');
        }
        return response()->download($pdfPath, 'Member-ID-Card-' . $member->member_id . '.pdf', [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="Member-ID-Card-' . $member->member_id . '.pdf"'
        ]);

    }



}
