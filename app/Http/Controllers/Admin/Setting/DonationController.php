<?php

namespace App\Http\Controllers\Admin\Setting;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Auth;

use App\Models\Payment;
use App\Models\User;


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

class DonationController extends Controller
{
  public function donationReport(Request $req){
    $query = Payment::orderBy('created_at', 'desc');
    if ($req->member_id && $req->member_id !== 'all') {
        $query->where('user_id', $req->member_id);
    }
    if($req->has('invoice_no') && $req->invoice_no != null){
        $query->where('invoice_no','like','%' .$req->invoice_no . '%');
    }
    if ($req->filter_values) {
        $now = now();
        if ($req->filter_values == 'this_year') {
            $query->whereYear('created_at', $now->year);
        } elseif ($req->filter_values == 'this_month') {
            $query->whereYear('created_at', $now->year)
                  ->whereMonth('created_at', $now->month);
        } elseif ($req->filter_values == 'this_week') {
            $query->whereBetween('created_at', [$now->startOfWeek(), $now->endOfWeek()]);
        } elseif ($req->filter_values == 'custom' && $req->startDate && $req->endDate) {
            $query->whereBetween('created_at', [$req->startDate, $req->endDate]);
        }
    }
    $donations = $query->paginate(10);
    $members   = User::all();
    return view('admin.donation.view', compact('donations','members'));
  }

    public function donationAdd(Request $req) {
        $req->validate([
            'user_name' => 'required|string',
            'amount' => 'required|min:0|numeric',
        ]);
        DB::beginTransaction();
        try {
            $donate = new Payment();
            $donate->mode = 2;
            $donate->currency = $req->currency;
            $donate->user_name = $req->user_name;
            $donate->user_mobile = $req->user_mobile;
            $donate->user_email = $req->user_email;
            $donate->amount = $req->amount;
            $donate->save();
            Log::info("Donation added successfully", ['donation_id' => $donate->id]);
            $this->generateInvoice($donate->id);
            DB::commit();
            return back()->with('success', 'Donation added successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Donation creation failed", ['error' => $e->getMessage()]);
            return back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }

    public function generateInvoice($donate_id) {
        try {
            DB::beginTransaction();
            $donate = Payment::findOrFail($donate_id);
            $invoiceNumber = now()->format('Ym') . rand(100000, 999999);
            $year = now()->year;
            $month = now()->format('M');
            $today = Carbon::now()->format('d-M-Y');
            $adminEmail = "atul@pearlorganisation.com";
            Log::info("Generating invoice", ['donation_id' => $donate_id, 'invoice_no' => $invoiceNumber]);
            $qrCodeFilePath = $this->generateQrCode($invoiceNumber, $year, $month);
            $pdfFilePath = $this->generatePdf($donate, $invoiceNumber, $year, $month, $today, $adminEmail, $qrCodeFilePath);
            $donate->update([
                'donation_pdf' => $pdfFilePath,
                'invoice_no'   => $invoiceNumber,
            ]);
            DB::commit();
            Log::info("Invoice generated successfully", ['donation_id' => $donate_id, 'pdf_path' => $pdfFilePath, 'qr_code' => $qrCodeFilePath]);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Invoice generation failed: ' . $e->getMessage());
        }
    }

    private function generateQrCode($invoiceNumber, $year, $month) {
        try {
            $qrCode = new QrCode(route('member-invoice', ['invoiceNumber' => $invoiceNumber]));
            $writer = new PngWriter();
            $qrCodeContent = $writer->write($qrCode)->getString();
            $qrCodeDirectory = public_path("app/member-donation/qr-codes/{$year}/{$month}");
            if (!File::exists($qrCodeDirectory)) {
                File::makeDirectory($qrCodeDirectory, 0777, true);
            }
            $qrCodeFilePath = "{$qrCodeDirectory}/{$invoiceNumber}-qr.jpg"; 
            file_put_contents($qrCodeFilePath, $qrCodeContent);
            Log::info("QR Code generated", ['invoice_no' => $invoiceNumber, 'path' => $qrCodeFilePath]);
            return "app/member-donation/qr-codes/{$year}/{$month}/{$invoiceNumber}-qr.jpg";
        } catch (\Exception $e) {
            Log::error("QR Code generation failed", ['invoice_no' => $invoiceNumber, 'error' => $e->getMessage()]);
            throw new \Exception("QR Code generation failed: " . $e->getMessage());
        }
    }

    private function generatePdf($payment_table, $invoiceNumber, $year, $month, $today, $adminEmail, $qrCodeFilePath) {
        try {
            $directoryPath = public_path("app/member-donation/{$year}/{$month}");
            if (!File::exists($directoryPath)) {
                File::makeDirectory($directoryPath, 0777, true, true);
            }
    
            $fileName = "invoice_{$invoiceNumber}.pdf";
            $filePath = "{$directoryPath}/{$fileName}";
    
            $count = 1;
            $pdf = Pdf::loadView('pdf.member.donation-invoice', compact('adminEmail', 'today', 'invoiceNumber', 'qrCodeFilePath', 'count','payment_table'));
            $pdf->save($filePath);
            Log::info("PDF generated", ['invoice_no' => $invoiceNumber, 'path' => $filePath]);
            return "app/member-donation/{$year}/{$month}/{$fileName}";
        } catch (\Exception $e) {
            Log::error("PDF generation failed", ['invoice_no' => $invoiceNumber, 'error' => $e->getMessage()]);
            throw new \Exception("PDF generation failed: " . $e->getMessage());
        }
    }

  

 



}
