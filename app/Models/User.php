<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username',
        'email',
        'password',
        'fullname',
        'dob',
        'is_active',
        'role_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    /** get following user */
    public function followers()
    {
        return $this->hasMany(Follow::class, 'follower_id');
    }

    /** get user who is following me */
    public function followeds()
    {
        return $this->hasMany(Follow::class, 'followed_id');
    }

    protected static function boot()
    {
        parent::boot();
        static::deleting(function ($user) {
            $user->image()->delete();

            foreach ($user->reviews()->get() as $review) {
                $review->delete();
            }

            foreach ($user->likes()->get() as $like) {
                $like->delete();
            }

            foreach ($user->favorites()->get() as $favorite) {
                $favorite->delete();
            }

            foreach ($user->followers()->get() as $follower) {
                $follower->delete();
            }

            foreach ($user->followeds()->get() as $followed) {
                $followed->delete();
            }
        });
    }

    public function receivesBroadcastNotificationsOn()
    {
        return [
            'users.' . $this->id,
            'favorite_book.' . $this->id,
        ];
    }
}
