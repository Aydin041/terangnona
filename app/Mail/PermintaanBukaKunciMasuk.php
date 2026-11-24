<?php

namespace App\Mail;

use App\Models\PermintaanBukaKunci;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PermintaanBukaKunciMasuk extends Mailable
{
    use Queueable, SerializesModels;

    public PermintaanBukaKunci $permintaan;

    public function __construct(PermintaanBukaKunci $permintaan)
    {
        $this->permintaan = $permintaan;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '[TERANG NONA - Admin] Permintaan Buka Kunci Nilai dari ' . ($this->permintaan->juri->nama ?? 'Juri'),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.admin.permintaan-buka-kunci',
            with: [
                'permintaan' => $this->permintaan,
            ],
        );
    }
}
