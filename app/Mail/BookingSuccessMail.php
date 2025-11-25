<?php

namespace App\Mail;

use App\Models\Booking; // Jangan lupa import Model Booking
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use SimpleSoftwareIO\QrCode\Facades\QrCode; // Import facade QrCode

class BookingSuccessMail extends Mailable
{
    use Queueable, SerializesModels;

    // Property untuk menampung data booking
    public $booking;

    /**
     * Create a new message instance.
     */
    public function __construct(Booking $booking)
    {
        // Menerima data booking saat class ini dipanggil
        $this->booking = $booking;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            // Subjek Email yang akan muncul di inbox warga
            subject: 'Bukti Booking Janji Temu - SiPentas Kel. Klender',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            // Mengarahkan ke view yang kita buat tadi
            view: 'emails.booking_success',
        );
    }

    /**
     * Get the attachments for the message.
     * (Kita tidak pakai attachment file terpisah, QR code di-embed langsung di view)
     */
    public function attachments(): array
    {
        return [];
    }
}