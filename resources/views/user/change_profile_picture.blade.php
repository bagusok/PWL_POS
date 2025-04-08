@extends('layouts.template')
@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">Foto Profile</h3>
            <div class="card-tools">
            </div>
        </div>

        <div class="card-body">

            @if ($user->profile_picture)
                <div class="text-center mb-3">
                    <img src="{{ asset('images/profile/' . $user->profile_picture) }}" alt="Profile Picture"
                        class="img-fluid rounded-circle" style="width: 150px; height: 150px;">
                </div>
            @else
                <div class="text-center mb-3">
                    <p>Belum ada foto profile</p>
                </div>
            @endif

        </div>


        @if (session('success'))
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: '{{ session('success') }}',
                    confirmButtonText: 'OK'
                });
            </script>
        @elseif (session('error'))
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: '{{ session('error') }}',
                    confirmButtonText: 'OK'
                });
            </script>
        @endif




    </div>

    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">Upload / Ganti Foto Profile</h3>
            <div class="card-tools">
            </div>
        </div>

        <div class="card-body">

            <form action="change-profile-picture/update" method="post" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="foto">Upload Foto</label>
                    <input type="file" name="profile_picture" id="profile_picture" class="form-control" accept="image/*">
                </div>

                <button class="btn btn-primary" type="submit">Upload</button>

            </form>

        </div>





    </div>
@endsection
@push('css')
@endpush
@push('js')
    <script>
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Sukses',
                text: '{{ session('success') }}',
                confirmButtonText: 'OK'
            });
        @endif


        @if (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: '{{ session('error') }}',
                confirmButtonText: 'OK'
            });
        @endif

        // SweetAlert untuk error validasi
        @if ($errors->any())
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: '{{ $errors->first() }}',
                confirmButtonText: 'OK'
            });
        @endif
    </script>
@endpush
