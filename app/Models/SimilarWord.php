<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SimilarWord extends Model
{
    use HasFactory;

     // Table
     protected $table = 'dn_similar_words';

     /**
      * The attributes that are mass assignable.
      *
      * @var array<int, string>
      */
     protected $fillable = [
         'word',
         'similar'
     ];
}
