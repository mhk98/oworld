<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Store;
use App\Models\Offer;
use App\Models\Category;
use App\Models\Billboard;
use App\Models\CategorySerial;
use App\Helpers\StoreHelper;
use App\Models\FeaturedContent;
use App\Models\FeaturedSection;
use App\Models\Highlight;
use Carbon\Carbon;

class ShareController extends Controller
{
    // Post Share
    public function postShare($storeSlug, $postId)
    {
        $store = Store::where('slug', $storeSlug)->where('status', 'active')->first();
        if (!$store) {
            return abort(404);
        }
        $openPost = Post::where('store_id', $store->id)->where('post_id', $postId)->first();
        if ($openPost) {
            $openingHoursInfo = StoreHelper::openingHours($store);
            $openingHoursData = $openingHoursInfo['openingHoursData'];
            $openingHoursStatus = $openingHoursInfo['openingHoursStatus'];
            $hoursUntilNextOpening = $openingHoursInfo['hoursUntilNextOpening'];
            $currentDay = $openingHoursInfo['currentDay'];

            return view('store', compact('store', 'openPost', 'openingHoursData', 'openingHoursStatus', 'hoursUntilNextOpening', 'currentDay'));
        } else {
            return abort(404);
        }
    }

    // Offer Share
    public function offerShare($offerId)
    {
        // Retrieve the offer by its ID
        $openOffer = Offer::where('offer_id', $offerId)->first();
        if (!$openOffer) {
            return abort(404); // Offer not found
        }

        // Check if the offer is expired
        if (Carbon::now()->isAfter($openOffer->offer_expiration)) {
            return abort(404); // Offer is expired
        }

        // Retrieve categories
        $categoriesOrder = [
            'Food',
            'Fashion',
            'Beauty',
            'Home & Living',
            'Travel',
            'Events & Entertainment',
            'Tech & Electronics',
            'Health & Wellness',
            'Groceries',
            'Education & Work',
            'Business services',
            'Automotive',
            'Social services'
        ];

        $categories = Category::whereIn('title', $categoriesOrder)
            ->where('status', 'active')
            ->orderByRaw('FIELD(title, "' . implode('","', $categoriesOrder) . '")')
            ->get();

        // Retrieve active offers
        $offers = Offer::where('status', 'published')
            ->where('offer_expiration', '>', Carbon::now())
            ->orderBy('id', 'desc')
            ->get();

        // Pass data to the 'offer' view
        return view('offers', compact('openOffer', 'categories', 'offers'));
    }

    // Interior Share
    public function interiorShare($storeSlug)
    {
        $store = Store::where('slug', $storeSlug)->where('status', 'active')->first();
        if (!$store) {
            return abort(404);
        }

        $openInterior = $store->interiorPosts->count() > 0;

        if ($openInterior) {
            $openingHoursInfo = StoreHelper::openingHours($store);
            $openingHoursData = $openingHoursInfo['openingHoursData'];
            $openingHoursStatus = $openingHoursInfo['openingHoursStatus'];
            $hoursUntilNextOpening = $openingHoursInfo['hoursUntilNextOpening'];
            $currentDay = $openingHoursInfo['currentDay'];

            return view('store', compact('store', 'openInterior', 'openingHoursData', 'openingHoursStatus', 'hoursUntilNextOpening', 'currentDay'));
        } else {
            return abort(404);
        }
    }

    // Featured Share
    public function featuredShare($storeSlug)
    {
        $store = Store::where('slug', $storeSlug)->where('status', 'active')->first();
        if (!$store) {
            return abort(404);
        }

        $openFeatured = $store->featuredPosts->count() > 0;

        if ($openFeatured) {
            $openingHoursInfo = StoreHelper::openingHours($store);
            $openingHoursData = $openingHoursInfo['openingHoursData'];
            $openingHoursStatus = $openingHoursInfo['openingHoursStatus'];
            $hoursUntilNextOpening = $openingHoursInfo['hoursUntilNextOpening'];
            $currentDay = $openingHoursInfo['currentDay'];

            return view('store', compact('store', 'openFeatured', 'openingHoursData', 'openingHoursStatus', 'hoursUntilNextOpening', 'currentDay'));
        } else {
            return abort(404);
        }
    }


    // Logo Share
    public function logoShare($storeSlug)
    {
        $store = Store::where('slug', $storeSlug)->where('status', 'active')->first();
        if (!$store) {
            return abort(404);
        }

        $openLogo = !empty($store->profile_picture);

        if ($openLogo) {
            $openingHoursInfo = StoreHelper::openingHours($store);
            $openingHoursData = $openingHoursInfo['openingHoursData'];
            $openingHoursStatus = $openingHoursInfo['openingHoursStatus'];
            $hoursUntilNextOpening = $openingHoursInfo['hoursUntilNextOpening'];
            $currentDay = $openingHoursInfo['currentDay'];

            return view('store', compact('store', 'openLogo', 'openingHoursData', 'openingHoursStatus', 'hoursUntilNextOpening', 'currentDay'));
        } else {
            return abort(404);
        }
    }

