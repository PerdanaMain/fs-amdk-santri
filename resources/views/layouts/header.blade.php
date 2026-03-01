<!-- ***** Header Area Start ***** -->
<header class="header-area header-sticky wow slideInDown" data-wow-duration="0.75s" data-wow-delay="0s">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <nav class="main-nav">
                    <a href="/" class="logo">
                        <img src="{{ asset('assets/images/favicon.ico') }}" alt="">
                    </a>
                    <ul class="nav">
                        <li class="scroll-to-section"><a href="/"
                                class="{{ Route::currentRouteName() == 'home' ? 'active' : '' }}">Home</a></li>
                        <li class="scroll-to-section"><a href="/product"
                                class="{{ Route::currentRouteName() == 'product' ? 'active' : '' }}">Product</a></li>
                        <li class="scroll-to-section"><a href="/sertification"
                                class="{{ Route::currentRouteName() == 'sertification' ? 'active' : '' }}">Sertification</a>
                        </li>
                        <li class="scroll-to-section"><a href="/media"
                                class="{{ Route::currentRouteName() == 'media.public' || Route::currentRouteName() == 'media.detail' ? 'active' : '' }}">Media</a>
                        </li>
                        <li class="scroll-to-section"><a href="/about"
                                class="{{ Route::currentRouteName() == 'about' ? 'active' : '' }}">About Us</a></li>
                        <li class="scroll-to-section">
                            <div class="main-blue-button">
                                <a href="/login" role="button" data-bs-toggle="modal"
                                    data-bs-target="#loginModal">Sign
                                    In</a>
                            </div>
                        </li>
                    </ul>
                    <a class='menu-trigger'>
                        <span>Menu</span>
                    </a>
                    <!-- ***** Menu End ***** -->
                </nav>
            </div>
        </div>
    </div>
</header>
<!-- ***** Header Area End ***** -->
