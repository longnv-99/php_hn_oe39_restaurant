<?php

namespace Tests\Unit;

use App\Models\Book;
use App\Models\Category;
use Tests\ModelTestCase;

class BookTest extends ModelTestCase
{
    protected $book;

    public function setUp(): void
    {
        parent::setUp();
        $this->book = new Book();
    }

    public function tearDown(): void
    {
        unset($this->book);
        parent::tearDown();
    }

    public function testModelConfiguration()
    {
        $fillable = [
            'title',
            'author',
            'number_of_page',
            'published_date',
            'category_id',
        ];

        $this->assertEquals($fillable, $this->book->getFillable());
    }

    public function testFavoritesRelation()
    {
        $relation = $this->book->favorites();

        $this->assertHasManyRelation($relation, $this->book);
    }

    public function testReviewsRelation()
    {
        $relation = $this->book->reviews();

        $this->assertHasManyRelation($relation, $this->book);
    }

    public function testCategoryRelation()
    {
        $relation = $this->book->category();

        $this->assertBelongsToRelation($relation, new Category());
    }

    public function testImageRelation()
    {
        $relation = $this->book->image();

        $this->assertMorphOneRelation($relation, 'imageable');
    }

    public function testLikesRelation()
    {
        $relation = $this->book->likes();

        $this->assertMorphManyRelation($relation, 'likeable');
    }
}
