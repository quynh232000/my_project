@extends('layout.app')
@section('title', 'Update Category')
@section('main')
    <div id="kt_app_content_container" class="app-container container-xxl">

        <div class="card card-flush">
            <!--begin::Modal content-->
            <div class="modal-content">
                <!--begin::Modal header-->
                <div class="modal-header px-5 pt-5">
                    <h2 class="fw-bold">Update Infomation</h2>
                    <!--end::Modal title-->
                    <!--begin::Close-->
                    <a href="{{ route($params['prefix'] . '.' . $params['controller'] . '.index') }}" class="btn  btn-danger">
                        Back
                    </a>

                </div>

                <!--end::Modal header-->
                <!--begin::Modal body-->
                <div class=" mx-lg-5 my-7">
                    <!--begin::Form-->
                    <form id="" class="form"
                        action="{{ route($params['prefix'] . '.' . $params['controller'] . '.update', $params['item']->id) }}"
                        method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <!--begin::Scroll-->

                        <div class="d-flex flex-column scroll-y me-n7 pe-7">

                            <!--begin::Input group-->
                            <div class="fv-row mb-10">
                                <!--begin::Label-->
                                <label class="fs-5 fw-bold form-label mb-2">
                                    <span class="required">Type</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input class="form-control form-control-solid" placeholder="Enter Aa.."
                                    value="{{ old('type') ?? $params['item']->type }}" name="type" />
                                @error('type')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="fv-row mb-10">
                                <!--begin::Label-->
                                <label class="fs-5 fw-bold form-label mb-2">
                                    <span class="required">Key</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input class="form-control form-control-solid" placeholder="Enter Aa.."
                                    value="{{ old('key') ?? $params['item']->key }}" name="key" />
                                @error('key')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="fv-row mb-10">
                                <!--begin::Label-->
                                <label class="fs-5 fw-bold form-label mb-2">
                                    <span class="required">Value</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input class="form-control form-control-solid" placeholder="Enter Aa.."
                                    value="{{ old('value') ?? $params['item']->value }}" name="value" />
                                @error('value')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="fv-row mb-10">
                                <!--begin::Label-->
                                <label class="fs-5 fw-bold form-label mb-2">
                                    <span class="required">Description</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input class="form-control form-control-solid" placeholder="Enter Aa.."
                                    value="{{ old('description') ?? $params['item']->description }}" name="description" />
                                @error('description')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>


                        </div>
                        <!--end::Scroll-->
                        <!--begin::Actions-->
                        <div class="text-center pt-15">
                            <button type="submit" class="btn btn-primary" data-kt-roles-modal-action="submit">
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
