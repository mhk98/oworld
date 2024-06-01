<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\CategorySerial;
use App\Models\Category;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Public path change
        app()->usePublicPath(base_path());
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Fetch ordered categories
        $orderedCategories = CategorySerial::where('section', 'general')
            ->orderBy('serial')
            ->pluck('category_id')
            ->toArray();

        // Fetch all categories based on ordered category IDs
        $allCategories = Category::whereIn('id', $orderedCategories)
            ->where('status', 'active')
            ->orderByRaw('FIELD(id, "' . implode('","', $orderedCategories) . '")')
            ->get(); 

           /***  $allCategories = Category::join('category_serial', 'categories.id', '=', 'category_serial.category_id')
    ->select('categories.*')
    ->where('category_serial.section', 'general')
    ->where('categories.status', 'active')
    ->orderBy('category_serial.serial')
    ->get(); */

        // Define areas
        $areas = [
            'badda', 'banani', 'cantonment', 'dhanmondi', 'gulshan', 'uttara', 'kafrul', 'kalabagan', 'khilgaon', 'khilkhet', 'mirpur', 'mohammadpur', 'motijheel',
            'new_market', 'paltan', 'ramna', 'rampura', 'shahbag', 'tejgaon'
        ];

        // Share variables with views
        View::share([
            'allCategories' => $allCategories,
            'areas' => $areas
        ]);
    }
}
