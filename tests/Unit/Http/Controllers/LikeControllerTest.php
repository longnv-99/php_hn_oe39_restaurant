<?php

namespace Tests\Unit;

use App\Http\Controllers\LikeController;
use App\Models\Book;
use App\Models\User;
use App\Repositories\Like\LikeRepository;
use Illuminate\Http\Request;
use Tests\TestCase;
use Mockery;

class LikeControllerTest extends TestCase
{
    protected $likeRepoMock;
    protected $likeController;

    protected function setUp(): void
    {
        parent::setUp();
        $this->likeRepoMock = Mockery::mock(LikeRepository::class);
        $this->likeController = new LikeController($this->likeRepoMock);
    }

    public function tearDown():void
    {
        Mockery::close();
        unset($likeRepoMock);
        unset($likeController);
        parent::tearDown();
    }

    public function testStoreFunction()
    {
        $book = Book::factory()->make(['id' => 1]);
        $user = User::factory()->make(['id' => 1]);
        $this->be($user);
        $data = [
            'user_id' => $user->id,
            'likeable_id' => $book->id,
            'likeable_type' => 'App\Models\Book',
        ];

        $this->likeRepoMock
            ->shouldReceive('create')
            ->once()
            ->with($data);
        
        $request = new Request();
        $request['book_id'] = $book->id;
        $response = $this->likeController->store($request);
        $this->assertJson($response);
        $this->assertJsonStringEqualsJsonString('{"statusCode":200}', $response);
    }

    public function testDestroyFunction()
    {
        $book = Book::factory()->make(['id' => 1]);
        $user = User::factory()->make(['id' => 1]);
        $this->be($user);
        $this->likeRepoMock
            ->shouldReceive('dislikeBookOrReview')
            ->once()
            ->with($book->id, get_class($book), $user->id);
        
        $response = $this->likeController->destroy($book->id);
        $this->assertJson($response);
        $this->assertJsonStringEqualsJsonString('{"statusCode":200}', $response);
    }
}
