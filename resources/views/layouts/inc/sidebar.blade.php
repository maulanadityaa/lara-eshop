<div class="sidebar" data-color="purple" data-background-color="white" data-image="../assets/img/sidebar-1.jpg">
    <!--
      Tip 1: You can change the color of the sidebar using: data-color="purple | azure | green | orange | danger"

      Tip 2: you can also add an image using data-image tag
  -->
    <div class="logo"><a href="{{ url('/') }}" class="simple-text logo-normal">
             Byboot.id
        </a></div>
    <div class="sidebar-wrapper">
        <ul class="nav">
            <li class="nav-item {{ Request::is('dashboard') ? 'active':'' }}">
                <a class="nav-link" href="{{ url('/dashboard') }}">
                    <i class="material-icons">dashboard</i>
                    <p>Dashboard</p>
                </a>
            </li>
            <li class="nav-item {{ Request::is('categories') ? 'active':'' }}">
                <a class="nav-link" href="{{ url('categories') }}">
                    <i class="material-icons">category</i>
                    <p>Kategori</p>
                </a>
            </li>
            <li class="nav-item {{ Request::is('add-categories') ? 'active':'' }}">
                <a class="nav-link" href="{{ url('add-categories') }}">
                    <i class="material-icons">add</i>
                    <p>Tambah Kategori</p>
                </a>
            </li>
            <li class="nav-item {{ Request::is('products') ? 'active':'' }}">
                <a class="nav-link" href="{{ url('products') }}">
                    <i class="material-icons">inventory_2</i>
                    <p>Produk</p>
                </a>
            </li>
            <li class="nav-item {{ Request::is('add-products') ? 'active':'' }}">
                <a class="nav-link" href="{{ url('add-products') }}">
                    <i class="material-icons">add</i>
                    <p>Tambah Produk</p>
                </a>
            </li>
            <li class="nav-item {{ Request::is('admin/orders') || Request::is('admin/order-history') || Request::is('admin/view-order-details/{id}') ? 'active':'' }}">
                <a class="nav-link" href="{{ url('admin/orders') }}">
                    <i class="material-icons">content_paste</i>
                    <p>Pesanan</p>
                </a>
            </li>
            <li class="nav-item {{ Request::is('users') ? 'active':'' }}">
                <a class="nav-link" href="{{ url('users') }}">
                    <i class="material-icons">person</i>
                    <p>Data Pelanggan</p>
                </a>
            </li>
        </ul>
    </div>
</div>
