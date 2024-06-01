<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Store;
use App\Models\Highlight;
use App\Helpers\FileUpload;
use App\Models\Category;

class HighlightController extends Controller
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

        $highlights = Highlight::where(function ($query) use ($filters) {
            if ($filters['store']) {
                $query->where('store_id', $filters['store']);
            }
            if ($filters['category']) {
                $query->where('category_id', $filters['category']);
            }
        })->orderBy('id', 'desc')->paginate(100);

        $stores = Store::where('status', 'active')->get();
        $categories = Category::where('status', 'active')->where('is_parent', true)->get();

        return view('admin.highlights.index', compact('highlights', 'stores', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $stores = Store::where('status', 'active')->orderBy('id', 'desc')->get();
        $categories = Category::where('status', 'active')->where('is_parent', true)->get();

        return view('admin.highlights.create', compact('stores', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:5120',
            'category_id' => 'required',
            'published_date' => 'required',
            'slot' => 'required',
            'status' => 'required'
        ]);

        // Handle Highlight image.
        if ($request->hasFile('image')) {
            $thumbnailFile = FileUpload::generatePreviewImage($request->file('image'), 180, 290);
            $highlightImagePath = FileUpload::uploadOriginalFile($request->file('image'));
        }

        Highlight::create([
            'thumbnail' => $thumbnailFile,
            'image' => $highlightImagePath,
            'description' => $request->description,
            'category_id' => $request->category_id,
            'store_id' => $request->store_id,
            'published_date' => $request->published_date,
            'slot' => $request->slot,
            'highlight_id' => mt_rand(10000000, 99999999),
            'status' => $request->status
        ]);

        return redirect()->route('admin.highlights.index')
            ->with('success', 'Highlight added successfully!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $highlight = Highlight::findOrFail($id);
        $stores = Store::where('status', 'active')->orderBy('id', 'desc')->get();
        $categories = Category::where('status', 'active')->where('is_parent', true)->get();

        return view('admin.highlights.edit', compact('highlight', 'stores', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'image' => 'nullable|image|mimes:jpg,png,jpeg,gif,svg|max:5120',
            'category_id' => 'required',
            'published_date' => 'required',
           // 'slot' => 'required',
            'status' => 'required'
        ]);

        $input = request()->all();
        $highlight = Highlight::findOrFail($id);

        // Handle image
        if ($request->hasFile('image')) {
            $imagePath = FileUpload::uploadOriginalFile($request->file('image'));
            $input['image'] = $imagePath;
        }
        $highlight->update($input);

        return redirect()->route('admin.highlights.index')
            ->with('success', 'Highlight updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $highlight = Highlight::findOrFail($id);
        $highlight->delete();

        return redirect()->route('admin.highlights.index')
            ->with('success', 'Highlight deleted successfully!');
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
}
