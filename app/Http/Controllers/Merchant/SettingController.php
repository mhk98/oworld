<?php

namespace App\Http\Controllers\Merchant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Category;
use App\Models\User;
use App\Models\Store;
use App\Models\Post;
use App\Helpers\FileUpload;
use App\Models\StoreGallery;
use App\Models\StoreOpeningHours;
use Illuminate\Support\Facades\Validator;

class SettingController extends Controller
{
    // Display the setting form
    public function setting()
    {
        $merchant = User::findOrFail(auth()->user()->id);
        $store = Store::where('id', session('current_store'))->first();
        return view('merchant.setting', compact('merchant', 'store'));
    }

    // Get Sub Categories
    public function getSubcategories(Request $request)
    {
        $mainCategories = $request->input('mainCategories', []);
        $subCategories = Category::whereIn('parent_id', $mainCategories)->get();
        $store = Store::where('id', session('current_store'))->first();

        $options = '';

        // Add nutrition category if main category IDs are 7 or 8
        if (in_array(7, $mainCategories) || in_array(8, $mainCategories)) {
            $nutritionCategory = Category::find(49);
            if ($nutritionCategory) {
                // Check if the nutrition category is in the store's subcategories
                $checked = !empty($store->subCategories) && $store->subCategories->contains('id', $nutritionCategory->id) ? 'checked' : '';
                $options .= '<div class="form-check">
                        <input class="form-check-input" type="checkbox" name="sub_category_id[]" value="' . $nutritionCategory->id . '" id="subCategoryCheckbox' . $nutritionCategory->id . '" ' . $checked . '>
                        <label class="form-check-label" for="subCategoryCheckbox' . $nutritionCategory->id . '">' . $nutritionCategory->title . '</label>
                    </div>';
            }
        }

        if ($subCategories->count() > 0) {
            foreach ($subCategories as $subCategory) {
                // Check if the subcategory is in the store's subcategories
                $checked = !empty($store->subCategories) && $store->subCategories->contains('id', $subCategory->id) ? 'checked' : '';

                $options .= '<div class="form-check">
                        <input class="form-check-input" type="checkbox" name="sub_category_id[]" value="' . $subCategory->id . '" id="subCategoryCheckbox' . $subCategory->id . '" ' . $checked . '>
                        <label class="form-check-label" for="subCategoryCheckbox' . $subCategory->id . '">' . $subCategory->title . '</label>
                    </div>';
            }
        } else {
            $options .= '<p>No sub-categories available</p>';
        }

        return $options;
    }

    // Display the store settings form
    public function storeSettingForm()
    {
        $store = Store::where('id', session('current_store'))->first();

        // Categories
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

        $mainCategories = $store->mainCategories()->get();
        $interiorImages = $store->gallery()->where('category', 'interior')->get();
        $featuredPostImages = $store->gallery()->where('category', 'featured_post')->get();

        $storeAreas = $store->areas()->pluck('area')->toArray() ?? [];

        $storeDeliveryAreas = $store->deliveryAreas()->pluck('area')->toArray() ?? [];

        return view('merchant.store_setting', compact('store', 'categories', 'interiorImages', 'featuredPostImages', 'storeAreas', 'storeDeliveryAreas'));
    }

