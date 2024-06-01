<?php

namespace App\Http\Controllers\Merchant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\FileUpload;
use App\Models\Post;
use App\Models\Store;
use App\Models\Billboard;
use App\Models\Highlight;
use App\Models\Offer;
use Carbon\Carbon;

class StoreContentController extends Controller
{
    // Display store content form
    public function storeContentForm()
    {
        return view('merchant.store_content');
    }

    // Store Post
    public function storePost(Request $request)
    {
        $validatedData = $request->validate([
            'postImages.*' => 'required|image|mimes:jpeg,jpg,png'
        ]);

        // Handle Post images.
        $postImagePaths = [];
        $thumbnailFile = null;

        if ($request->hasFile('postImages')) {

            $firstImage = $request->file('postImages')[0];
            $thumbnailFile = FileUpload::generatePreviewImage($firstImage, 450, 350);

            foreach ($request->file('postImages') as $image) {
                $postImagePaths[] = FileUpload::uploadOriginalFile($image);
            }
        }

        $store = Store::where('id', session('current_store'))->first();
        $pinPost = $request->filled('pin_post');

        Post::create([
            'thumbnail' => $thumbnailFile,
            'images' => $postImagePaths,
            'description' => $request->description,
            'store_id' => $store->id,
            'post_id' => mt_rand(10000000, 99999999),
            'pin_post' => $pinPost ? true : false,
            'status' => 'published'
        ]);

        return redirect()->route('store', $store->slug)->with('success', 'Post published successfully!');
    }

    // Store Offer
    public function storeOffer(Request $request)
    {
        $request->validate([
            'offerImages.*' => 'required|image|mimes:jpeg,jpg,png',
            'offer_expiration' => 'required',
            'category_id' => 'required'
        ]);

        // Handle offer images.
        $offerImagePaths = [];
        $thumbnailFile = null;

        if ($request->hasFile('offerImages')) {
            $firstImage = $request->file('offerImages')[0];
            $thumbnailFile = FileUpload::generatePreviewImage($firstImage, 450, 350);

            foreach ($request->file('offerImages') as $image) {
                $offerImagePaths[] = FileUpload::uploadOriginalFile($image);
            }
        }

        $store = Store::where('id', session('current_store'))->first();

        // Date
        $userInputDate = $request->offer_expiration;
        $expirationDateTime = Carbon::createFromFormat('Y-m-d', $userInputDate)
            ->endOfDay();
        $formattedExpirationDate = $expirationDateTime->format('Y-m-d H:i:s');

        Offer::create([
            'thumbnail' => $thumbnailFile,
            'images' => $offerImagePaths,
            'description' => $request->description,
            'offer_expiration' => $formattedExpirationDate,
            'category_id' => $request->category_id,
            'offer_id' => mt_rand(10000000, 99999999),
            'store_id' => $store->id,
            'status' => 'published'
        ]);

        return redirect()->route('store', $store->slug)->with('success', 'Offer submitted successfully! It is now under review.');
    }

    // Store Billboard
    public function storeBillboard(Request $request)
    {
        $request->validate([
            'billboard_image' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:5120',
            'published_date' => 'required'
        ], [
            'billboard_image.required' => 'Please upload a billboard image.',
            'billboard_image.image' => 'The file must be an image.',
            'billboard_image.mimes' => 'Only JPG, PNG, JPEG, GIF, and SVG formats are allowed.',
            'billboard_image.max' => 'The image size must not exceed 5MB.',
            'published_date.required' => 'Please specify the published date.'
        ]);

        // Handle Billboard image.
        if ($request->hasFile('billboard_image')) {
            $billboardImagePath = FileUpload::uploadOriginalFile($request->file('billboard_image'));
        }

        $store = Store::where('id', session('current_store'))->first();
        Billboard::create([
            'image' => $billboardImagePath,
            'description' => $request->description,
            'billboard_id' => mt_rand(10000000, 99999999),
            'store_id' => $store->id,
            'published_date' => $request->published_date,
            'status' => 'pending'
        ]);

        return redirect()->route('store', $store->slug)->with('success', 'Billboard submitted successfully! It is now under review.');
    }


    // Get Slots
    public function getSlots(Request $request)
    {
        // Validate
        $request->validate([
            'category_id' => 'required',
            'published_date' => 'required'
        ]);

        $categoryId = $request->category_id;
        $slotDate = $request->published_date;

        $html = '';

        for ($i = 1; $i <= 30; $i++) {
            $isAvailable = !Highlight::where('category_id', $categoryId)
                ->where('published_date', $slotDate)
                ->where('slot', $i)
                ->exists();

            $html .= '<input type="radio" name="slot" value="' . $i . '" id="slot-' . $i . '"';
            if (!$isAvailable) {
                $html .= ' disabled';
            }
            $html .= '/>';
            $html .= '<label for="slot-' . $i . '">' . $i . '</label><br>';
        }

        return $html;
    }


    // Store Highlight
    public function storeHighlight(Request $request)
    {
        $request->validate([
            'highlight_image' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            'category_id' => 'required',
            'published_date' => 'required',
            'slot' => 'required'
        ]);

        // Handle Billboard image.
        if ($request->hasFile('highlight_image')) {
            $thumbnailFile = FileUpload::generatePreviewImage($request->file('highlight_image'), 180, 290);
            $highlightImagePath = FileUpload::uploadOriginalFile($request->file('highlight_image'));
        }

        $store = Store::findOrFail(session('current_store'));

        Highlight::create([
            'thumbnail' => $thumbnailFile,
            'image' => $highlightImagePath,
            'description' => $request->description,
            'category_id' => $request->category_id,
            'store_id' => $store->id,
            'published_date' => $request->published_date,
            'slot' => $request->slot,
            'highlight_id' => mt_rand(10000000, 99999999),
            'status' => 'pending'
        ]);

        return redirect()->route('store', $store->slug)->with('success', 'Highlight submitted successfully. It is now pending approval.');
    }


    // Delete Content
    public function deleteContent(Request $request)
    {
        $request->validate([
            'content_type' => 'required',
            'content_id' => 'required'
        ]);

        $contentType = $request->content_type;
        $contentId = $request->content_id;

        switch ($contentType) {
            case 'post':
                Post::destroy($contentId);
                break;
            case 'offer':
                Offer::destroy($contentId);
                break;
            case 'billboard':
                Billboard::destroy($contentId);
                break;
            case 'highlight':
                Highlight::destroy($contentId);
                break;
            default:
                return back()->with('error', 'Invalid content type.');
        }

        return back()->with('success', 'Content deleted successfully.');
    }

    // Update Content
public function updateContent(Request $request)
{
    $request->validate([
        'content_type' => 'required',
        'content_id' => 'required',
        'description' => 'required'
    ]);

    $contentType = $request->content_type;
    $contentId = $request->content_id;
    $description = $request->description;

    switch ($contentType) {
        case 'post':
            $content = Post::findOrFail($contentId);
            break;
        case 'offer':
            $content = Offer::findOrFail($contentId);
            break;
        case 'billboard':
            $content = Billboard::findOrFail($contentId);
            break;
        case 'highlight':
            $content = Highlight::findOrFail($contentId);
            break;
        default:
            return back()->with('error', 'Invalid content type.');
    }

    $content->update(['description' => $description]);

    return response()->json(['success' => 'Content description updated successfully.']);
}

}
