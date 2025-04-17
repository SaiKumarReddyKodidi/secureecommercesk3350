<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Status</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEJ3Q2QQ76vZb8PHmIm0yoo0mkzcbqg4ldZr7A4tVeim0npx51gHg+Y+npfSv" crossorigin="anonymous">
    <style>
        body {
            background: #f4f7fc;
            font-family: 'Arial', sans-serif;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .alert-container {
            background: #fff;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            width: 100%;
            text-align: center;
        }

        .alert-container h4 {
            font-size: 24px;
            color: #28a745;
            font-weight: bold;
        }

        .alert-container p {
            font-size: 16px;
            color: #555;
            margin: 15px 0;
        }

        .alert-container .btn {
            background-color: #28a745;
            color: #fff;
            padding: 12px 30px;
            font-size: 16px;
            text-transform: uppercase;
            border-radius: 50px;
            border: none;
            transition: background-color 0.3s ease;
        }

        .alert-container .btn:hover {
            background-color: #218838;
        }

        .alert-container .btn:focus {
            outline: none;
        }

        .alert-container hr {
            border-color: #f0f0f0;
            margin: 20px 0;
        }
    </style>
</head>

<body>

<div class="alert-container">
    <div class="alert alert-success" role="alert">
        <h4 class="alert-heading">Payment Successful!</h4>
        <p>Your payment has been processed successfully. Thank you for your purchase. We appreciate your business!</p>
        <hr>
        <p class="mb-0">Click below to return to shopping and continue exploring more products.</p>
        <a href="{{ url('/shop') }}" class="btn mt-4">Back to Shopping</a>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pzjw8f+ua7Kw1TIq0g1+YcZb9J04sC4gXfO67o6thp2j1zFz5sNxVxWfZ0V8D02j" crossorigin="anonymous"></script>
</body>

</html>
