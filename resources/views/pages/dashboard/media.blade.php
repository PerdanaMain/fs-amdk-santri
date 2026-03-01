@extends('layouts.dashboard.index')

@section('title')
    Media & Content
@endsection

@section('content.dashboard')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Media & Content Management</h4>
                        <div class="d-block my-4">
                            @if (in_array(session()->get('user')->role_id, [1, 2, 5, 6]))
                                <button type="button" class="btn btn-primary me-2 mb-3" data-bs-toggle="modal"
                                    data-bs-target="#addModal">Add Media</button>
                            @endif

                            {{-- Add modal --}}
                            <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel"
                                aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="addModalLabel">Add New Media</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <form class="forms-sample" method="POST"
                                                    action="{{ route('media.store') }}" enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="form-group">
                                                        <label for="media_image">Image</label>
                                                        <input type="file" class="form-control" name="media_image">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="media_title">Title <span
                                                                style="color:red">*</span></label>
                                                        <input class="form-control" type="text"
                                                            name="media_title" id="media_title" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="media_category">Category</label>
                                                        <select class="form-select" name="media_category">
                                                            <option value="News">News</option>
                                                            <option value="Article">Article</option>
                                                            <option value="Announcement">Announcement</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="media_content">Content <span
                                                                style="color:red">*</span></label>
                                                        <textarea name="media_content" id="summernote" class="form-control" cols="30" rows="10" required></textarea>
                                                    </div>

                                                    <div class="d-block">
                                                        <button type="submit" class="btn btn-primary me-2">Submit</button>
                                                        <button class="btn btn-light" type="button"
                                                            data-bs-dismiss="modal">Cancel</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="table-responsive">
                            <table class="table table-striped" id="table-media">
                                <thead>
                                    <tr>
                                        <th>Image</th>
                                        <th>Title</th>
                                        <th>Category</th>
                                        <th>Created At</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($medias as $m)
                                        <tr>
                                            <td>
                                                @if ($m->media_image)
                                                    <img src="{{ url('storage/media/' . $m->media_image) }}"
                                                        alt="image" style="width: 70px; height:70px;" />
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td>{{ $m->media_title }}</td>
                                            <td><label class="badge badge-info">{{ $m->media_category }}</label></td>
                                            <td>{{ $m->created_at->format('d M Y H:i') }}</td>
                                            <td>
                                                <a class="nav-link" id="MediaDropdown" href="#"
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="mdi mdi-dots-vertical"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right navbar-dropdown"
                                                    aria-labelledby="MediaDropdown">
                                                    <button class="dropdown-item" data-bs-toggle="modal"
                                                        data-bs-target="#infoModal-{{ $m->media_id }}">
                                                        <i class="dropdown-item-icon mdi mdi-information-outline me-2"></i>
                                                        Info
                                                    </button>
                                                    @if (in_array(session()->get('user')->role_id, [1, 2, 5, 6]))
                                                        <button class="dropdown-item" data-bs-toggle="modal"
                                                            data-bs-target="#updateModal-{{ $m->media_id }}"><i
                                                                class="dropdown-item-icon mdi mdi-pencil-outline me-2"></i>
                                                            Update </button>
                                                        <button class="dropdown-item" data-id="{{ $m->media_id }}"
                                                            id="delete_media"><i
                                                                class="dropdown-item-icon mdi mdi-close me-2"></i>
                                                            Delete</button>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>

                                        {{-- info modal --}}
                                        <div class="modal fade" id="infoModal-{{ $m->media_id }}" tabindex="-1"
                                            aria-labelledby="infoModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="infoModalLabel">{{ $m->media_title }}</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-md-12 mb-3 text-center">
                                                                @if ($m->media_image)
                                                                    <img src="{{ url('storage/media/' . $m->media_image) }}"
                                                                        alt="image" class="img-fluid" style="max-height: 300px;" />
                                                                @endif
                                                            </div>
                                                            <div class="col-md-12">
                                                                <p><strong>Category:</strong> {{ $m->media_category }}</p>
                                                                <hr>
                                                                <div class="content-body">
                                                                    {!! $m->media_content !!}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- Update modal --}}
                                        <div class="modal fade" id="updateModal-{{ $m->media_id }}" tabindex="-1"
                                            aria-labelledby="updateModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="updateModalLabel">Update Media</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <form class="forms-sample" method="POST"
                                                                action="{{ route('media.update', ['id' => $m->media_id]) }}" enctype="multipart/form-data">
                                                                @csrf
                                                                @method('PUT')
                                                                <div class="form-group">
                                                                    <label for="media_image">Image</label>
                                                                    <input type="file" class="form-control" name="media_image">
                                                                    @if ($m->media_image)
                                                                        <small class="text-muted">Current image: {{ $m->media_image }}</small>
                                                                    @endif
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="media_title">Title <span
                                                                            style="color:red">*</span></label>
                                                                    <input class="form-control" type="text"
                                                                        name="media_title" value="{{ $m->media_title }}" required>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="media_category">Category</label>
                                                                    <select class="form-select" name="media_category">
                                                                        <option value="News" {{ $m->media_category == 'News' ? 'selected' : '' }}>News</option>
                                                                        <option value="Article" {{ $m->media_category == 'Article' ? 'selected' : '' }}>Article</option>
                                                                        <option value="Announcement" {{ $m->media_category == 'Announcement' ? 'selected' : '' }}>Announcement</option>
                                                                    </select>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="media_content">Content <span
                                                                            style="color:red">*</span></label>
                                                                    <textarea name="media_content" class="form-control summernote-edit" cols="30" rows="10" required>{{ $m->media_content }}</textarea>
                                                                </div>

                                                                <div class="d-block">
                                                                    <button type="submit"
                                                                        class="btn btn-primary me-2">Submit</button>
                                                                    <button class="btn btn-light" type="button"
                                                                        data-bs-dismiss="modal">Cancel</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
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
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#table-media').DataTable();
            
            // Initialize Summernote for add modal
            $('#summernote').summernote({
                placeholder: 'Write content here...',
                tabsize: 2,
                height: 200,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture', 'video']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ]
            });

            // Initialize Summernote for edit modals
            $('.summernote-edit').summernote({
                placeholder: 'Write content here...',
                tabsize: 2,
                height: 200,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture', 'video']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ]
            });
        });


        $(document).on("click", "#delete_media", function() {
            var media_id = $(this).data('id');
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
                        url: "/media/" + media_id,
                        type: 'DELETE',
                        data: {
                            _token: $("input[name=_token]").val()
                        },
                        success: function(response) {
                            if (response.status == true) {
                                Swal.fire(
                                    'Deleted!',
                                    response.message,
                                    'success'
                                )
                                location.reload();
                            } else {
                                Swal.fire(
                                    'Failed!',
                                    response.message,
                                    'error'
                                )
                            }
                        }
                    });
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
    @if (session('media.success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Success...',
                text: '{{ session('media.success') }}',
            })
        </script>
    @endif
    @if (session('media.error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: '{{ session('media.error') }}',
            })
        </script>
    @endif
@endpush
