<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    public function index(): JsonResponse
    {
        $products = Product::query()
            ->orderBy('id')
            ->get()
            ->map(fn (Product $product) => $this->transform($product));

        return response()->json($products);
    }

    public function show(string $slug): JsonResponse
    {
        $product = Product::query()->where('slug', $slug)->first();

        if ($product === null) {
            return response()->json(['error' => 'Product not found.'], 404);
        }

        return response()->json($this->transform($product));
    }

    /**
     * @return array<string, mixed>
     */
    private function transform(Product $product): array
    {
        return [
            'id' => $product->id,
            'name' => $product->name,
            'image' => $product->image,
            'slug' => $product->slug,
            'price' => $product->price,
        ];
    }
}
