@extends('layout.app')
@section('title', 'Manage ' . $params['controller'])

@section('main')
    <style>
        .fixed-submit {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 1050;
        }

        .fixed-submit .btn {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            padding: 10px 18px;
        }
    </style>
    <div id="kt_app_content_container" class="app-container">
        <!--begin::Card-->
        <div class="card card-flush">
            <div class="card-body pt-0">
                <!--begin::Row-->
                <h1 class="mb-4 mt-4">Routes not set Permission ( <i><small>{{ count($routes) }}</small></i> )</h1>

                <form action="{{ route($params['prefix'] . '.' . $params['controller'] . '.bulkStore') }}" method="POST">
                    @csrf

                    <div class="mb-3 mt-5 d-flex justify-content-between">
                        <div title="Chọn tất cả"
                            class="form-check form-check-sm form-check-custom form-check-danger checkbox-toggle form-check-solid me-3 mt-3 d-flex"
                            style="gap: 5px">
                            <input id="checkAllGlobal" class="form-check-input" type="checkbox" data-kt-check="true"
                                data-kt-check-target="#kt_ecommerce_products_table .form-check-input">
                            <label for="checkAllGlobal" class="ml-3">
                                <strong>Select All</strong>
                            </label>
                        </div>
                        <div class="mb-3">
                            <button type="button" id="toggleAllCollapse" class="btn btn-warning btn-sm">
                              <i class="fa-solid fa-gear me-2"></i>  Toggle All Groups
                            </button>
                        </div>
                    </div>

                    @php
                        $grouped = collect($routes)->groupBy(fn($r) => explode('@', $r['action'])[0]); // Group theo Controller
                    @endphp

                    @foreach ($grouped as $controller => $group)
                        @php $groupId = md5($controller); @endphp

                        <div class="card mb-3">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="form-check form-check-sm form-check-custom checkbox-toggle form-check-solid me-3 mt-3 d-flex"
                                        style="gap: 5px">
                                        <input id="data-group{{ $groupId }}" class="form-check-input checkGroup"
                                            type="checkbox" data-group="{{ $groupId }}">
                                        <label for="data-group{{ $groupId }}" class="ml-3">
                                            <strong>{{ $loop->iteration }}. {{ class_basename($controller) }}</strong>
                                        </label>
                                    </div>

                                </div>
                                <button type="button" class="btn btn-sm btn-link toggle-btn" data-bs-toggle="collapse"
                                    data-bs-target="#collapse-{{ $groupId }}" aria-expanded="true"
                                    aria-controls="collapse-{{ $groupId }}">
                                    <i class="bi bi-chevron-down me-1 toggle-icon"></i> Toggle
                                </button>
                            </div>

                            <div class="collapse show" id="collapse-{{ $groupId }}">
                                <div class="card-body table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th style="width: 30%">Route Name</th>
                                                <th style="width: 30%">URI</th>
                                                <th style="width: 5%">Method</th>
                                                <th style="width: 30%">Permission Name</th>
                                                <th style="width: 5%">Select</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php

                                                $dataMethod = [
                                                    'GET|HEAD' => 'primary',
                                                    'POST' => 'success',
                                                    'PUT' => 'warning',
                                                    'DELETE' => 'danger',
                                                    'PUT|PATCH' => 'warning',
                                                ];
                                            @endphp
                                            @foreach ($group as $route)
                                                <tr>
                                                    <td>{{ $route['name'] }}</td>
                                                    <td>{{ $route['uri'] }}</td>
                                                    <td><span
                                                            class="badge bg-{{ isset($dataMethod[$route['method']]) ? $dataMethod[$route['method']] : 'success' }} text-white">{{ $route['method'] }}</span>
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control"
                                                            name="routes[{{ $route['name'] }}][permission_name]"
                                                            value="{{ Str::replace('.', '_', $route['name']) }}">
                                                    </td>
                                                    <td>
                                                        <div class="form-check form-check-sm form-check-custom checkbox-toggle form-check-solid me-3 mt-3 d-flex"
                                                            style="gap: 5px">
                                                            <input class="form-check-input checkItem" type="checkbox"
                                                                name="routes[{{ $route['name'] }}][selected]"
                                                                value="1" data-group="{{ $groupId }}">
                                                        </div>
                                                        <input type="hidden"
                                                            name="routes[{{ $route['name'] }}][route_name]"
                                                            value="{{ $route['name'] }}">
                                                        <input type="hidden" name="routes[{{ $route['name'] }}][uri]"
                                                            value="{{ $route['uri'] }}">
                                                        <input type="hidden" name="routes[{{ $route['name'] }}][method]"
                                                            value="{{ $route['method'] }}">
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    <div class="fixed-submit">
                        <button type="submit" class="btn btn-primary">
                            Add All Selected
                        </button>
                    </div>
                </form>




            </div>



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
    <script>
        $(document).ready(function() {
            // toggle icon
            $('.toggle-btn').each(function() {
                const $btn = $(this);
                const $icon = $btn.find('.toggle-icon');
                const targetId = $btn.data('bs-target');

                const $collapse = $(targetId);

                // Khởi tạo icon theo trạng thái ban đầu
                $icon.toggleClass('bi-chevron-down', $collapse.hasClass('show'));
                $icon.toggleClass('bi-chevron-right', !$collapse.hasClass('show'));

                // Lắng nghe sự kiện show/hide
                $collapse.on('show.bs.collapse', function() {
                    $icon.removeClass('bi-chevron-right').addClass('bi-chevron-down');
                });

                $collapse.on('hide.bs.collapse', function() {
                    $icon.removeClass('bi-chevron-down').addClass('bi-chevron-right');
                });
            });

            // toggle all
            let allExpanded = true; // trạng thái hiện tại

            $('#toggleAllCollapse').on('click', function() {
                if (allExpanded) {
                    $('.collapse.show').collapse('hide');
                } else {
                    $('.collapse:not(.show)').collapse('show');
                }
                allExpanded = !allExpanded;
            });

            // Đồng bộ icon khi đóng/mở
            $('.toggle-btn').each(function() {
                const $btn = $(this);
                const $icon = $btn.find('.toggle-icon');
                const targetId = $btn.data('bs-target');
                const $collapse = $(targetId);

                // Khởi tạo icon theo trạng thái ban đầu
                $icon.toggleClass('bi-chevron-down', $collapse.hasClass('show'));
                $icon.toggleClass('bi-chevron-right', !$collapse.hasClass('show'));

                $collapse.on('show.bs.collapse', function() {
                    $icon.removeClass('bi-chevron-right').addClass('bi-chevron-down');
                });

                $collapse.on('hide.bs.collapse', function() {
                    $icon.removeClass('bi-chevron-down').addClass('bi-chevron-right');
                });
            });



        });
        // Chọn tất cả trong từng nhóm
        $('.checkGroup').on('change', function() {
            const group = $(this).data('group');
            $(`.checkItem[data-group="${group}"]`).prop('checked', $(this).is(':checked'));
        });

        // Chọn tất cả toàn cục
        $('#checkAllGlobal').on('change', function() {
            const checked = $(this).is(':checked');
            $('.checkItem, .checkGroup').prop('checked', checked);
        });
    </script>

    <!--end::Custom Javascript-->
    <!--end::Javascript-->
@endpush
