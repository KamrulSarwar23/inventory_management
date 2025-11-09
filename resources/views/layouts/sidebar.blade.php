<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="#" class="brand-link">
    <img src="{{asset('dist/img/AdminLTELogo.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
    <span class="brand-text font-weight-light">Inventory</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
       
    <li style="margin-left: -4px" class="nav-item {{ request()->routeIs('dashboard') ? 'menu-open active' : '' }}">
        <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
        <i class="nav-icon fas fa-tachometer-alt"></i>
        <p>
            Dashboard
        </p>
       </a>
    </li>

<!-- Product -->
<li class="nav-item {{ request()->routeIs(['products.index', 'products.create', 'products.show', 'products.edit']) ? 'menu-open active' : '' }}">
    <a href="#" class="nav-link {{ request()->routeIs(['products.create', 'products.index', 'products.show', 'products.edit']) ? 'active' : '' }}">
        <i class="fas fa-box"></i>
        <p>
            Products
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('products.create') }}" class="nav-link {{ request()->routeIs('products.create') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Create Products</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('products.index') }}" class="nav-link {{ request()->routeIs(['products.index', 'products.show', 'products.edit']) ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Manage Products</p>
            </a>
        </li>
    </ul>
</li>
<!-- end -->

<!-- Category -->
<li class="nav-item {{ request()->routeIs(['categories.create', 'categories.index', 'categories.show','categories.edit']) ? 'menu-open active' : '' }}">
    <a href="#" class="nav-link {{ request()->routeIs(['categories.create', 'categories.index', 'categories.show', 'categories.edit']) ? 'active' : '' }}">
        <i class="fas fa-tags"></i>
        <p>
            Categories
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('categories.create') }}" class="nav-link {{ request()->routeIs('categories.create') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Create Category</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('categories.index') }}" class="nav-link {{ request()->routeIs(['categories.index', 'categories.show', 'categories.edit']) ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Manage Categories</p>
            </a>
        </li>
    </ul>
</li>
<!-- end -->

<!-- Customer -->
<li class="nav-item {{ request()->routeIs(['customers.create', 'customers.index', 'customers.show', 'customers.edit']) ? 'menu-open active' : '' }}">
    <a href="#" class="nav-link {{ request()->routeIs(['customers.create', 'customers.index', 'customers.show', 'customers.edit']) ? 'active' : '' }}">
        <span class="fa-solid fa-users"></span>
        <p>
            Customers
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('customers.create') }}" class="nav-link {{ request()->routeIs('customers.create') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Create Customer</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('customers.index') }}" class="nav-link {{ request()->routeIs(['customers.index', 'customers.show', 'customers.edit']) ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Manage Customer</p>
            </a>
        </li>
    </ul>
</li>

<!-- Warehouse -->
<li class="nav-item {{ request()->routeIs(['warehouses.create', 'warehouses.index', 'warehouses.show', 'warehouses.edit']) ? 'menu-open active' : '' }}">
    <a href="#" class="nav-link {{ request()->routeIs(['warehouses.create', 'warehouses.index', 'warehouses.show', 'warehouses.edit']) ? 'active' : '' }}">
        <i class="fa-solid fa-warehouse"></i>
        <p>
            Warehouse
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('warehouses.create') }}" class="nav-link {{ request()->routeIs('warehouses.create') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Create Warehouse</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('warehouses.index') }}" class="nav-link {{ request()->routeIs(['warehouses.index', 'warehouses.show', 'warehouses.edit']) ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Manage Warehouses</p>
            </a>
        </li>
    </ul>
</li>

<!-- Suppliers -->
<li class="nav-item {{ request()->routeIs(['suppliers.create', 'suppliers.index', 'suppliers.show', 'suppliers.edit']) ? 'menu-open active' : '' }}">
    <a href="#" class="nav-link {{ request()->routeIs(['suppliers.create', 'suppliers.index', 'suppliers.show', 'suppliers.edit']) ? 'active' : '' }}">
        <i class="fas fa-truck"></i>
        <p>
            Suppliers
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('suppliers.create') }}" class="nav-link {{ request()->routeIs('suppliers.create') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Create Supplier</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('suppliers.index') }}" class="nav-link {{ request()->routeIs(['suppliers.index', 'suppliers.show', 'suppliers.edit']) ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Manage Suppliers</p>
            </a>
        </li>
    </ul>
</li>

<!-- Shipper -->
<li class="nav-item {{ request()->routeIs(['shippers.create', 'shippers.index', 'shippers.show', 'shippers.edit']) ? 'menu-open active' : '' }}">
    <a href="#" class="nav-link {{ request()->routeIs(['shippers.create', 'shippers.index', 'shippers.show', 'shippers.edit']) ? 'active' : '' }}">
        <i class="fa-solid fa-plane-departure"></i>
        <p>
            Shipper
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('shippers.create') }}" class="nav-link {{ request()->routeIs('shippers.create') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Create Shipper</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('shippers.index') }}" class="nav-link {{ request()->routeIs(['shippers.index', 'shippers.show', 'shippers.edit']) ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Manage Shipper</p>
            </a>
        </li>
    </ul>
</li>

<!-- Order -->
<li class="nav-item {{ request()->routeIs(['orders.create', 'orders.index', 'orders.show', 'orders.edit']) ? 'menu-open active' : '' }}">
    <a href="#" class="nav-link {{ request()->routeIs(['orders.create', 'orders.index', 'orders.show', 'orders.edit']) ? 'active' : '' }}">
        <i class="fas fa-clipboard-list"></i>
        <p>
            Orders
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('orders.create') }}" class="nav-link {{ request()->routeIs('orders.create') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Create Order</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ url('orders') }}" class="nav-link {{ request()->routeIs(['orders.index', 'orders.show', 'orders.edit']) ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Manage Orders</p>
            </a>
        </li>
    </ul>
</li>

        <!-- Purchase -->

        <li class="nav-item">
          <a href="" class="nav-link">
            <span><i class="fa-solid fa-money-bill-transfer"></i></span>
            <p>
              Purchase
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ route('purchases.create') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Create Purchase</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('purchases.index') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Manage Purchase</p>
              </a>
            </li>


          </ul>
        </li>


    
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>