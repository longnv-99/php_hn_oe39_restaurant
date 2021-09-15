<?php

namespace Tests\Unit;

use App\Models\Category;
use Tests\ModelTestCase;

class CategoryTest extends ModelTestCase
{
    protected $category;

    public function setUp(): void
    {
        parent::setUp();
        $this->category = new Category();
    }

    public function tearDown(): void
    {
        unset($this->category);
        parent::tearDown();
    }

    public function testModelConfiguration()
    {
        $fillable = [
            'name',
            'description',
            'parent_id',
        ];

        $this->assertEquals($fillable, $this->category->getFillable());
    }

    public function testBooksRelation()
    {
        $relation = $this->category->books();

        $this->assertHasManyRelation($relation, $this->category);
    }
}
