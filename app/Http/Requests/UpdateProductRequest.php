<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Pastikan tetap true
    }

    public function rules(): array
    {
        // Mengambil ID produk dari parameter route (misal: /admin/products/{product})
        $product = $this->route('product');
        $productId = is_object($product) ? $product->id : $product;

        return [
            'category_id'    => 'required|exists:categories,id',
            'name'           => 'required|string|max:255',
            'description'    => 'nullable|string',
            'price'          => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0',
            'stock'          => 'required|integer|min:0',
            'weight'         => 'required|numeric|min:0',
            'is_active'      => 'boolean',
            'is_featured'    => 'boolean',
            // Jika ada upload gambar
            'images.*'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ];
    }

    protected function prepareForValidation()
    {
        // Menangani checkbox agar tidak bernilai null
        $this->merge([
            'is_active'   => $this->has('is_active'),
            'is_featured' => $this->has('is_featured'),
        ]);
    }
}