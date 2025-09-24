@extends('layout.app')
@section('title', 'Manage Portfolio Data Info')
@section('main')
    <div id="kt_app_content_container" class="app-container container-xxl">
        <!--begin::Card-->
        <div class="card card-flush">
            <!--begin::Card header-->
            <div class="card-header border-0 pt-6">
                <!--begin::Card title-->
                <div class="card-title">
                    <!--begin::Search-->
                    <form class="d-flex align-items-center position-relative my-1">
                        <i class="ki-outline ki-magnifier fs-3 position-absolute ms-5"></i>
                        <input type="text" name="search" type="text" value="{{ request()->search ?? '' }}"
                            class="form-control form-control-solid w-250px ps-13" placeholder="Search.." />
                    </form>
                    <!--end::Search-->
                </div>
                <!--begin::Card title-->
                <!--begin::Card toolbar-->
                <div class="card-toolbar">
                    <!--begin::Toolbar-->
                    <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">

                        <a href="{{ route($params['prefix'] . '.' . $params['controller'] . '.create') }}" type="button"
                            class="btn btn-primary">
                            <i class="ki-outline ki-plus fs-2"></i>Add new</a>
                        <!--end::Add user-->
                    </div>


                </div>
                <!--end::Card toolbar-->
            </div>
            <!--end::Card header-->
            <!--begin::Card body-->
            <div class="card-body pt-0">
                <!--begin::Row-->

                <div class="container">
                    <h1 class="mb-4">List Data ({{$params['items']->total()}})</h1>

                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Image</th>
                                <th>Title</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th>Created At</th>
                                <th>Created by</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($params['items'] as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <span class="icon-wrapper cursor-pointer symbol symbol-40px">
                                                  <img src="{{ $item->image ?? asset('assets/media/auth/505-error.png') }}"
                                                        alt="">
                                            </span>

                                        </div>
                                    </td>
                                    <td><div style="max-width: 220px;overflow:hidden">
                                        {{ $item->title }}</div></td>

                                    <td class="text-warning">{{ $item->email }}</td>
                                    <td class="text">{{ $item->status }}</td>
                                    <td>{{ $item->created_at }}</td>
                                    <td>{{ $item->creator->full_name }}</td>
                                    <td>
                                        <a href="
                                        {{ route($params['prefix'] . '.' . $params['controller'] . '.edit', $item->id) }}
                                         "
                                            class="btn btn-sm btn-warning">Edit</a>
                                        <form
                                            action="{{ route($params['prefix'] . '.' . $params['controller'] . '.destroy', $item->id) }}"
                                            method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger"
                                                onclick="return confirm('Do you want to delete?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div>
                        {{ $params['items']->links() }}
                    </div>
                </div>

            </div>
            <!--end::Card body-->
        </div>

    </div>
@endsection
@push('js2')
    <!--begin::Custom Javascript(used for this page only)-->
    <script src="{{ asset('assets/js/custom/apps/user-management/permissions/list.js') }}"></script>
    <script src="{{ asset('assets/js/custom/apps/user-management/permissions/add-permission.js') }}"></script>
    <script src="{{ asset('assets/js/custom/apps/user-management/permissions/update-permission.js') }}"></script>
    <script src="{{ asset('assets/js/widgets.bundle.js') }}"></script>
    <script src="{{ asset('assets/js/custom/widgets.js') }}"></script>
    <script src="{{ asset('assets/js/custom/apps/chat/chat.js') }}"></script>
    <script src="{{ asset('assets/js/custom/utilities/modals/users-search.js') }}"></script>


    <script>
        if ($('table.table-striped tbody tr').length === 0) {
            $('table.table-striped tbody').html('<tr><td colspan="100%" class="text-center">No data</td></tr>');
        }
    </script>

    <!--end::Custom Javascript-->
    <!--end::Javascript-->
@endpush
