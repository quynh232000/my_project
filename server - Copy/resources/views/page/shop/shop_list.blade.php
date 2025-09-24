@extends('layout.app')
@section('view_title')
    Danh sách cửa hàng
@endsection

@section('main')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center mb-3">
                <div class="col-sm mb-2 mb-sm-0">
                    <h1 class="page-header-title">Danh sách cửa hàng <span
                            class="badge badge-soft-dark ml-2">{{ $data->total() }}</span></h1>

                    <div class="mt-2">
                        {{-- <a class="text-body mr-3" href="javascript:;" data-toggle="modal" data-target="#importCustomersModal">
                            <i class="tio-publish mr-1"></i> Xuất danh sách
                        </a> --}}


                        <!-- Unfold -->
                        {{-- <div class="hs-unfold">
                            <a class="js-hs-unfold-invoker text-body" href="javascript:;"
                                data-hs-unfold-options='{
                   "target": "#moreOptionsDropdown",
                   "type": "css-animation"
                 }'>
                                More options <i class="tio-chevron-down"></i>
                            </a>

                            <div id="moreOptionsDropdown" class="hs-unfold-content dropdown-unfold dropdown-menu mt-1">
                                <a class="dropdown-item" href="#">
                                    <i class="tio-copy dropdown-item-icon"></i> Manage duplicates
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="tio-edit dropdown-item-icon"></i> Edit users
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="tio-restore dropdown-item-icon"></i> Restore clients
                                </a>
                            </div>
                        </div> --}}
                        <!-- End Unfold -->
                    </div>
                </div>

                <div class="col-sm-auto">
                    {{-- <a class="btn btn-primary" href="{{ route('shop.add') }}">Thêm cửa hàng mới</a> --}}
                </div>
            </div>
        </div>
        <!-- End Page Header -->

        <!-- Card -->
        <div class="card">
            <!-- Body -->
            <div class="card-body">
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
                                <input id="datatableSearch" value="{{request()->search}}" type="search" name="search" class="form-control"
                                    placeholder="Tìm kiếm" aria-label="Search orders">
                                <button type="submit" class="btn btn-sm btn-warning">Tìm</button>
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
                            <form class="d-flex">
                                @php
                                    $sort=[
                                        ['key'=>'product','name'=>'Sản phẩm nhiều nhất'],
                                        ['key'=>'-product','name'=>'Sản phẩm ít nhất'],
                                        ['key'=>'latest','name'=>'Mới nhất'],
                                        ['key'=>'oldest','name'=>'Cũ nhất'],
                                    ];

                                @endphp
                                <select class="form-control" name="sort" id="">
                                    <option value="">--Sắp xếp--</option>
                                    @foreach ($sort as $item)
                                    <option value="{{$item['key']}}" {{request()->sort == $item['key']?'selected':''}}>{{$item['name']}}</option>

                                    @endforeach

                                </select>
                                <button style="margin-left: 5px" class="btn btn-sm btn-warning ms-2">Sort</button>
                            </form>
                            <!-- End Unfold -->
                        </div>
                    </div>
                </div>
                <!-- End Row -->
            </div>
            <!-- End Body -->

            <!-- Table -->
            <div class="table-responsive datatable-custom">
                <table
                    class="table table-lg table-borderless table-thead-bordered table-nowrap table-align-middle card-table"
                   >
                    <thead class="thead-light">
                        <tr>
                            <th scope="col" class="table-column-pr-0">
                                <div class="custom-control custom-checkbox">
                                    #
                                </div>
                            </th>
                            <th class="table-column-pl-0">Cửa hàng</th>
                            <th>Người dùng</th>
                            <th>Liên hệ</th>
                            <th>Sản phẩm</th>
                            <th>Trạng thái</th>
                            <th>Doanh số</th>
                            <th>Ngày tạo</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($data as $item)
                            <tr>
                                <td class="table-column-pr-0">
                                    <div class="custom-control custom-checkbox mr-5">

                                        <label class="custom-control-label" for="">{{ $item->id }}</label>
                                    </div>
                                </td>
                                <td class="table-column-pl-0">
                                    <a class="d-flex align-items-center"
                                        href="{{ route('shop.detail', ['slug' => $item->slug]) }}">
                                        <div class="avatar avatar-circle">
                                            <img class="avatar-img"
                                                src="{{ $item->logo && $item->logo != '' ? $item->logo : asset('assets/img/quin/shop.png') }}"
                                                alt="Image Description">
                                        </div>
                                        <div class="ml-3">
                                            <span class="h5 text-hover-primary">{{ $item->name }}
                                                {{-- <i
                                                    class="tio-verified text-primary" data-toggle="tooltip"
                                                    data-placement="top" title="Top endorsed"></i> --}}
                                            </span>
                                        </div>
                                    </a>
                                </td>
                                <td>
                                    <div>{{ $item->user->full_name }}</div>
                                    <div>{{ $item->user->email }}</div>
                                </td>
                                <td>{{ $item->phone_number ?? '-' }}</td>
                                <td>{{ $item->product_count() }}</td>
                                <td>
                                    @if ($item->deleted_at)
                                        <span class="legend-indicator bg-danger"></span> Đã khóa
                                    @else
                                        <span class="legend-indicator bg-success"></span> Hoạt động
                                    @endif

                                </td>
                                <td>
                                    <strong class="text-primary">{{number_format($item->money(),0,',','.')}}</strong> đ</td>
                                <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d/m/Y H:i:s') }}</td>
                            </tr>

                        @empty
                            <tr>
                                <td colspan="9" class="text-center py-5 text-danger">Không tìm thấy dữ liệu nào!</td>
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
