@extends('layout.app')
@section('view_title')
    Danh sách quy tắc Quin Coin
@endsection
@section('main')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center mb-3">
                <div class="col-sm mb-2 mb-sm-0">
                    <h1 class="page-header-title"> Danh sách quy tắc Quin Coin </h1>


                </div>

                {{-- <div class="col-sm-auto">
                    <a class="btn btn-primary" href="{{ route('banner.add') }}">Thêm Banner</a>
                </div> --}}
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
                            <th class="table-column-pl-0">Tên</th>
                            <th>Số Coin</th>
                            <th>Mô tả</th>
                            
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
                                            <h5 class="text-hover-primary mb-0">{{ $item->rule_name }}</h5>
                                        </div>
                                    </a>
                                </td>
                                <td><strong class="text-primary">{{ $item->coin_amount }} </strong> </td>
                                <td>
                                    {{$item->description}}
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
