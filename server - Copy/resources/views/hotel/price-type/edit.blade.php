@extends('layout.app')
@section('title', 'Update infomation loại giá')
@section('main')
    <!-- Content Header (Page header) -->
    <form class="form-horizontal app-container" id="admin-{{ $params['prefix'] }}-form" name="admin-{{ $params['prefix'] }}-form"
        enctype="multipart/form-data" method="POST"
        action="{{ route($params['prefix'] . '.' . $params['controller'] . '.update', ['price_type' => $params['item']['id']]) }}">
        <input type="hidden" name="_method" value="PUT">
         <input type="hidden" name="id" value="{{ $params['item']['id'] }}">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12">
                <div class="card">
                     <div class="card-header d-flex justify-content-between align-items-center">
                        Infomation
                        <div class="">
                            @include('include.btn.cancel', [
                                'href' => route($params['prefix'] . '.' . $params['controller'] . '.index'),
                            ])
                            @include('include.btn.save')
                        </div> <h3>Thông tin loại giá</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="row m-0 pt-2">
                            <div class="form-group col-6 p-2 mb-0">
                                <label class="col-form-label text-right" for="hotel">Khách sạn <span style="color: red">(*)</span></label>
                                <select class="form-control select2 select-bluer select-hotel" id="hotel_id" name="hotel_id">
                                    <option value="">-- Chọn khách sạn --</option>
                                    @foreach ($params['hotel']['hotel'] as $hotel)
                                    <option value="{{ $hotel['id'] }}" {{$hotel['id'] == $params['item']['hotel_id'] ? 'selected' : ''}}>{{ $hotel['name'] }}</option>
                                    @endforeach
                                </select>
                                <div class="input-error"></div>
                            </div>
                            <div class="form-group col-6 p-2 mb-0">
                                <label class="col-form-label text-right" for="name">Tên loại giá <span style="color: red">(*)</span></label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="Nhập tên loại giá" value="{{$params['item']['name'] ?? ''}}">
                                <div class="input-error"></div>
                            </div>
                            <div class="form-group col-6 p-2 mb-0">
                                <label class="col-form-label text-left" for="type">Loại phòng áp dụng <span style="color: red">(*)</span></label>
                                <div class="col-12">
                                    <div class="col-12 icheck-primary d-inline">
                                        <input type="checkbox" id="all_room_types" name="all_room_types" value="1">
                                        <label for="all_room_types">Áp dụng cho tất cả loại phòng</label>
                                    </div>
                                </div>
                                <div class="row col-12 clearfix p-2 ml-2" id="show_room_type">
                                    @foreach ($params['roomType'] as $room_type)
                                    <div class="icheck-primary d-inline p-2">
                                        <input class="room-checked" type="checkbox" id="room_type{{$loop->index}}" name="room_type_id[]" value="{{$room_type['id']}}"
                                        {{ in_array($room_type['id'], $params['item']['roomType']->pluck('room_type_id')->toArray()) ? 'checked' : '' }}>
                                        <label for="room_type{{$loop->index}}">{{$room_type['name']}}</label>
                                    </div>
                                    @endforeach
                                </div>
                                <div id="room_type_id" class="input-error"></div>
                            </div>
                            <div class="form-group col-6 p-2 mb-0">
                                <label class="col-form-label text-left" for="time">Cài đặt giá <span style="color: red">(*)</span></label>
                                <div class="custom-control custom-radio">
                                    <input class="custom-control-input" type="radio" id="price_setting" name="price_setting" value="0" {{$params['item']['price_setting'] == 0 ? 'checked' : ''}}>
                                    <label class="custom-control-label" for="price_setting">
                                        Cài đặt như một loại giá mới
                                    </label>
                                </div>
                                <div class="custom-control custom-radio">
                                    <input class="custom-control-input" type="radio" id="price_setting" name="price_setting" value="1" disabled>
                                    <label class="custom-control-label" for="price_setting">
                                        Dựa trên một trong số loại giá hiện tại
                                    </label>
                                </div>
                            </div>
                            <div class="form-group col-6 p-2 mb-0">
                                <label class="col-form-label text-left" for="refund_policy">Chính sách hoàn huỷ <span style="color: red">(*)</span></label>
                                <div class="custom-control custom-radio">
                                    <input class="custom-control-input" type="radio" id="refund_policy_0" name="refund_policy" value="0" checked>
                                    <label class="custom-control-label" for="refund_policy_0">
                                      Theo chính sách hoàn huỷ chung
                                    </label>
                                </div>
                                <div class="custom-control custom-radio">
                                    <input class="custom-control-input" type="radio" id="refund_policy_1" name="refund_policy" value="1" disabled>
                                    <label class="custom-control-label" for="refund_policy_1">
                                       Chính sách hoàn huỷ riêng
                                    </label>
                                </div>
                                <div class="input-group col-6 p-2">
                                    <select class="form-control" name="refund_policy_id" id="refund_policy_id" disabled>
                                        <option value="">-- Chọn chính sách --</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group col-6 p-2 mb-0">
                                <label class="col-form-label text-left" for="additional_fee">Phí phụ thu người lớn</label>
                                <div class="custom-control custom-radio">
                                    <input class="custom-control-input additional-fee" type="radio" id="additional_fee_0" name="additional_fee" value="0" {{$params['item']['adt_fees'] == null ? 'checked' : ''}}>
                                    <label class="custom-control-label" for="additional_fee_0">
                                      Miễn phí
                                    </label>
                                </div>

                                <div class="custom-control custom-radio">
                                    <input class="custom-control-input additional-fee" type="radio" id="additional_fee_1" name="additional_fee" value="1" {{$params['item']['adt_fees'] != null ? 'checked' : ''}}>
                                    <label class="custom-control-label" for="additional_fee_1">
                                       Tính phí
                                    </label>
                                </div>
                                <div class="input-group col-6 p-2">
                                    <input type="text" class="form-control adt-free number_format" id="adt_fees" name="adt_fees" value="{{$params['item']['adt_fees'] ?? ''}}" {{$params['item']['adt_fees'] == null ? 'disabled' : '' }} required>
                                    <div class="input-group-append">
                                        <div class="input-group-text">VND</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 p-2 mb-0">
                                <label class="col-form-label text-left" for="fees">Thiết lập hạn chế</label>
                                <div class="row">
                                    <div class="form-group col-6 p-2 mb-0">
                                        <label class="col-form-label text-right" for="booking_date_min">Số ngày đặt trước tối thiểu</label>
                                        <input type="text" class="form-control" id="booking_date_min" name="booking_date_min" placeholder="Nhập số ngày đặt trước tối thiểu" value="{{$params['item']['booking_date_min'] ?? ''}}">
                                        {{-- <p class="m-2">Số ngày tối thiểu trước ngày nhận phòng mà khách có thể đặt loại giá này</p> --}}
                                        <div class="input-error"></div>
                                    </div>
                                    <div class="form-group col-6 p-2 mb-0">
                                        <label class="col-form-label text-right" for="booking_date_max">Số ngày đặt trước tối đa</label>
                                        <input type="text" class="form-control" id="booking_date_max" name="booking_date_max" placeholder="Nhập số ngày đặt trước tối đa" value="{{$params['item']['booking_date_max'] ?? ''}}">
                                        <div class="input-error"></div>
                                    </div>
                                    <div class="form-group col-6 p-2 mb-0">
                                        <label class="col-form-label text-right" for="nights_number_min">Số đêm tối thiểu</label>
                                        <input type="text" class="form-control" id="nights_number_min" name="nights_number_min" placeholder="Nhập số đêm tối thiểu" value="{{$params['item']['nights_number_min'] ?? ''}}">
                                        <div class="input-error"></div>
                                    </div>
                                    <div class="form-group col-6 p-2 mb-0">
                                        <label class="col-form-label text-right" for="nights_number_max">Số đêm tối đa</label>
                                        <input type="text" class="form-control" id="nights_number_max" name="nights_number_max" placeholder="Nhập số đêm tối đa" value="{{$params['item']['nights_number_max'] ?? ''}}">
                                        <div class="input-error"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-6 p-2 mb-0">
                                <label class="col-form-label text-right" for="status">Trạng Thái </label>
                                {!! \App\Models\Hotel\PriceTypeModel::slbStatus($params['item']['status'], '') !!}
                                <div class="input-error"></div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
            </div><!-- /.row -->
            </div>
            <div class="row">&nbsp;</div>
        </div>
    </form>
    <script>
        $(document).ready(function() {
            $('#admin-{{ $params['prefix'] }}-form').submit(function(e) {

                $('.input-error').html('');
                $('.form-group input, .select2').removeClass('is-invalid');
                e.preventDefault();
                var formData = new FormData(this);const formEl = $(this)
                $.ajax({
                    type: 'POST',
                    url: "{{ route($params['prefix'] . '.' . $params['controller'] . '.update', ['price_type' => $params['item']['id']]) }}",
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
                            $('#' + x).parents('.form-group').find('.input-error').html(data
                                .responseJSON.errors[x]);
                            $('#' + x).parents('.form-group').find('.input-error').show();
                            $('#' + x).addClass('is-invalid');
                        }
                    }
                });
            });
            $('#all_room_types').change(function() {
                if ($('#all_room_types').prop('checked')) {
                    $('.room-checked').prop('disabled', true).prop('checked', true);
                } else {
                    $('.room-checked').prop('disabled', false).prop('checked', false);
                }
            });
            $('.additional-fee').on('change', function(){
                const additional_fee = $(this).val();
               if (additional_fee == 0) {
                    $('.adt-free').prop('disabled', true).val('');
               }
               else {
                    $('.adt-free').prop('disabled', false);
               }
            });
            $('.select-hotel').on('change', function(e) {

                e.preventDefault();
                const hotel_id = $(this).val();
                $.ajax({
                    url: "{{ route($params['prefix'] . '.' . $params['controller'] . '.get-info') }}",
                    method: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {hotel_id:hotel_id},
                    success: function(data) {

                        var htmlRoom    = '';
                        $.each(data['roomType'], function(index, roomType) {
                            htmlRoom += '<div class="icheck-primary d-inline p-2">';
                            htmlRoom += '<input class="room-checked" type="checkbox" id="room_type' + index + '" name="room_type_id[]" value="' + roomType.id + '">';
                            htmlRoom += '<label for="room_type' + index + '">' + roomType.name + '</label>';
                            htmlRoom += '</div>';
                        });
                        $('#show_room_type').html(htmlRoom);
                    },
                    error: function(data) {

                        console.log(data);
                    }
                });
            });
        });

    </script>
@endsection
