<?php

namespace App\Providers;

use App\Models\GeneralSetting;
use Carbon\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;

class ConfigServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot()
    {
        Carbon::setWeekStartsAt(Carbon::MONDAY);
        Carbon::setWeekEndsAt(Carbon::SUNDAY);

        try {
            $data = GeneralSetting::where('key', 'mail_config')->first();
            $emailServices = json_decode($data->value, true);

            if ($emailServices) {
                $config = [
                    'mail.mailers.smtp.transport' => 'smtp',
                    'mail.mailers.smtp.host' => $emailServices['host'],
                    'mail.mailers.smtp.port' => $emailServices['port'],
                    'mail.mailers.smtp.encryption' => $emailServices['encryption'],
                    'mail.mailers.smtp.username' => $emailServices['username'],
                    'mail.mailers.smtp.password' => $emailServices['password'],
                    'mail.from.address' => $emailServices['email_id'],
                    'mail.from.name' => $emailServices['name'],
                ];
                Config::set($config);
            }
        } catch (\Exception $ex) {
            // Handle the exception if needed
        }
    }
}
