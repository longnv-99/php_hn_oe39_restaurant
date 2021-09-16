<?php

namespace Tests\Unit;

use App\Models\Follow;
use App\Models\User;
use Tests\ModelTestCase;

class FollowTest extends ModelTestCase
{
    protected $follow;

    public function setUp(): void
    {
        parent::setUp();
        $this->follow = new Follow();
    }

    public function tearDown(): void
    {
        unset($this->follow);
        parent::tearDown();
    }

    public function testModelConfiguration()
    {
        $fillable = ['followed_id', 'follower_id'];

        $this->assertEquals($fillable, $this->follow->getFillable());
    }

    public function testFollowerRelation()
    {
        $relation = $this->follow->follower();

        $this->assertBelongsToRelation($relation, new User(), 'follower_id');
    }

    public function testFollowedRelation()
    {
        $relation = $this->follow->followed();

        $this->assertBelongsToRelation($relation, new User(), 'followed_id');
    }
}
