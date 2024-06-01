<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategorySerial extends Model
{
    use HasFactory;

    // Table
    protected $table = 'dn_category_serials';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'section',
        'category_id',
        'serial'
    ];
}
