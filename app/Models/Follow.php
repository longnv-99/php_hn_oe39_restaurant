<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Follow extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'followed_id',
        'follower_id',
    ];

    public function follower()
    {
        return $this->belongsTo(User::class);
    }

    public function followed()
    {
        return $this->belongsTo(User::class);
    }
}
