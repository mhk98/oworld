<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CategorySerial;
use App\Models\Category;

class CategorySerialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.categories.category_serial');
    }

 /**
 * Show the form for editing the specified resource.
 */
public function edit(string $sec)
{
    $section = $sec;

    // Fetch ordered category IDs
    $orderedCategories = CategorySerial::where('section', $section)
        ->orderBy('serial')
        ->pluck('category_id')
        ->toArray();

    // Fetch parent categories based on ordered category IDs
    $parentCategories = Category::whereIn('id', $orderedCategories)
        ->where('is_parent', true)
        ->where('status', 'active')
        ->orderByRaw('FIELD(id, "' . implode('","', $orderedCategories) . '")')
        ->get();

    $activeCategoryIds = CategorySerial::where('section', $section)->pluck('category_id')->toArray();

    return view('admin.categories.edit_category_serial', compact('section', 'parentCategories', 'activeCategoryIds'));
}

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $sec)
    {
       
        $activeCategoryIds = $request->category_ids;
        // Delete All Serial
        CategorySerial::where('section', $sec)->delete();
        foreach ($activeCategoryIds as $serial => $categoryId) {
            CategorySerial::create([
                'section' => $sec,
                'category_id' => $categoryId,
                'serial' => $serial + 1
            ]);
        } 

        return redirect()->route('admin.category_serial.index')->with('success', 'Category serial updated successfully');
    }
}
