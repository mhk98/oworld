<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoreGallery extends Model
{
    use HasFactory;

    // Table
    protected $table = 'dn_store_galleries';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'store_id',
        'thumbnail',
        'image',
        'category'
    ];
}
