<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class ContactMessageController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:255'],
            'message' => ['required', 'string', 'max:5000'],
        ]);

        if (! Schema::hasTable('contact_messages')) {
            return redirect()
                ->to(route('portfolio') . '#contact')
                ->withErrors([
                    'contact' => 'Contact form is temporarily unavailable. Please try again after running migrations.',
                ])
                ->withInput();
        }

        try {
            ContactMessage::create($validated);
        } catch (\Throwable) {
            return redirect()
                ->to(route('portfolio') . '#contact')
                ->withErrors([
                    'contact' => 'Could not send your message right now. Please try again in a moment.',
                ])
                ->withInput();
        }

        return redirect()
            ->to(route('portfolio') . '#contact')
            ->with('contact_success', 'Message sent successfully ✅');
    }
}
