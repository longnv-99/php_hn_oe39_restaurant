<?php

namespace Tests\Unit;

use App\Models\Book;
use App\Models\Favorite;
use App\Models\User;
use Tests\ModelTestCase;

class FavoriteTest extends ModelTestCase
{
    protected $favorite;

    public function setUp(): void
    {
        parent::setUp();
        $this->favorite = new Favorite();
    }

    public function tearDown(): void
    {
        $this->favorite = null;
        parent::tearDown();
    }

    public function testModelConfiguration()
    {
        $fillable = [
            'user_id',
            'book_id',
        ];

        $this->assertEquals($fillable, $this->favorite->getFillable());
    }

    public function testUserRelation()
    {
        $relation = $this->favorite->user();
        $related = new User();
        $this->assertBelongsToRelation($relation, $related);
    }

    public function testBookRelation()
    {
        $relation = $this->favorite->book();
        $related = new Book();
        $this->assertBelongsToRelation($relation, $related);
    }
}
