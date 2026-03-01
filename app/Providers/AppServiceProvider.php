<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

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
        if (app()->isProduction() && filter_var(env('FORCE_HTTPS', true), FILTER_VALIDATE_BOOL)) {
            URL::forceScheme('https');
        }

        RateLimiter::for('auth-login', function (Request $request): Limit {
            $email = (string) $request->input('email', 'guest');

            return Limit::perMinute(6)->by($email.'|'.$request->ip());
        });

        RateLimiter::for('contact-web', function (Request $request): Limit {
            $email = (string) $request->input('email', 'guest');

            return Limit::perMinute(12)
                ->by($email.'|'.$request->ip())
                ->response(function (Request $request): \Symfony\Component\HttpFoundation\Response {
                    return redirect()
                        ->to(route('portfolio') . '#contact')
                        ->withErrors([
                            'contact' => 'Too many contact attempts. Please wait a minute and try again.',
                        ])
                        ->withInput($request->only(['name', 'email', 'message']));
                });
        });

        RateLimiter::for('contact-api', function (Request $request): Limit {
            $email = (string) $request->input('email', 'guest');

            return Limit::perMinute(20)->by($email.'|'.$request->ip());
        });

        RateLimiter::for('access-request', function (Request $request): Limit {
            $email = (string) $request->input('email', 'guest');

            return Limit::perMinute(3)->by($email.'|'.$request->ip());
        });

        RateLimiter::for('access-key', function (Request $request): Limit {
            $email = (string) $request->input('email', 'guest');

            return Limit::perMinute(10)->by($email.'|'.$request->ip());
        });
    }
}
