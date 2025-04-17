<!DOCTYPE html>
<html lang="en">
<head>
    <title>Checkout</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @include('home.css')
    <style>
        #card-element {
            display: none;
            padding: 12px;
            border: 1px solid #ced4da;
            border-radius: 0.375rem;
            background-color: #fff;
            box-shadow: inset 0 1px 2px rgba(0,0,0,0.075);
            transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
        }

        #card-element.StripeElement--focus {
            border-color: #80bdff;
            box-shadow: 0 0 0 0.2rem rgba(0,123,255,.25);
        }

        #card-loader {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100px;
        }

        #card-label {
            font-weight: bold;
            margin-bottom: 8px;
        }
    </style>
</head>
<body>
@include('home.nav')
@include("home.header")

<div class="container mt-5">
    <h2>Checkout</h2>

    <div class="row">
        <div class="col-md-8">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                </tr>
                </thead>
                <tbody>
                @php
                    $subtotal = 0;
                @endphp
                @foreach ($products as $productId => $product)
                    @php
                        $total = $product['price'] * $product['quantity'];
                        $subtotal += $total;
                    @endphp
                    <tr>
                        <td>{{ $product['name'] }}</td>
                        <td>${{ number_format($product['price'], 2) }}</td>
                        <td>{{ $product['quantity'] }}</td>
                        <td>${{ number_format($total, 2) }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <div class="col-md-4">
            <h3>Cart Totals</h3>
            <p>Subtotal: <strong>${{ number_format($subtotal, 2) }}</strong></p>

            <form id="payment-form" method="POST" action="{{ route('stripe.checkout.post') }}">
                @csrf
                <input type="hidden" name="amount" value="{{ $subtotal * 100 }}">

                <!-- Card input label -->
                <div id="card-label" class="mb-2">Enter your card details below:</div>

                <!-- Loader while card element is loading -->
                <div id="card-loader">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>

                <!-- Stripe Card Element -->
                <div id="card-element" class="mb-3">
                    <!-- Stripe will insert the card input here -->
                </div>

                <!-- Error Display -->
                <div id="card-errors" role="alert" class="text-danger mb-3"></div>

                <button type="submit" class="btn btn-lg btn-primary btn-block" id="submit-button">
                    Place Order
                </button>
            </form>
        </div>
    </div>
</div>

@include("home.footer")
@include("home.js")
<script src="https://js.stripe.com/v3/"></script>
<script>
    const stripe = Stripe('{{ $publishableKey }}');
    const paymentForm = document.getElementById('payment-form');
    const cardElement = document.getElementById('card-element');
    const cardErrors = document.getElementById('card-errors');
    const cardLoader = document.getElementById('card-loader');

    let clientSecret;

    fetch('/stripe/checkout', {
        method: 'GET',
    })
        .then(response => response.json())
        .then(data => {
            clientSecret = data.clientSecret;

            const elements = stripe.elements();
            const card = elements.create('card', {
                style: {
                    base: {
                        fontSize: '16px',
                        color: '#212529',
                        fontFamily: 'Arial, sans-serif',
                        '::placeholder': {
                            color: '#6c757d'
                        }
                    },
                    invalid: {
                        color: '#dc3545',
                        iconColor: '#dc3545'
                    }
                }
            });

            card.mount(cardElement);

            card.on('ready', function () {
                cardLoader.style.display = 'none';
                cardElement.style.display = 'block';
            });

            paymentForm.addEventListener('submit', async (event) => {
                event.preventDefault();

                const { error, paymentMethod } = await stripe.createPaymentMethod({
                    type: 'card',
                    card: card,
                });

                if (error) {
                    cardErrors.textContent = error.message;
                } else {
                    stripe.confirmCardPayment(clientSecret, {
                        payment_method: paymentMethod.id,
                    }).then(function(result) {
                        if (result.error) {
                            cardErrors.textContent = result.error.message;
                        } else {
                            if (result.paymentIntent.status === 'succeeded') {
                                window.location.href = '/stripe/checkout/success';
                            }
                        }
                    });
                }
            });
        });
</script>

</body>
</html>
