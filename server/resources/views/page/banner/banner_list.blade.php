@extends('layout.app')
@section('view_title')
    Danh sách banners
@endsection
@section('main')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center mb-3">
                <div class="col-sm mb-2 mb-sm-0">
                    <h1 class="page-header-title">Danh sách Banners </h1>


                </div>

                <div class="col-sm-auto">
                    <a class="btn btn-primary" href="{{ route('banner.add') }}">Thêm Banner</a>
                </div>
            </div>
            <!-- End Row -->


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
                            <div class="input-group input-group-merge input-group-flush">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="tio-search"></i>
                                    </div>
                                </div>
                                <input id="datatableSearch" type="search" class="form-control" placeholder="Tìm kiếm.."
                                    aria-label="Search users">
                            </div>
                            <!-- End Search -->
                        </form>
                    </div>

                    <div class="col-auto">
                        <!-- Unfold -->
                        <div class="hs-unfold mr-2">
                            <a class="js-hs-unfold-invoker btn btn-white" href="javascript:;"
                                data-hs-unfold-options='{
                  "target": "#datatableFilterSidebar",
                  "type": "css-animation",
                  "animationIn": "fadeInRight",
                  "animationOut": "fadeOutRight",
                  "hasOverlay": true,
                  "smartPositionOff": true
                 }'>
                                <i class="tio-filter-list mr-1"></i> Filters
                            </a>
                        </div>
                        <!-- End Unfold -->

                        <!-- Unfold -->
                        <div class="hs-unfold">
                            <a class="js-hs-unfold-invoker btn btn-white" href="javascript:;"
                                data-hs-unfold-options='{
                   "target": "#showHideDropdown",
                   "type": "css-animation"
                 }'>
                                <i class="tio-table mr-1"></i> Columns <span
                                    class="badge badge-soft-dark rounded-circle ml-1">6</span>
                            </a>

                            <div id="showHideDropdown"
                                class="hs-unfold-content dropdown-unfold dropdown-menu dropdown-menu-right dropdown-card"
                                style="width: 15rem;">
                                <div class="card card-sm">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <span class="mr-2">Product</span>

                                            <!-- Checkbox Switch -->
                                            <label class="toggle-switch toggle-switch-sm" for="toggleColumn_product">
                                                <input type="checkbox" class="toggle-switch-input" id="toggleColumn_product"
                                                    checked="">
                                                <span class="toggle-switch-label">
                                                    <span class="toggle-switch-indicator"></span>
                                                </span>
                                            </label>
                                            <!-- End Checkbox Switch -->
                                        </div>

                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <span class="mr-2">Type</span>

                                            <!-- Checkbox Switch -->
                                            <label class="toggle-switch toggle-switch-sm" for="toggleColumn_type">
                                                <input type="checkbox" class="toggle-switch-input" id="toggleColumn_type"
                                                    checked="">
                                                <span class="toggle-switch-label">
                                                    <span class="toggle-switch-indicator"></span>
                                                </span>
                                            </label>
                                            <!-- End Checkbox Switch -->
                                        </div>

                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <span class="mr-2">Vendor</span>

                                            <!-- Checkbox Switch -->
                                            <label class="toggle-switch toggle-switch-sm" for="toggleColumn_vendor">
                                                <input type="checkbox" class="toggle-switch-input" id="toggleColumn_vendor">
                                                <span class="toggle-switch-label">
                                                    <span class="toggle-switch-indicator"></span>
                                                </span>
                                            </label>
                                            <!-- End Checkbox Switch -->
                                        </div>

                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <span class="mr-2">Stocks</span>

                                            <!-- Checkbox Switch -->
                                            <label class="toggle-switch toggle-switch-sm" for="toggleColumn_stocks">
                                                <input type="checkbox" class="toggle-switch-input" id="toggleColumn_stocks"
                                                    checked="">
                                                <span class="toggle-switch-label">
                                                    <span class="toggle-switch-indicator"></span>
                                                </span>
                                            </label>
                                            <!-- End Checkbox Switch -->
                                        </div>

                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <span class="mr-2">SKU</span>

                                            <!-- Checkbox Switch -->
                                            <label class="toggle-switch toggle-switch-sm" for="toggleColumn_sku">
                                                <input type="checkbox" class="toggle-switch-input" id="toggleColumn_sku"
                                                    checked="">
                                                <span class="toggle-switch-label">
                                                    <span class="toggle-switch-indicator"></span>
                                                </span>
                                            </label>
                                            <!-- End Checkbox Switch -->
                                        </div>

                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <span class="mr-2">Price</span>

                                            <!-- Checkbox Switch -->
                                            <label class="toggle-switch toggle-switch-sm" for="toggleColumn_price">
                                                <input type="checkbox" class="toggle-switch-input"
                                                    id="toggleColumn_price" checked="">
                                                <span class="toggle-switch-label">
                                                    <span class="toggle-switch-indicator"></span>
                                                </span>
                                            </label>
                                            <!-- End Checkbox Switch -->
                                        </div>

                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <span class="mr-2">Quantity</span>

                                            <!-- Checkbox Switch -->
                                            <label class="toggle-switch toggle-switch-sm" for="toggleColumn_quantity">
                                                <input type="checkbox" class="toggle-switch-input"
                                                    id="toggleColumn_quantity">
                                                <span class="toggle-switch-label">
                                                    <span class="toggle-switch-indicator"></span>
                                                </span>
                                            </label>
                                            <!-- End Checkbox Switch -->
                                        </div>

                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="mr-2">Variants</span>

                                            <!-- Checkbox Switch -->
                                            <label class="toggle-switch toggle-switch-sm" for="toggleColumn_variants">
                                                <input type="checkbox" class="toggle-switch-input"
                                                    id="toggleColumn_variants" checked="">
                                                <span class="toggle-switch-label">
                                                    <span class="toggle-switch-indicator"></span>
                                                </span>
                                            </label>
                                            <!-- End Checkbox Switch -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End Unfold -->
                    </div>
                </div>
                <!-- End Row -->
            </div>
            <!-- End Header -->

            <!-- Table -->
            <div class="table-responsive datatable-custom">
                <table
                    id="datatable"
                    class="table table-borderless table-thead-bordered table-nowrap table-align-middle card-table"
                   >
                    <thead class="thead-light">
                        <tr>
                            <th>ID</th>


                            <th class="table-column-pl-0">Tiêu đề</th>
                            <th>Vị trí</th>
                            <th>Hiện</th>
                            <th>Ngày hết hạn</th>
                            <th>Ngày tạo</th>
                            <th>Từ</th>
                            <th>
                                Hành động
                            </th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($data as $item)
                            <tr>
                                <td class="pr-2">{{ $item->id }}</td>

                                <td class="table-column-pl-0">
                                    <a class="media align-items-center" href="ecommerce-product-details.html">
                                        <img class="avatar avatar-lg mr-3" style="object-fit: cover; width:120px" src="{{ $item->banner_url }}"
                                            alt="Image Description">
                                        <div class="media-body">
                                            <h5 class="text-hover-primary mb-0">{{ $item->title }}</h5>
                                            <div>
                                                {{$item->user->shop->name}}
                                            </div>
                                        </div>
                                    </a>

                                </td>
                                <td>{{ $item->placement }}</td>
                                <td>
                                    <label class="toggle-switch toggle-switch-sm" for="stocksCheckbox1">
                                        <input type="checkbox" class="toggle-switch-input" id="stocksCheckbox1"
                                            {{ $item->is_show ? 'checked' : '' }}>
                                        <span class="toggle-switch-label">
                                            <span class="toggle-switch-indicator"></span>
                                        </span>
                                    </label>
                                </td>
                                <td>{{ explode(' ', $item->expired_at)[0] }}</td>
                                <td>{{ explode(' ', $item->created_at)[0] }}</td>
                                <td>{{ strtoupper($item->from) }}</td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a class="btn btn-sm btn-white" href="{{route('banner.update',['id'=>$item->id])}}">
                                            <i class="tio-edit"></i> Edit
                                        </a>
                                        <!-- Unfold -->
                                        <div class="hs-unfold btn-group">
                                            <a class="js-hs-unfold-invoker btn btn-icon btn-sm btn-white dropdown-toggle dropdown-toggle-empty"
                                                href="javascript:;"
                                                data-hs-unfold-options='{
                                                    "target": "#productsEditDropdown{{$item->id}}",
                                                    "type": "css-animation",
                                                    "smartPositionOffEl": "#datatable"
                                                }'></a>

                                            <div id="productsEditDropdown{{$item->id}}"
                                                class="hs-unfold-content dropdown-unfold dropdown-menu dropdown-menu-right mt-1">


                                                <a class="dropdown-item"
                                                    href="{{ route('banner.update', ['id' => $item->id]) }}">
                                                    <i class="tio-publish dropdown-item-icon"></i> Sửa
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
                                <td class="text-danger text-center" colspan="8">Không tìm thấy dữ liệu</td>
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
                            <span class="mr-2">Hiện thị:</span>
                           {{$data->links()}}
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
