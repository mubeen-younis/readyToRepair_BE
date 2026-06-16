<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Support\ProductLabel;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

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

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'id' => ['nullable', 'string', 'max:255', 'unique:products,id'],
            'name' => ['required', 'string', 'max:255'],
            'image' => ['required', 'string', 'max:500'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:products,slug'],
            'price' => ['required', 'integer', 'min:0'],
        ]);

        $id = $data['id'] ?? ProductLabel::nextProductId();
        $name = trim($data['name']);
        $slug = $data['slug'] ?? ProductLabel::uniqueSlug($name);

        if (Product::query()->where('slug', $slug)->exists()) {
            return response()->json(['error' => 'Slug already exists.'], 422);
        }

        $product = Product::query()->create([
            'id' => $id,
            'name' => $name,
            'image' => trim($data['image']),
            'slug' => $slug,
            'price' => $data['price'],
        ]);

        return response()->json($this->transform($product), 201);
    }

    public function update(Request $request, string $productId): JsonResponse
    {
        $product = Product::query()->find($productId);

        if ($product === null) {
            return response()->json(['error' => 'Product not found.'], 404);
        }

        $data = $request->validate([
            'name' => ['sometimes', 'required', 'string', 'max:255'],
            'image' => ['sometimes', 'required', 'string', 'max:500'],
            'slug' => ['sometimes', 'nullable', 'string', 'max:255', 'unique:products,slug,'.$product->id.',id'],
            'price' => ['sometimes', 'required', 'integer', 'min:0'],
        ]);

        if (array_key_exists('name', $data)) {
            $product->name = trim($data['name']);
        }

        if (array_key_exists('image', $data)) {
            $product->image = trim($data['image']);
        }

        if (array_key_exists('price', $data)) {
            $product->price = $data['price'];
        }

        if (array_key_exists('slug', $data)) {
            $product->slug = $data['slug'] !== null && $data['slug'] !== ''
                ? ProductLabel::slugify($data['slug'])
                : ProductLabel::uniqueSlug($product->name, $product->id);
        } elseif (array_key_exists('name', $data)) {
            $product->slug = ProductLabel::uniqueSlug($product->name, $product->id);
        }

        $product->save();

        return response()->json($this->transform($product));
    }

    public function destroy(string $productId): JsonResponse
    {
        $product = Product::query()->find($productId);

        if ($product === null) {
            return response()->json(['error' => 'Product not found.'], 404);
        }

        if ($product->orderItems()->exists()) {
            return response()->json([
                'error' => 'This product is linked to existing orders and cannot be deleted.',
            ], 422);
        }

        $product->delete();

        return response()->json(['message' => 'Product deleted.']);
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
