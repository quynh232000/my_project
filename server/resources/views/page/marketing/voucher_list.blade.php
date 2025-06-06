@extends('layout.app')
@section('view_title')
    Danh sách khuyến mãi
@endsection

@section('main')
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-sm mb-2 mb-sm-0">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-no-gutter">
                            <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ route('dashboard') }}">Trang
                                    chủ</a></li>
                            <li class="breadcrumb-item"><a class="breadcrumb-link"
                                    href="{{ route('marketing.voucher.list') }}">Khuyến mãi
                                </a></li>
                            <li class="breadcrumb-item active" aria-current="page">Danh sách khuyến mãi</li>
                        </ol>
                    </nav>

                    <h1 class="page-header-title">Danh khuyến mãi {{ $data->total() }}</h1>
                </div>
                <div class="col-sm-auto">
                    <a class="btn btn-primary" href="{{ route('marketing.voucher.add') }}">
                        <i class="fa-solid fa-plus mr-1"></i> Thêm khuyến mãi
                    </a>
                </div>
            </div>
            <!-- End Row -->
        </div>
        <!-- End Page Header -->



        <!-- Card -->
        <div class="card">
            <!-- Header -->
            <div class="card-header">
                <div class="row justify-content-between align-items-center flex-grow-1">
                    <div class="col-12">
                        <form class="d-flex">
                            <!-- Search -->

                            <div class="d-sm-flex justify-content-sm-end align-items-sm-center">
                                <div class="d-flex gap-2 align-items-center">
                                    <span class="me-2">Trạng thái</span>
                                    <div class="ps-2" style="padding-left:10px">
                                        <select name="status" id="" class="form-control ">
                                            <option value="">--Chọn--</option>
                                            <option value="active" {{isset(request()->status) && request()->status == 'active' ? 'selected':''}}>Đang diễn ra</option>
                                            <option value="coming" {{isset(request()->status) && request()->status == 'coming' ? 'selected':''}}>Sắp diễn ra</option>
                                            <option value="end" {{isset(request()->status) && request()->status == 'end' ? 'selected':''}}>Đã kết thúc</option>
                                        </select>

                                    </div>
                                </div>
                                <div class="d-flex gap-2 align-items-center ml-2">
                                    <span class="me-2">Loại</span>
                                    <div class="ps-2" style="padding-left:10px">
                                        <select name="type" id="" class="form-control ">
                                            <option value="">--Chọn--</option>
                                            <option value="ADMIN" {{isset(request()->type) && request()->type == 'ADMIN' ? 'selected':''}}>Quin Emccomerce</option>
                                            <option value="SHOP" {{isset(request()->type) && request()->type == 'SHOP' ? 'selected':''}}>Cửa hàng</option>
                                        </select>

                                    </div>
                                </div>
                            </div>
                            <div class="ml-5">
                                <div class="input-group input-group-merge input-group-flush">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="tio-search"></i>
                                        </div>
                                    </div>
                                    <input id="datatableSearch" type="text" name="search" class="form-control" value="{{request()->search ?? ''}}" placeholder="Tìm kiếm.."
                                        aria-label="Search users">
                                </div>
                            </div>
                            <div class="ml-5">
                                <button class="btn btn-primary px-5">Lọc</button>
                            </div>
                            <!-- End Search -->
                        </form>
                    </div>

                    <div class="col-sm-6">

                    </div>
                </div>
                <!-- End Row -->
            </div>
            <!-- End Header -->

            <!-- Table -->
            <div class="table-responsive">
                <table
                    class="table table-lg table-borderless table-thead-bordered table-nowrap table-align-middle card-table">
                    <thead class="thead-light">
                        <tr>
                            <th class="table-column-pr-0">
                                <div class="custom-control custom-checkbox">
                                    {{-- <input id="datatableCheckAll" type="checkbox" class="custom-control-input">
                                    <label class="custom-control-label" for="datatableCheckAll"></label> --}}
                                </div>
                            </th>
                            <th class="table-column-pl-0">Tên Voucher</th>
                            <th>Loại</th>
                            <th>Giảm giá</th>
                            <th>Số lượng</th>
                            <th>Thời gian</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($data as $item)
                            <tr>
                                <td class="table-column-pr-0">
                                    <div class="custom-control custom-checkbox">
                                        #{{ $item->id }}
                                    </div>
                                </td>
                                <td class="table-column-pl-0">
                                    <a class="d-flex align-items-center" href="user-profile.html">

                                        <div class="">
                                            @switch($item->status)
                                                @case('end')
                                                    <div
                                                        class="d-block h5 text-hover-primary mb-2 badge badge-soft-danger pb-1 text-start" style="width: fit-content">
                                                        <span class="legend-indicator bg-danger"></span>Đã kết thúc
                                                    </div>
                                                @break

                                                @case('active')
                                                    <div
                                                        class="d-block h5 text-hover-primary mb-2 badge badge-soft-success pb-1 text-start" style="width: fit-content">
                                                        <span class="legend-indicator bg-success"></span>Đang diễn ra
                                                    </div>
                                                @break

                                                @default
                                                    <div
                                                        class="d-block h5 text-hover-primary mb-2 badge badge-soft-warning pb-1 text-start" style="width: fit-content">
                                                        <span class="legend-indicator bg-warning"></span>Sắp diễn ra
                                                    </div>
                                            @endswitch

                                            <span class="d-block h5 text-hover-primary mb-0">{{ $item->name }} </span>
                                            <span class="d-block font-size-sm text-body">Mã: {{ $item->code }}</span>
                                        </div>
                                    </a>
                                </td>
                                <td>
                                    <span class="d-block h5 mb-0">{{ strtoupper($item->from) }}</span>
                                </td>
                                <td>{{ number_format($item->discount_amount, 0, ',', '.') }} vnd</td>
                                <td>
                                    {{ $item->quantity }}
                                </td>

                                <td>
                                    <div>Từ: <span class="text-primary ml-2">{{ $item->date_start }}</span></div>
                                    <div>Đến: <span class="text-primary ml-2">{{ $item->date_end }}</span></div>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a class="btn btn-sm btn-white"
                                            href="{{ route('marketing.voucher.update', ['id' => $item->id]) }}">
                                            <i class="tio-edit"></i> Sửa
                                        </a>
                                        <!-- Unfold -->
                                        <div class="hs-unfold btn-group">
                                            <a class="js-hs-unfold-invoker btn btn-icon btn-sm btn-white dropdown-toggle dropdown-toggle-empty"
                                                href="javascript:;"
                                                data-hs-unfold-options='{
                                                    "target": "#productsEditDropdown1",
                                                    "type": "css-animation",
                                                    "smartPositionOffEl": "#datatable"
                                                }'></a>

                                            <div id="productsEditDropdown1"
                                                class="hs-unfold-content dropdown-unfold dropdown-menu dropdown-menu-right mt-1">


                                                <a class="dropdown-item"
                                                    href="{{ route('marketing.voucher.update', ['id' => $item->id]) }}">
                                                    <i class="tio-publish dropdown-item-icon"></i> Sửa
                                                </a>
                                                <a class="dropdown-item"
                                                    href="{{ route('banner.update', ['id' => $item->id]) }}">
                                                    <i class="fa-regular fa-copy dropdown-item-icon"></i> Sao chép
                                                </a>
                                                <a class="dropdown-item"
                                                    href="{{ route('banner.delete', ['id' => $item->id]) }}">
                                                    <i class="tio-clear dropdown-item-icon"></i> Xóa
                                                </a>
                                            </div>
                                        </div>
                                        <!-- End Unfold -->
                                    </div>
                                </td>
                            </tr>

                            @empty
                                <tr>
                                    <td class="text-danger text-center py-5" colspan="7">Không tìm thấy dữ liệu nào!</td>
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
                        <div class="col-sm mb-2 mb-sm-0">
                            <div class="d-flex justify-content-center justify-content-sm-start align-items-center">
                                <span class="mr-2">Hiển thị:</span>

                                <!-- Select -->

                            </div>
                        </div>

                        {{ $data->links() }}
                    </div>
                    <!-- End Pagination -->
                </div>
                <!-- End Footer -->
            </div>
            <!-- End Card -->
        </div>
    @endsection
