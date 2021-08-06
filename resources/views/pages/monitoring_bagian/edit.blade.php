@extends('layouts.admin')
@section('title', 'Edit Data Bagian')
@section('content')
    <!-- Page Header -->
    <div class="page-header">
        <div>
            <h2 class="main-content-title tx-24 mg-b-5">Edit Data Bagian</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">BM</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit Data Bagian</li>
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
                    <form action="{{ route('bagian.update', $item->id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="col-12">
                            <label for="nama">Nama</label>
                            <input class="form-control tanggalan @error('nama') is-invalid @enderror" name="nama"
                                value="{{ $item->nama }}" type="text">
                            @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-12">
                            <label for="nama">Status</label>
                            <select class="form-control"  name="flag" required>
                                <option label="Pilih Status"></option>
                                <option value="1" {{$item->flag==1 ? 'selected' : ''}}>Aktif</option>
                                <option value="2" {{$item->flag==2 ? 'selected' : ''}}>Tidak Aktif</option>
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
