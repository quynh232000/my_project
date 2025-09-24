@extends('layout.app')
@section('title', 'Organization Listing')
@section('main')
    <div id="kt_app_content_container" class="app-container container-xxl">
        <!--begin::Card-->
        <div class="card card-flush">
            <!--begin::Card header-->
            <div class="card-header mt-6">
                <!--begin::Card title-->
                <div class="card-title">
                    <!--begin::Search-->
                    <div class="d-flex align-items-center position-relative my-1 me-5">
                        <i class="ki-outline ki-magnifier fs-3 position-absolute ms-5"></i>
                        <input type="text" data-kt-permissions-table-filter="search"
                            class="form-control form-control-solid w-250px ps-13" placeholder="Search Permissions" />
                    </div>
                    <!--end::Search-->
                </div>
                <!--end::Card title-->
                <!--begin::Card toolbar-->
                <div class="card-toolbar">
                    <!--begin::Button-->
                    <button type="button" class="btn btn-light-primary" data-bs-toggle="modal"
                        data-bs-target="#kt_modal_add_permission">
                        <i class="ki-outline ki-plus-square fs-3"></i>Add Organization</button>
                    <!--end::Button-->
                </div>
                <!--end::Card toolbar-->
            </div>
            <!--end::Card header-->
            <!--begin::Card body-->
            <div class="card-body pt-0">
                <!--begin::Table-->
                <table class="table align-middle table-row-dashed fs-6 gy-5 mb-0" id="kt_permissions_table">
                    <thead>
                        <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                            <th class="min-w-125px">ID</th>
                            <th class="min-w-125px">Name</th>
                            <th class="min-w-250px">Slug</th>
                            <th class="min-w-250px">Status</th>
                            <th class="min-w-125px">Created Date</th>
                            <th class="text-end min-w-100px">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="fw-semibold text-gray-600">
                        @forelse ($params['data'] as $item)
                            <tr>
                                <td>#{{ $item->id }}</td>
                                <td>{{ $item->name }}</td>
                                <td>
                                    {{ $item->slug }}
                                </td>
                                <td>
                                    @if ($item->status == 'active')
                                        <a href="apps/user-management/roles/view.html"
                                            class="badge badge-light-primary fs-7 m-1">Active</a>
                                    @else
                                        <a href="apps/user-management/roles/view.html"
                                            class="badge badge-light-danger fs-7 m-1">Inactive</a>
                                    @endif

                                </td>
                                <td>{{ $item->created_at }}</td>
                                <td class="text-end">
                                    <button class="btn btn-icon btn-active-light-primary w-30px h-30px me-3"
                                        data-bs-toggle="modal" data-bs-target="#kt_modal_update_permission">
                                        <i class="ki-outline ki-setting-3 fs-3"></i>
                                    </button>
                                    <button class="btn btn-icon btn-active-light-primary w-30px h-30px"
                                        data-kt-permissions-table-filter="delete_row">
                                        <i class="ki-outline ki-trash fs-3"></i>
                                    </button>
                                </td>
                            </tr>

                        @empty
                            <tr>
                                <td>No data found</td>
                            </tr>
                        @endforelse

                    </tbody>
                </table>
                <!--end::Table-->
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Card-->
        <!--begin::Modals-->
        <!--begin::Modal - Add permissions-->
        <div class="modal fade" id="kt_modal_add_permission" tabindex="-1" aria-hidden="true">
            <!--begin::Modal dialog-->
            <div class="modal-dialog modal-dialog-centered mw-650px">
                <!--begin::Modal content-->
                <div class="modal-content">
                    <!--begin::Modal header-->
                    <div class="modal-header">
                        <!--begin::Modal title-->
                        <h2 class="fw-bold">Add a Organization</h2>
                        <!--end::Modal title-->
                        <!--begin::Close-->
                        <div class="btn btn-icon btn-sm btn-active-icon-primary" data-kt-permissions-modal-action="close">
                            <i class="ki-outline ki-cross fs-1"></i>
                        </div>
                        <!--end::Close-->
                    </div>
                    <!--end::Modal header-->
                    <!--begin::Modal body-->
                    <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                        <!--begin::Form-->
                        <form id="" class="form" method="POST"
                            action="{{ route($params['prefix'] . '.' . $params['controller'] . '.store') }}">
                            <!--begin::Heading-->
                            @csrf
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="fs-6 fw-semibold form-label mb-2">
                                    <span class="required">Organization Name</span>
                                    <span class="ms-2" data-bs-toggle="popover" data-bs-trigger="hover"
                                        data-bs-html="true" data-bs-content="Organization names is required to be unique.">
                                        <i class="ki-outline ki-information fs-7"></i>
                                    </span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input class="form-control form-control-solid" value="{{ old('name') }}"
                                    placeholder="Enter a Organization name" name="name" />
                                @error('name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                                <!--end::Input-->
                            </div>
                            <div>
                                <!--begin::Label-->
                                <label class="form-label">Description</label>
                                <!--end::Label-->
                                <!--begin::Editor-->
                                <textarea class="form-control form-control-solid" name="description" id="" cols="12" rows="5">{{ old('description') }}</textarea>

                                <!--begin::Description-->
                                <div class="text-muted fs-7 mt-2">Set a description to the Organization for better
                                    visibility.</div>
                                <!--end::Description-->
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->

                            <div class="text-center pt-15">
                                <button type="reset" class="btn btn-light me-3"
                                    data-kt-permissions-modal-action="cancel">Discard</button>
                                <button type="submit" class="btn btn-primary">
                                    <span class="indicator-label">Submit</span>
                                    <span class="indicator-progress">Please wait...
                                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                </button>
                            </div>
                            <!--end::Actions-->
                        </form>
                        <!--end::Form-->
                    </div>
                    <!--end::Modal body-->
                </div>
                <!--end::Modal content-->
            </div>
            <!--end::Modal dialog-->
        </div>
        <!--end::Modal - Add permissions-->
        <!--begin::Modal - Update permissions-->
        <div class="modal fade" id="kt_modal_update_permission" tabindex="-1" aria-hidden="true">
            <!--begin::Modal dialog-->
            <div class="modal-dialog modal-dialog-centered mw-650px">
                <!--begin::Modal content-->
                <div class="modal-content">
                    <!--begin::Modal header-->
                    <div class="modal-header">
                        <!--begin::Modal title-->
                        <h2 class="fw-bold">Update Permission</h2>
                        <!--end::Modal title-->
                        <!--begin::Close-->
                        <div class="btn btn-icon btn-sm btn-active-icon-primary" data-kt-permissions-modal-action="close">
                            <i class="ki-outline ki-cross fs-1"></i>
                        </div>
                        <!--end::Close-->
                    </div>
                    <!--end::Modal header-->
                    <!--begin::Modal body-->
                    <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                        <!--begin::Notice-->
                        <!--begin::Notice-->
                        <div class="notice d-flex bg-light-warning rounded border-warning border border-dashed mb-9 p-6">
                            <!--begin::Icon-->
                            <i class="ki-outline ki-information fs-2tx text-warning me-4"></i>
                            <!--end::Icon-->
                            <!--begin::Wrapper-->
                            <div class="d-flex flex-stack flex-grow-1">
                                <!--begin::Content-->
                                <div class="fw-semibold">
                                    <div class="fs-6 text-gray-700">
                                        <strong class="me-1">Warning!</strong>By editing the permission name, you might
                                        break the system permissions functionality. Please ensure you're absolutely certain
                                        before proceeding.
                                    </div>
                                </div>
                                <!--end::Content-->
                            </div>
                            <!--end::Wrapper-->
                        </div>
                        <!--end::Notice-->
                        <!--end::Notice-->
                        <!--begin::Form-->

                        <form id="kt_modal_update_permission_form" class="form" method="POST"
                            action="{{ route($params['prefix'] . '.' . $params['controller'] . '.store') }}">
                            <!--begin::Heading-->
                            @csrf
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="fs-6 fw-semibold form-label mb-2">
                                    <span class="required">Organization Name</span>
                                    <span class="ms-2" data-bs-toggle="popover" data-bs-trigger="hover"
                                        data-bs-html="true"
                                        data-bs-content="Organization names is required to be unique.">
                                        <i class="ki-outline ki-information fs-7"></i>
                                    </span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input class="form-control form-control-solid" value="{{ old('name') }}"
                                    placeholder="Enter a Organization name" name="name" />
                                @error('name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                                <!--end::Input-->
                            </div>
                            <div>
                                <!--begin::Label-->
                                <label class="form-label">Description</label>
                                <!--end::Label-->
                                <!--begin::Editor-->
                                <textarea class="form-control form-control-solid" name="description" id="" cols="12" rows="5">{{ old('description') }}</textarea>

                                <!--begin::Description-->
                                <div class="text-muted fs-7 mt-2">Set a description to the Organization for better
                                    visibility.</div>
                                <!--end::Description-->
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->

                            <div class="text-center pt-15">
                                <button type="reset" class="btn btn-light me-3"
                                    data-kt-permissions-modal-action="cancel">Discard</button>
                                <button type="submit" class="btn btn-primary">
                                    <span class="indicator-label">Submit</span>
                                    <span class="indicator-progress">Please wait...
                                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                </button>
                            </div>
                            <!--end::Actions-->
                        </form>
                        <!--end::Form-->
                    </div>
                    <!--end::Modal body-->
                </div>
                <!--end::Modal content-->
            </div>
            <!--end::Modal dialog-->
        </div>
        <!--end::Modal - Update permissions-->
        <!--end::Modals-->
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


    <script src="{{ asset('assets/js/custom/apps/ecommerce/catalog/save-category.js') }}"></script>

    <!--end::Javascript-->
@endpush
