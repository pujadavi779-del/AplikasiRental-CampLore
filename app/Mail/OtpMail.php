<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OtpMail extends Mailable
{
    use Queueable, SerializesModels;

    public string $otpCode;
    public string $expiryMinutes;

    public function __construct(string $otpCode, int $expirySeconds = 60)
    {
        $this->otpCode      = $otpCode;
        $this->expiryMinutes = $expirySeconds >= 60
            ? ($expirySeconds / 60) . ' menit'
            : $expirySeconds . ' detik';
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '[Camplore] Kode Verifikasi OTP Anda',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'pages.login.otp',
        );
    }
}