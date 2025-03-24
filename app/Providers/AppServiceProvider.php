<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator; // ✅ Add this line

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Validator::replacer('unique', function ($message, $attribute) {
            if ($attribute === 'student_id') {
                return 'This Student ID is already registered.';
            }
            return $message;
        });
    }
}
