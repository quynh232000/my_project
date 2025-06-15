@extends('layout.app')
@section('title', 'Manage Users')
@section('main')
    <div id="kt_app_content_container" class="app-container container-xxl">

        <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-5 g-xl-9">
            <!--begin::Add new card-->
            <div class="ol-md-4">
                <!--begin::Card-->
                <a href="{{ route($params['prefix'] . '.' . $params['controller'] . '.create') }}" class="card h-md-100">
                    <!--begin::Card body-->
                    <div class="card-body d-flex flex-center">
                        <!--begin::Button-->
                        <button type="button" class="btn btn-clear d-flex flex-column flex-center">
                            <!--begin::Illustration-->
                            <img src="{{ asset('assets/media/illustrations/sketchy-1/4.png') }}" alt=""
                                class="mw-100 mh-150px mb-7" />
                            <!--end::Illustration-->
                            <!--begin::Label-->
                            <div class="fw-bold fs-3 text-gray-600 text-hover-primary">Add New Role</div>
                            <!--end::Label-->
                        </button>
                        <!--begin::Button-->
                    </div>
                    <!--begin::Card body-->
                </a>
                <!--begin::Card-->
            </div>
            <!--begin::Add new card-->
            <!--begin::Col-->

            @foreach ($params['roles'] as $item)
                <div class="col-md-4">
                    <!--begin::Card-->
                    <div class="card card-flush h-md-100">
                        <!--begin::Card header-->
                        <div class="card-header">
                            <!--begin::Card title-->
                            <div class="card-title">
                                <h2>{{ $item->name }}</h2>
                            </div>
                            <!--end::Card title-->
                        </div>
                        <!--end::Card header-->
                        <!--begin::Card body-->
                        <div class="card-body pt-1">
                            <!--begin::Users-->
                            <div class="fw-bold text-gray-600 mb-5">Total permission with this role:
                                {{ $item->permissions->count() }}</div>
                            <!--end::Users-->
                            <!--begin::Permissions-->
                            <div class="d-flex flex-column text-gray-600">

                                @forelse ($item->permissions->take(5) as $permission)
                                    <div class="d-flex align-items-center py-2" title="{{ $permission->uri }}">
                                        <span class="bullet bg-primary me-3"></span>{{ $permission->name }}
                                    </div>
                                @empty
                                    <div class="d-flex align-items-center py-2 text-center w-full text-danger">
                                        No permission added
                                    </div>
                                @endforelse

                                @if ($item->permissions->count() > 5)
                                    <div class='d-flex align-items-center py-2'>
                                        <span class='bullet bg-primary me-3'></span>
                                        <em>and {{ $item->permissions->count() - 5 }} more...</em>
                                    </div>
                                @endif
                            </div>
                            <!--end::Permissions-->
                        </div>
                        <!--end::Card body-->
                        <!--begin::Card footer-->
                        <div class="card-footer flex-wrap pt-0">
                            <a href="{{ route($params['prefix'] . '.' . $params['controller'] . '.show', $item->id) }}"
                                class="btn btn-light btn-active-primary my-1 me-2">View Role</a>
                            <a href="{{ route($params['prefix'] . '.' . $params['controller'] . '.edit', $item->id) }}"
                                class="btn btn-light btn-active-primary my-1 me-2">Edit Role</a>

                        </div>
                        <!--end::Card footer-->
                    </div>
                    <!--end::Card-->
                </div>
            @endforeach

            {{-- <!--end::Col-->
            <!--begin::Col-->
            <div class="col-md-4">
                <!--begin::Card-->
                <div class="card card-flush h-md-100">
                    <!--begin::Card header-->
                    <div class="card-header">
                        <!--begin::Card title-->
                        <div class="card-title">
                            <h2>Developer</h2>
                        </div>
                        <!--end::Card title-->
                    </div>
                    <!--end::Card header-->
                    <!--begin::Card body-->
                    <div class="card-body pt-1">
                        <!--begin::Users-->
                        <div class="fw-bold text-gray-600 mb-5">Total users with this role: 14</div>
                        <!--end::Users-->
                        <!--begin::Permissions-->
                        <div class="d-flex flex-column text-gray-600">
                            <div class="d-flex align-items-center py-2">
                                <span class="bullet bg-primary me-3"></span>Some Admin Controls
                            </div>
                            <div class="d-flex align-items-center py-2">
                                <span class="bullet bg-primary me-3"></span>View Financial Summaries only
                            </div>
                            <div class="d-flex align-items-center py-2">
                                <span class="bullet bg-primary me-3"></span>View and Edit API Controls
                            </div>
                            <div class="d-flex align-items-center py-2">
                                <span class="bullet bg-primary me-3"></span>View Payouts only
                            </div>
                            <div class="d-flex align-items-center py-2">
                                <span class="bullet bg-primary me-3"></span>View and Edit Disputes
                            </div>
                            <div class='d-flex align-items-center py-2'>
                                <span class='bullet bg-primary me-3'></span>
                                <em>and 3 more...</em>
                            </div>
                        </div>
                        <!--end::Permissions-->
                    </div>
                    <!--end::Card body-->
                    <!--begin::Card footer-->
                    <div class="card-footer flex-wrap pt-0">
                        <a href="apps/user-management/roles/view.html"
                            class="btn btn-light btn-active-primary my-1 me-2">View Role</a>
                        <button type="button" class="btn btn-light btn-active-light-primary my-1" data-bs-toggle="modal"
                            data-bs-target="#kt_modal_update_role">Edit Role</button>
                    </div>
                    <!--end::Card footer-->
                </div>
                <!--end::Card-->
            </div>
            <!--end::Col-->
            <!--begin::Col-->
            <div class="col-md-4">
                <!--begin::Card-->
                <div class="card card-flush h-md-100">
                    <!--begin::Card header-->
                    <div class="card-header">
                        <!--begin::Card title-->
                        <div class="card-title">
                            <h2>Analyst</h2>
                        </div>
                        <!--end::Card title-->
                    </div>
                    <!--end::Card header-->
                    <!--begin::Card body-->
                    <div class="card-body pt-1">
                        <!--begin::Users-->
                        <div class="fw-bold text-gray-600 mb-5">Total users with this role: 4</div>
                        <!--end::Users-->
                        <!--begin::Permissions-->
                        <div class="d-flex flex-column text-gray-600">
                            <div class="d-flex align-items-center py-2">
                                <span class="bullet bg-primary me-3"></span>No Admin Controls
                            </div>
                            <div class="d-flex align-items-center py-2">
                                <span class="bullet bg-primary me-3"></span>View and Edit Financial Summaries
                            </div>
                            <div class="d-flex align-items-center py-2">
                                <span class="bullet bg-primary me-3"></span>Enabled Bulk Reports
                            </div>
                            <div class="d-flex align-items-center py-2">
                                <span class="bullet bg-primary me-3"></span>View Payouts only
                            </div>
                            <div class="d-flex align-items-center py-2">
                                <span class="bullet bg-primary me-3"></span>View Disputes only
                            </div>
                            <div class='d-flex align-items-center py-2'>
                                <span class='bullet bg-primary me-3'></span>
                                <em>and 2 more...</em>
                            </div>
                        </div>
                        <!--end::Permissions-->
                    </div>
                    <!--end::Card body-->
                    <!--begin::Card footer-->
                    <div class="card-footer flex-wrap pt-0">
                        <a href="apps/user-management/roles/view.html"
                            class="btn btn-light btn-active-primary my-1 me-2">View Role</a>
                        <button type="button" class="btn btn-light btn-active-light-primary my-1" data-bs-toggle="modal"
                            data-bs-target="#kt_modal_update_role">Edit Role</button>
                    </div>
                    <!--end::Card footer-->
                </div>
                <!--end::Card-->
            </div>
            <!--end::Col-->
            <!--begin::Col-->
            <div class="col-md-4">
                <!--begin::Card-->
                <div class="card card-flush h-md-100">
                    <!--begin::Card header-->
                    <div class="card-header">
                        <!--begin::Card title-->
                        <div class="card-title">
                            <h2>Support</h2>
                        </div>
                        <!--end::Card title-->
                    </div>
                    <!--end::Card header-->
                    <!--begin::Card body-->
                    <div class="card-body pt-1">
                        <!--begin::Users-->
                        <div class="fw-bold text-gray-600 mb-5">Total users with this role: 23</div>
                        <!--end::Users-->
                        <!--begin::Permissions-->
                        <div class="d-flex flex-column text-gray-600">
                            <div class="d-flex align-items-center py-2">
                                <span class="bullet bg-primary me-3"></span>No Admin Controls
                            </div>
                            <div class="d-flex align-items-center py-2">
                                <span class="bullet bg-primary me-3"></span>View Financial Summaries only
                            </div>
                            <div class="d-flex align-items-center py-2">
                                <span class="bullet bg-primary me-3"></span>View Payouts only
                            </div>
                            <div class="d-flex align-items-center py-2">
                                <span class="bullet bg-primary me-3"></span>View and Edit Disputes
                            </div>
                            <div class="d-flex align-items-center py-2">
                                <span class="bullet bg-primary me-3"></span>Response to Customer Feedback
                            </div>
                        </div>
                        <!--end::Permissions-->
                    </div>
                    <!--end::Card body-->
                    <!--begin::Card footer-->
                    <div class="card-footer flex-wrap pt-0">
                        <a href="apps/user-management/roles/view.html"
                            class="btn btn-light btn-active-primary my-1 me-2">View Role</a>
                        <button type="button" class="btn btn-light btn-active-light-primary my-1" data-bs-toggle="modal"
                            data-bs-target="#kt_modal_update_role">Edit Role</button>
                    </div>
                    <!--end::Card footer-->
                </div>
                <!--end::Card-->
            </div>
            <!--end::Col-->
            <!--begin::Col-->
            <div class="col-md-4">
                <!--begin::Card-->
                <div class="card card-flush h-md-100">
                    <!--begin::Card header-->
                    <div class="card-header">
                        <!--begin::Card title-->
                        <div class="card-title">
                            <h2>Trial</h2>
                        </div>
                        <!--end::Card title-->
                    </div>
                    <!--end::Card header-->
                    <!--begin::Card body-->
                    <div class="card-body pt-1">
                        <!--begin::Users-->
                        <div class="fw-bold text-gray-600 mb-5">Total users with this role: 546</div>
                        <!--end::Users-->
                        <!--begin::Permissions-->
                        <div class="d-flex flex-column text-gray-600">
                            <div class="d-flex align-items-center py-2">
                                <span class="bullet bg-primary me-3"></span>No Admin Controls
                            </div>
                            <div class="d-flex align-items-center py-2">
                                <span class="bullet bg-primary me-3"></span>View Financial Summaries only
                            </div>
                            <div class="d-flex align-items-center py-2">
                                <span class="bullet bg-primary me-3"></span>View Bulk Reports only
                            </div>
                            <div class="d-flex align-items-center py-2">
                                <span class="bullet bg-primary me-3"></span>View Payouts only
                            </div>
                            <div class="d-flex align-items-center py-2">
                                <span class="bullet bg-primary me-3"></span>View Disputes only
                            </div>
                        </div>
                        <!--end::Permissions-->
                    </div>
                    <!--end::Card body-->
                    <!--begin::Card footer-->
                    <div class="card-footer flex-wrap pt-0">
                        <a href="apps/user-management/roles/view.html"
                            class="btn btn-light btn-active-primary my-1 me-2">View Role</a>
                        <button type="button" class="btn btn-light btn-active-light-primary my-1" data-bs-toggle="modal"
                            data-bs-target="#kt_modal_update_role">Edit Role</button>
                    </div>
                    <!--end::Card footer-->
                </div>
                <!--end::Card-->
            </div>
            <!--end::Col--> --}}

        </div>

    </div>
@endsection
@push('js2')
    <script src="{{ asset('assets/js/custom/apps/user-management/roles/list/add.js') }}"></script>
    <script src="{{ asset('assets/js/custom/apps/user-management/roles/list/update-role.js') }}"></script>
    <script src="{{ asset('assets/js/widgets.bundle.js') }}"></script>
    <script src="{{ asset('assets/js/custom/widgets.js') }}"></script>
    <script src="{{ asset('assets/js/custom/apps/chat/chat.js') }}"></script>
    <script src="{{ asset('assets/js/custom/utilities/modals/users-search.js') }}"></script>
@endpush
