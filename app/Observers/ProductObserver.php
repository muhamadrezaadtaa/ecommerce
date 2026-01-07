<?php

namespace App\Observers;

use App\Models\Product;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class ProductObserver
{
    /**
     * Handle the Product "created" event.
     */
    public function created(Product $product): void
    {
        // 1. Bersihkan cache yang berkaitan dengan list produk
        $this->clearCommonCaches($product);

        // 2. Log manual ke Laravel Log (sebagai pengganti activitylog sementara)
        Log::info('Produk baru dibuat: ' . $product->name, [
            'id' => $product->id,
            'user' => auth()->id() ?? 'System/Seeder'
        ]);
    }

    /**
     * Handle the Product "updated" event.
     */
    public function updated(Product $product): void
    {
        // 1. Bersihkan cache detail produk ini
        Cache::forget('product_' . $product->id);
        Cache::forget('product_slug_' . $product->slug);

        // 2. Bersihkan cache list umum
        $this->clearCommonCaches($product);

        // 3. Jika kategori berubah, hapus cache kategori lama & baru
        if ($product->isDirty('category_id')) {
            Cache::forget('category_' . $product->getOriginal('category_id') . '_products');
            Cache::forget('category_' . $product->category_id . '_products');
        }

        Log::info('Produk diperbarui: ' . $product->name, ['id' => $product->id]);
    }

    /**
     * Handle the Product "deleted" event.
     */
    public function deleted(Product $product): void
    {
        // Bersihkan semua cache terkait produk ini
        Cache::forget('product_' . $product->id);
        Cache::forget('product_slug_' . $product->slug);
        $this->clearCommonCaches($product);

        Log::info('Produk dihapus: ' . $product->name, ['id' => $product->id]);
    }

    /**
     * Fungsi bantuan untuk membersihkan cache yang sering dipakai.
     */
    protected function clearCommonCaches(Product $product): void
    {
        Cache::forget('featured_products');
        Cache::forget('all_products_count');
        Cache::forget('category_' . $product->category_id . '_products');
    }
}