    // Featured Post Share
    public function featuredPostShare($featuredPostId)
    {
        $openFeaturedPost = FeaturedContent::where('featured_content_id', $featuredPostId)->where('content_type', 'post')->first();
        if ($openFeaturedPost) {
            $billboards = Billboard::where('status', 'published')->orderBy('serial', 'asc')->get();
            $orderedCategories = CategorySerial::where('section', 'home')
                ->orderBy('serial')
                ->pluck('category_id')
                ->toArray();

            $homeCategories = Category::whereIn('id', $orderedCategories)
                ->where('status', 'active')
                ->orderByRaw('FIELD(id, "' . implode('","', $orderedCategories) . '")')
                ->get();

            $featuredSections = FeaturedSection::where('status', 'active')->orderBy('serial', 'asc')->get();

            $highlightCategoriesOrder = [
                'Events & Entertainment',
                'Food',
                'Fashion',
                'Beauty',
                'Home & Living',
                'Travel',
                'Tech & Electronics',
                'Health and Wellness',
                'Groceries',
                'Education & Work',
                'Business services',
                'Automotive',
                'Social services'
            ];

            $highlightCategories = Category::whereIn('title', $highlightCategoriesOrder)
                ->where('status', 'active')
                ->orderByRaw('FIELD(title, "' . implode('","', $highlightCategoriesOrder) . '")')
                ->get();

            return view('index', compact('openFeaturedPost', 'billboards', 'highlightCategories', 'homeCategories', 'featuredSections'));
        } else {
            return abort(404);
        }
    }

    // Featured Offer Share
    public function featuredOfferShare($featuredOfferId)
    {
        $openFeaturedOffer = FeaturedContent::where('featured_content_id', $featuredOfferId)->where('content_type', 'offer')->first();
        if ($openFeaturedOffer) {
            $billboards = Billboard::where('status', 'published')->orderBy('serial', 'asc')->get();
            $orderedCategories = CategorySerial::where('section', 'home')
                ->orderBy('serial')
                ->pluck('category_id')
                ->toArray();

            $homeCategories = Category::whereIn('id', $orderedCategories)
                ->where('status', 'active')
                ->orderByRaw('FIELD(id, "' . implode('","', $orderedCategories) . '")')
                ->get();

            $featuredSections = FeaturedSection::where('status', 'active')->orderBy('serial', 'asc')->get();

            $highlightCategoriesOrder = [
                'Events & Entertainment',
                'Food',
                'Fashion',
                'Beauty',
                'Home & Living',
                'Travel',
                'Tech & Electronics',
                'Health and Wellness',
                'Groceries',
                'Education & Work',
                'Business services',
                'Automotive',
                'Social services'
            ];

            $highlightCategories = Category::whereIn('title', $highlightCategoriesOrder)
                ->where('status', 'active')
                ->orderByRaw('FIELD(title, "' . implode('","', $highlightCategoriesOrder) . '")')
                ->get();

            return view('index', compact('openFeaturedOffer', 'billboards', 'highlightCategories', 'homeCategories', 'featuredSections'));
        } else {
            return abort(404);
        }
    }


    // Method to retrieve highlight categories
    public function shareHighlight($highlightCategory)
    {
       $openHighlightCategory = Category::find($highlightCategory);
      if ($openHighlightCategory) {
            $billboards = Billboard::where('status', 'published')->orderBy('serial', 'asc')->get();
            $orderedCategories = CategorySerial::where('section', 'home')
                ->orderBy('serial')
                ->pluck('category_id')
                ->toArray();

            $homeCategories = Category::whereIn('id', $orderedCategories)
                ->where('status', 'active')
                ->orderByRaw('FIELD(id, "' . implode('","', $orderedCategories) . '")')
                ->get();

            $featuredSections = FeaturedSection::where('status', 'active')->orderBy('serial', 'asc')->get();

            $highlightCategoriesOrder = [
                'Events & Entertainment',
                'Food',
                'Fashion',
                'Beauty',
                'Home & Living',
                'Travel',
                'Tech & Electronics',
                'Health and Wellness',
                'Groceries',
                'Education & Work',
                'Business services',
                'Automotive',
                'Social services'
            ];

            $highlightCategories = Category::whereIn('title', $highlightCategoriesOrder)
                ->where('status', 'active')
                ->orderByRaw('FIELD(title, "' . implode('","', $highlightCategoriesOrder) . '")')
                ->get();

            return view('index', compact('openHighlightCategory', 'billboards', 'highlightCategories', 'homeCategories', 'featuredSections'));
        } else {
            return abort(404);
        }
    }
}
