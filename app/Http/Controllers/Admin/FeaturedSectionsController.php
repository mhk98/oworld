<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FeaturedSection;
use App\Models\Store;

class FeaturedSectionsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $featuredSections = FeaturedSection::orderBy('serial', 'asc')->paginate(100);
        return view('admin.featured_sections.index', compact('featuredSections'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $stores = Store::where('status', 'active')->orderBy('id', 'desc')->get();
        return view('admin.featured_sections.create', compact('stores'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'serial' => 'required|integer',
            'content_type' => 'required|string|max:255',
            'status' => 'required|in:active,inactive',
        ]);

        $input = $request->all();
        $featuredSection = FeaturedSection::create($input);

        return redirect()->route('admin.featured-sections.index')
            ->with('success', 'Featured Section added successfully!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $featuredSection = FeaturedSection::findOrFail($id);
        return view('admin.featured_sections.edit', compact('featuredSection'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'serial' => 'required|integer',
            'content_type' => 'required|string|max:255',
            'status' => 'required|in:active,inactive',
        ]);

        $featuredSection = FeaturedSection::findOrFail($id);
        $featuredSection->update($request->all());

        return redirect()->route('admin.featured-sections.index')->with('success', 'Featured Section updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $featuredSection = FeaturedSection::findOrFail($id);
        $featuredSection->delete();

        return redirect()->route('admin.featured-sections.index')->with('success', 'Featured Section deleted successfully!');
    }
}
