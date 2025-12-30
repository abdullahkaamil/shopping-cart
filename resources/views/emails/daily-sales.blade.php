<h2>Daily Sales Report ({{ now()->format('Y-m-d') }})</h2>
<table border="1">
    <tr><th>Product</th><th>Qty</th><th>Price</th></tr>
    @foreach($sales as $sale)
        <tr>
            <td>{{ $sale->product->name }}</td>
            <td>{{ $sale->quantity }}</td>
            <td>${{ $sale->price }}</td>
        </tr>
    @endforeach
</table>
