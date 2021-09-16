<?php

namespace Tests\Unit;

use App\Models\Role;
use App\Models\User;
use Tests\ModelTestCase;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RoleTest extends ModelTestCase
{
    protected $role;

    public function setUp(): void
    {
        parent::setUp();
        $this->role = new Role();
    }

    public function tearDown(): void
    {
        unset($this->role);
        parent::tearDown();
    }

    public function testModelConfiguration()
    {
        $fillable = ['name'];

        $this->assertEquals($fillable, $this->role->getFillable());
    }

    public function testRoleHasManyUsers()
    {
        $relation = $this->role->users();

        $this->assertInstanceOf(HasMany::class, $relation, 'Relation is wrong');
        $this->assertInstanceOf(User::class, $relation->getRelated(), 'Related model is wrong');
        $this->assertEquals('role_id', $relation->getForeignKeyName(), 'Foreign key is wrong');
    }
}
