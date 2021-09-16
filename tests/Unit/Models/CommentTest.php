<?php

namespace Tests\Unit;

use App\Models\Review;
use App\Models\User;
use App\Models\Comment;
use Tests\ModelTestCase;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CommentTest extends ModelTestCase
{
    protected $comment;

    public function setUp(): void
    {
        parent::setUp();
        $this->comment = new Comment();
    }

    public function tearDown(): void
    {
        unset($this->comment);
        parent::tearDown();
    }

    public function testModelConfiguration()
    {
        $fillable = [
            'content',
            'display',
            'review_id',
            'user_id',
        ];

        $this->assertEquals($fillable, $this->comment->getFillable());
    }

    public function testReviewBelongsToUser()
    {
        $relation = $this->comment->user();

        $this->assertInstanceOf(BelongsTo::class, $relation, 'Relation is wrong');
        $this->assertInstanceOf(User::class, $relation->getRelated(), 'Related model is wrong');
        $this->assertEquals('id', $relation->getOwnerKeyName(), 'Owner key is wrong');
        $this->assertEquals('user_id', $relation->getForeignKeyName(), 'Foreign key is wrong');
    }

    public function testReviewBelongsToReview()
    {
        $relation = $this->comment->review();

        $this->assertInstanceOf(BelongsTo::class, $relation, 'Relation is wrong');
        $this->assertInstanceOf(Review::class, $relation->getRelated(), 'Related model is wrong');
        $this->assertEquals('id', $relation->getOwnerKeyName(), 'Owner key is wrong');
        $this->assertEquals('review_id', $relation->getForeignKeyName(), 'Foreign key is wrong');
    }
}
