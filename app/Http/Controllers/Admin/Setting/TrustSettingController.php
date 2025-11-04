<?php

namespace App\Http\Controllers\Admin\Setting;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Auth;

use App\Models\BussinessSetting;
use App\Models\Setting;

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
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\View;
use ZipArchive;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Http;
use Exception;

class TrustSettingController extends Controller
{
    public function privacyPolicy(Request $req){
        if($req->isMethod('get')){
            $privacyPolicy = BussinessSetting::find(2);
            // dd($privacyPolicy);
            return view('admin.setting.social-pages.privacy-policy', compact('privacyPolicy'));

        }else{
            // dd($req->all());
            $req->validate([
                'value' => 'required|string',
            ]);
            BussinessSetting::where('id', 2)->update([
                'value' => $req->value,
            ]);
            return back()->with('success','Privacy Policy Update Successfully!');
        }
    }

    public function termCondition(Request $req){
        if($req->isMethod('get')){
            $termCondition = BussinessSetting::find(1);
            return view('admin.setting.social-pages.term-condition', compact('termCondition'));

        }else{
            // dd($req->all());
            $req->validate([
                'value' => 'required|string',
            ]);
            BussinessSetting::where('id', 1)->update([
                'value' => $req->value,
            ]);
            return back()->with('success','Term & Condition Update Successfully!');
        }
    }

    public function cacheClear()
    {
        Artisan::call('cache:clear');
        Artisan::call('config:clear');
        Artisan::call('route:clear');
        Artisan::call('view:clear');
        return back()->with('success', 'Cache Clear Successfully!');
    }

    public function websiteProfile(){
        $settings = BussinessSetting::all()->pluck('value', 'type'); 
        return view('admin.setting.social-pages.website',compact('settings'));
    }       

    public function websiteProfileUpdate(Request $req){
        // dd($req->all());
        $fields = [
            4 => 'name',
            5 => 'mobile_no1',
            6 => 'mobile_no2',
            7 => 'address',
            8 => 'email',
            9 => 'map_link',
        ];

        foreach ($fields as $id => $field) {
            $row = BussinessSetting::find($id);
            if ($row) {
                $row->update(['value' => $req->$field]);
            }
        }

        if ($req->hasFile('logo')) {
            $file = $req->file('logo');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $year = now()->year;
            $month = now()->format('M');
            $folderPath = public_path("app/logo/{$year}/{$month}");
            if (!file_exists($folderPath)) {
                mkdir($folderPath, 0777, true);
            }
            $file->move($folderPath, $filename);
            $logoRow = BussinessSetting::find(3);
            if ($logoRow) {
                $logoRow->update(['value' => "app/logo/{$year}/{$month}/" . $filename]);
            }
        }
        return back()->with('success', 'Details updated successfully!');


    }

    public function socialMediaChat(Request $req){
            if($req->isMethod('get')){
                $setting = BussinessSetting::find(10);
                $whatsapp_api = BussinessSetting::find(14);
                return view('admin.setting.social-pages.whatsapp',compact('setting','whatsapp_api'));
            }else{
                // dd($req->all());
                $whatsappSetting = BussinessSetting::find(10);
                if ($whatsappSetting) {
                    $whatsappSetting->update(['value' => $req->whatsapp]);
                }
                $whatsappApiSetting = BussinessSetting::find(14);
                if ($whatsappApiSetting) {
                    $whatsappApiSetting->update(['value' => $req->whatsapp_api]);
                }
                return back()->with('success', 'Details updated successfully!');
            }
    }

