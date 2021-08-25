@extends('layouts.admin')
@section('title', 'Monitor Kehadiran')
@section('content')
    <!-- Page Header -->
    <div class="page-header">
        <div>
            <h2 class="main-content-title tx-24 mg-b-5">Monitor Kehadiran</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">BM</a></li>
                <li class="breadcrumb-item active" aria-current="page">Monitor Kehadiran</li>
            </ol>
        </div>
        <div class="d-flex">

        </div>
    </div>
    <!-- End Page Header -->
    @if (session('success'))
        <div class="alert alert-success" role="alert">
            <button aria-label="Close" class="close" data-dismiss="alert" type="button">
                <span aria-hidden="true">&times;</span>
            </button>
            {{ session('success') }}
        </div>
    @endif
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
        <div class="col-lg-12 col-md-12">
            <div class="card custom-card">
                <div class="card-body">
                    @if (Auth::user()->privilege == 1)

                        <form id="search">
                            <div class="row row-sm">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <select class="form-control select2" name="id_wilayah" id="id_wilayah">
                                            <option value="">Pilih Wilayah</option>
                                            @foreach ($wilayah as $key => $value)
                                                <option value="{{ $value->id }}"
                                                    {{ old('id') == $value->id ? 'selected' : '' }}>
                                                    {{ $value->nama }} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <select class="form-control select2" name="id_lokasi" id="id_lokasi">
                                            <option value="">Pilih Lokasi</option>
                                            @foreach ($lokasi as $key => $value)
                                                <option value="{{ $value->id }}"
                                                    {{ old('id') == $value->id ? 'selected' : '' }}>
                                                    {{ $value->nama }} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group btn btn-list d-inline">
                                        <button type="submit" class="btn ripple btn-primary">Cari &nbsp; <i
                                                class="ti-search"></i></button>
                                        <button class="btn ripple btn-warning d-inline" onclick="reset()">
                                            Refresh&nbsp; <i class="fa fa-refresh"></i> </button>
                                    </div>

                                </div>
                            </div>
                        </form>
                    @else
                        <form id="search">
                            <div class="row row-sm">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <select class="form-control select2" name="id_lokasi" id="id_lokasi">
                                            <option>Pilih Lokasi</option>
                                            @foreach ($lokasi as $key => $value)
                                                <option value="{{ $value->id }}"
                                                    {{ old('id') == $value->id ? 'selected' : '' }}>
                                                    {{ $value->nama }} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group btn btn-list d-inline">
                                        <button type="submit" class="btn ripple btn-primary">Cari &nbsp; <i
                                                class="ti-search"></i></button>
                                        <button class="btn ripple btn-warning d-inline" onclick="reset()">
                                            Refresh&nbsp; <i class="fa fa-refresh"></i> </button>
                                    </div>

                                </div>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="row row-sm">
        <div class="col-sm-12 col-md-12 col-lg-12">
            <div class="card custom-card">
                <div class="card-header">

                </div>
                <div class="card-body">
                    <div class="table-responsive border">
                        <table id="kehadiranTable" class="table text-nowrap text-md-nowrap table-hover mg-b-0">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Jam Masuk</th>
                                    <th>Jam Pulang</th>
                                    <th>Lokasi Masuk</th>
                                    <th>Lokasi Pulang</th>
                                    <th>Pekerja</th>
                                    <th>Lokasi Kerja</th>
                                    <th>Wilayah Kerja</th>
                                    <th>Foto Masuk</th>
                                    <th>Foto Pulang</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('custom-script')

    <script>
        $(function() {
            moment.locale('id');
            var table = $('#kehadiranTable').DataTable({
                processing: true,
                serverSide: true,
                type: "GET",
                // ordering: true,
                ajax: {
                    url: '{!! url()->current() !!}',
                    data: function(d) {
                        d.id_lokasi = $('#id_lokasi').val();
                        d.id_wilayah = $('#id_wilayah').val();
                    }
                },
                columns: [{
                        data: "id",
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
                        data: 'jam_masuk',
                        name: 'jam_masuk'
                    },
                    {
                        data: 'jam_pulang',
                        name: 'jam_pulang'
                    },
                    {
                        data: 'lokasi_masuk',
                        name: 'lokasi_masuk'
                    },
                    {
                        data: 'lokasi_pulang',
                        name: 'lokasi_pulang'
                    },
                    {
                        data: 'nama',
                        name: 'nama'
                    },
                    {
                        data: 'lokasi_kerja',
                        name: 'lokasi_kerja'
                    },
                    {
                        data: 'wilayah_kerja',
                        name: 'wilayah_kerja'
                    },
                    {
                        data: 'foto_masuk',
                        name: 'foto_masuk'
                    },
                    {
                        data: 'foto_pulang',
                        name: 'foto_pulang'
                    },
                    {
                        data: 'flag',
                        name: 'flag'
                    },
                    {
                        data: 'action',
                        name: 'action'
                    },
                ]
            });
            $('#search').on('submit', function(e) {
                table.draw();
                e.preventDefault();
                table.ajax.reload();
                // perhatiin yang di draw harus sesuai dengan deklarasi variabel yang didatatable di atas, terus ngedeklarasiin variabel nya pake let aja
            });
        });

        function reset() {
            document.getElementById("search").reset();
        }

    </script>
@endpush
