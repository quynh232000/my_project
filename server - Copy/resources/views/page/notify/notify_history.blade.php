@extends('layout.app')
@section('view_title')
    Lịch sử thông báo đã gửi
@endsection
@section('main')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center mb-3">
                <div class="col-sm mb-2 mb-sm-0">
                    <h1 class="page-header-title"> Lịch sử thông báo đã gửi </h1>


                </div>

                {{-- <div class="col-sm-auto">
                    <a class="btn btn-primary" href="{{ route('banner.add') }}">Thêm Banner</a>
                </div> --}}
            </div>
            <!-- End Row -->


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
                                <input id="datatableSearch" type="search" class="form-control" placeholder="Tìm kiếm.."
                                    aria-label="Search users">
                            </div>
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
                    class="table table-borderless table-thead-bordered table-nowrap table-align-middle card-table"
                   >
                    <thead class="thead-light">
                        <tr>
                            <th scope="col" class="table-column-pr-0">
                                <div class="custom-control custom-checkbox">
                                    <input id="datatableCheckAll" type="checkbox" class="custom-control-input">
                                    <label class="custom-control-label" for="datatableCheckAll"></label>
                                </div>
                            </th>
                            <th class="table-column-pl-0">ID Thông báo</th>
                            <th>Người nhận</th>
                            <th>Trạng thái</th>
                            
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($data as $item)
                            <tr>
                                <td class="table-column-pr-0">
                                    <div class="custom-control custom-checkbox">
                                        {{$item->id}}
                                    </div>
                                </td>
                                <td class="table-column-pl-0">
                                    <a class="media align-items-center" href="#">
                                       
                                        <div class="media-body">
                                            <h5 class="text-hover-primary mb-0">{{ $item->notification_id }}</h5>
                                        </div>
                                    </a>
                                </td>
                                <td>
                                   <div> <strong class="text-primary">{{ $item->user->full_name }} </strong> </div>
                                    <strong class="text-primary">{{ $item->user->email }} </strong> 
                                </td>
                                <td>
                                   @if ($item->is_read)
                                       Đã đọc
                                   @else
                                        Chưa đọc                                       
                                   @endif
                                </td>
                               
                                
                            </tr>

                        @empty
                            <tr>
                                <td class="text-danger text-center" colspan="5">Không tìm thấy dữ liệu</td>
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
                            
                           {{$data->links()}}
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
