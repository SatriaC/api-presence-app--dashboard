@extends('layouts.admin')
@section('title', 'Edit Data Karyawan')
@section('content')
    <!-- Page Header -->
    <div class="page-header">
        <div>
            <h2 class="main-content-title tx-24 mg-b-5">Edit Data Karyawan</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">BM</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit Data Karyawan</li>
            </ol>
        </div>
        <div class="d-flex">

        </div>
    </div>
    <!-- End Page Header -->
    @if ($errors->any())
        <div class="alert alert-danger mg-b-0" role="alert">
            <ul>
                @foreach ($errors->all() as $error)
                    <button aria-label="Close" class="close" data-dismiss="alert" type="button">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="row row-sm">
        <div class="col-sm-12 col-md-12 col-lg-12">
            <div class="card custom-card">
                <div class="card-header">
                    <div>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('karyawan.update', $user->id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="col-12">
                            <label for="nama">Nama</label>
                            <input class="form-control tanggalan @error('nama') is-invalid @enderror" name="nama"
                                value="{{ $user->nama }}" type="text">
                            @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-12 mt-2">
                            <label for="">Email</label>
                            <input class="form-control tanggalan @error('email') is-invalid @enderror" name="email"
                                value="{{ $user->email }}" type="email">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-12 mt-2">
                            <label for="">Wilayah</label>
                            <select class="form-control select2" id="region" name="id_wilayah">
                                <option label="Pilih WIlayah"></option>
                                @foreach ($regions as $value)
                                    <option value="{{ $value->id }}"
                                        {{ $user->id_wilayah == $value->id ? 'selected' : '' }}>
                                        {{ $value->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12 mt-2">
                            <label for="">Lokasi</label>
                            <select class="form-control select2" id="location" name="id_lokasi">
                                <option label="Pilih Lokasi"></option>
                            </select>
                        </div>
                        <div class="col-12 mt-2">
                            <label for="">Divisi</label>
                            <select class="form-control select2" name="id_bagian">
                                <option label="Pilih Divisi"></option>
                                @foreach ($divisions as $value)
                                    <option value="{{ $value->id }}"
                                    {{$user->id_bagian==$value->id ? 'selected' : ''}}>
                                    {{$value->nama}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12 mt-2">
                            <label for="">Privilege</label>
                            <select class="form-control select2" name="privilege">
                                <option label="Pilih WIlayah"></option>
                                @foreach ($privileges as $value)
                                    <option value="{{ $value->id }}"
                                        {{ $user->privilege == $value->id ? 'selected' : '' }}>
                                        {{ $value->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12">
                            <label for="nama">Status</label>
                            <select class="form-control"  name="flag" required>
                                <option label="Pilih Status"></option>
                                <option value="1" {{$user->flag==1 ? 'selected' : ''}}>Aktif</option>
                                <option value="2" {{$user->flag==2 ? 'selected' : ''}}>Tidak Aktif</option>
                            </select>
                        </div>
                        <button class="btn ripple btn-primary" type="submit"
                            onclick="return confirm('Apakah anda yakin akan mengedit data ?')">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('custom-script')

    <script>
        jQuery(document).ready(function() {
            jQuery('#region').on('change', function() {
                const _url = "{{ route('api-locations') }}";
                $.ajax({
                    dataType: "json",
                    url: _url,
                    type: "GET",
                    data: {
                        regions_id: $(this).val(),
                    },
                    success: function(html) {
                        $('#location').empty();
                        $('#location').append('<option value="">Pilih Lokasi</option>');
                        $.each(html.data, function(key, item) {
                            $('#location').append('<option value="' + item.id + '">' +
                                item.nama + '</option>')
                        });
                    },
                    error: function(xhr) {
                        console.log(xhr);
                    }
                })

            });
        });

    </script>
@endpush
