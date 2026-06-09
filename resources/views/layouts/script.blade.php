<!-- Scripts -->
<script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/js/owl-carousel.js') }}"></script>
<script src="{{ asset('assets/js/animation.js') }}"></script>
<script src="{{ asset('assets/js/imagesloaded.js') }}"></script>
<script src="{{ asset('assets/js/templatemo-custom.js') }}"></script>
<script>
    const navbar = document.querySelector('.col-navbar')
    const cover = document.querySelector('.screen-cover')

    const sidebar_items = document.querySelectorAll('.sidebar-item')

    function toggleNavbar() {
        navbar.classList.toggle('d-none')
        cover.classList.toggle('d-none')
    }

    function toggleActive(e) {
        sidebar_items.forEach(function(v, k) {
            v.classList.remove('active')
        })
        e.closest('.sidebar-item').classList.add('active')

    }
</script>

<!-- Core JS -->
<!-- build:js assets/vendor/js/core.js -->
<script src="{{ asset('vendor/libs/jquery/jquery.js') }}"></script>
<script src="{{ asset('vendor/libs/popper/popper.js') }}"></script>
<script src="{{ asset('vendor/js/bootstrap.js') }}"></script>
<script src="{{ asset('vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
<script src="{{ asset('vendor/libs/node-waves/node-waves.js') }}"></script>

<script src="{{ asset('vendor/libs/hammer/hammer.js') }}"></script>
<script src="{{ asset('vendor/libs/i18n/i18n.js') }}"></script>
<script src="{{ asset('vendor/libs/typeahead-js/typeahead.js') }}"></script>

<script src="{{ asset('vendor/js/menu.js') }}"></script>
<!-- endbuild -->

<!-- Vendors JS -->
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
<script src="{{ asset('vendor/libs/swiper/swiper.js') }}"></script>
<script src="{{ asset('vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>

<!-- Main JS -->
<script src="{{ asset('assets/js/main.js') }}"></script>

<!-- Page JS -->
<script src="{{ asset('assets/js/dashboards-analytics.js') }}"></script>

<!-- Additional JS -->
<script>
    $(document).on("click", "#forgot-btn", function() {
        $("#loginModal").modal("hide");
        Swal.fire({
            title: 'Forgot Password',
            input: 'email',
            inputLabel: 'Enter your email address',
            inputPlaceholder: 'Email Address',
            showCancelButton: true,
            confirmButtonText: 'Send',
            showLoaderOnConfirm: true,
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "/reset-submission/" + result.value,
                    type: "PUT",
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success...',
                            text: response.message,
                        })
                    },
                    error: function(response) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: response.responseJSON.message,
                        })
                    }
                })
            }
        })
    });
</script>

@if ($errors->any())
    @foreach ($errors->all() as $error)
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: '{{ $error }}',
            })
        </script>
    @endforeach
@endif
@if (session('auth.success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Success...',
            text: '{{ session('auth.success') }}',
        })
    </script>
@endif
@if (session('auth.error'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: '{{ session('auth.error') }}',
        })
    </script>
@endif

@stack('script')
