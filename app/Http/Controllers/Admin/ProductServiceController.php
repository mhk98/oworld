<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StoreProduct;
use App\Models\StoreService;
use App\Models\SimilarWord;

class ProductServiceController extends Controller
{
    /**
     * Display a listing of products and services.
     *
     * @return \Illuminate\View\View
     */
    public function productsServices()
    {
        $products = StoreProduct::select('product')
            ->distinct()
            ->paginate(300);

        $services = StoreService::select('service')
            ->distinct()
            ->paginate(300);

        return view('admin.products_services.index', compact('products', 'services'));
    }

    /**
     * Show the form for editing the specified product.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function similarWord($word)
    {
        $similarWords = SimilarWord::where('word', $word)->get();
        return view('admin.products_services.similar_words', compact('word', 'similarWords'));
    }

    /**
     * Update the similar words for a specified word in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $word
     * @return \Illuminate\Http\Response
     */
    public function updateSimilarWord(Request $request, $word)
    {
        $inputSimilarWords = array_map('trim', explode(',', $request->input('similar_words')));

        SimilarWord::where('word', $word)->delete();

        foreach ($inputSimilarWords as $inputSimilarWord) {
            SimilarWord::create([
                'word' => $word,
                'similar' => $inputSimilarWord
            ]);
        }

        return redirect()->route('admin.products_services')->with('success', 'Similar words updated successfully.');
    }
}
