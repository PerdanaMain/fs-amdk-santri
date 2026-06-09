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
                                            <td class="text-truncate" style="max-width: 150px;">{!! $f->feedback_firstname !!} {!! $f->feedback_lastname !!}</td>
                                            <td>{{ $f->feedback_email }}</td>
                                            <td class="text-truncate" style="max-width: 200px;">{!! $f->feedback_message !!}</td>
                                            <td>{{ $f->feedback_phone }}</td>
                                            <td>{{ $f->created_at }}</td>
                                            <td>
                                                <button type="button" class="btn btn-info btn-sm detail-btn"
                                                    data-name="{{ $f->feedback_firstname }} {{ $f->feedback_lastname }}"
                                                    data-email="{{ $f->feedback_email }}"
                                                    data-phone="{{ $f->feedback_phone }}"
                                                    data-message="{{ $f->feedback_message }}"
                                                    data-date="{{ $f->created_at }}">Detail</button>
                                                <button type="button" data-id="{{ $f->feedback_id }}"
                                                    class="btn btn-danger btn-sm delete-btn">Delete</button>
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

    <!-- Modal Detail Feedback -->
    <div class="modal fade" id="feedbackDetailModal" tabindex="-1" role="dialog" aria-labelledby="feedbackDetailModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="feedbackDetailModalLabel">Feedback Detail</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p><strong>Name:</strong> <span id="modal-name"></span></p>
                    <p><strong>Email:</strong> <span id="modal-email"></span></p>
                    <p><strong>Phone:</strong> <span id="modal-phone"></span></p>
                    <p><strong>Date:</strong> <span id="modal-date"></span></p>
                    <p><strong>Message:</strong></p>
                    <p id="modal-message"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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

        $(document).on("click", ".detail-btn", function() {
            let name = $(this).data('name');
            let email = $(this).data('email');
            let phone = $(this).data('phone');
            let message = $(this).data('message');
            let date = $(this).data('date');

            $('#modal-name').text(name);
            $('#modal-email').text(email);
            $('#modal-phone').text(phone);
            $('#modal-message').html(message);
            $('#modal-date').text(date);

            $('#feedbackDetailModal').modal('show');
        });

        $(document).on("click", ".delete-btn", function() {
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
