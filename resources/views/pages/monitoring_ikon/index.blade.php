@extends('layouts.admin')
@section('title', 'Monitor Ikon')
@section('content')
    <!-- Page Header -->
    <div class="page-header">
        <div>
            <h2 class="main-content-title tx-24 mg-b-5">Monitor Ikon</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">BM</a></li>
                <li class="breadcrumb-item active" aria-current="page">Monitor Ikon</li>
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
                        @if (Auth::user()->privilege == 1)
                        <a href="#" class="btn btn-warning float-right"
                        data-target="#modaldemo3" data-toggle="modal">Tambah</a>
                        @endif
                        <!-- Large Modal -->
                        <div class="modal fade show in" id="modaldemo3">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content modal-content-demo">
                                    <div class="modal-header">
                                        <h6 class="modal-title">Tambah Data Ikon</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                                    </div>
                                    <form action="{{ route('ikon.store') }}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="col-12 mt-2">
                                            <label>Icon</label>
                                            <input type="file" name="ikon" class="form-control @error('ikon') is-invalid @enderror" value="{{ old('ikon') }}"  required>
                                            @error('ikon')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
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
                        <table id="ikonTable" class="table text-nowrap text-md-nowrap table-hover mg-b-0">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Ikon</th>
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
        var datatable = $('#ikonTable').DataTable({
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
                    data: 'ikon',
                    name: 'ikon'
                },
                {
                    data: 'status',
                    name: 'status'
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
