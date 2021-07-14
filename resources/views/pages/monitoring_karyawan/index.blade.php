@extends('layouts.admin')
@section('title', 'Monitor Karyawan')
@section('content')
    <!-- Page Header -->
    <div class="page-header">
        <div>
            <h2 class="main-content-title tx-24 mg-b-5">Monitor Karyawan</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">BM</a></li>
                <li class="breadcrumb-item active" aria-current="page">Monitor Karyawan</li>
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
                    <div>
                        <a href="#" class="btn btn-warning float-right"
                        data-target="#modaldemo3" data-toggle="modal">Tambah</a>
                        <!-- Large Modal -->
                        <div class="modal fade show in" id="modaldemo3">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content modal-content-demo">
                                    <div class="modal-header">
                                        <h6 class="modal-title">Tambah Data SOW</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                                    </div>
                                    <form action="{{ route('karyawan.store') }}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="col-12">
                                            <label for="name">Nama</label>
                                            <input
                                                class="form-control tanggalan @error('name') is-invalid @enderror"
                                                name="name"
                                                value="{{ old('name') }}" type="text">
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-12 mt-2">
                                            <label for="">Email</label>
                                            <input
                                                class="form-control tanggalan @error('email') is-invalid @enderror"
                                                name="email"
                                                value="{{ old('email') }}" type="email">
                                            @error('email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-12 mt-2">
                                            <label for="">Wilayah</label>
                                            <select class="form-control select2" id="region"  name="regions_id">
                                                <option label="Pilih WIlayah"></option>
                                                @foreach ($regions as $value)
                                                    <option value="{{$value->id}}"
                                                    {{old('regions_id')==$value->id ? 'selected' : ''}}>
                                                    {{$value->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-12 mt-2">
                                            <label for="">Lokasi</label>
                                            <select class="form-control select2" id="location"  name="locations_id">
                                                <option label="Pilih Lokasi"></option>
                                            </select>
                                        </div>
                                        <div class="col-12 mt-2">
                                            <label for="">Divisi</label>
                                            <select class="form-control select2"  name="divisions_id">
                                                <option label="Pilih Divisi"></option>
                                                @foreach ($divisions as $value)
                                                    <option value="{{$value->id}}"
                                                    {{old('divisions_id')==$value->id ? 'selected' : ''}}>
                                                    {{$value->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-12 mt-2">
                                            <label for="">Privilege</label>
                                            <select class="form-control select2"  name="privileges_id">
                                                <option label="Pilih WIlayah"></option>
                                                @foreach ($privileges as $value)
                                                    <option value="{{$value->id}}"
                                                    {{old('privileges_id')==$value->id ? 'selected' : ''}}>
                                                    {{$value->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button class="btn ripple btn-primary" type="submit"
                                            onclick="return confirm('Apakah anda yakin dengan data yang diinputkan ?')">Submit</button>
                                    </form>
                                        <button class="btn ripple btn-secondary" data-dismiss="modal" type="button">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--End Large Modal -->
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive border">
                        <table id="userTable" class="table text-nowrap text-md-nowrap table-hover mg-b-0">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Wilayah</th>
                                    <th>Lokasi</th>
                                    <th>Bagian</th>
                                    <th>Privilege</th>
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
        var datatable = $('#userTable').DataTable({
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
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'email',
                    name: 'email'
                },
                {
                    data: 'region.name',
                    name: 'region.name'
                },
                {
                    data: 'location.name',
                    name: 'location.name'
                },
                {
                    data: 'division.name',
                    name: 'division.name'
                },
                {
                    data: 'privilege.name',
                    name: 'privilege.name'
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
    });

</script>


<script>
    jQuery(document).ready(function ()
    {
        jQuery('#region').on('change',function(){
            const _url = "{{ route('api-locations') }}";
            $.ajax({
                dataType: "json",
                url : _url,
                type: "GET",
                data: {
                    regions_id : $(this).val(),
                },
                success: function (html){
                    $('#location').empty();
                    $('#location').append('<option value="">Pilih Lokasi</option>');
                    $.each(html.data, function (key, item){
                        $('#location').append('<option value="'+item.id+'">'+item.name+'</option>')
                    });
                },
                error: function (xhr){
                    console.log(xhr);
                }
            })

        });
    });
</script>
@endpush
