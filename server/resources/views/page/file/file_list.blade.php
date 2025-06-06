@extends('layout.app')
@section('view_title')
    Thư viện
@endsection
@push('js1')
    <script>
        function handleCopy(text) {
            navigator.clipboard.writeText(text).then(function() {
                alert('Đã Copy đường dẫn thành công!');
            }, function(err) {
                alert('Lỗi khi Copy: ', err);
            });
        }
    </script>
@endpush
@section('main')
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-sm mb-2 mb-sm-0">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-no-gutter">
                            <li class="breadcrumb-item"><a class="breadcrumb-link" href="javascript:;">Quản trị</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Files</li>
                        </ol>
                    </nav>

                    <h1 class="page-header-title">Thư viện</h1>
                </div>
                <div class="col-sm-auto">
                    <a class="btn btn-primary" href="{{ route('file.add') }}">
                        <i class="tio-user-add mr-1"></i> Thêm ảnh mới
                    </a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card mb-3 mb-lg-5">
                    <div class="card-body">
                        <ul class="nav nav-tabs mb-4">
                            <li class="nav-item">
                                <a class="nav-link {{ $type == '' ? 'active' : '' }}" href="{{ route('file.list') }}">Tất
                                    cả</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ $type == 'image' ? 'active' : '' }}" href="?type=image">Hình ảnh</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ $type == 'video' ? 'active' : '' }}" href="?type=video">Video</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ $type == 'file' ? 'active' : '' }}" href="?type=file">File</a>
                            </li>

                        </ul>
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
                                        <input id="datatableSearch" type="search" class="form-control"
                                            placeholder="Tìm kiếm" aria-label="Tìm kiếm">
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
                                        <a class="js-hs-unfold-invoker btn btn-sm btn-white dropdown-toggle"
                                            href="javascript:;"
                                            data-hs-unfold-options='{
                                   "target": "#usersExportDropdown",
                                   "type": "css-animation"
                                 }'>
                                            <i class="tio-download-to mr-1"></i> Export
                                        </a>

                                        <div id="usersExportDropdown"
                                            class="hs-unfold-content dropdown-unfold dropdown-menu dropdown-menu-sm-right">
                                            <span class="dropdown-header">Options</span>
                                            <a id="export-copy" class="dropdown-item" href="javascript:;">
                                                <img class="avatar avatar-xss avatar-4by3 mr-2"
                                                    src="assets\svg\illustrations\copy.svg" alt="Image Description">
                                                Copy
                                            </a>
                                            <a id="export-print" class="dropdown-item" href="javascript:;">
                                                <img class="avatar avatar-xss avatar-4by3 mr-2"
                                                    src="assets\svg\illustrations\print.svg" alt="Image Description">
                                                Print
                                            </a>
                                            <div class="dropdown-divider"></div>
                                            <span class="dropdown-header">Download options</span>
                                            <a id="export-excel" class="dropdown-item" href="javascript:;">
                                                <img class="avatar avatar-xss avatar-4by3 mr-2"
                                                    src="assets\svg\brands\excel.svg" alt="Image Description">
                                                Excel
                                            </a>
                                            <a id="export-csv" class="dropdown-item" href="javascript:;">
                                                <img class="avatar avatar-xss avatar-4by3 mr-2"
                                                    src="assets\svg\components\placeholder-csv-format.svg"
                                                    alt="Image Description">
                                                .CSV
                                            </a>
                                            <a id="export-pdf" class="dropdown-item" href="javascript:;">
                                                <img class="avatar avatar-xss avatar-4by3 mr-2"
                                                    src="assets\svg\brands\pdf.svg" alt="Image Description">
                                                PDF
                                            </a>
                                        </div>
                                    </div>
                                    <!-- End Unfold -->

                                    <!-- Unfold -->
                                    <div class="hs-unfold">
                                        <a class="js-hs-unfold-invoker btn btn-sm btn-white" href="javascript:;"
                                            data-hs-unfold-options='{
                                   "target": "#showHideDropdown",
                                   "type": "css-animation"
                                 }'>
                                            <i class="tio-table mr-1"></i> Columns <span
                                                class="badge badge-soft-dark rounded-circle ml-1">7</span>
                                        </a>

                                        <div id="showHideDropdown"
                                            class="hs-unfold-content dropdown-unfold dropdown-menu dropdown-menu-right dropdown-card"
                                            style="width: 15rem;">
                                            <div class="card card-sm">
                                                <div class="card-body">
                                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                                        <span class="mr-2">Order</span>

                                                        <!-- Checkbox Switch -->
                                                        <label class="toggle-switch toggle-switch-sm"
                                                            for="toggleColumn_order">
                                                            <input type="checkbox" class="toggle-switch-input"
                                                                id="toggleColumn_order" checked="">
                                                            <span class="toggle-switch-label">
                                                                <span class="toggle-switch-indicator"></span>
                                                            </span>
                                                        </label>
                                                        <!-- End Checkbox Switch -->
                                                    </div>

                                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                                        <span class="mr-2">Date</span>

                                                        <!-- Checkbox Switch -->
                                                        <label class="toggle-switch toggle-switch-sm"
                                                            for="toggleColumn_date">
                                                            <input type="checkbox" class="toggle-switch-input"
                                                                id="toggleColumn_date" checked="">
                                                            <span class="toggle-switch-label">
                                                                <span class="toggle-switch-indicator"></span>
                                                            </span>
                                                        </label>
                                                        <!-- End Checkbox Switch -->
                                                    </div>

                                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                                        <span class="mr-2">Customer</span>

                                                        <!-- Checkbox Switch -->
                                                        <label class="toggle-switch toggle-switch-sm"
                                                            for="toggleColumn_customer">
                                                            <input type="checkbox" class="toggle-switch-input"
                                                                id="toggleColumn_customer" checked="">
                                                            <span class="toggle-switch-label">
                                                                <span class="toggle-switch-indicator"></span>
                                                            </span>
                                                        </label>
                                                        <!-- End Checkbox Switch -->
                                                    </div>

                                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                                        <span class="mr-2">Payment status</span>

                                                        <!-- Checkbox Switch -->
                                                        <label class="toggle-switch toggle-switch-sm"
                                                            for="toggleColumn_payment_status">
                                                            <input type="checkbox" class="toggle-switch-input"
                                                                id="toggleColumn_payment_status" checked="">
                                                            <span class="toggle-switch-label">
                                                                <span class="toggle-switch-indicator"></span>
                                                            </span>
                                                        </label>
                                                        <!-- End Checkbox Switch -->
                                                    </div>

                                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                                        <span class="mr-2">Fulfillment status</span>

                                                        <!-- Checkbox Switch -->
                                                        <label class="toggle-switch toggle-switch-sm"
                                                            for="toggleColumn_fulfillment_status">
                                                            <input type="checkbox" class="toggle-switch-input"
                                                                id="toggleColumn_fulfillment_status">
                                                            <span class="toggle-switch-label">
                                                                <span class="toggle-switch-indicator"></span>
                                                            </span>
                                                        </label>
                                                        <!-- End Checkbox Switch -->
                                                    </div>

                                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                                        <span class="mr-2">Payment method</span>

                                                        <!-- Checkbox Switch -->
                                                        <label class="toggle-switch toggle-switch-sm"
                                                            for="toggleColumn_payment_method">
                                                            <input type="checkbox" class="toggle-switch-input"
                                                                id="toggleColumn_payment_method" checked="">
                                                            <span class="toggle-switch-label">
                                                                <span class="toggle-switch-indicator"></span>
                                                            </span>
                                                        </label>
                                                        <!-- End Checkbox Switch -->
                                                    </div>

                                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                                        <span class="mr-2">Total</span>

                                                        <!-- Checkbox Switch -->
                                                        <label class="toggle-switch toggle-switch-sm"
                                                            for="toggleColumn_total">
                                                            <input type="checkbox" class="toggle-switch-input"
                                                                id="toggleColumn_total" checked="">
                                                            <span class="toggle-switch-label">
                                                                <span class="toggle-switch-indicator"></span>
                                                            </span>
                                                        </label>
                                                        <!-- End Checkbox Switch -->
                                                    </div>

                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <span class="mr-2">Actions</span>

                                                        <!-- Checkbox Switch -->
                                                        <label class="toggle-switch toggle-switch-sm"
                                                            for="toggleColumn_actions">
                                                            <input type="checkbox" class="toggle-switch-input"
                                                                id="toggleColumn_actions" checked="">
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
                        </div>
                    </div>
                </div>
            </div>
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
        <div class="row">
            <div class="col-12">
                <div class="card mb-3 mb-lg-5">
                    <!-- Header -->
                    <div class="card-header">
                        <h4 class="card-header-title">Thư viện ảnh ({{ $data->total() }})</h4>
                    </div>
                    <!-- End Header -->
                    <!-- Body -->
                    <div class="card-body">
                        <style>
                            .card-img-top {
                                height: 180px !important;
                                object-fit: cover
                            }
                            .cursor-pointer{
                                cursor:  !important;
                            }
                        </style>
                        <!-- Gallery -->
                        <div id="fancyboxGallery" class="js-fancybox row  gx-2">
                            @forelse ($data as $item)
                                <div class="col-6 col-sm-4 col-md-3 mb-3 mb-lg-5">
                                    <!-- Card -->
                                    <div class="card card-sm">
                                        <a href="{{ $item->url }}" target="__blank">
                                            @if (str_contains($item->type, 'image'))
                                                <img class="card-img-top" src="{{ $item->url }}"
                                                    alt="{{ $item->type }}">
                                            @elseif (str_contains($item->type, 'video'))
                                                <video controls class="card-img-top">
                                                    <source src="{{ $item->url }}" type="video/mp4">
                                                    <source src="{{ $item->url }}" type="video/ogg">
                                                    Your browser does not support the video tag.
                                                </video>
                                            @else
                                                <img class="card-img-top" src="{{ $item->url }}"
                                                    alt="{{ $item->type }}">
                                            @endif
                                        </a>
                                        <div class="px-2">
                                            <div class="d-flex justify-content-between mt-2">
                                                <small>Loại: <i class="text-primary">{{ $item->type ?? '--' }}</i></small>
                                                <small>Size: <i class="text-primary">{{round($item->size / 1024, 0) ?? '0' }}.KB</i></small>
                                            </div>
                                            <div>
                                                <small>Ngày tạo: <i class="text-primary">{{ explode(' ', $item->created_at)[0] }}</i></small>
                                            </div>
                                            <div>
                                                <small>Từ: <i class="text-primary">{{ $item->from ?? '--' }}</i></small>
                                            </div>
                                        </div>
                                        <div class="card-body ">
                                            <div class="row text-center">
                                                <div class="col cursor-pointer">
                                                    <div class="js-fancybox-item cursor-pointer text-body"
                                                        onclick="handleCopy('{{ $item->url }}')" data-toggle="tooltip"
                                                        data-placement="top" title="Copy"
                                                        >
                                                        <i class="fa-regular fa-copy"></i>
                                                    </div>
                                                </div>

                                                <div class="col column-divider">
                                                    <a class="text-danger"
                                                        onclick="return confirm('Bạn chắc là có muốn xóa chứ?')"
                                                        href="{{ route('file.delete', ['public_id' => $item->public_id]) }}"
                                                        data-toggle="tooltip" data-placement="top" title="Xóa">
                                                        <i class="tio-delete-outlined"></i>
                                                    </a>
                                                </div>
                                            </div>
                                            <!-- End Row -->
                                        </div>
                                    </div>
                                    <!-- End Card -->
                                </div>

                            @empty
                                <div class="text-danger py-5 text-center  w-100">Không tìm thấy dữ liệu nào!</div>
                            @endforelse


                        </div>
                        <!-- End Gallery -->


                    </div>
                    <!-- Body -->
                    <div>
                        {{ $data->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
