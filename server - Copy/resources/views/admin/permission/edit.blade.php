@extends('layout.app')
@section('title', 'Update Permissions')
@section('main')
    <div id="kt_app_content_container" class="app-container container-xxl">
        <!--begin::Card-->
        <div class="card card-flush">
            <!--begin::Card header-->

            <!--end::Card header-->
            <!--begin::Card body-->
            <div class="card-body  pt-5">
                <!--begin::Row-->
                <h1 class="mb-4">Update Permission</h1>


                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Route Name</th>
                            <th>URI</th>
                            <th>Method</th>
                            <th>Set Permission</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ $params['item']->name }}</td>
                            <td>{{  $params['item']->uri }}</td>
                            <td>
                                <a href="#" class="badge badge-light-success fs-7 m-1"> {{  $params['item']->method }}</a>
                            </td>
                            <td>
                                <form action="{{ route($params['prefix'] . '.' . $params['controller'] . '.update',$params['item']->id) }}"
                                    method="POST" class="form-inline d-flex">
                                    @csrf
                                    @method("PUT")
                                    <input type="text" name="permission_name" class="form-control me-2"
                                        value="{{ Str::replace('.', '_',  $params['item']->name) }}">
                                    <button type="submit" class="btn btn-primary btn-sm">Save</button>
                                </form>
                            </td>
                        </tr>

                    </tbody>
                </table>


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




    <!--end::Custom Javascript-->
    <!--end::Javascript-->
@endpush
