<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeaturedSection extends Model
{
    use HasFactory;

    // Table
    protected $table = 'dn_featured_sections';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'serial',
        'content_type',
        'status'
    ];

    /**
     * Define a one-to-many relationship with the FeaturedStore model.
     */
    public function featuredStores()
    {
        return $this->hasMany(FeaturedStore::class, 'featured_section_id', 'id');
    }

    /**
     * Define a one-to-many relationship with the FeaturedContent model.
     * Retrieve only FeaturedContents where content_type is "post" and status is "published".
     */
    public function featuredPosts()
    {
        return $this->hasMany(FeaturedContent::class, 'featured_section_id', 'id')
            ->where('content_type', 'post')
            ->where('status', 'active');
    }

    /**
     * Define a one-to-many relationship with the FeaturedContent model for offers.
     * Retrieve only FeaturedContents where content_type is "offer" and status is "published".
     */
    public function featuredOffers()
    {
        return $this->hasMany(FeaturedContent::class, 'featured_section_id', 'id')
            ->where('content_type', 'offer')
            ->where('status', 'active');
    }
}
