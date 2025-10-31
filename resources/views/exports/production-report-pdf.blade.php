<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Production Report</title>
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
        .status-badge {
            padding: 3px 8px;
            border-radius: 3px;
            font-size: 10px;
            font-weight: bold;
        }
        .status-completed {
            background-color: #d4edda;
            color: #155724;
        }
        .status-failed {
            background-color: #f8d7da;
            color: #721c24;
        }
        .status-cancelled {
            background-color: #e2e3e5;
            color: #383d41;
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
        <h1>Production Report</h1>
        <p>Cuevas Bread</p>
        <p><strong>Period:</strong> {{ \Carbon\Carbon::parse($startDate)->format('F d, Y') }} to {{ \Carbon\Carbon::parse($endDate)->format('F d, Y') }}</p>
        <p><strong>Generated:</strong> {{ $date }}</p>
    </div>

    <div class="summary">
        <div class="summary-item">
            <strong>Total Units Produced:</strong> {{ number_format($totalProduction) }}
        </div>
        <div class="summary-item">
            <strong>Total Batches:</strong> {{ number_format($totalBatches) }}
        </div>
    </div>

    <div class="section-title">Production by Product</div>
    <table>
        <thead>
            <tr>
                <th>Rank</th>
                <th>Product Name</th>
                <th>Total Produced</th>
                <th>Batches</th>
                <th>Avg per Batch</th>
            </tr>
        </thead>
        <tbody>
            @foreach($productionByProduct as $index => $prod)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $prod->product->name ?? 'Unknown' }}</td>
                <td>{{ number_format($prod->total_produced) }}</td>
                <td>{{ number_format($prod->batches) }}</td>
                <td>{{ number_format($prod->total_produced / $prod->batches, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="section-title">Production Logs</div>
    <table>
        <thead>
            <tr>
                <th>Date & Time</th>
                <th>Product</th>
                <th>Quantity</th>
                <th>Status</th>
                <th>Produced By</th>
                <th>Notes</th>
            </tr>
        </thead>
        <tbody>
            @foreach($productionLogs as $log)
            <tr>
                <td>{{ \Carbon\Carbon::parse($log->produced_at)->format('M d, Y H:i') }}</td>
                <td>{{ $log->product->name ?? 'Unknown' }}</td>
                <td>{{ number_format($log->quantity_produced) }}</td>
                <td>
                    @if($log->status == 'completed')
                        <span class="status-badge status-completed">Completed</span>
                    @elseif($log->status == 'failed')
                        <span class="status-badge status-failed">Failed</span>
                    @else
                        <span class="status-badge status-cancelled">Cancelled</span>
                    @endif
                </td>
                <td>{{ $log->producer->fullname ?? 'N/A' }}</td>
                <td>{{ $log->notes ?? '-' }}</td>
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
