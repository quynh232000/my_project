@extends('layout.app')
@section('view_title')
    Quản trị sản phẩm
@endsection

@section('main')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center mb-3">
                <div class="col-sm mb-2 mb-sm-0">
                    <h1 class="page-header-title">Sản phẩm <span
                            class="badge badge-soft-dark ml-2">{{ $data->total() }}</span></h1>

                    <div class="mt-2">

                        <a class="text-body" href="javascript:;" data-toggle="modal" data-target="#importProductsModal">
                            <i class="tio-publish mr-1"></i> Xuất
                        </a>
                    </div>
                </div>

                <div class="col-sm-auto">
                    <a class="btn btn-primary" href="{{ route('product.add') }}"> <i class="fa-solid fa-plus"></i>Thêm sản
                        phẩm mới</a>
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
                <ul class="nav nav-tabs page-header-tabs" id="pageHeaderTab" role="tablist">
                    @php
                        $navs = [
                            ['link' => 'all', 'name' => 'Tất cả'],
                            ['link' => 'pending', 'name' => 'Chờ duyệt'],
                            ['link' => 'active', 'name' => 'Hoạt động'],
                            ['link' => 'deny', 'name' => 'Từ chối'],
                        ];
                    @endphp
                    @foreach ($navs as $item)
                        <li class="nav-item">
                            <a class="nav-link {{ str_contains($type, $item['link']) ? 'active' : '' }}"
                                href="{{ route('product.list', ['type' => $item['link']]) }}">{{ $item['name'] }} </a>
                        </li>
                    @endforeach

                </ul>
                <!-- End Nav -->
            </div>
            <!-- End Nav Scroller -->
        </div>
        <!-- End Page Header -->

        <div class="row justify-content-end mb-3">
            <div class="col-lg">
                <!-- Datatable Info -->
                <div id="datatableCounterInfo" style="display: none;">
                    <div class="d-sm-flex justify-content-lg-end align-items-sm-center">
                        <span class="d-block d-sm-inline-block font-size-sm mr-3 mb-2 mb-sm-0">
                            <span id="datatableCounter">0</span>
                            Selected
                        </span>
                        <a class="btn btn-sm btn-outline-danger mb-2 mb-sm-0 mr-2" href="javascript:;">
                            <i class="tio-delete-outlined"></i> Delete
                        </a>
                        <a class="btn btn-sm btn-white mb-2 mb-sm-0 mr-2" href="javascript:;">
                            <i class="tio-archive"></i> Archive
                        </a>
                        <a class="btn btn-sm btn-white mb-2 mb-sm-0 mr-2" href="javascript:;">
                            <i class="tio-publish"></i> Publish
                        </a>
                        <a class="btn btn-sm btn-white mb-2 mb-sm-0" href="javascript:;">
                            <i class="tio-clear"></i> Unpublish
                        </a>
                    </div>
                </div>
                <!-- End Datatable Info -->
            </div>
        </div>
        <!-- End Row -->

        <!-- Card -->
        <div class="card">
            <!-- Header -->
            <div class="card-header">
                <div class="row justify-content-between align-items-center flex-grow-1">
                    <div class="col-md-4 mb-3 mb-md-0">
                        <form>
                            <!-- Search -->
                            <div class="input-group input-group-merge input-group-flush d-flex">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="tio-search"></i>
                                    </div>
                                </div>
                                <input id="" type="search" name="search" value="{{ request()->search }}"
                                    class="form-control" placeholder="Tìm kiếm.." aria-label="Tìm kiếm..">
                                <button class="btn btn-sm btn-warning">Tìm</button>
                            </div>
                            <!-- End Search -->
                        </form>
                    </div>

                    <div>
                        <a href="{{ route('product.update_status_all', ['status' => 'DENY']) }}"
                            class="btn btn-sm btn-danger">Từ chối tất cả</a>
                        <a href="{{ route('product.update_status_all', ['status' => 'ACTIVE']) }}"
                            class="btn btn-sm btn-success">Duyệt tất cả</a>
                    </div>
                </div>
                <!-- End Row -->
            </div>
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
            <!-- End Header -->

            <!-- Table -->
            <div class="table-responsive datatable-custom">
                <table id="datatable"
                    class="table table-borderless table-thead-bordered table-nowrap table-align-middle card-table"
                    data-hs-datatables-options='{
                 "columnDefs": [{
                    "targets": [0, 4, 9],
                    "width": "5%",
                    "orderable": false
                  }],
                 "order": [],
                 "info": {
                   "totalQty": "#datatableWithPaginationInfoTotalQty"
                 },
                 "search": "#datatableSearch",
                 "entries": "#datatableEntries",
                 "pageLength": 12,
                 "isResponsive": false,
                 "isShowPaging": false,
                 "pagination": "datatablePagination"
               }'>
                    <thead class="thead-light">
                        <tr>
                            <th scope="col" class="table-column-pr-0">
                                <div class="custom-control custom-checkbox">
                                    <input id="datatableCheckAll" type="checkbox" class="custom-control-input">
                                    <label class="custom-control-label" for="datatableCheckAll"></label>
                                </div>
                            </th>
                            <th class="table-column-pl-0">Sản phẩm</th>
                            {{-- <th>Danh mục</th> --}}
                            <th>Cửa hàng</th>
                            <th>Hiển thị</th>
                            <th>Giá</th>
                            <th>Số lượng</th>
                            <th>Trạng thái</th>
                            <th>Hành động</th>
                            {{-- <th>Ngày tạo</th> --}}
                        </tr>
                    </thead>

                    <tbody class="text-sm" style=" font-size:13px">
                        @forelse ($data as $product)
                            <tr>
                                <td class="">
                                    <div class="custom-control custom-checkbox me-2"
                                        style="min-width: 24px;text-align:left">
                                        #{{ $product->id }}
                                    </div>
                                </td>
                                <td class="table-column-pl-0 ps-2">
                                    <a class="media align-items-center"
                                        href="{{ route('product.update', ['id' => $product->id]) }}">
                                        <img class="avatar avatar-lg mr-3" style="object-fit: cover"
                                            src="{{ $product->image }}" alt="Image Description">
                                        <div class="media-body">
                                            <h5 class="text-hover-primary mb-0 overflow-hidden" style="max-width: 240px;">{{ $product->name }}</h5>
                                            <div class="mt-2">{{ $product->category->name }}</div>
                                        </div>
                                    </a>
                                </td>
                                {{-- <td>{{ $product->category->name }}</td> --}}
                                <td>
                                    <div>
                                        <div>Shop: <span class="text-success">{{ $product->shop->name }}</span>
                                        </div>
                                        <div>User: {{ $product->shop->user->full_name }}</div>
                                    </div>
                                </td>
                                <td>
                                    <form id="form_published{{ $product->id }}" method="POST"
                                        action="{{ route('product.update_publish', ['product_id' => $product->id]) }}">
                                        @csrf
                                        <label class="toggle-switch toggle-switch-sm"
                                            for="stocksCheckbox1{{ $product->id }}">
                                            <input type="checkbox" class="toggle-switch-input"
                                                id="stocksCheckbox1{{ $product->id }}"
                                                {{ $product->is_published ? 'checked' : '' }}>
                                            <span class="toggle-switch-label">
                                                <span class="toggle-switch-indicator"></span>
                                            </span>
                                            <script>
                                                $('#stocksCheckbox1'+{{ $product->id }}).change(function() {
                                                    const formid = {{ $product->id }} + '';
                                                    $('#form_published' + formid).submit()
                                                })
                                            </script>
                                        </label>
                                    </form>
                                    
                                </td>
                                <td>{{ number_format($product->price, 0, ',', '.') }}đ</td>
                                <td>{{ $product->stock }}</td>
                                <td>
                                    @if ($product->status == 'PENDING')
                                        <span class="badge badge-primary">{{ ('Mới') }}</span>
                                    @endif
                                    @if ($product->status == 'ACTIVE')
                                        <span class="badge badge-success">{{ ('Đã duyệt') }}</span>
                                    @endif
                                    @if ($product->status == 'DENY')
                                        <span class="badge badge-danger">{{ ('Từ chối') }}</span>
                                    @endif
                                    <div>
                                        <small>Tạo: {{ $product->created_at }}</small>
                                    </div>
                                </td>
                               
                                <td>
                                    <div class="btn-group" role="group">
                                        <a class="btn btn-sm btn-white"
                                            href="{{ route('product.update', ['id' => $product->id]) }}">
                                            <i class="tio-edit"></i> Sửa
                                        </a>

                                        <!-- Unfold -->
                                        <div class="hs-unfold btn-group">
                                            <a class="js-hs-unfold-invoker btn btn-icon btn-sm btn-white dropdown-toggle dropdown-toggle-empty"
                                                href="javascript:;"
                                                data-hs-unfold-options='{
                                                    "target": "#productsEditDropdown1{{ $product->id }}",
                                                    "type": "css-animation",
                                                    "smartPositionOffEl": "#datatable"
                                                }'></a>
                                            <div id="productsEditDropdown1{{ $product->id }}"
                                                class="hs-unfold-content dropdown-unfold dropdown-menu dropdown-menu-right mt-1">
                                                <a class="dropdown-item"
                                                    href="{{ route('product.delete', ['id' => $product->id]) }}">
                                                    <i class="tio-delete-outlined dropdown-item-icon"></i> Xóa
                                                </a>
                                                @if ($product->status == 'PENDING')
                                                    <a class="dropdown-item"
                                                        href="{{ route('product.update_status', ['product_id' => $product->id, 'status' => 'ACTIVE']) }}">
                                                        <i class="tio-publish dropdown-item-icon"></i>Duyệt
                                                    </a>
                                                    <a class="dropdown-item"
                                                        href="{{ route('product.update_status', ['product_id' => $product->id, 'status' => 'DENY']) }}">
                                                        <i class="tio-clear dropdown-item-icon"></i> Từ chối
                                                    </a>
                                                @endif
                                                @if ($product->status == 'DENY')
                                                    <a class="dropdown-item"
                                                        href="{{ route('product.update_status', ['product_id' => $product->id, 'status' => 'ACTIVE']) }}">
                                                        <i class="tio-publish dropdown-item-icon"></i>Duyệt lại
                                                    </a>
                                                @endif
                                                @if ($product->deleted_at)
                                                    <a class="dropdown-item"
                                                        href="{{ route('product.restore', ['product_id' => $product->id]) }}">
                                                        <i class="tio-archive dropdown-item-icon"></i> Khôi phục
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                        <!-- End Unfold -->
                                    </div>
                                </td>
                                {{-- <td> <small>{{ $product->created_at }}</small></td> --}}
                            </tr>

                        @empty
                            <tr>
                                <td colspan="10" class="text-center py-5 text-danger">
                                    <div class="font-bold">
                                        Không tìm thấy dữ liệu nào!
                                    </div>
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
                    <div class="col-sm mb-2 mb-sm-0">
                        <div class="d-flex justify-content-center justify-content-sm-start align-items-center">
                            <span class="mr-2">Showing:</span>

                            {{ $data->links() }}
                        </div>
                    </div>

                    <div class="col-sm-auto">
                        <div class="d-flex justify-content-center justify-content-sm-end">
                            <!-- Pagination -->
                            <nav id="datatablePagination" aria-label="Activity pagination"></nav>
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
@push('js2')
@endpush
