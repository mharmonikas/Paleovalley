<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
            return response()->json(['status' => false, 'message' => 'Product does not exist.', 'errors' => $e->getMessage()]);
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
        try {
            $validate = Validator::make($request->all(), [
                'name' => 'required|string',
                'description' => 'required|string',
                'price' => 'required|numeric|gt:0',
            ]);

            if($validate->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'Validation error.',
                    'errors' => $validate->errors()
                ], 422);
            }

            $product = Product::create([
                'name' => $request->name,
                'description' => $request->description,
                'price' => $request->price,
            ]);

            return response()->json(['status' => true, 'message' => "Product with ID of {$product->id} created successfully."]);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => 'Can not create product.', 'errors' => $e->getMessage()]);
        }
    }

    /**
     * Update the specified product in the database.
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(Request $request, int $id): JsonResponse
    {
        try {
            $validate = Validator::make($request->all(), [
                'name' => 'required|string',
                'description' => 'required|string',
                'price' => 'required|numeric',
            ]);

            if ($validate->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation error.',
                    'errors' => $validate->errors()
                ], 422);
            }

            Product::whereId($id)->update([
                'name' => (string)$request->name,
                'description' => $request->description,
                'price' => $request->price,
            ]);

            return response()->json(['status' => true, 'message' => 'Product updated successfully.']);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => 'Product not updated.', 'errors' => $e->getMessage()]);
        }
    }

    /**
     * Remove the specified product from database.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            $product = Product::findOrFail($id);

            $product->delete();

            return response()->json(['status' => true, 'message' => 'Product deleted successfully.']);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => 'Product does not exist', 'errors' => $e->getMessage()]);
        }
    }
}
