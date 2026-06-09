<!-- partial:partials/_navbar.html -->
<nav class="navbar default-layout col-lg-12 col-12 p-0 fixed-top d-flex align-items-top flex-row">
    <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-start">
        <div class="me-3">
            <button class="navbar-toggler align-self-center d-none d-lg-inline-block" type="button"
                data-bs-toggle="minimize">
                <span class="icon-menu"></span>
            </button>
            <button class="navbar-toggler navbar-toggler-right align-self-center d-lg-none" type="button"
                data-toggle="offcanvas">
                <span class="icon-menu"></span>
            </button>
        </div>
        <div>
            <a class="navbar-brand d-none d-sm-inline-block" href="/dashboard">
                <span style="color: #0362a6; font-weight:600;">
                    AMDK <b style="color: #008000">Santri</b>
                </span>
            </a>
        </div>
    </div>
    <div class="navbar-menu-wrapper d-flex align-items-top">
        <ul class="navbar-nav">
            <li class="nav-item font-weight-semibold d-none d-lg-block ms-0">
                <h1 class="welcome-text">Welcome, <span class="text-black fw-bold">
                        {{ session()->get('user')->user_name }}</span></h1>
                <h3 class="welcome-sub-text">
                    <b>{{ session()->get('user')->role->role_description }}</b> - AMDK Santri
                </h3>
            </li>
        </ul>
        <ul class="navbar-nav ms-auto">
            <li class="nav-item dropdown d-none d-lg-block user-dropdown">
                <a class="nav-link" id="UserDropdown" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                    @if (session()->get('user')->user_photo)
                        <img class="img-md rounded-circle"
                            src="{{ asset('storage/profiles/' . session()->get('user')->user_photo) }}"
                            alt="Profile image" style="width: 40px;">
                    @else
                        <img class="img-md rounded-circle" src="dashboards/images/faces/face8.jpg" alt="Profile image">
                    @endif
                </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="UserDropdown">
                    <div class="dropdown-header text-center">
                        @if (session()->get('user')->user_photo)
                            <img class="img-md rounded-circle"
                                src="{{ asset('storage/profiles/' . session()->get('user')->user_photo) }}"
                                alt="Profile image" style="width: 40px;">
                        @else
                            <img class="img-md rounded-circle" src="dashboards/images/faces/face8.jpg"
                                alt="Profile image">
                        @endif

                        <p class="mb-1 mt-3 font-weight-semibold">
                            {{ session()->get('user')->user_name }}
                        </p>
                        <p class="fw-light text-muted mb-0">
                            {{ session()->get('user')->role->user_email }}
                        </p>
                    </div>
                    <a class="dropdown-item" href="/profile"><i
                            class="dropdown-item-icon mdi mdi-account-outline text-primary me-2"></i> My
                        Profile </a>

                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="dropdown-item" type="submit">
                            <i class="dropdown-item-icon mdi mdi-power text-primary me-2"></i>Sign
                            Out
                        </button>
                    </form>
                </div>
            </li>
        </ul>
    </div>
</nav>
<!-- partial -->
