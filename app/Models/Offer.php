<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use App\Models\SaveOffer;
use App\Models\Like;

class Offer extends Model
{
    use HasFactory;

    // Table
    protected $table = 'dn_offers';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'thumbnail',
        'images',
        'description',
        'offer_expiration',
        'category_id',
        'store_id',
        'offer_id',
        'status'
    ];

    // Casts
    protected $casts = [
        'images' => 'array'
    ];

    /**
     * Get the store that owns the highlight.
     */
    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    /**
     * Get the category that owns the highlight.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Check if the post is liked by the authenticated user.
     *
     * @return bool
     */
    public function isLike()
    {
        if (Auth::check()) {
            return Like::where('content_type', 'offer')
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
        return $this->hasMany(Like::class, 'content_id')->where('content_type', 'offer');
    }

    /**
     * Check if the offer is saved by the authenticated user.
     *
     * @return bool
     */
    public function isSave()
    {
        if (Auth::check()) {
            return SaveOffer::where('offer_id', $this->id)
                ->where('user_id', Auth::id())
                ->exists();
        }
        return false;
    }


    /**
     * Get the comments associated with the post.
     */
    public function comments()
    {
        return $this->hasMany(Comment::class, 'content_id')->where('content_type', 'offer');
    }
}
