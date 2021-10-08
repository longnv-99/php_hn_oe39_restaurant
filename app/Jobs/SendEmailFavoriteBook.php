<?php

namespace App\Jobs;

use App\Mail\MailNotifyFavoriteBook;
use App\Repositories\Book\BookRepositoryInterface;
use App\Repositories\Favorite\FavoriteRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendEmailFavoriteBook implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
       //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(
        UserRepositoryInterface $userRepo,
        BookRepositoryInterface $bookRepo,
        FavoriteRepositoryInterface $favoriteRepo
    ) {
        $userIds = $favoriteRepo->getUserIdsMarkFavorite();
        foreach ($userIds as $user_id) {
            $user = $userRepo->find($user_id);
            $favoriteBooks = $bookRepo->getFavoriteBooksByUserId($user_id);
            Mail::to($user)
                ->send(new MailNotifyFavoriteBook($user, $favoriteBooks));
        }
    }
}
