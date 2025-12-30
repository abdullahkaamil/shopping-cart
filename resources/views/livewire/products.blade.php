<div class="p-6">
    <h1 class="text-2xl mb-4">Products</h1>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        @foreach($products as $product)
            <div class="border p-4 rounded">
                <h3 class="font-semibold">{{ $product->name }}</h3>
                <p class="text-green-600">${{ number_format($product->price, 2) }}</p>
                <p class="text-sm text-gray-600">Stock: {{ $product->stock_quantity }}</p>
                <button
                    wire:click="addToCart({{ $product->id }})"
                    class="mt-2 bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded"
                    @if($product->stock_quantity < 1) disabled @endif
                >
                    @if($product->stock_quantity < 1)
                        Out of Stock
                    @else
                        Add to Cart
                    @endif
                </button>
            </div>
        @endforeach
    </div>

    <div class="mt-8">
        <livewire:cart />
    </div>
</div>
