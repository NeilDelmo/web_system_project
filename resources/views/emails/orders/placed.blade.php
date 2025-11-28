<!DOCTYPE html>
<html>
<head>
    <title>New Order Placed</title>
</head>
<body>
    <h1>New Order Received</h1>
    <p>A new order has been placed.</p>
    
    <p><strong>Order ID:</strong> #{{ $order->id }}</p>
    <p><strong>Customer:</strong> {{ $order->customer_name }}</p>
    <p><strong>Total Amount:</strong> ${{ number_format($order->total_amount, 2) }}</p>
    <p><strong>Status:</strong> {{ $order->status }}</p>

    <h3>Order Items:</h3>
    <ul>
        @foreach($order->items as $item)
            <li>{{ $item->product->name }} x {{ $item->quantity }} - ${{ number_format($item->price, 2) }}</li>
        @endforeach
    </ul>

    <p>Please log in to the system to process this order.</p>
</body>
</html>
