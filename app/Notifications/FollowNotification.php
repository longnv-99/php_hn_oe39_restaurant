<?php

namespace App\Notifications;

use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class FollowNotification extends Notification
{
    use Queueable;

    protected $user;
    protected $followed_user;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($user, $followed_user)
    {
        $this->user = $user;
        $this->followed_user = $followed_user;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database', 'broadcast'];
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
            'id' => $this->id,
            'user' => $this->user,
        ];
    }

    public function broadcastOn()
    {
        return new PrivateChannel('users.' . $this->followed_user->id);
    }
}
