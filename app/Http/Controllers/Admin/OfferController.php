<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Store;
use App\Models\Offer;
use App\Models\Category;
use App\Helpers\FileUpload;

class OfferController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filters = [
            'store' => $request->store,
            'category' => $request->category
        ];


        $offers = Offer::where(function ($query) use ($filters) {
            if ($filters['store']) {
                $query->where('store_id', $filters['store']);
            }
        })->orderBy('id', 'desc')->paginate(100);

        $stores = Store::where('status', 'active')->get();
        $categories = Category::where('status', 'active')
        ->where('is_parent', true)->get();

        return view('admin.offers.index', compact('offers', 'stores', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {   
        $stores = Store::where('status', 'active')->orderBy('id', 'desc')->get();
        $categories = Category::where('status', 'active')
        ->where('is_parent', true)->get();

        return view('admin.offers.create', compact('stores', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'offerImages' => 'nullable|array|min:1',
            'offerImages.*' => 'image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            'offer_expiration' => 'required',
            'store_id' => 'required',
            'category_id' => 'required',
            'status' => 'required'
        ]);

        // Handle image
        $offerImagePaths = [];
        $thumbnailFile = null;
        if ($request->hasFile('offerImages')) {
            $firstImage = $request->file('offerImages')[0];
            $thumbnailFile = FileUpload::generatePreviewImage($firstImage, 450, 350);

            foreach ($request->file('offerImages') as $image) {
                $offerImagePaths[] = FileUpload::uploadOriginalFile($image);
            }
        }
        
        Offer::create([
            'thumbnail' => $thumbnailFile,
            'images' => $offerImagePaths,
            'description' => $request->description,
            'offer_expiration' => $request->offer_expiration,
            'store_id' => $request->store_id,
            'category_id' => $request->category_id,
            'offer_id' => mt_rand(10000000, 99999999),
            'status' =>  $request->status
        ]);

        return redirect()->route('admin.offers.index')
            ->with('success', 'Offer added successfully!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $offer = Offer::findOrFail($id);
        $stores = Store::where('status', 'active')->orderBy('id', 'desc')->get();
        $categories = Category::where('status', 'active')->get();

        return view('admin.offers.edit', compact('offer', 'stores', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'offerImages.*' => 'image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            'offer_expiration' => 'required',
            'store_id' => 'required',
            'category_id' => 'required',
            'status' => 'required'
        ]);

        $offer = Offer::findOrFail($id);

        // Handle image
        $offerImagePaths = $offer->images;
        if ($request->hasFile('offerImages')) {
            foreach ($request->file('offerImages') as $image) {
                $offerImagePaths[] = FileUpload::uploadOriginalFile($image);
            }
        }        

        $offer->update([
            'images' => $offerImagePaths,
            'description' => $request->description,
            'category_id' => $request->category_id,
            'store_id' => $request->store_id,
            'offer_expiration' => $request->offer_expiration,
            'status' =>  $request->status
        ]);

        return redirect()->route('admin.offers.index')
        ->with('success', 'Offer updated successfully!');
    }

    // Remove Image
   public function removeImage(Request $request)
   {
       $offerId = $request->input('offerId');
       $imageId = $request->input('imageId');

       $offer = Offer::findOrFail($offerId);
       $images = $offer->images;

       // Check if the image exists
       if (isset($images[$imageId])) {
           if (count($images) > 1) {
               unset($images[$imageId]);
               $offer->images = $images;
               $offer->save();

               return response()->json(['success' => true]);
           } else {
               return response()->json(['success' => false, 'message' => 'At least one image must remain'], 400);
           }
       } else {
           return response()->json(['success' => false, 'message' => 'Image not found'], 404);
       }
   }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $offer = Offer::findOrFail($id);
        $offer->delete();

        return redirect()->route('admin.offers.index')
            ->with('success', 'Offer deleted successfully!');
    }
}
