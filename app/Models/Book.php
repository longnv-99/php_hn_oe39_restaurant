<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Book extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'author',
        'number_of_page',
        'published_date',
        'category_id',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    public function likes()
    {
        return $this->morphMany(Like::class, 'likeable');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    protected static function boot()
    {
        parent::boot();
        static::deleting(function ($book) {
            $book->image()->delete();

            foreach ($book->reviews->get() as $review) {
                $review->delete();
            }

            foreach ($book->likes()->get() as $like) {
                $like->delete();
            }

            foreach ($book->favorites()->get() as $favorite) {
                $favorite->delete();
            }
        });
    }
}
