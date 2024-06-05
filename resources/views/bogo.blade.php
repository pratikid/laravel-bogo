<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel Bogo</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }

        div {
            border: 1px solid #ddd;
            padding: 20px;
            border-radius: 5px;
        }

        h1,
        h2 {
            margin: 10px 0;
        }

        ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        li {
            margin: 5px 0;
        }

        form {
            display: flex;
            flex-direction: column;
            margin-bottom: 20px;
        }

        label {
            margin-bottom: 5px;
        }

        input[type="text"] {
            padding: 5px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }

        button {
            background-color: #4CAF50;
            border: none;
            color: white;
            padding: 10px 15px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin-top: 10px;
            cursor: pointer;
            border-radius: 5px;
        }

        .discountedItems li {
            color: green;
        }

        .payableItems li {
            color: blue;
        }

        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid transparent;
            border-radius: 4px;
        }

        .alert-danger {
            color: #a94442;
            background-color: #f2dede;
            border-color: #e4b9b9;
        }
    </style>

</head>

<body>
    <div>
        <h1>Buy One Get One Free!</h1>
        <form method="post" action="/">
            @csrf
            <label for="priceList">Enter product prices (comma separated):</label><br>
            <input type="text" id="priceList" name="priceList" value="{{ implode(',', $priceList) }}">
            <br><br>
            <button type="submit">Calculate Discount</button>
        </form>

        @if (!empty($priceList))
        <h2>Product Price List:</h2>
        <ul>
            @foreach ($priceList as $price)
            <li>{{ $price }}</li>
            @endforeach
        </ul>

        @if (!empty($discountedItems))
        <h2>Discounted Items:</h2>
        <ul>
            @foreach ($discountedItems as $item)
            <li>{{ $item }}</li>
            @endforeach
        </ul>
        @endif
        <h2>Payable Items:</h2>
        <ul>
            @foreach ($payableItems as $item)
            <li>{{ $item }}</li>
            @endforeach
        </ul>
        @endif
    </div>
    @if ($errors->has('priceList'))
    <div class="alert alert-danger">
        @foreach ($errors->get('priceList') as $error)
        <p>{{ $error }}</p>
        @endforeach
    </div>
    @endif
</body>

</html>