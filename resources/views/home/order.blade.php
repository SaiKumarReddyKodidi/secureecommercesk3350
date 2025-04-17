<!DOCTYPE html>
<html lang="en">

<head>
    <title>Ecommerce website : Digital goods</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="apple-touch-icon" href="assets/img/apple-icon.png">
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.svg">

    @include('home.css')

</head>

<body>
<!-- Start Top Nav -->
@include('home.nav')
<!-- Close Top Nav -->


<!-- Header -->
@include("home.header")
<!-- Close Header -->

<!-- Modal -->
@include("home.modal")


<section class="bg-light">
    <div class="container py-5">
        <div class="row">
            @foreach($payments as $product)
                <div class="col-12 col-md-4 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <ul class="list-unstyled d-flex justify-content-between">
                                <li>
                                    <!-- Example static star rating, you could modify this to be dynamic based on reviews -->
                                    <i class="text-warning fa fa-star"></i>
                                    <i class="text-warning fa fa-star"></i>
                                    <i class="text-warning fa fa-star"></i>
                                    <i class="text-muted fa fa-star"></i>
                                    <i class="text-muted fa fa-star"></i>
                                </li>
                                <li class="text-muted text-right">${{ number_format($product->price, 2) }}</li>
                            </ul>
                            <a href="/shop-single?id={{ $product->id }}" class="h3 text-decoration-none text-dark">{{ $product->name }}</a>
                            <p class="card-text">{{ Str::limit($product->description, 100) }}</p>
                            <p class="text-muted">Reviews ({{ $product->reviews_count }})</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
<style>
    .card-img-top {
        width: 100%;
        height: 250px; /* You can adjust this height to your preferred size */
        object-fit: cover; /* This ensures the image covers the area without distortion */
    }

</style>


<!-- Start Footer -->
@include("home.footer")
<!-- End Footer -->

<!-- Start Script -->
@include("home.js")
<!-- End Script -->
</body>

</html>
