<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\Category;

class HomeCategories extends Component
{
    public $homeCategories;

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $homeCategoriesSerial = [
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

        $this->homeCategories = Category::whereIn('title', $homeCategoriesSerial)
            ->where('status', 'active')
            ->orderByRaw('FIELD(title, "' . implode('","', $homeCategoriesSerial) . '")')
            ->get();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.home-categories');
    }
}
