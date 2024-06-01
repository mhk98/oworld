<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use App\Models\Like;

class FeaturedContent extends Model
{
    use HasFactory;

    // Table
    protected $table = 'dn_featured_contents';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'featured_section_id',
        'featured_content_id',
        'store_id',
        'title',
        'thumbnail',
        'images',
        'store_title',
        'description',
        'content_type',
        'serial',
        'status'
    ];

    // Casts
    protected $casts = [
        'images' => 'array'
    ];

    /**
     * Define a belongs to relationship with the FeaturedSection model.
     */
    public function featuredSection()
    {
        return $this->belongsTo(FeaturedSection::class, 'featured_section_id', 'id');
    }

    /**
     * Define a belongs to relationship with the Store model.
     */
    public function store()
    {
        return $this->belongsTo(Store::class, 'store_id', 'id');
    }

    /**
     * Check if the post is liked by a specific user.
     *
     * @param int $userId
     * @return bool
     */
    public function isPostLike()
    {
        if (Auth::check()) {
            $userId = Auth::user()->id;
            return Like::where('content_type', 'home_featured_post')
                ->where('content_id', $this->id)
                ->where('user_id', $userId)
                ->exists();
        }
        return false;
    }

    /**
     * Get the likes associated with the post.
     */
    public function postLikes()
    {
        return $this->hasMany(Like::class, 'content_id')->where('content_type', 'home_featured_post');
    }

    /**
     * Get the comments associated with the post.
     */
    public function postComments()
    {
        return $this->hasMany(Comment::class, 'content_id')->where('content_type', 'home_featured_post');
    }


    /**
     * Check if the offer is saved by the authenticated user and is featured.
     *
     * @return bool
     */
    public function isSaveOffer()
    {
        if (Auth::check()) {
            return SaveOffer::where('offer_id', $this->id)
                ->where('user_id', Auth::id())
                ->exists();
        }
        return false;
    }

    /**
     * Check if the offer is liked by a specific user.
     *
     * @param int $userId
     * @return bool
     */
    public function isOfferLike()
    {
        if (Auth::check()) {
            $userId = Auth::user()->id;
            return Like::where('content_type', 'featured_offer')
                ->where('content_id', $this->id)
                ->where('user_id', $userId)
                ->exists();
        }
        return false;
    }

    /**
     * Get the likes associated with the offer.
     */
    public function offerLikes()
    {
        return $this->hasMany(Like::class, 'content_id')->where('content_type', 'featured_offer');
    }

    /**
     * Get the comments associated with the offer.
     */
    public function offerComments()
    {
        return $this->hasMany(Comment::class, 'content_id')->where('content_type', 'featured_offer');
    }
}
