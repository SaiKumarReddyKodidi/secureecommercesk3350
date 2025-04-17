<!DOCTYPE html>
<html lang="en">

<head>
    <title>Ecommerce Website: Digital Goods</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="apple-touch-icon" href="assets/img/apple-icon.png">
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.svg">

    @include('home.css')
</head>

<body>
@include('home.nav')
@include("home.header")
@include("home.modal")

<div class="bg-light py-3">
    <div class="container">
        <div class="row">
            <div class="col-md-12 mb-0">
                <a href="/">Home</a> <span class="mx-2 mb-0">/</span> <strong class="text-black">Cart</strong>
            </div>
        </div>
    </div>
</div>

<div class="site-section">
    <div class="container">
        <div class="row mb-5">
            <div class="site-blocks-table">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th class="product-thumbnail">Image</th>
                        <th class="product-name">Product</th>
                        <th class="product-price">Price</th>
                        <th class="product-quantity">Quantity</th>
                        <th class="product-total">Total</th>
                        <th class="product-remove">Remove</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($products as $product)
                        <tr data-product-id="{{ $product->id }}">
                            <td class="product-thumbnail">
                                <img style="height: 60px; width: 60px;" src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="img-fluid">
                            </td>
                            <td class="product-name">
                                <h2 class="h5 text-black">{{ $product->name }}</h2>
                            </td>
                            <td class="product-price">${{ number_format($product->price, 2) }}</td>
                            <td>
                                <div class="input-group mb-3" style="max-width: 120px;">
                                    <div class="input-group-prepend">
                                        <button class="btn btn-outline-primary js-btn-minus" type="button">&minus;</button>
                                    </div>
                                    <input type="number" class="form-control text-center quantity-input" data-price="{{ $product->price }}" name="quantities[{{ $product->id }}]" value="{{ $product->quantity }}" min="1">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-primary js-btn-plus" type="button">&plus;</button>
                                    </div>
                                </div>
                            </td>
                            <td class="product-total">${{ number_format($product->price * $product->quantity, 2) }}</td>
                            <td>
                                <form method="POST" action="{{ route('cart.remove') }}">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <button type="submit" class="btn btn-primary btn-sm">X</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <button class="btn btn-outline-primary btn-sm btn-block" onclick="window.location='/'">Continue Shopping</button>
            </div>
            <div class="col-md-6 pl-5">
                <div class="row justify-content-end">
                    <div class="col-md-7">
                        <div class="row">
                            <div class="col-md-12 text-right border-bottom mb-5">
                                <h3 class="text-black h4 text-uppercase">Cart Totals</h3>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <span class="text-black">Subtotal</span>
                            </div>
                            <div class="col-md-6 text-right">
                                <strong class="text-black cart-subtotal">${{ number_format($subtotal, 2) }}</strong>
                            </div>
                        </div>
                        <div class="row mb-5">
                            <div class="col-md-6">
                                <span class="text-black">Total</span>
                            </div>
                            <div class="col-md-6 text-right">
                                <strong class="text-black cart-total">${{ number_format($total, 2) }}</strong>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <form id="checkout-form" method="POST" action="{{ route('checkout') }}">
                                    @csrf
                                    <div id="cart-summary"></div>
                                    <button type="submit" class="btn btn-primary btn-lg py-3 btn-block">Proceed To Checkout</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include("home.footer")
@include("home.js")

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const updateTotals = () => {
            let subtotal = 0;

            document.querySelectorAll("tbody tr").forEach(row => {
                const price = parseFloat(row.querySelector(".product-price").textContent.replace("$", ""));
                const quantityInput = row.querySelector(".quantity-input");
                const totalCell = row.querySelector(".product-total");

                let quantity = parseInt(quantityInput.value);
                let total = price * quantity;
                totalCell.textContent = `$${total.toFixed(2)}`;

                subtotal += total;
            });

            document.querySelector(".cart-subtotal").textContent = `$${subtotal.toFixed(2)}`;
            document.querySelector(".cart-total").textContent = `$${subtotal.toFixed(2)}`;

            updateCheckoutForm();
        };

        const updateCheckoutForm = () => {
            let summaryDiv = document.getElementById("cart-summary");
            summaryDiv.innerHTML = "";

            document.querySelectorAll("tbody tr").forEach(row => {
                const productId = row.getAttribute("data-product-id");
                const productName = row.querySelector(".product-name h2").textContent;
                const productPrice = parseFloat(row.querySelector(".product-price").textContent.replace("$", ""));
                const quantity = row.querySelector(".quantity-input").value;

                summaryDiv.innerHTML += `
                <input type="hidden" name="products[${productId}][name]" value="${productName}">
                <input type="hidden" name="products[${productId}][price]" value="${productPrice}">
                <input type="hidden" name="products[${productId}][quantity]" value="${quantity}">
            `;
            });
        };

        document.querySelectorAll(".js-btn-minus, .js-btn-plus").forEach(button => {
            button.addEventListener("click", function () {
                let input = this.closest(".input-group").querySelector(".quantity-input");
                let value = parseInt(input.value);

                if (this.classList.contains("js-btn-minus") && value > 1) {
                    input.value = value - 1;
                } else if (this.classList.contains("js-btn-plus")) {
                    input.value = value + 1;
                }

                updateTotals();
            });
        });

        document.querySelectorAll(".quantity-input").forEach(input => {
            input.addEventListener("change", function () {
                if (this.value < 1) this.value = 1;
                updateTotals();
            });
        });

        updateTotals();
    });
</script>

</body>
</html>
