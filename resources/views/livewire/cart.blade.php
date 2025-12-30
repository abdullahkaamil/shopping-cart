<div class="mt-8 border-t pt-6">
    <h2 class="text-xl font-bold mb-4">Shopping Cart</h2>

    @if(count($cartItems))
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left">Product</th>
                        <th class="px-4 py-3 text-left">Price</th>
                        <th class="px-4 py-3 text-left">Quantity</th>
                        <th class="px-4 py-3 text-left">Subtotal</th>
                        <th class="px-4 py-3 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($cartItems as $item)
                        <tr>
                            <td class="px-4 py-3">{{ $item['product']['name'] }}</td>
                            <td class="px-4 py-3">${{ number_format($item['product']['price'], 2) }}</td>
                            <td class="px-4 py-3">
                                <input type="number"
                                       min="1"
                                       max="{{ $item['product']['stock_quantity'] }}"
                                       value="{{ $item['quantity'] }}"
                                       wire:change="updateQuantity({{ $item['id'] }}, $event.target.value)"
                                       class="w-20 px-2 py-1 border rounded"
                                />
                            </td>
                            <td class="px-4 py-3 font-semibold">
                                ${{ number_format($item['product']['price'] * $item['quantity'], 2) }}
                            </td>
                            <td class="px-4 py-3">
                                <button wire:click="removeFromCart({{ $item['id'] }})"
                                        class="text-red-500 hover:text-red-700">
                                    Remove
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4 flex justify-between items-center">
            <div class="text-xl font-bold">
                Total: ${{ number_format($total, 2) }}
            </div>
            <button wire:click="checkout"
                    class="bg-green-500 hover:bg-green-600 text-white px-6 py-2 rounded-lg font-semibold">
                Checkout
            </button>
        </div>
    @else
        <p class="text-gray-500">Your cart is empty.</p>
    @endif
</div>
