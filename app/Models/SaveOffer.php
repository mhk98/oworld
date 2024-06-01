<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaveOffer extends Model
{
    use HasFactory;

    // Table
    protected $table = 'dn_save_offers';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'offer_id',
        'user_id',
        'is_featured'
    ];

    /**
     * Define the relationship with the Offer model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function offer()
    {
        return $this->belongsTo(Offer::class, 'offer_id', 'id');
    }


    /**
     * Define the relationship with the FeaturedContent model.
     *
     * @return BelongsTo
     */
    public function featuredOffer()
    {
        return $this->belongsTo(FeaturedContent::class, 'offer_id', 'id');
    }

    /**
     * Define the relationship with the User model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
