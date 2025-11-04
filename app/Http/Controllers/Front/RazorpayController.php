<?php

namespace App\Http\Controllers\Front;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Razorpay\Api\Api;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;
use App\Models\Payment;

class RazorpayController extends Controller
{

    protected $razorpayKey;
    protected $razorpaySecret;
    protected $api;
    protected $secret;

    public function __construct()
    {
        $this->razorpayKey = env('RAZORPAY_KEY');
        $this->razorpaySecret = env('RAZORPAY_SECRET');
        $this->api = new Api($this->razorpayKey, $this->razorpaySecret);
        $this->secret = env('RAZORPAY_WEBHOOK_SECRET');

    }

    public function razorpayView()
    {
        // dd($this->secret);
        return view('front.razorpay.view');
    }


    public function get_curl_handle_razorpay($razorpayPaymentId, $amount, $currencyCode)
    {
        $url = 'https://api.razorpay.com/v1/payments/' . $razorpayPaymentId . '/capture';
        $key_id = env('RAZORPAY_KEY');
        $key_secret = env('RAZORPAY_SECRET');
        $arr = ['amount' => $amount * 100, 'currency' => $currencyCode];

        $fields_string = json_encode($arr);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_USERPWD, $key_id . ':' . $key_secret);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        return $ch;
    }

    public function proceedPayment($request)
    {
        try {
            $razorpayPaymentId = $request['razorpay_payment_id'];
            $merchant_order_id = $request['merchant_order_id'];
            $amount = $request['amount'];
            $currencyCode = 'INR';

            Log::channel('razorpay')->info('Starting payment capture for order: ' . $merchant_order_id);

            $ch = $this->get_curl_handle_razorpay($razorpayPaymentId, $amount, $currencyCode);
            $result = curl_exec($ch);
            $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            Log::channel('razorpay')->debug('Raw CURL response: ' . $result);

            $response_array = json_decode($result, true);

            if (
                ($http_status === 200 && isset($response_array['status']) && $response_array['status'] === 'captured') ||
                (isset($response_array['error']['description']) && $response_array['error']['description'] === 'This payment has already been captured')
            ) {
                DB::table('payments')->insert([
                    'mode' => '1',
                    'r_payment_id' => $response_array['id'] ?? 'N/A',
                    'merchant_order_id' => $merchant_order_id,
                    'method' => $response_array['method'],
                    'currency' => $response_array['currency'],
                    'user_email' => 'harshit@example.com',
                    'amount' => $response_array['amount'] / 100,
                    'json_response' => $result,
                ]);

                Log::channel('razorpay')->info('Payment captured for order: ' . $merchant_order_id);
                return 'captured';
            } else {
                Log::channel('razorpay')->warning('Payment failed for order: ' . $merchant_order_id . ' | Response: ' . $result);
                return 'failed';
            }

        } catch (Exception $e) {
            Log::channel('razorpay')->error('Payment Exception for order: ' . ($request['merchant_order_id'] ?? 'N/A') . ' | Message: ' . $e->getMessage());
            return 'failed';
        }
    }

    public function proceddToPay(Request $request)
    {
        // dd($request->all());
        Log::channel('razorpay')->info("Payment process started", ['request' => $request->all()]);
        $api = new Api($this->razorpayKey, $this->razorpaySecret);

         // Step 1: Check if Customer Exists
        $email = $request->input('email');
        $contact = $request->input('mobile_no');
        $existingCustomer = null;
        $customers = $api->customer->all(['email' => $email]);
        // dd($customers->count);
        if ($customers->count!=0) {
            $existingCustomer = $customers['items'][0];
        }

        // Step 2: Create Customer if Not Exists
        if ($existingCustomer==null) {
            $customer = $api->customer->create([
                'name' => "Harshit Chauhan",
                'email' => $email,
                'contact' => $contact,
            ]);
        } else {
            $customer = $existingCustomer;
        }

        // Step 3: Create Plan
        $planName = "Monthly Subscription Plan";
        $interval = "monthly"; // weekly, monthly, yearly
        $amount = $request->input('amount') * 100; // Amount in paise

        $plan = $api->plan->create([
            'period' => $interval,
            'interval' => 1,
            'item' => [
                'name' => $planName,
                'amount' => $amount,
                'currency' => 'INR',
                'description' => 'Plan for ' . $planName,
            ],
        ]);

        // Step 4: Calculate Start Time
        $daysToAdd = match ($interval) {
            'weekly' => 7,
            'monthly' => 30,
            'yearly' => 365,
            default => 0,
        };
        $startAt = now()->addDays($daysToAdd)->timestamp;

        // Step 5: Create Subscription
        $subscription = $api->subscription->create([
            'plan_id' => $plan->id,
            'customer_id' => $customer['id'],
            'customer_notify' => 1,
            'total_count' => 12, // Billing cycles
        ]);

        // $paymentLink = $api->invoice->create([
        //     'type' => 'link',
        //     'description' => 'Payment for ' . $planName,
        //     'customer' => [
        //         'name' => $customer['name'],
        //         'email' => $customer['email'],
        //         'contact' => $customer['contact'],
        //     ],
        //     'amount' => $amount,
        //     'currency' => 'INR',
        //     'subscription_id' => $subscription->id,
        //     'receipt' => 'receipt_' . uniqid(),
        //     'callback_method' => 'get',
        // ]);



         session(['plan_id' => $plan->id, 'subscription_id' => $subscription->id, 'postData' => $request->all(),'amount'=>$request->amount ]);


        DB::beginTransaction();
        try {
            $request->validate([
                'razorpay_payment_id' => 'required|string',
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
            if ($payment === 'captured') {
                $payment_table = Payment::where('r_payment_id', $request->razorpay_payment_id)->first();
                if ($payment_table) {
                    $invoiceNumber = now()->format('Ym') . rand(100000, 999999);
                    $payment_table->update(['invoice_no' => $invoiceNumber]);
                }

                $invoices = $api->invoice->all(['subscription_id' => $subscription->id]);
                $firstInvoice = $invoices['items'][0] ?? null;
                if ($firstInvoice && isset($firstInvoice->short_url)) {
                    DB::commit();
                    return redirect($firstInvoice->short_url);
                } else {
                    return back()->with('error', 'Unable to fetch subscription invoice.');
                }



                return redirect(route('razorpay-view'))->with('success', 'Booking Successfully Complete!');
            }

            throw new Exception('Payment not captured');
        } catch (Exception $e) {
            DB::rollBack();
            Log::channel('razorpay')->error("Transaction failed: " . $e->getMessage());
            return back()->with('error', 'Warning : ' . $e->getMessage());
        }
    }

    public function handleWebhook(Request $request)
    {
        Log::channel('razorpay')->info("Webhook Hit", ['payload' => $request->all()]);
        $payload = $request->getContent();
        $sigHeader = $request->header('X-Razorpay-Signature');
        $secret = env('RAZORPAY_WEBHOOK_SECRET'); // Set this in .env file

        try {
            $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
            $verified = Webhook::verify($payload, $sigHeader, $secret);

            if ($verified) {
                $data = json_decode($payload, true);

                if ($data['event'] === 'subscription.activated') {
                    $subscriptionId = $data['payload']['subscription']['entity']['id'];

                    // Update your subscription in DB as Active
                    Subscription::where('subscription_id', $subscriptionId)->update([
                        'status' => 'active'
                    ]);
                     Log::info("Subscription $subscriptionId activated");
                }
            }
        } catch (\Exception $e) {
            Log::error('Razorpay Webhook error: ' . $e->getMessage());
            return response('Webhook Error', 400);
        }

        return response('Webhook Handled', 200);
    }
}
