@extends('base.base-admin-index')
@section('content')

<section class="section">
    <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row">

        <div class="col-lg-4 col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">Edit Foto Profile</h4>
                    <button type="submit" class="btn btn-outline-primary">
                        <i class="fa-solid fa-paper-plane"></i>
                    </button>
                </div>
                <div class="card-body">
                    <img src="{{ asset('storage/images/profile/' . Auth::user()->photo) }}"
                         class="card-img-top" alt="Foto Profile">
                    <label for="photo" class="mt-3">Upload Photo Profile</label>
                    <input type="file" name="photo" id="photo" class="form-control" accept="image/*">
                    @error('photo') <small class="text-danger">{{ $message }}</small> @enderror
                </div>
            </div>
        </div>

        <div class="col-lg-8 col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">Edit Identitas Admin</h4>
                    <button type="submit" class="btn btn-outline-primary">
                        <i class="fa-solid fa-paper-plane"></i>
                    </button>
                </div>
                <div class="row card-body">
                    <div class="form-group col-lg-6 col-12">
                        <label for="name">Nama Lengkap</label>
                        <input type="text" class="form-control" name="name" id="name"
                               placeholder="Inputkan nama kamu..."
                               value="{{ Auth::user()->name }}">
                        @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div class="form-group col-lg-6 col-12">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" name="username" id="username"
                               placeholder="Inputkan username kamu..."
                               value="{{ Auth::user()->username }}">
                        @error('username') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div class="form-group col-lg-6 col-12">
                        <label for="phone">Nomor Handphone (WhatsApp)</label>
                        <input type="text" class="form-control" name="phone" id="phone"
                               placeholder="Inputkan nomor handphone kamu..."
                               value="{{ Auth::user()->phone }}">
                        @error('phone') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div class="form-group col-lg-6 col-12">
                        <label for="email">Alamat Email</label>
                        <input type="text" class="form-control" name="email" id="email"
                               placeholder="Inputkan email kamu..."
                               value="{{ Auth::user()->email }}">
                        @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>
            </div>
        </div>

    </div>
    </form>
</section>

@endsection

@section('custom-js')
<script>
    document.getElementById("photo").onchange = function(event) {
        var reader = new FileReader();
        reader.onload = function() {
            document.querySelector('.card-img-top').src = reader.result;
        };
        reader.readAsDataURL(event.target.files[0]);
    };
</script>
@endsection