<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Miga de Oro-Invoice {{ $order['id'] }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h3 {
            text-align: center;
            margin-bottom: 20px;
        }

        .row {
            display: flex;
            flex-wrap: wrap;
        }

        .col-4 {
            flex: 0 0 33.33%;
            max-width: 33.33%;
            padding: 10px;
        }

        hr {
            margin: 40px 0;
            border: none;
            border-top: 1px solid #ccc;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .text-end {
            text-align: right;
        }
    </style>
</head>
<body>
<div class="container">
    <h3>Migas de Oro S.L</h3>
    <div class="row">
        <div class="col-4">
            <h4>Ship to:</h4>
            <p>{{ $address['name'] }} , {{ $address['lastName'] }}</p>
            <p>{{ $address['street'] }} , {{ $address['number'] }}</p>
            <p>{{ $address['city'] }} , {{ $address['province'] }} , {{ $address['country'] }} , {{ $address['postCode'] }}</p>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-2">
            <p > <span style="color: darkred">Order Date:</span> {{ \Illuminate\Support\Carbon::now() }}</p>
            <p><span style="color: darkred">Order Number:</span>{{ $order['id'] }}</p>
        </div>

    </div>
    <hr>
    <table>
        <thead>
        <tr>
            <th scope="col">Quantity</th>
            <th scope="col">Product</th>
            <th scope="col">Unit Price</th>
            <th scope="col">Total Price</th>
        </tr>
        </thead>
        <tbody>
        @foreach($orderLines as $orderLine)
            <tr>
                <td>{{ $orderLine->stock }}</td>
                <td>{{ $orderLine->product->name }}</td>
                <td>{{ $orderLine->unitPrice }}</td>
                <td>{{ $orderLine->linePrice }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <p class="text-end">Total: {{ $order['totalPrice'] }}</p>
    <p class="text-end">Tax: {{ $order['tax'] }}</p>
    <p class="text-end">Total: {{ $order['total'] }}</p>
</div>
</body>
</html>
