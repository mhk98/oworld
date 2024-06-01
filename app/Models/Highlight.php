<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use App\Models\Like;

class Highlight extends Model
{
    use HasFactory;

    // Table
    protected $table = 'dn_highlights';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'image',
        'thumbnail',
        'description',
        'category_id',
        'status',
        'highlight_id',
        'slot',
        'published_date',
        'store_id'
    ];

    /**
     * Get the store that owns the highlight.
     */
    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    /**
     * Get the category that owns the highlight.
     */

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    

        /**
     * Check if the post is liked by the authenticated user.
     *
     * @return bool
     */
    public function isLike()
    {
        if (Auth::check()) {
            return Like::where('content_type', 'highlight')
                ->where('content_id', $this->id)
                ->where('user_id', Auth::id())
                ->exists();
        }
        return false;
    }

    /**
     * Get the likes associated with the post.
     */
    public function likes()
    {
        return $this->hasMany(Like::class, 'content_id')->where('content_type', 'highlight');
    }
}
