@extends('layout.app')
@section('title', 'Update infomation loại phòng')
@foreach ($params['service'] as $parent)
    @php
        $parents[] = $parent;
    @endphp
    @if (!empty($parent['children']))
            @foreach ($parent['children'] as $child)
            @php
                $children[] = $child;
            @endphp
            @endforeach
        </div>
    @endif
@endforeach
@section('main')
    <style>
        .nav-link.card-title.active{
            color: #002499 !important
        }
        .content-wrapper{
            height: auto;
        }
        .img_show_delete{
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            display: none;
            justify-content: center;
            align-items: center;
            background-color: rgba(22,22,24,.6)
        }
        .img_item_wrapper:hover .img_show_delete{
            display: flex;
            transition: .3s ease all;
            cursor: pointer;
        }
    </style>
    <!-- Content Header (Page header) -->
    <form class="form-horizontal app-container" id="admin-{{ $params['prefix'] }}-form" name="admin-{{ $params['prefix'] }}-form"
        enctype="multipart/form-data" method="POST"
        action="{{ route($params['prefix'] . '.' . $params['controller'] . '.update', ['room_type' => $params['item']['id']]) }}">
        <input type="hidden" name="_method" value="PUT">
         <input type="hidden" name="id" value="{{ $params['item']['id'] }}">
        <div class="row">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header p-2">
                        Thông tin phòng
                    </div>
                    <div class="card-body row">
                        <div class="form-group col-6 p-2 mb-0">
                            <label for="value_on" class="col-form-label text-right">Khách sạn<span
                                style="color: red">(*)</span></label>
                            <select id="hotel_id" name="hotel_id" class="form-control select2 select2-blue"  style="width: 100%;">
                                <option value="">-- Chọn khách sạn --</option>
                                @foreach ($params['hotel']['hotel'] as $hotel)
                                    <option value="{{$hotel['id']}}"  {{ isset($params['item']['hotel_id']) && $params['item']['hotel_id'] == $hotel['id'] ? 'selected' : ''}}>{{$hotel['name']}}</option>
                                @endforeach
                            </select>
                            <div class="input-error"></div>
                        </div>
                        <div class="form-group col-6 p-2 mb-0">
                            <label class="col-form-label text-right" for="type">Loại phòng<span style="color: red">(*)</span></label>
                            {!! \App\Models\Hotel\RoomTypeModel::selectOptions('type','room_type',$params['item']['type']??'') !!}
                            <div class="input-error"></div>
                        </div>
                        <div class="form-group col-6 p-2 mb-0">
                            <label class="col-form-label text-right" for="name">Tên loại phòng <span
                                    style="color: red">(*)</span></label>
                            <input type="text" class="form-control generate-slug" id="name" name="name"
                                placeholder="Nhập tên loại phòng" value="{{$params['item']['name']}}">
                            <div class="input-error"></div>
                        </div>
                        <div class="form-group col-6 p-2 mb-0">
                            <label class="col-form-label text-right" for="slug">Slug<span style="color: red">(*)</span></label>
                            <input type="text" class="form-control" id="slug" name="slug" placeholder="Nhập slug" value="{{$params['item']['slug']}}">
                            <div class="input-error"></div>
                        </div>

                        <div class="form-group col-6 p-2 mb-0">
                            <label class="col-form-label text-right" for="direction">Hướng phòng <span style="color: red">(*)</span></label>
                            {!! \App\Models\Hotel\RoomTypeModel::selectOptions('direction','direction_type',$params['item']['direction']) !!}
                            <div class="input-error"></div>
                        </div>
                        <div class="form-group col-6 p-2 mb-0">
                            <label class="col-form-label text-right" for="quantity" >
                                Số lượng phòng
                                <i class="fa-solid fa-circle-info text-secondary" data-toggle="tooltip" data-placement="top" title="Số lượng phòng sẽ được mở để đặt phòng"></i>
                                <span style="color: red">(*)</span>
                            </label>
                            <input type="number" class="form-control" id="quantity" min="0" max="500" name="quantity"
                                placeholder="Nhập số lượng phòng" value="{{$params['item']['quantity']}}">
                            <div class="input-error"></div>
                        </div>
                        <div class="form-group col-6 p-2 mb-0">
                            <label class="col-form-label text-right" for="room_area">Diện tích <span style="color: red">(*)</span></label>
                            <div class="input-group mb-3">
                                <input type="number" class="form-control" id="room_area" name="area"
                                    placeholder="Nhập diện tích" value="{{$params['item']['area']}}">
                                <div class="input-group-append">
                                   <span class="input-group-text">m<sup>2</sup></span>
                                </div>
                            </div>
                            <div class="input-error"></div>
                        </div>
                        <div class="form-group col-md-6 p-2 mb-0">
                            <label class="col-form-label text-right" for="status">Trạng Thái <span
                                style="color: red">(*)</span></label>
                            {!! \App\Models\Hotel\RoomTypeModel::slbStatus($params['item']['status']) !!}
                            <div class="input-error"></div>
                        </div>
                        <div class="form-group col-md-6 p-2 mb-0">
                            <label class="col-form-label text-right" for="smoking">Được phép hút thuốc</label>
                            <div >
                                <div class="icheck-primary d-inline">
                                    <input value="0" type="radio" id="smoking_no" name="smoking" {{$params['item']['smoking'] == 0 ? 'checked' : ''}} >
                                    <label for="smoking_no" style="font-weight: normal" >
                                        Cấm hút thuốc
                                    </label>
                                </div>
                                <div class="icheck-primary d-inline ml-5">
                                    <input value="1" type="radio" id="smoking_yes" name="smoking" {{$params['item']['smoking'] == 1 ? 'checked' : ''}}>
                                    <label for="smoking_yes"  style="font-weight: normal">
                                        Cho phép
                                    </label>
                                </div>
                           </div>
                            <div class="input-error"></div>
                        </div>
                        <div class="form-group col-md-6 p-2 mb-0">
                            <label class="col-form-label text-right" for="breakfast">Bao gồm ăn sáng</label>
                            <div>
                                <div class="icheck-primary d-inline">
                                    <input value="0" type="radio" id="breakfast" name="breakfast" {{$params['item']['breakfast'] == 0 ? 'checked' : ''}}>
                                    <label for="breakfast"  style="font-weight: normal">
                                        Không
                                    </label>
                                </div>
                                <div class="icheck-primary d-inline ml-5">
                                    <input value="1" type="radio" id="breakfast_yes" name="breakfast" {{$params['item']['breakfast'] == 1 ? 'checked' : ''}}>
                                    <label for="breakfast_yes"  style="font-weight: normal">
                                        Có
                                    </label>
                                </div>
                            </div>
                            <div class="input-error"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header p-2">
                        Chi tiết phòng
                    </div>
                    <div class="card-body row">
                        <div class="form-group col-12 p-2 mb-0">
                            <label class="col-form-label text-right" for="breakfast">Sức chứa</label>
                            <div>
                                <div class="icheck-primary d-inline">
                                    <input value="0" type="radio" class="type-capcity" id="capacity_type" name="capacity_type" {{$params['item']['capacity_type'] == 0 ? 'checked' : ''}} >
                                    <label for="capacity_type"  style="font-weight: normal">
                                        Người lớn và trẻ em
                                    </label>
                                </div>
                                <div class="icheck-primary d-inline ml-5">
                                    <input value="1" type="radio" class="type-capcity" id="capacity_type_yes" name="capacity_type" {{$params['item']['capacity_type'] == 1 ? 'checked' : ''}} >
                                    <label for="capacity_type_yes"  style="font-weight: normal">
                                        Người lớn hoặc trẻ em
                                    </label>
                                </div>
                            </div>
                            <div class="input-error"></div>
                        </div>

                        <div class="form-group col-md-6 p-2 mb-0">
                            <label class="col-form-label text-right" for="standard_capacity">Khách tiêu chuẩn
                                <i class="fa-solid fa-circle-info text-secondary" data-toggle="tooltip" data-placement="top" title="Số lượng khách người lớn tối đa được phép lưu trú trong phòng này."></i>
                                <span style="color: red">(*)</span>
                            </label>
                            <input type="number" class="form-control" id="standard_capacity" value="{{$params['item']['standard_capacity']}}" name="standard_capacity"
                                placeholder="Nhập số khách tiêu chuẩn" value="">
                            <div class="input-error price"></div>
                        </div>
                        <div class="form-group col-md-6 p-2 mb-0">
                            <label class="col-form-label text-right" for="add_adt">Người lớn phụ thu tối đa<span style="color: red">(*)</span></label>
                            <input type="number" class="form-control" id="add_adt" name="add_adt"
                                placeholder="Nhập số người lớn phụ thu tối đa" value="{{$params['item']['add_adt']}}">
                            <div class="input-error price"></div>
                        </div>
                        <div class="form-group col-md-6 p-2 mb-0">
                            <label class="col-form-label text-right" for="add_chd">Trẻ em phụ thu tối đa<span style="color: red">(*)</span></label>
                            <input type="number" class="form-control" id="add_chd" name="add_chd"
                                placeholder="Nhập số trẻ em phụ thu tối đa" value="{{$params['item']['add_chd']}}">
                            <div class="input-error price"></div>
                        </div>
                        <div class="form-group col-md-6 p-2 mb-0" id="max_capacity_field">
                            <label class="col-form-label text-right" for="max_capacity">Sức chứa tối đa<span style="color: red">(*)</span></label>
                            <input type="number" class="form-control" id="max_capacity" name="max_capacity"
                                placeholder="Nhập sức chứa tối đa" value="{{$params['item']['max_capacity']}}">
                            <div class="input-error price"></div>
                        </div>
                        <div class="form-group col-md-6 p-2 mb-0" id="field-null" style="display:none"></div>
                        <div class="form-group col-md-6 p-2 mb-0">
                            <label class="col-form-label text-right" for="bed_type">Loại giường chính <span style="color: red">(*)</span></label>
                            {!! \App\Models\Hotel\RoomTypeModel::selectOptions('bed_type','bed_type' , $params['item']['bed_type']) !!}
                            <div class="input-error"></div>
                        </div>
                        <div class="form-group col-md-6 p-2 mb-0">
                            <label class="col-form-label text-right" for="bed_quantity">Số lượng giường <span style="color: red">(*)</span></label>
                            <input type="number" min="0" max="50" class="form-control" id="bed_quantity" name="bed_quantity"
                            placeholder="Nhập số lượng" value="{{ $params['item']['bed_quantity']}}">
                            <div class="input-error"></div>
                        </div>
                        <div class="form-group col-12 p-2 mb-0">
                            <div class="custom-control custom-switch">
                              <input type="checkbox" class="custom-control-input sub-bed" id="sub_bed" name="sub_bed" {{!empty($params['item']['sub_bed_type']) ? 'checked' : ''}}>
                              <label class="custom-control-label" for="sub_bed">Kiểu giường thay thế</label>
                            </div>
                        </div>
                        <div class="row col-12 p-2 mb-0 sub-bed-hidden" style="display: none">
                            <div class="form-group col-md-6 p-2 mb-0">
                                <label class="col-form-label text-right" for="sub_bed_type">Kiểu giường thay thế <span style="color: red">(*)</span></label>
                                {!! \App\Models\Hotel\RoomTypeModel::selectOptions('sub_bed_type','bed_type', $params['item']['sub_bed_type']) !!}
                                <div class="input-error"></div>
                            </div>
                            <div class="form-group col-md-6 p-2 mb-0">
                                <label class="col-form-label text-right" for="sub_bed_quantity">Số lượng <span style="color: red">(*)</span></label>
                                <input type="text" class="form-control" id="sub_bed_quantity" name="sub_bed_quantity"
                                placeholder="Nhập số lượng" value="{{$params['item']['sub_bed_quantity']}}">
                                <div class="input-error"></div>
                            </div>
                        </div>

                        <div class="form-group col-md-6 p-2 mb-0">
                            <label class="col-form-label text-right" for="price_min">
                                Giá tối thiểu
                                <i class="fa-solid fa-circle-info text-secondary" data-toggle="tooltip" data-placement="top" title="Đặt mức giá tối thiểu cho phòng này. Thao tác này đảm bảo rằng phòng của bạn sẽ không được bán với mức giá thấp hơn mức giá này sau khi đã áp dụng giảm giá, khuyến mãi."></i>
                                <span style="color: red">(*)</span>
                            </label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control number_format" id="price_min" name="price_min"
                                    placeholder="Nhập giá tối thiểu" value="{{$params['item']['price_min']}}">
                                <div class="input-group-append">
                                   <span class="input-group-text">VND</span>
                                </div>
                            </div>
                            <div class="input-error"></div>
                        </div>
                        <div class="form-group col-md-6 p-2 mb-0">
                            <label class="col-form-label text-right" for="price_standard">Giá cơ bản/phòng/đêm<span style="color: red">(*)</span></label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control number_format" id="price_standard" name="price_standard"
                                placeholder="Nhập giá cơ bản/phòng/đêm" value="{{$params['item']['price_standard']}}">
                                <div class="input-group-append">
                                   <span class="input-group-text">VND</span>
                                </div>
                            </div>
                            <div class="input-error"></div>
                        </div>
                        <div class="form-group col-md-6 p-2 mb-0">
                            <label class="col-form-label text-right" for="price_max">Giá tối đa<span style="color: red">(*)</span></label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control number_format" id="price_max" name="price_max" placeholder="Nhập giá tối đa" value="{{$params['item']['price_max']}}">
                                <div class="input-group-append">
                                   <span class="input-group-text">VND</span>
                                </div>
                            </div>
                            <div class="input-error"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="card">
                    <div class="card-header p-2">
                        Tiện nghi phòng
                    </div>
                    <div class="card-body row pt-0 mt-0">
                        <div class="form-group col-4 p-2 mb-0">
                            <label class="col-form-label text-right" for="special_service">Tiện ích nổi bật </label>
                           <select id="special_service" name="special_service[]" class="form-control select2 select2-blue" style="width: 100%;" multiple>
                                <option value="">-- Chọn dịch vụ & tiện ích phòng --</option>
                                @foreach ($children as $child)
                                    <option value="{{$child['id']}}"
                                        @if(isset($params['item']['special_service']) && !empty($params['item']['special_service']) && in_array($child['id'], $params['item']['special_service']))
                                            selected
                                        @endif
                                    >
                                        {{$child['name']}}
                                    </option>
                                @endforeach
                            </select>
                            <div class="input-error"></div>
                        </div>
                        <div class="form-group col-12 p-2 mb-0 ">
                            <label for="value_on" class="col-form-label text-right">Tiện ích và dịch vụ</label>
                            <div class="row border-top">
                                <div class="col-12 col-md-4 border-right service_parent" id="list_check">
                                    <div class="form-check border-bottom py-2">
                                        <input class="form-check-input" data-type="check-list-all" type="checkbox" id="check_all">
                                        <label class="form-check-label fw-bold" for="check_all">
                                            Chọn tất cả tiện ích
                                        </label>
                                    </div>

                                    <div style="overflow-y: auto; overflow-x: hidden; max-height: 500px;">
                                        @foreach ($params['service'] as $parent)
                                            <div class="px-3 py-2 border-bottom service_parent service_group" data-service-id="{{ $parent['id'] }}">
                                                <div class="form-check">
                                                    <input class="form-check-input input_service" data-type="check-list" type="checkbox" id="service_parent_{{ $parent['id'] }}">
                                                    <label class="form-check-label fw-bold" for="service_parent_{{ $parent['id'] }}">
                                                        {{ $parent['name'] }}
                                                    </label>
                                                </div>
                                                @if (!empty($parent['children']))
                                                    <div class="p-2 px-4">
                                                        @foreach ($parent['children'] as $child)
                                                            <div class="form-check">
                                                                <input name="services[]"
                                                                {{in_array($child['id'],$params['item']['services'])?'checked':''}}
                                                                data-type="check-item" value="{{ $child['id'] }}" class="form-check-input input_item" id="service_child_{{ $child['id'] }}" type="checkbox">
                                                                <label class="form-check-label" for="service_child_{{ $child['id'] }}">
                                                                    {{ $child['name'] }}
                                                                </label>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="col-12 col-md-8">
                                    <div class="border-bottom ">
                                        <label for="value_on" class="col-form-label text-right ">Tiện ích đã chọn</label>
                                        <input type="hidden" name="old_services" value="{{json_encode($params['item']['services'])}}">
                                    </div>
                                    <div class="row px-2" id="list-service-select" style="overflow-y: auto; overflow-x: hidden; max-height: 500px;">
                                        <div class="col-12 text-center py-5">
                                            Chưa có tiện ích nào được chọn!
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="card">
                    <div class="card-header p-2">
                        Ảnh phòng
                    </div>
                    <div class="card-body row pt-0 mt-0">
                        <div class="m-0 pt-2 col-12">

                            <div id="dropzone_template" hidden>
                                <div class=" drop_zone col-12 col-md-4 col-xl-2 position-relative p-1 img_item" >
                                    <div class="border position-relative img_item_wrapper">
                                        <span class="mailbox-attachment-icon has-img">
                                            <img style="height: 120px; object-fit:cover" data-dz-thumbnail class="w-100" src="" alt="Attachment">
                                        </span>
                                        <div style="flex:1" class=" img_show_delete ">
                                            <button data-dz-remove   class="text-danger btn btn-default btn-sm">
                                                <i class="fa-regular fa-trash-can"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="mt-2">
                                        {!! \App\Models\Hotel\RoomTypeModel::selectImageLabel(null,'images[name][]') !!}
                                    </div>
                                    <i class="">
                                        <small style="font-size: 12px d-flex justify-content-center align-items-center" class="error text-danger w-100" data-dz-errormessage></small>
                                    </i>
                                </div>
                            </div>
                            <div class="images-item border-bottom pb-3">
                                <div class="mt-4">
                                    <div class="dropzone border-dashed row mx-1 multipleImageDropzone">
                                        @foreach (($params['item']['images'] ??[]) as $k => $img)
                                            <div class="drop_zone col-12 col-md-4 col-xl-2 position-relative p-1 img_item" title="{{$img['label_id']}}">
                                                <div class="border position-relative img_item_wrapper">
                                                    <span class="mailbox-attachment-icon has-img">
                                                        <img style="height: 110px; object-fit:cover" class="w-100" src="{{ $img['image'] }}?t={{time()}}" alt="Attachment">
                                                    </span>
                                                    <div style="flex:1" class=" img_show_delete ">
                                                        <botton data-dz-remove  onclick="removeImage(event,this)" data-id="{{$img['id']}}" class="text-danger btn btn-default btn-sm">
                                                            <i class="fa-regular fa-trash-can"></i>
                                                        </botton>
                                                    </div>
                                                </div>
                                                <div class="mt-2">
                                                    {!! \App\Models\Hotel\HotelModel::selectImageLabel($img['label_id'],"images_current[".$img['id']."]",$img['label_id']) !!}
                                                </div>
                                            </div>
                                        @endforeach
                                        <input type="file"  name="images[image][]" multiple hidden>
                                        <div class="dz-default dz-message text-secondary col-12 d-flex justify-content-center align-items-center pb-2">
                                            <i class="fa-regular fa-images mr-2 fa-xl"></i> Tải lên hoặc kéo thả file ảnh ( .jpeg, .png, .jpg, .gif, .webp)
                                        </div>
                                    </div>
                                </div>
                                <div class="input-error"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- /.row -->
        <div class="row">&nbsp;</div>
    </form>
    <script src="{{ url('assets/plugins/admin-lte/plugins/dropzone/min/dropzone.min.js') }}"></script>
    <script src="{{ url('assets/js/admin-image.js?t='.time()) }}"></script>
    <script>
        let idDeletes = []
        $(document).ready(function() {
            $('#admin-{{ $params['prefix'] }}-form').submit(function(e) {

                $('.input-error').html('');
                $('.form-group input').removeClass('is-invalid');
                e.preventDefault();
                var formData = new FormData(this);const formEl = $(this)
                formData.append("list_image", JSON.stringify(idDeletes));
                $.ajax({
                    type: 'POST',
                    url: "{{ route($params['prefix'] . '.' . $params['controller'] . '.update', ['room_type' => $params['item']['id']]) }}",
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    cache: false,
                    contentType: false,
                    processData: false,
                   success: (data) => {
$(formEl).find('.indicator-label').show()
                        $(formEl).find('.indicator-progress').hide()
                        $(formEl).find(`button[type='submit']`).prop('disabled', false);
                        Swal.fire({
                                text: res.message ??
                                    "Form has been successfully submitted!",
                                icon: "success",
                                buttonsStyling: !1,
                                confirmButtonText: "Ok, got it!",
                                customClass: {
                                    confirmButton: "btn btn-primary"
                                }
                            })
                            .then((function(e) {
                                window.location.reload()
                            }))},
                    error: function(data) {

                        for (x in data.responseJSON.errors) {
                            console.log('data.responseJSON.errors', $('#' + x).parents());
                            $('#' + x).parents('.form-group').find('.input-error').html(data
                                .responseJSON.errors[x]);
                            $('#' + x).parents('.form-group').find('.input-error').show();
                            $('#' + x).addClass('is-invalid');
                        }
                    }
                });
            });
            $('.type-capcity').on('change', function() {

                if ($(this).val() == '1') {
                    $('#field-null').show();
                    $('#max_capacity_field').hide();
                } else {
                    $('#field-null').hide();
                    $('#max_capacity_field').show();
                }
            });
            if ($('.type-capcity:checked').val() == '1') {
                $('#field-null').show();
                $('#max_capacity_field').hide();
            } else {
                $('#field-null').hide();
                $('#max_capacity_field').show();
            }
            $('.sub-bed').change(function() {
                if ($(this).prop('checked')) {
                    $('.sub-bed-hidden').show();
                } else {
                    $('#sub_bed_type').val('');
                    $('#sub_bed_quantity').val('');
                    $('.sub-bed-hidden').hide();
                }
            });
            if ($('.sub-bed').prop('checked')) {
                $('.sub-bed-hidden').show();
            } else {
                $('.sub-bed-hidden').hide();
            }
            $('input.number_format').each(function() {
                $(this).val(formatNumber($(this).val()));
            });
        });
        // service room type
        const facilities    = @json($children);
        const services      = @json($parents);
        const inputEl       = '#list_check input';
        const listResultEl  = '#list-service-select';
        const list          = '#list_check';

        $(inputEl).on('change', function () {
            const dataType = $(this).attr('data-type');
            if (dataType && dataType.includes('check-list')) {
                $(this).closest('.service_parent').find('input').prop('checked', $(this).prop('checked'));
                if (!$(this).prop('checked') && dataType !== 'check-list-all') {
                    $('#check_all').prop('checked', false);
                }
            }
            checkParent();
            renderSelectService();
        });
        checkParent();
        renderSelectService();
        function renderSelectService() {
            let dataIds = {};
            $(inputEl).each(function () {
                if ($(this).attr('data-type') === 'check-item' && $(this).prop('checked')) {
                    const service_id   = $(this).closest('.service_parent').attr('data-service-id');
                    const value        = $(this).val();
                    dataIds = {
                        ...dataIds,
                        [service_id]: [
                            ...(dataIds[service_id] || []),
                            + value
                        ]
                    };
                }
            });
            renderSericeHtml(dataIds);
        }
        function renderSericeHtml(dataIds) {
            let html = '';
            for (const key in dataIds) {
                if (Object.prototype.hasOwnProperty.call(dataIds, key)) {
                    const faciId    = dataIds[key];
                    const service   = Object.values(services).find(item => item.id === parseInt(key));

                    const facilityHtml = faciId.map(f => {
                        return `<li>${facilities.find(faci => faci.id == f)?.name}</li>`;
                    }).join('');

                    html += `
                        <div class="col-12 col-md-6">
                            <label for="" >${service.name} (${faciId.length})</label>
                            <ul>${facilityHtml}</ul>
                        </div>
                    `;
                }
            }
            if (html === '') {
                html = '<div class="col-12 text-center py-5">Chưa chọn dịch vụ nào</div>';
            }
            $(listResultEl).html(html);
        }
        function checkParent() {
            $('.service_group').each(function () {
                const $parent = $(this);
                if ($parent.find('.input_item:checked').length === $parent.find('.input_item').length) {
                    $parent.find('.input_service').prop('checked', true);
                } else {
                    $parent.find('.input_service').prop('checked', false);
                }
            });

            if ($(list).find('.service_parent .input_service:checked').length === $(list).find('.service_parent .input_service').length) { // Check all
                $(list).find('#check_all').prop('checked', true);
            } else {
                $(list).find('#check_all').prop('checked', false);
            }
        }
         ///////////dropzone-preimage/////////////
        const imageMultiple = @json($params['item']['images']);
        var listImage       = initializeImage('.multipleImageDropzone', false, [], 10, "image/jpeg,png");
        //////////dropzone-preimage/////////////
        function removeImage(event,_this) {
            event.preventDefault();
            const id = $(_this).attr('data-id')
            if(id){
                idDeletes.push(id)
            }
            $(_this).closest('.img_item').remove()

        }
    </script>
@endsection
