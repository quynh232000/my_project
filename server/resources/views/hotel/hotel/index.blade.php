@extends('layout.app')
@php
    $model = $params['model'];
@endphp
@section('title', trans('Danh sách khách sạn'))
@section('main')

    @if (\Session::has('info'))
        <div class="alert alert-info">
            <ul>
                <li>{!! \Session::get('info') !!}</li>
            </ul>
        </div>
    @endif
    <div class="modals" id="global_modal"></div>
    <style>
        .image_item {
            width: 100%;
            height: 56px;
            overflow: hidden;
            display: inline-block;
            margin-right: auto;
            padding: auto;
            position: relative;
        }

        .image_item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .p-1.last.text-center {}

        .vnbk-box-btn-filter {
            padding: auto;
            margin: auto
        }
    </style>

    <div class="row app-container">
        <div class="col-12 p-2">
            <div class="card card-default">
                <div class="card-body p-2">
                    <div class="row p-5">
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
                                <label for="end_point_name" class="font-weight-normal">Tên khách sạn</label>
                                <input id="name" name="name"
                                    value="{{ isset($params['name']) && !empty($params['name']) ? $params['name'] : '' }}"
                                    type="text" class="form-control event-enter" placeholder="Nhập...">
                            </div>
                            <div class="form-group col-3 p-2 mb-0">
                                <label for="accommodation_id" class="font-weight-normal">Loại hình cư trú </label>
                                {!! \App\Models\Hotel\HotelModel::selectAccommodation(
                                    isset($params['accommodation_id']) && !empty($params['accommodation_id']) ? $params['accommodation_id'] : '',
                                ) !!}
                            </div>

                            <div class="form-group col-3 p-2 mb-0">
                                <label for="status" class="font-weight-normal">{{ trans('field.status_label') }}</label>
                                {!! \App\Models\Hotel\HotelModel::slbStatus(@$params['status'], ['action' => @$params['action']]) !!}
                            </div>
                            <div class="row col-12">
                                {{-- {!! \App\Helpers\Template::address([
                                    'country_id'    => $params['country_id'] ?? '',
                                    'city_id'       => $params['city_id'] ?? '',
                                    'district_id'   => $params['district_id'] ?? '',
                                    'ward_id'       => $params['ward_id'] ?? ''
                                ]) !!} --}}
                            </div>
                            <div class="col-12 row">
                                <div class="form-group col-3 p-2 mb-0">
                                    <label for="customer" class="font-weight-normal">Nhân viên</label>
                                    <input id="customer" name="customer"
                                        value="{{ isset($params['customer']) && !empty($params['customer']) ? $params['customer'] : '' }}"
                                        type="text" class="form-control event-enter"
                                        placeholder="Nhập tên, email, số điện thoại...">
                                </div>
                            </div>
                            <div class="col-12 row">
                                <div class="form-group col-3 p-2 mb-0">
                                    <label for="full_name" class="font-weight-normal">Người tạo</label>
                                    <input id="full_name" address="full_name"
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
                            <div class="col-12 text-right d-flex justify-content-end mb-2">
                                @include('include.btn.search')
                            </div>
                        </div>
                    </form>
                    <div class="row p-2">

                        <div class="col-12">
                            <a href="{{ route($params['prefix'] . '.' . $params['controller'] . '.index') }}"
                                class="text-dark">{{ trans('button.total') }}:&nbsp;
                                <span class="text-primary">{{ number_format($model['items']->total()) }} dòng</span>
                            </a>
                        </div>
                    </div>
                    <div class="basic-data-table">
                        {!! $model['contentHtml'] !!}
                    </div>

                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {

        });
    </script>
@endsection
