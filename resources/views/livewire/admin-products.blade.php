<div>
    @if(session('message'))
        <div class="bg-green-100 p-3 rounded mb-4">{{ session('message') }}</div>
    @endif

    <!-- Form -->
    <div class="bg-white p-4 rounded shadow mb-6">
        <h3 class="text-lg font-bold mb-3">{{ $editingId ? 'Edit Product' : 'Add New Product' }}</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <input type="text" wire:model="name" placeholder="Name" class="border p-2">
            <input type="number" step="0.01" wire:model="price" placeholder="Price" class="border p-2">
            <input type="number" wire:model="stock_quantity" placeholder="Stock" class="border p-2">
        </div>
        <div class="mt-3">
            @if($editingId)
                <button wire:click="update" class="bg-blue-500 text-white px-4 py-2 rounded">Update</button>
                <button wire:click="resetForm" class="ml-2 text-gray-600">Cancel</button>
            @else
                <button wire:click="createProduct" class="bg-green-500 text-white px-4 py-2 rounded">Create</button>
            @endif
        </div>
    </div>

    <!-- Search -->
    <input type="text" wire:model.live="search" placeholder="Search products..." class="border p-2 mb-4 w-full">

    <!-- Product List -->
    <table class="min-w-full border">
        <thead>
        <tr class="bg-gray-100">
            <th class="border p-2">Name</th>
            <th class="border p-2">Price</th>
            <th class="border p-2">Stock</th>
            <th class="border p-2">Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach($products as $product)
            <tr>
                <td class="border p-2">{{ $product->name }}</td>
                <td class="border p-2">${{ number_format($product->price, 2) }}</td>
                <td class="border p-2">{{ $product->stock_quantity }}</td>
                <td class="border p-2">
                    <button wire:click="edit({{ $product->id }})" class="text-blue-500 mr-2">Edit</button>
                    <button wire:click="delete({{ $product->id }})" class="text-red-500"
                            onclick="return confirm('Are you sure?')">Delete</button>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    {{ $products->links() }}
</div>
