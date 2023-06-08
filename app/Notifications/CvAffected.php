<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CvAffected extends Notification
{
    use Queueable;

    public $cv;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($cv)
    {
        $this->cv = $cv;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->from('test@gmail.com', 'Mon Application')
                    ->subject('Tu as une nouvelle demande de cv à finir')
                    ->line("La demande de cv (#" . $this->cv->id . ") '" . $this->cv->name . "' vient de vous être affecté par " . $this->cv->cvAffectedBy->name . ".")
                    ->action('Voir toutes mes demande de cv', url('/cvs'))
                    ->line("Merci bien !");
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'type' => 'App\Notifications\CvAffected',
            'cv_id' => $this->cv->id,
            'affected_by' => $this->cv->cvAffectedBy->name,
            'cv_name' => $this->cv->name,
        ];
    }
}
