<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Store;
use App\Models\Post;
use App\Models\Category;
use App\Helpers\FileUpload;

class PostController extends Controller
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

        $posts = Post::where(function ($query) use ($filters) {
            if ($filters['store']) {
                $query->where('store_id', $filters['store']);
            }
            if ($filters['category']) {
                $query->where('category_id', $filters['category']);
            }
        })->orderBy('id', 'desc')->paginate(100);

        $stores = Store::where('status', 'active')->get();
        $categories = Category::where('status', 'active')->get();

        return view('admin.posts.index', compact('posts', 'stores', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $stores = Store::where('status', 'active')->orderBy('id', 'desc')->get();
        return view('admin.posts.create', compact('stores'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'postImages' => 'nullable|array|min:1',
            'postImages.*' => 'image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            'store_id' => 'required',
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
        $pinPost = $request->filled('pin_post');

        Post::create([
            'thumbnail' => $thumbnailFile,
            'images' => $postImagePaths,
            'description' => $request->description,
            'store_id' => $request->store_id,
            'post_id' => mt_rand(10000000, 99999999),
            'pin_post' => $pinPost ? true : false,
            'status' =>  $request->status
        ]);

        return redirect()->route('admin.posts.index')
            ->with('success', 'Post added successfully!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $post = Post::findOrFail($id);
        $stores = Store::where('status', 'active')->orderBy('id', 'desc')->get();

        return view('admin.posts.edit', compact('post', 'stores'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'postImages.*' => 'image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            'store_id' => 'required',
            'status' => 'required'
        ]);

        $post = Post::findOrFail($id);

        // Handle image
        $postImagePaths = $post->images;
        if ($request->hasFile('postImages')) {
            foreach ($request->file('postImages') as $image) {
                $postImagePaths[] = FileUpload::uploadOriginalFile($image);
            }
        }
        $pinPost = $request->filled('pin_post');

        $post->update([
            'images' => $postImagePaths,
            'description' => $request->description,
            'store_id' => $request->store_id,
            'pin_post' => $pinPost ? true : false,
            'status' =>  $request->status
        ]);

        return redirect()->route('admin.posts.index')
            ->with('success', 'Post updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $post = Post::findOrFail($id);
        $post->delete();

        return redirect()->route('admin.posts.index')
            ->with('success', 'Post deleted successfully!');
    }

    // Remove Post Image
    public function removeImage(Request $request) 
    {
        $postId = $request->input('postId');
        $imageId = $request->input('imageId');

        $post = Post::findOrFail($postId);
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
}
