<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoreOpeningHours extends Model
{
    use HasFactory;

    // Table
    protected $table = 'dn_store_opening_hours';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
       'store_id',
       'day',
       'opening',
       'closing',
       'open_24h',
       'closed'
    ];
}
