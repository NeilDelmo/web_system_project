<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Sales Report</title>
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
        .summary {
            margin-bottom: 20px;
            background-color: #f9f9f9;
            padding: 15px;
            border-radius: 5px;
        }
        .summary-item {
            display: inline-block;
            width: 48%;
            margin-bottom: 10px;
        }
        .summary-item strong {
            color: #333;
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
        .section-title {
            font-size: 16px;
            font-weight: bold;
            margin-top: 20px;
            margin-bottom: 10px;
            color: #333;
            border-bottom: 1px solid #ccc;
            padding-bottom: 5px;
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
        <h1>Sales Report</h1>
        <p>Cuevas Bread</p>
        <p><strong>Period:</strong> {{ \Carbon\Carbon::parse($startDate)->format('F d, Y') }} to {{ \Carbon\Carbon::parse($endDate)->format('F d, Y') }}</p>
        <p><strong>Generated:</strong> {{ $date }}</p>
    </div>

    <div class="summary">
        <div class="summary-item">
            <strong>Total Revenue:</strong> ₱{{ number_format($totalRevenue, 2) }}
        </div>
        <div class="summary-item">
            <strong>Total Orders:</strong> {{ number_format($totalOrders) }}
        </div>
    </div>

    <div class="section-title">Top Selling Products</div>
    <table>
        <thead>
            <tr>
                <th>Rank</th>
                <th>Product Name</th>
                <th>Quantity Sold</th>
                <th>Revenue</th>
            </tr>
        </thead>
        <tbody>
            @foreach($topProducts as $index => $product)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $product->product->name ?? 'Unknown' }}</td>
                <td>{{ number_format($product->total_sold) }}</td>
                <td>₱{{ number_format($product->revenue, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="section-title">Order Details</div>
    <table>
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Date</th>
                <th>Type</th>
                <th>Items</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
            <tr>
                <td>#{{ $order->id }}</td>
                <td>{{ $order->created_at->format('M d, Y H:i') }}</td>
                <td>{{ ucfirst($order->order_type) }}</td>
                <td>
                    @foreach($order->items as $item)
                        {{ $item->product->name }} ({{ $item->quantity }})@if(!$loop->last), @endif
                    @endforeach
                </td>
                <td>₱{{ number_format($order->total_amount, 2) }}</td>
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
