<!DOCTYPE html>
<html>
<head>
    <title>Low Stock Alert</title>
</head>
<body>
    <h1>Low Stock Alert</h1>
    <p>The following item has reached a low stock level:</p>
    
    <p><strong>Item:</strong> {{ $item->name }}</p>
    <p><strong>Current Quantity:</strong> {{ $item->quantity ?? $item->stock_quantity }} {{ $item->unit ?? '' }}</p>
    <p><strong>Reorder Level/Threshold:</strong> {{ $item->reorder_level ?? \App\Models\SystemSetting::get('low_stock_threshold', 10) }}</p>
    
    <p>Please arrange for restocking soon.</p>
</body>
</html>
