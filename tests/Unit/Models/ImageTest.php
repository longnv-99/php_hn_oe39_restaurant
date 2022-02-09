<?php

namespace Tests\Unit;

use App\Models\Image;
use Tests\ModelTestCase;

class ImageTest extends ModelTestCase
{
    protected $image;

    public function setUp(): void
    {
        parent::setUp();
        $this->image = new Image();
    }

    public function tearDown(): void
    {
        $this->image = null;
        parent::tearDown();
    }

    public function testModelConfiguration()
    {
        $fillable = [
            'path',
            'imageable_type',
            'imageable_id',
        ];

        $this->assertEquals($fillable, $this->image->getFillable());
    }

    public function testImageableRelation()
    {
        $relation = $this->image->imageable();
        $this->assertMorphToRelation($relation, 'imageable');
    }
}