    public function mailConfiguration(Request $req){
        if($req->isMethod('get')){
            $setting = BussinessSetting::find(11);
            $mailConfig = json_decode($setting->value, true);
            // dd($setting,$mailConfig);
            return view('admin.setting.social-pages.mail-configuration',compact('setting','mailConfig'));
        }else{
            // dd($req->all());

            $req->validate([
                'name' => 'required|string',
                'host' => 'required|string',
                'driver' => 'required|string',
                'port' => 'required|numeric',
                'username' => 'required|string',
                'email' => 'required|email',
                'encryption' => 'required|string',
                'password' => 'required|string',

            ]);
            $formattedName = str_replace(' ', '', $req->name);
            $mailConfig = [
                'name' => $formattedName,
                'host' => $req->host,
                'driver' => $req->driver,
                'port' => $req->port,
                'username' => $req->username,
                'email' => $req->email,
                'encryption' => $req->encryption,
                'password' => $req->password,
            ];

            BussinessSetting::where('id', 11)->update(['value' => json_encode($mailConfig)]);
            $this->updateEnvFile($mailConfig);
            return back()->with('success', 'Mail Configuration Updated Successfully!');
        
        }
    }

    private function updateEnvFile($config)
    {
        $envFile = base_path('.env');
        $envContent = file_get_contents($envFile);
        $envContent = preg_replace('/^MAIL_HOST=.*/m', "MAIL_HOST={$config['host']}", $envContent);
        $envContent = preg_replace('/^MAIL_MAILER=.*/m', "MAIL_MAILER={$config['driver']}", $envContent);
        $envContent = preg_replace('/^MAIL_PORT=.*/m', "MAIL_PORT={$config['port']}", $envContent);
        $envContent = preg_replace('/^MAIL_USERNAME=.*/m', "MAIL_USERNAME={$config['username']}", $envContent);
        $envContent = preg_replace('/^MAIL_FROM_ADDRESS=.*/m', "MAIL_FROM_ADDRESS={$config['email']}", $envContent);
        $envContent = preg_replace('/^MAIL_ENCRYPTION=.*/m', "MAIL_ENCRYPTION={$config['encryption']}", $envContent);
        file_put_contents($envFile, $envContent);
        Artisan::call('config:clear');
        Artisan::call('config:cache');
    }

    public function sendMail(Request $req){
        // dd($req->all());
        $toEmail = $req->email;
        $subject = '🔔Testing Purpose Email | 🗓️ ' . \Carbon\Carbon::today()->format('d-M-Y') . ' | 🕒 ' . \Carbon\Carbon::now()->format('h:i A');
        $body = 'This is a test email sent using raw content to check if email functionality is working.';
        try {
            Mail::raw($body, function ($message) use ($toEmail, $subject) {
                $message->to($toEmail)
                        ->subject($subject);
            });
            \Log::channel('email')->info('Success to send email to ' . $toEmail);
        } catch (\Exception $mailException) {
            return back()->with('error','Failed to send email to ' . $toEmail . '. Error: ' . $mailException->getMessage());
        }
        return back()->with('success','Mail Send Successfully!');
        
    }

    public function dataFileBackup(Request $req){
            return view('admin.website-setting.data-file-backup');      
    }

    public function dataFileBackupDownload(Request $request)
    {
        if ($request->has('sql_backup')) {
            return $this->backupDatabase();
        } elseif ($request->has('clear_cache')) {
            return $this->cacheClear();
        }

        return back()->with('error', 'Invalid request.');
    }

