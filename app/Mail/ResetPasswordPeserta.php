<?php

namespace App\Mail;

use App\Models\Peserta;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ResetPasswordPeserta extends Mailable
{
    use Queueable, SerializesModels;

    public Peserta $peserta;
    public string $resetUrl;

    public function __construct(Peserta $peserta, string $resetUrl)
    {
        $this->peserta = $peserta;
        $this->resetUrl = $resetUrl;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '[TERANG NONA] Permintaan Reset Kata Sandi Akun Peserta',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.auth.reset-password-peserta',
            with: [
                'peserta' => $this->peserta,
                'resetUrl' => $this->resetUrl,
            ],
        );
    }
}
