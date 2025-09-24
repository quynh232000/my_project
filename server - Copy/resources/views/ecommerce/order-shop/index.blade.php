@extends('layout.app')
@section('title', 'Manage Ecommerce Product')
@php
    $model = $params['model'];
@endphp

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
                                {{-- @include('include.btn.delete')
                                @include('include.btn.create') --}}
                            </div>
                        </div>
                    </div>
                    <form class="d-flex align-items-center position-relative my-1 row">
                        <div class="mb-2 fv-row fv-plugins-icon-container col-md-3">
                            <label class=" form-label">Title</label>
                            <input type="text" name="title" class="form-control mb-2" placeholder="Enter..."
                                value="{{ request()->title ?? '' }}">
                        </div>
                        <div class="mb-2 fv-row fv-plugins-icon-container col-md-3">
                            <label class=" form-label">Slug</label>
                            <input type="text" name="slug" class="form-control mb-2" placeholder="Enter..."
                                value="{{ request()->slug ?? '' }}">
                        </div>
                        <div class="mb-2 fv-row fv-plugins-icon-container col-md-3">
                            <label class=" form-label">Status</label>
                            {!!\App\Models\Ecommerce\ProductModel::slbStatus($params['status'] ?? '')!!}
                        </div>
                        <div class="mb-2 fv-row fv-plugins-icon-container col-md-3">
                            <label class=" form-label">From</label>
                            <input type="text" name="from" class="form-control mb-2" placeholder="Enter..."
                                value="{{ request()->from ?? '' }}">
                        </div>
                        <div class="mb-2 fv-row fv-plugins-icon-container col-md-3">
                            <label class=" form-label">Placement</label>
                            <input type="text" name="placement" class="form-control mb-2" placeholder="Enter..."
                                value="{{ request()->placement ?? '' }}">
                        </div>
                        <div class="mb-2 fv-row fv-plugins-icon-container col-md-3">
                            <label class=" form-label">Type</label>
                            <input type="text" name="type" class="form-control mb-2" placeholder="Enter..."
                                value="{{ request()->type ?? '' }}">
                        </div>

                        <div class="col-12 row">
                            <div class="mb-2 fv-row fv-plugins-icon-container col-md-3">
                                <label class=" form-label">Creator</label>
                                <input type="text" name="created_by" class="form-control mb-2" placeholder="Enter..."
                                    value="{{ request()->created_by ?? '' }}">
                            </div>
                            <div class="mb-2 fv-row fv-plugins-icon-container col-md-3">
                                <label class=" form-label">Created At</label>
                                <input type="date" name="created_at" class="form-control mb-2" placeholder="Enter..."
                                    value="{{ request()->created_at ?? '' }}">

                            </div>
                            <div class="mb-2 fv-row fv-plugins-icon-container col-md-3">
                                <label class=" form-label">Modifior</label>
                                <input type="text" name="updated_by" class="form-control mb-2" placeholder="Enter..."
                                    value="{{ request()->updated_by ?? '' }}">
                            </div>
                            <div class="mb-2 fv-row fv-plugins-icon-container col-md-3">
                                <label class=" form-label">Updated At</label>
                                <input type="date" name="updated_at" class="form-control mb-2" placeholder="Enter..."
                                    value="{{ request()->updated_at ?? '' }}">
                            </div>
                        </div>
                        <div class="col-12 text-right d-flex justify-content-end " style="gap: 10px">
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
                        {!! $model['contentHtml'] !!}
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
