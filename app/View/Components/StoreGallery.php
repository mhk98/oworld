<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\Like;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;

class StoreGallery extends Component
{
    public $store;
    public $galleryType;
    public $galleryImages;
    public $isLike;
    public $likes;
    public $comments;
    public $shareUrl;

    /**
     * Create a new component instance.
     */
    public function __construct($store, $galleryType)
    {
        $this->store = $store;
        $this->galleryType = $galleryType;

        if ($this->galleryType === 'interior') {
            $this->galleryImages = $this->store->gallery()->where('category', 'interior')->get();
        } elseif ($this->galleryType === 'featured_post') {
            $this->galleryImages = $this->store->gallery()->where('category', 'featured_post')->get();
        }

        $this->isLike = Like::where('content_type', $this->galleryType)
            ->where('content_id', $this->store->id)
            ->where('user_id', Auth::id())
            ->exists();

        $this->likes = Like::where('content_type', $this->galleryType)
            ->where('content_id', $this->store->id)
            ->count();

        $this->comments = Comment::where('content_type', $this->galleryType)
            ->where('content_id', $this->store->id)
            ->get();

        if ($this->galleryType === 'interior') {
            $this->shareUrl = route('interiorShare', ['storeSlug' => $store->slug]);
        } elseif ($this->galleryType === 'featured_post') {
            $this->shareUrl = route('featuredShare', ['storeSlug' => $store->slug]);
        }
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.store-gallery');
    }
}
