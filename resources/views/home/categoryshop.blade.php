<!DOCTYPE html>
<html lang="en">

<head>
    <title>Ecommerce website : Digital goods</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="apple-touch-icon" href="assets/img/apple-icon.png">
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.svg">

    @include('home.css')
    <style>
        /* Styles for the product card images */
        .product-img {
            height: 250px; /* Set the desired height */
            object-fit: cover; /* Ensures the image covers the area without distortion */
            width: 100%; /* Make sure the image fills the container width */
        }

        /* Optional: To adjust other card components */
        .product-card {
            margin-bottom: 20px;
        }
        .categories-container {
            margin-top: 20px;
        }

        .category-header {
            cursor: pointer;
            font-size: 18px;
        }

        .category-header:hover {
            background-color: #0056b3;
            color: #fff;
        }

        #categories-list {
            padding-left: 20px;
            margin-top: 10px;
        }

        .category-item {
            color: #007bff;
        }

        .category-item:hover {
            color: #0056b3;
        }


    </style>
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

    <!-- Start Content -->
    <div class="container py-5">
        <div class="row">

            <div class="col-lg-3">

                <div class="categories-container">
                    <button class="category-header btn btn-primary">View Categories</button>

                    <!-- Dropdown for categories (hidden initially) -->
                    <ul id="categories-list" class="list-unstyled" style="display: none;">
                        @foreach ($categories as $category)
                            <li class="pb-2">
                                <a href="{{ route('shop.category', ['category' => $category->name]) }}" class="category-item text-decoration-none">
                                    {{ $category->name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>


            </div>

            <div class="col-lg-9">
                <div class="row">
                    <div class="col-md-6">
                        <ul class="list-inline shop-top-menu pb-3 pt-1">
                            <li class="list-inline-item">
                                <a class="h3 text-dark text-decoration-none mr-3" href="#">All</a>
                            </li>
                            <li class="list-inline-item">
                                <a class="h3 text-dark text-decoration-none mr-3" href="#">Men's</a>
                            </li>
                            <li class="list-inline-item">
                                <a class="h3 text-dark text-decoration-none" href="#">Women's</a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-6 pb-4">
                        <div class="d-flex">
                            <select class="form-control">
                                <option>Featured</option>
                                <option>A to Z</option>
                                <option>Item</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    @foreach($products as $product)
                        <div class="col-md-4">
                            <div class="card mb-4 product-wap rounded-0">
                                <div class="card rounded-0">
                                    <img class="card-img rounded-0 img-fluid product-img"
                                         src="{{ asset('storage/' . $product->image) }}"
                                         alt="{{ $product->name }}">
                                    <div class="card-img-overlay rounded-0 product-overlay d-flex align-items-center justify-content-center">
                                        <ul class="list-unstyled">
                                            <li><a class="btn btn-success text-white mt-2" href="/shop-single?id={{ $product->id }}"><i class="far fa-eye"></i></a></li>
                                            <li><a class="btn btn-success text-white mt-2" href="/cart?id={{$product->id}}"><i class="fas fa-cart-plus"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <a href="/shop-single?id={{ $product->id }}" class="h3 text-decoration-none">{{ $product->name }}</a>
                                    <ul class="w-100 list-unstyled d-flex justify-content-between mb-0">
                                        <li>M/L/X/XL</li>
                                        <li class="pt-2">
                                            <span class="product-color-dot color-dot-red float-left rounded-circle ml-1"></span>
                                            <span class="product-color-dot color-dot-blue float-left rounded-circle ml-1"></span>
                                            <span class="product-color-dot color-dot-black float-left rounded-circle ml-1"></span>
                                            <span class="product-color-dot color-dot-light float-left rounded-circle ml-1"></span>
                                            <span class="product-color-dot color-dot-green float-left rounded-circle ml-1"></span>
                                        </li>
                                    </ul>
                                    <ul class="list-unstyled d-flex justify-content-center mb-1">
                                        <li>
                                            <i class="text-warning fa fa-star"></i>
                                            <i class="text-warning fa fa-star"></i>
                                            <i class="text-warning fa fa-star"></i>
                                            <i class="text-muted fa fa-star"></i>
                                            <i class="text-muted fa fa-star"></i>
                                        </li>
                                    </ul>
                                    <p class="text-center mb-0">${{ number_format($product->price, 2) }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
        </div>

    </div>
    <!-- End Content -->

    <!-- Start Footer -->
    @include("home.footer")
    <!-- End Footer -->

    <!-- Start Script -->
    @include("home.js")
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // When the "Categories" button is clicked
            $('.category-header').click(function() {
                // Toggle the visibility of the categories list
                $('#categories-list').toggle();
            });
        });
    </script>

    <!-- End Script -->
    </body>

</html>