    // Store the settings
    public function storeSetting(Request $request)
    {
        $store = Store::where('id', session('current_store'))->first();

        if ($request->step == 'basic') {
            $validator = Validator::make($request->all(), [
                'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
                'cover_picture' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
                'category_id' => 'required',
                'sub_category_id' => 'required',
                'store_type' => 'required|array',
                'store_type.*' => 'in:online,physical',
                'email' => 'required|email',
                'phone' => 'required',
                'established_since' => 'required',
                'intro' => 'required'
            ], [
                'profile_picture.image' => 'The profile picture must be an image file (JPEG, PNG, JPG).',
                'profile_picture.mimes' => 'The profile picture format is not supported. Please use JPEG, PNG, or JPG.',
                'profile_picture.max' => 'The profile picture cannot be larger than 2MB.',
                'cover_picture.image' => 'The cover picture must be an image file (JPEG, PNG, JPG).',
                'cover_picture.mimes' => 'The cover picture format is not supported. Please use JPEG, PNG, or JPG.',
                'cover_picture.max' => 'The cover picture cannot be larger than 2MB.',
                'category_id.required' => 'The category field is required.',
                'sub_category_id.required' => 'The sub category field is required.',
                'store_type.required' => 'Please select at least one store type.',
                'store_type.array' => 'The store type must be an array.',
                'store_type.*.in' => 'Invalid store type selected.',
                'email.required' => 'The email field is required.',
                'email.email' => 'Please provide a valid email address.',
                'phone.required' => 'The phone field is required.',
                'established_since.required' => 'The established since field is required.',
                'intro.required' => 'The intro field is required.'
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput()->with('sec', 'basic');
            }
        }

        // Basic Setting
        if ($request->step == 'basic') {

            $basicDataUpdate = [
                'store_type' => $request->store_type,
                'email' => $request->email,
                'phone' => $request->phone,
                'established_since' => $request->established_since,
                'intro' => $request->intro,
                'tags' =>$request->tags
            ];

            // Check if profile picture file exists in the request
            if ($request->hasFile('profile_picture')) {
                $profilePictureFile = FileUpload::uploadOriginalFile($request->file('profile_picture'));
                $basicDataUpdate['profile_picture'] = $profilePictureFile;
            }

            // Check if cover picture file exists in the request
            if ($request->hasFile('cover_picture')) {
                $coverPictureFile = FileUpload::uploadOriginalFile($request->file('cover_picture'));
                $basicDataUpdate['cover_picture'] = $coverPictureFile;
            }

             // Products
             if ($request->has('products')) {
                $products = $request->products;
                $store->products()->delete();
                foreach (explode(',', $products) as $productName) {
                    if (!empty($productName)) {
                        $store->products()->create(['product' => $productName]);
                    }
                }
            } else {
                $store->products()->delete();
            }

            // Services
            if ($request->has('services')) {
                $services = $request->services;
                $store->services()->delete();
                foreach (explode(',', $services) as $serviceName) {
                    if (!empty($serviceName)) {
                        $store->services()->create(['service' => $serviceName]);
                    }
                }
            } else {
                $store->services()->delete();
            }
            
            $store->update($basicDataUpdate);

            // Store Category
            if ($request->has('category_id')) {
                $store->mainCategories()->sync($request->category_id);
            }

            // Store Sub Category
            if ($request->has('sub_category_id')) {
                $store->subCategories()->sync($request->sub_category_id);
            }

            return redirect()->route('merchant.storeSettingForm', ['sec' => 'basic'])->with('success', 'Basic settings updated successfully.');
        }


        // Validate 'area' and 'address' if 'physical' store type is selected
        if ($request->step == 'area' && in_array('physical', $store->store_type)) {
            $validator = Validator::make($request->all(), [
                'area' => 'required|array',
                'area.*' => 'required',
                'address.*' => 'required',
            ], [
                'area.required' => 'Please select at least one area.',
                'area.*.required' => 'Please provide the address for all selected areas.',
                'address.*.required' => 'Please provide the address for all selected areas.',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput()->with('sec', 'area');
            }
        }


        // Validate 'delivery_area' if 'online' store type is selected
        if ($request->step == 'area' && in_array('online', $store->store_type)) {
            $validator = Validator::make($request->all(), [
                'delivery_area' => 'required|array',
                'delivery_area.*' => 'required',
            ], [
                'delivery_area.required' => 'Please select at least one delivery area.',
                'delivery_area.*.required' => 'Please provide the address for all selected areas.',
            ]);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput()->with('sec', 'area');
            }
        }

        // Area Setting
        if ($request->step == 'area') {
            if (in_array('physical', $store->store_type)) {
                // Store Areas
                $store->areas()->delete();
                foreach ($request->area as $areaName) {
                    $store->areas()->create([
                        'area' => $areaName,
                        'address' => $request->input('address.' . $areaName)
                    ]);
                }
            }


            if (in_array('online', $store->store_type)) {
                // Store Delivery Areas
                $store->deliveryAreas()->delete();
                foreach ($request->delivery_area as $deliveryAreaName) {
                    if ($deliveryAreaName != 'all') {
                        $store->deliveryAreas()->create([
                            'area' => $deliveryAreaName
                        ]);
                    }
                }
            }

            return redirect()->route('merchant.storeSettingForm', ['sec' => 'area'])->with('success', 'Area settings updated successfully.');
        }

        if ($request->step == 'external_links') {
            $validator = Validator::make($request->all(), [
                'facebook' => 'required|url',
                'twitter' => 'nullable|url',
                'instagram' => 'nullable|url',
                'linkedin' => 'nullable|url',
                'website' => 'nullable|url',
                'map_url' => 'nullable|url'
            ], [
                'facebook.required' => 'The Facebook field is required.',
                'facebook.url' => 'The Facebook URL format is invalid.',
                'twitter.url' => 'The Twitter URL format is invalid.',
                'instagram.url' => 'The Instagram URL format is invalid.',
                'linkedin.url' => 'The LinkedIn URL format is invalid.',
                'website.url' => 'The Website URL format is invalid.',
                'map_url.url' => 'The Map URL format is invalid.'
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput()->with('sec', 'basic');
            }
        }

        // External Links Setting
        if ($request->step == 'external_links') {
            $externalLinksDataUpdate = [
                'email' => $request->email,
                'facebook' => $request->facebook,
                'twitter' => $request->twitter,
                'instagram' => $request->instagram,
                'linkedin' => $request->linkedin,
                'website' => $request->website,
                'map_url' => $request->map_url
            ];

            $store->update($externalLinksDataUpdate);

            return redirect()->route('merchant.storeSettingForm', ['sec' => 'external_links'])->with('success', ' External Links settings updated successfully.');
        }


        // Interior
        if ($request->step == 'interior') {
            $validator = Validator::make($request->all(), [
                'interiorImages.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            ], [
                'interiorImages.*.image' => 'The file must be an image (jpeg, png, jpg).',
                'interiorImages.*.mimes' => 'Only jpeg, png, and jpg files are allowed.',
                'interiorImages.*.max' => 'The file size must not exceed 2048 kilobytes.'
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput()->with('sec', 'interior');
            }
        }

        if ($request->step == 'interior') {
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

            return redirect()->route('merchant.storeSettingForm', ['sec' => 'interior'])->with('success', 'Interior settings updated successfully.');
        }

        // Featured Post
        if ($request->step == 'featured_post') {
            $validator = Validator::make($request->all(), [
                'featured_post_type' => 'required',
                'featuredPosts.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            ], [
                'featured_post_type.required' => 'The Featured Post Type field is required.',
                'featuredPosts.*.image' => 'The file must be an image (jpeg, png, jpg).',
                'featuredPosts.*.mimes' => 'Only jpeg, png, and jpg files are allowed.',
                'featuredPosts.*.max' => 'The file size must not exceed 2048 kilobytes.'
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput()->with('sec', 'interior');
            }
        }


        if ($request->step == 'featured_post') {
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

            return redirect()->route('merchant.storeSettingForm', ['sec' => 'featured_post'])->with('success', 'Featured Post settings updated successfully.');
        }

        // Opening Hours
        if ($request->step == 'opening_hours') {
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


            return redirect()->route('merchant.storeSettingForm', ['sec' => 'opening_hours'])->with('success', 'Opening hours settings updated successfully.');
        }
    }

    // Display the account settings form
    public function accountSettingForm()
    {
        $merchant = User::findOrFail(auth()->user()->id);
        return view('merchant.account_setting', compact('merchant'));
    }

    // Display the account settings
    public function accountSetting(Request $request)
    {
        $merchant = User::findOrFail(auth()->user()->id);

        try {
            $validatedData = $request->validate([
                'merchant_first_name' => 'required|string',
                'merchant_last_name' => 'required|string',
                'merchant_email' => 'required|email|unique:dn_users,email,' . $merchant->id,
                'merchant_phone' => 'required|string|unique:dn_users,phone,' . $merchant->id,
                'merchant_birth_day' => 'required|numeric',
                'merchant_birth_month' => 'required|numeric',
                'merchant_birth_year' => 'required|numeric',
                'merchant_password' => 'nullable|string|min:8|same:merchant_password_confirmation'
            ], [
                'merchant_first_name.required' => 'The first name field is required.',
                'merchant_last_name.required' => 'The last name field is required.',
                'merchant_email.required' => 'The email field is required.',
                'merchant_email.email' => 'Please enter a valid email address.',
                'merchant_email.unique' => 'This email address is already in use.',
                'merchant_phone.required' => 'The phone number field is required.',
                'merchant_phone.unique' => 'This phone number is already in use.',
                'merchant_birth_day.required' => 'The birth day field is required.',
                'merchant_birth_month.required' => 'The birth month field is required.',
                'merchant_birth_year.required' => 'The birth year field is required.',
                'merchant_password.min' => 'Password must be at least 8 characters long.',
                'merchant_password.same' => 'The password and confirmation must match.',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Validation failed
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput($request->all());
        }

        $merchant->update([
            'first_name' => $request->merchant_first_name,
            'last_name' => $request->merchant_last_name,
            'email' => $request->merchant_email,
            'phone' => $request->merchant_phone,
            'password' => $request->filled('merchant_password') ? Hash::make($request->merchant_password) : $merchant->password,
            'birth_day' => $request->merchant_birth_day,
            'birth_month' => $request->merchant_birth_month,
            'birth_year' => $request->merchant_birth_year,
            'business_type' => $request->business_type
        ]);

        return redirect('merchant/setting?type=merchant')->with('success', 'Settings saved successfully');
    }

    // Gallery Item Remove
    public function galleryItemRemove($id)
    {
        $interiorImage = StoreGallery::findOrFail($id);
        $interiorImage->delete();

        return response()->json(['success' => true]);
    }
}
