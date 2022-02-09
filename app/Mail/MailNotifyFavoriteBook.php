<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MailNotifyFavoriteBook extends Mailable
{
    use Queueable, SerializesModels;

    protected $user;
    protected $favoriteBooks;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $favoriteBooks)
    {
        $this->user = $user;
        $this->favoriteBooks = $favoriteBooks;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('xuantruong120499@gmail.com')
            ->subject(__('messages.favorite-book-reviews-statistic'))
            ->markdown('emails.favorite_book_review')
            ->with([
                'user' => $this->user,
                'favoriteBooks' => $this->favoriteBooks,
            ]);
    }
}
