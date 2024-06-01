<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Helpers\FileUpload;

class CategoryController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $filters = [
            'title' => $request->title,
            'status' => $request->status
        ];

        $parentCategories = Category::where('is_parent', true)->where(function ($query) use ($filters) {
            if ($filters['title']) {
                $query->where('title', 'like', '%' . $filters['title'] . '%');
            }
            if ($filters['status'] && $filters['status'] != 'All') {
                $query->where('status', '=', $filters['status']);
            }
        })->orderBy('id', 'desc')->paginate(100);

        return view('admin.categories.index', compact('parentCategories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        $parentCategories = Category::where('is_parent', true)->get();
        return view('admin.categories.create', compact('parentCategories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'slug' => 'required|unique:dn_categories,slug',
            'icon' => 'nullable|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            'desktop_hero_image' => 'nullable|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            'mobile_hero_image' => 'nullable|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            'status' => 'required'
        ]);

        $input = request()->all();

        // Handle icon
        if ($request->hasFile('icon')) {
            $iconPath = FileUpload::uploadOriginalFile($request->file('icon'));
            $input['icon'] = $iconPath;
        }

        // Handle Desktop Hero Immage
        if ($request->hasFile('desktop_hero_image')) {
            $desktopHeroImagePath = FileUpload::uploadOriginalFile($request->file('desktop_hero_image'));
            $input['desktop_hero_image'] = $desktopHeroImagePath;
        }

        // Handle Mobile Hero Image
        if ($request->hasFile('mobile_hero_image')) {
            $mobileHeroImagePath = FileUpload::uploadOriginalFile($request->file('mobile_hero_image'));
            $input['mobile_hero_image'] = $mobileHeroImagePath;
        }

        // Parent Category
        $input['is_parent'] = $request->filled('is_parent') ? 1 : 0;
        $input['parent_id'] = !$request->filled('is_parent') ? $request->parent_id : null;

        Category::create($input);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category added successfully!');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Category::findOrFail($id);
        $parentCategories = Category::where('is_parent', true)->get();
        return view('admin.categories.edit', compact('category','parentCategories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            'slug' => 'required|unique:dn_categories,slug,' . $id,
            'icon' => 'nullable|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            'desktop_hero_image' => 'nullable|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            'mobile_hero_image' => 'nullable|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            'status' => 'required'
        ]);

        $category = Category::findOrFail($id);
        $input = request()->all();
       
         // Handle icon
         if ($request->hasFile('icon')) {
            $iconPath = FileUpload::uploadOriginalFile($request->file('icon'));
            $input['icon'] = $iconPath;
        }

        // Handle Desktop Hero Immage
        if ($request->hasFile('desktop_hero_image')) {
            $desktopHeroImagePath = FileUpload::uploadOriginalFile($request->file('desktop_hero_image'));
            $input['desktop_hero_image'] = $desktopHeroImagePath;
        }

        // Handle Mobile Hero Image
        if ($request->hasFile('mobile_hero_image')) {
            $mobileHeroImagePath = FileUpload::uploadOriginalFile($request->file('mobile_hero_image'));
            $input['mobile_hero_image'] = $mobileHeroImagePath;
        }

        // Parent Category
        $input['is_parent'] = $request->filled('is_parent') ? 1 : 0;
        $input['parent_id'] = !$request->filled('is_parent') ? $request->parent_id : null;

        $category->update($input);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category deleted successfully!');
    }
}
