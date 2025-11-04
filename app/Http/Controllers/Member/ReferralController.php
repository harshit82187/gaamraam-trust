<?php

namespace App\Http\Controllers\Member;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Auth;

use App\Models\User;
use App\Models\Payment;
use App\Models\Referral;

use App\Mail\SendDonationInvoiceMail;
use App\Mail\MemberVerification;

use Hash;
use Str;
use Mail;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Barryvdh\DomPDF\Facade\Pdf;


class ReferralController extends Controller
{
    public function referralList(){
        $member = Auth::user();
        $referrals = Referral::where('referrer_id',$member->id)->paginate(10);
        // dd($member,$referrals);
        return view('member.referral.list',compact('member','referrals'));
    }

    public function socialPoint(){
        $member = Auth::user();
        $referrals = Referral::where('referrer_id',$member->id)->paginate(10);
        // dd($member,$referrals);
        return view('member.referral.list',compact('member','referrals'));
    }

    public function enrollMember(Request $request) {
        // dd($request->all());
        DB::beginTransaction();
        Log::channel('razorpay')->info("Payment process started", ['request' => $request->all()]);
        $member = Auth::user();
        try{
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'mobile' => 'required|numeric|digits:10|unique:users,mobile',
                'password' => 'required|min:6',
            ]);

            $userData = [
                'name' => $request->name,
                'email' => $request->email,
                'mobile' => $request->mobile,
                'password' => Hash::make($request->password),
            ];
            if (!empty($request->passport)) {
                $userData['passport'] = $request->passport;
            }
            $newUser = User::create($userData);
            $points = 0;
            if ($request->currency == "INR") {
                $points = $request->amount * 0.10; // 10% of INR amount
            } elseif ($request->currency == "USD") {
                $points = ($request->amount * 0.10) * 83; // Convert USD to INR (Assuming 1 USD = 83 INR)
            }
            Referral::create([
                'referrer_id' => $member->id,  
                'referred_id' => $newUser->id,
                'points' => $points,
                'type'   => 5,
            ]);

