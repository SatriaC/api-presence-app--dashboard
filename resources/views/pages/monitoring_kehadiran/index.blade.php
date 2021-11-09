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
                    @if (Auth::user()->privilege == 3)
                        <form id="filter">
                            <div class="row row-sm">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <p class="mg-b-10">Lokasi</p>
                                        <select class="form-control select2" id="location">
                                            <option value="">Pilih Lokasi</option>
                                            @foreach ($lokasi as $key => $value)
                                                <option value="{{ $value->id }}"
                                                    {{ old('id') == $value->id ? 'selected' : '' }}>
                                                    {{ $value->nama }} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4 mt-4">
                                    <div class="form-group btn btn-list d-inline">
                                        <button type="submit" class="btn ripple btn-primary">Cari &nbsp; <i
                                                class="ti-search"></i></button>
                                        <button class="btn ripple btn-warning d-inline" onclick="reset()">
                                            Refresh&nbsp; <i class="fa fa-refresh"></i> </button>
                                    </div>

                                </div>
                            </div>
                        </form>
                    @elseif (Auth::user()->privilege == 2)
                        <form id="filter">
                            <div class="row row-sm">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <p class="mg-b-10">Lokasi</p>
                                        <select class="form-control select2" id="location">
                                            <option value="">Pilih Lokasi</option>
                                            @foreach ($lokasi as $key => $value)
                                                <option value="{{ $value->id }}"
                                                    {{ old('id') == $value->id ? 'selected' : '' }}>
                                                    {{ $value->nama }} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4 mt-4">
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

                        <form id="filter">
                            <div class="row row-sm">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <p class="mg-b-10">Wilayah</p>
                                        <select class="form-control select2" id="region">
                                            <option value="">Pilih Wilayah</option>
                                            @foreach ($wilayah as $key => $value)
                                                <option value="{{ $value->id }}"
                                                    {{ old('id') == $value->id ? 'selected' : '' }}>
                                                    {{ $value->nama }} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <p class="mg-b-10">Lokasi</p>
                                        <select class="form-control select2" id="location">
                                            <option value="">Pilih Lokasi</option>
                                            @foreach ($lokasi as $key => $value)
                                                <option value="{{ $value->id }}"
                                                    {{ old('id') == $value->id ? 'selected' : '' }}>
                                                    {{ $value->nama }} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <p class="mg-b-10">Tanggal Awal</p>
                                        <input class="form-control" id="tanggal_awal" autocomplete="off" type="text">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <p class="mg-b-10">Tanggal Akhir</p>
                                        <input class="form-control" id="tanggal_akhir" autocomplete="off" type="text">
                                    </div>
                                </div>
                            </div>
                            <div class="row row-sm">
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
                dom: 'lBfrtip',
                processing: true,
                serverSide: true,
                "lengthMenu": [
                    [10, 25, 50, 100, -1],
                    [10, 25, 50, 100, "All"]
                ],
                type: "GET",
                // ordering: true,
                ajax: {
                    url: '{!! url()->current() !!}',
                    data: function(d) {
                        d.location = $('#location').val();
                        d.region = $('#region').val();
                        d.tanggal_awal = $('#tanggal_awal').val();
                        d.tanggal_akhir = $('#tanggal_akhir').val();
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
                        data: 'user.nama',
                        name: 'user.nama'
                    },
                    {
                        data: 'user.location.nama',
                        name: 'user.location.nama'
                    },
                    {
                        data: 'user.region.nama',
                        name: 'user.region.nama'
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
                        data: 'action',
                        name: 'action'
                    },
                ]
            });
            $('#filter').on('submit', function(e) {
                table.draw();
                e.preventDefault();
                table.ajax.reload();
                // perhatiin yang di draw harus sesuai dengan deklarasi variabel yang didatatable di atas, terus ngedeklarasiin variabel nya pake let aja
            });
        });

        function reset() {
            document.getElementById("filter").reset();
        }

        $(document).ready(function() {
            $("#tanggal_awal").datepicker({
                dateFormat: 'yy-mm-dd',
                autoclose: true,
                changeMonth: true,
                changeYear: true,
                yearRange: "-100:+0",
                // viewMode: "months",
                // minViewMode: "months"
            });
            $("#tanggal_akhir").datepicker({
                dateFormat: 'yy-mm-dd',
                autoclose: true,
                changeMonth: true,
                changeYear: true,
                yearRange: "-100:+0",
                // viewMode: "months",
                // minViewMode: "months"
            });
        });

    </script>
@endpush
