<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FeaturedContent;
use App\Models\FeaturedSection;
use App\Models\Store;
use App\Helpers\FileUpload;

class FeaturedPostsController extends Controller
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

        $featuredPosts = FeaturedContent::where('content_type', 'post')
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

        $featuredSections = FeaturedSection::where('content_type', 'Posts')->orderBy('serial', 'asc')->get();

        return view('admin.featured_posts.index', compact('featuredPosts', 'featuredSections'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $featuredSections = FeaturedSection::where('content_type', 'Posts')->orderBy('serial', 'asc')->get();
        $stores = Store::where('status', 'active')->orderBy('business_name', 'asc')->get();

        return view('admin.featured_posts.create', compact('featuredSections', 'stores'));
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
            'postImages' => 'nullable|array|min:1',
            'postImages.*' => 'image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            'status' => 'required'
        ]);

        // Handle image
        $postImagePaths = [];
        $thumbnailFile = null;
        if ($request->hasFile('postImages')) {
            $firstImage = $request->file('postImages')[0];
            $thumbnailFile = FileUpload::generatePreviewImage($firstImage, 450, 350);

            foreach ($request->file('postImages') as $image) {
                $postImagePaths[] = FileUpload::uploadOriginalFile($image);
            }
        }

        FeaturedContent::create([
            'featured_section_id' => $request->featured_section_id,
            'featured_content_id' => mt_rand(10000000, 99999999),
            'store_id' => $request->store_id,
            'title' => $request->title,
            'thumbnail' => $thumbnailFile,
            'images' => $postImagePaths,
            'description' => $request->description,
            'content_type' => 'post',
            'serial' => $request->serial,
            'status' =>  $request->status
        ]);

        return redirect()->route('admin.featured-posts.index')
            ->with('success', 'Featured Post added successfully!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $featuredPost = FeaturedContent::findOrFail($id);
        $featuredSections = FeaturedSection::where('content_type', 'Posts')->orderBy('serial', 'asc')->get();
        $stores = Store::where('status', 'active')->orderBy('business_name', 'asc')->get();

        return view('admin.featured_posts.edit', compact('featuredPost', 'featuredSections','stores'));
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
            'postImages' => 'nullable|array|min:1',
            'postImages.*' => 'image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            'status' => 'required'
        ]);

        $featuredPost = FeaturedContent::findOrFail($id);

        // Handle image
        $postImagePaths = $featuredPost->images ?? [];
        $thumbnailFile = $featuredPost->thumbnail;

        if ($request->hasFile('postImages')) {
            $firstImage = $request->file('postImages')[0];
            $thumbnailFile = FileUpload::generatePreviewImage($firstImage, 450, 350);

            // Replace existing images
            $postImagePaths = [];
            foreach ($request->file('postImages') as $image) {
                $postImagePaths[] = FileUpload::uploadOriginalFile($image);
            }
        }

        $featuredPost->update([
            'featured_section_id' => $request->featured_section_id,
            'store_id' => $request->store_id,
            'title' => $request->title,
            'thumbnail' => $thumbnailFile,
            'images' => $postImagePaths,
            'description' => $request->description,
            'status' => $request->status
        ]);

        return redirect()->route('admin.featured-posts.index')
            ->with('success', 'Featured Post updated successfully!');
    }


    // Remove Featured Post Image
    public function removeImage(Request $request) 
    {
        $postId = $request->input('postId');
        $imageId = $request->input('imageId');

        $post = FeaturedContent::findOrFail($postId);
        $images = $post->images;

        // Check if the image exists
        if (isset($images[$imageId])) {
            if (count($images) > 1) {
                unset($images[$imageId]);
                $post->images = $images;
                $post->save();

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
        $featuredPost = FeaturedContent::findOrFail($id);
        $featuredPost->delete();

        return redirect()->route('admin.featured-posts.index')
            ->with('success', 'Featured Post deleted successfully!');
    }
}
