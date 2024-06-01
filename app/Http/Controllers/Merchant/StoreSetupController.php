<?php

namespace App\Http\Controllers\Merchant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Store;
use App\Helpers\FileUpload;
use App\Notifications\EmailVerificationNotification;
use App\Models\UserVerify;
use Illuminate\Support\Str;
use Notification;

class StoreSetupController extends Controller
{

    // Welcome Page
    public function welcome()
    {
        return view('storeSetup.welcome');
    }

    // Steps En
    public function stepsEn()
    {
        return view('storeSetup.steps_en');
    }

    // Steps Bn
    public function stepsBn()
    {
        return view('storeSetup.steps_bn');
    }


    // Picture Form
    public function pictureForm()
    {
        $store = Store::findOrFail(session('current_store'));
        return view('storeSetup.picture', ['store' => $store]);
    }

    public function picture(Request $request)
    {
        $request->validate([
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'cover_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120'
        ], [
            'profile_picture.image' => 'The profile picture must be an image file (JPEG, PNG, JPG, GIF).',
            'profile_picture.mimes' => 'Supported formats for the profile picture are JPEG, PNG, JPG, or GIF.',
            'profile_picture.max' => 'The profile picture cannot exceed 5MB in size.',
            'cover_picture.image' => 'The cover picture must be an image file (JPEG, PNG, JPG, GIF).',
            'cover_picture.mimes' => 'Supported formats for the cover picture are JPEG, PNG, JPG, or GIF.',
            'cover_picture.max' => 'The cover picture cannot exceed 5MB in size.'
        ]);        
    
        $store = Store::findOrFail(session('current_store'));
    
        $profilePictureFile = $store->profile_picture;
        if ($request->hasFile('profile_picture')) {
            $profilePictureFile = FileUpload::uploadOriginalFile($request->file('profile_picture'));
        }
    
        $coverPictureFile = $store->cover_picture;
        if ($request->hasFile('cover_picture')) {
            $coverPictureFile = FileUpload::uploadOriginalFile($request->file('cover_picture'));
        }
    
        $store->update([
            'profile_picture' => $profilePictureFile,
            'cover_picture' => $coverPictureFile
        ]);
    
        return redirect()->route('merchant.categoryForm');
    }


    // Category Form
    public function categoryForm()
    {
        $store = Store::findOrFail(session('current_store'));
        return view('storeSetup.category', ['store' => $store]);
    }

    // Category
    public function category(Request $request)
    {
        $request->validate([
            'sub_category_id' => 'required'
        ], [
            'sub_category_id.required' => 'Please select a sub-category.'
        ]);

        // Store
        $store = Store::findOrFail(session('current_store'));

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

        return redirect()->route('merchant.externalLinksForm');
    }


    // External Links Form
    public function externalLinksForm()
    {
        // Store
        $store = Store::findOrFail(session('current_store'));
        return view('storeSetup.external_links', ['store' => $store]);
    }

    // External Links
    public function externalLinks(Request $request)
    {
        // Store
        $store = Store::findOrFail(session('current_store'));
        $store->update([
            'twitter' => $request->twitter,
            'instagram' => $request->instagram,
            'linkedin' => $request->linkedin,
            'website' => $request->website
        ]);

        return redirect()->route('merchant.filterForm');
    }

    // Filter From
    public function filterForm()
    {   
          // Store
          $store = Store::findOrFail(session('current_store'));

        return view('storeSetup.filters', ['store' => $store]);
    }

    // Filter
    public function filter(Request $request)
    {  
          // Store
          $store = Store::findOrFail(session('current_store'));

        // Filter
        $store->filter()->updateOrCreate([
            'store_id' =>  $store->id,
            'pre_order' => $request->has('pre_order') ? true : false,
            'in_stock' => $request->has('in_stock') ? true : false,
            'organic' => $request->has('organic') ? true : false,
            'home_delivery' => $request->has('home_delivery') ? true : false,
            'men' => $request->has('men') ? true : false,
            'women' => $request->has('women') ? true : false,
            'imported' => $request->has('imported') ? true : false,
            'local' => $request->has('local') ? true : false,
            'cuisine' => $request->has('cuisine') ? true : false,
            'indoor' => $request->has('indoor') ? true : false,
            'outdoor' => $request->has('outdoor') ? true : false
        ]);


        $store->update([
            'is_setup_complete' => true
        ]);


        // Email Verification Notification
        $token = Str::random(64);
        $verification = UserVerify::updateOrCreate(
            ['user_id' =>  $store->merchant->id],
            ['token' => $token]
        );
        Notification::route('mail', $store->merchant->email)->notify(new EmailVerificationNotification($token));

        return redirect()->route('store', $store->slug)->with('info', 'Check your email, we have sent a verification link.');
    }
}