    private function backupDatabase()
    {
        try {
            $dbHost = env('DB_HOST');
            $dbName = env('DB_DATABASE');
            $dbUser = env('DB_USERNAME');
            $dbPass = env('DB_PASSWORD');
            $year = date('Y');
            $month = date('m');
    
            // Define storage path
            $storagePath = public_path("app/sql-backup/{$year}/{$month}");
            if (!File::exists($storagePath)) {
                File::makeDirectory($storagePath, 0755, true);
            }
    
            // Backup file name
            $backupFile = "{$storagePath}/backup-" . date('Y-m-d_H-i-s') . '.sql';
    
            // Detect OS and set mysqldump path
            $mysqldumpPath = 'mysqldump'; // Linux/macOS default
            if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
                $mysqldumpPath = '"C:\\xampp\\mysql\\bin\\mysqldump.exe"'; // Update for your MySQL installation
            }
    
            // Command as string for debugging
            $command = "{$mysqldumpPath} --user={$dbUser} --password={$dbPass} --host={$dbHost} {$dbName} > {$backupFile}";
    
            // Run command using shell_exec and log output
            $output = shell_exec($command . ' 2>&1'); // Capture errors
            \Log::error('MySQL Dump Output: ' . $output);
    
            // Check if file exists
            if (file_exists($backupFile)) {
                return response()->download($backupFile)->deleteFileAfterSend(true);
            }
    
            return redirect()->back()->with('error', 'Backup file was not created.');
        } catch (\Exception $e) {
            \Log::error('Backup Error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error downloading backup: ' . $e->getMessage());
        }
    }

    public function socialMedia(Request $req){
        if($req->isMethod('get')){
            $row = BussinessSetting::find(12);
            $socialMediaConfig = json_decode($row->value, true);
            return view('admin.setting.social-pages.social-media', compact('socialMediaConfig'));  
        }else{

            // dd($req->all());

            $req->validate([
                'facebook' => 'required|string',
                'instagram' => 'required|string',
                'youtube' => 'required|string',            
            ]);
            $socialMediaConfig = [
                'facebook' => $req->facebook,
                'instagram' => $req->instagram,
                'youtube' => $req->youtube,               
            ];

            BussinessSetting::where('id', 12)->update(['value' => json_encode($socialMediaConfig)]);
            return back()->with('success', 'Social Media Updated Successfully!');
        }
    }

    public function toggleMaintenance(Request $request)
    {
        // dd($request->all());
        $status = $request->input('status') === 'on' ? 'on' : 'off';
        Setting::set('maintenance_mode', $status);
        return response()->json(['message' => 'Maintenance mode updated successfully!']);
    }

    public function accessories(Request $req){
        if($req->isMethod('get')){
             return view('admin.setting.social-pages.accessories');  
        }

        
        if ($req->type == 'model') {
            $modelName = ucfirst($req->model);
            $existingMigrations = File::files(database_path('migrations'));
            Artisan::call('make:model', [
                'name' => $modelName,
                '--migration' => true,
            ]);
            $allMigrations = File::files(database_path('migrations'));
            $newMigration = collect($allMigrations)->diff($existingMigrations)->first();
            $migrationPath = $newMigration ? str_replace(base_path() . '/', '', $newMigration->getPathname()) : null;
            return back()->with([
                'success' => "Model & migration created for `$modelName`.",
                'migration_path' => $migrationPath,
            ]);
        }

        if($req->type == 'migrate_file') {
            $path = $req->migration_path;
            Artisan::call('migrate', [
                '--path' => str_replace(base_path() . '/', '', $path)
            ]);
            return back()->with('success', "Migration file `{$path}` executed successfully.");
        }

        if ($req->type == 'controller') {
            $controllerPath = $req->controller;
            Artisan::call('make:controller', [
                'name' => $controllerPath
            ]);
            return back()->with('success', "Controller `$controllerPath` created successfully.");
        }
        return back()->with('error', 'Invalid request type.');

    }

    public function sendWhatsappMessage(Request $req)
    {
        $MobileNo = $req->whatsapp_no;
        $message = "👋 Dear Aspirant,\n\n" .
            "✅ This is just a *test message* to confirm that the WhatsApp API is working correctly.\n\n" .
            "🧪 *No action is needed.*\n\n" .
            "🛠 This is only for testing. Please ignore.\n\n" .
            "Thanks & Regards,\n GaamRaam NGO Team";
         if (!str_starts_with($MobileNo, '+91')) {
            $MobileNo = '+91' . $MobileNo;
        }
        try {
            $apiKey = BussinessSetting::find(14)->value;
            $response = Http::get('http://api.textmebot.com/send.php', [
                'recipient' => $MobileNo,
                'apikey'    => $apiKey,
                'text'      => $message
            ]);
            if ($response->successful()) {
                $body = strtolower($response->body());
                if (str_contains($body, 'error') || str_contains($body, 'failed')) {
                    return back()->with('error', 'API responded but failed to send message: ' . $response->body());
                }
                return back()->with('success', 'Message sent successfully!');
            } else {
                return back()->with('error', 'API Error: ' . $response->status() . ' - ' . $response->body());
            }
        } catch (Exception $e) {
            Log::error('WhatsApp API Exception', ['error' => $e->getMessage()]);
            return back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }
}
