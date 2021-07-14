@extends('layouts.admin')
@section('title', 'Monitor Pekerjaan')
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
                                    {{-- <th>Lokasi</th> --}}
                                    <th>Pekerja</th>
                                    <th>Bagian</th>
                                    <th>SoW</th>
                                    <th>Detail SoW</th>
                                    <th>Laporan Pekerjaan</th>
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
        moment.locale('id');
        var datatable = $('#pekerjaanTable').DataTable({
            processing: true,
            serverSide: true,
            ordering: true,
            ajax: {
                url: '{!! url()->current() !!}',
            },
            columns: [{
                    data: "id",
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    data: 'created_at',
                    name: 'created_at'
                },
                // {
                //     data: 'locations',
                //     name: 'locations'
                // },
                {
                    data: 'user.name',
                    name: 'user.name'
                },
                {
                    data: 'user.division.name',
                    name: 'user.division.name'
                },
                {
                    data: 'detail.sow.name',
                    name: 'detail.sow.name'
                },
                {
                    data: 'detail.name',
                    name: 'detail.name'
                },
                {
                    data: 'report',
                    name: 'report'
                },
                {
                    data: 'photos_before',
                    name: 'photos_before'
                },
                {
                    data: 'photos_after',
                    name: 'photos_after'
                },
                {
                    data: 'flag',
                    name: 'flag'
                },
                {
                    data: 'reason_rejected',
                    name: 'reason_rejected'
                },
                {
                    data: 'action',
                    name: 'action'
                },
            ]
        });
    });

</script>
@endpush
