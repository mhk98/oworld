<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Helpers\Helper;

class Category extends Model
{
    use HasFactory;

    // Table
    protected $table = 'dn_categories';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'slug',
        'icon',
        'desktop_hero_image',
        'mobile_hero_image',
        'is_parent',
        'parent_id',
        'status'
    ];

    /**
     * Get the parent category of the current category.
     */
    public function parentCategory()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    /**
     * Get the child categories of the current category.
     */
    public function subCategories()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    /**
     * Get the highlights for the category.
     */
    public function highlights()
    {
        return $this->hasMany(Highlight::class, 'category_id')
            ->where('status', 'published');
            //->whereDate('published_date', Carbon::today());
    }


    /**
     * Check if all highlights in the category have been viewed by the current IP address.
     *
     * @return bool
     */
    public function allViewed()
    {
        $ipAddress = Helper::ipAddress();
        $totalHighlights = $this->highlights->count();
        $viewedHighlights = HighlightView::whereIn('highlight_id', $this->highlights->pluck('id'))
            ->where('ip_address', $ipAddress)
            ->distinct('highlight_id')
            ->count();

        return $viewedHighlights === $totalHighlights;
    }
}
