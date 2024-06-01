<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeaturedStore extends Model
{
    use HasFactory;

     // Table
     protected $table = 'dn_featured_stores';

     /**
      * The attributes that are mass assignable.
      *
      * @var array<int, string>
      */
     protected $fillable = [
         'featured_section_id',
         'store_id',
         'serial'
     ];

    /**
     * Define a belongs to relationship with the Store model.
     */
    public function store()
    {
        return $this->belongsTo(Store::class, 'store_id', 'id');
    }

      /**
     * Define a belongs to relationship with the FeaturedSection model.
     */
    public function featuredSection()
    {
        return $this->belongsTo(FeaturedSection::class, 'featured_section_id', 'id');
    }
}
