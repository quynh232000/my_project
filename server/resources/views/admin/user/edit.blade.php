@extends('layout.app')
@section('title', 'Add User')
@section('main')
    <div id="kt_app_content_container" class="app-container container-xxl">
        <!--begin::Card-->
        <div class="card">
            <!--begin::Card header-->
            <div class="card-header border-0 pt-6">
                <!--begin::Card title-->
                <div class="card-title">
                    <!--begin::Search-->
                    <div class="d-flex align-items-center position-relative my-1">
                        Add user
                    </div>
                    <!--end::Search-->
                </div>

            </div>
            <!--end::Card header-->
            <!--begin::Card body-->
            <div class="card-body py-4">
                <div>
                    <div class="modal-content">
                        <!--begin::Modal header-->

                        <!--end::Modal header-->
                        <!--begin::Modal body-->
                        <div class="modal-body px-5 my-7">
                            <!--begin::Form-->
                            <form id="kt_modal_add_user_form" class="form"
                                action="{{ route($params['prefix'] . '.' . $params['controller'] . '.update',$params['item']->id) }}"
                                method="POST">
                                @csrf
                                @method("put")
                                <input type="text" hidden name="id" value="{{$params['item']->id}}">
                                <!--begin::Scroll-->
                                <div class="d-flex flex-column scroll-y px-5 px-lg-10">
                                    <!--begin::Input group-->
                                    <div class="fv-row mb-7 d-none">
                                        <!--begin::Label-->
                                        <label class="d-block fw-semibold fs-6 mb-5">Avatar</label>
                                        <!--end::Label-->
                                        <!--begin::Image placeholder-->
                                        <style>
                                            .image-input-placeholder {
                                                background-image: url({{ asset('assets/media/svg/files/blank-image.svg') }});
                                            }

                                            [data-bs-theme="dark"] .image-input-placeholder {
                                                background-image: url('{{ asset('assets/media/svg/files/blank-image-dark.svg') }}');
                                            }
                                        </style>
                                        <!--end::Image placeholder-->
                                        <!--begin::Image input-->
                                        {{-- <div class="image-input image-input-outline image-input-placeholder"
                                            data-kt-image-input="true">
                                            <!--begin::Preview existing avatar-->
                                            <div class="image-input-wrapper w-125px h-125px"
                                                style="background-image: url({{ asset('assets/media/avatars/300-6.jpg') }});">
                                            </div>
                                            <!--end::Preview existing avatar-->
                                            <!--begin::Label-->
                                            <label
                                                class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                                data-kt-image-input-action="change" data-bs-toggle="tooltip"
                                                title="Change avatar">
                                                <i class="ki-outline ki-pencil fs-7"></i>
                                                <!--begin::Inputs-->
                                                <input type="file" name="avatar" accept=".png, .jpg, .jpeg" />
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
                                        </div> --}}
                                        <!--end::Image input-->
                                        <!--begin::Hint-->
                                        <div class="form-text">Allowed file types: png, jpg, jpeg.</div>
                                        <!--end::Hint-->
                                    </div>
                                    <!--end::Input group-->
                                    <!--begin::Input group-->
                                    <div class="fv-row mb-7">
                                        <!--begin::Label-->
                                        <label class="required fw-semibold fs-6 mb-2">Full Name</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <input type="text" name="full_name"
                                            class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Full name"
                                            value="{{ old('full_name') ?? $params['item']->full_name }}" />
                                        @error('full_name')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                        <!--end::Input-->
                                    </div>
                                    <div class="fv-row mb-7">
                                        <!--begin::Label-->
                                        <label class="required fw-semibold fs-6 mb-2">Phone</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <input type="text" name="phone"
                                            class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Phone"
                                            value="{{ old('phone')?? $params['item']->phone }}" />
                                        @error('phone')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                        <!--end::Input-->
                                    </div>
                                    <!--end::Input group-->
                                    <!--begin::Input group-->
                                    <div class="fv-row mb-7">
                                        <!--begin::Label-->
                                        <label class="required fw-semibold fs-6 mb-2">Email</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <input type="email" name="email"
                                            class="form-control form-control-solid mb-3 mb-lg-0"
                                            placeholder="example@domain.com" value="{{ old('email') ?? $params['item']->email }}" />
                                        @error('email')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                        <!--end::Input-->
                                    </div>
                                    <div class="fv-row mb-7">
                                        <!--begin::Label-->
                                        <label class="required fw-semibold fs-6 mb-2">Password</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <input type="text" name="password"
                                            class="form-control form-control-solid mb-3 mb-lg-0" placeholder="********"
                                            value="" />
                                        @error('password')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                        <!--end::Input-->
                                    </div>
                                    <!--end::Input group-->
                                    <!--begin::Input group-->
                                    <div class="mb-5">
                                        <!--begin::Label-->
                                        <label class=" fw-semibold fs-6 mb-5">Add Role</label>
                                        <!--end::Label-->
                                        <!--begin::Roles-->
                                        <!--begin::Input row-->

                                        @foreach ($params['roles'] as $item)
                                            <div class="d-flex fv-row">
                                                <!--begin::Radio-->
                                                <div class="form-check form-check-custom form-check-solid">
                                                    <!--begin::Input-->
                                                    <input class="form-check-input me-3" name="role[]" type="checkbox"
                                                        value="{{ $item->id }}"
                                                       {{ in_array($item->id, $params['role_ids']) ? 'checked' : '' }}
                                                        id="kt_modal_update_role_option_0{{ $item->id }}" />
                                                    <!--end::Input-->
                                                    <!--begin::Label-->
                                                    <label class="form-check-label"
                                                        for="kt_modal_update_role_option_0{{ $item->id }}">
                                                        <div class="fw-bold text-gray-800">{{ $item->name }}</div>
                                                        <div class="text-gray-600">{{ $item->description }}</div>
                                                    </label>
                                                    <!--end::Label-->
                                                </div>
                                                <!--end::Radio-->
                                            </div>
                                            <!--end::Input row-->
                                            <div class='separator separator-dashed my-5'></div>
                                        @endforeach

                                        <!--end::Roles-->
                                    </div>
                                    <div class="mb-5">
                                        <label class=" fw-semibold fs-6 mb-5">Add Permission</label>
                                        <table class="table align-middle table-row-dashed list_permission fs-6 gy-5">
                                            <tbody class="text-gray-600 fw-semibold">
                                                 @foreach ($params['permissions'] as $type => $group)
                                                <tr>
                                                    <td>
                                                        <strong class="text-primary">{{ strtoupper($type) }}</strong>
                                                    </td>
                                                </tr>
                                                @foreach ($group as $permission)
                                                    <tr>
                                                        <!--begin::Label-->
                                                        <td class="text-gray-800">{{ ucfirst($permission['uri']) }}
                                                            Action</td>
                                                        <!--end::Label-->
                                                        <!--begin::Options-->
                                                        <td>
                                                            <!--begin::Wrapper-->
                                                            <div class="d-flex">
                                                                <label
                                                                    class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
                                                                    <input class="form-check-input input_check_item" type="checkbox"
                                                                        value="{{ $permission['id'] }}"
                                                                         {{ in_array($permission['id'], $params['permission_ids']) ? 'checked' : '' }}
                                                                        name="permission[]" />
                                                                    <span
                                                                        class="form-check-label">{{ ucfirst($permission['name']) }}</span>
                                                                </label>


                                                            </div>
                                                            <!--end::Wrapper-->
                                                        </td>
                                                        <!--end::Options-->
                                                    </tr>
                                                @endforeach
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <!--end::Input group-->
                                </div>
                                <!--end::Scroll-->
                                <!--begin::Actions-->
                                <div class="text-center pt-10">

                                    <button type="submit" class="btn btn-primary" data-kt-users-modal-action="submit">
                                        <span class="indicator-label">Save</span>
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
                </div>
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Card-->
    </div>
@endsection

@push('js2')
    <script src="{{ asset('assets/js/custom/apps/user-management/users/list/table.js') }}"></script>
    <script src="{{ asset('assets/js/custom/apps/user-management/users/list/export-users.js') }}"></script>
    <script src="{{ asset('assets/js/custom/apps/user-management/users/list/add.js') }}"></script>
    <script src="{{ asset('assets/js/widgets.bundle.js') }}"></script>
    <script src="{{ asset('assets/js/custom/widgets.js') }}"></script>
    <script src="{{ asset('assets/js/custom/apps/chat/chat.js') }}"></script>
    <script src="{{ asset('assets/js/custom/utilities/modals/users-search.js') }}"></script>
@endpush