            $referrer = Auth::user();
            $referrer->points += $points;
            $referrer->save();
            if ($request->mode == 3) {
                $this->offlinePaymentModule($request, [
                    'member_id'    => $newUser->id,
                    'member_name'  => $newUser->name,
                    'member_email' => $newUser->email,
                    'member_mobile'=> $newUser->mobile
                ]);
            }else{

                if (!$request->razorpay_payment_id || !$request->transaction_via || !$request->merchant_order_id) {
                    return response()->json(['error' => 'Missing payment details'], 400);
                }
                $invoiceData = [
                    'razorpay_payment_id' => $request->razorpay_payment_id,
                    'transaction_via'     => $request->transaction_via,
                    'merchant_order_id'   => $request->merchant_order_id,
                    'currency'            => $request->currency,
                    'amount'              => $request->amount,
                    'member_id'           => $newUser->id,
                    'member_name'           => $newUser->name,
                    'member_email'           => $newUser->email,
                    'member_mobile'           => $newUser->mobile,
                ];
                $this->sendInvoice($invoiceData);
            }   
            $data = [
                'name' => $request->name,
                'email' => $request->email,
            ];
            $email = $request->email;
            try {
                Mail::to($email)->queue(new MemberVerification($data));
                Log::channel('member')->info('Success to send email to ' . $email);
            } catch (\Exception $mailException) {
                Log::channel('member')->error('Failed to send email to ' . $email . '. Error: ' . $mailException->getMessage());
            }
            DB::commit();
            return back()->with('success', 'Member enrolled successfully!');
        }catch (\Exception $e){
            DB::rollBack();
            Log::channel('razorpay')->error("Transaction failed", ['error' => $e->getMessage()]);
            return back()->with('error', 'Warning : ' .$e->getMessage());
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
                'amount'       => $req->amount,
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
            $adminEmail = "gaamraam.ngo@gmail.com";

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
            DB::commit();
            }
          catch (\Exception $e) {
            DB::rollBack();
            Log::channel('member')->error('Error in offlinePaymentModule', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        }
             
     

    }


    public function get_curl_handle_razorpay($razorpayPaymentId, $amount, $currencyCode)
    {
        $url = 'https://api.razorpay.com/v1/payments/' . $razorpayPaymentId . '/capture';
        $key_id = env('RAZORPAY_KEY');
        $key_secret = env('RAZORPAY_SECRET');
        // $arr = ['amount' => $amount, 'currency' => $currencyCode];
        $arr = ['amount' => $amount * 100, 'currency' => $currencyCode];
        Log::channel('razorpay')->info('Razorpay Key ' . $key_id. 'And Secret Key ' . $key_secret);

        $arr1 = json_encode($arr);
        $fields_string = $arr1;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_USERPWD, $key_id . ':' . $key_secret);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        return $ch;
    }

    public function proceedPayment($request)
    {
        try {
            if (!empty($request['razorpay_payment_id']) || !empty($request['merchant_order_id'])) {
                $razorpayPaymentId = $request['razorpay_payment_id'];
                $merchant_order_id = $request['merchant_order_id'];
                $member_id  = $request['member_id'];
                $member_name  = $request['member_name'];
                $member_email  = $request['member_email'];
                $member_mobile  = $request['member_mobile'];

                $currencyCode = "INR";
                $amount = $request['amount'];
                $success = false;
                $error = '';

                Log::info('Starting payment process', [
                    'razorpay_payment_id' => $razorpayPaymentId,
                    'merchant_order_id' => $merchant_order_id,
                    'amount' => $amount,
                    'currency' => $currencyCode
                ]);
                $user = Auth::User();
                try {
                    $ch = $this->get_curl_handle_razorpay($razorpayPaymentId, $amount, $currencyCode);
                    $result = curl_exec($ch);
                    // dd($result);
                    $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                    Log::channel('razorpay')->info('Razorpay cURL Result', ['result' => $result, 'http_status' => $http_status]);
                    if ($result === false) {
                        $success = false;
                        $error = 'Curl error: ' . curl_error($ch);
                        Log::channel('razorpay')->error('Curl execution failed: ' . curl_error($ch));
                    } else {
                        $response_array = json_decode($result, true);
                        Log::channel('razorpay')->info('Razorpay Response', $response_array);
                        if ($http_status === 200 && isset($response_array['status'])) {
                          if ($response_array['status'] == 'captured' || $response_array['status'] == 'authorized') {
                                DB::enableQueryLog();
                                
                               
                                $payment = DB::table('payments')->insert([
                                    'mode' => '1',
                                    'r_payment_id' => $response_array['id'],
                                    'merchant_order_id' => $merchant_order_id,
                                    'method' => $response_array['method'],
                                    'currency' => $response_array['currency'],
                                    'user_id'   => $member_id,
                                    'user_email' => $member_email ?? '',
                                    'user_name' => $member_name ?? '',
                                    'user_mobile' => $member_mobile  ?? '',
                                    'amount' => $response_array['amount'] / 100,
                                    'json_response' => $result,
                                ]);
                                // Log::channel('razorpay')->info(DB::getQueryLog());
                                if (!$payment) {
                                    Log::channel('razorpay')->error('Payment creation failed in database', ['response' => $response_array]);
                                    throw new Exception('Payment not saved in database');
                                }
                                Log::channel('razorpay')->info('Payment successfully captured', ['status' => $response_array['status']]);
                                return 'captured';
                            } else {
                                $error = 'Payment capture failed: ' . $response_array['status'];
                                Log::channel('razorpay')->error('Payment capture failed', ['status' => $response_array['status']]);
                                return 'failed';
                            }
                        } else {
                            $success = false;
                            if (!empty($response_array['error']['code'])) {
                                $error = $response_array['error']['code'] . ': ' . $response_array['error']['description'];
                            } else {
                                $error = 'RAZORPAY_ERROR: Invalid Response';
                            }
                            Log::channel('razorpay')->error('Razorpay API error', ['error' => $error]);
                        }
                    }
                    curl_close($ch);
                } catch (Exception $e) {
                    $success = false;
                    $error = 'OPENCART_ERROR: Request to Razorpay Failed - ' . $e->getMessage();
                    Log::channel('razorpay')->error('Error processing payment: ' . $e->getMessage());
                }
            } else {
                $error = 'Missing required payment data';
                Log::channel('razorpay')->error('Error processing payment: ' . $error);
            }
        } catch (Exception $e) {
            $error = 'An error occurred: ' . $e->getMessage();
            Log::channel('razorpay')->error('Error processing payment: ' . $error);
        }
        if ($error) {
            Log::channel('razorpay')->error('Final error during payment: ' . $error);
            return 'An error occurred. Contact site administrator, please!';
        }
        return $success;
    }

    public function sendInvoice($InvoiceData){
        // dd($InvoiceData);
        DB::beginTransaction();
        try{
          
            Log::channel('razorpay')->info('InvoiceData : ' . json_encode($InvoiceData));
            $paymentData = [
                'razorpay_payment_id' => $InvoiceData['razorpay_payment_id'],
                'transaction_via'     => $InvoiceData['transaction_via'],
                'merchant_order_id'   => $InvoiceData['merchant_order_id'],
                'currency'            => $InvoiceData['currency'],
                'amount'              => $InvoiceData['amount'],
                'member_id'              => $InvoiceData['member_id'],
                'member_name'              => $InvoiceData['member_name'],
                'member_email'              => $InvoiceData['member_email'],
                'member_mobile'              => $InvoiceData['member_mobile'],
            ];
          
            $email = $InvoiceData['member_email'];
            if (!$email) {
                Log::channel('razorpay')->error('Email key is missing in InvoiceData.');
                return back()->with('error', 'Invalid Invoice Data: Email missing.');
            }
            Log::channel('razorpay')->info('Email is :' .$email);
            $payment = $this->proceedPayment($paymentData);
            if ($payment === 'captured' || $payment === 'authorized') {
                $r_payment_id =  $InvoiceData['razorpay_payment_id'];                
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
                $adminEmail = "gaamraam.ngo@gmail.com";

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
                    
                
             
                DB::commit();
                Log::channel('razorpay')->info('Donation Payment Successfully Complete!');
            }


        }catch (\Exception $e){
            DB::rollBack();
            Log::channel('razorpay')->error('Warning In sendInvoice Function : ' . $e->getMessage());
        }
    }

  

    



}
