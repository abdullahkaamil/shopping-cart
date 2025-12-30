<x-app-layout>
    <div class="p-6">
        <h1 class="text-2xl mb-4">Products</h1>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            @foreach($products as $product)
                <div class="border p-4 rounded">
                    <h3>{{ $product->name }}</h3>
                    <p class="text-green-600">${{ $product->price }}</p>
                    <p>Stock: {{ $product->stock_quantity }}</p>
                    <button
                        wire:click="addToCart({{ $product->id }})"
                        class="mt-2 bg-blue-500 text-white px-3 py-1 rounded"
                    >
                        Add to Cart
                    </button>
                </div>
            @endforeach
        </div>

        <livewire:cart />
    </div>
</x-app-layout>
