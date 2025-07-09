@extends('layout.app')
@php
    $model      = $params['model'];
@endphp
@section('title', trans('Danh sách khuyến mãi'))
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
                            <label for="name" class="font-weight-normal">Khách sạn</label>
                            <select name="hotel_id" id="hotel_id" class="form-control select2 select2-blue select-hotel"
                                    data-dropdown-css-class="select2-blue" style="width: 100%;">
                                <option value="">-- Chọn Khách sạn --</option>
                                @foreach ($params['hotel'] as $hotel)
                                    <option value="{{ $hotel->id }}" {{ isset($params['hotel_id']) && $params['hotel_id'] == $hotel->id ? 'selected' : '' }}>
                                        {{ $hotel['name'] }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-3 p-2 mb-0">
                            <label for="name" class="font-weight-normal">Tên khuyến mãi</label>
                            <input id="name" name="name" value="{{isset($params['name']) && !empty($params['name']) ? $params['name'] : ''}}" type="text" class="form-control event-enter" placeholder="Nhập tên khuyến mãi">
                        </div>
                        <div class="form-group col-3 p-2 mb-0">
                            <label for="name" class="font-weight-normal">Loại phòng</label>
                            <select name="room_type" id="room_type" class="form-control select2 select2-blue"
                                    data-dropdown-css-class="select2-blue" style="width: 100%;">
                                <option value="">-- Chọn loại phòng --</option>
                            </select>
                        </div>
                        <div class="form-group col-3 p-2 mb-0">
                            <label for="name" class="font-weight-normal">Loại giá</label>
                            <select name="price_type" id="price_type" class="form-control select2 select2-blue"
                                    data-dropdown-css-class="select2-blue" style="width: 100%;">
                                    <option value="">-- Chọn loại giá--</option>
                            </select>
                        </div>
                        <div class="form-group col-3 p-2 mb-0">
                            <label for="start_date" class="font-weight-normal">Ngày bắt đầu</label>
                            <input id="start_date" name="start_date" value="{{isset($params['start_date']) && !empty($params['start_date']) ? $params['start_date'] : ''}}" type="text" class="form-control event-enter" placeholder="Chọn ngày bắt đầu">
                        </div>
                        <div class="form-group col-3 p-2 mb-0">
                            <label for="end_date" class="font-weight-normal">Ngày kết thúc</label>
                            <input id="end_date" name="end_date" value="{{isset($params['end_date']) && !empty($params['end_date']) ? $params['end_date'] : ''}}" type="text" class="form-control event-enter" placeholder="Chọn ngày kết thúc">
                        </div>
                        <div class="form-group col-3 p-2 mb-0">
                            <label for="status" class="font-weight-normal">{{ trans('field.status_label') }}</label>
                            {!!\App\Models\Hotel\PromotionModel::slbStatus(@$params['status'],['action' => @$params['action']])!!}
                        </div>
                        <div class="form-group col-3 p-2 mb-0"></div>
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
 <div class="col-12 text-right d-flex justify-content-end mb-2">
                        @include('include.btn.search')
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
                    {!!$model['contentHtml']!!}
                </div>

            </div>
        </div>
    </div>
</div>
<script>
$(document).ready(function(){
    adminIndex("{{$params['prefix']}}","{{$params['controller']}}","{{$params['action']}}",'{{route($params["prefix"]. '.' . $params["controller"] . ".index")}}');
    dateFromTo('#created_at, #start_date', null, null, 'YYYY/MM/DD');
    dateFromTo('#updated_at, #end_date', null, null, 'YYYY/MM/DD');
    $('.select-hotel').on('change', function(e) {
        e.preventDefault();
        const hotel_id = $(this).val();
        if (hotel_id) {
            loadHotelInfo(hotel_id);
        }
    });
    const hotel_id = $('.select-hotel').val();
    if (hotel_id) {
        loadHotelInfo(hotel_id);
    }
});
function loadHotelInfo(hotel_id) {
    const price_type    = $('#price_type');
    const room_type     = $('#room_type');
    price_type.html('<option value="">-- Chọn loại giá --</option>');
    room_type.html('<option value="">-- Chọn loại phòng --</option>');
    //
    $.ajax({
        url: "{{ route($params['prefix'] . '.' . $params['controller'] . '.get-info') }}",
        method: "POST",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: { hotel_id: hotel_id },
        success: function(data) {
            //
            const roomType  = new URLSearchParams(window.location.search).get('room_type');
            const priceType = new URLSearchParams(window.location.search).get('price_type');
            $.each(data['priceType'], function(index, item) {
                const option = $('<option>', {
                    value: item.id,
                    text: item.name,
                    selected: priceType == item.id
                });
                price_type.append(option);
            });
            $.each(data['roomType'], function(index, item) {
                const option = $('<option>', {

                    value: item.id,
                    text: item.name,
                    selected: roomType == item.id
                });
                room_type.append(option);
            });
        },
        error: function(data) {
            //
            console.log(data);
        }
    });
}
</script>
@endsection
