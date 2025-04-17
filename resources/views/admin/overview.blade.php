<div class="col-sm-6">
    <h3 class="mb-0 font-weight-bold">
        {{ Auth::user()->name }}

    </h3>
</div>
</div>
<div class="row  mt-3">
    <div class="col-xl-5 d-flex grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex flex-wrap justify-content-between">
                    <h4 class="card-title mb-3">Sales by Category</h4>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="row">
                            <div class="col-lg-6">
                                <div id="circleProgress6" class="progressbar-js-circle rounded p-3"></div>
                            </div>
                            <div class="col-lg-6">
                                <ul class="sales-by-category-legend">
                                    @foreach($category_sales as $sales)
                                        <li>
                                            <div>{{ $sales['category_name'] }} ({{ $sales['product_count'] }})</div>
                                            <div>${{ number_format($sales['total_revenue'], 2) }} ({{ $sales['percentage'] }}%)</div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 d-flex grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex flex-wrap justify-content-between">
                    <h4 class="card-title mb-3">Product Overview</h4>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="d-flex justify-content-between mb-md-5 mt-3">
                                    <div class="small">Critical</div>
                                    <div class="text-danger small">Low Stock</div>
                                    <div class="text-warning small">Restocking Soon</div>
                                </div>
                                <canvas id="eventChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-4 d-flex grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex flex-wrap justify-content-between">
                    <h4 class="card-title mb-3">Inventory Stats</h4>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="d-flex justify-content-between mb-4">
                                    <div>Total Products</div>
                                    <div class="text-muted">{{ $total_products }}</div>
                                </div>
                                <div class="d-flex justify-content-between mb-4">
                                    <div>Average Price</div>
                                    <div class="text-muted">${{ number_format($average_price, 2) }}</div>
                                </div>
                                <div class="d-flex justify-content-between mb-4">
                                    <div>Total Revenue</div>
                                    <div class="text-muted">${{ number_format($total_revenue, 2) }}</div>
                                </div>
                                <div class="d-flex justify-content-between mb-4">
                                    <div>Products in Low Stock</div>
                                    <div class="text-muted">{{ $low_stock_count }}</div>
                                </div>
                                <div class="progress progress-md mt-4">
                                    <div class="progress-bar bg-success" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



