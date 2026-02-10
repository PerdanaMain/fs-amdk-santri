@extends('layouts.dashboard.index')

@section('title')
    Profile
@endsection

@section('content.dashboard')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Profile setting</h4>
                        <p class="card-description">
                            Change your profile settings
                        </p>
                        <form class="forms-sample" action="{{ route('profile.update', ['id' => $user->user_id]) }}"
                            enctype="multipart/form-data" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-group row">
                                <label for="exampleInputProfileImage" class="col-sm-3 col-form-label">Profile Image</label>
                                <div class="col-sm-9">
                                    @if ($user->user_photo)
                                        <img src="{{ asset('storage/profiles/' . $user->user_photo) }}" alt="Profile Image"
                                            class="img-fluid" style="width:100px;">
                                        <input type="file" class="form-control" id="exampleInputProfileImage"
                                            name="user_photo">
                                    @else
                                        <input type="file" class="form-control" id="exampleInputProfileImage"
                                            name="user_photo">
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="exampleInputName" class="col-sm-3 col-form-label">NIP </label>
                                <div class="col-sm-9">
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="exampleInputName" name="user_nip"
                                            value="{{ $user->user_nip }}" placeholder="Masukkan NIP">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="exampleInputName" class="col-sm-3 col-form-label">NIK <span
                                        style="color: red;">*</span></label>
                                <div class="col-sm-9">
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="exampleInputName" name="user_nik"
                                            value="{{ $user->user_nik }}" placeholder="Masukkan NIK">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="exampleInputName" class="col-sm-3 col-form-label">Nama Lengkap <span
                                        style="color: red;">*</span></label>
                                <div class="col-sm-9">
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="exampleInputName" name="user_name"
                                            value="{{ $user->user_name }}" placeholder="Masukkan Nama">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="exampleInputPhone" class="col-sm-3 col-form-label">No Telpon <span
                                        style="color: red;">*</span></label>
                                <div class="col-sm-9">
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="exampleInputPhone" name="user_phone"
                                            value="{{ $user->user_phone }}" placeholder="Masukkan Nomor Telpon">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="exampleInputPhone" class="col-sm-3 col-form-label">Alamat Lengkap <span
                                        style="color: red;">*</span> </label>
                                <div class="col-sm-9">
                                    <div class="input-group">
                                        <textarea name="user_address" class="form-control" cols="30" rows="10">{{ $user->user_address }}
                                        </textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="exampleInputPhone" class="col-sm-3 col-form-label">New Password</label>
                                <div class="col-sm-9">
                                    <div class="input-group">
                                        <input type="password" class="form-control" id="exampleInputPhone"
                                            name="user_password" placeholder="Masukkan Password Baru">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="exampleInputPhone" class="col-sm-3 col-form-label">Confirm New Password</label>
                                <div class="col-sm-9">
                                    <div class="input-group">
                                        <input type="password" class="form-control" id="exampleInputPhone"
                                            name="user_conf_password" placeholder="Masukkan Konfirmasi Password Baru">
                                    </div>
                                </div>
                            </div>

                            <div class="d-block">
                                <button type="submit" class="btn btn-primary me-2">Submit</button>
                                <a class="btn btn-light" href="/dashboard">Back</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('dashboard.script')
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
    @if (session('profile.success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Success...',
                text: '{{ session('profile.success') }}',
            })
        </script>
    @endif
    @if (session('profile.error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: '{{ session('profile.error') }}',
            })
        </script>
    @endif
@endpush
