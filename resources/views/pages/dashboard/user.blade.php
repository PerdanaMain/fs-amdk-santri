@extends('layouts.dashboard.index')

@section('title')
    Users
@endsection

@section('content.dashboard')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Data User yang mengajukan reset password</h4>

                        <div class="table-responsive">
                            <table class="table table-striped" id="table-purchase">
                                <thead>
                                    <tr>
                                        <th>Nama Employee</th>
                                        <th>Nama Customer</th>
                                        <th>Deskripsi</th>
                                        <th>Lupa Password</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $u)
                                        <tr>
                                            <td>{{ $u->user_name }}</td>
                                            <td>{{ $u->user_phone }}</td>
                                            <td>{{ $u->user_branch }}</td>
                                            <td>
                                                <button class="btn btn-primary" id="reset-btn" data-id="{{ $u->user_id }}">
                                                    Reset Password
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('dashboard.script')
    <script>
        $(document).ready(function() {
            $('#table-purchase').DataTable();
        });

        $(document).on("click", "#reset-btn", function() {
            let id = $(this).data("id");
            Swal.fire({
                icon: "warning",
                text: "Apakah anda yakin ingin mereset password user ini?",
                title: "Konfirmasi",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Ya, Reset!",
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "/user/reset-password/" + id,
                        type: "PUT",
                        data: {
                            _token: "{{ csrf_token() }}",
                        },
                        success: function(response) {
                            Swal.fire({
                                icon: "success",
                                title: "Success...",
                                text: response.message,
                            }).then(() => {
                                location.reload();
                            });
                        },
                        error: function(err) {
                            Swal.fire({
                                icon: "error",
                                title: "Oops...",
                                text: err.responseJSON.message,
                            });
                        },
                    })
                }
            });
        })
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
    @if (session('user.success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Success...',
                text: '{{ session('user.success') }}',
            })
        </script>
    @endif
    @if (session('user.error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: '{{ session('user.error') }}',
            })
        </script>
    @endif
@endpush
