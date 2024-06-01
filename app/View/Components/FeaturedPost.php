<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FeaturedPost extends Component
{   
    public $featuredPost;
    public $shareUrl;

    /**
     * Create a new component instance.
     */
    public function __construct($featuredPost)
    {
        $this->featuredPost = $featuredPost;
        $this->shareUrl = route('featuredPostShare', ['featuredPostId' => $featuredPost->featured_content_id]);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.featured-post');
    }
}
