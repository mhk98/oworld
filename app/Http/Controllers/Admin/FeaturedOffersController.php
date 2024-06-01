<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FeaturedContent;
use App\Models\FeaturedSection;
use App\Models\Store;
use App\Helpers\FileUpload;

class FeaturedOffersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filters = [
            'title' => $request->title,
            'section' => $request->section,
            'status' => $request->status
        ];

        $featuredOffers = FeaturedContent::where('content_type', 'offer')
            ->where(function ($query) use ($filters) {
                if ($filters['title']) {
                    $query->where('title', $filters['title']);
                }
                if ($filters['section']) {
                    $query->where('featured_section_id', $filters['section']);
                }
                if ($filters['status']) {
                    $query->where('status', $filters['status']);
                }
            })->orderBy('serial', 'asc')->paginate(100);

        $featuredSections = FeaturedSection::where('content_type', 'Offers')->orderBy('serial', 'asc')->get();

        return view('admin.featured_offers.index', compact('featuredOffers', 'featuredSections'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $featuredSections = FeaturedSection::where('content_type', 'Offers')->orderBy('serial', 'asc')->get();
        $stores = Store::where('status', 'active')->orderBy('business_name', 'asc')->get();

        return view('admin.featured_offers.create', compact('featuredSections', 'stores'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'title' => 'required',
            'featured_section_id' => 'required',
            'store_id' => 'required',
            'serial' => 'required',
            'offerImages' => 'nullable|array|min:1',
            'offerImages.*' => 'image|mimes:jpg,png,jpeg,gif,svg|max:2048',
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

        FeaturedContent::create([
            'featured_section_id' => $request->featured_section_id,
            'featured_content_id' => mt_rand(10000000, 99999999),
            'store_id' => $request->store_id,
            'title' => $request->title,
            'thumbnail' => $thumbnailFile,
            'images' => $offerImagePaths,
            'description' => $request->description,
            'content_type' => 'offer',
            'serial' => $request->serial,
            'status' =>  $request->status
        ]);

        return redirect()->route('admin.featured-offers.index')
            ->with('success', 'Featured Offer added successfully!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $featuredOffer = FeaturedContent::findOrFail($id);
        $featuredSections = FeaturedSection::where('content_type', 'Offers')->orderBy('serial', 'asc')->get();
        $stores = Store::where('status', 'active')->orderBy('business_name', 'asc')->get();

        return view('admin.featured_offers.edit', compact('featuredOffer', 'featuredSections', 'stores'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'title' => 'required',
            'featured_section_id' => 'required',
            'store_id' => 'required',
            'serial' => 'required',
            'offerImages' => 'nullable|array|min:1',
            'offerImages.*' => 'image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            'status' => 'required'
        ]);

        $featuredOffer = FeaturedContent::findOrFail($id);

        // Handle image
        $offerImagePaths = $featuredOffer->images ?? [];
        $thumbnailFile = $featuredOffer->thumbnail;

        if ($request->hasFile('offerImages')) {
            $firstImage = $request->file('offerImages')[0];
            $thumbnailFile = FileUpload::generatePreviewImage($firstImage, 450, 350);

            // Replace existing images
            $offerImagePaths = [];
            foreach ($request->file('offerImages') as $image) {
                $offerImagePaths[] = FileUpload::uploadOriginalFile($image);
            }
        }

        $featuredOffer->update([
            'featured_section_id' => $request->featured_section_id,
            'store_id' => $request->store_id,
            'title' => $request->title,
            'thumbnail' => $thumbnailFile,
            'images' => $offerImagePaths,
            'description' => $request->description,
            'status' => $request->status
        ]);

        return redirect()->route('admin.featured-offers.index')
            ->with('success', 'Featured Offer updated successfully!');
    }


    // Remove Featured Offer Image
    public function removeImage(Request $request)
    {
        $offerId = $request->input('offerId');
        $imageId = $request->input('imageId');

        $offer = FeaturedContent::findOrFail($offerId);
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
        $featuredOffer = FeaturedContent::findOrFail($id);
        $featuredOffer->delete();

        return redirect()->route('admin.featured-offers.index')
            ->with('success', 'Featured Offer deleted successfully!');
    }
}
