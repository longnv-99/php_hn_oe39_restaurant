<?php

namespace Tests\Unit\Jobs;

use App\Jobs\SendEmailFavoriteBook;
use App\Mail\MailNotifyFavoriteBook;
use App\Models\Book;
use App\Models\User;
use App\Repositories\Book\BookRepository;
use App\Repositories\Favorite\FavoriteRepository;
use App\Repositories\User\UserRepository;
use Illuminate\Support\Facades\Mail;
use Mockery;
use Tests\TestCase;

class SendEmailFavoriteBookTest extends TestCase
{
    protected $userRepoMock;
    protected $bookRepoMock;
    protected $favoriteRepoMock;
    protected $sendEmailFavoriteBook;

    public function setUp(): void
    {
        parent::setUp();
        $this->userRepoMock = Mockery::mock(UserRepository::class);
        $this->bookRepoMock = Mockery::mock(BookRepository::class);
        $this->favoriteRepoMock = Mockery::mock(FavoriteRepository::class);
        $this->sendEmailFavoriteBook = new SendEmailFavoriteBook();
    }

    public function tearDown(): void
    {
        $this->userRepoMock = null;
        $this->bookRepoMock = null;
        $this->favoriteRepoMock = null;
        $this->sendEmailFavoriteBook = null;
        parent::tearDown();
    }

    public function testHandle()
    {
        $userIds = [1, 2, 3, 4, 5];
        $user = User::factory()->make(['id' => 1]);
        $books = Book::factory()->count(5)->make();

        $this->favoriteRepoMock
            ->shouldReceive('getUserIdsMarkFavorite')
            ->once()
            ->andReturn($userIds);
        $this->userRepoMock
            ->shouldReceive('find')
            ->andReturn($user);
        $this->bookRepoMock
            ->shouldReceive('getFavoriteBooksByUserId')
            ->andReturn($books);

        Mail::fake();
        $this->sendEmailFavoriteBook->handle(
            $this->userRepoMock,
            $this->bookRepoMock,
            $this->favoriteRepoMock
        );
        Mail::assertSent(MailNotifyFavoriteBook::class, function ($mail) use ($user) {
            return $mail->hasTo($user);
        });
    }
}
