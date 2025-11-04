<?php

namespace App\Http\Controllers\API\Member\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Auth;

use App\Models\User;
use App\Models\Payment;



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

class PaymentController extends Controller
{
    protected $assetUrl;

    public function __construct(){
        $this->assetUrl = env('ASSET_URL', '');
    }

    public function paymentOnline(Request $request){
        try{
            $user = $request->get('auth_user');
            $payments = Payment::with('member')->orderBy('created_at','desc')->where('user_id',$user->id)->whereIn('mode',[1,4,5])->get()->map(function ($payment) {
                            $payment->qr_image = $payment->qr_image ? ($this->assetUrl ? rtrim($this->assetUrl, '/') . '/' . ltrim($payment->qr_image, '/') : $payment->qr_image) : 'QR Code Not Available';
                            $payment->donation_pdf = $payment->donation_pdf ? ($this->assetUrl ? rtrim($this->assetUrl, '/') . '/' . ltrim($payment->donation_pdf, '/') : $payment->donation_pdf) : 'Donation Not Available';
                            $modeText = match($payment->mode) {
                                '1' => 'Online Payment Via Member Registration Page',
                                '2' => 'Donate Page Payment',
                                '3' => 'Offline Payment Via Member Registration Page',
                                '4' => 'Donate With His Panel',
                                '5' => 'Other Online Payment',
                                default => 'N/A'
                            };
                            $payment->mode = $modeText;
                            unset($payment->member);
                            return $payment;
                        });
            if ($payments->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Donation Not Found!'
                ],404);
            }            
            return response()->json([
                'status' => true,
                'message' => 'Member profile fetched successfully!',
                'member_name' => $user->name,
                'count'   => count($payments),
                'payments'   => $payments,
            ]);
        }catch (\Throwable  $e) {
                return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
      
    }

    public function paymentOffline(Request $request){
        try{
            $user = $request->get('auth_user');
            $payments = Payment::with('member')->orderBy('created_at','desc')->where('user_id',$user->id)->whereIn('mode',[3])->get()->map(function ($payment) {
                            $payment->qr_image = $payment->qr_image ? ($this->assetUrl ? rtrim($this->assetUrl, '/') . '/' . ltrim($payment->qr_image, '/') : $payment->qr_image) : 'QR Code Not Available';
                            $payment->donation_pdf = $payment->donation_pdf ? ($this->assetUrl ? rtrim($this->assetUrl, '/') . '/' . ltrim($payment->donation_pdf, '/') : $payment->donation_pdf) : 'Donation Not Available';
                            $modeText = match($payment->mode) {
                                '1' => 'Online Payment Via Member Registration Page',
                                '2' => 'Donate Page Payment',
                                '3' => 'Offline Payment Via Member Registration Page',
                                '4' => 'Donate With His Panel',
                                '5' => 'Other Online Payment',
                                default => 'N/A'
                            };
                            $payment->mode = $modeText;
                            unset($payment->member);
                            return $payment;
                        });
            if ($payments->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Donation Not Found!'
                ],404);
            }            
            return response()->json([
                'status' => true,
                'message' => 'Member donation fetched successfully!',
                'member_name' => $user->name,
                'count'   => count($payments),
                'payments'   => $payments,
            ]);
        }catch (\Throwable  $e) {
                return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
      
    }

    public function paymentSearch(Request $request){
        try{
            $user = $request->get('auth_user');
            $search = $request->input('search');
            $payments = Payment::where('user_id',$user->id)->orderBy('created_at','desc')->where('invoice_no', 'like', '%' . $search . '%')->get()->map(function ($payment) {
                            $payment->qr_image = $payment->qr_image ? ($this->assetUrl ? rtrim($this->assetUrl, '/') . '/' . ltrim($payment->qr_image, '/') : $payment->qr_image) : 'QR Code Not Available';
                            $payment->donation_pdf = $payment->donation_pdf ? ($this->assetUrl ? rtrim($this->assetUrl, '/') . '/' . ltrim($payment->donation_pdf, '/') : $payment->donation_pdf) : 'Donation Not Available';
                            $modeText = match($payment->mode) {
                                '1' => 'Online Payment Via Member Registration Page',
                                '2' => 'Donate Page Payment',
                                '3' => 'Offline Payment Via Member Registration Page',
                                '4' => 'Donate With His Panel',
                                '5' => 'Other Online Payment',
                                default => 'N/A'
                            };
                            $payment->mode = $modeText;                           
                            return $payment;
                        });                
            if ($payments->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No payments found of this invoice no!'
                ], 404);
            }
            return response()->json([
                'status' => true,
                'message' => 'Payments fetched successfully!',
                'member_name' => $user->name,
                'search' => $search,
                'count'   => count($payments),
                'payments'   => $payments,
            ]);
        }catch (\Throwable  $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

  




 
   


   


   


   



}
