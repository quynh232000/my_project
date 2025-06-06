@extends('layout.app')
@section('view_title')
    Cài đặt chung
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
                            <li class="breadcrumb-item"><a class="breadcrumb-link" href="javascript:;">Cài đặt chung</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Danh sách cài chung</li>
                        </ol>
                    </nav>

                    <h1 class="page-header-title">Cài đặt chung ({{ $data->total() }})</h1>
                </div>

            </div>
            <!-- End Row -->
        </div>
        <!-- End Page Header -->
        <div class="row">
            <div class="col-12">
                @if (session('error'))
                    <div class="alert alert-danger py-2">{{ session('error') }}</div>
                @endif
                @if (session('success'))
                    <div class="alert alert-success py-2">{{ session('success') }}</div>
                @endif
            </div>
        </div>
        <div class="card mb-3 mb-lg-5">
            <!-- Header -->
            <div class="card-header">
                <h4 class="card-header-title">{{ isset($setting) ? 'Cập nhật thông tin' : 'Thêm cài đặt' }} </h4>
            </div>
            <!-- End Header -->

            <!-- Body -->
            @if (isset($setting))
                <form method="post" action="{{ route('settings._update', ['id' => $setting->id]) }}" class="card-body">
                    <!-- Form Group -->
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="" class="input-label">Loại</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" value="{{ old('type') ?? $setting->type }}"
                                        name="type" id="" placeholder="" aria-label="">
                                </div>
                                @error('type')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="" class="input-label">Tên</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" value="{{ old('key') ?? $setting->key }}"
                                        name="key" id="" placeholder="" aria-label="">
                                </div>
                                @error('key')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="" class="input-label">Giá trị</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" value="{{ old('value') ?? $setting->value }}"
                                        name="value" id="" placeholder="" aria-label="">
                                </div>
                                @error('value')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="" class="input-label">Mô tả</label>
                                <div class="input-group">
                                    <input type="text" class="form-control"
                                        value="{{ old('description') ?? $setting->description }}" name="description"
                                        id="" placeholder="" aria-label="">
                                </div>
                                @error('description')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary">Cập nhật thông tin</button>
                            <a href="{{ route('settings') }}" class="btn btn-warning">Tạo mới</a>
                        </div>
                    </div>


                </form>
            @else
                <form method="post" action="{{ route('settings.add_new') }}" class="card-body">
                    <!-- Form Group -->
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="" class="input-label">Loại</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" value="{{ old('type') }}" name="type"
                                        id="" placeholder="" aria-label="">
                                </div>
                                @error('type')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="" class="input-label">Tên</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" value="{{ old('key') }}"
                                        name="key" id="" placeholder="" aria-label="">
                                </div>
                                @error('key')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="" class="input-label">Giá trị</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" value="{{ old('value') }}"
                                        name="value" id="" placeholder="" aria-label="">
                                </div>
                                @error('value')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="" class="input-label">Mô tả</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" value="{{ old('description') }}"
                                        name="description" id="" placeholder="" aria-label="">
                                </div>
                                @error('description')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary">{{ 'Thêm cài đặt' }}</button>
                        </div>
                    </div>


                </form>
            @endif
            <!-- Body -->
        </div>

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
                            <th class="table-column-pl-0">tYPE</th>
                            <th>Key</th>
                            <th>Value</th>
                            <th class="text-end">
                                <div class="w-100 text-right">Hành động</div>
                            </th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($data as $item)
                            <tr>
                                <td class="table-column-pr-0">
                                    {{ $item->id }}

                                </td>
                                <td title="{{ $item->description }}" class="table-column-pr-0">
                                    {{ $item->type }}

                                </td>
                                <td class="table-column-pl-0">
                                    {{ $item->key }}
                                </td>
                                <td>
                                    {{ $item->value }}
                                </td>
                                <td>
                                    <div class="d-flex justify-content-end">
                                        <a title="Sửa" href="{{ route('settings.update', ['id' => $item->id]) }}"
                                            class="btn btn-sm btn-info"><i class="fa-solid fa-pen-to-square"></i></a>
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
