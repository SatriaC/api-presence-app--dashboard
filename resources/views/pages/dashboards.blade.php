@extends('layouts.admin')
@section('title', 'Dashboard')
    @push('custom-style')
        <style>
            #container1 {
                height: 500px;
            }

            .highcharts-figure,
            .highcharts-data-table table {
                min-width: 320px;
                max-width: 700px;
                margin: 1em auto;
            }

            .highcharts-data-table table {
                font-family: Verdana, sans-serif;
                border-collapse: collapse;
                border: 1px solid #EBEBEB;
                margin: 10px auto;
                text-align: center;
                width: 100%;
                max-width: 500px;
            }

            .highcharts-data-table caption {
                padding: 1em 0;
                font-size: 1.2em;
                color: #555;
            }

            .highcharts-data-table th {
                font-weight: 600;
                padding: 0.5em;
            }

            .highcharts-data-table td,
            .highcharts-data-table th,
            .highcharts-data-table caption {
                padding: 0.5em;
            }

            .highcharts-data-table thead tr,
            .highcharts-data-table tr:nth-child(even) {
                background: #f8f8f8;
            }

            .highcharts-data-table tr:hover {
                background: #f1f7ff;
            }

        </style>
    @endpush
@section('content')
    <!-- Page Header -->
    <div class="page-header">
        <div>
            <h2 class="main-content-title tx-24 mg-b-5">Dashboard</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">BM</a></li>
                <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
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

    <!--Row-->
    <div class="row row-sm">
        <div class="col-sm-12 col-lg-12 col-xl-12">
            <!--Row-->
            <div class="row row-sm">
                <div class="col-sm-12 col-md-6 col-lg-6 col-xl-4">
                    <div class="card custom-card">
                        <div class="card-body">
                            <div class="card-item">
                                <div class="card-item-icon card-icon">
                                    <svg class="text-primary" xmlns="http://www.w3.org/2000/svg"
                                        enable-background="new 0 0 24 24" height="24" viewBox="0 0 24 24" width="24">
                                        <g>
                                            <rect height="14" opacity=".3" width="14" x="5" y="5" />
                                            <g>
                                                <rect fill="none" height="24" width="24" />
                                                <g>
                                                    <path
                                                        d="M19,3H5C3.9,3,3,3.9,3,5v14c0,1.1,0.9,2,2,2h14c1.1,0,2-0.9,2-2V5C21,3.9,20.1,3,19,3z M19,19H5V5h14V19z" />
                                                    <rect height="5" width="2" x="7" y="12" />
                                                    <rect height="10" width="2" x="15" y="7" />
                                                    <rect height="3" width="2" x="11" y="14" />
                                                    <rect height="2" width="2" x="11" y="10" />
                                                </g>
                                            </g>
                                        </g>
                                    </svg>
                                </div>
                                <div class="card-item-title mb-2">
                                    <label class="main-content-label tx-13 font-weight-bold mb-1">Total Pekerjaan
                                    </label>
                                    {{-- <span class="d-block tx-12 mb-0 text-muted">Previous month vs this months</span> --}}
                                </div>
                                <div class="card-item-body">
                                    <div class="card-item-stat">
                                        <h2 class="font-weight-bold">{{ $pekerjaan }}</h2>
                                        {{-- <small><b class="text-success">55%</b> higher</small> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-6 col-xl-4">
                    <div class="card custom-card">
                        <div class="card-body">
                            <div class="card-item">
                                <div class="card-item-icon card-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24">
                                        <path d="M0 0h24v24H0V0z" fill="none" />
                                        <path
                                            d="M12 4c-4.41 0-8 3.59-8 8 0 1.82.62 3.49 1.64 4.83 1.43-1.74 4.9-2.33 6.36-2.33s4.93.59 6.36 2.33C19.38 15.49 20 13.82 20 12c0-4.41-3.59-8-8-8zm0 9c-1.94 0-3.5-1.56-3.5-3.5S10.06 6 12 6s3.5 1.56 3.5 3.5S13.94 13 12 13z"
                                            opacity=".3" />
                                        <path
                                            d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zM7.07 18.28c.43-.9 3.05-1.78 4.93-1.78s4.51.88 4.93 1.78C15.57 19.36 13.86 20 12 20s-3.57-.64-4.93-1.72zm11.29-1.45c-1.43-1.74-4.9-2.33-6.36-2.33s-4.93.59-6.36 2.33C4.62 15.49 4 13.82 4 12c0-4.41 3.59-8 8-8s8 3.59 8 8c0 1.82-.62 3.49-1.64 4.83zM12 6c-1.94 0-3.5 1.56-3.5 3.5S10.06 13 12 13s3.5-1.56 3.5-3.5S13.94 6 12 6zm0 5c-.83 0-1.5-.67-1.5-1.5S11.17 8 12 8s1.5.67 1.5 1.5S12.83 11 12 11z" />
                                    </svg>
                                </div>
                                <div class="card-item-title mb-2">
                                    <label class="main-content-label tx-13 font-weight-bold mb-1">Total Karyawan
                                    </label>
                                    {{-- <span class="d-block tx-12 mb-0 text-muted">Employees joined this month</span> --}}
                                </div>
                                <div class="card-item-body">
                                    <div class="card-item-stat">
                                        <h2 class="font-weight-bold">{{ $karyawan }}</h2>
                                        {{-- <small><b class="text-success">5%</b> Increased</small> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-6 col-xl-4">
                    <div class="card custom-card">
                        <div class="card-body">
                            <div class="card-item">
                                <div class="card-item-icon card-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24">
                                        <path d="M0 0h24v24H0V0z" fill="none" />
                                        <path
                                            d="M12 4c-4.41 0-8 3.59-8 8 0 1.82.62 3.49 1.64 4.83 1.43-1.74 4.9-2.33 6.36-2.33s4.93.59 6.36 2.33C19.38 15.49 20 13.82 20 12c0-4.41-3.59-8-8-8zm0 9c-1.94 0-3.5-1.56-3.5-3.5S10.06 6 12 6s3.5 1.56 3.5 3.5S13.94 13 12 13z"
                                            opacity=".3" />
                                        <path
                                            d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zM7.07 18.28c.43-.9 3.05-1.78 4.93-1.78s4.51.88 4.93 1.78C15.57 19.36 13.86 20 12 20s-3.57-.64-4.93-1.72zm11.29-1.45c-1.43-1.74-4.9-2.33-6.36-2.33s-4.93.59-6.36 2.33C4.62 15.49 4 13.82 4 12c0-4.41 3.59-8 8-8s8 3.59 8 8c0 1.82-.62 3.49-1.64 4.83zM12 6c-1.94 0-3.5 1.56-3.5 3.5S10.06 13 12 13s3.5-1.56 3.5-3.5S13.94 6 12 6zm0 5c-.83 0-1.5-.67-1.5-1.5S11.17 8 12 8s1.5.67 1.5 1.5S12.83 11 12 11z" />
                                    </svg>
                                </div>
                                <div class="card-item-title mb-2">
                                    <label class="main-content-label tx-13 font-weight-bold mb-1">Total SoW
                                    </label>
                                    {{-- <span class="d-block tx-12 mb-0 text-muted">Employees joined this month</span> --}}
                                </div>
                                <div class="card-item-body">
                                    <div class="card-item-stat">
                                        <h2 class="font-weight-bold">{{ $sow }}</h2>
                                        {{-- <small><b class="text-success">5%</b> Increased</small> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <!--End row-->


            <div class="row row-sm">
                <div class="col-lg-12 col-md-12">
                    <div class="card custom-card">
                        <div class="card-body">
                            <form action="{{ route('dashboard') }}" method="GET">
                                <div class="row row-sm">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            {{-- <p class="mg-b-10">SoW</p> --}}
                                            <select class="form-control select2" name="id_wilayah" id="id_wilayah">
                                                <option value="0" label="">Pilih Wilayah</option>
                                                @foreach ($wilayah as $key => $value)
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
                                            {{-- <button class="btn ripple btn-warning d-inline" onclick="reset()">
                                                Refresh&nbsp; <i class="fa fa-refresh"></i> </button> --}}
                                        </div>

                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!--row-->
            <div class="row row-sm">
                <div class="col-sm-6 col-lg-6 col-xl-6">
                    <div class="card custom-card overflow-hidden">
                        <div class="card-header border-bottom-0">
                            <div>
                                <label class="main-content-label mb-2">Chart Document</label>
                                {{-- <span class="d-block tx-12 mb-0 text-muted">The Project Budget is a tool used by project
                                    managers to estimate the total cost of a project</span> --}}
                            </div>
                        </div>
                        <div class="card-body">
                            <figure class="highcharts-figure">
                                <div id="container"></div>
                            </figure>
                        </div>
                    </div>
                </div><!-- col end -->
                <div class="col-sm-6 col-lg-6 col-xl-6">
                    <div class="card custom-card overflow-hidden">
                        <div class="card-header border-bottom-0">
                            <div>
                                <label class="main-content-label mb-2">Pie Chart</label>
                                {{-- <span class="d-block tx-12 mb-0 text-muted">The Project Budget is a tool used by project
                                    managers to estimate the total cost of a project</span> --}}
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="cart-item">

                                <figure class="highcharts-figure">
                                    <div id="container1"></div>
                                    {{-- <p class="highcharts-description">
                                    </p> --}}
                                </figure>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Row end -->
        </div>
        <!-- col end -->


        <!-- col end -->
    </div><!-- Row end -->


@endsection
@push('custom-script')
    <style>
        .highcharts-figure,
        .highcharts-data-table table {
            min-width: 400px;
            max-width: 700px;
            margin: 1em auto;
        }

        #container {
            height: auto;
        }

        .highcharts-data-table table {
            font-family: Verdana, sans-serif;
            border-collapse: collapse;
            border: 1px solid #EBEBEB;
            margin: 10px auto;
            text-align: center;
            width: 100%;
            max-width: 500px;
        }

        .highcharts-data-table caption {
            padding: 1em 0;
            font-size: 1.2em;
            color: #555;
        }

        .highcharts-data-table th {
            font-weight: 600;
            padding: 0.5em;
        }

        .highcharts-data-table td,
        .highcharts-data-table th,
        .highcharts-data-table caption {
            padding: 0.5em;
        }

        .highcharts-data-table thead tr,
        .highcharts-data-table tr:nth-child(even) {
            background: #f8f8f8;
        }

        .highcharts-data-table tr:hover {
            background: #f1f7ff;
        }

    </style>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/variable-pie.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>
    <script>
        Highcharts.chart('container', {
            chart: {
                type: 'column'
            },
            title: {
                text: 'Grafik Total Per Bagian'
            },
            // subtitle: {
            //     text: ''
            // },
            xAxis: {
                categories: [
                    'CSOB & HK',
                    'Security',
                    'Teknisi ME'
                ],
                crosshair: true
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Jumlah Pekerjaan'
                }
            },
            tooltip: {
                headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                // pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                //     '<td style="padding:0"><b>{point.y:.1f} mm</b></td></tr>',
                footerFormat: '</table>',
                shared: true,
                useHTML: true
            },
            plotOptions: {
                column: {
                    pointPadding: 0.2,
                    borderWidth: 0
                }
            },
            series: [{
                name: 'Jumlah Pekerjaan',
                data: {!! json_encode($data) !!}

            }, ]
        });

    </script>
    <script>
        $(function() {
            var data_progress = {!! json_encode($data_progress) !!};
            var data_name = {!! json_encode($data_name) !!};
            var datas = [];
            for (var i = 0; i < data_name.length; i++) {
                datas.push({
                    name: data_name[i],
                    y: data_progress[i]
                });
            }

            Highcharts.chart('container1', {
                chart: {
                    type: 'variablepie'
                },
                title: {
                    text: 'Status Pekerjaan'
                },
                tooltip: {
                    pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                },
                plotOptions: {
                    pie: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        dataLabels: {
                            enabled: true,
                            format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                            style: {
                                color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                            }
                        }
                    }
                },
                series: [{
                    minPointSize: 75,
                    innerSize: '40%',
                    zMin: 0,
                    name: 'Persentase',
                    data: datas,


                }]
            });

        });


    </script>
@endpush
