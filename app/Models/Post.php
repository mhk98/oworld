<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use App\Models\Like;

class Post extends Model
{
    use HasFactory;

    // Table
    protected $table = 'dn_posts';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'images',
        'thumbnail',
        'description',
        'store_id',
        'pin_post',
        'post_id',
        'status'
    ];

    // Casts
    protected $casts = [
        'images' => 'array'
    ];

    /**
     * Get the store that owns the billboard.
     */
    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    /**
     * Check if the post is liked by the authenticated user.
     *
     * @return bool
     */
    public function isLike()
    {
        if (Auth::check()) {
            return Like::where('content_type', 'post')
                ->where('content_id', $this->id)
                ->where('user_id', Auth::id())
                ->exists();
        }
        return false;
    }

    /**
     * Get the likes associated with the post.
     */
    public function likes()
    {
        return $this->hasMany(Like::class, 'content_id')->where('content_type', 'post');
    }

    /**
     * Get the comments associated with the post.
     */
    public function comments()
    {
        return $this->hasMany(Comment::class, 'content_id')->where('content_type', 'post');
    }
}
