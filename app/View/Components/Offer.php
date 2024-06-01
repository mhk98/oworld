<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Illuminate\Support\Facades\Auth;

class Offer extends Component
{
    public $offer;
    public $isContentOwner;
    public $shareUrl;

    /**
     * Create a new component instance.
     */
    public function __construct($offer)
    {
        $this->offer = $offer;
        $this->isContentOwner = $this->offer->store && Auth::check() && Auth::id() == $this->offer->store->merchant_id;
        $this->shareUrl = route('offerShare', ['offerId' => $offer->offer_id]);
    }
    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.offer');
    }
}
