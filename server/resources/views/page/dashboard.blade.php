@extends('layout.app')
@section('view_title')
    Tổng quan
@endsection

@section('main')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col-sm mb-2 mb-sm-0">
                    <h1 class="page-header-title">Tổng quan</h1>
                    <a href="{{ route('cache-resset') }}" class="btn btn-info btn-sm" href="javascript:;">
                        <i class="tio-user-add mr-1"></i>Nạp cache
                    </a>
                </div>

                <div class="col-sm-auto">
                    <a class="btn btn-primary" href="javascript:;" data-toggle="modal" data-target="#inviteUserModal">
                        <i class="tio-user-add mr-1"></i>Thêm cộng tác viên
                    </a>
                </div>
            </div>
        </div>
        <div>
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
        </div>
        <!-- End Page Header -->

        <!-- Stats -->
        <div class="row gx-2 gx-lg-3">
            <div class="col-sm-6 col-lg-3 mb-3 mb-lg-5">
                <!-- Card -->
                <a class="card card-hover-shadow h-100" href="#">
                    <div class="card-body">
                        <h6 class="card-subtitle">Tổng tài khoản</h6>

                        <div class="row align-items-center gx-2 mb-1">
                            <div class="col-6">
                                <span class="card-title h2">{{ $data['user_count'] }}</span>
                            </div>
                            @php
                                $usersPerMonth_label = '';
                                $usersPerMonth_data = '';
                                foreach ($data['usersPerMonth'] as $key => $value) {
                                    $usersPerMonth_label .= '"' . $value['month'] . '/' . $value->year . '"' . ',';
                                    $usersPerMonth_data .= $value['total'] . ',';
                                }
                                $usersPerMonth_label = rtrim($usersPerMonth_label, ',');
                                $usersPerMonth_data = rtrim($usersPerMonth_data, ',');
                            @endphp
                            <div class="col-6">
                                <!-- Chart -->
                                <div class="chartjs-custom" style="height: 3rem">
                                    <canvas class="js-chart"
                                        data-hs-chartjs-options='{
                        "type": "line",
                        "data": {
                           "labels": [{{ $usersPerMonth_label }}],
                           "datasets": [{
                            "data": [{{ $usersPerMonth_data }}],
                            "backgroundColor": ["rgba(55, 125, 255, 0)", "rgba(255, 255, 255, 0)"],
                            "borderColor": "#377dff",
                            "borderWidth": 2,
                            "pointRadius": 0,
                            "pointHoverRadius": 0
                          }]
                        },
                        "options": {
                           "scales": {
                             "yAxes": [{
                               "display": false
                             }],
                             "xAxes": [{
                               "display": false
                             }]
                           },
                          "hover": {
                            "mode": "nearest",
                            "intersect": false
                          },
                          "tooltips": {
                            "postfix": " tài khoản",
                            "hasIndicator": true,
                            "intersect": false
                          }
                        }
                      }'>
                                    </canvas>
                                </div>
                                <!-- End Chart -->
                            </div>
                        </div>
                        <!-- End Row -->

                        {{-- <span class="badge badge-soft-success">
                            <i class="tio-trending-up"></i> 12.5%
                        </span>
                        <span class="text-body font-size-sm ml-1">from 70,104</span> --}}
                    </div>
                </a>
                <!-- End Card -->
            </div>

            <div class="col-sm-6 col-lg-3 mb-3 mb-lg-5">
                <!-- Card -->
                <a class="card card-hover-shadow h-100" href="#">
                    <div class="card-body">
                        <h6 class="card-subtitle">Tổng sản phẩm</h6>

                        <div class="row align-items-center gx-2 mb-1">
                            <div class="col-6">
                                <span class="card-title h2">{{ $data['product_count'] }}</span>
                            </div>
                            @php
                                $productPerMonth_label = '';
                                $productPerMonth_data = '';
                                foreach ($data['productPerMonth'] as $key => $value) {
                                    $productPerMonth_label .= '"' . $value['month'] . '/' . $value->year . '"' . ',';
                                    $productPerMonth_data .= $value['total'] . ',';
                                }
                                $productPerMonth_label = rtrim($productPerMonth_label, ',');
                                $productPerMonth_data = rtrim($productPerMonth_data, ',');
                            @endphp
                            <div class="col-6">
                                <!-- Chart -->
                                <div class="chartjs-custom" style="height: 3rem">
                                    <canvas class="js-chart"
                                        data-hs-chartjs-options='{
                        "type": "line",
                        "data": {
                           "labels": [{{ $productPerMonth_label }}],
                           "datasets": [{
                            "data": [{{ $productPerMonth_data }}],
                            "backgroundColor": ["rgba(55, 125, 255, 0)", "rgba(255, 255, 255, 0)"],
                            "borderColor": "#377dff",
                            "borderWidth": 2,
                            "pointRadius": 0,
                            "pointHoverRadius": 0
                          }]
                        },
                        "options": {
                           "scales": {
                             "yAxes": [{
                               "display": false
                             }],
                             "xAxes": [{
                               "display": false
                             }]
                           },
                          "hover": {
                            "mode": "nearest",
                            "intersect": false
                          },
                          "tooltips": {
                            "postfix": " sản phẩm",
                            "hasIndicator": true,
                            "intersect": false
                          }
                        }
                      }'>
                                    </canvas>
                                </div>
                                <!-- End Chart -->
                            </div>
                        </div>
                        <!-- End Row -->

                        {{-- <span class="badge badge-soft-success">
                            <i class="tio-trending-up"></i> 1.7%
                        </span>
                        <span class="text-body font-size-sm ml-1">from 29.1%</span> --}}
                    </div>
                </a>
                <!-- End Card -->
            </div>

            <div class="col-sm-6 col-lg-3 mb-3 mb-lg-5">
                <!-- Card -->
                <a class="card card-hover-shadow h-100" href="#">
                    <div class="card-body">
                        <h6 class="card-subtitle">Tổng đơn hàng</h6>

                        <div class="row align-items-center gx-2 mb-1">
                            <div class="col-6">
                                <span class="card-title h2">{{ $data['order_count'] }}</span>
                            </div>
                            @php
                                $orderPerMonth_label = '';
                                $orderPerMonth_data = '';
                                foreach ($data['orderPerMonth'] as $key => $value) {
                                    $orderPerMonth_label .= '"' . $value['month'] . '/' . $value->year . '"' . ',';
                                    $orderPerMonth_data .= $value['total'] . ',';
                                }
                                $orderPerMonth_label = rtrim($orderPerMonth_label, ',');
                                $orderPerMonth_data = rtrim($orderPerMonth_data, ',');
                            @endphp
                            <div class="col-6">
                                <!-- Chart -->
                                <div class="chartjs-custom" style="height: 3rem">
                                    <canvas class="js-chart"
                                        data-hs-chartjs-options='{
                        "type": "line",
                        "data": {
                          "labels": [{{ $orderPerMonth_label }}],
                           "datasets": [{
                            "data": [{{ $orderPerMonth_data }}],
                            "backgroundColor": ["rgba(55, 125, 255, 0)", "rgba(255, 255, 255, 0)"],
                            "borderColor": "#377dff",
                            "borderWidth": 2,
                            "pointRadius": 0,
                            "pointHoverRadius": 0
                          }]
                        },
                        "options": {
                           "scales": {
                             "yAxes": [{
                               "display": false
                             }],
                             "xAxes": [{
                               "display": false
                             }]
                           },
                          "hover": {
                            "mode": "nearest",
                            "intersect": false
                          },
                          "tooltips": {
                            "postfix": " đơn hàng",
                            "hasIndicator": true,
                            "intersect": false
                          }
                        }
                      }'>
                                    </canvas>
                                </div>
                                <!-- End Chart -->
                            </div>
                        </div>
                        <!-- End Row -->

                        {{-- <span class="badge badge-soft-danger">
                            <i class="tio-trending-down"></i> 4.4%
                        </span>
                        <span class="text-body font-size-sm ml-1">from 61.2%</span> --}}
                    </div>
                </a>
                <!-- End Card -->
            </div>

            <div class="col-sm-6 col-lg-3 mb-3 mb-lg-5">
                <!-- Card -->
                <a class="card card-hover-shadow h-100" href="#">
                    <div class="card-body">
                        <h6 class="card-subtitle">Doanh thu</h6>

                        <div class="row align-items-center gx-2 mb-1">
                            <div class="col-6">
                                <span class="card-title h2">{{ number_format($data['revenue'], 0, ',', '.') }}đ</span>
                            </div>
                            @php
                                $revenuePerMonth_label = '';
                                $revenuePerMonth_data = '';
                                foreach ($data['revenuePerMonth'] as $key => $value) {
                                    $revenuePerMonth_label .= '"' . $value['month'] . '/' . $value->year . '"' . ',';
                                    // $numberformat           = number_format($value->total,0,',','.');
                                    $revenuePerMonth_data .= '"' . $value['total'] . '",';
                                }
                                $revenuePerMonth_label = rtrim($revenuePerMonth_label, ',');
                                $revenuePerMonth_data = rtrim($revenuePerMonth_data, ',');
                            @endphp
                            <div class="col-6">
                                <!-- Chart -->
                                <div class="chartjs-custom" style="height: 3rem">
                                    <canvas class="js-chart"
                                        data-hs-chartjs-options='{
                        "type": "line",
                        "data": {
                           "labels": [{{ $revenuePerMonth_label }}],
                           "datasets": [{
                            "data": [{{ $revenuePerMonth_data }}],
                            "backgroundColor": ["rgba(55, 125, 255, 0)", "rgba(255, 255, 255, 0)"],
                            "borderColor": "#377dff",
                            "borderWidth": 2,
                            "pointRadius": 0,
                            "pointHoverRadius": 0
                          }]
                        },
                        "options": {
                           "scales": {
                             "yAxes": [{
                               "display": false
                             }],
                             "xAxes": [{
                               "display": false
                             }]
                           },
                          "hover": {
                            "mode": "nearest",
                            "intersect": false
                          },
                          "tooltips": {
                            "postfix": " vnd",
                            "hasIndicator": true,
                            "intersect": false
                          }
                        }
                      }'>
                                    </canvas>
                                </div>
                                <!-- End Chart -->
                            </div>
                        </div>
                        <!-- End Row -->

                        {{-- <span class="badge badge-soft-secondary">0.0%</span>
                        <span class="text-body font-size-sm ml-1">from 2,913</span> --}}
                    </div>
                </a>
                <!-- End Card -->
            </div>
        </div>
        <!-- End Stats -->

        <div class="row gx-2 gx-lg-3">
            <div class="col-lg-5 mb-3 mb-lg-5">
                <!-- Card -->
                <div class="card h-100">
                    <!-- Header -->
                    <div class="card-header">
                        <h5 class="card-header-title">
                            Yêu cầu trở thành cộng tác viên
                        </h5>

                        <!-- Unfold -->
                        {{-- <div class="hs-unfold">
                            <a class="js-hs-unfold-invoker btn btn-icon btn-sm btn-ghost-secondary rounded-circle"
                                href="javascript:;"
                                data-hs-unfold-options='{
                                "target": "#reportsOverviewDropdown2",
                                "type": "css-animation"
                                }'>
                                <i class="tio-more-vertical"></i>
                            </a>

                            <div id="reportsOverviewDropdown2"
                                class="hs-unfold-content dropdown-unfold dropdown-menu dropdown-menu-right mt-1">
                                <span class="dropdown-header">Settings</span>

                                <a class="dropdown-item" href="#">
                                    <i class="tio-share dropdown-item-icon"></i> Share chart
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="tio-download-to dropdown-item-icon"></i>
                                    Download
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="tio-alt dropdown-item-icon"></i> Connect other
                                    apps
                                </a>

                                <div class="dropdown-divider"></div>

                                <span class="dropdown-header">Feedback</span>

                                <a class="dropdown-item" href="#">
                                    <i class="tio-chat-outlined dropdown-item-icon"></i>
                                    Report
                                </a>
                            </div>
                        </div> --}}
                        <!-- End Unfold -->
                    </div>
                    <!-- End Header -->

                    <!-- Body -->
                    <div class="card-body">
                        <p>
                            Thêm người dùng làm cộng các viên để quản trị hệ thống Quin Ecommerce
                        </p>

                        <ul class="list-group list-group-flush list-group-no-gutters">
                            <li class="list-group-item py-3">
                                <h5 class="modal-title">Danh sách yêu cầu:</h5>
                            </li>

                            <!-- List Group Item -->

                            @forelse ($data['contributors'] as $item)
                                <li class="list-group-item py-3">
                                    <div class="media">
                                        <div class="mt-1 mr-3" style="width: 40px;height:40px">
                                            <img style="width: 100%; height:100%; object-fit:cover"
                                                class="avatar avatar-xs avatar-4by3" src="{{ $item['user']['avatar_url'] }}"
                                                alt="Image Description" />
                                        </div>
                                        <div class="media-body">
                                            <div class="row align-items-center">
                                                <div class="col">
                                                    <h5 class="mb-0">{{ $item['user']['email'] }}</h5>
                                                    <span class="d-block font-size-sm">Yêu cầu quyền:
                                                        {{ $item->role->name }}</span>
                                                </div>

                                                <div class="col-auto d-flex">
                                                    <form action="{{route('user.contributor.add-role',['id'=>$item['id'],'type'=>'reject'])}}" class="mr-2" method="POST">
                                                        <button type="submit" class="btn btn-sm btn-outline-danger"
                                                            href="#" title="Launch importer" target="_blank">
                                                            @csrf
                                                            Từ chối
                                                            <i class="tio-open-in-new ml-1"></i>
                                                        </button>
                                                    </form>
                                                    <form action="{{route('user.contributor.add-role',['id'=>$item['id'],'type'=>'active'])}}" method="POST">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-primary"
                                                            href="#" title="Launch importer" target="_blank">
                                                            Chấp nhận
                                                            <i class="tio-open-in-new ml-1"></i>
                                                        </button>

                                                    </form>

                                                </div>
                                            </div>
                                            <!-- End Row -->
                                        </div>
                                    </div>
                                </li>

                            @empty
                                <li class="list-group-item py-3">
                                    <div class="text-center">
                                        <span class="font-weight-bold">Đang cập nhật dữ liệu.</span>
                                    </div>
                                </li>
                            @endforelse

                            <!-- End List Group Item -->

                            <li class="list-group-item">
                                <small>Hoặc bạn có thể
                                    <a href="/user">thêm quền</a> trong phần quản lý người dùng.</small>
                            </li>
                        </ul>
                    </div>
                    <!-- End Body -->
                </div>
                <!-- End Card -->
            </div>

            <div class="col-lg-7 mb-3 mb-lg-5">
                <!-- Card -->
                <div class="card h-100">
                    <!-- Header -->
                    <div class="card-header">
                        <h5 class="card-header-title">Tổng đơn hàng theo tuần</h5>
                        @php
                            $dataFill1 = [
                                'thisweek' => 'Tuần này',
                                'lastweek' => 'Tuần trước',
                                'day30' => '30 ngày trước',
                                'day60' => '60 ngày trước',
                                'day90' => '90 ngày trước',
                                'year' => '1 năm',
                            ];
                        @endphp

                        <!-- Nav -->
                        <ul class="nav nav-segment" id="expensesTab" role="tablist">

                            @foreach ($dataFill1 as $key => $value)
                                <li class="nav-item">
                                    <a class="nav-link {{ isset(request()->filter) && request()->filter == $key ? 'active' : '' }}"
                                        href="?filter={{ $key }}">{{ $value }}</a>
                                </li>
                            @endforeach
                            {{-- <li class="nav-item" >
                                <a class="nav-link active" href="?week=thisWeek" >Tuần này</a>
                            </li>
                            <li class="nav-item" >
                                <a class="nav-link" href="?week=lastWeek" >Tuần trước</a>
                            </li> --}}
                            {{-- <button  id="js-daterangepicker-predefined" class="btn btn-ghost-secondary dropdown-toggle">
                                <i class="tio-date-range"></i>
                                <span class="js-daterangepicker-predefined-preview ml-1"></span>
                            </button> --}}
                        </ul>
                        <!-- End Nav -->
                    </div>
                    <!-- End Header -->

                    <!-- Body -->
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-sm mb-2 mb-sm-0">
                                <div class="d-flex align-items-center">
                                    <span class="h1 mb-0">35%</span>
                                    <span class="text-success ml-2">
                                        <i class="tio-trending-up"></i> 25.3%
                                    </span>
                                </div>
                            </div>

                            <div class="col-sm-auto align-self-sm-end">
                                <!-- Legend Indicators -->
                                <div class="row font-size-sm">
                                    <div class="col-auto">
                                        <span class="legend-indicator bg-primary"></span> Đơn hoàn thành
                                    </div>
                                    <div class="col-auto">
                                        <span class="legend-indicator"></span> Đơn đã hủy
                                    </div>
                                </div>
                                <!-- End Legend Indicators -->
                            </div>
                        </div>
                        <!-- End Row -->
                        @php
                            $orders1PerDay_label = '';
                            $orders1PerDay_data = '';
                            foreach ($data['orders1PerDay'] as $key => $value) {
                                $orders1PerDay_label .= '"' . $value['date'] . '"' . ',';
                                // $numberformat           = number_format($value->total,0,',','.');
                                $orders1PerDay_data .= '"' . $value['total'] . '",';
                            }
                            $orders1PerDay_label = rtrim($orders1PerDay_label, ',');
                            $orders1PerDay_data = rtrim($orders1PerDay_data, ',');
                        @endphp
                        @php
                            $orders2PerDay_label = '';
                            $orders2PerDay_data = '';
                            foreach ($data['orders2PerDay'] as $key => $value) {
                                $orders2PerDay_label .= '"' . $value['date'] . '"' . ',';
                                // $numberformat           = number_format($value->total,0,',','.');
                                $orders2PerDay_data .= '"' . $value->total . '",';
                            }
                            $orders2PerDay_label = rtrim($orders2PerDay_label, ',');
                            $orders2PerDay_data = rtrim($orders2PerDay_data, ',');
                        @endphp



                        <!-- Bar Chart -->
                        <div class="chartjs-custom">
                            <canvas id="updatingData" style="height: 20rem"
                                data-hs-chartjs-options='{
                                "type": "bar",
                                "data": {
                                "labels":[{{ $orders1PerDay_label }}],
                                "datasets": [{
                                    "data": [{{ $orders1PerDay_data }}],
                                    "backgroundColor": "#8037f1",
                                    "hoverBackgroundColor": "#377dff",
                                    "borderColor": "#377dff"
                                },
                                {
                                    "data": [{{ $orders2PerDay_data }}],
                                    "backgroundColor": "#eb202045",
                                    "borderColor": "#e7eaf3"
                                }]
                                },
                                "options": {
                                "scales": {
                                    "yAxes": [{
                                    "gridLines": {
                                        "color": "#e7eaf3",
                                        "drawBorder": false,
                                        "zeroLineColor": "#e7eaf3"
                                    },
                                    "ticks": {
                                        "beginAtZero": true,
                                        "stepSize": 100,
                                        "fontSize": 12,
                                        "fontColor": "#97a4af",
                                        "fontFamily": "Open Sans, sans-serif",
                                        "padding": 10,
                                        "postfix": " đ"
                                    }
                                    }],
                                    "xAxes": [{
                                    "gridLines": {
                                        "display": false,
                                        "drawBorder": false
                                    },
                                    "ticks": {
                                        "fontSize": 12,
                                        "fontColor": "#97a4af",
                                        "fontFamily": "Open Sans, sans-serif",
                                        "padding": 5
                                    },
                                    "categoryPercentage": 0.5,
                                    "maxBarThickness": "10"
                                    }]
                                },
                                "cornerRadius": 2,
                                "tooltips": {
                                    "prefix": "",
                                    "hasIndicator": true,
                                    "mode": "index",
                                    "intersect": false
                                },
                                "hover": {
                                    "mode": "nearest",
                                    "intersect": true
                                }
                                }
                            }'></canvas>
                        </div>
                        <!-- End Bar Chart -->
                    </div>
                    <!-- End Body -->
                </div>
                <!-- End Card -->
            </div>
        </div>
        <!-- End Row -->
        <div class="row gx-2 gx-lg-3">
            <div class="col-lg-6 mb-3 mb-lg-0">
                <!-- Card -->
                <div class="card h-100">
                    <!-- Header -->
                    <div class="card-header">
                        <h5 class="card-header-title">Hình thức thanh toán</h5>

                        <!-- Daterangepicker -->
                        {{-- <button id="js-daterangepicker-predefined" class="btn btn-sm btn-ghost-secondary dropdown-toggle">
                            <i class="tio-date-range"></i>
                            <span class="js-daterangepicker-predefined-preview ml-1"></span>
                        </button> --}}
                        <!-- End Daterangepicker -->
                    </div>
                    <!-- End Header -->

                    <!-- Body -->
                    <div class="card-body">
                        @php
                        $color =[
                            ['a'=>'blue','b'=>'primary','po'=>'"x": 55, "y": 65'],
                            ['a'=>'red','b'=>'danger','po'=>'"x": 33, "y": 42'],
                            ['a'=>'green','b'=>'succcess','po'=>'"x": 46, "y": 26'],
                            ['a'=>'yellow','b'=>'warning','po'=>'"x": 12, "y": 35'],
                    ];
                        $data_transactions = '';
                        $data_color = [];
                            foreach ($data['transactions'] as $key => $value) {
                                $data_transactions.= ' {"label": "Label 1 '.$key.'","data": [{'.$color[$key]['po'].', "r": '.$value->total.'}],"color": "#fff","backgroundColor": "'.$color[$key]['a'].'","borderColor": "transparent"},';
                            }
                            $data_transactions = rtrim($data_transactions, ',');
                        @endphp
                        @foreach ($data['transactions'] as $item)

                        @endforeach
                        <!-- Chart -->
                        <div class="chartjs-custom mx-auto" style="height: 20rem">
                            <canvas class="js-chart-datalabels"
                                data-hs-chartjs-options='{
                                "type": "bubble",
                                "data": {
                                "datasets": [
                                    {{$data_transactions}}
                                ]
                                },
                                "options": {
                                "scales": {
                                    "yAxes": [{
                                    "gridLines": {
                                        "display": false
                                    },
                                    "ticks": {
                                        "display": false,
                                        "max": 100,
                                        "beginAtZero": true
                                    }
                                    }],
                                    "xAxes": [{
                                    "gridLines": {
                                        "display": false
                                    },
                                    "ticks": {
                                        "display": false,
                                        "max": 100,
                                        "beginAtZero": true
                                    }
                                    }]
                                },
                                "tooltips": false
                                }
                            }'></canvas>
                        </div>
                        <!-- End Chart -->

                        <!-- Legend Indicators -->
                        <div class="row justify-content-center">
                            @foreach ($data['transactions'] as $key=>$item)
                                <div class="col-auto">
                                    <span style="text-transform: uppercase" class="legend-indicator bg-{{$color[$key]['b']}}"></span><strong class="text-{{$color[$key]['b']}}" style="text-transform: uppercase">{{{$item->payment_method->code}}} </strong> - {{$item->payment_method->name}}
                                </div>

                            @endforeach
                        </div>
                        <!-- End Legend Indicators -->
                    </div>
                    <!-- End Body -->
                </div>
                <!-- End Card -->
            </div>

            <div class="col-lg-6">
                <!-- Card -->
                <div class="card h-100">
                    <!-- Header -->
                    <div class="card-header">
                        <h5 class="card-header-title">Báo cáo doanh thu</h5>

                        <!-- Unfold -->

                        <!-- End Unfold -->
                    </div>
                    <!-- End Header -->

                    <!-- Body -->
                    <div class="card-body">
                        <span class="h1 d-block mb-4">{{number_format($data['money']->total,0,',','.')}} VND</span>

                        <!-- Progress -->
                        <div class="progress rounded-pill mb-2">
                            <div class="progress-bar" role="progressbar" style="width: {{($data['money']->completed/$data['money']->total)*100}}%" aria-valuenow="{{($data['money']->completed/$data['money']->total)*100}}"
                                aria-valuemin="0" aria-valuemax="100" data-toggle="tooltip" data-placement="top"
                                title="Đơn hàng đã thanh toán"></div>
                            <div class="progress-bar opacity" role="progressbar" style="width: {{($data['money']->new/$data['money']->total)*100}}%" aria-valuenow="{{($data['money']->new/$data['money']->total)*100}}"
                                aria-valuemin="0" aria-valuemax="100" data-toggle="tooltip" data-placement="top"
                                title="Đơn hàng mới chưa thanh toán">
                            </div>
                            <div class="progress-bar opacity-xs" role="progressbar" style="width: {{($data['money']->cancelled/$data['money']->total)*100}}%" aria-valuenow="{{($data['money']->cancelled/$data['money']->total)*100}}"
                                aria-valuemin="0" aria-valuemax="100" data-toggle="tooltip" data-placement="top"
                                title="Đơn hàng đã hủy">
                            </div>
                        </div>

                        <div class="d-flex justify-content-between mb-4">
                            <span>0%</span>
                            <span>100%</span>
                        </div>
                        <!-- End Progress -->

                        <!-- Table -->
                        <div class="table-responsive">
                            <table class="table table-lg table-nowrap card-table mb-0">
                                <tr>
                                    <th scope="row">
                                        <span class="legend-indicator bg-primary"></span>Đơn hoàn thành
                                    </th>
                                    <td>{{number_format($data['money']->completed,0,',','.')}} VND</td>
                                    <td>
                                        {{-- <span class="badge badge-soft-success">+12.1%</span> --}}
                                    </td>
                                </tr>

                                <tr>
                                    <th scope="row">
                                        <span class="legend-indicator bg-primary opacity"></span>Đơn chưa thanh toán
                                    </th>
                                    <td>{{number_format($data['money']->new,0,',','.')}} VND</td>
                                    <td>
                                        {{-- <span class="badge badge-soft-warning">+6.9%</span> --}}
                                    </td>
                                </tr>

                                <tr>
                                    <th scope="row">
                                        <span class="legend-indicator bg-primary opacity-xs"></span>Đơn đã hủy
                                    </th>
                                    <td>{{number_format($data['money']->cancelled,0,',','.')}} VND</td>
                                    <td>
                                        {{-- <span class="badge badge-soft-danger">-1.5%</span> --}}
                                    </td>
                                </tr>


                            </table>
                        </div>
                        <!-- End Table -->
                    </div>
                    <!-- End Body -->
                </div>
                <!-- End Card -->
            </div>
        </div>

        <!-- Card -->
        <div class="card mb-3 mb-lg-5">
            <!-- Header -->
            <div class="card-header">
                <div class="row justify-content-between align-items-center flex-grow-1">
                    <div class="col-12 col-md">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="card-header-title">Sản phẩm chờ duyệt {{ $data['product_waiting']->total() }}</h5>

                            <a href="{{ route('product.list') }}?type=pending">Xem tất cả</a>
                            <!-- End Datatable Info -->
                        </div>

                    </div>

                </div>
            </div>
            <!-- End Header -->

            <!-- Table -->
            <div class="table-responsive datatable-custom">
                <table id="datatable"
                    class="table table-borderless table-thead-bordered table-nowrap table-align-middle card-table">
                    <thead class="thead-light">
                        <tr>
                            <th class="">Sản phẩm</th>
                            <th>Trạng thái</th>
                            <th>Cửa hàng</th>
                            <th>Giá</th>
                            <th>Số lượng</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($data['product_waiting'] as $item)
                            <tr>
                                <td class="">
                                    <a class="media align-items-center"
                                        href="{{ route('product.update', ['id' => $item->id]) }}">
                                        <div class=" mr-2">
                                            <img class="" class="rounded-lg" width="45" height="45"
                                                src="{{ $item->image }}" alt="Image Description" />
                                        </div>
                                        <div class="media-body" style="">
                                            <div class="h5 text-hover-primary mb-0"
                                                style="max-width: 220px;overflow:hidden">{{ $item->name }}
                                            </div>
                                        </div>
                                    </a>
                                </td>
                                <td>
                                    <span class="legend-indicator bg-warning"></span>Chờ duyệt
                                </td>
                                <td>
                                    <div>{{ $item->shop->name }}</div>
                                    <div>{{ $item->shop->email }}</div>
                                </td>
                                <td>{{ number_format($item->price, 0, ',', '.') }}đ</td>
                                <td>{{ $item->stock }}</td>
                                <td>
                                    <div class="d-flex flex-columns" style="flex-direction: column;gap:2px">
                                        <a href="{{ route('product.update_status', ['product_id' => $item->id, 'status' => 'ACTIVE']) }}"
                                            class="btn btn-sm btn-primary">Duyệt</a>
                                        <a href="{{ route('product.update_status', ['product_id' => $item->id, 'status' => 'DENY']) }}"
                                            class="btn btn-sm btn-outline-danger">Từ chối</a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                        @endforelse



                    </tbody>
                </table>
            </div>
            <!-- End Table -->

            <!-- Footer -->
            <div class="card-footer">
                <!-- Pagination -->
                <div class="row justify-content-center justify-content-sm-between align-items-sm-center">
                    <div class="col-sm mb-2 mb-sm-0">
                        <div class="d-flex justify-content-center justify-content-sm-start align-items-center">
                            <span class="mr-2">Hiển thị:</span>
                            {{ $data['product_waiting']->links() }}

                        </div>
                    </div>


                </div>
                <!-- End Pagination -->
            </div>
            <!-- End Footer -->
        </div>
        <!-- End Card -->
        <!-- Card -->
        <div class="card mb-3 mb-lg-5">
            <!-- Header -->
            <div class="card-header">
                <div class="row justify-content-between align-items-center flex-grow-1">
                    <div class="col-12 col-md">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="card-header-title">Tài khoản {{ $data['user_new']->total() }}</h5>

                            <a href="{{ route('user.list') }}?type=pending">Xem tất cả</a>
                            <!-- End Datatable Info -->
                        </div>

                    </div>

                </div>
            </div>
            <!-- End Header -->

            <!-- Table -->
            <div class="table-responsive datatable-custom">
                <table class="table table-borderless table-thead-bordered table-nowrap table-align-middle card-table">
                    <thead class="thead-light">
                        <tr>
                            <th class="">Tên</th>
                            <th>Email</th>
                            <th>Quyền</th>
                            <th>Ngày tạo</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($data['user_new'] as $item)
                            <tr>
                                <td class="">
                                    <a class="media align-items-center" href="">
                                        <div class=" mr-2">
                                            <img class="" class="rounded-lg" width="45" height="45"
                                                src="{{ $item->avatar_url }}" alt="Image Description" />
                                        </div>
                                        <div class="media-body" style="">
                                            <div class="h5 text-hover-primary mb-0"
                                                style="max-width: 220px;overflow:hidden">{{ $item->full_name }}
                                            </div>
                                        </div>
                                    </a>
                                </td>
                                <td>
                                    {{ $item->email }}
                                </td>
                                <td>
                                    @foreach ($item->roles() as $role)
                                        <span class="legend-indicator bg-primary"></span>{{ $role }}
                                    @endforeach
                                </td>
                                <td>{{ $item->created_at }}</td>
                            </tr>
                        @empty
                        @endforelse



                    </tbody>
                </table>
            </div>
            <!-- End Table -->

            <!-- Footer -->
            <div class="card-footer">
                <!-- Pagination -->
                <div class="row justify-content-center justify-content-sm-between align-items-sm-center">
                    <div class="col-sm mb-2 mb-sm-0">
                        <div class="d-flex justify-content-center justify-content-sm-start align-items-center">
                            <span class="mr-2">Hiển thị:</span>
                            {{ $data['product_waiting']->links() }}

                        </div>
                    </div>


                </div>
                <!-- End Pagination -->
            </div>
            <!-- End Footer -->
        </div>
        <!-- End Card -->


    </div>



    <!-- Create a new user Modal -->
    <div class="modal fade" id="inviteUserModal" tabindex="-1" role="dialog" aria-labelledby="inviteUserModalTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <form class="modal-content">
                <!-- Header -->
                <div class="modal-header">
                    <h4 id="inviteUserModalTitle" class="modal-title">Thêm cộng tác viên</h4>

                    <button type="button" class="btn btn-icon btn-sm btn-ghost-secondary" data-dismiss="modal"
                        aria-label="Close">
                        <i class="tio-clear tio-lg"></i>
                    </button>
                </div>
                <!-- End Header -->

                <!-- Body -->
                <div class="modal-body">
                    <!-- Form Group -->
                    <div class="form-group">
                        <div class="input-group input-group-merge mb-2 mb-sm-0">
                            <div class="input-group-prepend" id="fullName">
                                <span class="input-group-text">
                                    <i class="tio-search"></i>
                                </span>
                            </div>

                            <input type="text" class="form-control" name="fullName"
                                placeholder="Search name or emails" aria-label="Search name or emails"
                                aria-describedby="fullName" />

                            <div class="input-group-append input-group-append-last-sm-down-none">
                                <!-- Select -->
                                <div id="permissionSelect" class="select2-custom select2-custom-right">
                                    <select class="js-select2-custom custom-select" size="1" style="opacity: 0"
                                        data-hs-select2-options='{
                                        "dropdownParent": "#permissionSelect",
                                        "minimumResultsForSearch": "Infinity",
                                        "dropdownAutoWidth": true,
                                        "dropdownWidth": "11rem"
                                        }'>
                                        @foreach ($data['roles'] as $item)
                                            <option value="{{ $item->id }}" selected="">{{ $item->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <!-- End Select -->

                                <a class="btn btn-primary d-none d-sm-block" href="javascript:;">Invite</a>
                            </div>
                        </div>

                        <a class="btn btn-block btn-primary d-sm-none" href="javascript:;">Invite</a>
                    </div>
                    <!-- End Form Group -->

                    <div class="form-row">
                        <h5 class="col modal-title">Danh sách cộng tác viên</h5>


                    </div>

                    <hr class="mt-2" />

                    <ul class="list-unstyled list-unstyled-py-4">
                        <!-- List Group Item -->
                        @foreach ($data['users'] as $item)
                            <li>
                                <div class="media">
                                    <div class="avatar avatar-sm avatar-circle mr-3">
                                        <img class="avatar-img" src="{{ $item->avatar_url }}" alt="Image Description" />
                                    </div>

                                    <div class="media-body">
                                        <div class="row align-items-center">
                                            <div class="col-sm">
                                                <h5 class="text-body mb-0">
                                                    {{ $item->full_name }}
                                                    <i class="tio-verified text-primary" data-toggle="tooltip"
                                                        data-placement="top" title="Top endorsed"></i>
                                                </h5>
                                                <span class="d-block font-size-sm">{{ $item->email }}</span>
                                            </div>


                                        </div>
                                        <!-- End Row -->
                                    </div>
                                </div>
                            </li>
                        @endforeach

                    </ul>
                </div>
                <!-- End Body -->

                <!-- Footer -->
                <div class="modal-footer justify-content-start">
                    <div class="row align-items-center flex-grow-1 mx-n2">
                        <div class="col-sm-9 mb-2 mb-sm-0">
                            <input type="hidden" id="inviteUserPublicClipboard"
                                value="https://themes.getbootstrap.com/product/front-multipurpose-responsive-template/" />

                            <p class="modal-footer-text">
                                The public share <a href="#">link settings</a>
                                <i class="tio-help-outlined" data-toggle="tooltip" data-placement="top"
                                    title="The public share link allows people to view the project without giving access to full collaboration features."></i>
                            </p>
                        </div>

                        <div class="col-sm-3 text-sm-right">
                            <a class="js-clipboard btn btn-sm btn-white text-nowrap" href="javascript:;"
                                data-toggle="tooltip" data-placement="top" title="Copy to clipboard!"
                                data-hs-clipboard-options='{
                "type": "tooltip",
                "successText": "Copied!",
                "contentTarget": "#inviteUserPublicClipboard",
                "container": "#inviteUserModal"
               }'>
                                <i class="tio-link mr-1"></i> Copy link</a>
                        </div>
                    </div>
                </div>
                <!-- End Footer -->
            </form>
        </div>
    </div>
    <!-- End Create a new user Modal -->



@endsection
