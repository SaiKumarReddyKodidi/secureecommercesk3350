<section class="bg-light">
    <div class="container py-5">
        <div class="row text-center py-3">
            <div class="col-lg-6 m-auto">
                <h1 class="h1">Featured Products</h1>
                <p>
                    Discover our top picks for this month. Each product is carefully selected to ensure quality and satisfaction.
                </p>
            </div>
        </div>
        <div class="row">
            @foreach($products as $product)
                <div class="col-12 col-md-4 mb-4">
                    <div class="card h-100">
                        <a href="/shop-single?id={{ $product->id }}">
                            <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}">
                        </a>
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
