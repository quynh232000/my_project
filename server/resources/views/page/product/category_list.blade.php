@extends('layout.app')
@section('view_title')
    Danh mục
@endsection

@section('main')
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-sm mb-2 mb-sm-0">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-no-gutter">
                            <li class="breadcrumb-item"><a class="breadcrumb-link" href="javascript:;">Quản trị</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Vai trò</li>
                        </ol>
                    </nav>

                    <h1 class="page-header-title">Danh mục</h1>
                </div>
                <div class="col-sm-auto">
                    <a class="btn btn-primary" href="{{ route('product.category.list') }}">
                        <i class="tio-user-add mr-1"></i> Thêm danh mục mới
                    </a>
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
            <div class="col-lg-4">
                <!-- Card -->
                <div class="card mb-3 mb-lg-5">
                    <!-- Header -->
                    <div class="card-header">
                        <h4 class="card-header-title">{{ isset($category) ? 'Cập nhật danh mục' : 'Thêm danh mục mới' }}
                        </h4>
                    </div>
                    <!-- End Header -->

                    <!-- Body -->
                    @if (isset($category))
                        <form method="post" action="{{ route('product.category._update', ['id' => $category->id]) }}"
                            class="card-body" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="name" class="input-label">Tên <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="text" class="form-control" value="{{ old('name') ?? $category->name }}"
                                        name="name" id="name" placeholder="Váy nữ">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="name" class="input-label">Danh mục cha </label>
                                <div class="input-group">
                                    <select name="parent_id" class="select2-selection custom-select" id="">
                                        <option value="">--Trống--</option>
                                        @foreach ($categories as $item)
                                            @if ($item->id != $category->id)
                                                <option value="{{ $item->id }}"
                                                    {{ $category->parent_id == $item->id ? 'selected' : '' }}
                                                    class="ps-5 level-{{ $item->level }}">
                                                    {!! str_repeat('&nbsp;&nbsp;&nbsp;', $item->level) !!}{{ $item->name }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="commission_fee" class="input-label">Chiết khấu cho sàn <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="text" class="form-control" value="{{ old('commission_fee') ?? $category->commission_fee }}"
                                        name="commission_fee" id="commission_fee" placeholder="Váy nữ">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="name" class="input-label">Mô tả</label>
                                <div class="input-group">
                                    <textarea class="form-control" name="description" cols="30" rows="2" placeholder="Mô tả">{{ old('description') ?? $category->description }}</textarea>
                                </div>
                            </div>
                            <style>
                                #image-q {
                                    height: 180px;
                                    object-fit: cover
                                }
                            </style>
                            <!-- Form Group -->
                            <div class="form-group">
                                <label for="priceNameLabel" class="input-label">Icon</label>
                                <div class="input-group">
                                    <label for="imageInput" id="attachFilesNewProjectLabel"
                                        class="js-dropzone dropzone-custom custom-file-boxed">
                                        <div class="dz-message custom-file-boxed-label">
                                            <img id="imagePreview" style="object-fit: cover" class="avatar avatar-xl avatar-4by3 mb-3 object-fit-cover"
                                                src="{{ $category->icon_url ? $category->icon_url : asset('assets\svg\illustrations\browse.svg') }}"
                                                alt="Image Description">
                                            {{-- <h5 class="mb-1">Choose files to upload</h5>
                                            <p class="">or</p> --}}
                                            <div><label for="imageInput" class="btn btn-sm btn-success">Tải lên</label>
                                            </div>
                                        </div>
                                    </label>
                                    <input type="file" name="icon_url" hidden id="imageInput">
                                </div>
                            </div>
                            <script>
                                document.getElementById("imageInput").addEventListener("change", function(event) {
                                    const file = event.target.files[0];
                                    if (file) {
                                        const reader = new FileReader();
                                        reader.onload = function(e) {
                                            const imagePreview = document.getElementById("imagePreview");
                                            document.getElementById('attachFilesNewProjectLabel').innerHTML =
                                                `
                                            <img id="image-q" width="100%" src="${e.target.result}"/>
                                        `
                                            // imagePreview.src = e.target.result;
                                        };
                                        reader.readAsDataURL(file);
                                    }
                                });
                            </script>
                            <!-- Toggle Switch -->
                            <label class="row toggle-switch" for="availabilitySwitch1">
                                <span class="col-8 col-sm-9 toggle-switch-content">
                                    <span class="text-dark">Hiển thị</span>
                                </span>
                                <span class="col-4 col-sm-3">
                                    <input type="checkbox" class="toggle-switch-input" name="is_show"
                                        {{ $category->is_show ? 'checked' : '' }} id="availabilitySwitch1">
                                    <span class="toggle-switch-label ml-auto">
                                        <span class="toggle-switch-indicator"></span>
                                    </span>
                                </span>
                            </label>
                            <!-- End Toggle Switch -->
                            <hr class="my-4">
                            <div class="d-flex justify-content-center">
                                <button type="submit" class="btn btn-sm btn-primary w-100">Cập nhật</button>
                            </div>
                        </form>
                    @else
                        <form method="post" action="{{ route('product.category._add') }}" class="card-body"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="name" class="input-label">Tên <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="name" id="name"
                                        placeholder="Váy nữ">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="name" class="input-label">Danh mục cha </label>
                                <div class="input-group">
                                    {{-- <option class="level-1" value="46">&nbsp;&nbsp;&nbsp;tset1</option> --}}
                                    <select name="parent_id" class="select2-selection custom-select" id="">
                                        <option value="">--Trống--</option>
                                        @foreach ($categories as $item)
                                            <option value="{{ $item->id }}" class="ps-5 level-{{ $item->level }}">
                                                {!! str_repeat('&nbsp;&nbsp;&nbsp;', $item->level) !!}{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="commission_fee" class="input-label">Chiết khấu cho sàn <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="number" min="0" max="100" class="form-control" value="{{ old('commission_fee')??'5' }}"
                                        name="commission_fee" id="commission_fee" placeholder="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="name" class="input-label">Mô tả</label>
                                <div class="input-group">
                                    <textarea class="form-control" name="description" cols="30" rows="2" placeholder="Mô tả">{{ old('description') }}</textarea>
                                </div>
                            </div>
                            <style>
                                #image-q {
                                    height: 180px;
                                    object-fit: cover
                                }
                            </style>
                            <!-- Form Group -->
                            <div class="form-group">
                                <label for="priceNameLabel" class="input-label">Icon</label>
                                <div class="input-group">
                                    <label for="imageInput" id="attachFilesNewProjectLabel"
                                        class="js-dropzone dropzone-custom custom-file-boxed">
                                        <div class="dz-message custom-file-boxed-label">
                                            <img id="imagePreview" class="avatar avatar-xl avatar-4by3 mb-3"
                                                src="{{ asset('assets\svg\illustrations\browse.svg') }}"
                                                alt="Image Description">
                                            {{-- <h5 class="mb-1">Choose files to upload</h5>
                                            <p class="">or</p> --}}
                                            <div><label for="imageInput" class="btn btn-sm btn-success">Tải lên</label>
                                            </div>
                                        </div>
                                    </label>
                                    <input type="file" name="icon_url" hidden id="imageInput">
                                </div>
                            </div>
                            <script>
                                document.getElementById("imageInput").addEventListener("change", function(event) {
                                    const file = event.target.files[0];
                                    if (file) {
                                        const reader = new FileReader();
                                        reader.onload = function(e) {
                                            const imagePreview = document.getElementById("imagePreview");
                                            document.getElementById('attachFilesNewProjectLabel').innerHTML =
                                                `
                                            <img id="image-q" width="100%" src="${e.target.result}"/>
                                        `
                                            // imagePreview.src = e.target.result;
                                        };
                                        reader.readAsDataURL(file);
                                    }
                                });
                            </script>
                            <!-- Toggle Switch -->
                            <label class="row toggle-switch" for="availabilitySwitch1">
                                <span class="col-8 col-sm-9 toggle-switch-content">
                                    <span class="text-dark">Hiển thị</span>
                                </span>
                                <span class="col-4 col-sm-3">
                                    <input type="checkbox" class="toggle-switch-input" name="is_show" checked
                                        id="availabilitySwitch1">
                                    <span class="toggle-switch-label ml-auto">
                                        <span class="toggle-switch-indicator"></span>
                                    </span>
                                </span>
                            </label>
                            <!-- End Toggle Switch -->
                            <hr class="my-4">
                            <div class="d-flex justify-content-center">
                                <button type="submit" class="btn btn-sm btn-primary w-100">Tạo mới</button>
                            </div>
                        </form>
                    @endif
                    <!-- Body -->
                </div>

            </div>
            <div class="col-lg-8">
                <!-- Card -->
                <div class="card mb-3 mb-lg-5">
                    <!-- Header -->
                    <div class="card-header">
                        <h4 class="card-header-title">Danh sách danh mục ({{ $data->total() }})</h4>
                    </div>


                    <!-- Table -->
                    <div class="table-responsive datatable-custom">
                        <table
                            class="table table-borderless table-thead-bordered table-nowrap table-align-middle card-table">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col" class="table-column-pr-0">
                                        <div class="custom-control custom-checkbox">
                                            {{-- <input id="datatableCheckAll" type="checkbox" class="custom-control-input"> --}}
                                            {{-- <label class="custom-control-label" for="datatableCheckAll"></label> --}}
                                        </div>
                                    </th>
                                    <th class="table-column-pl-0">Tên</th>
                                    <th>Slug</th>
                                    <th>Sản phẩm</th>
                                    <th>Hành động</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse ($data as $item)
                                    <tr>
                                        <td class="table-column-pr-0">
                                            <div class="custom-control custom-checkbox">
                                                {{-- <input type="checkbox" class="custom-control-input" id="productsCheck1">
                                                <label class="custom-control-label" for="productsCheck1"></label> --}}
                                                #{{ $item->id }}
                                            </div>
                                        </td>
                                        <td class="table-column-pl-0">
                                            <a class="media align-items-center" href="ecommerce-product-details.html">
                                                <img class="avatar avatar-lg mr-3 border"
                                                    src="{{ $item->icon_url ? $item->icon_url : asset('assets/img/quin/cate.avif') }}"
                                                    alt="Image Description">
                                                <div class="media-body">
                                                    <h5 class="text-hover-primary mb-0">
                                                        {{ str_repeat('—  ', $item->level) . ' ' . $item->name }}</h5>
                                                </div>
                                            </a>
                                        </td>
                                        <td>
                                            <div>
                                                <div class="mb-2">{{ $item->slug }}</div>
                                                <i class="text-warning">Path: {{ $item->path }}</i>
                                            </div>
                                        </td>
                                        <td>
                                            <div>
                                                <div class="mb-2">
                                                    __
                                                </div>
                                                {{-- <i class="text-warning">Level: {{ $item->level }}</i> --}}
                                                <i class="text-warning">Chiết khẩu: {{ $item->commission_fee }} %</i>
                                            </div>
                                        </td>

                                        <td>
                                            <div class="btn-group" role="group">
                                                <a class="btn btn-sm btn-white"
                                                    href="{{ route('product.category.edit', ['id' => $item->id]) }}">
                                                    <i class="tio-edit"></i>
                                                </a>
                                                <a class="btn btn-sm btn-white"
                                                    onclick="return confirm('Bạn có chắc là muốn xóa chứ!')"
                                                    href="{{ route('product.category.delete', ['id' => $item->id]) }}">
                                                    <i class="fa-regular fa-trash-can"></i>
                                                </a>

                                            </div>
                                        </td>
                                    </tr>

                                @empty
                                    <tr>
                                        <td class="text-center text-danger py-5" colspan="5">Không tìm thấy dữ liệu
                                            nào!</td>
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
                                    {{-- <span class="mr-2">Hiển thị:</span> --}}
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
                    <!-- Body -->
                </div>

            </div>


        </div>
    </div>
@endsection
