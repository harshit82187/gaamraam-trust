<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\BussinessSetting;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        require_once app_path('Helpers/CustomHelper.php');
        $adminEmail = get_business_setting('email');
        $siteName   = get_business_setting('name');
        $mobile1    = get_business_setting('mobile_no1');
        $mobile2    = get_business_setting('mobile_no2');
        $websiteLogo = get_business_setting('logo');
        $address    = get_business_setting('address');
        $socialMediaConfig    = json_decode(get_business_setting('social_media'),true);
        View::share([
            'adminEmail' => $adminEmail,
            'siteName'   => $siteName,
            'mobile1'    => $mobile1,
            'mobile2'    => $mobile2,
            'websiteLogo'=> $websiteLogo,
            'address'    => $address,
            'socialMediaConfig'    => $socialMediaConfig,
        ]);
    }
}
