@extends('layouts.admin')
@section('title', 'Edit Data Sow')
@section('content')
    <!-- Page Header -->
    <div class="page-header">
        <div>
            <h2 class="main-content-title tx-24 mg-b-5">Edit Data Sow</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">BM</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit Data Sow</li>
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
                    <form action="{{ route('sow.update', $item->id) }}" method="post" enctype="multipart/form-data">
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
                        <div class="col-12 mt-2">
                            <label for="">Bagian</label>
                            <select class="form-control select2" name="id_bagian">
                                <option label="Pilih Bagian"></option>
                                @foreach ($divisions as $value)
                                    <option value="{{ $value->id }}"
                                    {{$item->id_bagian==$value->id ? 'selected' : ''}}>
                                    {{$value->nama}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12 mt-2 mb-3">
                            <label>Icon</label>
                            @foreach ($ikons as $value)
                            <label class="rdiobox"><input name="ikon" value="{{ $value->ikon }}" {{$value->ikon == $item->ikon ? 'checked' : ''}} type="radio"><span> <img src="{{ Storage::url($value->ikon) }}" style="max-height: 40px;" /></span></label>
                            @endforeach
                        </div>
                        <button class="btn ripple btn-primary" type="submit"
                            onclick="return confirm('Apakah anda yakin akan mengedit data ?')">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
