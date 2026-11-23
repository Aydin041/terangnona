<?php

namespace App\Mail;

use App\Models\Pengajuan;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PengajuanTandaTerima extends Mailable
{
    use Queueable, SerializesModels;

    public Pengajuan $pengajuan;

    public function __construct(Pengajuan $pengajuan)
    {
        $this->pengajuan = $pengajuan;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '[TERANG NONA] Tanda Terima Pengajuan – ' . $this->pengajuan->nama_inovasi,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.pengajuan.tanda-terima',
            with: [
                'pengajuan' => $this->pengajuan,
            ],
        );
    }
}
