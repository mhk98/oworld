<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HighlightView extends Model
{
    use HasFactory;

     // Table
     protected $table = 'dn_highlight_views';

     /**
      * The attributes that are mass assignable.
      *
      * @var array<int, string>
      */
     protected $fillable = [
         'highlight_id',
         'ip_address'
     ];
}
