<?php

namespace App\Repositories\Category;

use App\Models\Category;
use App\Repositories\BaseRepository;

class CategoryRepository extends BaseRepository implements CategoryRepositoryInterface
{
    public function getModel()
    {
        return Category::class;
    }

    public function getAllSubcategoriesWithBooks()
    {
        return $this->model->with('books')
            ->whereNotIn(
                'id',
                $this->model->distinct()->pluck('parent_id')->toArray()
            )->get();
    }
}
