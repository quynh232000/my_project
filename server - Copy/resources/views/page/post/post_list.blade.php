@extends('layout.app')
@section('view_title')
    Danh sách bài viết
@endsection
@section('main')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center mb-3">
                <div class="col-sm mb-2 mb-sm-0">
                    <h1 class="page-header-title">Danh sách bài viết </h1>


                </div>

                <div class="col-sm-auto">
                    <a class="btn btn-primary" href="{{ route('post.add') }}">Thêm Bài viết mới</a>
                </div>
            </div>
            <!-- End Row -->


        </div>
        <!-- End Page Header -->

        <div class="row justify-content-end mb-3">
            <div class="col-lg">
                <!-- Datatable Info -->
                <div  style="display: none;">
                    <div class="d-sm-flex justify-content-lg-end align-items-sm-center">
                        <span class="d-block d-sm-inline-block font-size-sm mr-3 mb-2 mb-sm-0">
                            <span >0</span>
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
        <div class="row">
            <div class="col-12">
                <div>
                    @if (session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                </div>
            </div>
        </div>
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
                                <input id="datatableSearch" value="{{request()->search}}" type="search" name="search" class="form-control" placeholder="Tìm kiếm.."
                                    aria-label="Search users">
                                <button class="btn btn-sm btn-warning">Tìm</button>
                            </div>
                            <!-- End Search -->
                        </form>

                    </div>

                    <div class="d-flex justify-content-between" style="flex-1">

                        <div>
                            <a class="btn btn-sm btn-success" href="{{ route('post.active_all') }}">Duyệt tất cả</a>
                        </div>
                    </div>
                </div>
                <!-- End Row -->
            </div>
            <!-- End Header -->

            <!-- Table -->
            <div class="table-responsive datatable-custom">
                <table
                    class="table table-borderless table-thead-bordered table-nowrap table-align-middle card-table">
                    <thead class="thead-light">
                        <tr>
                            <th scope="col" class="table-column-pr-0">
                                <div class="custom-control custom-checkbox">
                                    <input id="datatableCheckAll" type="checkbox" class="custom-control-input">
                                    <label class="custom-control-label" for="datatableCheckAll"></label>
                                </div>
                            </th>
                            <th class="table-column-pl-0">Title</th>
                            <th>Tác giả</th>
                            <th>Hiện</th>
                            <th>Danh mục</th>
                            <th>Ngày tạo</th>
                            <th>Loại</th>
                            <th>Trạng thái</th>
                            <th>
                                Hành động
                            </th>
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
                                        <img style="object-fit:cover" class="avatar avatar-lg mr-3" src="{{ $item->thumbnail }}"
                                            alt="Image Description">
                                        <div class="media-body">
                                            <h5 class="text-hover-primary mb-0" style="max-width: 220px; overflow:hidden">{{ $item->title }}</h5>
                                        </div>
                                    </a>
                                </td>
                                <td>
                                    <div>{{ $item->author->full_name }}</div>
                                    <div>{{ $item->author->email }}</div>
                                </td>
                                <td>
                                    <form method="POST" id="form_show{{ $item->id }}"
                                        action="{{ route('post.is_show', ['id' => $item->id]) }}">
                                        @csrf

                                        <label class="toggle-switch toggle-switch-sm" for="toggleColumn_product{{$item->id}}">
                                            <input type="checkbox" class="toggle-switch-input" id="toggleColumn_product{{$item->id}}"
                                            {{$item->is_show ==1?'checked':''}} >
                                            <span class="toggle-switch-label">
                                                <span class="toggle-switch-indicator"></span>
                                            </span>
                                        </label>

                                    </form>
                                    <script>
                                        $('#toggleColumn_product' + {{ $item->id }}).change(function() {
                                            $('#form_show' + {{ $item->id }}).submit()
                                        })
                                    </script>
                                </td>
                                <td>
                                    <div>{{ $item->category->name }}</div>
                                    <div>
                                        @if ($item->post_tags->count() > 0)
                                            <i>Hashtags:</i>
                                            @foreach ($item->post_tags as $posttag)
                                                <span class="text-primary">{{ $posttag->tag->tag_name }}</span>
                                            @endforeach
                                        @endif
                                    </div>
                                </td>
                                <td>{{ explode(' ', $item->created_at)[0] }}</td>
                                <td>{{ $item->category->post_type->name }}</td>
                                <td>
                                    @if ($item->is_published)
                                        <span class="badge badge-soft-success ml-2">Hoạt động</span>
                                    @else
                                        <span class="badge badge-soft-warning ml-2">Chờ duyệt</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a class="btn btn-sm btn-white"
                                            href="{{ route('post.update', ['id' => $item->id]) }}">
                                            <i class="tio-edit"></i> Sửa
                                        </a>
                                        <!-- Unfold -->
                                        <div class="hs-unfold btn-group">
                                            <a class="js-hs-unfold-invoker btn btn-icon btn-sm btn-white dropdown-toggle dropdown-toggle-empty"
                                                href="javascript:;"
                                                data-hs-unfold-options='{
                                                "target": "#productsEditDropdown1{{$item->id}}",
                                                "type": "css-animation",
                                                "smartPositionOffEl": "#datatable"
                                            }'></a>
                                            <div id="productsEditDropdown1{{$item->id}}"
                                                class="hs-unfold-content dropdown-unfold dropdown-menu dropdown-menu-right mt-1">

                                                @if (!$item->is_published)
                                                    <a class="dropdown-item"
                                                        href="{{ route('post.active', ['id' => $item->id]) }}">
                                                        <i class="tio-publish dropdown-item-icon"></i> Duyệt
                                                    </a>
                                                @endif
                                                <a class="dropdown-item"
                                                    href="{{ route('post.update', ['id' => $item->id]) }}">
                                                    <i class="tio-edit dropdown-item-icon"></i> Sửa
                                                </a>
                                                <a class="dropdown-item"
                                                    href="{{ route('post.delete', ['id' => $item->id]) }}">
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
