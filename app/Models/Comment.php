<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Comment extends Model
{
    use HasFactory;

    // Table
    protected $table = 'dn_comments';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'content_type',
        'content_id',
        'user_id',
        'comment'
    ];

    /**
     * Get the user that owns the comment.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Check if the authenticated user is the owner of the comment.
     *
     * @return bool
     */
    public function isOwner()
    {
        return Auth::check() && Auth::id() == $this->user_id;
    }
}
