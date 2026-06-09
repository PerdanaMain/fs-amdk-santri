<!-- partial:partials/_sidebar.html -->
<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item {{ Route::currentRouteName() == 'dashboard' ? 'active' : '' }}">
            <a class="nav-link" href="/dashboard">
                <i class="mdi mdi-grid-large menu-icon"></i>
                <span class="menu-title">Dashboard</span>
            </a>
        </li>
        <li class="nav-item nav-category">Systems</li>
        <li class="nav-item {{ Route::currentRouteName() == 'stocks' ? 'active' : '' }}">
            <a class="nav-link" href="/stocks">
                <i class="mdi mdi-archive menu-icon"></i>
                <span class="menu-title">Stocks</span>
            </a>
        </li>

        @if (in_array(session()->get('user')->role_id, [1, 2, 3, 5, 6]))
            <li class="nav-item {{ Route::currentRouteName() == 'customer' ? 'active' : '' }}">
                <a class="nav-link" href="/customers">
                    <i class="mdi mdi-account-multiple menu-icon"></i>
                    <span class="menu-title">Customers</span>
                </a>
            </li>
        @endif
        @if (in_array(session()->get('user')->role_id, [1, 2, 3, 5, 6]))
            <li class="nav-item {{ Route::currentRouteName() == 'supplier' ? 'active' : '' }}">
                <a class="nav-link" href="/suppliers">
                    <i class="mdi mdi-truck menu-icon"></i>
                    <span class="menu-title">Suppliers</span>
                </a>
            </li>
        @endif
        @if (session()->get('user')->role_id == 2)
            <li class="nav-item {{ Route::currentRouteName() == 'employee' ? 'active' : '' }}">
                <a class="nav-link" href="/employees">
                    <i class="mdi mdi-account menu-icon"></i>
                    <span class="menu-title">Employees</span>
                </a>
            </li>
        @endif
        @if (in_array(session()->get('user')->role_id, [1, 2, 5, 6]))
            <li class="nav-item {{ Route::currentRouteName() == 'feedbacks' ? 'active' : '' }}">
                <a class="nav-link" href="/feedbacks">
                    <i class="mdi mdi-email-outline menu-icon"></i>
                    <span class="menu-title">Feedbacks</span>
                </a>
            </li>
        @endif

        @if (in_array(session()->get('user')->role_id, [1, 2, 5, 6]))
            <li class="nav-item {{ Route::currentRouteName() == 'media.index' ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('media.index') }}">
                    <i class="mdi mdi-folder-image menu-icon"></i>
                    <span class="menu-title">Media</span>
                </a>
            </li>
        @endif

        @if (in_array(session()->get('user')->role_id, [1, 2, 5, 6]))
            <li class="nav-item nav-category">Transactions</li>
            <li class="nav-item" {{ Route::currentRouteName() == 'purchase' ? 'active' : '' }}>
                <a class="nav-link" href="/purchase">
                    <i class="mdi mdi-cart-outline menu-icon"></i>
                    <span class="menu-title">Pembelian</span>
                </a>
            </li>
        @endif
        @if (in_array(session()->get('user')->role_id, [1, 2, 3, 5, 6]))
            <li class="nav-item" {{ Route::currentRouteName() == 'sales' ? 'active' : '' }}>
                <a class="nav-link" href="/sales">
                    <i class="mdi mdi-chart-areaspline menu-icon"></i>
                    <span class="menu-title">Penjualan</span>
                </a>
            </li>
        @endif
        
        @if (in_array(session()->get('user')->role_id, [1, 2, 5, 6]))
            <li class="nav-item nav-category">Tagihan</li>
            <li class="nav-item {{ Route::currentRouteName() == 'debts.payable' ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('debts.payable') }}">
                    <i class="mdi mdi-cash-multiple menu-icon"></i>
                    <span class="menu-title">Hutang</span>
                </a>
            </li>
            <li class="nav-item {{ Route::currentRouteName() == 'debts.receivable' ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('debts.receivable') }}">
                    <i class="mdi mdi-cash-usd menu-icon"></i>
                    <span class="menu-title">Piutang</span>
                </a>
            </li>
        @endif
        @if (in_array(session()->get('user')->role_id, [1, 2, 3, 5, 6]))
            <li class="nav-item nav-category">Shipments</li>
            <li class="nav-item {{ Route::currentRouteName() == 'visit' ? 'active' : '' }}">
                <a class="nav-link" href="/visits">
                    <i class="mdi mdi-map-marker-circle menu-icon"></i>
                    <span class="menu-title">Kunjungan</span>
                </a>
            </li>
        @endif
        @if (in_array(session()->get('user')->role_id, [1, 2, 4, 5, 6]))
            <li class="nav-item {{ Route::currentRouteName() == 'delivery' ? 'active' : '' }}">
                <a class="nav-link" href="/delivery">
                    <i class="mdi mdi-car-pickup menu-icon"></i>
                    <span class="menu-title">Delivery Order</span>
                </a>
            </li>
        @endif

        @if (in_array(session()->get('user')->role_id, [1, 2, 5, 6]))
            <li class="nav-item nav-category">Laporan</li>
            <li class="nav-item {{ Route::currentRouteName() == 'financens' ? 'active' : '' }}">
                <a class="nav-link" href="/finance">
                    <i class="mdi mdi-cart menu-icon"></i>
                    <span class="menu-title">Keuangan</span>
                </a>
            </li>
            <li class="nav-item {{ Route::currentRouteName() == 'assets.index' ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('assets.index') }}">
                    <i class="mdi mdi-cube-outline menu-icon"></i>
                    <span class="menu-title">Aset</span>
                </a>
            </li>
        @endif

        @if (in_array(session()->get('user')->role_id, [1, 2, 5, 6]))
            <li class="nav-item {{ Route::currentRouteName() == 'purchaseHistory' ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('purchaseHistory') }}">
                    <i class="mdi mdi-history menu-icon"></i>
                    <span class="menu-title">Riwayat Pembelian</span>
                </a>
            </li>
        @endif
        @if (in_array(session()->get('user')->role_id, [1, 2, 5, 6]))
            <li class="nav-item {{ Route::currentRouteName() == 'salesHistory' ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('salesHistory') }}">
                    <i class="mdi mdi-history menu-icon"></i>
                    <span class="menu-title">Riwayat Penjualan</span>
                </a>
            </li>
        @endif
        @if (in_array(session()->get('user')->role_id, [1, 2, 5, 6]))
            <li class="nav-item {{ Route::currentRouteName() == 'deliveryHistory' ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('deliveryHistory') }}">
                    <i class="mdi mdi-history menu-icon"></i>
                    <span class="menu-title">Riwayat Pengiriman</span>
                </a>
            </li>
        @endif


        <li class="nav-item nav-category">Settings</li>
        <li class="nav-item">
            <a class="nav-link" href="/profile">
                <i class="mdi mdi-account menu-icon"></i>
                <span class="menu-title">Profile</span>
            </a>
        </li>
        @if (in_array(session()->get('user')->role_id, [1, 2, 5, 6]))
            <li class="nav-item">
                <a class="nav-link" href="/user">
                    <i class="mdi mdi-account-multiple menu-icon"></i>
                    <span class="menu-title">User</span>
                </a>
            </li>
        @endif
    </ul>
</nav>
<!-- partial -->
