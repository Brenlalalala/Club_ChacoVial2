<?php

namespace App\Mail;

use App\Models\Reserva;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NuevaReservaSolicitud extends Mailable
{
    use Queueable, SerializesModels;

    public $reserva;

    public function __construct(Reserva $reserva)
    {
        $this->reserva = $reserva;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '🔔 Nueva Reserva Pendiente #' . $this->reserva->id,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.nueva-reserva-admin',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}