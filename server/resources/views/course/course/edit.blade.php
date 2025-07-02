@extends('layout.app')
@section('title', 'Update Category')
@section('main')
    <div id="kt_app_content_container" class="app-container">

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
                        action="{{ route($params['prefix'] . '.' . $params['controller'] . '.update',$params['item']->id) }}" method="POST" enctype="multipart/form-data" >
                        @csrf
                        @method('PUT')
                        <!--begin::Scroll-->

                        <div class="d-flex flex-column scroll-y me-n7 pe-7">
                            <div class="fv-row mb-10">
                                <!--begin::Label-->
                                <label class="fs-5 fw-bold form-label mb-2">
                                    <span class="required">Parent category</span>
                                </label>

                                <!--end::Label-->
                                <!--begin::Input-->

                                <select class="form-select mb-2" data-control="select2" name="parent_id"
                                    data-placeholder="Select an option" data-allow-clear="true"
                                    data-placeholder="Select an option" id="kt_ecommerce_add_product_status_select">
                                    <option value="">--Select--</option>
                                    @foreach ($params['categories'] as $item)
                                        <option {{$item->id == $params['item']->parent_id ? 'selected' : '' }} value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                                @error('parent_id')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <!--begin::Input group-->
                            <div class="fv-row mb-10">
                                <!--begin::Label-->
                                <label class="fs-5 fw-bold form-label mb-2">
                                    <span class="required">Name</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input class="form-control form-control-solid" placeholder="Enter Aa.." value="{{old('name') ?? $params['item']->name}}" name="name" />
                                @error('name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="fv-row mb-10">
                                <label class="fs-5 fw-bold form-label mb-2">
                                    <span class="required">Status</span>
                                </label>
                                 {!!\App\Models\Ecommerce\CategoryModel::slbStatus($params['item']['status'] ?? '')!!}
                                @error('status')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="fv-row mb-10">
                                <!--begin::Label-->
                                <label class="fs-5 fw-bold form-label mb-2">
                                    <span class="">Icon</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                {{-- <input type="file" class="form-control form-control-solid" placeholder="Enter Aa.."
                                    name="icon" /> --}}
                                <div class="card-body text-center pt-0">
                                    <!--begin::Image input-->
                                    <!--begin::Image input placeholder-->
                                    <style>
                                        .image-input-placeholder {
                                            background-image: url('{{$params['item']->icon_url ?? asset("assets/media/svg/files/blank-image.svg")}}');
                                        }

                                        [data-bs-theme="dark"] .image-input-placeholder {
                                            background-image: url('{{asset("assets/media/svg/files/blank-image-dark.svg")}}');
                                        }
                                    </style>
                                    <!--end::Image input placeholder-->
                                    <div class="image-input image-input-empty image-input-outline image-input-placeholder mb-3"
                                        data-kt-image-input="true">
                                        <!--begin::Preview existing avatar-->
                                        <div class="image-input-wrapper w-150px h-150px"></div>
                                        <!--end::Preview existing avatar-->
                                        <!--begin::Label-->
                                        <label
                                            class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                            data-kt-image-input-action="change" data-bs-toggle="tooltip"
                                            title="Change avatar">
                                            <i class="ki-outline ki-pencil fs-7"></i>
                                            <!--begin::Inputs-->
                                            <input type="file" name="icon" accept=".png, .jpg, .jpeg" />
                                            <input type="hidden" name="avatar_remove" />
                                            <!--end::Inputs-->
                                        </label>
                                        <!--end::Label-->
                                        <!--begin::Cancel-->
                                        <span
                                            class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                            data-kt-image-input-action="cancel" data-bs-toggle="tooltip"
                                            title="Cancel avatar">
                                            <i class="ki-outline ki-cross fs-2"></i>
                                        </span>
                                        <!--end::Cancel-->
                                        <!--begin::Remove-->
                                        <span
                                            class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                            data-kt-image-input-action="remove" data-bs-toggle="tooltip"
                                            title="Remove avatar">
                                            <i class="ki-outline ki-cross fs-2"></i>
                                        </span>
                                        <!--end::Remove-->
                                    </div>
                                    <!--end::Image input-->
                                    <!--begin::Description-->
                                    <div class="text-muted fs-7">Set the product thumbnail image. Only *.png, *.jpg and
                                        *.jpeg image files are accepted</div>
                                    <!--end::Description-->
                                </div>
                                <!--end::Input-->
                            </div>
                            <div class="fv-row mb-10">
                                <!--begin::Label-->
                                <label class="fs-5 fw-bold form-label mb-2">
                                    <span class="">Or Link Icon</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" class="form-control form-control-solid" placeholder="Enter https.."
                                    name="icon_link" value="{{$params['item']->icon_url}}" />
                                <!--end::Input-->
                            </div>

                            <!--end::Input group-->
                            <!--begin::Permissions-->

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
