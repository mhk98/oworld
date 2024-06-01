<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Store;
use App\Models\User;
use App\Models\Category;
use App\Models\StoreGallery;
use App\Models\StoreOpeningHours;
use App\Helpers\FileUpload;

class StoreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filters = [
            'business_name' => $request->business_name,
            'status' => $request->status
        ];

        $stores = Store::where(function ($query) use ($filters) {
            if ($filters['business_name']) {
                $query->where('business_name', 'like', '%' . $filters['business_name'] . '%');
            }
            if ($filters['status'] && $filters['status'] != 'All') {
                $query->where('status', '=', $filters['status']);
            }
        })->orderBy('id', 'desc')->paginate(100);

        return view('admin.stores.index', compact('stores'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $merchants = User::where('is_merchant', true)->where('status', 'active')->get();
        $parentCategories = Category::where('status', 'active')
            ->where('is_parent', true)
            ->get();

        return view('admin.stores.create', compact('merchants', 'parentCategories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'business_name' => 'required',
            'merchant_id' => 'required',
            'business_type' => 'required',
            'store_type' => 'required',
            'profile_picture' => 'nullable|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            'cover_picture' => 'nullable|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            'category_id' => 'required',
            'sub_category_id' => 'required',
            'status' => 'required'
        ]);

        $input = request()->all();

        // Store Id
        $input['store_id'] = mt_rand(10000000, 99999999);

        // Handle Profile Picture
        if ($request->hasFile('profile_picture')) {
            $profilePicturePath = FileUpload::uploadOriginalFile($request->file('profile_picture'));
            $input['profile_picture'] = $profilePicturePath;
        }

        // Handle Cover Picture
        if ($request->hasFile('cover_picture')) {
            $coverPicturePath = FileUpload::uploadOriginalFile($request->file('cover_picture'));
            $input['cover_picture'] = $coverPicturePath;
        }

        // Slug
        $input['slug'] = Str::slug($request->business_name) . '-' . mt_rand(10000000, 99999999);
        $store = Store::create($input);

        if ($request->has('store_type') && in_array('physical', $request->store_type)) {
            // Store Areas
            if ($request->has('area')) {
                foreach ($request->area as $areaName) {
                    $store->areas()->create([
                        'area' => $areaName,
                        'address' => $request->input('address.' . $areaName)
                    ]);
                }
            }
        }


        if ($request->has('store_type') && in_array('online', $request->store_type)) {
            // Store Delivery Areas
            if ($request->has('delivery_area')) {
                foreach ($request->delivery_area as $deliveryAreaName) {
                    if ($deliveryAreaName != 'all') {
                        $store->deliveryAreas()->create([
                            'area' => $deliveryAreaName
                        ]);
                    }
                }
            }
        }


        // Featured Posts
        if ($request->hasFile('featuredPosts')) {
            $featuredPosts = $request->file('featuredPosts');
            foreach ($featuredPosts as $featuredPost) {
                if ($featuredPost->isValid()) {

                    $thumbnailFile = FileUpload::generatePreviewImage($featuredPost, 450, 350);
                    $imageFile = FileUpload::uploadOriginalFile($featuredPost);

                    StoreGallery::create([
                        'thumbnail' => $thumbnailFile,
                        'image' => $imageFile,
                        'category' => 'featured_post',
                        'store_id' => $store->id
                    ]);
                }
            }
        }

        $store->update([
            'featured_post_type' => $request->featured_post_type
        ]);

        // Interior
        if ($request->hasFile('interiorImages')) {
            $interiorImages = $request->file('interiorImages');
            foreach ($interiorImages as $interiorImage) {
                if ($interiorImage->isValid()) {

                    $thumbnailFile = FileUpload::generatePreviewImage($interiorImage, 450, 350);
                    $imageFile = FileUpload::uploadOriginalFile($interiorImage);

                    StoreGallery::create([
                        'thumbnail' => $thumbnailFile,
                        'image' => $imageFile,
                        'category' => 'interior',
                        'store_id' => $store->id
                    ]);
                }
            }
        }

        // Store Category
        if ($request->has('category_id')) {
            $store->mainCategories()->sync($request->category_id);
        }

        // Store Sub Category
        if ($request->has('sub_category_id')) {
            $store->subCategories()->sync($request->sub_category_id);
        }

        // Products
        if ($request->has('products')) {
            $products = $request->products;
            foreach (explode(',', $products) as $productName) {
                $store->products()->create(['product' => $productName]);
            }
        }

        // Services
        if ($request->has('services')) {
            $services = $request->services;
            foreach (explode(',', $services) as $serviceName) {
                $store->services()->create(['service' => $serviceName]);
            }
        }

        // Opening Hours
        $openingHours = [];
        if (in_array('physical', $store->store_type)) {
            $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
            foreach ($days as $day) {
                $openingHours[$day] = StoreOpeningHours::updateOrCreate(
                    ['store_id' => $store->id, 'day' => $day],
                    [
                        'opening' => $request->input(strtolower($day) . '_opening'),
                        'closing' => $request->input(strtolower($day) . '_closing'),
                        'open_24h' => $request->has(strtolower($day) . '_24h'),
                        'closed' => $request->has(strtolower($day) . '_closed')
                    ]
                );
            }
        }

        return redirect()->route('admin.stores.index')
            ->with('success', 'Store added successfully!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $store = Store::findOrFail($id);
        $merchants = User::where('is_merchant', true)->where('status', 'active')->get();
        $parentCategories = Category::where('status', 'active')
            ->where('is_parent', true)
            ->get();
        $mainCategories = $store->mainCategories()->get();

        $interiorImages = $store->gallery()->where('category', 'interior')->get();
        $featuredPostImages = $store->gallery()->where('category', 'featured_post')->get();

        return view('admin.stores.edit', compact('store', 'merchants', 'parentCategories', 'mainCategories', 'interiorImages', 'featuredPostImages'));
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'merchant_id' => 'required',
            'business_type' => 'required',
            'store_type' => 'required',
            'profile_picture' => 'nullable|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            'cover_picture' => 'nullable|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            'category_id' => 'required',
            'sub_category_id' => 'required',
            'status' => 'required'
        ]);

        $input = request()->all();
        $store = Store::findOrFail($id);

        // Handle Profile Picture
        if ($request->hasFile('profile_picture')) {
            $profilePicturePath = FileUpload::uploadOriginalFile($request->file('profile_picture'));
            $input['profile_picture'] = $profilePicturePath;
        }

        // Handle Cover Picture
        if ($request->hasFile('cover_picture')) {
            $coverPicturePath = FileUpload::uploadOriginalFile($request->file('cover_picture'));
            $input['cover_picture'] = $coverPicturePath;
        }


        // Store Areas
        $store->areas()->delete();
        if ($request->has('store_type') && in_array('physical', $request->store_type)) {
            if ($request->has('area')) {
                foreach ($request->area as $areaName) {
                    $store->areas()->create([
                        'area' => $areaName,
                        'address' => $request->input('address.' . $areaName)
                    ]);
                }
            }
        }


        // Store Delivery Areas
        $store->deliveryAreas()->delete();
        if ($request->has('store_type') && in_array('online', $request->store_type)) {
            if ($request->has('delivery_area')) {
                foreach ($request->delivery_area as $deliveryAreaName) {
                    if ($deliveryAreaName != 'all') {
                        $store->deliveryAreas()->create([
                            'area' => $deliveryAreaName
                        ]);
                    }
                }
            }
        }

        // Featured Posts
        if ($request->hasFile('featuredPosts')) {
            $featuredPosts = $request->file('featuredPosts');
            foreach ($featuredPosts as $featuredPost) {
                if ($featuredPost->isValid()) {

                    $thumbnailFile = FileUpload::generatePreviewImage($featuredPost, 450, 350);
                    $imageFile = FileUpload::uploadOriginalFile($featuredPost);

                    StoreGallery::create([
                        'thumbnail' => $thumbnailFile,
                        'image' => $imageFile,
                        'category' => 'featured_post',
                        'store_id' => $store->id
                    ]);
                }
            }
        }

        //  $store->update([
        //  'featured_post_type' => $request->featured_post_type
        //  ]);

        // Interior
        if ($request->hasFile('interiorImages')) {
            $interiorImages = $request->file('interiorImages');
            foreach ($interiorImages as $interiorImage) {
                if ($interiorImage->isValid()) {

                    $thumbnailFile = FileUpload::generatePreviewImage($interiorImage, 450, 350);
                    $imageFile = FileUpload::uploadOriginalFile($interiorImage);

                    StoreGallery::create([
                        'thumbnail' => $thumbnailFile,
                        'image' => $imageFile,
                        'category' => 'interior',
                        'store_id' => $store->id
                    ]);
                }
            }
        }

        // Store Category
        if ($request->has('category_id')) {
            $store->mainCategories()->sync($request->category_id);
        }

        // Store Sub Category
        if ($request->has('sub_category_id')) {
            $store->subCategories()->sync($request->sub_category_id);
        }

        // Products
        $store->products()->delete();
        if ($request->has('products')) {
            $products = $request->products;
            foreach (explode(',', $products) as $productName) {
                if (!empty($productName)) {
                    $store->products()->create(['product' => $productName]);
                }
            }
        }

        // Services
        $store->services()->delete();
        if ($request->has('services')) {
            $services = $request->services;
            foreach (explode(',', $services) as $serviceName) {
                if (!empty($serviceName)) {
                    $store->services()->create(['service' => $serviceName]);
                }
            }
        }

        // Opening Hours
        $openingHours = [];
        if (in_array('physical', $store->store_type)) {
            $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
            foreach ($days as $day) {
                $openingHours[$day] = StoreOpeningHours::updateOrCreate(
                    ['store_id' => $store->id, 'day' => $day],
                    [
                        'opening' => $request->input(strtolower($day) . '_opening'),
                        'closing' => $request->input(strtolower($day) . '_closing'),
                        'open_24h' => $request->has(strtolower($day) . '_24h'),
                        'closed' => $request->has(strtolower($day) . '_closed')
                    ]
                );
            }
        }

        // Update All
        $store->update($input);

        return redirect()->route('admin.stores.index')
            ->with('success', 'Store updated successfully!');
    }


    // Gallery Item Remove
    public function galleryItemRemove($id)
    {
        $interiorImage = StoreGallery::findOrFail($id);
        $interiorImage->delete();

        return response()->json(['success' => true]);
    }


    // Get Sub Categories
    public function getSubcategories(Request $request)
    {
        $mainCategories = $request->input('mainCategories', []);
        $subCategories = Category::whereIn('parent_id', $mainCategories)->get();
        $storeId = $request->input('store_id');
        $store = !empty($storeId) ? Store::findOrFail($storeId) : null;
        $options = '';
        if ($subCategories->count() > 0) {
            foreach ($subCategories as $subCategory) {
                $checked = !empty($store->id) && !empty($store->subCategories) && $store->subCategories->contains('id', $subCategory->id) ? 'checked' : '';

                $options .= '<div class="form-check">
                <input class="form-check-input" type="checkbox" name="sub_category_id[]" value="' . $subCategory->id . '" id="subCategoryCheckbox' . $subCategory->id . '" ' . $checked . '>
                <label class="form-check-label" for="subCategoryCheckbox' . $subCategory->id . '">' . $subCategory->title . '</label>
            </div>';
            }
        } else {
            $options .= '<p>No sub-categories available</p>';
        }

        // Manually include category with ID 49 if main category IDs are 7 or 8
        if (in_array(7, $mainCategories) || in_array(8, $mainCategories)) {
            $nutritionCategory = Category::find(49);
            if ($nutritionCategory) {
                $checked = !empty($store->id) && !empty($store->subCategories) && $store->subCategories->contains('id', $nutritionCategory->id) ? 'checked' : '';
                $options .= '<div class="form-check">
                <input class="form-check-input" type="checkbox" name="sub_category_id[]" value="' . $nutritionCategory->id . '" id="subCategoryCheckbox' . $nutritionCategory->id . '" ' . $checked . '>
                <label class="form-check-label" for="subCategoryCheckbox' . $nutritionCategory->id . '">' . $nutritionCategory->title . '</label>
            </div>';
            }
        }

        return $options;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $store = Store::findOrFail($id);
        $store->delete();

        return redirect()->route('admin.stores.index')
            ->with('success', 'Store deleted successfully!');
    }
}
