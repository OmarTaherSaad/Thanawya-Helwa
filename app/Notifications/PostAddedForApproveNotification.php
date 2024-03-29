<?php

namespace App\Notifications;

use App\Models\Team\Post;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PostAddedForApproveNotification extends Notification implements ShouldQueue
{
    use Queueable;
    protected $post;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database','broadcast'];
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
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
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
            'link' => $this->post->getLinkToView(),
            'text' => $this->post->writer->name . ' wrote a new post: ' . $this->post->small_part()
        ];
    }

    public function toDatabase($notifiable)
    {
        return [
            'link' => $this->post->getLinkToView(),
            'text' => $this->post->writer->name . ' wrote a new post: ' .$this->post->small_part()
        ];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'link' => $this->post->getLinkToView(),
            'text' => $this->post->writer->name . ' wrote a new post: ' .$this->post->small_part()
        ]);
    }
}
