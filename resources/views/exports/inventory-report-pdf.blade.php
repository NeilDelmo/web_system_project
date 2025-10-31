<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Inventory Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            color: #333;
        }
        .header p {
            margin: 5px 0;
            color: #666;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table th {
            background-color: #333;
            color: white;
            padding: 10px;
            text-align: left;
            font-weight: bold;
        }
        table td {
            padding: 8px;
            border-bottom: 1px solid #ddd;
        }
        table tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .low-stock {
            background-color: #fff3cd !important;
        }
        .out-of-stock {
            background-color: #f8d7da !important;
        }
        .section-title {
            font-size: 16px;
            font-weight: bold;
            margin-top: 20px;
            margin-bottom: 10px;
            color: #333;
            border-bottom: 1px solid #ccc;
            padding-bottom: 5px;
        }
        .status-badge {
            padding: 3px 8px;
            border-radius: 3px;
            font-size: 10px;
            font-weight: bold;
        }
        .status-available {
            background-color: #d4edda;
            color: #155724;
        }
        .status-low {
            background-color: #fff3cd;
            color: #856404;
        }
        .status-out {
            background-color: #f8d7da;
            color: #721c24;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 10px;
            border-top: 1px solid #ccc;
            color: #666;
            font-size: 10px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Inventory Report</h1>
        <p>Cuevas Bread</p>
        <p><strong>Generated:</strong> {{ $date }}</p>
    </div>

    <div class="section-title">Products Inventory</div>
    <table>
        <thead>
            <tr>
                <th>Product Name</th>
                <th>Stock Quantity</th>
                <th>Price</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
            <tr class="@if($product->stock_quantity < 10 && $product->stock_quantity > 0) low-stock @elseif($product->stock_quantity == 0) out-of-stock @endif">
                <td>{{ $product->name }}</td>
                <td>{{ number_format($product->stock_quantity) }}</td>
                <td>₱{{ number_format($product->price, 2) }}</td>
                <td>
                    @if($product->stock_quantity >= 10)
                        <span class="status-badge status-available">Available</span>
                    @elseif($product->stock_quantity > 0)
                        <span class="status-badge status-low">Low Stock</span>
                    @else
                        <span class="status-badge status-out">Out of Stock</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="section-title">Ingredients Inventory</div>
    <table>
        <thead>
            <tr>
                <th>Ingredient Name</th>
                <th>Quantity</th>
                <th>Unit</th>
                <th>Status</th>
                <th>Reorder Level</th>
            </tr>
        </thead>
        <tbody>
            @foreach($ingredients as $ingredient)
            <tr class="@if($ingredient->status == 'low_stock') low-stock @elseif($ingredient->status == 'out_of_stock') out-of-stock @endif">
                <td>{{ $ingredient->name }}</td>
                <td>{{ number_format($ingredient->quantity, 2) }}</td>
                <td>{{ $ingredient->unit }}</td>
                <td>
                    @if($ingredient->status == 'in_stock')
                        <span class="status-badge status-available">In Stock</span>
                    @elseif($ingredient->status == 'low_stock')
                        <span class="status-badge status-low">Low Stock</span>
                    @else
                        <span class="status-badge status-out">Out of Stock</span>
                    @endif
                </td>
                <td>{{ number_format($ingredient->reorder_level, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>&copy; {{ date('Y') }} Cuevas Bread. All rights reserved.</p>
        <p>This is a computer-generated document. No signature is required.</p>
    </div>
</body>
</html>
