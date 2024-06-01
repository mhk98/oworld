<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Store;
use App\Models\Billboard;
use App\Models\Offer;
use App\Models\Category;
use App\Models\FeaturedSection;
use App\Models\CategorySerial;
use App\Helpers\StoreHelper;
use Carbon\Carbon;

class IndexController extends Controller
{
    /**
     * Index.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        // Fetch published billboards
        $billboards = Billboard::where('status', 'published')->orderBy('serial', 'asc')->get();

        // Fetch home categories
        $orderedCategories = CategorySerial::where('section', 'home')
            ->orderBy('serial')
            ->pluck('category_id')
            ->toArray();

        $homeCategories = Category::whereIn('id', $orderedCategories)
            ->where('status', 'active')
            ->orderByRaw('FIELD(id, "' . implode('","', $orderedCategories) . '")')
            ->get();

        // Fetch featured sections
        $featuredSections = FeaturedSection::where('status', 'active')->orderBy('serial', 'asc')->get();

        // Fetch highlight categories
        $orderedHighlightCategories = CategorySerial::where('section', 'general')
            ->orderBy('serial')
            ->pluck('category_id')
            ->toArray();

        $highlightCategories = Category::whereIn('id', $orderedHighlightCategories)
            ->where('status', 'active')
            ->orderByRaw('FIELD(id, "' . implode('","', $orderedHighlightCategories) . '")')
            ->get();

        return view('index', compact('billboards', 'highlightCategories', 'homeCategories', 'featuredSections'));
    }


    /**
     * Categories.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function categories(Request $request)
    {
        $stores = Store::query();
        $stores->whereDoesntHave('mainCategories', function ($query) {
            $query->where('id', 13);
        });

        // Apply store type filter
        if ($request->filled('store_type')) {
            $stores->whereJsonContains('store_type', $request->store_type);
        }


        // Filter by area.
        if (request()->filled('area')) {
            $areas = explode(',', request()->query('area'));

            $stores->whereHas('areas', function ($query) use ($areas) {
                $query->whereIn('area', $areas);
            });
        }

        // Filter by various attributes using dynamic method calls
        $filters = ['pre_order', 'in_stock', 'organic', 'men', 'women', 'imported', 'local', 'cuisine', 'home_delivery', 'indoor', 'outdoor'];

        foreach ($filters as $filter) {
            if ($request->filled($filter)) {
                $stores->whereHas('filter', function ($query) use ($filter, $request) {
                    $query->where($filter, true);
                });
            }
        }

        // Satus
        $stores->where('status', 'active');

        // Get the filtered stores
        $stores = $stores->get();

        return view('categories', compact('stores'));
    }

    /**
     * Category.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function category(Request $request, $slug)
    {
        $mainCategory = Category::where('slug', $slug)->first();
        if (!$mainCategory) {
            abort(404);
        }

        // Sub Categories
        $subCategories = $mainCategory->subCategories;

        $stores = Store::where('status', 'active')
            ->whereHas('mainCategories', function ($query) use ($mainCategory) {
                $query->where('id', $mainCategory->id);
            })
            ->orWhereHas('subCategories', function ($query) use ($mainCategory) {
                $query->where('id', $mainCategory->id);
            });

        // Apply store type filter
        if ($request->filled('store_type')) {
            $stores->whereJsonContains('store_type', $request->store_type);
        }


        // Filter by area.
        if (request()->filled('area')) {
            $areas = explode(',', request()->query('area'));

            $stores->whereHas('areas', function ($query) use ($areas) {
                $query->whereIn('area', $areas);
            });
        }

        // Filter by various attributes using dynamic method calls
        $filters = ['pre_order', 'in_stock', 'organic', 'men', 'women', 'imported', 'local', 'cuisine', 'home_delivery', 'indoor', 'outdoor'];

        foreach ($filters as $filter) {
            if ($request->filled($filter)) {
                $stores->whereHas('filter', function ($query) use ($filter, $request) {
                    $query->where($filter, true);
                });
            }
        }

        $stores = $stores->get();


        return view('category', compact('mainCategory', 'subCategories', 'stores'));
    }

    // Sub Category
    public function subCategory(Request $request, $mainCategorySlug, $subCategorySlug)
    {
        $mainCategory = Category::where('slug', $mainCategorySlug)->first();
        if (!$mainCategory) {
            abort(404);
        }

        $subCategory = Category::where('slug', $subCategorySlug)
            //->where('parent_id', $mainCategory->id)
            ->first();
        if (!$subCategory) {
            abort(404);
        }

        $subCategories = $mainCategory->subCategories;

        $stores = Store::where('status', 'active')
            // ->whereHas('mainCategories', function ($query) use ($subCategory) {
            //  $query->where('id', $subCategory->id);
            //  })
            ->whereHas('subCategories', function ($query) use ($subCategory) {
                $query->where('id', $subCategory->id);
            });
        // Apply store type filter
        if ($request->filled('store_type')) {
            $stores->whereJsonContains('store_type', $request->store_type);
        }


        // Filter by area.
        if (request()->filled('area')) {
            $areas = explode(',', request()->query('area'));

            $stores->whereHas('areas', function ($query) use ($areas) {
                $query->whereIn('area', $areas);
            });
        }

        // Filter by various attributes using dynamic method calls
        $filters = ['pre_order', 'in_stock', 'organic', 'men', 'women', 'imported', 'local', 'cuisine', 'home_delivery', 'indoor', 'outdoor'];

        foreach ($filters as $filter) {
            if ($request->filled($filter)) {
                $stores->whereHas('filter', function ($query) use ($filter, $request) {
                    $query->where($filter, true);
                });
            }
        }
        $stores = $stores->get();


        return view('sub_category', compact('mainCategory', 'subCategory', 'subCategories', 'stores'));
    }

    // Food
    public function food(Request $request)
    {
        $foodCategory = Category::where('title', 'Food')->first();
        if (!$foodCategory) {
            abort(404);
        }

        $foodSubCategoriesOrder = [
            'Restaurant',
            'Cafe',
            'Bakery',
            'Food services'
        ];

        $foodSubCategories = $foodCategory->subcategories()
            ->whereIn('title', $foodSubCategoriesOrder)
            ->where('status', 'active')
            ->orderByRaw('FIELD(title, "' . implode('","', $foodSubCategoriesOrder) . '")')
            ->get();

        $stores = Store::where('status', 'active')
            ->whereHas('mainCategories', function ($query) use ($foodCategory) {
                $query->where('id', $foodCategory->id);
            })
            ->orWhereHas('subCategories', function ($query) use ($foodCategory) {
                $query->where('id', $foodCategory->id);
            });

        // Apply store type filter
        if ($request->filled('store_type')) {
            $stores->whereJsonContains('store_type', $request->store_type);
        }


        // Filter by area.
        if (request()->filled('area')) {
            $areas = explode(',', request()->query('area'));

            $stores->whereHas('areas', function ($query) use ($areas) {
                $query->whereIn('area', $areas);
            });
        }

        // Filter by various attributes using dynamic method calls
        $filters = ['pre_order', 'in_stock', 'organic', 'men', 'women', 'imported', 'local', 'cuisine', 'home_delivery', 'indoor', 'outdoor'];

        foreach ($filters as $filter) {
            if ($request->filled($filter)) {
                $stores->whereHas('filter', function ($query) use ($filter, $request) {
                    $query->where($filter, true);
                });
            }
        }

        $stores = $stores->get();

        return view('food', compact('stores', 'foodSubCategories'));
    }

    // Food Sub Category
    public function foodSubCategory(Request $request, $subCategory)
    {
        $foodCategory = Category::where('title', 'Food')->first();
        if (!$foodCategory) {
            abort(404);
        }

        $foodSubCategory = Category::where('slug', $subCategory)->first();
        if (!$foodSubCategory) {
            abort(404);
        }

        $foodSubCategoriesOrder = [
            'Restaurant',
            'Cafe',
            'Bakery',
            'Food services'
        ];

        $foodSubCategories = $foodCategory->subcategories()
            ->whereIn('title', $foodSubCategoriesOrder)
            ->where('status', 'active')
            ->orderByRaw('FIELD(title, "' . implode('","', $foodSubCategoriesOrder) . '")')
            ->get();

        $stores = Store::where('status', 'active')
            ->whereHas('mainCategories', function ($query) use ($foodSubCategory) {
                $query->where('id', $foodSubCategory->id);
            })
            ->orWhereHas('subCategories', function ($query) use ($foodSubCategory) {
                $query->where('id', $foodSubCategory->id);
            });

        // Apply store type filter
        if ($request->filled('store_type')) {
            $stores->whereJsonContains('store_type', $request->store_type);
        }


        // Filter by area.
        if (request()->filled('area')) {
            $areas = explode(',', request()->query('area'));

            $stores->whereHas('areas', function ($query) use ($areas) {
                $query->whereIn('area', $areas);
            });
        }

        // Filter by various attributes using dynamic method calls
        $filters = ['pre_order', 'in_stock', 'organic', 'men', 'women', 'imported', 'local', 'cuisine', 'home_delivery', 'indoor', 'outdoor'];

        foreach ($filters as $filter) {
            if ($request->filled($filter)) {
                $stores->whereHas('filter', function ($query) use ($filter, $request) {
                    $query->where($filter, true);
                });
            }
        }

        $stores = $stores->get();

        return view('food_sub_category', compact('foodSubCategories', 'foodSubCategory', 'stores'));
    }


    // Offers
    public function offers(Request $request)
    {
        // Fetch ordered categories
        $orderedCategories = CategorySerial::where('section', 'general')
            ->orderBy('serial')
            ->pluck('category_id')
            ->toArray();

        // Fetch all categories based on ordered category IDs
        $categories = Category::whereIn('id', $orderedCategories)
            ->where('status', 'active')
            ->orderByRaw('FIELD(id, "' . implode('","', $orderedCategories) . '")')
            ->get();

        // Offers
        $now = Carbon::now();
        $offersQuery = Offer::where('status', 'published')
            ->where('offer_expiration', '>', $now);

        if ($request->has('category')) {
            $categorySlug = $request->input('category');
            $category = Category::where('slug', $categorySlug)->first();
            if ($category) {
                $offersQuery->where('category_id', $category->id);
            }
        }

        $offers = $offersQuery->orderBy('id', 'desc')->get();

        return view('offers', compact('categories', 'offers'));
    }

    // Store
    public function store($slug)
    {

        $store = Store::where('slug', $slug)->first();
        if (!$store) {
            abort(404);
        }

        $openingHoursInfo = StoreHelper::openingHours($store);
        $openingHoursData = $openingHoursInfo['openingHoursData'];
        $openingHoursStatus = $openingHoursInfo['openingHoursStatus'];
        $hoursUntilNextOpening = $openingHoursInfo['hoursUntilNextOpening'];
        $currentDay = $openingHoursInfo['currentDay'];

        return view('store_new', compact('store', 'openingHoursData', 'openingHoursStatus', 'hoursUntilNextOpening', 'currentDay'));
    }

    // Search
    public function search(Request $request)
    {
        $keywords = $request->search;

        // Product / Services
        $productServiceStores = Store::where('status', 'active')->where(function ($query) use ($keywords) {
            $query->whereHas('products', function ($query) use ($keywords) {
                $query->where('product', 'like', "%$keywords%");
            })->orWhereHas('services', function ($query) use ($keywords) {
                $query->where('service', 'like', "%$keywords%");
            })->orWhereHas('products.similarWords', function ($query) use ($keywords) {
                $query->where('similar', 'like', "%$keywords%");
            })->orWhereHas('services.similarWords', function ($query) use ($keywords) {
                $query->where('similar', 'like', "%$keywords%");
            });
        })->get();

        // Store Names
        $businessNameStores = Store::where('status', 'active')->where(function ($query) use ($keywords) {
            $query->where('business_name', 'like', "%$keywords%");
        })->get();

        // Apply store type filter
        if ($request->filled('store_type')) {
            $productServiceStores->whereJsonContains('store_type', $request->store_type);
            $businessNameStores->whereJsonContains('store_type', $request->store_type);
        }

        // Filter by area.
        if ($request->filled('area')) {
            $areas = explode(',', $request->query('area'));
            $productServiceStores->whereHas('areas', function ($query) use ($areas) {
                $query->whereIn('area', $areas);
            });
            $businessNameStores->whereHas('areas', function ($query) use ($areas) {
                $query->whereIn('area', $areas);
            });
        }

        // Filter by various attributes using dynamic method calls
        $filters = ['pre_order', 'in_stock', 'organic', 'men', 'women', 'imported', 'local', 'cuisine', 'home_delivery', 'indoor', 'outdoor'];

        foreach ($filters as $filter) {
            if ($request->filled($filter)) {
                $productServiceStores->whereHas('filter', function ($query) use ($filter, $request) {
                    $query->where($filter, true);
                });
                $businessNameStores->whereHas('filter', function ($query) use ($filter, $request) {
                    $query->where($filter, true);
                });
            }
        }

        return view('search', compact('productServiceStores', 'businessNameStores'));
    }
    // Bday Bash
    public function bday_bash()
    {
        return view('bday_bash');
    }

    // Influencer
    public function influencer()
    {
        return view('influencer');
    }
}
