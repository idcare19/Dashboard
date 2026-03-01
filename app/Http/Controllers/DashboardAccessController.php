<?php

namespace App\Http\Controllers;

use App\Models\DashboardAccessRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class DashboardAccessController extends Controller
{
    public function showRequestForm(): View
    {
        return view('access.request');
    }

    public function submitRequest(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'email' => ['required', 'email', 'max:255'],
            'message' => ['nullable', 'string', 'max:1000'],
        ]);

        DashboardAccessRequest::query()->create([
            'email' => $validated['email'],
            'message' => $validated['message'] ?? null,
            'status' => 'pending',
        ]);

        return redirect()
            ->route('access.request.form')
            ->with('success', 'Request sent. Admin will review and approve via email/key.');
    }

    public function showKeyForm(): View
    {
        return view('access.key');
    }

    public function verifyKey(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'email' => ['required', 'email', 'max:255'],
            'access_key' => ['required', 'string', 'min:8', 'max:64'],
        ]);

        $record = DashboardAccessRequest::query()
            ->where('email', $validated['email'])
            ->where('status', 'approved')
            ->whereNotNull('access_key_hash')
            ->latest()
            ->first();

        if (! $record || ! hash_equals($record->access_key_hash, hash('sha256', $validated['access_key']))) {
            return back()->withErrors([
                'access_key' => 'Invalid access key.',
            ])->onlyInput('email');
        }

        if (! $record->access_key_expires_at || now()->greaterThan($record->access_key_expires_at)) {
            return back()->withErrors([
                'access_key' => 'Access key expired. Request a new one.',
            ])->onlyInput('email');
        }

        $request->session()->put('temporary_dashboard_access_until', $record->access_key_expires_at->toDateTimeString());
        $request->session()->put('temporary_dashboard_email', $record->email);

        return redirect()->route('dashboard.preview');
    }

    public function clearTemporarySession(Request $request): RedirectResponse
    {
        $request->session()->forget(['temporary_dashboard_access_until', 'temporary_dashboard_email']);

        return redirect()->route('portfolio');
    }

    public function approve(Request $request, DashboardAccessRequest $accessRequest): RedirectResponse
    {
        $accessKey = strtoupper(substr(str_replace('-', '', (string) \Illuminate\Support\Str::uuid()), 0, 10));
        $expiresAt = now()->addHour();

        $accessRequest->update([
            'status' => 'approved',
            'access_key_hash' => hash('sha256', $accessKey),
            'access_key_expires_at' => $expiresAt,
            'approved_by' => $request->user()->id,
        ]);

        $mailBody = "Your dashboard temporary access key is: {$accessKey}\nThis key expires at {$expiresAt->toDateTimeString()} (server time).";

        try {
            Mail::raw($mailBody, function ($message) use ($accessRequest): void {
                $message->to($accessRequest->email)
                    ->subject('Dashboard Temporary Access Key');
            });
        } catch (\Throwable) {
            // Mail transport may be unavailable in local setups; key is still generated.
        }

        return back()->with('success', "Access approved. Key: {$accessKey} (valid for 1 hour). Shared by email/log too.");
    }

    public function reject(Request $request, DashboardAccessRequest $accessRequest): RedirectResponse
    {
        $accessRequest->update([
            'status' => 'rejected',
            'access_key_hash' => null,
            'access_key_expires_at' => null,
            'approved_by' => $request->user()->id,
        ]);

        return back()->with('success', 'Access request rejected.');
    }
}
