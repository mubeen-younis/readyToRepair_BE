<?php

namespace App\Support;

use App\Models\Product;

class ProductLabel
{
    public static function deriveLabelFromPath(string $path): string
    {
        $raw = urldecode(basename($path));
        $base = preg_replace('/\.[^.]+$/', '', $raw) ?? $raw;
        $base = preg_replace('/\(\d+\)/', '', $base) ?? $base;
        $base = preg_replace('/[_-]+/', ' ', $base) ?? $base;
        $base = preg_replace('/\binto\b/i', ' x ', $base) ?? $base;
        $base = preg_replace('/\s{2,}/', ' ', trim($base)) ?? trim($base);

        return self::toTitleCase($base);
    }

    public static function slugify(string $value): string
    {
        $slug = strtolower($value);
        $slug = preg_replace('/[^a-z0-9]+/', '-', $slug) ?? $slug;

        return trim($slug, '-');
    }

    public static function uniqueSlug(string $name, ?string $excludeProductId = null): string
    {
        $baseSlug = self::slugify($name);
        $slug = $baseSlug;
        $suffix = 2;

        while (
            Product::query()
                ->where('slug', $slug)
                ->when($excludeProductId !== null, fn ($query) => $query->where('id', '!=', $excludeProductId))
                ->exists()
        ) {
            $slug = $baseSlug.'-'.$suffix;
            $suffix++;
        }

        return $slug;
    }

    public static function nextProductId(): string
    {
        $maxNumber = Product::query()
            ->where('id', 'like', 'product-%')
            ->get(['id'])
            ->map(fn (Product $product) => (int) str_replace('product-', '', $product->id))
            ->max() ?? 0;

        return 'product-'.($maxNumber + 1);
    }

    private static function toTitleCase(string $value): string
    {
        $segments = preg_split('/\s+/', trim($value)) ?: [];

        return collect($segments)
            ->filter()
            ->map(fn (string $segment) => ucfirst(strtolower($segment)))
            ->implode(' ');
    }
}
