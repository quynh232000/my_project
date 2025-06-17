@extends('layout.app')
@section('title', 'Manage Portfolio Category')
@section('main')
    <div id="kt_app_content_container" class="app-container container-xxl">
        <!--begin::Card-->
        <div class="card card-flush">
            <!--begin::Card header-->
            <div class="card-header mt-6">
                <!--begin::Card title-->
                <div class="card-title">
                    <!--begin::Search-->
                    <form class="d-flex align-items-center position-relative my-1 me-5">
                        <i class="ki-outline ki-magnifier fs-3 position-absolute ms-5"></i>
                        <input type="text" name="search" value="{{request()->search ?? ''}}" data-kt-permissions-table-filter="search"
                            class="form-control form-control-solid w-250px ps-13" placeholder="Search Permissions" />
                    </form>
                    <!--end::Search-->
                </div>
                <!--end::Card title-->
                <!--begin::Card toolbar-->

                <!--end::Card toolbar-->
            </div>
            <!--end::Card header-->
            <!--begin::Card body-->
            <div class="card-body pt-0">
                <!--begin::Row-->

                <div class="container">
                    <h1 class="mb-4">List Category</h1>

                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Uri</th>
                                <th>Method</th>
                                <th>Resource type</th>
                                <th>Created At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($params['permissions'] as $permission)
                                <tr>
                                    <td>{{ $permission->id }}</td>
                                    <td>{{ $permission->name }}</td>
                                    <td>{{ $permission->uri }}</td>
                                    <td class="text-warning">{{ $permission->method }}</td>
                                    <td>{{ $permission->resource_type ?? '—' }}</td>
                                    <td>{{ $permission->created_at->format('d/m/Y H:i') }}</td>
                                    <td>
                                        <a href="
                                        {{ route($params['prefix'] . '.' . $params['controller'] . '.edit', $permission->id) }}
                                         "
                                            class="btn btn-sm btn-warning">Edit</a>
                                        <form  action="{{ route($params['prefix'] . '.' . $params['controller'] . '.destroy', $permission->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method("DELETE")
                                            <button class="btn btn-sm btn-danger"
                                                onclick="return confirm('Do you want to delete?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div>
                        {{ $params['permissions']->links() }}
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
