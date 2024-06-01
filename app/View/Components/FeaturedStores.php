<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\Store;

class FeaturedStores extends Component
{    
    public $featuredStores;

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->featuredStores = Store::where('is_featured', true)->where('status', 'active')->get();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.featured-stores');
    }
}
