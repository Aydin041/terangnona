<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PeringatanKeamananLogin extends Mailable
{
    use Queueable, SerializesModels;

    public string $guard;
    public string $emailTarget;
    public string $ipAddress;
    public string $waktu;

    public function __construct(string $guard, string $emailTarget, string $ipAddress)
    {
        $this->guard = $guard;
        $this->emailTarget = $emailTarget;
        $this->ipAddress = $ipAddress;
        $this->waktu = now()->locale('id')->isoFormat('D MMMM YYYY, HH:mm:ss') . ' WIB';
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '[TERANG NONA - Keamanan] Peringatan Percobaan Login Mencurigakan (' . ucfirst($this->guard) . ')',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.admin.peringatan-keamanan',
            with: [
                'guard' => $this->guard,
                'emailTarget' => $this->emailTarget,
                'ipAddress' => $this->ipAddress,
                'waktu' => $this->waktu,
            ],
        );
    }
}
