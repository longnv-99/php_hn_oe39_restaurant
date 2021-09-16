<?php

namespace Tests\Unit;

use App\Models\Role;
use App\Models\User;
use Tests\ModelTestCase;

class UserTest extends ModelTestCase
{
    protected $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = new User();
    }

    public function tearDown(): void
    {
        $this->user = null;
        parent::tearDown();
    }

    public function testModelConfiguration()
    {
        $fillable = [
            'username',
            'email',
            'password',
            'fullname',
            'dob',
            'is_active',
            'role_id',
        ];

        $hidden = [
            'password',
            'remember_token',
        ];

        $casts = [
            'email_verified_at' => 'datetime',
            'deleted_at' => 'datetime',
            'id' => 'int',
        ];

        $this->assertEquals($fillable, $this->user->getFillable());
        $this->assertEquals($hidden, $this->user->getHidden());
        $this->assertEquals($casts, $this->user->getCasts());
    }

    public function testRoleRelation()
    {
        $relation = $this->user->role();
        $related = new Role();
        $this->assertBelongsToRelation($relation, $related);
    }

    public function testImageRelation()
    {
        $relation = $this->user->image();
        $this->assertMorphOneRelation($relation, 'imageable');
    }

    public function testReviewsRelation()
    {
        $relation = $this->user->reviews();
        $this->assertHasManyRelation($relation, $this->user);
    }

    public function testCommentsRelation()
    {
        $relation = $this->user->comments();
        $this->assertHasManyRelation($relation, $this->user);
    }

    public function testFavoritesRelation()
    {
        $relation = $this->user->favorites();
        $this->assertHasManyRelation($relation, $this->user);
    }

    public function testLikesRelation()
    {
        $relation = $this->user->likes();
        $this->assertHasManyRelation($relation, $this->user);
    }

    public function testFollowersRelation()
    {
        $relation = $this->user->followers();
        $this->assertHasManyRelation($relation, $this->user, 'follower_id');
    }

    public function testFollowedsRelation()
    {
        $relation = $this->user->followeds();
        $this->assertHasManyRelation($relation, $this->user, 'followed_id');
    }
}
