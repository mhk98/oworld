<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FeaturedOffer extends Component
{   
    public $featuredOffer;
    public $shareUrl;

    /**
     * Create a new component instance.
     */
    public function __construct($featuredOffer)
    {
        $this->featuredOffer = $featuredOffer;
        $this->shareUrl = route('featuredOfferShare', ['featuredOfferId' => $featuredOffer->featured_content_id]);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.featured-offer');
    }
}
