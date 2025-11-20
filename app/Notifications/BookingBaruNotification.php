<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BookingBaruNotification extends Notification
{
    use Queueable;

    public $booking;

    /**
     * Create a new notification instance.
     */
    public function __construct($booking)
    {
        $this->booking = $booking;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via(object $notifiable): array
    {
        return ['database']; // Kita simpan ke database saja
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray(object $notifiable): array
    {
        return [
            'booking_id' => $this->booking->id,
            'no_booking' => $this->booking->no_booking,
            'nama_pemohon' => $this->booking->warga->nama_lengkap,
            'layanan' => $this->booking->layanan->nama_layanan,
            'pesan' => 'Booking baru masuk: ' . $this->booking->no_booking,
            'waktu' => now()->diffForHumans(),
        ];
    }
}