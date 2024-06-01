<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Illuminate\Support\Facades\Auth;

class Post extends Component
{

    public $post;
    public $isContentOwner;
    public $shareUrl;

    /**
     * Create a new component instance.
     */
    public function __construct($post)
    {
        $this->post = $post;
        $this->isContentOwner = $this->post->store && Auth::check() && Auth::id() == $this->post->store->merchant_id;
        $this->shareUrl = route('postShare', ['storeSlug' => $this->post->store->slug, 'postId' => $post->post_id]);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.post');
    }
}