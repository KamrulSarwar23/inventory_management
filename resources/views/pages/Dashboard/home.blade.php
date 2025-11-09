@extends("layouts.master")
@section("page")
<section class="content">
    <div class="container-fluid">
        <!-- Dashboard Stats Row 1 -->
        <div class="row">
            <!-- Orders Overview -->
            <div class="col-lg-3 col-6">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{ $totalOrders }}</h3>
                        <p>Total Orders</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                    <a href="{{ route('orders.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            
            <!-- Pending Orders -->
            <div class="col-lg-3 col-6">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>{{ $pendingOrders }}</h3>
                        <p>Pending Orders</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-clock"></i>
                    </div>
                    <a href="{{ route('orders.index', ['status' => 'pending']) }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            
            <!-- Completed Orders -->
            <div class="col-lg-3 col-6">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>{{ $completedOrders }}</h3>
                        <p>Completed Orders</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-checkmark"></i>
                    </div>
                    <a href="{{ route('orders.index', ['status' => 'completed']) }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            
            <!-- Order Revenue -->
            <div class="col-lg-3 col-6">
                <div class="small-box bg-primary">
                    <div class="inner">
                        <h3>${{ number_format($totalOrderValue, 2) }}</h3>
                        <p>Total Order Value</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-cash"></i>
                    </div>
                    <a href="{{ route('orders.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>

        <!-- Dashboard Stats Row 2 -->
        <div class="row">
            <!-- Customers -->
            <div class="col-lg-3 col-6">
                <div class="small-box bg-secondary">
                    <div class="inner">
                        <h3>{{ $totalCustomers }}</h3>
                        <p>Total Customers</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-person-stalker"></i>
                    </div>
                    <a href="{{ route('customers.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            
            <!-- Products -->
            <div class="col-lg-3 col-6">
                <div class="small-box bg-teal">
                    <div class="inner">
                        <h3>{{ $totalProducts }}</h3>
                        <p>Total Products</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-cube"></i>
                    </div>
                    <a href="{{ route('products.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            
            <!-- Categories -->
            <div class="col-lg-3 col-6">
                <div class="small-box bg-indigo">
                    <div class="inner">
                        <h3>{{ $totalCategories }}</h3>
                        <p>Product Categories</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-ios-list"></i>
                    </div>
                    <a href="{{ route('categories.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            
            <!-- Low Stock Products -->
            <div class="col-lg-3 col-6">
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3>{{ $lowStockProducts }}</h3>
                        <p>Low Stock Products</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-alert"></i>
                    </div>
                    <a href="{{ route('products.index', ['low_stock' => true]) }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>

        <!-- Dashboard Stats Row 3 -->
        <div class="row">
            <!-- Suppliers -->
            <div class="col-lg-3 col-6">
                <div class="small-box bg-orange">
                    <div class="inner">
                        <h3>{{ $totalSuppliers }}</h3>
                        <p>Total Suppliers</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-ios-people"></i>
                    </div>
                    <a href="{{ route('suppliers.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            
            <!-- Purchases -->
            <div class="col-lg-3 col-6">
                <div class="small-box bg-purple">
                    <div class="inner">
                        <h3>{{ $totalPurchases }}</h3>
                        <p>Total Purchases</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-ios-cart"></i>
                    </div>
                    <a href="{{ route('purchases.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            
            <!-- Purchase Value -->
            <div class="col-lg-3 col-6">
                <div class="small-box bg-maroon">
                    <div class="inner">
                        <h3>${{ number_format($totalPurchaseValue, 2) }}</h3>
                        <p>Total Purchase Value</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-social-usd"></i>
                    </div>
                    <a href="{{ route('purchases.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            
            <!-- Warehouses -->
            <div class="col-lg-3 col-6">
                <div class="small-box bg-olive">
                    <div class="inner">
                        <h3>{{ $totalWarehouses }}</h3>
                        <p>Warehouses</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-home"></i>
                    </div>
                    <a href="{{ route('warehouses.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>

        <!-- Additional Stats Row 4 -->
        <div class="row">
            <!-- Shippers -->
            <div class="col-lg-3 col-6">
                <div class="small-box bg-navy">
                    <div class="inner">
                        <h3>{{ $totalShippers }}</h3>
                        <p>Shipping Partners</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-plane"></i>
                    </div>
                    <a href="{{ route('shippers.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            
            <!-- Today's Orders -->
            <div class="col-lg-3 col-6">
                <div class="small-box bg-fuchsia">
                    <div class="inner">
                        <h3>{{ $todayOrders }}</h3>
                        <p>Today's Orders</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-calendar"></i>
                    </div>
                    <a href="{{ route('orders.index', ['date' => today()->format('Y-m-d')]) }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            
            <!-- This Month Revenue -->
            <div class="col-lg-3 col-6">
                <div class="small-box bg-lime">
                    <div class="inner">
                        <h3>${{ number_format($thisMonthRevenue, 2) }}</h3>
                        <p>This Month Revenue</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-pie-graph"></i>
                    </div>
                    <a href="{{ route('orders.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            
            <!-- Processing Orders -->
            <div class="col-lg-3 col-6">
                <div class="small-box bg-lightblue">
                    <div class="inner">
                        <h3>{{ $processingOrders }}</h3>
                        <p>Processing Orders</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-gear-a"></i>
                    </div>
                    <a href="{{ route('orders.index', ['status' => 'processing']) }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>

        <!-- Charts and Additional Information Section -->
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Recent Orders</h3>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Order ID</th>
                                    <th>Customer</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentOrders as $order)
                                <tr>
                                    <td>#{{ $order->id }}</td>
                                    <td>{{ $order->customer->name ?? 'N/A' }}</td>
                                    <td>${{ number_format($order->order_total, 2) }}</td>
                                    <td>
                                        <span class="badge badge-{{ 
                                            $order->status == \App\Models\Order::STATUS_COMPLETED ? 'success' : 
                                            ($order->status == \App\Models\Order::STATUS_PENDING ? 'warning' : 
                                            ($order->status == \App\Models\Order::STATUS_PROCESSING ? 'info' : 'danger')) 
                                        }}">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Low Stock Products</h3>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Category</th>
                                    <th>Stock</th>
                                    <th>Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($lowStockProductsList as $product)
                                <tr>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $product->category->name ?? 'N/A' }}</td>
                                    <td><span class="badge badge-danger">{{ $product->stock }}</span></td>
                                    <td>${{ number_format($product->price, 2) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection