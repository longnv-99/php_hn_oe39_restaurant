<?php

namespace Tests\Unit;

use App\Models\Like;
use App\Models\User;
use Tests\ModelTestCase;

class LikeTest extends ModelTestCase
{
    protected $like;

    public function setUp(): void
    {
        parent::setUp();
        $this->like = new Like();
    }

    public function tearDown(): void
    {
        $this->like = null;
        parent::tearDown();
    }

    public function testModelConfiguration()
    {
        $fillable = [
            'user_id',
            'likeable_id',
            'likeable_type',
        ];

        $this->assertEquals($fillable, $this->like->getFillable());
    }

    public function testUserRelation()
    {
        $relation = $this->like->user();
        $related = new User();

        $this->assertBelongsToRelation($relation, $related);
    }

    public function testLikeableRelation()
    {
        $relation = $this->like->likeable();
        $this->assertMorphToRelation($relation, 'likeable');
    }
}
