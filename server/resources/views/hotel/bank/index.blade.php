@extends('layout.app')
@php
    $model = $params['model'];
@endphp
@section('title', trans('Manage ' . $params['controller']))



@section('main')
    <div id="kt_app_content_container" class="app-container">
        <!--begin::Card-->

        <div class="card card-flush">
            <!--begin::Card header-->
            <div class="card-header border-0 pt-6">

                <!--begin::Card title-->
                <div class="w-100">
                    <div class="row">
                        <div class="card-toolbar col-12 d-flex justify-content-end">
                            <!--begin::Toolbar-->
                            <div class="d-flex justify-content-end" style="gap: 10px" data-kt-user-table-toolbar="base">
                                @include('include.btn.delete')
                                @include('include.btn.create')
                            </div>
                        </div>
                    </div>

                    <form class="form-horizontal" method="GET" enctype="multipart/form-data"
                        id="admin-form-{{ $params['prefix'] }}-{{ $params['controller'] }}"
                        name="admin-form-{{ $params['prefix'] }}-{{ $params['controller'] }}">
                        <div class="row m-0 pt-2">
                            <div class="form-group col-3 p-2 mb-0">
                                <label for="name" class="font-weight-normal">Tên </label>
                                <input id="name" name="name"
                                    value="{{ isset($params['name']) && !empty($params['name']) ? $params['name'] : '' }}"
                                    type="text" class="form-control event-enter" placeholder="Nhập...">
                            </div>
                            <div class="form-group col-3 p-2 mb-0">
                                <label for="short_name" class="font-weight-normal">Tên viết tắt</label>
                                <input id="short_name" name="short_name"
                                    value="{{ isset($params['short_name']) && !empty($params['short_name']) ? $params['short_name'] : '' }}"
                                    type="text" class="form-control event-enter" placeholder="Nhập...">
                            </div>
                            <div class="form-group col-3 p-2 mb-0">
                                <label for="code" class="font-weight-normal">Code</label>
                                <input id="code" name="code"
                                    value="{{ isset($params['code']) && !empty($params['code']) ? $params['code'] : '' }}"
                                    type="text" class="form-control event-enter" placeholder="Nhập...">
                            </div>
                            <div class="form-group col-3 mb-0">
                                <label class="col-form-label text-right" for="status">Trạng Thái </label>
                                {!! \App\Models\Hotel\BankModel::slbStatus(
                                    isset($params['status']) && !empty($params['status']) ? $params['status'] : '',
                                ) !!}
                                <div class="input-error"></div>
                            </div>
                            <div class="form-group col-3 p-2 mb-0">
                                <label for="full_name" class="font-weight-normal">Người tạo</label>
                                <input id="full_name" name="full_name"
                                    value="{{ isset($params['full_name']) && !empty($params['full_name']) ? $params['full_name'] : '' }}"
                                    type="text" class="form-control event-enter" placeholder="Nhập tên người tạo">
                            </div>
                            <div class="form-group col-3 p-2 mb-0">
                                <label for="created_at" class="font-weight-normal">Ngày tạo</label>
                                <input id="created_at" name="created_at"
                                    value="{{ isset($params['created_at']) && !empty($params['created_at']) ? $params['created_at'] : '' }}"
                                    type="text" class="form-control event-enter" placeholder="">
                            </div>
                            <div class="form-group col-3 p-2 mb-0">
                                <label for="full_name_update" class="font-weight-normal">Người sửa</label>
                                <input id="full_name_update" name="full_name_update"
                                    value="{{ isset($params['full_name_update']) && !empty($params['full_name_update']) ? $params['full_name_update'] : '' }}"
                                    type="text" class="form-control event-enter" placeholder="Nhập tên người sửa">
                            </div>
                            <div class="form-group col-3 p-2 mb-0">
                                <label for="updated_at" class="font-weight-normal">Ngày sửa</label>
                                <input id="updated_at" name="updated_at"
                                    value="{{ isset($params['updated_at']) && !empty($params['updated_at']) ? $params['updated_at'] : '' }}"
                                    type="text" class="form-control event-enter" placeholder="">
                            </div>
                        </div>
                        <div class="col-12 text-right d-flex justify-content-end mt-2" style="gap: 10px">
                            @include('include.btn.search')
                        </div>
                    </form>
                    <div class="row">
                    </div>
                    <!--end::Search-->
                </div>
                <!--begin::Card title-->
                <!--begin::Card toolbar-->

                <!--end::Card toolbar-->
            </div>
            <div class="card-body pt-0">
                <div>
                    <div class="row p-2">

                        <div class="col-12">
                            <a href="{{ route($params['prefix'] . '.' . $params['controller'] . '.index') }}"
                                class="text-dark">Totals:&nbsp;
                                <span class="text-primary">{{ number_format($model['items']->total()) }} rows</span>
                            </a>
                        </div>
                    </div>
                    <div class="basic-data-table">
                         {!!$model['contentHtml']!!}
                    </div>


                </div>

            </div>
            <!--end::Card body-->
        </div>

    </div>
@endsection
@push('js2')
    </script>
    <script src="{{ asset('assets/js/widgets.bundle.js') }}"></script>
    <script src="{{ asset('assets/js/custom/widgets.js') }}"></script>
    <script src="{{ asset('assets/js/custom/apps/chat/chat.js') }}"></script>
    <script src="{{ asset('assets/js/custom/utilities/modals/users-search.js') }}"></script>

    {{-- <script src="{{ asset('assets/js/custom/apps/ecommerce/catalog/products.js') }}"></script> --}}

    <script>
        if ($('table.table-striped tbody tr').length === 0) {
            $('table.table-striped tbody').html('<tr><td colspan="100%" class="text-center">No data</td></tr>');
        }
    </script>

    <!--end::Custom Javascript-->
    <!--end::Javascript-->
@endpush
