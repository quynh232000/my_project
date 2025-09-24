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
                            <li class="breadcrumb-item"><a class="breadcrumb-link" href="javascript:;">Danh sách phương thức thanh toán</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Danh sách phương thức thanh toán</li>
                        </ol>
                    </nav>

                    <div class="d-flex justify-content-between mt-4">
                        <h1 class="page-header-title">Danh sách phương thức thanh toán ({{ $data->total() }})</h1>
                        <a href="{{{route('payment-method.create')}}}" class="btn btn-primary">Thêm mới</a>
                    </div>
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
                            <th class=" px-4">Code</th>
                            <th>Tên</th>
                            <th>Trạng thái</th>
                            <th>Mô tả</th>
                            <th>Ngày tạo</th>
                            <th>Ngày cập nhật</th>
                            <th class="text-end">
                                <div class="w-100 text-right">Hành động</div>
                            </th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($data as $item)
                            <tr>
                                <td class="table-column-pr-0">
                                    <strong >{{ $item->id }}</strong>

                                </td>
                                <td title="{{ $item->description }}" class="">
                                    <strong class="text-primary pr-4" style="text-transform: uppercase ">

                                        {{ $item->code }}
                                    </strong>

                                </td>
                                <td class="table-column-pl-0">
                                    {{ $item->name }}
                                </td>
                                <td class="table-column-pl-0">
                                    <div>
                                        @if ($item->is_show == 1)
                                            <a href="{{route('payment-method.status',['id'=>$item->id])}}" class="badge badge-success" style="min-width: 60px">Hiện thị</a>
                                        @else
                                        <a href="{{route('payment-method.status',['id'=>$item->id])}}" class="badge badge-danger" style="min-width: 60px">Ẩn</a>

                                        @endif
                                    </div>
                                </td>
                                <td>
                                   <div title="{{ $item->description }}" class="" style="max-width: 220px;overflow: hidden">
                                    {{ $item->description }}
                                   </div>
                                </td>

                                <td>
                                    {{ $item->created_at ?? '_' }}
                                </td>
                                <td>
                                    {{ $item->updated_at ?? '_' }}
                                </td>
                                <td>
                                    <div class="d-flex justify-content-end">
                                        <a title="Sửa" href="{{ route('payment-method.edit', ['payment_method' => $item->id]) }}"
                                            class="btn btn-sm btn-info"><i class="fa-solid fa-pen-to-square"></i></a>
                                            <form action="{{ route('payment-method.destroy', ['payment_method' => $item->id]) }}" method="POST">
                                                @method('delete')
                                                @csrf
                                                <button type="submit" title="Xóa"
                                                    class="btn btn-sm btn-danger ml-2">
                                                    <i class="fa-solid fa-trash-can"></i>
                                                </button>

                                            </form>
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
