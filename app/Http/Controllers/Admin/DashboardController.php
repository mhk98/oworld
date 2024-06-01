<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Store;
use App\Models\Post;
use App\Models\Offer;
use App\Models\Billboard;
use App\Models\Highlight;
use App\Models\Category;
use App\Models\StoreGallery;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    // Dashboard
    public function dashboard()
    {
        $totalUsers = User::where('is_merchant', false)->where('is_admin', false)->count();
        $totalMerchants = User::where('is_merchant', true)->count();
        $totalStores = Store::count();
        $totalPosts = Post::count();
        $totalOffers = Offer::count();
        $totalHighlights = Highlight::count();
        $totalBillboards = Billboard::count();

        return view('admin.dashboard', compact('totalUsers', 'totalMerchants', 'totalStores', 'totalPosts', 'totalOffers', 'totalHighlights', 'totalBillboards'));
    }

     // Get Sub Categories
     public function getSubcategories(Request $request)
     {
         $mainCategories = $request->input('mainCategories', []);
         $subCategories = Category::whereIn('parent_id', $mainCategories)->get();
 
         $options = '';
         foreach ($subCategories as $subCategory) {
             $options .= '<option value="' . $subCategory->id . '">' . $subCategory->title . '</option>';
         }
 
         return $options;
     }

       // Gallery Item Remove
    public function galleryItemRemove($id)
    {
        $interiorImage = StoreGallery::findOrFail($id);
        $interiorImage->delete();

        return response()->json(['success' => true]);
    }

    // Logout
    public function logout()
    {
        Auth::logout();
        return redirect()->route('adminAuth.loginForm')->with('error', 'Please Login To Your Account!');
    }
}
