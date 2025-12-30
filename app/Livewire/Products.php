<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;
use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;

class Products extends Component
{
    public $products = [];

    public function mount()
    {
        $this->loadProducts();
    }

    public function loadProducts()
    {
        $this->products = Product::all();
    }

    public function addToCart($productId)
    {
        $product = Product::findOrFail($productId);

        if ($product->stock_quantity < 1) {
            session()->flash('error', 'Out of stock!');
            return;
        }

        $existingItem = CartItem::where('user_id', Auth::id())
            ->where('product_id', $productId)
            ->first();

        if ($existingItem) {
            $existingItem->increment('quantity');
        } else {
            CartItem::create([
                'user_id' => Auth::id(),
                'product_id' => $productId,
                'quantity' => 1
            ]);
        }

        // Check low stock after update
        $product->refresh();
        if ($product->stock_quantity <= 5) {
            dispatch(new \App\Jobs\LowStockNotification($product));
        }

        session()->flash('success', 'Product added to cart!');
        $this->dispatch('cartUpdated');
    }

    public function render()
    {
        return view('livewire.products');
    }
}
