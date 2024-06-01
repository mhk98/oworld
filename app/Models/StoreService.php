<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoreService extends Model
{
    use HasFactory;

    // Table
    protected $table = 'dn_store_services';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'store_id',
        'service'
    ];

      /**
     * Get the similar words associated with the store service.
     */
    public function similarWords()
    {
        return $this->hasMany(SimilarWord::class, 'word', 'service');
    }
}
