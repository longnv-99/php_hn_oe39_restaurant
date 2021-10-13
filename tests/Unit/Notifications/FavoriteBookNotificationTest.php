<?php

namespace Tests\Unit\Notifications;

use App\Models\Book;
use App\Models\User;
use App\Notifications\FavoriteBookNotification;
use Illuminate\Broadcasting\PrivateChannel;
use Tests\TestCase;

class FavoriteBookNotificationTest extends TestCase
{
    protected $user;
    protected $book;
    protected $notification;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->make();
        $this->book = Book::factory()->make();
        $this->notification = new FavoriteBookNotification(
            $this->user,
            $this->book
        );
    }

    public function tearDown(): void
    {
        $this->user = null;
        $this->book = null;
        $this->notification = null;
        parent::tearDown();
    }

    public function testVia()
    {
        $expectedChannels = ['database', 'broadcast'];
        $actualChannels = $this->notification->via($this->user);

        $this->assertEqualsCanonicalizing($expectedChannels, $actualChannels);
    }

    public function testToArray()
    {
        $expectedArr = ['book' => $this->book];
        $actualArr = $this->notification->toArray($this->user);

        $this->assertEqualsCanonicalizing($expectedArr, $actualArr);
    }

    public function testBroadcastOn()
    {
        $broadcastOn = $this->notification->broadcastOn();

        $this->assertInstanceOf(PrivateChannel::class, $broadcastOn);
    }
}
