<?php

use Illuminate\Support\Facades\Http;

if (!function_exists('sendWhatsapp')) {
    function sendWhatsapp(string $phone, string $message): void
    {
        Http::withHeaders([
            'Authorization' => config('services.fonnte.token'),
        ])->post('https://api.fonnte.com/send', [
            'target'  => $phone,
            'message' => $message,
        ]);
    }
}