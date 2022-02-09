<?php

namespace Tests\Unit;

use App\Models\Review;
use App\Models\Book;
use App\Models\User;
use Tests\ModelTestCase;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReviewTest extends ModelTestCase
{
    protected $review;

    public function setUp(): void
    {
        parent::setUp();
        $this->review = new Review();
    }

    public function tearDown(): void
    {
        unset($this->review);
        parent::tearDown();
    }

    public function testModelConfiguration()
    {
        $fillable = [
            'content',
            'display',
            'user_id',
            'book_id',
            'rate',
        ];

        $this->assertEquals($fillable, $this->review->getFillable());
    }

    public function testReviewBelongsToUser()
    {
        $relation = $this->review->user();

        $this->assertInstanceOf(BelongsTo::class, $relation, 'Relation is wrong');
        $this->assertInstanceOf(User::class, $relation->getRelated(), 'Related model is wrong');
        $this->assertEquals('id', $relation->getOwnerKeyName(), 'Owner key is wrong');
        $this->assertEquals('user_id', $relation->getForeignKeyName(), 'Foreign key is wrong');
    }

    public function testReviewBelongsToBook()
    {
        $relation = $this->review->book();

        $this->assertInstanceOf(BelongsTo::class, $relation, 'Relation is wrong');
        $this->assertInstanceOf(Book::class, $relation->getRelated(), 'Related model is wrong');
        $this->assertEquals('id', $relation->getOwnerKeyName(), 'Owner key is wrong');
        $this->assertEquals('book_id', $relation->getForeignKeyName(), 'Foreign key is wrong');
    }
    
    public function testReviewMorphManyLikes()
    {
        $relation = $this->review->likes();

        $this->assertInstanceOf(MorphMany::class, $relation, 'Relation is wrong');
        $this->assertEquals('likeable_type', $relation->getMorphType());
        $this->assertEquals('likeable_id', $relation->getForeignKeyName());
    }
}
