<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FeaturedSection;
use App\Models\FeaturedStore;
use App\Models\Store;

class FeaturedStoresController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filters = [
            'store' => $request->store,
            'section' => $request->section
        ];

        $featuredStores = FeaturedStore::where(function ($query) use ($filters) {
            if ($filters['store']) {
                $query->where('store_id', $filters['store']);
            }
            if ($filters['section']) {
                $query->where('featured_section_id', $filters['section']);
            }
        })->orderBy('serial', 'asc')->paginate(100);

        $featuredSections = FeaturedSection::where('content_type', 'Stores')->orderBy('serial', 'asc')->get();

        return view('admin.featured_stores.index', compact('featuredStores', 'featuredSections'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $featuredSections = FeaturedSection::where('content_type', 'Stores')->orderBy('serial', 'asc')->get();
        $stores = Store::where('status', 'active')->orderBy('business_name', 'asc')->get();

        return view('admin.featured_stores.create', compact('featuredSections', 'stores'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'featured_section_id' => 'required',
            'store_id' => 'required',
            'serial' => 'required'
        ]);

        FeaturedStore::create([
            'featured_section_id' => $request->featured_section_id,
            'store_id' => $request->store_id,
            'serial' => $request->serial
        ]);

        return redirect()->route('admin.featured-stores.index')
            ->with('success', 'Featured Store added successfully!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $featuredStore = FeaturedStore::findOrFail($id);
        $featuredSections = FeaturedSection::where('content_type', 'Stores')->orderBy('serial', 'asc')->get();
        $stores = Store::where('status', 'active')->orderBy('business_name', 'asc')->get();

        return view('admin.featured_stores.edit', compact('featuredStore', 'featuredSections', 'stores'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'featured_section_id' => 'required',
            'store_id' => 'required',
            'serial' => 'required'
        ]);

        $featuredStore = FeaturedStore::findOrFail($id);
        $featuredStore->update([
            'featured_section_id' => $request->featured_section_id,
            'store_id' => $request->store_id,
            'serial' => $request->serial
        ]);

        return redirect()->route('admin.featured-stores.index')
            ->with('success', 'Featured Store updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $featuredStore = FeaturedStore::findOrFail($id);
        $featuredStore->delete();

        return redirect()->route('admin.featured-stores.index')
            ->with('success', 'Featured Store deleted successfully!');
    }
}
