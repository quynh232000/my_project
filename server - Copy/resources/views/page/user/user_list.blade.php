@extends('layout.app')
@section('view_title')
    Thành viên
@endsection

@section('main')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-sm mb-2 mb-sm-0">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-no-gutter">
                            <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ route('dashboard') }}">Trang
                                    chủ</a></li>
                            <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ route('user.list') }}">Thành
                                    viên</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Tổng quan</li>
                        </ol>
                    </nav>

                    <h1 class="page-header-title">Thành viên</h1>
                </div>

                <div class="col-sm-auto">
                    <a class="btn btn-primary" href="{{route('user.add')}}">
                        <i class="tio-user-add mr-1"></i> Thêm người dùng
                    </a>
                </div>
            </div>
            <!-- End Row -->
        </div>
        <!-- End Page Header -->

        <!-- Stats -->
        <div class="row gx-2 gx-lg-3">
            <div class="col-sm-6 col-lg-3 mb-3 mb-lg-5">
                <!-- Card -->
                <div class="card h-100">
                    <div class="card-body">
                        <h6 class="card-subtitle mb-2">Tổng người dùng</h6>

                        <div class="row align-items-center gx-2">
                            <div class="col">
                                <span class="js-counter display-4 text-dark">{{$data->total()}}</span>
                                {{-- <span class="text-body font-size-sm ml-1">từ 22</span> --}}
                            </div>


                        </div>
                        <!-- End Row -->
                    </div>
                </div>
                <!-- End Card -->
            </div>

            <div class="col-sm-6 col-lg-3 mb-3 mb-lg-5">
                <!-- Card -->
                <div class="card h-100">
                    <div class="card-body">
                        <h6 class="card-subtitle mb-2">Quản trị viên</h6>

                        <div class="row align-items-center gx-2">
                            <div class="col">
                                <span class="js-counter display-4 text-dark">{{$info['admin']}}</span>
                            </div>


                        </div>
                        <!-- End Row -->
                    </div>
                </div>
                <!-- End Card -->
            </div>

            <div class="col-sm-6 col-lg-3 mb-3 mb-lg-5">
                <!-- Card -->
                <div class="card h-100">
                    <div class="card-body">
                        <h6 class="card-subtitle mb-2">Tài khoản hoạt động</h6>

                        <div class="row align-items-center gx-2">
                            <div class="col">
                                <span class="js-counter display-4 text-dark">{{$info['active']}}</span>
                            </div>

                        </div>
                        <!-- End Row -->
                    </div>
                </div>
                <!-- End Card -->
            </div>

            <div class="col-sm-6 col-lg-3 mb-3 mb-lg-5">
                <!-- Card -->
                <div class="card h-100">
                    <div class="card-body">
                        <h6 class="card-subtitle mb-2">Tài khoản bị khóa</h6>

                        <div class="row align-items-center gx-2">
                            <div class="col">
                                <span class="js-counter display-4 text-dark">{{$info['blocked']}}</span>
                            </div>

                        </div>
                        <!-- End Row -->
                    </div>
                </div>
                <!-- End Card -->
            </div>
        </div>
        <!-- End Stats -->
        <!-- Card -->
        <div class="card">
            <!-- Header -->
            <div class="card-header">
                <div class="row justify-content-between align-items-center flex-grow-1">
                    <div class="col-sm-6 col-md-4 mb-3 mb-sm-0">
                        <form>
                            <!-- Search -->
                            <div class="input-group input-group-merge input-group-flush">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="tio-search"></i>
                                    </div>
                                </div>
                                <input id="datatableSearch" type="text" value="{{request()->search ?? ''}}" name="search" class="form-control" placeholder="Tìm kiếm.."
                                    aria-label="Tìm kiếm..">
                            </div>
                            <!-- End Search -->
                        </form>
                    </div>

                    <div class="col-sm-6">
                        <form class="d-sm-flex justify-content-sm-end align-items-sm-center">
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

                            <select class="form-control" style="width: 180px" name="role_id" id="">
                                <option value="">--Quyền hạng--</option>
                                @foreach ($info['roles'] as $item)
                                    <option value="{{$item->id}}">{{$item->name}}</option>
                                @endforeach

                            </select>
                            <select name="is_blocked" class="form-control ml-2" style="width: 150px" id="">
                                <option value="">--Trạng thái--</option>
                                <option value="0">Hoạt động</option>
                                <option value="1">Bị khóa</option>
                            </select>
                            <button type="submit" class="btn ml-4 btn-warning">Lọc</button>
                            <a href="/user" class="btn m-2 btn-outline-warning">Làm mới</a>
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
                                <div class="custom-control custom-checkbox">
                                    <input id="datatableCheckAll" type="checkbox" class="custom-control-input">
                                    <label class="custom-control-label" for="datatableCheckAll"></label>
                                </div>
                            </th>
                            <th class="table-column-pl-0">Tên</th>
                            <th>Vai trò</th>
                            <th>Trạng thái</th>
                            <th>Tham gia vào</th>
                            <th>Login lần cuối</th>
                            <th></th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($data as $item)
                            <tr>
                                <td class="table-column-pr-0">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input"
                                            id="usersDataCheck{{ $item->id }}">
                                        <label class="custom-control-label"
                                            for="usersDataCheck{{ $item->id }}"></label>
                                    </div>
                                </td>
                                <td class="table-column-pl-0">
                                    <a class="d-flex align-items-center" href="{{route('user.info',['uuid'=>$item->uuid])}}">
                                        <div class="avatar avatar-circle">
                                            <img width="42" height="42" style="object-fit: cover" class="avatar-img" src="{{ $item->avatar_url }}"
                                                alt="Image Description">
                                        </div>
                                        <div class="ml-3">
                                            <span class="d-block h5 text-hover-primary mb-0">{{ $item->full_name }}<i
                                                    class="tio-verified text-primary" data-toggle="tooltip"
                                                    data-placement="top" title="Top endorsed"></i></span>
                                            <span class="d-block font-size-sm text-body">{{ $item->email }}</span>
                                        </div>
                                    </a>
                                </td>
                                <td>
                                    <div>
                                        @foreach ($item->roles() as $role)
                                            <span class="d-block h5 mb-0">-{{ $role }}-</span>
                                        @endforeach
                                    </div>
                                </td>
                                <td>
                                    @if ($item->is_blocked)
                                        <span class="legend-indicator bg-danger"></span>Bị khóa
                                    @else
                                        <span class="legend-indicator bg-success"></span>Hoạt động
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        {{ explode(' ', $item->created_at)[0] }}
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        {{$item->last_login_at ?? '' }}
                                    </div>
                                </td>

                                <td>
                                    <div id="editUserPopover" >
                                        <a class="btn btn-sm btn-white" href="{{route('user.update',['uuid'=>$item->uuid])}}" >
                                            <i class="tio-edit"></i> Edit
                                        </a>
                                    </div>
                                </td>
                            </tr>

                        @empty
                            <tr>
                                <td class="text-center text-danger py-5" colspan="6">Không tìm thấy dữ liệu!</td>
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
                       {{$data->links()}}
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
