@extends('layout.app')
@php
    $model      = $params['model'];
    $items      = $model['items'];
@endphp
@section('title', trans('Danh sách danh mục'))
@section('main')


<div class="row app-container">
    <div class="col-12 p-2">
        <div class="card card-default">
            <div class="card-body p-2"> <div class="row p-5">
                        <div class="card-toolbar col-12 d-flex justify-content-end">
                            <!--begin::Toolbar-->
                            <div class="d-flex justify-content-end" style="gap: 10px" data-kt-user-table-toolbar="base">
                                @include('include.btn.delete')
                                @include('include.btn.create')
                            </div>
                        </div>
                    </div>
                <form class="form-horizontal" method="GET" enctype="multipart/form-data" id="admin-form-{{$params['prefix']}}-{{$params['controller']}}" name="admin-form-{{$params['prefix']}}-{{$params['controller']}}">
                    <div class="row m-0 pt-2">
                        <div class="form-group col-3 p-2 mb-0">
                            <label for="name" class="font-weight-normal">Tên danh mục</label>
                            <input id="name" name="name" value="{{isset($params['name']) && !empty($params['name']) ? $params['name'] : ''}}" type="text" class="form-control event-enter" placeholder="Nhập tên danh mục">
                        </div>
                        <div class="form-group col-3 p-2 mb-0">
                            <label for="status" class="font-weight-normal">{{ trans('field.status_label') }}</label>
                            {!!\App\Models\Hotel\PostCategoryModel::slbStatus(@$params['status'],['action' => @$params['action']])!!}
                        </div>
                        <div class="form-group col-3 p-2 mb-0">
                        </div>
                        <div class="form-group col-3 p-2 mb-0">
                        </div>
                        <div class="form-group col-3 p-2 mb-0">
                            <label for="full_name" class="font-weight-normal">Người tạo</label>
                            <input id="full_name" name="full_name" value="{{isset($params['full_name']) && !empty($params['full_name']) ? $params['full_name'] : ''}}" type="text" class="form-control event-enter" placeholder="Nhập tên người tạo">
                        </div>
                        <div class="form-group col-3 p-2 mb-0">
                            <label for="created_at" class="font-weight-normal">Ngày tạo</label>
                            <input id="created_at" name="created_at" value="{{isset($params['created_at']) && !empty($params['created_at']) ? $params['created_at'] : ''}}" type="date" class="form-control event-enter" placeholder="Chọn ngày tạo">
                        </div>
                        <div class="form-group col-3 p-2 mb-0">
                            <label for="update_name" class="font-weight-normal">Người sửa</label>
                            <input id="update_name" name="update_name" value="{{isset($params['update_name']) && !empty($params['update_name']) ? $params['update_name'] : ''}}" type="text" class="form-control event-enter" placeholder="Nhập người sửa">
                        </div>
                        <div class="form-group col-3 p-2 mb-0">
                            <label for="updated_at" class="font-weight-normal">Ngày sửa</label>
                            <input id="updated_at" name="updated_at" value="{{isset($params['updated_at']) && !empty($params['updated_at']) ? $params['updated_at'] : ''}}" type="date" class="form-control event-enter" placeholder="Chọn ngày sửa">
                        </div>


                    </div>
                </form>
                <div class="row p-2">

                    <div class="col-12">
                        <a href="{{route($params['prefix'] . '.' . $params['controller'] . '.index')}}" class="text-dark">{{ trans('button.total') }}:&nbsp;
                            <span class="text-primary">{{number_format($model['items']->total())}} dòng</span>
                        </a>
                    </div>
                </div>
                <div class="basic-data-table">
                    {!!\App\Models\Hotel\PostCategoryModel::createTreeTable($params,$items->toTree())!!}
                </div>
                @if (count($items) > 0)
                {!! \App\Models\Hotel\PostCategoryModel::paginateBackend($items,$params) !!}
                 @endif

            </div>
        </div>
    </div>
</div>
<script>
$(document).ready(function(){

    move("{{$params['prefix']}}","{{$params['controller']}}","{{$params['action']}}", "");
});
</script>
@endsection
