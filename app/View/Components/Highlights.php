<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\Category;

class Highlights extends Component
{   
    public $highlightCategories;

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $highlightCategoriesSerial = [
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

        $this->highlightCategories = Category::whereIn('title', $highlightCategoriesSerial)
            ->where('status', 'active')
            ->orderByRaw('FIELD(title, "' . implode('","', $highlightCategoriesSerial) . '")')
            ->get();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.highlights');
    }
}
