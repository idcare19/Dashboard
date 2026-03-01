<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class ContactApiController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:255'],
            'message' => ['required', 'string', 'max:5000'],
        ]);

        if (! Schema::hasTable('contact_messages')) {
            return response()->json([
                'success' => false,
                'message' => 'Contact service is not ready. Run migrations on the backend.',
            ], 503);
        }

        ContactMessage::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Message sent successfully.',
        ], 201);
    }
}
