@extends('layout.app')
@section('view_title')
    Vai trò
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

                    <h1 class="page-header-title">Vai trò ({{ $data->count() }})</h1>
                </div>
                <div class="col-sm-auto">
                    <a class="btn btn-primary" href="{{route('user.role.list')}}">
                        <i class="tio-user-add mr-1"></i> Thêm quyền mới
                    </a>
                </div>
            </div>
        </div>
        <div class="row mb-5">
            <div class="col-12">
                <div>
                    @if (session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                </div>
                <div id="addUserStepFormContent">
                    <div id="addUserStepBillingAddress" class="card card-lg">
                        <!-- Body -->
                        <form method="post"
                            action="{{ isset($role) ? route('user.role.update', ['id' => $role->id]) : '' }}"
                            class="card-body">
                            @csrf
                            <div class="row form-group">
                                <label for="locationLabel" class="col-sm-3 col-form-label input-label">Tên vai trò</label>
                                <div class="col-sm-9">
                                    <div class="mb-3">
                                        <input type="text" class="form-control"
                                            value="{{ isset($role) ? $role->name : old('name') }}" name="name"
                                            id="name" placeholder="Tên vai trò..." aria-label="City">
                                            
                                    </div>
                                </div>
                            </div>
                            <div class="row form-group">
                                <label for="addressLine1Label" class="col-sm-3 col-form-label input-label">Mô tả</label>
                                <div class="col-sm-9">
                                    <textarea name="description" id="description" class="form-control" placeholder="Mô tả vai trò.." cols="30"
                                        rows="2">{{ isset($role) ? $role->description : old('description') }}</textarea>
                                </div>
                            </div>
                            <div class="ml-auto w-100 d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary">
                                    {{ isset($role) ? 'Cập nhật' : 'Tạo mới' }}

                                </button>
                            </div>
                        </form>

                    </div>

                </div>
            </div>
        </div>
        <!-- End Stats -->

        <!-- Card -->
        <div class="card">
            <!-- Table -->
            <div class="table-responsive datatable-custom">
                <table
                    class="table table-lg table-borderless table-thead-bordered table-nowrap table-align-middle card-table">
                    <thead class="thead-light w-100">
                        <tr>
                            <th class="table-column-pl-2">Tên quyền</th>
                            <th>Mô tả</th>
                            <th>Nguời dùng</th>
                            <th>Ngày tạo</th>
                            <th class="d-flex justify-content-end">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $item)
                            <tr>
                                <td class="table-column-pl-2">
                                    <div class="d-flex align-items-center">
                                        <div class="">
                                            <div class="badge text-bg-secondary bg-success text-white align-center py-2"
                                                style="min-width: 34px">{{ $item->id }}</div>
                                        </div>
                                        <div class="ml-3">
                                            <span class="d-block h5 text-hover-primary mb-0">{{ $item->name }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-block font-size-sm">
                                        {{ $item->description }}
                                    </div>
                                </td>
                                <td>
                                    <span class="d-block font-size-sm">{{ $item->users_count() }}</span>
                                </td>
                                <td>{{ $item->updated_at ? explode(' ', $item->updated_at)[0] : '--' }}</td>
                                <td class="d-flex justify-content-end gap-2">
                                    <div>
                                        <a onclick="return confirm('Bạn có chắc là sẽ xóa chứ?')"
                                            href="{{ route('user.role.delete', ['id' => $item->id]) }}"
                                            class="btn btn-sm btn-danger">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </a>
                                        <a class="btn btn-sm btn-primary ms-2"
                                            href="{{ route('user.role.show', ['id' => $item->id]) }}">
                                            <i class="fa-solid fa-pen"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach


                    </tbody>
                </table>
            </div>
            <!-- End Table -->


        </div>
    </div>
@endsection
