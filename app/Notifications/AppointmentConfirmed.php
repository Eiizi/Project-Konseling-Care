<?php

namespace App\Notifications;

use App\Models\Appointment; // <-- Import Appointment
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AppointmentConfirmed extends Notification
{
    use Queueable;

    public $appointment; // Properti untuk menyimpan data appointment

    /**
     * Create a new notification instance.
     */
    public function __construct(Appointment $appointment) // Terima appointment
    {
        $this->appointment = $appointment;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via(object $notifiable): array
    {
        return ['mail']; // Kirim via email
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $patientName = $this->appointment->patient?->name ?? 'Pasien';
        $counselorName = $this->appointment->counselor?->name ?? 'Konselor';
        $scheduleTime = $this->appointment->schedule_time->isoFormat('dddd, D MMMM YYYY, HH:mm') . ' WIB';

        // Pesan berbeda untuk konselor dan admin
        if ($notifiable->role === 'counselor') {
            $greeting = "Halo {$counselorName},";
            $line1 = "Anda memiliki sesi konseling baru yang telah dikonfirmasi dengan pasien {$patientName}.";
        } else { // Anggap admin atau lainnya
             $greeting = "Halo Admin,";
             $line1 = "Sesi konseling baru antara {$patientName} dan {$counselorName} telah dikonfirmasi.";
        }

        return (new MailMessage)
                    ->subject('Konfirmasi Jadwal Sesi Konseling')
                    ->greeting($greeting)
                    ->line($line1)
                    ->line("Detail Jadwal: {$scheduleTime}")
                    ->action('Lihat Dashboard', url('/login')) // Link umum ke login
                    ->line('Terima kasih!');
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray(object $notifiable): array
    {
        return [
            'appointment_id' => $this->appointment->id,
            'message' => 'Sesi dengan ' . ($this->appointment->patient?->name ?? 'Pasien') . ' telah dikonfirmasi.',
        ];
    }
}