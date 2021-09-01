@extends('layouts.admin')
@section('title', 'Monitor Pekerjaan')
    @push('custom-style')

    @endpush
@section('content')
    <!-- Page Header -->
    <div class="page-header">
        <div>
            <h2 class="main-content-title tx-24 mg-b-5">Monitor Pekerjaan</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">BM</a></li>
                <li class="breadcrumb-item active" aria-current="page">Monitor Pekerjaan</li>
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
                    <form id="filter">
                        @if (Auth::user()->privilege == 1)
                        <div class="row row-sm">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <p class="mg-b-10">SoW</p>
                                    <select class="form-control select2" name="id_sow" id="id_sow">
                                        <option value="">Pilih SoW</option>
                                        @foreach ($sow as $key => $value)
                                            <option value="{{ $value->id }}"
                                                {{ old('id') == $value->id ? 'selected' : '' }}>
                                                {{ $value->nama }} </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <p class="mg-b-10">Wilayah</p>
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
                            <div class="col-md-3">
                                <div class="form-group">
                                    <p class="mg-b-10">Lokasi</p>
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
                            <div class="col-md-3 mt-4">
                                <div class="form-group btn btn-list d-inline">
                                    <button type="submit" class="btn ripple btn-primary">Cari &nbsp; <i
                                            class="ti-search"></i></button>
                                    <button class="btn ripple btn-warning d-inline" onclick="reset()">
                                        Refresh&nbsp; <i class="fa fa-refresh"></i> </button>
                                </div>

                            </div>
                        </div>

                        @else
                        <div class="row row-sm">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <p class="mg-b-10">SoW</p>
                                    <select class="form-control select2" name="id_sow" id="id_sow">
                                        <option>Pilih SoW</option>
                                        @foreach ($sow as $key => $value)
                                            <option value="{{ $value->id }}"
                                                {{ old('id') == $value->id ? 'selected' : '' }}>
                                                {{ $value->nama }} </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <p class="mg-b-10">Lokasi</p>
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
                        @endif
                    </form>
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
                        <table id="pekerjaanTable" class="table text-nowrap text-md-nowrap table-hover mg-b-0">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Tanggal</th>
                                    <th>Lokasi</th>
                                    <th>Pekerja</th>
                                    <th>Bagian</th>
                                    <th>SoW</th>
                                    <th>Kategori SoW</th>
                                    <th>Detail SoW</th>
                                    <th>Foto Sebelum</th>
                                    <th>Foto Sesudah</th>
                                    <th>Approval</th>
                                    <th>Keterangan</th>
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
            // console.log($("#sow").val().'ASASW');
            moment.locale('id');
            var table = $('#pekerjaanTable').DataTable({
                dom: 'lBfrtip',
                processing: true,
                // searching: true,
                serverSide: true,
                "lengthMenu": [ [10, 25, 50, 100, -1], [10, 25, 50, 100, "All"] ],
                type:"GET",
                ajax: {
                    url: '{!! url()->current() !!}',
                    data: function(d) {
                        d.id_sow = $("#id_sow").val();
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
                        data: 'reported_at',
                        name: 'reported_at'
                    },
                    {
                        data: 'lokasi',
                        name: 'lokasi'
                    },
                    {
                        data: 'user.nama',
                        name: 'user.nama'
                    },
                    {
                        data: 'user.division.nama',
                        name: 'user.division.nama'
                    },
                    {
                        data: 'detail.category.sow.nama',
                        name: 'detail.category.sow.nama'
                    },
                    {
                        data: 'detail.category.nama',
                        name: 'detail.category.nama'
                    },
                    {
                        data: 'detail.nama',
                        name: 'detail.nama'
                    },
                    {
                        data: 'foto_before',
                        name: 'foto_before'
                    },
                    {
                        data: 'foto_after',
                        name: 'foto_after'
                    },
                    {
                        data: 'flag',
                        name: 'flag'
                    },
                    {
                        data: 'alasan_reject',
                        name: 'alasan_reject'
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

    </script>
@endpush
