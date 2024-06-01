<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

     // Table
     protected $table = 'dn_reviews';

     /**
      * The attributes that are mass assignable.
      *
      * @var array<int, string>
      */
     protected $fillable = [
         'name',
         'feedback',
         'rating',
         'user_id',
         'store_id'
     ];

      /**
     * Get the user that owns the review.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the store that the review belongs to.
     */
    public function store()
    {
        return $this->belongsTo(Store::class);
    }
 
}
