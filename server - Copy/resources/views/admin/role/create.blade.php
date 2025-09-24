@extends('layout.app')
@section('title', 'Create a new '.$params['controller'] )
@section('main')
    <div id="kt_app_content_container" class="app-container">

        <div class="card card-flush">
            <!--begin::Modal content-->
            <div class="modal-content">
                <!--begin::Modal header-->
                <div class="modal-header px-5 pt-5">
                    <!--begin::Modal title-->
                    <h2 class="fw-bold">Add a new {{$params['controller'] }}</h2>
                    <!--end::Modal title-->
                   @include('include.btn.back')
                </div>

                <!--end::Modal header-->
                <!--begin::Modal body-->
                <div class=" mx-lg-5 my-7">
                    <!--begin::Form-->
                    <form id="" class="form"
                        action="{{ route($params['prefix'] . '.' . $params['controller'] . '.store') }}" method="POST">
                        @csrf
                        <!--begin::Scroll-->
                        <div class="d-flex flex-column scroll-y me-n7 pe-7">
                            <!--begin::Input group-->
                            <div class="fv-row mb-10">
                                <!--begin::Label-->
                                <label class="fs-5 fw-bold form-label mb-2">
                                    <span class="required">Role name</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input class="form-control form-control-solid" placeholder="Enter a role name"
                                    name="name" />
                                <!--end::Input-->
                            </div>
                            <div class="fv-row mb-10">
                                <!--begin::Label-->
                                <label class="fs-5 fw-bold form-label mb-2">
                                    <span class="">Description</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <textarea name="description" id="" cols="30" rows="3" class="form-control form-control-solid"
                                    placeholder="Enter description.."></textarea>

                                <!--end::Input-->
                            </div>

                            <div class="fv-row">
                                <label class="fs-5 fw-bold form-label mb-4">Role Permissions</label>

                                <!-- Nút chọn tất cả -->
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <label class="form-check form-check-warning form-check-solid mb-0">
                                        <input type="checkbox" class="form-check-input" id="selectAllPermissions">
                                        <span class="form-check-label">Select All Permissions</span>
                                    </label>

                                    <div class="d-flex align-items-center gap-3">
                                        <span id="permissionCounter" class="text-muted small">
                                            Selected: 0 / {{ collect($params['items'])->flatten(1)->count() }} permissions
                                        </span>
                                        <button type="button" id="toggleAllGroups" class="btn btn-warning btn-sm">
                                            <i class="fa-solid fa-gear me-2"></i>
                                            Toggle All Groups
                                        </button>
                                    </div>
                                </div>


                                <div class="accordion" id="permissionsAccordion">
                                    @foreach ($params['items'] as $type => $group)
                                        @php $groupId = 'perm_' . md5($type); @endphp
                                        <div class="card mb-2">
                                            <div class="card-header d-flex justify-content-between align-items-center">
                                                <div class="d-flex align-items-center">
                                                    <label class="form-check form-check-success form-check-solid me-3">
                                                        <input type="checkbox" class="form-check-input checkGroup"
                                                            data-group="{{ $groupId }}">
                                                    </label>
                                                    <button class="btn btn-sm btn-link toggle-perm" type="button"
                                                        data-bs-toggle="collapse"
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
                                                                    <input class="form-check-input input_check_item"
                                                                        type="checkbox" value="{{ $permission['id'] }}"
                                                                        name="permission[]"
                                                                        data-group="{{ $groupId }}">
                                                                    <span class="form-check-label">
                                                                        {{ ucfirst($permission['name']) }} <small
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

                            <!--end::Permissions-->
                        </div>
                        <!--end::Scroll-->
                        <!--begin::Actions-->
                        <div class="text-center pt-15 fixed-bottom-bar">
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
    <script src="{{ asset('assets/js/custom/apps/user-management/roles/list/add.js') }}"></script>
    <script src="{{ asset('assets/js/custom/apps/user-management/roles/list/update-role.js') }}"></script>
    <script src="{{ asset('assets/js/widgets.bundle.js') }}"></script>
    <script src="{{ asset('assets/js/custom/widgets.js') }}"></script>
    <script src="{{ asset('assets/js/custom/apps/chat/chat.js') }}"></script>
    <script src="{{ asset('assets/js/custom/utilities/modals/users-search.js') }}"></script>
    <script>
        $('#kt_roles_select_all').on('change', function(e) {
            $('.input_check_item').prop('checked', $(this).prop('checked'))


        })
    </script>
    <script>
        $(document).ready(function() {
            // Toggle icon trong từng nhóm
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

            // Check all trong nhóm
            $('.checkGroup').on('change', function() {
                const group = $(this).data('group');
                const isChecked = $(this).is(':checked');
                $(`input.input_check_item[data-group="${group}"]`).prop('checked', isChecked);
            });

            // Chọn tất cả
            $('#selectAllPermissions').on('change', function() {
                const checked = $(this).is(':checked');
                $('input.input_check_item, .checkGroup').prop('checked', checked);
            });
        });

        // toggle all
        $(document).ready(function() {
            let allExpanded = true;

            // Toggle icon trong từng nhóm (như trước)
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

            // Check group
            $('.checkGroup').on('change', function() {
                const group = $(this).data('group');
                const isChecked = $(this).is(':checked');
                $(`input.input_check_item[data-group="${group}"]`).prop('checked', isChecked);
            });

            // Check all
            $('#selectAllPermissions').on('change', function() {
                const checked = $(this).is(':checked');
                $('input.input_check_item, .checkGroup').prop('checked', checked);
            });
        });

        // count selected
        // Hàm cập nhật bộ đếm
        function updatePermissionCounter() {
            const selected = $('input.input_check_item:checked').length;
            const total = $('input.input_check_item').length;
            $('#permissionCounter').text(`Selected: ${selected} / ${total} permissions`);
        }

        // Gọi khi thay đổi
        $(document).on('change', 'input.input_check_item, #selectAllPermissions, .checkGroup', function() {
            updatePermissionCounter();
        });

        // Khởi tạo ban đầu
        updatePermissionCounter();
    </script>
@endpush
