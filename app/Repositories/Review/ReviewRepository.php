<?php

namespace App\Repositories\Review;

use App\Models\Review;
use App\Repositories\BaseRepository;

class ReviewRepository extends BaseRepository implements ReviewRepositoryInterface
{
    public function getModel()
    {
        return Review::class;
    }

    public function getReviewsHistory($id)
    {
        return $this->model
            ->where('user_id', $id)
            ->where('display', config('app.display'))
            ->orderBy('updated_at', 'DESC')
            ->paginate(config('app.paginate'));
    }
}
