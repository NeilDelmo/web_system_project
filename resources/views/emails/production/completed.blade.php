<!DOCTYPE html>
<html>
<head>
    <title>Production Completed</title>
</head>
<body>
    <h1>Production Completed</h1>
    <p>A production run has been completed successfully.</p>
    
    <p><strong>Product:</strong> {{ $productionLog->product->name }}</p>
    <p><strong>Quantity Produced:</strong> {{ $productionLog->quantity_produced }}</p>
    <p><strong>Produced By:</strong> {{ $productionLog->producer->name ?? 'Unknown' }}</p>
    <p><strong>Date:</strong> {{ $productionLog->created_at->format('Y-m-d H:i') }}</p>

    @if($productionLog->notes)
        <p><strong>Notes:</strong> {{ $productionLog->notes }}</p>
    @endif

    <p>Stock levels have been updated accordingly.</p>
</body>
</html>
