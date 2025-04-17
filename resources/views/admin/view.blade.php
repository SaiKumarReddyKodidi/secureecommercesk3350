<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Admin Panel - View Products</title>
    <!-- base:css -->
    <link rel="stylesheet" href="admin/vendors/typicons.font/font/typicons.css">
    <link rel="stylesheet" href="admin/vendors/css/vendor.bundle.base.css">
    <!-- inject:css -->
    <link rel="stylesheet" href="admin/css/vertical-layout-light/style.css">
    <!-- endinject -->
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.svg">
    <style>
        .uniform-img {
            width: 100%;         /* Ensures the image takes up the full width of the container */
            height: 250px;       /* Sets a fixed height for all images */
            object-fit: cover;   /* Ensures the image is cropped to fit within the defined dimensions */
        }

    </style>
</head>
<body>

<div class="container-scroller">
    <!-- partial:partials/_navbar.html -->
    @include("admin.topnav")
    <!-- partial -->
    @include('admin.sidebar')
    <!-- partial -->
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <!-- Loop through products and display each product in a card -->
                @foreach ($products as $product)
                    <div class="col-12 col-md-4 grid-margin stretch-card">
                        <div class="card">
                            <img src="{{ Storage::url($product->image) }}" class="card-img-top uniform-img" alt="{{ $product->name }}">
                            <div class="card-body">
                                <h5 class="card-title">{{ $product->name }}</h5>
                                <p class="card-text">{{ Str::limit($product->description, 100) }}</p>

                                <!-- Check if the category is loaded and exists -->
                                <p class="card-text">
                                    Category: {{ $product->category ? $product->category->name : 'No category assigned' }}
                                </p>

                                <p class="card-text"><strong>${{ number_format($product->price, 2) }}</strong></p>
                                {{--                <a href="{{ route('products.show', $product->id) }}" class="btn btn-primary">View Details</a>--}}
                            </div>
                        </div>
                    </div>
                @endforeach



            </div>
        </div>
        <!-- content-wrapper ends -->
        <!-- partial:partials/_footer.html -->
        @include('admin.footer')
        <!-- partial -->
    </div>
    <!-- main-panel ends -->
</div>
<!-- page-body-wrapper ends -->
</div>
<!-- container-scroller -->
<!-- base:js -->
<script src="admin/vendors/js/vendor.bundle.base.js"></script>
<!-- inject:js -->
<script src="admin/js/off-canvas.js"></script>
<script src="admin/js/hoverable-collapse.js"></script>
<script src="admin/js/template.js"></script>
<script src="admin/js/settings.js"></script>
<script src="admin/js/todolist.js"></script>
<!-- End inject -->
<script src="admin/vendors/progressbar.js/progressbar.min.js"></script>
<script src="admin/vendors/chart.js/Chart.min.js"></script>
<script src="admin/js/dashboard.js"></script>

</body>
</html>
