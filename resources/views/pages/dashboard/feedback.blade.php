@extends('layouts.dashboard.index')

@section('title')
    Feedbacks
@endsection

@section('content.dashboard')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Data Informasi Pengunjung</h4>

                        <div class="table-responsive">
                            <table class="table table-striped" id="table-feedback">
                                <thead>
                                    <tr>
                                        <th>Nama</th>
                                        <th>Email</th>
                                        <th>Message</th>
                                        <th>Phone</th>
                                        <th>Tanggal Pengajuan</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($feedbacks as $f)
                                        <tr>
                                            <td>{{ $f->feedback_firstname }} {{ $f->feedback_lastname }} </td>
                                            <td>{{ $f->feedback_email }}</td>
                                            <td>{{ $f->feedback_message }}</td>
                                            <td>{{ $f->feedback_phone }}</td>
                                            <td>{{ $f->created_at }}</td>
                                            <td>
                                                <button type="button" id="delete-btn" data-id="{{ $f->feedback_id }}"
                                                    class="btn btn-danger btn-sm">Delete</button>
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
            $('#table-feedback').DataTable();
        });

        $(document).on("click", "#delete-btn", function() {
            let id = $(this).data('id');

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '/feedbacks/' + id,
                        method: 'delete',
                        data: {
                            _token: `{{ csrf_token() }}`,
                        },
                        success: function(response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success...',
                                text: response.message,
                            }).then(() => {
                                location.reload();
                            })
                        },
                        error: function(err) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: err.responseJSON.message,
                            })
                        }
                    })
                }
            })
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
    @if (session('feedback.success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Success...',
                text: '{{ session('feedback.success') }}',
            })
        </script>
    @endif
    @if (session('feedback.error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: '{{ session('feedback.error') }}',
            })
        </script>
    @endif
@endpush
