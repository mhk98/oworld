<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use App\Models\Follower;

class Store extends Model
{
    use HasFactory;

    // Table
    protected $table = 'dn_stores';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'business_name',
        'slug',
        'profile_picture',
        'cover_picture',
        'business_type',
        'store_type',
        'merchant_id',
        'intro',
        'phone',
        'email',
        'facebook',
        'twitter',
        'instagram ',
        'linkedin',
        'website',
        'established_since',
        'is_featured',
        'featured_post_type',
        'map_url',
        'tags',
        'is_setup_complete',
        'status'
    ];

    // Casts
    protected $casts = [
        'store_type' => 'array',
        'tags' => 'array'
    ];

    /**
     * Define the many-to-many relationship with Category.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function mainCategories()
    {
        return $this->belongsToMany(Category::class, 'dn_store_main_categories', 'store_id', 'category_id');
    }

    /**
     * Define the many-to-many relationship with Sub Categories.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function subCategories()
    {
        return $this->belongsToMany(Category::class, 'dn_store_sub_categories', 'store_id', 'category_id');
    }

    /**
     * Define the "merchant" relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function merchant()
    {
        return $this->belongsTo(User::class, 'merchant_id')->where('is_merchant', true);
    }

    /**
     * Define the "posts" relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function posts()
    {
        return $this->hasMany(Post::class, 'store_id');
    }

    /**
     * Define the "reviews" relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function reviews()
    {
        return $this->hasMany(Review::class, 'store_id');
    }

    /**
     * Define the "gallery" relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function gallery()
    {
        return $this->hasMany(StoreGallery::class, 'store_id');
    }

    /**
     * Get the interior posts for the store.
     */
    public function getInteriorPostsAttribute()
    {
        return $this->gallery()->where('category', 'interior')->get();
    }

    /**
     * Get the featured posts for the store.
     */
    public function getFeaturedPostsAttribute()
    {
        return $this->gallery()->where('category', 'featured_post')->get();
    }

    /**
     * Define a one-to-many relationship with StoreArea model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function areas()
    {
        return $this->hasMany(StoreArea::class, 'store_id');
    }

    /**
     * Define a one-to-many relationship with StoreDeliveryArea model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function deliveryAreas()
    {
        return $this->hasMany(StoreDeliveryArea::class, 'store_id');
    }


    /**
     * Define a one-to-one relationship with the Filter model.
     */
    public function filter()
    {
        return $this->hasOne(Filter::class, 'store_id');
    }


    /**
     * Define a one-to-many relationship with the Store Opening Hours model.
     */
    public function openingHours()
    {
        return $this->hasMany(StoreOpeningHours::class, 'store_id');
    }


    /**
     * Define a one-to-many relationship with the Product model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function products()
    {
        return $this->hasMany(StoreProduct::class, 'store_id');
    }


    /**
     * Define a one-to-many relationship with the Service model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function services()
    {
        return $this->hasMany(StoreService::class, 'store_id');
    }

    /**
     * Calculate and get the average rating for the store.
     *
     * @return float|null
     */
    public function getAverageRatingAttribute()
    {
        $averageRating = $this->reviews()->avg('rating');

        // If there are no reviews, return null or a default value
        return $averageRating !== null ? round($averageRating, 2) : null;
    }

    /**
     * Define the "followers" relationship.
     *
     * @return BelongsToMany
     */
    public function followers()
    {
        return $this->belongsToMany(User::class, 'dn_followers', 'store_id', 'user_id')->withTimestamps();
    }

    /**
     * Get the count of followers for the store.
     *
     * @return int
     */
    public function getFollowersCountAttribute()
    {
        return $this->followers()->count();
    }

    /**
     * Check if the current user is following the store.
     */
    public function getIsFollowingAttribute()
    {
        if (Auth::check()) {
            $user = Auth::user();
            return Follower::where('user_id', $user->id)->where('store_id', $this->id)->exists();
        }
        return false;
    }

    /**
     * Check if the user is a merchant and the current store matches.
     */
    public function getIsMerchantAttribute()
    {
        return auth()->check() && auth()->user()->is_merchant && $this->id == session('current_store');
    }
}
