<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    /**
     * Display a product.
     *
     * @param integer $id
     * @return JsonResponse
     */
    public function index(int $id): JsonResponse
    {
        try {
            $product = Product::findOrFail($id);

            return response()->json($product);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Product does not exist.']);
        }
    }

    /**
     * Store a newly created product.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $request->valdate([
            'name' => 'required|string|max:50',
            'description' => 'required|string|max:255',
            'price' => 'required|numeric|gt:0',
        ]);

        $product = Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
        ]);

        return response()->json($product);
    }

    /**
     * Update the specified product in the database.
     *
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function update(Request $request, $id)
    {
        $request->valdate([
            'name' => 'required|string|max:50',
            'description' => 'required|string|max:255',
            'price' => 'required|numeric|gt:0',
        ]);

        Product::where('id', $id)->update([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
        ]);

        return response()->json(['success' => 1]);
    }

    /**
     * Remove the specified product from database.
     *
     * @param Product $product
     * @return JsonResponse
     */
    public function destroy(Product $product): JsonResponse
    {
        $product->delete();

        return response()->json(['success' => 1]);
    }
}
