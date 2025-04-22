<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<div class="main-panel">
    <div class="content-wrapper">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>SL. No</th>
                    <th>Order ID</th>
                    <th>User Name</th>
                    <th>User Phone</th>
                    <th>User Address</th>
                    <th>Total Quantity</th>
                    <th>Total Price</th>
                </tr>
            </thead>
            <tbody>   
                @php
                    $i = 1;
                @endphp   
                @foreach ($orders as $order)
                    <tr>
                        <td>{{ $i++ }}</td>
                        <td>{{ $order->id }}</td>
                        <td>{{ $order->user->name }}</td>
                        <td>{{ $order->user->phone }}</td>
                        <td>{{ $order->user->address }}</td>
                        <td>{{ $order->total_quantity }}</td>
                        <td>{{ $order->total_price }}</td>
                    </tr>
                @endforeach     
            </tbody>
        </table>
    </div>
</div>
</body>
</html>