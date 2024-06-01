<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Billboard extends Model
{
    use HasFactory;

    // Table
    protected $table = 'dn_billboards';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
       'image',
       'description',
       'store_id',
       'billboard_id',
       'serial',
       'published_date',
       'status'
    ];

    /**
     * Get the store that owns the billboard.
     */
    public function store()
    {
        return $this->belongsTo(Store::class);
    }
}
