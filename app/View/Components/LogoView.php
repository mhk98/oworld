<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\Like;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;

class LogoView extends Component
{

    public $store;
    public $isLike;
    public $likes;
    public $comments;
    public $shareUrl;

    /**
     * Create a new component instance.
     */
    public function __construct($store)
    {
        $this->store = $store;

        $this->isLike = Like::where('content_type', 'logo')
            ->where('user_id', Auth::id())
            ->exists();

        $this->likes = Like::where('content_type', 'logo')
            ->count();

        $this->comments = Comment::where('content_type', 'logo')
            ->get();

        $this->shareUrl = route('logoShare', ['storeSlug' => $store->slug]);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.logo-view');
    }
}
