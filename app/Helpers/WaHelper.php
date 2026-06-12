<?php

use Illuminate\Support\Facades\Http;

if (!function_exists('sendWhatsapp')) {
    function sendWhatsapp(string $phone, string $message): void
    {
        // Normalisasi nomor ke format 62xxxxxxxxxx
        $phone = preg_replace('/[^0-9]/', '', $phone);
        if (str_starts_with($phone, '0')) {
            $phone = '62' . substr($phone, 1);
        } elseif (str_starts_with($phone, '+62')) {
            $phone = substr($phone, 1);
        }

        $response = Http::withHeaders([
            'Authorization' => config('services.fonnte.token'),
        ])->post('https://api.fonnte.com/send', [
            'target'  => $phone,
            'message' => $message,
        ]);

        \Log::info('Fonnte response', [
            'target' => $phone,
            'status' => $response->status(),
            'body'   => $response->body(),
        ]);
    }
}