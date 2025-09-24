@extends('layout.app')
@section('view_title')
    Tổng quan Quin Coin
@endsection
@section('main')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-sm mb-2 mb-sm-0">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-no-gutter">
                            <li class="breadcrumb-item"><a class="breadcrumb-link" href="/">Trang chủ</a></li>
                            <li class="breadcrumb-item"><a class="breadcrumb-link" href="javascript:;">Quin Coins</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Tổng quan</li>
                        </ol>
                    </nav>

                    <h1 class="page-header-title">Tổng quan Quin Coins</h1>
                </div>


            </div>
            <!-- End Row -->
        </div>
        <!-- End Page Header -->

        <!-- Stats -->
        <div class="row gx-2 gx-lg-3">
            <div class="col-sm-6 col-lg-3 mb-3 mb-lg-5">
                <!-- Card -->
                <div class="card h-100">
                    <div class="card-body">
                        <h6 class="card-subtitle mb-2">Coins đã tạo</h6>

                        <div class="row align-items-center gx-2">
                            <div class="col">
                                <span class="js-counter display-4 text-dark">{{ $total['coin_create'] }}</span>
                                {{-- <span class="text-body font-size-sm ml-1">from 22</span> --}}
                            </div>

                            <div class="col-auto">
                                <span class="badge badge-soft-success p-1">
                                    <i class="tio-trending-up"></i> Tăng
                                </span>
                            </div>
                        </div>
                        <!-- End Row -->
                    </div>
                </div>
                <!-- End Card -->
            </div>

            <div class="col-sm-6 col-lg-3 mb-3 mb-lg-5">
                <!-- Card -->
                <div class="card h-100">
                    <div class="card-body">
                        <h6 class="card-subtitle mb-2">Coins đã dùng</h6>

                        <div class="row align-items-center gx-2">
                            <div class="col">
                                <span class="js-counter display-4 text-dark">{{ abs($total['coin_used']) }}</span>
                            </div>

                            <div class="col-auto">
                                <span class="badge badge-soft-success p-1">
                                    <i class="tio-trending-up"></i> tăng
                                </span>
                            </div>
                        </div>
                        <!-- End Row -->
                    </div>
                </div>
                <!-- End Card -->
            </div>


        </div>
        <!-- End Stats -->

        <!-- Card -->
        <div class="card">
            <!-- Header -->
            <div class="card-header">
                <div class="row justify-content-between align-items-center flex-grow-1">
                    <div class="col-sm-6 col-md-4 mb-3 mb-sm-0">
                        <form class="d-flex">
                            <!-- Search -->
                            <div class="input-group input-group-merge input-group-flush">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="tio-search"></i>
                                    </div>
                                </div>
                                <input id="datatableSearch" type="text" name="search" class="form-control"
                                    placeholder="Tìm kiếm.." aria-label="Search users">
                            </div>
                            <button type="submit" class="btn btn-sm btn-warning">Tìm</button>
                            <!-- End Search -->
                        </form>
                    </div>


                </div>
                <!-- End Row -->
            </div>
            <!-- End Header -->

            <!-- Table -->
            <div class="table-responsive datatable-custom">
                <table id="datatable"
                    class="table table-lg table-borderless table-thead-bordered table-nowrap table-align-middle card-table">
                    <thead class="thead-light">
                        <tr>
                            <th class="table-column-pr-0">
                                #
                            </th>
                            <th class="table-column-pl-0">Tên</th>
                            <th>Người dùng</th>
                            <th>Trạng thái</th>
                            <th>Biến động</th>
                            <th>Ngày tạo</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($data as $item)
                            <tr>
                                <td class="table-column-pr-0">
                                    <div class="custom-control custom-checkbox">
                                        {{ $item->id }}
                                    </div>
                                </td>
                                <td class="table-column-pl-0">
                                    <a class="d-flex align-items-center" href="#">
                                        <div class="avatar avatar-circle">
                                            <img class="avatar-img" src="{{ asset('assets/icon/quin_coin.jpg') }}"
                                                alt="Image Description">
                                        </div>
                                        <div class="ml-3">
                                            <span class="d-block h5 text-hover-primary mb-0">{{ $item->name }}</span>
                                            {{-- <span class="d-block font-size-sm text-body">amanda@example.com</span> --}}
                                        </div>
                                    </a>
                                </td>
                                <td>
                                    <a href="{{ route('user.info', ['uuid' => $item->user->uuid]) }}">
                                        <span class="d-block h5 mb-0">{{ $item->user->full_name }}</span>
                                        <span class="d-block font-size-sm">{{ $item->user->email }}</span>

                                    </a>
                                </td>
                                <td>
                                    <span>{{ $item->status }}</span>
                                </td>
                                <td>
                                    @if ($item->amount > 0)
                                        <span class="legend-indicator bg-success"></span> {{ $item->amount }}
                                    @else
                                        <span class="legend-indicator bg-danger"></span>{{ $item->amount }}
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        {{ $item->created_at ?? '__' }}
                                    </div>
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td class="text-danger text-center py-5" colspan="6">
                                    Không tìm thấy dữ liêu nào!
                                </td>
                            </tr>
                        @endforelse





                    </tbody>
                </table>
            </div>
            <!-- End Table -->

            <!-- Footer -->
            <div class="card-footer">
                <!-- Pagination -->
                <div class="row justify-content-center justify-content-sm-between align-items-sm-center">
                    {{ $data->links() }}
                </div>
                <!-- End Pagination -->
            </div>
            <!-- End Footer -->
        </div>
        <!-- End Card -->
    </div>
@endsection
