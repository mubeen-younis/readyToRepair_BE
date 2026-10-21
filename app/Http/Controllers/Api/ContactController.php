<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Throwable;

class ContactController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['nullable', 'email', 'max:190'],
            'phone' => ['nullable', 'string', 'max:40'],
            'message' => ['required', 'string', 'max:5000'],
        ]);

        $to = (string) config('mail.contact_to');

        if ($to === '') {
            return response()->json([
                'error' => 'Contact inbox is not configured.',
            ], 500);
        }

        $name = trim($validated['name']);
        $email = isset($validated['email']) ? trim((string) $validated['email']) : '';
        $phone = isset($validated['phone']) ? trim((string) $validated['phone']) : '';
        $messageBody = trim($validated['message']);

        $lines = [
            "Name: {$name}",
            $email !== '' ? "Email: {$email}" : 'Email: (not provided)',
            $phone !== '' ? "Phone: {$phone}" : 'Phone: (not provided)',
            '',
            $messageBody,
        ];

        try {
            Mail::raw(implode("\n", $lines), function ($message) use ($to, $name, $email) {
                $message
                    ->to($to)
                    ->subject("Website inquiry from {$name}");

                if ($email !== '') {
                    $message->replyTo($email, $name);
                }
            });
        } catch (Throwable $e) {
            report($e);

            return response()->json([
                'error' => 'Unable to send your message right now. Please try again shortly.',
            ], 502);
        }

        return response()->json(['ok' => true]);
    }
}
