@extends('layout.app')
@section('title', 'Edit ' . $params['controller'])
@section('main')
    <div id="kt_app_content_container" class="app-container">
        <!--begin::Card-->
        <div class="card">

            <div class="card-body py-4">
                <div>
                    <div class="modal-content">
                        <!--begin::Modal header-->
                        <div class="modal-header px-5 pt-5">
                            <!--begin::Modal title-->
                            <h2 class="fw-bold">Edit {{ $params['controller'] }}</h2>
                            <!--end::Modal title-->
                            @include('include.btn.back')
                        </div>
                        <!--end::Modal header-->
                        <!--begin::Modal body-->
                        <div class="modal-body px-5 my-7">
                            <!--begin::Form-->
                            <form id="kt_modal_add_user_form" class="form"
                                action="{{ route($params['prefix'] . '.' . $params['controller'] . '.update', $params['item']->id) }}"
                                enctype="multipart/form-data"
                                method="POST">
                                @csrf
                                @method('put')
                                <input type="text" hidden name="id" value="{{ $params['item']->id }}">
                                <!--begin::Scroll-->
                                <div class="d-flex flex-column scroll-y px-5 px-lg-10">
                                    <!--begin::Input group-->
                                    <div class="fv-row mb-7 ">
                                        <!--begin::Label-->
                                        <label class="d-block fw-semibold fs-6 mb-5">Avatar</label>
                                        <!--end::Label-->
                                        <!--begin::Image placeholder-->
                                        <style>
                                            .image-input-placeholder {
                                                background-image: url({{$params['item']->avatar ??  asset('assets/media/svg/files/blank-image.svg') }});
                                            }

                                            [data-bs-theme="dark"] .image-input-placeholder {
                                                background-image: url('{{ asset('assets/media/svg/files/blank-image-dark.svg') }}');
                                            }
                                        </style>
                                        <!--end::Image placeholder-->
                                        <!--begin::Image input-->
                                        <div class="image-input image-input-outline image-input-placeholder"
                                            data-kt-image-input="true">
                                            <!--begin::Preview existing avatar-->
                                            <div class="image-input-wrapper w-125px h-125px"
                                                style="background-image: url({{$params['item']->avatar ?? asset('assets/media/avatars/300-6.jpg') }});">
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
                                        </div>
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
                                            value="{{ old('phone') ?? $params['item']->phone }}" />
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
                                            placeholder="example@domain.com"
                                            value="{{ old('email') ?? $params['item']->email }}" />
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

                                    <div class="fv-row">
                                        <div class="fv-row">
                                            <label class="fs-5 fw-bold form-label mb-4">Add Permissions</label>

                                            <!-- Select All + Counter + Toggle All -->
                                            <div class="d-flex justify-content-between align-items-center mb-3">
                                                <label class="form-check form-check-warning form-check-solid mb-0">
                                                    <input type="checkbox" class="form-check-input"
                                                        id="selectAllPermissions">
                                                    <span class="form-check-label">Select All Permissions</span>
                                                </label>

                                                <div class="d-flex align-items-center gap-3">
                                                    <span id="permissionCounter" class="text-muted small">
                                                        Selected: {{ count($params['permission_ids'] ?? []) }} /
                                                        {{ collect($params['permissions'])->flatten(1)->count() }}
                                                        permissions
                                                    </span>
                                                    <button type="button" id="toggleAllGroups"
                                                        class="btn btn-warning btn-sm">
                                                        <i class="fa-solid fa-gear me-2"></i>
                                                        Toggle All Groups
                                                    </button>
                                                </div>
                                            </div>

                                            <!-- Accordion groups -->
                                            <div class="accordion" id="permissionsAccordion">
                                                @foreach ($params['permissions'] as $type => $group)
                                                    @php $groupId = 'perm_' . md5($type); @endphp
                                                    <div class="card mb-2">
                                                        <div
                                                            class="card-header d-flex justify-content-between align-items-center">
                                                            <div class="d-flex  align-items-center">
                                                                <label
                                                                    class="form-check form-check-success form-check-solid me-3">
                                                                    <input type="checkbox"
                                                                        class="form-check-input checkGroup"
                                                                        data-group="{{ $groupId }}">
                                                                </label>
                                                                <button class="btn btn-sm btn-link toggle-perm"
                                                                    type="button" data-bs-toggle="collapse"
                                                                    data-bs-target="#collapse-{{ $groupId }}">
                                                                    <i class="bi bi-chevron-down me-1 toggle-icon"></i>
                                                                    <strong>{{ strtoupper($type) }}</strong>
                                                                </button>
                                                            </div>
                                                        </div>

                                                        <div id="collapse-{{ $groupId }}" class="collapse show"
                                                            data-bs-parent="#permissionsAccordion">
                                                            <div class="card-body">
                                                                <div class="row">
                                                                    @foreach ($group as $permission)
                                                                        <div class="col-md-6 mb-2">
                                                                            <label
                                                                                class="form-check form-check-custom form-check-solid">
                                                                                <input
                                                                                    class="form-check-input input_check_item"
                                                                                    type="checkbox"
                                                                                    value="{{ $permission['id'] }}"
                                                                                    name="permission[]"
                                                                                    data-group="{{ $groupId }}"
                                                                                    {{ in_array($permission['id'], $params['permission_ids'] ?? []) ? 'checked' : '' }}>
                                                                                <span class="form-check-label">
                                                                                    {{ ucfirst($permission['name']) }}
                                                                                    <small
                                                                                        class="text-muted">({{ $permission['uri'] }})</small>
                                                                                </span>
                                                                            </label>
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    <!--end::Input group-->
                                </div>
                                <!--end::Scroll-->
                                <!--begin::Actions-->
                                <div class="text-center pt-10 fixed-bottom-bar">

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

    <script>
        function syncParentCheckboxes() {
            // Đồng bộ từng nhóm
            $('.checkGroup').each(function() {
                const group = $(this).data('group');
                const $items = $(`.input_check_item[data-group="${group}"]`);
                const $checkedItems = $items.filter(':checked');

                $(this).prop('checked', $items.length === $checkedItems.length);
            });

            // Đồng bộ select all toàn cục
            const total = $('input.input_check_item').length;
            const selected = $('input.input_check_item:checked').length;
            $('#selectAllPermissions').prop('checked', selected === total);
        }

        $(document).ready(function() {
            syncParentCheckboxes();
            let allExpanded = true;

            // Đếm permission đã chọn
            function updatePermissionCounter() {
                const selected = $('input.input_check_item:checked').length;
                const total = $('input.input_check_item').length;
                $('#permissionCounter').text(`Selected: ${selected} / ${total} permissions`);
            }

            // Khởi tạo trạng thái icon toggle
            $('.toggle-perm').each(function() {
                const $btn = $(this);
                const $icon = $btn.find('.toggle-icon');
                const targetId = $btn.data('bs-target');
                const $collapse = $(targetId);

                $icon.toggleClass('bi-chevron-down', $collapse.hasClass('show'));
                $icon.toggleClass('bi-chevron-right', !$collapse.hasClass('show'));

                $collapse.on('show.bs.collapse', function() {
                    $icon.removeClass('bi-chevron-right').addClass('bi-chevron-down');
                });

                $collapse.on('hide.bs.collapse', function() {
                    $icon.removeClass('bi-chevron-down').addClass('bi-chevron-right');
                });
            });

            // Toggle All Groups
            $('#toggleAllGroups').on('click', function() {
                if (allExpanded) {
                    $('.collapse.show').collapse('hide');
                } else {
                    $('.collapse:not(.show)').collapse('show');
                }
                allExpanded = !allExpanded;
            });

            // Check all nhóm
            $('.checkGroup').on('change', function() {
                const group = $(this).data('group');
                const isChecked = $(this).is(':checked');
                $(`input.input_check_item[data-group="${group}"]`).prop('checked', isChecked);
                updatePermissionCounter();
            });

            // Check all toàn bộ
            $('#selectAllPermissions').on('change', function() {
                const checked = $(this).is(':checked');
                $('input.input_check_item, .checkGroup').prop('checked', checked);
                updatePermissionCounter();
            });

            // Khi tick/bỏ từng item
            $(document).on('change', 'input.input_check_item', function() {
                updatePermissionCounter();
            });

            updatePermissionCounter(); // khởi tạo ban đầu
        });
    </script>
@endpush
