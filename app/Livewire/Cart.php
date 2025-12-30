<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class Cart extends Component
{
    public $cartItems = [];
    public $total = 0;

    protected $listeners = ['cartUpdated' => 'loadCart'];

    protected $rules = [
        'cartItems.*.quantity' => 'required|integer|min:1',
    ];

    public function mount()
    {
        $this->loadCart();
    }

    public function loadCart()
    {
        $this->cartItems = Auth::user()
            ->cartItems()
            ->with('product')
            ->get()
            ->toArray();

        $this->calculateTotal();
    }

    public function addToCart($productId)
    {
        $product = Product::findOrFail($productId);

        if ($product->stock_quantity < 1) {
            $this->dispatch('alert', type: 'error', message: 'Out of stock!');
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
        if ($product->stock_quantity <= 5) { // threshold = 5
            dispatch(new \App\Jobs\LowStockNotification($product));
        }

        $this->loadCart();
    }

    public function updateQuantity($itemId, $quantity)
    {
        $item = CartItem::findOrFail($itemId);
        if ($item->user_id !== Auth::id()) return;

        $product = $item->product;
        if ($quantity > $product->stock_quantity) {
            $this->dispatch('alert', type: 'error', message: 'Not enough stock!');
            $this->loadCart();
            return;
        }

        $item->update(['quantity' => $quantity]);
        $this->loadCart();
    }

    public function removeFromCart($itemId)
    {
        $item = CartItem::findOrFail($itemId);
        if ($item->user_id !== Auth::id()) return;

        $item->delete();
        $this->loadCart();
    }

    public function calculateTotal()
    {
        $this->total = collect($this->cartItems)->sum(fn($item) => $item['product']['price'] * $item['quantity']);
    }

    public function render()
    {
        return view('livewire.cart');
    }

    public function checkout()
    {
        $cartItems = Auth::user()->cartItems()->with('product')->get();

        if ($cartItems->isEmpty()) {
            $this->dispatch('alert', type: 'warning', message: 'Cart is empty!');
            return;
        }

        // Validate stock again
        foreach ($cartItems as $item) {
            if ($item->quantity > $item->product->stock_quantity) {
                $this->dispatch('alert', type: 'error', message: "{$item->product->name} is out of stock!");
                return;
            }
        }

        // Create order
        $total = $cartItems->sum(fn($i) => $i->product->price * $i->quantity);

        $order = Auth::user()->orders()->create([
            'total_amount' => $total,
            'placed_at' => now(),
        ]);

        // Create order items & reduce stock
        foreach ($cartItems as $item) {
            $order->items()->create([
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'price_per_unit' => $item->product->price,
            ]);

            // Reduce product stock
            $item->product->decrement('stock_quantity', $item->quantity);

            // Optional: Trigger low stock check
            $product = $item->product->fresh();
            if ($product->stock_quantity <= 5) {
                dispatch(new \App\Jobs\LowStockNotification($product));
            }
        }

        // Clear user's cart
        Auth::user()->cartItems()->delete();

        // Log for daily report (optional: already captured via order_items)
        // Daily report will now use `order_items` instead of fake "sales"

        $this->dispatch('alert', type: 'success', message: 'Order placed successfully!');
        $this->loadCart();
    }
}
