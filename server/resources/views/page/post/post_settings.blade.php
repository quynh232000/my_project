@extends('layout.app')
@section('view_title')
    Cài đặt bài viết
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

                    <h1 class="page-header-title">Cài đặt bài viết</h1>
                </div>
                <div class="col-sm-auto">
                    <a class="btn btn-primary" href="{{ route('product.category.list') }}">
                        <i class="tio-user-add mr-1"></i> Thêm bài viết mới
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
            <div class="col-lg-6">
                <!-- Card -->
                <div class="card mb-3 mb-lg-5">
                    <!-- Header -->
                    <div class="card-header">
                        <h4 class="card-header-title">Thêm Loại
                        </h4>
                    </div>
                    <!-- End Header -->

                    <!-- Body -->
                   
                        <form method="post" action="{{ route('post.setting.type._add') }}" class="card-body"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="name" class="input-label">Tên loại<span class="text-danger">*</span></label>
                                <div class="input-group d-flex">
                                    <input type="text" class="form-control" name="name" id="name"
                                        placeholder="BLOG, EDU, QA,..">
                                    <button type="submit" class="btn btn-sm btn-primary">Tạo mới</button>
                                </div>
                            </div>

                        </form>
                  
                    <div class="table-responsive datatable-custom">
                        <table id="datatable1"
                            class="table table-borderless table-thead-bordered table-nowrap table-align-middle card-table">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col" class="table-column-pr-0">
                                        <div class="custom-control custom-checkbox">
                                        </div>
                                    </th>
                                    <th class="table-column-pl-0">Tên</th>
                                    <th>Slug</th>
                                    <th>Danh mục</th>
                                    <th class=" ">
                                        <div class="text-center">Hành động</div>
                                    </th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse ($post_types as $item)
                                    <tr>
                                        <td class="table-column-pr-0">
                                            <div class="custom-control custom-checkbox">

                                                #{{ $item->id }}
                                            </div>
                                        </td>
                                        <td class="table-column-pl-0">
                                            <a class="media align-items-center" href="ecommerce-product-details.html">

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
                                                <div class="mb-2">{{ $item->post_categories->count() }}</div>
                                            </div>
                                        </td>


                                        <td class="d-flex justify-content-end">
                                            <div class="btn-group" role="group">
                                                <a class="btn btn-sm btn-white"
                                                    onclick="return confirm('Bạn có chắc là muốn xóa chứ!')"
                                                    href="{{ route('post.setting.type.delete', ['id' => $item->id]) }}">
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
                    <!-- Body -->
                </div>

            </div>

            <div class="col-lg-6">
                <!-- Card -->
                <div class="card mb-3 mb-lg-5">
                    <!-- Header -->
                    <div class="card-header">
                        <h4 class="card-header-title"> Quản lý tags
                        </h4>
                    </div>
                    <!-- End Header -->

                    <!-- Body -->

                    <form method="post" action="{{ route('post.setting.tag._add') }}" class="card-body"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="name" class="input-label">Tên tag<span class="text-danger">*</span></label>
                            <div class="input-group d-flex">
                                <input type="text" class="form-control" name="name" id="name"
                                    placeholder="tinnong, hoidaphay,..">
                                <button type="submit" class="btn btn-sm btn-primary">Tạo mới</button>
                            </div>
                        </div>

                    </form>
                    <div class="table-responsive datatable-custom">
                        <table id="datatable2"
                            class="table table-borderless table-thead-bordered table-nowrap table-align-middle card-table">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col" class="table-column-pr-0">
                                        <div class="custom-control custom-checkbox">
                                        </div>
                                    </th>
                                    <th class="table-column-pl-0">Tên</th>
                                    <th>Slug</th>
                                    <th>Bài viết</th>
                                    <th class=" ">
                                        <div class="text-center">Hành động</div>
                                    </th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse ($tags as $item)
                                    <tr>
                                        <td class="table-column-pr-0">
                                            <div class="custom-control custom-checkbox">
                                                #{{ $item->id }}
                                            </div>
                                        </td>
                                        <td class="table-column-pl-0">
                                            <a class="media align-items-center" href="ecommerce-product-details.html">

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
                                                <div class="mb-2">{{ $item->post_tags->count() }}</div>
                                            </div>
                                        </td>
                                        <td class="d-flex justify-content-end">
                                            <div class="btn-group" role="group">
                                                <a class="btn btn-sm btn-white"
                                                    onclick="return confirm('Bạn có chắc là muốn xóa chứ!')"
                                                    href="{{ route('post.setting.tag.delete', ['id' => $item->id]) }}">
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
                    <!-- Body -->
                </div>

            </div>



        </div>
    </div>
@endsection
