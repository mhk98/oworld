<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Store;
use App\Models\Billboard;
use App\Helpers\FileUpload;

class BillboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filters = [
            'store' => $request->store
        ];

        $billboards = Billboard::where(function ($query) use ($filters) {
            if ($filters['store']) {
                $query->where('store_id', $filters['store']);
            }
        })->orderBy('published_date', 'desc')->paginate(100);

        $stores = Store::where('status', 'active')->get();
        return view('admin.billboards.index', compact('billboards', 'stores'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $stores = Store::where('status', 'active')->orderBy('id', 'desc')->get();
        return view('admin.billboards.create', compact('stores'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:5120',
            'store_id' => 'required',
            'published_date' => 'required'
        ]);

        $input = request()->all();

        // Handle image
        if ($request->hasFile('image')) {
            $imagePath = FileUpload::uploadOriginalFile($request->file('image'));
            $input['image'] = $imagePath;
        }

        // Billboard Id
        $input['billboard_id'] = mt_rand(10000000, 99999999);
        Billboard::create($input);

        return redirect()->route('admin.billboards.index')
            ->with('success', 'Billboard added successfully!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $billboard = Billboard::findOrFail($id);
        $stores = Store::where('status', 'active')->orderBy('id', 'desc')->get();
        return view('admin.billboards.edit', compact('billboard', 'stores'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'image' => 'nullable|image|mimes:jpg,png,jpeg,gif,svg|max:5120',
            'store_id' => 'required',
            'published_date' => 'required'
        ]);

        $input = request()->all();
        $billboard = Billboard::findOrFail($id);

        // Handle image
        if ($request->hasFile('image')) {
            $imagePath = FileUpload::uploadOriginalFile($request->file('image'));
            $input['image'] = $imagePath;
        }

        $billboard->update($input);

        return redirect()->route('admin.billboards.index')
            ->with('success', 'Billboard updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $billboard = Billboard::findOrFail($id);
        $billboard->delete();

        return redirect()->route('admin.billboards.index')
            ->with('success', 'Billboard deleted successfully!');
    }
}
