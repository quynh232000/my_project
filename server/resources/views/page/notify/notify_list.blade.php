@extends('layout.app')
@section('view_title')
   Danh sách Cài đặt thông báo
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
                            <li class="breadcrumb-item"><a class="breadcrumb-link" href="javascript:;">Cài đặt thông báo</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Danh sách thông báo</li>
                        </ol>
                    </nav>

                    <h1 class="page-header-title">Thông báo ({{$data->total()}})</h1>
                </div>


            </div>
            <!-- End Row -->
        </div>
        <!-- End Page Header -->



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
                <table
                    class="table table-lg table-borderless table-thead-bordered table-nowrap table-align-middle card-table">
                    <thead class="thead-light">
                        <tr>
                            <th class="table-column-pr-0">
                                #
                            </th>
                            <th class="table-column-pl-0">Title</th>
                            <th>Gửi tới</th>
                            <th>Loại</th>
                            <th>Loại gửi</th>
                            <th>Trạng thái</th>
                            <th>Ngày tạo</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($data as $item)
                            <tr>
                                <td class="table-column-pr-0">
                                    <div class="custom-control custom-checkbox">
                                        {{ $item->id }}
                                    </div>
                                </td>
                                <td class="table-column-pl-0">
                                    <a class="d-flex align-items-center" href="{{route('notify.history.detail',['notify_id'=>$item->id])}}">
                                        <div class="ml-3 overflow-hidden" style="max-width: 260px;">
                                            <span class=" h5 text-hover-primary mb-0">{{ $item->title }}</span>
                                        </div>
                                    </a>
                                </td>
                                <td>
                                    <div>
                                        <span class="d-block mb-0">
                                            Từ:{{ $item->from}}
                                        </span>
                                        <span class="d-block mb-0">
                                            Đến:{{ $item->to}}
                                        </span>
                                    </div>
                                </td>
                                <td>
                                    @if ($item->sent_type=='IMMEDIATE')
                                        Gửi ngay
                                    @else
                                        Đặt lịch
                                    @endif
                                </td>
                                <td>
                                    @if ($item->type_target =='ALL')
                                        Toàn hệ thốn
                                    @endif
                                    @if ($item->type_target =='GROUP')
                                        Nhóm đối tượng
                                    @endif
                                    @if ($item->type_target =='USER')
                                        1 người
                                    @endif

                                </td>
                                <td>
                                     @if ($item->status =='SENT')
                                        <span class="legend-indicator bg-success"></span> Đã gửi
                                    @endif
                                    @if ($item->status =='PENDING')
                                        <span class="legend-indicator bg-info"></span> Chưa gửi
                                    @endif
                                    @if ($item->status =='FAILED')
                                        <span class="legend-indicator bg-danger"></span> Thất bại
                                    @endif
                                </td>
                                <td>
                                    {{$item->created_at}}
                               </td>
                               <td>
                                <a href="{{route('notify.show',['id'=>$item->id])}}" class="btn btn-primary">Xem</a>
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
