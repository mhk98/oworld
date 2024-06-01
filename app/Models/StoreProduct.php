<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoreProduct extends Model
{
    use HasFactory;

    // Table
    protected $table = 'dn_store_products';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'store_id',
        'product'
    ];

    /**
     * Get the similar words associated with the store product.
     */
    public function similarWords()
    {
        return $this->hasMany(SimilarWord::class, 'word', 'product');
    }
}
