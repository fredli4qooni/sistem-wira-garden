<?php

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;

if (!function_exists('setting')) {
    function setting($key, $default = null)
    {
        try {
            if (!Schema::hasTable('settings')) {
                return $default;
            }
            
            $settings = Cache::rememberForever('global_settings', function () {
                return Setting::pluck('value', 'key')->toArray();
            });

            return $settings[$key] ?? $default;
        } catch (\Exception $e) {
            return $default;
        }
    }
}
