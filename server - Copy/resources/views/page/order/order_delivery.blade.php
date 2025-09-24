@extends('layout.app')
@section('view_title')
    Đơn hàng vận chuyển
@endsection
@section('main')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center mb-3">
                <div class="col-sm">
                    <h1 class="page-header-title">Đơn hàng vận chuyển<span
                            class="badge badge-soft-dark ml-2">{{ $data->total() }}</span></h1>

                    <div class="mt-2">
                        <a class="text-body mr-3" href="javascript:;" data-toggle="modal" data-target="#exportOrdersModal">
                            <i class="tio-download-to mr-1"></i> Xuất file
                        </a>


                    </div>
                </div>
            </div>
            <!-- End Row -->

            <!-- Nav Scroller -->
            <div class="js-nav-scroller hs-nav-scroller-horizontal">
                <span class="hs-nav-scroller-arrow-prev" style="display: none;">
                    <a class="hs-nav-scroller-arrow-link" href="javascript:;">
                        <i class="tio-chevron-left"></i>
                    </a>
                </span>

                <span class="hs-nav-scroller-arrow-next" style="display: none;">
                    <a class="hs-nav-scroller-arrow-link" href="javascript:;">
                        <i class="tio-chevron-right"></i>
                    </a>
                </span>

                <!-- Nav -->
                <ul class="nav nav-tabs page-header-tabs">
                    <li class="nav-item">
                        <a class="nav-link {{ !request('status') ? 'active' : '' }}" href="?page=1">Tất cả</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request('status') == 'CONFIRMED' ? 'active' : '' }} " href="?status=CONFIRMED"
                            tabindex="-1">Chờ vận chuyển</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request('status') == 'ONDELIVERY' ? 'active' : '' }} "
                            href="?status=ONDELIVERY" tabindex="-1">Đang vận chuyển</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request('status') == 'COMPLETED' ? 'active' : '' }} " href="?status=COMPLETED"
                            tabindex="-1">Đã giao hàng</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request('status') == 'CANCELLED' ? 'active' : '' }} " href="?status=CANCELLED"
                            tabindex="-1">Đã hủy</a>
                    </li>
                </ul>
                <!-- End Nav -->
            </div>
            <!-- End Nav Scroller -->
        </div>
        <!-- End Page Header -->
        <div class="row">
            <div class="col-12">
                @if (session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
            </div>
        </div>
        <!-- Card -->
        <div class="card">
            <!-- Header -->
            <div class="card-header">
                <div class="row justify-content-between align-items-center flex-grow-1">
                    <div class="col-lg-6 mb-3 mb-lg-0">
                        <form>
                            <!-- Search -->
                            <div class="input-group input-group-merge input-group-flush">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="tio-search"></i>
                                    </div>
                                </div>
                                <input value="{{ request('search') ?? '' }}" id="datatableSearch" type="search"
                                    name="search" class="form-control" placeholder="Tìm kiếm tên cửa hàng.."
                                    aria-label="Search orders">
                            </div>
                            <!-- End Search -->
                        </form>
                    </div>

                    <div class="col-lg-6">
                        <div class="d-sm-flex justify-content-sm-end align-items-sm-center">
                            <!-- Datatable Info -->
                            <div id="datatableCounterInfo" class="mr-2 mb-2 mb-sm-0" style="display: none;">
                                <div class="d-flex align-items-center">
                                    <span class="font-size-sm mr-3">
                                        <span id="datatableCounter">0</span>
                                        Selected
                                    </span>
                                    <a class="btn btn-sm btn-outline-danger" href="javascript:;">
                                        <i class="tio-delete-outlined"></i> Delete
                                    </a>
                                </div>
                            </div>
                            <!-- End Datatable Info -->

                            <!-- Unfold -->
                            <div class="hs-unfold mr-2">
                                <a class="js-hs-unfold-invoker btn btn-sm btn-white dropdown-toggle" href="javascript:;"
                                    data-hs-unfold-options='{
                                        "target": "#usersExportDropdown",
                                        "type": "css-animation"
                                    }'>
                                    <i class="tio-download-to mr-1"></i> Sắp xếp theo
                                </a>

                                <div id="usersExportDropdown"
                                    class="hs-unfold-content dropdown-unfold dropdown-menu dropdown-menu-sm-right">
                                    <span class="dropdown-header">Lựa chọn</span>
                                    <a id="export-copy" class="dropdown-item" href="?{{ $params }}&sort=latest">
                                        Mới nhất
                                    </a>
                                    <a id="export-print" class="dropdown-item" href="?{{ $params }}&sort=oldest">
                                        Cũ nhất
                                    </a>
                                    <a class="dropdown-item" href="?{{ $params }}&sort=price_desc">
                                        Giá cao nhất
                                    </a>
                                    <a class="dropdown-item" href="?{{ $params }}&sort=price_asc">
                                        Giá thấp nhất
                                    </a>


                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- End Row -->
            </div>
            <!-- End Header -->

            <!-- Table -->
            <div class="table-responsive datatable-custom">
                <table
                    class="table table-hover table-borderless table-thead-bordered table-nowrap table-align-middle card-table"
                    style="width: 100%">
                    <thead class="thead-light">
                        <tr>
                            <th class="">Đơn hàng</th>
                            <th>Ngày</th>
                            <th>Địa chỉ</th>
                            <th>Khách hàng</th>
                            <th>Thanh toán</th>
                            {{-- <th>Trạng thái</th> --}}
                            <th>Tổng tiền</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($data as $item)
                            <tr>
                                <td class="">
                                    <div>Order: {{ $item->order->order_code }}</div>
                                    <div>
                                        <a href="ecommerce-order-details.html">ID: {{ $item->id }}</a>
                                    </div>

                                </td>
                                <td>
                                    <div>{{ $item->created_at }}</div>
                                    <div>Sản phẩm: x{{ $item->order_details->count() }}</div>
                                </td>

                                <td>
                                    <div>
                                        <div>
                                            {{ $item->order->address->ward->name ?? '' }} <br>
                                            {{ $item->order->address->district->name ?? '' }} <br>
                                            {{ $item->order->address->province->name ?? '' }} <br>
                                            <div class="d-flex">
                                                <div>Chi tiết:</div>
                                                <div style="max-width: 140px;overflow:hidden" title="{{ $item->order->address->address_detail ?? '' }}">{{ $item->order->address->address_detail ?? '' }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        <div>{{ $item->order->address->receiver_name ??'' }}</div>
                                        <div>{{ $item->order->address->phone_number??'' }}</div>
                                    </div>
                                </td>
                                <td>
                                    <div class="text-center">{{ strtoupper($item->order->payment_method->code) }}</div>
                                    <div>
                                        @if ($item->payment_status == 'PAID')
                                            <span class="badge badge-soft-success">
                                                <span class="legend-indicator bg-success"></span>Đã thanh toán
                                            </span>
                                        @else
                                            <span class="badge badge-soft-warning">
                                                <span class="legend-indicator bg-warning"></span>Chưa thanh toán
                                            </span>
                                        @endif

                                    </div>
                                </td>
                                {{-- <td>
                                    @switch($item->status)
                                        @case('NEW')
                                            <span class="badge badge-soft-warning">
                                                <span class="legend-indicator bg-warning"></span>{{ $item->status }}
                                            </span>
                                        @break

                                        @case('PROCESSING')
                                            <span class="badge badge-soft-primary">
                                                <span class="legend-indicator bg-primary"></span>{{ $item->status }}
                                            </span>
                                        @break

                                        @case('CANCELLED')
                                            <span class="badge badge-soft-danger">
                                                <span class="legend-indicator bg-danger"></span>{{ $item->status }}
                                            </span>
                                        @break

                                        @default
                                            <span class="badge badge-soft-info">
                                                <span class="legend-indicator bg-info"></span>{{ $item->status }}
                                            </span>
                                    @endswitch

                                </td> --}}
                                <td>
                                    <div class="d-flex align-items-center">
                                        {{-- &bull;&bull;&bull;&bull; --}}
                                        <span class="text-dark"> {{ number_format($item->total, 0, ',', '.') }} đ</span>
                                    </div>
                                </td>

                                <td>
                                    <div>
                                        <div class=" d-flex flex-direction-column" style="flex-direction: column;gap:4px">
                                            @if ($item->status == 'CONFIRMED' || $item->status == 'ONDELIVERY')
                                                @if ($item->status == 'CONFIRMED')
                                                    <a href="{{ route('order.delivery.status', ['id' => $item->id, 'status' => 'ONDELIVERY']) }}"
                                                        class="btn btn-sm btn-primary">Xác nhận</a>
                                                @else
                                                    <a href="{{ route('order.delivery.status', ['id' => $item->id, 'status' => 'COMPLETED']) }}"
                                                        class="btn btn-sm btn-success">Đã giao hàng</a>
                                                @endif
                                                <a href="{{ route('order.delivery.status', ['id' => $item->id, 'status' => 'CANCELlED']) }}"
                                                    class="btn btn-sm btn-outline-danger">Hủy đơn</a>
                                            @else
                                                <button class="btn" disabled>Hoàn thành</button>
                                            @endif
                                        </div>
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
                                <span class="mr-2">Showing:</span>

                                {{ $data->links() }}
                            </div>
                        </div>


                    </div>
                    <!-- End Pagination -->
                </div>
                <!-- End Footer -->
            </div>
            <!-- End Card -->
        </div>
    @endsection
