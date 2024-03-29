<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('home') }}" class="brand-link">
      <img src="{{asset('dist/img/denaku-intial.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">DenAku</span>
    </a>
    {{-- <img src="dist/img/logo.svg" alt=""> --}}

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{asset('dist/img/user2-160x160.jpg')}}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">{{ $user->name }}</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          
          <li class="nav-item {{ (request()->is('dashboard')) ? 'menu-open' : '' }}">
            <a href="{{route('home') }}" class="nav-link">
              <i class="nav-icon fas fa-solid fa-dashboard"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>

          <li class="nav-item {{ (request()->is('point-of-sale')) ? 'menu-open' : '' }}">
            <a href="{{route('pos.view') }}" class="nav-link">
              <i class="nav-icon fas fa-solid fa-calculator"></i>
              <p>
                POS
              </p>
            </a>
          </li>

          <li class="nav-item {{ (request()->is('sales')) ? 'menu-open' : '' }}">
            <a href="{{route('sales.view') }}" class="nav-link">
              <i class="nav-icon fas fa-solid fa-shopping-cart"></i>
              <p>
                Sales
              </p>
            </a>
          </li>

          {{-- <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-solid fa-briefcase"></i>
              <p>
                Order Management
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('order.add')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>New Orders</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('order.index')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Order List</p>
                </a>
              </li>
            </ul>
          </li> --}}

          <li class="nav-item treeview {{ (request()->is('product*')) ? 'menu-open' : '' }}">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-solid fa-cash-register"></i>
              <p>
                Products
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item {{ (request()->is('product')) ? 'active' : '' }}">
                <a href="{{ route('product.index') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Product List</p>
                </a>
              </li>
              <li class="nav-item {{ (request()->is('product/category')) ? 'active' : '' }}">
                <a href="{{ route('product-category.index') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Product Category</p>
                </a>
              </li>
            </ul>
          </li>
          
          <li class="nav-item {{ (request()->is('client')) ? 'menu-open' : '' }}" >
            <a href="{{route('client.index')}}" class="nav-link" >
              <i class="nav-icon fas fa-solid fa-user"></i>
              <p>
                Customers
              </p>
            </a>
          </li>
          
          {{-- <li class="nav-item {{ (request()->is('/store')) ? 'menu-open' : '' }}" >
            <a href="{{route('store.index')}}" class="nav-link" >
              <i class="nav-icon fas fa-solid fa-store"></i>
              <p>
                Stores
              </p>
            </a>
          </li> --}}
          <li class="nav-item {{ (request()->is('delivery*')) ? 'menu-open' : '' }}">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-solid fa-truck"></i>
              <p>
                Delivery
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item {{ (request()->is('delivery/list')) ? 'active' : '' }}">
                <a href="{{ route('product.index') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Delivery List</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="/logout" class="nav-link">
              <i class="nav-icon fas fa-sign-out-alt"></i>
              <p>
                Sign Out
              </p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>