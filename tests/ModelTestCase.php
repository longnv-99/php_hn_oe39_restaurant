<?php

namespace Tests;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class ModelTestCase extends TestCase
{
    protected function assertHasManyRelation($relation, Model $model, $key = null, $parent = null)
    {
        $this->assertInstanceOf(HasMany::class, $relation);

        $key = $key ?? $model->getForeignKey();
        $this->assertEquals($key, $relation->getForeignKeyName());

        $parent = $parent ?? $model->getKeyName();
        $this->assertEquals($model->getTable() . '.' . $parent, $relation->getQualifiedParentKeyName());
    }

    protected function assertBelongsToRelation($relation, Model $related, $key = null, $owner = null)
    {
        $this->assertInstanceOf(BelongsTo::class, $relation);

        $key = $key ?? $related->getForeignKey();
        $this->assertEquals($key, $relation->getForeignKeyName());

        $owner = $owner ?? $related->getKeyName();
        $this->assertEquals($owner, $relation->getOwnerKeyName());
    }

    protected function assertMorphOneRelation($relation, $name)
    {
        $this->assertInstanceOf(MorphOne::class, $relation);
        $this->assertEquals($name . '_type', $relation->getMorphType());
        $this->assertEquals($name . '_id', $relation->getForeignKeyName());
    }

    protected function assertMorphManyRelation($relation, $name)
    {
        $this->assertInstanceOf(MorphMany::class, $relation);
        $this->assertEquals($name . '_type', $relation->getMorphType());
        $this->assertEquals($name . '_id', $relation->getForeignKeyName());
    }

    protected function assertMorphToRelation($relation, $name)
    {
        $this->assertInstanceOf(MorphTo::class, $relation);
        $this->assertEquals($name . '_type', $relation->getMorphType());
        $this->assertEquals($name . '_id', $relation->getForeignKeyName());
    }
}
