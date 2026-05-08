<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductApiController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::with(['category'])
            ->where('is_active', true)
            ->when($request->search, fn($q) => 
                $q->where('name', 'like', '%'.$request->search.'%')
            )
            ->when($request->category, fn($q) => 
                $q->whereHas('category', fn($q) => 
                    $q->where('slug', $request->category)
                )
            )
            ->paginate($request->get('per_page', 12));

        return response()->json($products);
    }

    public function show(string $slug)
    {
        $product = Product::with(['category'])
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        return response()->json($product);
    }
}