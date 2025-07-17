@extends('layout.app')
@section('title', 'Update infomation khuyến mãi')
@section('main')
    <!-- Content Header (Page header) -->
    <form class="form-horizontal app-container" id="admin-{{ $params['prefix'] }}-form" name="admin-{{ $params['prefix'] }}-form"
        enctype="multipart/form-data" method="POST"
        action="{{ route($params['prefix'] . '.' . $params['controller'] . '.update', ['promotion' => $params['item']['id']]) }}">
        <input type="hidden" name="_method" value="PUT">
         <input type="hidden" name="id" value="{{ $params['item']['id'] }}">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-11">
                <div class="card">
                     <div class="card-header d-flex justify-content-between align-items-center">
                        Infomation
                        <div class="">
                            @include('include.btn.cancel', [
                                'href' => route($params['prefix'] . '.' . $params['controller'] . '.index'),
                            ])
                            @include('include.btn.save')
                        </div> <h3>Thông tin khuyến mãi</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="row m-0 pt-2">
                            <div class="card col-12 p-2 mb-0 mt-2">
                                <div class="row">
                                    <div class="form-group col-6 p-2 mb-0">
                                        <label class="col-form-label text-right" for="hotel">Khách sạn <span style="color: red">(*)</span></label>
                                        <select class="form-control select2 select-bluer select-hotel" id="hotel_id" name="hotel_id">
                                            <option value="">-- Chọn khách sạn --</option>
                                            @foreach ($params['hotel'] as $hotel)
                                            <option value="{{ $hotel['id'] }}" {{ $hotel['id'] == $params['item']['hotel_id'] ? 'selected' : ''}}>{{ $hotel['name'] }}</option>
                                            @endforeach
                                        </select>
                                        <div class="input-error"></div>
                                    </div>
                                    <div class="form-group col-6 p-2 mb-0">
                                        <label class="col-form-label text-right" for="name">Tên khuyến mãi <span style="color: red">(*)</span></label>
                                        <input type="text" class="form-control" id="name" name="name" placeholder="Nhập tên khuyến mãi" value="{{$params['item']['name'] ?? ''}}">
                                        <div class="input-error"></div>
                                    </div>
                                </div>
                                <label class="col-form-label text-left" for="type">Loại giá sẽ áp dụng</label>
                                <div class="custom-control custom-radio mt-2">
                                    <input class="custom-control-input disable" type="radio" id="all_price_types_0" name="all_price_types" value="1" {{$params['item']['all_price_types'] == 1 ? 'checked' : ''}}>
                                    <label class="custom-control-label" for="all_price_types_0">
                                      Tất cả loại giá
                                    </label>
                                </div>
                                <div class="custom-control custom-radio mt-2">
                                    <input class="custom-control-input disable" type="radio" id="all_price_types_1" name="all_price_types" value="0" {{$params['item']['all_price_types'] == 0 ? 'checked' : ''}}>
                                    <label class="custom-control-label" for="all_price_types_1">
                                        Chọn loại giá <span class="text-sm-left font-weight-normal">( Chọn ít nhất 1 loại giá<span style="color: red">*</span> )</span>
                                    </label>
                                </div>
                                <div class="row clearfix p-2" id="show_price_type">
                                    @foreach ($params['priceType'] as $priceType)
                                    <div class="icheck-primary d-inline p-2">
                                        <input class="disable-price-type" type="checkbox" id="price_type{{$loop->index}}" name="price_types[]"
                                        value="{{$priceType['id']}}" {{ in_array($priceType['id'], $params['item']['priceType']->pluck('price_type_id')->toArray()) ? 'checked' : '' }} {{ $params['item']['all_price_types'] == 1 ? 'disabled' : ''}}>
                                        <label for="price_type{{$loop->index}}">{{$priceType['name']}}</label>
                                    </div>
                                    @endforeach
                                </div>
                                <div class="input-error" id="all_price_types"></div>
                                <label class="col-form-label text-left" for="type">Loại phòng sẽ áp dụng</label>
                                <div class="custom-control custom-radio mt-2">
                                    <input class="custom-control-input disable" type="radio" id="all_room_types_0" name="all_room_types" value="1" {{$params['item']['all_room_types'] == 1 ? 'checked' : ''}}>
                                    <label class="custom-control-label" for="all_room_types_0">
                                      Tất cả loại phòng có loại giá đã chọn
                                    </label>
                                </div>
                                <div class="custom-control custom-radio mt-2">
                                    <input class="custom-control-input disable" type="radio" id="all_room_types_1" name="all_room_types" value="0" {{$params['item']['all_room_types'] == 0 ? 'checked' : ''}}>
                                    <label class="custom-control-label" for="all_room_types_1">
                                        Chọn phòng <span class="text-sm-left font-weight-normal">( Chọn ít nhất 1 phòng<span style="color: red">*</span> )</span>
                                    </label>
                                </div>
                                <div class="row clearfix p-2" id="show_room_type">
                                    @foreach ($params['roomType'] as $roomType)
                                    <div class="icheck-primary d-inline p-2">
                                        <input class="disable-room-type" type="checkbox" id="room_type{{$loop->index}}" name="room_types[]"
                                        value="{{$roomType['id']}}" {{ in_array($roomType['id'], $params['item']['roomType']->pluck('room_type_id')->toArray()) ? 'checked' : '' }} {{$params['item']['all_room_types'] == 1 ? 'disabled' : ''}}>
                                        <label for="room_type{{$loop->index}}">{{$roomType['name']}}</label>
                                    </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="card form-group col-12 p-2 mb-0 mt-2">
                                <label class="col-form-label text-left" for="time">Áp dụng giảm giá</label>
                                <div class="custom-control custom-radio mt-2">
                                    <input class="custom-control-input promotion" type="radio" id="perNight" name="promotion" value="0" {{isset($params['item']['discount_per_night']) != null ? 'checked': ''}}>
                                    <label class="custom-control-label" for="perNight">
                                        Mỗi đêm
                                    </label>
                                </div>
                                <div class="input-group col-3 p-2" id="per-night-group" style="display:none;">
                                    <input type="number" class="form-control" id="per_night" name="discount_per_night" min="0" max="100" value="{{$params['item']['discount_per_night'] ?? ''}}">
                                    <div class="input-group-append">
                                        <div class="input-group-text">%</div>
                                    </div>
                                </div>
                                <div class="custom-control custom-radio mt-2">
                                    <input class="custom-control-input promotion" type="radio" id="firstNight" name="promotion" value="1" {{isset($params['item']['discount_first_night']) != null ? 'checked': ''}}>
                                    <label class="custom-control-label" for="firstNight">
                                        Đêm đầu tiên
                                    </label>
                                </div>
                                <div class="input-group col-3 p-2" id="first-night-group" style="display:none;">
                                    <input type="number" class="form-control" id="first_night" name="discount_first_night" min="0" max="100" value="{{$params['item']['discount_first_night'] ?? ''}}">
                                    <div class="input-group-append">
                                        <div class="input-group-text">%</div>
                                    </div>
                                </div>
                                <div class="custom-control custom-radio mt-2 mb-3">
                                    <input class="custom-control-input promotion" type="radio" id="specificDay" name="promotion" value="2" {{isset($params['item']['discount_specific_days']) != null ? 'checked': ''}}>
                                    <label class="custom-control-label" for="specificDay">
                                        Ngày cụ thể trong tuần
                                    </label>
                                </div>

                                <div class="row" id="specific-days-group" style="display:none;">
                                    @if ($params['item']['discount_specific_days'] != null)
                                        @foreach ($params['item']['discount_specific_days'] as $day => $specific_day)
                                        <div class="form-group col-2">
                                            <label class="col-form-label text-right ml-2" for="">
                                                @if ($day == 0)
                                                    Chủ nhật
                                                @else
                                                    Thứ {{$day + 1}}
                                                @endif
                                            </label>
                                            <div class="input-group col-12">
                                                <input type="number" class="form-control specific_days" id="specific_day" name="discount_specific_days[{{$day}}]" min="0" max="100" value="{{$specific_day}}">
                                                <div class="input-group-append">
                                                    <div class="input-group-text">%</div>
                                                </div>
                                            </div>
                                            <div class="input-error"></div>
                                        </div>
                                    @endforeach
                                    @else
                                        <div class="form-group col-2">
                                            <label class="col-form-label text-right ml-2" for="">Thứ 2</label>
                                            <div class="input-group col-12">
                                                <input type="number" class="form-control specific_days" id="specific_day" name="discount_specific_days[1]" min="0" max="100">
                                                <div class="input-group-append">
                                                    <div class="input-group-text">%</div>
                                                </div>
                                            </div>
                                            <div class="input-error"></div>
                                        </div>
                                        <div class="form-group col-2">
                                            <label class="col-form-label text-right ml-2" for="">Thứ 3</label>
                                            <div class="input-group col-12">
                                                <input type="number" class="form-control specific_days" id="specific_days" name="discount_specific_days[2]" min="0" max="100">
                                                <div class="input-group-append">
                                                    <div class="input-group-text">%</div>
                                                </div>
                                            </div>
                                            <div class="input-error"></div>
                                        </div>
                                        <div class="form-group col-2">
                                            <label class="col-form-label text-right ml-2" for="">Thứ 4</label>
                                            <div class="input-group col-12">
                                                <input type="number" class="form-control specific_days" id="specific_days" name="discount_specific_days[3]" min="0" max="100">
                                                <div class="input-group-append">
                                                    <div class="input-group-text">%</div>
                                                </div>
                                            </div>
                                            <div class="input-error"></div>
                                        </div>
                                        <div class="form-group col-2">
                                            <label class="col-form-label text-right ml-2" for="">Thứ 5</label>
                                            <div class="input-group col-12">
                                                <input type="number" class="form-control specific_days" id="specific_days" name="discount_specific_days[4]" min="0" max="100">
                                                <div class="input-group-append">
                                                    <div class="input-group-text">%</div>
                                                </div>
                                            </div>
                                            <div class="input-error"></div>
                                        </div>
                                        <div class="form-group col-2">
                                            <label class="col-form-label text-right ml-2" for="">Thứ 6</label>
                                            <div class="input-group col-12">
                                                <input type="number" class="form-control specific_days" id="specific_days" name="discount_specific_days[5]" min="0" max="100">
                                                <div class="input-group-append">
                                                    <div class="input-group-text">%</div>
                                                </div>
                                            </div>
                                            <div class="input-error"></div>
                                        </div>
                                        <div class="form-group col-2">
                                            <label class="col-form-label text-right ml-2" for="">Thứ 7</label>
                                            <div class="input-group col-12">
                                                <input type="number" class="form-control specific_days" id="specific_days" name="discount_specific_days[6]" min="0" max="100">
                                                <div class="input-group-append">
                                                    <div class="input-group-text">%</div>
                                                </div>
                                            </div>
                                            <div class="input-error"></div>
                                        </div>
                                        <div class="form-group col-2">
                                            <label class="col-form-label text-right ml-2" for="">Chủ nhật</label>
                                            <div class="input-group col-12">
                                                <input type="number" class="form-control specific_days" id="specific_days" name="discount_specific_days[0]" min="0" max="100">
                                                <div class="input-group-append">
                                                    <div class="input-group-text">%</div>
                                                </div>
                                            </div>
                                            <div class="input-error"></div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="card col-12 p-2 mb-0 mt-2">
                                <label class="col-form-label text-left" for="start_date">Thời gian áp dụng khuyến mãi</label>
                                <div class="row">
                                    <div class="form-group col-4">
                                        <label class="col-form-label text-right ml-2">Từ <span style="color: red">(*)</span></label>
                                        <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                            <input type="text" class="form-control datetimepicker-input" id="start_date" name="start_date" data-target="#reservationdate" value="{{$params['item']['start_date'] ?? ''}}">
                                            <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                            </div>
                                        </div>
                                        <div class="input-error"></div>
                                    </div>
                                    <div class="form-group col-4">
                                        <label class="col-form-label text-right ml-2">Đến <span style="color: red">(*)</span></label>
                                        <div class="input-group date" id="reservationdate1" data-target-input="nearest">
                                            <input type="text" class="form-control datetimepicker-input unlimit" id="end_date" name="end_date" data-target="#reservationdate1" value="{{$params['item']['end_date'] ?? ''}}">
                                            <div class="input-group-append" data-target="#reservationdate1" data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                            </div>

                                        </div>
                                        <div class="input-error"></div>
                                    </div>
                                    <div class="form-group col-4">
                                        <div class="icheck-primary d-inline p-2" style="position: absolute; top: 30px; left: 0; transform: translateY(0);">
                                            <input class="disable" type="checkbox" id="unlimit" name="unlimit" value="1" {{isset($params['item']['end_date']) == null ? 'checked' : '' }}>
                                            <label for="unlimit">Gia hạn ngày đặt vô hạn</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card form-group col-12 p-2 mb-0 mt-2">
                                <label class="col-form-label text-left">Có cho phép cộng dồn khuyến mãi?</label>
                                <div class="custom-control custom-switch">
                                    <input type="hidden" id="is_stackable_hidden" name="is_stackable" value="0">
                                    <input type="checkbox" class="custom-control-input" id="is_stackable" name="is_stackable" value="1" {{isset($params['item']['is_stackable']) == 1 ? 'checked' : ''}}>
                                  <label class="custom-control-label" for="is_stackable">Cho phép cộng dồn</label>
                                </div>
                                <label class="col-form-label text-left mt-3" for="status">Trạng Thái </label>
                                <div class="col-4">
                                    {!! \App\Models\Hotel\PromotionModel::slbStatus($params['item']['status'],) !!}
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
                    url: "{{ route($params['prefix'] . '.' . $params['controller'] . '.update', ['promotion' => $params['item']['id']]) }}",
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
            $('#reservationdate').datetimepicker({
               format: 'YYYY-MM-DD',
               //minDate: moment()
            });
            $('#reservationdate1').datetimepicker({
               format: 'YYYY-MM-DD',
               //minDate: moment()
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
                            var htmlPrice   = '';
                            $.each(data['priceType'], function(index, priceType) {
                                htmlPrice += '<div class="icheck-primary d-inline p-2">';
                                htmlPrice += '<input class="disable-price-type" type="checkbox" id="price_type' + index + '" name="price_types[]" value="' + priceType.id + '">';
                                htmlPrice += '<label for="price_type' + index + '">' + priceType.name + '</label>';
                                htmlPrice += '</div>';
                            });
                            $.each(data['roomType'], function(index, roomType) {
                                htmlRoom += '<div class="icheck-primary d-inline p-2">';
                                htmlRoom += '<input class="disable-room-type" type="checkbox" id="room_type' + index + '" name="room_types[]" value="' + roomType.id + '">';
                                htmlRoom += '<label for="room_type' + index + '">' + roomType.name + '</label>';
                                htmlRoom += '</div>';
                            });
                            $('#show_price_type').html(htmlPrice);
                            $('#show_room_type').html(htmlRoom);
                        },
                        error: function(data) {

                            console.log(data);

                        }
                    });
            });
            $('.disable').on('change', function() {
                const id = $(this).attr('id');
                let targetClass = '';
                if ($(this).prop('checked')) {
                    switch (id) {
                        case 'all_room_types_0':
                            targetClass = '.disable-room-type';
                            break;
                        case 'all_room_types_1':
                            targetClass = '.disable-room-type';
                            break;
                        case 'all_price_types_0':
                            targetClass = '.disable-price-type';
                            break;
                        case 'all_price_types_1':
                            targetClass = '.disable-price-type';
                            break;
                        case 'unlimit':
                            targetClass = '.unlimit';
                            break;
                    }
                    if (targetClass) {
                        if (id === 'all_room_types_0' || id === 'all_price_types_0') {
                            $(targetClass).prop('disabled', true).prop('checked', true);
                        }
                        else if (id === 'unlimit') {
                            $(targetClass).prop('disabled', true).prop('checked', true).val('');

                        } else {
                            $(targetClass).prop('disabled', false).prop('checked', false);
                        }
                    }
                }
                else {
                    $('.unlimit').prop('disabled', false).prop('checked', false);
                }
            });

            $('.promotion').on('change', function() {
                const value         = $(this).val();
                const perNight      = $('#per-night-group');
                const firstNight    = $('#first-night-group');
                const specificDays  = $('#specific-days-group');

                perNight.hide();
                firstNight.hide();
                specificDays.hide();
                if (value == '0') {
                    firstNight.find('#first_night').val(null);
                    specificDays.find('.specific_days').val(null);
                    perNight.show();
                } else if (value == '1') {
                    perNight.find('#per_night').val(null);
                    specificDays.find('.specific_days').val(null);
                    firstNight.show();
                } else if (value == '2') {
                    perNight.find('#per_night').val(null);
                    firstNight.find('#first_night').val(null);
                    specificDays.show();
                }
            });
            $('.promotion:checked').trigger('change');
            if ($('#unlimit').prop('checked')) {
                 $('.unlimit').prop('disabled', true).prop('checked', true).val('');
            }
        });

    </script>
@endsection
