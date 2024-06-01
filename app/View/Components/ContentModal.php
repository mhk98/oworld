<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Illuminate\Support\Facades\Auth;

class ContentModal extends Component
{
    public $content;
    public $contentId;
    public $store;
    public $images;
    public $comments;
    public $contentType;
    public $contentDescription;
    public $isContentOwner;
    public $shareUrl;

    /**
     * Create a new component instance.
     */
    public function __construct($content, $store, $contentType)
    {
        $this->content = $content;
        $this->contentId = $content->id;
        $this->store = $store;
        $this->images = $content->images;
        $this->comments = $content->comments;
        $this->contentType = $contentType;
        $this->contentDescription = $content->description;
        $this->isContentOwner = Auth::check() && Auth::id() == $store->merchant_id;
        $this->shareUrl = '';
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.content-modal');
    }
}
