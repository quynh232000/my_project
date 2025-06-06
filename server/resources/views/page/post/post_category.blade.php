@extends('layout.app')
@section('view_title')
    Danh mục bài viết
@endsection
@section('main')
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-sm mb-2 mb-sm-0">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-no-gutter">
                            <li class="breadcrumb-item"><a class="breadcrumb-link" href="javascript:;">Quản trị</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Bài viết</li>
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
                        <form method="post" action="{{ route('post.category._update', ['id' => $category->id]) }}"
                            class="card-body" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="name" class="input-label">Tên danh mục<span
                                        class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="text" class="form-control" value="{{ old('name')??$category->name }}" name="name"
                                        id="name" placeholder="Thời sự">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="name" class="input-label">Danh mục cha </label>
                                <div class="input-group">
                                    <select name="parent_id" class="select2-selection custom-select" id="">
                                        <option value="">--Trống--</option>
                                        @foreach ($categories as $item)
                                            <option value="{{ $item->id }}"
                                                {{ old('parent_id') == $item->id ? 'selected' : ($category->parent_id ==$item->id ?'selected':'') }} class="ps-5 level">
                                                {{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="input-label">Loại danh mục</label>
                                <div class="input-group">
                                    <select name="post_type_id" class="select2-selection custom-select" id="">
                                        <option value="">--Trống--</option>
                                        @foreach ($post_types as $item)
                                            <option value="{{ $item->id }}"
                                                {{ old('post_type_id') == $item->id ? 'selected' : ($category->post_type_id ==$item->id?'selected':'') }} class="ps-5 level">
                                                {{ $item->name }}</option>
                                        @endforeach
                                    </select>
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
                                        <img  style="width: 100%;object-fit:cover" id="image-q" class="avatar avatar-xl avatar-4by3 mb-3"
                                                src="{{ $category->icon??asset('assets\svg\illustrations\browse.svg') }}"
                                                alt="Image Description">
                                        <div class="dz-message custom-file-boxed-label">
                                            {{-- <img style="object-fit: cover" id="imagePreview" class="avatar avatar-xl avatar-4by3 mb-3"
                                                src="{{ $category->icon??asset('assets\svg\illustrations\browse.svg') }}"
                                                alt="Image Description"> --}}
                                            {{-- <h5 class="mb-1">Choose files to upload</h5>
                                        <p class="">or</p> --}}
                                            <div><label for="imageInput" class="btn btn-sm btn-success">Tải lên</label>
                                            </div>
                                        </div>
                                    </label>
                                    <input type="file" name="icon" hidden id="imageInput">
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
                                    <input type="checkbox" class="toggle-switch-input" name="is_show" {{$category->is_show?'checked':''}}
                                        id="availabilitySwitch1">
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
                        <form method="post" action="{{ route('post.category._add') }}" class="card-body"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="name" class="input-label">Tên danh mục<span
                                        class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="text" class="form-control" value="{{ old('name') }}"
                                        name="name" id="name" placeholder="Thời sự">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="name" class="input-label">Danh mục cha </label>
                                <div class="input-group">
                                    <select name="parent_id" class="select2-selection custom-select" id="">
                                        <option value="">--Trống--</option>
                                        @foreach ($categories as $item)
                                            <option value="{{ $item->id }}"
                                                {{ old('parent_id') == $item->id ? 'selected' : '' }} class="ps-5 level">
                                                {{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="input-label">Loại danh mục</label>
                                <div class="input-group">
                                    <select name="post_type_id" class="select2-selection custom-select" id="">
                                        <option value="">--Trống--</option>
                                        @foreach ($post_types as $item)
                                            <option value="{{ $item->id }}"
                                                {{ old('post_type_id') == $item->id ? 'selected' : '' }} class="ps-5 level">
                                                {{ $item->name }}</option>
                                        @endforeach
                                    </select>
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
                                    <input type="file" name="icon" hidden id="imageInput">
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
                        <table id="datatable"
                            class="table table-borderless table-thead-bordered table-nowrap table-align-middle card-table">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col" class="table-column-pr-0">
                                        <div class="custom-control custom-checkbox">

                                        </div>
                                    </th>
                                    <th class="table-column-pl-0">Tên</th>
                                    <th>Slug</th>
                                    <th>Loại</th>
                                    <th>Bài viết</th>
                                    <th>Hành động</th>
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
                                            <a class="media align-items-center" href="ecommerce-product-details.html">
                                                <img style="object-fit: cover" class="avatar avatar-lg mr-3 border"
                                                    src="{{ $item->icon ? $item->icon : asset('assets/img/quin/cate.avif') }}"
                                                    alt="Image Description">
                                                <div class="media-body">
                                                    <h5 class="text-hover-primary mb-0">
                                                        {{ $item->name }}</h5>
                                                </div>
                                            </a>
                                        </td>
                                        <td>
                                            <div>
                                                <div class="mb-2">{{ $item->slug }}</div>
                                            </div>
                                        </td>
                                        <td>
                                            <div>
                                                <div class="mb-2">{{ $item->post_type->name }}</div>
                                            </div>
                                        </td>
                                        <td>
                                            <div>
                                                <div class="mb-2">
                                                    __
                                                </div>

                                            </div>
                                        </td>

                                        <td>
                                            <div class="btn-group" role="group">
                                                <a class="btn btn-sm btn-white"
                                                    href="{{ route('post.category.update', ['id' => $item->id]) }}">
                                                    <i class="tio-edit"></i>
                                                </a>
                                                <a class="btn btn-sm btn-white"
                                                    onclick="return confirm('Bạn có chắc là muốn xóa chứ!')"
                                                    href="{{ route('post.category.delete', ['id' => $item->id]) }}">
                                                    <i class="fa-regular fa-trash-can"></i>
                                                </a>

                                            </div>
                                        </td>
                                    </tr>

                                @empty
                                    <tr>
                                        <td class="text-center text-danger py-5" colspan="6">Không tìm thấy dữ liệu
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
