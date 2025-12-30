<div class="mt-6">
    <h2 class="text-xl font-bold">My Orders</h2>

    @if($orders->isEmpty())
        <p>You have no orders yet.</p>
    @else
        @foreach($orders as $order)
            <div class="border p-4 mb-4 rounded">
                <p><strong>Order #{{ $order->id }}</strong> | {{ $order->placed_at->format('M j, Y') }}</p>
                <p>Total: ${{ number_format($order->total_amount, 2) }}</p>
                <ul class="mt-2">
                    @foreach($order->items as $item)
                        <li>{{ $item->quantity }}x {{ $item->product->name }} @ ${{ $item->price_per_unit }}</li>
                    @endforeach
                </ul>
            </div>
        @endforeach
    @endif
</div>
