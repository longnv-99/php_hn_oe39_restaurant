<?php

namespace Tests\Unit;

use App\Http\Controllers\UserController;
use App\Models\Follow;
use App\Models\Review;
use App\Models\User;
use App\Repositories\Follow\FollowRepository;
use App\Repositories\Review\ReviewRepository;
use App\Repositories\User\UserRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Mockery;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    protected $userRepoMock;
    protected $followRepoMock;
    protected $reviewRepoMock;
    protected $userController;

    public function setUp(): void
    {
        parent::setUp();
        $this->userRepoMock = Mockery::mock(UserRepository::class);
        $this->followRepoMock = Mockery::mock(FollowRepository::class);
        $this->reviewRepoMock = Mockery::mock(ReviewRepository::class);
        $this->userController = new UserController(
            $this->userRepoMock,
            $this->followRepoMock,
            $this->reviewRepoMock
        );
    }

    public function tearDown(): void
    {
        Mockery::close();
        $this->userRepoMock = null;
        $this->followRepoMock = null;
        $this->reviewRepoMock = null;
        $this->userController = null;
        parent::tearDown();
    }

    public function testIndexReturnView()
    {
        $users = User::factory()->count(5)->make();

        $this->userRepoMock
            ->shouldReceive('getUsersIsNotAdmin')
            ->once()
            ->andReturn($users);

        $view = $this->userController->index();
        $data = $view->getData();

        $this->assertEquals('admin.users.index', $view->getName());
        $this->assertIsArray($data);
        $this->assertArrayHasKey('users', $data);
    }

    public function testShowReturnView()
    {
        $user = User::factory()->make(['id' => 1]);
        $relationship = Follow::factory()
            ->make([
                'follower_id' => Auth::id(),
                'followed_id' => $user->id,
            ]);
        $reviews = Review::factory()
            ->count(5)
            ->make([
                'user_id' => $user->id,
                'book_id' => 1,
            ]);

        $this->userRepoMock
            ->shouldReceive('showUserProfile')
            ->once()
            ->with($user->id)
            ->andReturn($user);
        
        $this->followRepoMock
            ->shouldReceive('getRelationship')
            ->once()
            ->with($user->id)
            ->andReturn($relationship);

        $this->reviewRepoMock
            ->shouldReceive('getReviewsHistory')
            ->once()
            ->with($user->id)
            ->andReturn($reviews);
        
        $view = $this->userController->show($user->id);
        $data = $view->getData();

        $this->assertEquals('user.profile', $view->getName());
        $this->assertIsArray($data);
        $this->assertArrayHasKey('user', $data);
        $this->assertArrayHasKey('relationship', $data);
        $this->assertArrayHasKey('reviews', $data);
    }

    public function testChangeUserStatusFromActiveToInactive()
    {
        $user = User::factory()->make(['id' => 1]);
        $status = config('app.is_active');

        $this->userRepoMock
            ->shouldReceive('changeUserStatus')
            ->once()
            ->with($user->id, $status);

        $response = $this->userController->changeUserStatus($user->id, $status);

        $this->assertInstanceOf(RedirectResponse::class, $response);
        $this->assertEquals(route('users.index'), $response->getTargetUrl());
    }
    
    public function testChangeUserStatusFromInactiveToActive()
    {
        $user = User::factory()->make(['id' => 1]);
        $status = config('app.is_inactive');

        $this->userRepoMock
            ->shouldReceive('changeUserStatus')
            ->once()
            ->with($user->id, $status);

        $response = $this->userController->changeUserStatus($user->id, $status);

        $this->assertInstanceOf(RedirectResponse::class, $response);
        $this->assertEquals(route('users.index'), $response->getTargetUrl());
    }

    public function testDestroyUser()
    {
        $user = User::factory()->make(['id' => 1]);

        $this->userRepoMock
            ->shouldReceive('delete')
            ->once()
            ->with($user->id);

        $response = $this->userController->destroy($user->id);
        
        $this->assertInstanceOf(RedirectResponse::class, $response);
        $this->assertEquals(route('users.index'), $response->getTargetUrl());
    }
}
