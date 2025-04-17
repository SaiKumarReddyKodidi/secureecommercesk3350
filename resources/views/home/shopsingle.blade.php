<!DOCTYPE html>
<html lang="en">

<head>
    <title>Ecommerce website : Digital goods</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="apple-touch-icon" href="assets/img/apple-icon.png">
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.svg">

    @include('home.css')
    <!--

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


    <!-- Open Content -->
    <section class="bg-light">
        <div class="container pb-5">
            <div class="row">
                <div class="col-lg-5 mt-5">
                    <!-- Display the single product's image -->
                    <div class="card mb-3">
                        <img class="card-img img-fluid" src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" id="product-detail">
                    </div>
                </div>
                <!-- col end -->
                <div class="col-lg-7 mt-5">
                    <div class="card">
                        <div class="card-body">
                            <!-- Product Name -->
                            <h1 class="h2">{{ $product->name }}</h1>

                            <!-- Product Price -->
                            <p class="h3 py-2">${{ number_format($product->price, 2) }}</p>

                            <!-- Product Rating -->
                            <p class="py-2">
                                <i class="fa fa-star text-warning"></i>
                                <i class="fa fa-star text-warning"></i>
                                <i class="fa fa-star text-warning"></i>
                                <i class="fa fa-star text-warning"></i>
                                <i class="fa fa-star text-secondary"></i>
                                <span class="list-inline-item text-dark">Rating {{ $product->rating }} | {{ $product->comments_count }} Comments</span>
                            </p>

                            <!-- Product Brand -->
                            <ul class="list-inline">
                                <li class="list-inline-item">
                                    <h6>Brand:</h6>
                                </li>
                                <li class="list-inline-item">
                                    <p class="text-muted"><strong>{{ $product->brand }}</strong></p>
                                </li>
                            </ul>

                            <!-- Product Description -->
                            <h6>Description:</h6>
                            <p>{{ $product->description }}</p>

                            @if(auth()->guest())
                                <!-- Redirect to login if user is not authenticated -->
                                <script>
                                    window.location.href = "{{ route('login') }}";
                                </script>
                            @else
                                <!-- Product Size and Quantity Selection -->
                                <div class="row pb-3">
                                    <div class="col d-grid">
                                        <a class="btn btn-success text-white mt-2" href="/cart?id={{$product->id}}">
                                            <button type="submit" class="btn btn-success btn-lg">Add To Cart</button>
                                        </a>
                                    </div>
                                </div>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Close Content -->


    <!-- Start Footer -->
    @include("home.footer")
    <!-- End Footer -->

    <!-- Start Script -->
    @include("home.js")
    <!-- End Script -->
    </body>

</html>
