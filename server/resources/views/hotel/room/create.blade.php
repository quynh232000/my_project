@extends('layout.app')
@section('title', 'Thêm phòng mới')
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
        .w-20{
            width: 20% !important;
        }
        .not_delete{
            color: gray !important;
            cursor: not-allowed !important
        }
    </style>
    <!-- Content Header (Page header) -->
    <form class="form-horizontal app-container" id="admin-{{ $params['prefix'] }}-form" name="admin-{{ $params['prefix'] }}-form"
        enctype="multipart/form-data" method="POST"
        action="{{ route($params['prefix'] . '.' . $params['controller'] . '.store') }}">
        <input type="hidden" name="_method" value="POST">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mt-2">
                    <div class="col-6 text-left"></div>
                    <div class="col-6 text-right">
                        @include('include.btn.cancel', [
                            'href' => route($params['prefix'] . '.' . $params['controller'] . '.index'),
                        ])
                        @include('include.btn.save')
                    </div>
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <div class="row">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header p-2">
                        Thông tin phòng
                    </div>
                    <div class="card-body row mt-0 pt-0">
                        <div class="form-group col-6 p-2 mb-0">
                            <label for="value_on" class="col-form-label text-right">Khách sạn<span
                                style="color: red">(*)</span></label>
                            <select id="hotel_id" name="hotel_id" class="form-control select2 select2-blue"  style="width: 100%;">
                                <option value="">-- Chọn khách sạn --</option>
                                @foreach ($params['hotel']['hotel'] as $hotel)
                                    <option value="{{$hotel['id']}}">{{$hotel['name']}}</option>
                                @endforeach
                            </select>
                            <div class="input-error"></div>
                        </div>
                        <div class="form-group col-6 p-2 mb-0">
                            <label class="col-form-label text-right" for="type">Loại phòng<span style="color: red">(*)</span></label>
                            {!! \App\Models\Hotel\RoomTypeModel::selectOptions('type','room_type') !!}
                            <div class="input-error"></div>
                        </div>
                        <div class="form-group col-6 p-2 mb-0">
                            <label class="col-form-label text-right" for="name">Tên loại phòng <span
                                    style="color: red">(*)</span></label>
                            <input type="text" class="form-control generate-slug" id="name" name="name"
                                placeholder="Nhập tên loại phòng" value="">
                            <div class="input-error"></div>
                        </div>
                        <div class="form-group col-6 p-2 mb-0">
                            <label class="col-form-label text-right" for="slug">Slug<span style="color: red">(*)</span></label>
                            <input type="text" class="form-control" id="slug" name="slug" placeholder="Nhập slug" value="">
                            <div class="input-error"></div>
                        </div>

                        <div class="form-group col-6 p-2 mb-0">
                            <label class="col-form-label text-right" for="direction">Hướng phòng <span style="color: red">(*)</span></label>
                            {!! \App\Models\Hotel\RoomTypeModel::selectOptions('direction','direction_type') !!}
                            <div class="input-error"></div>
                        </div>
                        <div class="form-group col-6 p-2 mb-0">
                            <label class="col-form-label text-right" for="quantity" >
                                Số lượng phòng
                                <i class="fa-solid fa-circle-info text-secondary" data-toggle="tooltip" data-placement="top" title="Số lượng phòng sẽ được mở để đặt phòng"></i>
                                <span style="color: red">(*)</span>
                            </label>
                            <input type="number" class="form-control" id="quantity" min="0" max="500" name="quantity"
                                placeholder="Nhập số lượng phòng" value="">
                            <div class="input-error"></div>
                        </div>
                        <div class="form-group col-6 p-2 mb-0">
                            <label class="col-form-label text-right" for="room_area">Diện tích <span style="color: red">(*)</span></label>
                            <div class="input-group mb-3">
                                <input type="number" class="form-control" id="room_area" name="area"
                                    placeholder="Nhập diện tích" value="">
                                <div class="input-group-append">
                                   <span class="input-group-text">m<sup>2</sup></span>
                                </div>
                            </div>
                            <div class="input-error"></div>
                        </div>
                        <div class="form-group col-md-6 p-2 mb-0">
                            <label class="col-form-label text-right" for="status">Trạng Thái <span
                                style="color: red">(*)</span></label>
                            {!! \App\Models\Hotel\RoomTypeModel::slbStatus('inactive') !!}
                            <div class="input-error"></div>
                        </div>
                        <div class="form-group col-md-12 p-2 mb-0">
                            <label class="col-form-label text-right" for="smoking">Được phép hút thuốc</label>
                            <div class="d-flex">
                                <div class="">
                                    <input value="0" type="radio" id="smoking_no" name="smoking" >
                                    <label for="smoking_no" style="font-weight: normal" >
                                        Cấm hút thuốc
                                    </label>
                                </div>
                                <div class=" ml-5">
                                    <input value="1" type="radio" id="smoking_yes" name="smoking" checked>
                                    <label for="smoking_yes"  style="font-weight: normal">
                                        Cho phép
                                    </label>
                                </div>
                           </div>
                            <div class="input-error"></div>
                        </div>
                        <div class="form-group col-md-12 p-2 mb-0">
                            <label class="col-form-label text-right" for="breakfast">Bao gồm ăn sáng</label>
                            <div class="d-flex">
                                <div class="">
                                    <input value="0" type="radio" id="breakfast" name="breakfast" checked>
                                    <label for="breakfast"  style="font-weight: normal">
                                        Không
                                    </label>
                                </div>
                                <div class=" ml-5">
                                    <input value="1" type="radio" id="breakfast_yes" name="breakfast" >
                                    <label for="breakfast_yes"  style="font-weight: normal">
                                        Có
                                    </label>
                                </div>
                            </div>
                            <div class="input-error"></div>
                        </div>
                        <div class="form-group col-md-6 p-2 mb-0">
                            <label class="col-form-label text-right" for="fee_extra_bed">Nôi/ cũi và giường phụ</label>
                            <div class="d-flex">
                                <div class="">
                                    <input value="0" type="radio" id="fee_extra_bed" name="fee_extra_bed" checked>
                                    <label for="fee_extra_bed"  style="font-weight: normal">
                                        Không
                                    </label>
                                </div>
                                <div class=" ml-5">
                                    <input value="1" type="radio" id="fee_extra_bed_yes" name="fee_extra_bed" >
                                    <label for="fee_extra_bed_yes"  style="font-weight: normal">
                                        Có
                                    </label>
                                </div>
                            </div>
                            <div class="input-error"></div>
                        </div>
                        <div class="form-group col-md-12 p-2 mb-0 tb_fee_extra_bed" hidden >

                            <table class="table table-bordered " >
                                <thead >
                                  <tr style="border-bottom: 0">
                                    <th>Tuổi</th>
                                    <th >Loại phí</th>
                                    <th>Phí</th>
                                    <th></th>
                                  </tr>
                                </thead>
                                <tbody class="fee_extra_bed_list">
                                  <tr>
                                    <td  >
                                        <div class="d-flex" style="gap: 10px">
                                            <div class="d-flex align-items-center" style="flex: 1; gap:4px">
                                                Từ
                                                <div style="flex:1;" class="">
                                                    <input type="number" value="0" min="0" name="fee_extra_bed[0][from]" data-type="from" max="100" class="form-control input_age">
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-center" style="flex: 1; gap:4px">
                                                Đến
                                                <div style="flex:1;" >
                                                    <input type="number" value="" min="0" max="100" name="fee_extra_bed[0][to]" data-type="to" class="form-control input_age" placeholder="Trở lên">
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <select name="fee_extra_bed[0][type]" class="form-control bed_sel_type" style="width: 120px">
                                            <option value="free">Miễn phí</option>
                                            <option value="charge">Có phí</option>
                                        </select>
                                    </td>
                                    <td class="row_value"  style="min-width: 260px">
                                        <div class="badge bg-success mt-2">
                                            Miễn phí
                                            <input type="number" value="0" name="fee_extra_bed[0][fee]" min="0" class="form-control d-none" >
                                        </div>
                                        <div hidden>
                                            <div class="d-flex items-center align-items-center" >
                                                <input type="number" name="fee_extra_bed[0][fee]" min="0" class="form-control" >
                                                <div class="text-sm text-end pl-2" style="min-width: 72px">đ/ người</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td >
                                        <button class="mt-2 text-danger btn_delete_row not_delete" title="Xóa">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </td>
                                  </tr>
                                </tbody>
                            </table>
                            <div class="d-flex justify-content-end">
                                <button class="btn btn-sm btn-primary add_fee_extra_bed">Thêm hàng</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">

                <div class="card">
                    <div class="card-header p-2">
                        Sức chứa
                    </div>
                    <div class="card-body row mt-0 pt-0">
                        <div class="form-group col-md-6 p-2 mb-0">
                            <label class="col-form-label text-right" for="standard_capacity">Khách tiêu chuẩn
                                <i class="fa-solid fa-circle-info text-secondary" data-toggle="tooltip" data-placement="top" title="Số lượng khách người lớn tối đa được phép lưu trú trong phòng này."></i>
                                <span style="color: red">(*)</span>
                            </label>
                            <input type="number" class="form-control" id="standard_capacity" name="standard_capacity"
                                placeholder="Nhập số khách tiêu chuẩn" value="">
                            <div class="input-error price"></div>
                        </div>
                        <div class="form-group col-md-6 p-2 mb-0">
                            <label class="col-form-label text-right" for="add_adt">Người lớn phụ thu tối đa<span style="color: red">(*)</span></label>
                            <input type="number" class="form-control" id="add_adt" name="add_adt"
                                placeholder="Nhập số người lớn phụ thu tối đa" value="">
                            <div class="input-error price"></div>
                        </div>


                        <div class="form-group col-md-6 p-2 mb-0">
                            <label class="col-form-label text-right" for="breakfast">Cho phép trẻ em trong phòng này</label>
                            <div class="d-flex" style="gap: 10px">
                                <div class="">
                                    <input value="1" type="radio" class="allow_children" id="allow_children" name="allow_children" checked>
                                    <label for="allow_children"  style="font-weight: normal">
                                        Cho phép
                                    </label>
                                </div>
                                <div class=" ml-5">
                                    <input value="0" type="radio" class="allow_children" id="allow_children_yes" name="allow_children" >
                                    <label for="allow_children_yes"  style="font-weight: normal">
                                        Không cho phép
                                    </label>
                                </div>
                            </div>
                            <div class="input-error"></div>
                        </div>
                        <div class="form-group col-md-6 p-2 mb-0 allow_children_input">
                            <label class="col-form-label text-right" for="add_chd">Trẻ em phụ thu tối đa<span style="color: red">(*)</span></label>
                            <input type="number" min="0" class="form-control" id="add_chd" name="add_chd"
                                placeholder="Nhập số trẻ em phụ thu tối đa" value="">
                            <div class="input-error price"></div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header p-2">
                        Cài đặt giường ngủ
                    </div>
                    <div class="card-body row mt-0 pt-0">
                         <div class="form-group col-md-6 p-2 mb-0">
                             <label class="col-form-label text-right" for="bed_type">Loại giường chính <span style="color: red">(*)</span></label>
                             {!! \App\Models\Hotel\RoomTypeModel::selectOptions('bed_type','bed_type') !!}
                             <div class="input-error"></div>
                         </div>
                         <div class="form-group col-md-6 p-2 mb-0">
                             <label class="col-form-label text-right" for="bed_quantity">Số lượng giường <span style="color: red">(*)</span></label>
                             <input type="number" min="0" max="50" class="form-control" id="bed_quantity" name="bed_quantity"
                             placeholder="Nhập số lượng" value="">
                             <div class="input-error"></div>
                         </div>
                        <div class="form-group col-12 p-2 mb-0">
                            <div class="custom-control custom-switch">
                              <input type="checkbox" class="custom-control-input sub-bed" id="sub_bed" name="sub_bed">
                              <label class="custom-control-label" for="sub_bed">Kiểu giường thay thế</label>
                            </div>
                        </div>
                        <div class="row col-12 p-2 mb-0 sub-bed-hidden" style="display: none">
                            <div class="form-group col-md-6 p-2 mb-0">
                                <label class="col-form-label text-right" for="sub_bed_type">Kiểu giường thay thế <span style="color: red">(*)</span></label>
                                {!! \App\Models\Hotel\RoomTypeModel::selectOptions('sub_bed_type','bed_type') !!}
                                <div class="input-error"></div>
                            </div>
                            <div class="form-group col-md-6 p-2 mb-0">
                                <label class="col-form-label text-right" for="sub_bed_quantity">Số lượng <span style="color: red">(*)</span></label>
                                <input type="text" class="form-control" id="sub_bed_quantity" name="sub_bed_quantity"
                                placeholder="Nhập số lượng" value="">
                                <div class="input-error"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header p-2">
                        Giá phòng
                    </div>
                    <div class="card-body row mt-0 pt-0">
                        <div class="form-group col-md-6 p-2 mb-0">
                            <label class="col-form-label text-right" for="price_min">
                                Giá tối thiểu
                                <i class="fa-solid fa-circle-info text-secondary" data-toggle="tooltip" data-placement="top" title="Đặt mức giá tối thiểu cho phòng này. Thao tác này đảm bảo rằng phòng của bạn sẽ không được bán với mức giá thấp hơn mức giá này sau khi đã áp dụng giảm giá, khuyến mãi."></i>
                                <span style="color: red">(*)</span>
                            </label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control number_format" id="price_min" name="price_min"
                                    placeholder="Nhập giá tối thiểu" value="">
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
                                placeholder="Nhập giá cơ bản/phòng/đêm" value="">
                                <div class="input-group-append">
                                   <span class="input-group-text">VND</span>
                                </div>
                            </div>
                            <div class="input-error"></div>
                        </div>
                        <div class="form-group col-md-6 p-2 mb-0">
                            <label class="col-form-label text-right" for="price_max">Giá tối đa<span style="color: red">(*)</span></label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control number_format" id="price_max" name="price_max"
                                placeholder="Nhập giá tối đa" value="">
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
                                <option value="{{$child['id']}}">{{$child['name']}}</option>
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
                                                                <input name="services[]" data-type="check-item" value="{{ $child['id'] }}" class="form-check-input input_item" id="service_child_{{ $child['id'] }}" type="checkbox">
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

        </div>
        <!-- /.row -->
        <div class="row">&nbsp;</div>
    </form>
    <script src="{{ url('assets/plugins/admin-lte/plugins/dropzone/min/dropzone.min.js') }}"></script>
    <script src="{{ url('assets/js/admin-image.js?t='.now()) }}"></script>
    <script>
        $(document).ready(function() {
            $('#admin-{{ $params['prefix'] }}-form').submit(function(e) {


                $('.input-error').html('');
                $('.form-group row p-0 m-0 mb-2 input').removeClass('is-invalid');
                e.preventDefault();
                var formData = new FormData(this);const formEl = $(this)
                $.ajax({
                    type: 'POST',
                    url: "{{ route($params['prefix'] . '.' . $params['controller'] . '.store') }}",
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
                            $('#' + x).parents('.form-group').find('.input-error').html(data.responseJSON.errors[x]);
                            $('#' + x).parents('.form-group').find('.input-error').show();
                            $('#' + x).addClass('is-invalid');
                        }
                    }
                });
            });
            // $('.type-capcity').on('change', function() {

            //     if ($(this).val() == '1') {
            //         $('#field-null').show();
            //         $('#max_capacity_field').hide();
            //     } else {
            //         $('#field-null').hide();
            //         $('#max_capacity_field').show();
            //     }
            // });
            $('.sub-bed').change(function() {
                if ($(this).prop('checked')) {
                    $('.sub-bed-hidden').show();
                } else {
                    $('#sub_bed_type').val('');
                    $('#sub_bed_quantity').val('');
                    $('.sub-bed-hidden').hide();
                }
            });
            // ==== allow chidlren
            $('.allow_children').change(function () {
                if($(this).val() == 1){
                    $('.allow_children_input').find('input').prop('disabled',false)
                }else{
                    $('.allow_children_input').find('input').val('').prop('disabled',true)
                }
            })
            // ==== add axtra bed
            $('[name="fee_extra_bed"]').change(function(){
                if($(this).val() == 1){
                    $('.tb_fee_extra_bed').prop('hidden',false)
                }else{
                    $('.tb_fee_extra_bed').prop('hidden',true)
               }
            })

            let extraBedIndex = 1
            $('.add_fee_extra_bed').click(function(e){
                e.preventDefault()
                const rowClone      = $('.fee_extra_bed_list').find('tr').first().clone().removeClass('rowClone')
                $(rowClone).find('.btn_delete_row').removeClass('not_delete')

                rowClone.find('input, select').each(function(){
                    let inputName = $(this).attr('name');
                    inputName     = inputName.replace('[0]',`[${extraBedIndex}]`);
                    $(this).attr('name',inputName)
                })
                extraBedIndex ++;
                rowClone.find('input').val('');
                $('.fee_extra_bed_list').append(rowClone)
            })
            $('.fee_extra_bed_list').on('click','.btn_delete_row',function(e){
                e.preventDefault();
                if(!$(this).hasClass('not_delete')){
                    $(this).closest('tr').remove()
                }
            })
            $('.fee_extra_bed_list').on('change','.bed_sel_type',function(){
                const row_value     = $(this).closest('tr').find('.row_value')
                const isFree        = $(this).val() == 'free';
                $(row_value).children().eq(0).prop('hidden',!isFree)
                $(row_value).children().eq(1).prop('hidden',isFree)
            })
            $('.fee_extra_bed_list').on('input','.input_age',function(){
                if($(this).data('type') == 'to'){
                    const from = $(this).closest('td').find(`[data-type="from"]`).val()
                    if($(this).val() && ($(this).val() <= from) ){
                        $(this).val('')
                    }
                }
                // else {
                //     const rowBefore = $(this).closest('tr').before()
                //     const beforeTo  = $(rowBefore).find(`[data-type="to"]`).val()
                // }

            })


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
                            +value
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
        // initializeImage('.multipleImageDropzone', false, [], 10);
        initializeImage('.multipleImageDropzone', false, [], 10, 'image/*');
        //////////dropzone-preimage/////////////


    </script>
@endsection
