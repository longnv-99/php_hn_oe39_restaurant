<?php

namespace Tests\Unit\Http\Controllers;

use Tests\TestCase;
use Mockery;
use App\Models\Comment;
use App\Models\User;
use App\Models\Review;
use App\Http\Controllers\CommentController;
use App\Repositories\Comment\CommentRepository;
use App\Http\Requests\CreateCommentRequest;
use App\Http\Requests\EditCommentRequest;
use Illuminate\Http\Request;
use Illuminate\Database\Connection;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Gate;
use Illuminate\Auth\Access\Response as AccessResponse;

/**
 * Test cases:
 * @method testStoreNewComment
 * @method testUpdateComment
 * @method testDeleteComment
 * @method testHideComment
 * @method testHideUnexistedComment
 * @method testViewComment
 * @method testViewUnexistedComment
 */
class CommentControllerTest extends TestCase
{
    protected $commentRepoMock;
    protected $commentController;

    public function setUp(): void
    {
        parent::setUp();

        $this->commentRepoMock = Mockery::mock(CommentRepository::class);
        $this->commentController = new CommentController($this->commentRepoMock);
    }

    public function tearDown(): void
    {
        Mockery::close();
        $this->commentRepoMock = null;
        $this->commentController = null;

        parent::tearDown();
    }

    public function testStoreNewComment()
    {
        // Init models
        $user = User::factory()->make(['id' => 1]);
        $this->be($user);
        $review = Review::factory()->make(['id' => 1]);
        $request = new CreateCommentRequest([
            'content' => Comment::factory()->make()->content,
            'review_id' => $review->id,
        ]);
        $data = $request->all();
        $data['display'] = config('app.display');
        $data['user_id'] = $user->id;

        // Mock
        $this->commentRepoMock
            ->shouldReceive('create')
            ->once()
            ->with($data);

        // Test
        $response = $this->commentController->store($request);
        $this->assertInstanceOf(RedirectResponse::class, $response);
        $this->assertEquals(Session::get('success'), __('messages.create-comment-success'));
    }

    public function testUpdateComment()
    {
        // Init models
        $user = User::factory()->make(['id' => 1]);
        $review = Review::factory()->make(['id' => 1]);
        $comment = Comment::factory()->make([
            'id' => 1,
            'user_id' => $user->id,
            'review_id' => $review->id,
        ]);
        $request = new EditCommentRequest([
            'content' => Comment::factory()->make()->content,
        ]);

        // Mock
        $this->commentRepoMock
            ->shouldReceive('update')
            ->once()
            ->with($comment->id, $request->all());
        Gate::shouldReceive('authorize')
            ->once()
            ->with('update', $comment)
            ->andReturn(new AccessResponse(true));

        // Test
        $response = $this->commentController->update($request, $comment);
        $this->assertInstanceOf(RedirectResponse::class, $response);
        $this->assertEquals(Session::get('success'), __('messages.edit-comment-success'));
    }

    public function testDeleteComment()
    {
        // Init models
        $user = User::factory()->make(['id' => 1]);
        $review = Review::factory()->make(['id' => 1]);
        $comment = Comment::factory()->make([
            'id' => 1,
            'user_id' => $user->id,
            'review_id' => $review->id
        ]);

        // Mock
        $this->commentRepoMock
            ->shouldReceive('delete')
            ->once()
            ->with($comment->id);
        Gate::shouldReceive('authorize')
            ->once()
            ->with('delete', $comment)
            ->andReturn(new AccessResponse(true));
        
        // Test
        $response = $this->commentController->destroy($comment);
        $this->assertInstanceOf(RedirectResponse::class, $response);
        $this->assertEquals(Session::get('success'), __('messages.delete-comment-success'));
    }

    public function testHideComment()
    {
        // Init models
        $user = User::factory()->make(['id' => 1]);
        $review = Review::factory()->make(['id' => 1]);
        $comment = Comment::factory()->make([
            'id' => 1,
            'user_id' => $user->id,
            'review_id' => $review->id
        ]);

        // Mock
        $this->commentRepoMock
            ->shouldReceive('hideComment')
            ->once()
            ->with($comment->id);
        $this->commentRepoMock
            ->shouldReceive('find')
            ->once()
            ->with($comment->id);

        // Test
        $response = $this->commentController->hide($comment->id);
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals($response->getData(), (object) [
            'success' => __('messages.hide-comment-success')
        ]);
    }

    public function testHideUnexistedComment()
    {
        $unexistedCommentId = 2;

        // Set up mock
        $this->commentRepoMock
            ->shouldReceive('find')
            ->once()
            ->with($unexistedCommentId)
            ->andThrow(ModelNotFoundException::class);

        // Test
        $this->expectException(ModelNotFoundException::class);
        $this->commentController->hide($unexistedCommentId);
    }

    public function testViewComment()
    {
        // Init models
        $user = User::factory()->make(['id' => 1]);
        $review = Review::factory()->make(['id' => 1]);
        $comment = Comment::factory()->make([
            'id' => 1,
            'user_id' => $user->id,
            'review_id' => $review->id
        ]);

        // Mock
        $this->commentRepoMock
            ->shouldReceive('showComment')
            ->once()
            ->with($comment->id);
        $this->commentRepoMock
            ->shouldReceive('find')
            ->once()
            ->with($comment->id);

        // Test
        $response = $this->commentController->view($comment->id);
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals($response->getData(), (object) [
            'success' => __('messages.show-comment-success')
        ]);
    }

    public function testViewUnexistedComment()
    {
        $unexistedCommentId = 2;

        // Set up mock
        $this->commentRepoMock
            ->shouldReceive('find')
            ->once()
            ->with($unexistedCommentId)
            ->andThrow(ModelNotFoundException::class);

        // Test
        $this->expectException(ModelNotFoundException::class);
        $this->commentController->view($unexistedCommentId);
    }
}
