<div>

    @foreach($orders as $order)
        <div class="border p-4 mb-3 rounded">
            <p>User: {{ $order->user->email }}</p>
            <p>Total: ${{ number_format($order->total_amount, 2) }}</p>
            <p>Status:
                <select wire:change="updateStatus({{ $order->id }}, $event.target.value)" class="ml-2">
                    @foreach( $statuses as $value => $label)
                        <option value="{{ $value }}" @if($order->status === $value) selected @endif>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
            </p>
            <!-- items list -->
        </div>
    @endforeach

</div>

