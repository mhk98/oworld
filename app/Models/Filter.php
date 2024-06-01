<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Filter extends Model
{
    use HasFactory;

     // Table
     protected $table = 'dn_filters';

     /**
      * The attributes that are mass assignable.
      *
      * @var array<int, string>
      */
     protected $fillable = [
         'store_id',
         'pre_order',
         'in_stock',
         'organic',
         'home_delivery',
         'men',
         'women',
         'imported',
         'local',
         'cuisine',
         'indoor',
         'outdoor'
    ];
 
}
