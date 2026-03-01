<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureDashboardPreviewAccess
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user()) {
            return $next($request);
        }

        $expiresAt = $request->session()->get('temporary_dashboard_access_until');

        if (! $expiresAt) {
            return redirect()->route('access.key.form')->withErrors([
                'access' => 'Temporary access key is required.',
            ]);
        }

        if (now()->greaterThan($expiresAt)) {
            $request->session()->forget(['temporary_dashboard_access_until', 'temporary_dashboard_email']);

            return redirect()->route('access.key.form')->withErrors([
                'access' => 'Your temporary access key has expired.',
            ]);
        }

        return $next($request);
    }
}
