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



<!-- Start Banner Hero -->
@include("home.barner")
<!-- End Banner Hero -->
{{--    @include("home.category")--}}

    <!-- Start Featured Product -->
   @include('home.products')

<!-- End Featured Product -->


<!-- Start Footer -->
@include("home.footer")
    <!-- End Footer -->

<!-- Start Script -->
@include("home.js")
<!-- End Script -->
</body>

</html>
