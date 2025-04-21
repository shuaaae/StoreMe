<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reservation History</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            margin: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 16px;
        }
        th, td {
            border: 1px solid #333;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        tfoot td {
            border: none;
            font-weight: bold;
            text-align: right;
        }
    </style>
</head>
<body>
    <h2>Reservation History</h2>

    @php
        $totalIncome = 0;
    @endphp

    <table>
        <thead>
            <tr>
                <th>User</th>
                <th>Locker</th>
                <th>Start</th>
                <th>End</th>
                <th>Duration</th>
                <th>Payment</th>
                <th>Status</th>
                <th>Payment Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($reservations as $res)
                @php
                    $start = \Carbon\Carbon::parse($res->reserved_at);
                    $end = \Carbon\Carbon::parse($res->reserved_until);
                    $hours = ceil(abs($end->floatDiffInHours($start)));
                    $paymentAmount = $hours * 10;
                    $totalIncome += $paymentAmount;
                @endphp
                <tr>
                    <td>{{ $res->user->name ?? 'N/A' }}</td>
                    <td>Locker #{{ $res->locker->number ?? 'N/A' }}</td>
                    <td>{{ $start->format('M d, Y h:i A') }}</td>
                    <td>{{ $end->format('M d, Y h:i A') }}</td>
                    <td>{{ $hours }} hr(s)</td>
                    <td>PHP {{ number_format($paymentAmount, 2) }}</td>
                    <td>{{ ucfirst($res->status) }}</td>
                    <td>{{ $res->payment_status ?? 'Unpaid' }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="5"></td>
                <td colspan="3">Total Income: PHP {{ number_format($totalIncome, 2) }}</td>
            </tr>
        </tfoot>
    </table>
</body>
</html>
