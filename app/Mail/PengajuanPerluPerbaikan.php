<?php

namespace App\Mail;

use App\Models\Pengajuan;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PengajuanPerluPerbaikan extends Mailable
{
    use Queueable, SerializesModels;

    public Pengajuan $pengajuan;
    public string $catatan;

    public function __construct(Pengajuan $pengajuan, string $catatan)
    {
        $this->pengajuan = $pengajuan;
        $this->catatan   = $catatan;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '[TERANG NONA] Pengajuan Perlu Perbaikan – ' . $this->pengajuan->nama_inovasi,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.pengajuan.perlu-perbaikan',
            with: [
                'pengajuan' => $this->pengajuan,
                'catatan'   => $this->catatan,
            ],
        );
    }
}
