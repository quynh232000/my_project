@extends('layout.app')
@section('view_title')
    Danh sách LiveStream
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
                            <li class="breadcrumb-item"><a class="breadcrumb-link" href="javascript:;">Phiên live</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Tổng quan</li>
                        </ol>
                    </nav>
                    <h1 class="page-header-title">Danh sách LiveStream ({{ $data->total() }})</h1>
                </div>
            </div>
            <!-- End Row -->
        </div>
        <!-- End Page Header -->

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

        <!-- Card -->
        <div class="card">
            <!-- Header -->
            <div class="card-header">
                <div class="row justify-content-between align-items-center flex-grow-1">
                    <div class="col-12 mb-sm-0">
                        <form class="d-flex row">
                            <!-- Search -->
                            <div class="input-group input-group-merge input-group-flush col-4 d-flex">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="tio-search"></i>
                                    </div>
                                </div>
                                <input id="datatableSearch" type="text" name="search"
                                    value="{{ request()->search ?? '' }}" class="form-control" placeholder="Tìm kiếm.."
                                    aria-label="Search users">
                            </div>
                            <div class="form-group ml-5 col-3">
                                <select name="status" id="" class="form-control">
                                    <option value="">-Trạng thái-</option>
                                    <option value="scheduled" {{ (request()->status ?? '') == 'scheduled' ? 'selected' : '' }}>
                                        Chưa Live</option>
                                    <option value="live" {{ (request()->status ?? '') == 'live' ? 'selected' : '' }}>Đang
                                        Live</option>
                                    <option value="ended" {{ (request()->status ?? '') == 'ended' ? 'selected' : '' }}>Đã kết
                                        thúc</option>
                                </select>
                            </div>
                            <div class="col-2 " style="padding-top:3px">
                                <button type="submit" class="btn btn-sm btn-warning ">Tìm</button>
                            </div>
                            <!-- End Search -->
                        </form>
                    </div>


                </div>
                <!-- End Row -->
            </div>
            <!-- End Header -->

            @php
                $dataStatus = [
                    'scheduled' => '<span class="badge badge-warning">Chưa diễn ra</span>',
                    'live' => '<span class="badge badge-success">Đang diễn ra</span>',
                    'ended' => '<span class="badge badge-danger">Đã kết thúc</span>',
                ];
            @endphp
            <!-- Table -->
            <div class="table-responsive datatable-custom">
                <table
                    class="table table-lg table-borderless table-thead-bordered table-nowrap table-align-middle card-table">
                    <thead class="thead-light">
                        <tr>
                            <th class="table-column-pr-0">
                                #ID
                            </th>
                            <th class="table-column-pl-0">Title</th>
                            <th>Trạng thái</th>
                            <th>Cửa hàng</th>
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
                                    <a class="d-flex align-items-center" href="#">
                                        <div class="avatar avatar-circle">
                                            <img class="avatar-img" src="{{ $item->thumbnail_url }}"
                                                alt="Image Description">
                                        </div>
                                        <div class="ml-3" style="flex: 1">
                                            <span class="d-block h5 text-hover-primary mb-0">{{ $item->title }}</span>
                                            {{-- <span class="d-block font-size-sm text-body">amanda@example.com</span> --}}
                                        </div>
                                    </a>
                                </td>
                                <td>
                                    {!! $dataStatus[$item->status] !!}
                                </td>
                                <td>
                                    <span>{{ $item->user->shop->name }}</span>
                                    <div>{{ $item->user->email }}</div>
                                </td>

                                <td>
                                    <div class="d-flex align-items-center">
                                        {{ $item->created_at ?? '__' }}
                                    </div>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a class="btn btn-sm btn-white"
                                            href="{{ route('live.status', ['id' => $item->id, 'status' => 'live']) }}">
                                            {{-- <i class="tio-edit"></i> --}}
                                            Live
                                        </a>
                                        <a class="btn btn-sm btn-white"
                                            onclick="return confirm('Bạn có chắc là muốn tắt chứ!')"
                                            href="{{ route('live.status', ['id' => $item->id, 'status' => 'ended']) }}">
                                            {{-- <i class="fa-regular fa-trash-can"></i> --}}
                                            Kết thúc
                                        </a>
                                        <a class="btn btn-sm btn-white"
                                            onclick="return confirm('Bạn có chắc là muốn đặt lại chứ!')"
                                            href="{{ route('live.status', ['id' => $item->id, 'status' => 'scheduled']) }}">
                                            {{-- <i class="fa-regular fa-trash-can"></i> --}}
                                            Scheduled
                                        </a>
                                        <a class="btn btn-sm btn-danger"
                                            onclick="return confirm('Bạn có chắc là muốn xóa chứ!')"
                                            href="{{ route('live.delete', ['id' => $item->id]) }}">
                                            <i class="fa-regular fa-trash-can"></i>
                                        </a>

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
