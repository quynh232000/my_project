@extends('layout.app')
@section('title', 'Cập nhật thông tin khách sạn')
@section('main')

    <div id="kt_app_content_container" class="app-container ">
        <form class="form-horizontal app-container" id="admin-{{ $params['prefix'] }}-form"
            name="admin-{{ $params['prefix'] }}-form" enctype="multipart/form-data" method="POST"
            action="{{ route($params['prefix'] . '.' . $params['controller'] . '.update', ['hotel' => $params['item']['id']]) }}">
            <input type="hidden" name="_method" value="PUT">
            <input type="hidden" name="id" value="{{ $params['item']['id'] }}">
            <div class="card-header d-flex justify-content-between align-items-center mb-5">
                <div></div>
                <div>
                    @include('include.btn.cancel', [
                        'href' => route($params['prefix'] . '.' . $params['controller'] . '.index'),
                    ])
                    @include('include.btn.save')
                </div>
            </div>
            <div class="row ">

                <div class="col-6 col-md-6 col-sm-12 ">
                    <div class="card">

                        <!-- /.card-header -->
                        <div class="card-body p-1">
                            <div class="row m-0  pt-2">
                                <div class="form-group col-6 p-2 mb-0">
                                    <label class="col-form-label text-right" for="name">Tên khách sạn<span
                                            style="color: red">(*)</span></label>
                                    <input type="text" class="form-control generate-slug" id="name" name="name"
                                        placeholder="Nhập tiêu đề" value="{{ $params['item']['name'] }}">
                                    <div class="input-error"></div>
                                </div>
                                <div class="form-group col-6 p-2 mb-0">
                                    <label class="col-form-label text-right" for="slug">Slug<span
                                            style="color: red">(*)</span></label>
                                    <input type="text" class="form-control" id="slug" name="slug"
                                        placeholder="Nhập slug" value="{{ $params['item']['slug'] }}">
                                    <div class="input-error"></div>
                                </div>

                                <div class="form-group col-6 p-2 mb-0">
                                    <label class="col-form-label text-right" for="commission_rate">Phí triết khấu(%)</label>
                                    <input type="number" step="0.01" min="0" max="100" class="form-control"
                                        id="commission_rate" name="commission_rate" placeholder="Nhập phí triết khấu"
                                        value="{{ $params['item']['commission_rate'] }}">
                                    <div class="input-error"></div>
                                </div>
                                <div class="form-group col-6 p-2 mb-0">
                                    <label class="col-form-label text-right" for="status">Loại hình cư trú <span
                                            style="color: red">(*)</span></label>
                                    {!! \App\Models\Hotel\HotelModel::selectAccommodation($params['item']['accommodation_id']) !!}
                                    <div class="input-error"></div>
                                </div>
                                <div class="form-group col-6 p-2 mb-0">
                                    <label class="col-form-label text-right" for="time_checkin">Giờ nhận phòng</label>
                                    <input type="time" class="form-control" id="time_checkin" name="time_checkin"
                                        placeholder="Nhập.." value="{{ $params['item']['time_checkin'] }}">
                                    <div class="input-error"></div>
                                </div>
                                <div class="form-group col-6 p-2 mb-0">
                                    <label class="col-form-label text-right" for="time_checkout">Giờ trả phòng</label>
                                    <input type="time" class="form-control" id="time_checkout" name="time_checkout"
                                        placeholder="Nhập.." value="{{ $params['item']['time_checkout'] }}">
                                    <div class="input-error"></div>
                                </div>
                                <div class="form-group col-6 p-2 mb-0">
                                    <label class="col-form-label text-right" for="construction_year">Năm xây dựng</label>
                                    <input type="number" min="1900" max="2100"
                                        value="{{ $params['item']['construction_year'] }}" id="construction_year"
                                        class="form-control" name="construction_year" placeholder="Chọn năm">
                                    <div class="input-error"></div>
                                </div>
                                <div class="form-group col-6 p-2 mb-0 star">
                                    <label class="col-form-label text-right" for="commission_rate">Hạng sao</label>
                                    <input type="number" min="0" max="5" value=""
                                        id="construction_year" class="form-control" name="stars"
                                        value="{{ $params['item']->stars ?? '' }}" placeholder="Chọn năm">
                                    <div class="input-error"></div>

                                </div>
                                <div class="form-group col-6 p-2 mb-0">
                                    <label class="col-form-label text-right" for="floor_count">Số tầng</label>
                                    <input type="number" min="0" max="100" class="form-control"
                                        id="floor_count" name="floor_count" placeholder="Nhập số.."
                                        value="{{ $params['item']['floor_count'] }}">
                                    <div class="input-error"></div>
                                </div>
                                <div class="form-group col-6 p-2 mb-0">
                                    <label class="col-form-label text-right" for="floor_count">Số phòng</label>
                                    <input type="number" min="1" max="100" class="form-control"
                                        id="room_count" name="room_count" placeholder="Nhập số.."
                                        value="{{ $params['item']['room_count'] }}">
                                    <div class="input-error"></div>
                                </div>
                                <div class="form-group col-6 p-2 mb-0">
                                    <label class="col-form-label text-right" for="bar_count">Số quán bar</label>
                                    <input type="number" min="0" max="100" class="form-control"
                                        id="bar_count" name="bar_count" placeholder="Nhập số.."
                                        value="{{ $params['item']['bar_count'] }}">
                                    <div class="input-error"></div>
                                </div>
                                <div class="form-group col-6 p-2 mb-0">
                                    <label class="col-form-label text-right" for="restaurant_count">Số nhà hàng</label>
                                    <input type="number" class="form-control" id="restaurant_count"
                                        name="restaurant_count" placeholder="Nhập số.."
                                        value="{{ $params['item']['restaurant_count'] }}">
                                    <div class="input-error"></div>
                                </div>

                                <div class="form-group col-6 p-2 mb-0">
                                    <label class="col-form-label text-right" for="language">Ngôn ngữ hỗ trợ</label>
                                    {!! \App\Models\Hotel\HotelModel::selectLanguage($params['item']['language'] ?? null) !!}
                                    <div class="input-error"></div>
                                </div>

                                <div class="form-group col-6 p-2 mb-0">
                                    <label class="col-form-label text-right" for="featured">Nổi bật</label>
                                    <select class="form-control" id="featured" name="featured">
                                        <option value="0"
                                            {{ isset($params['item']['featured']) && $params['item']['featured'] == 0 ? 'selected' : '' }}>
                                            Không
                                        </option>
                                        <option value="1"
                                            {{ isset($params['item']['featured']) && $params['item']['featured'] == 1 ? 'selected' : '' }}>
                                            Có</option>
                                    </select>
                                    <div class="input-error"></div>
                                </div>
                                <div class="form-group col-6 p-2 mb-0">
                                    <label class="col-form-label text-right" for="status">Trạng Thái </label>
                                    {!! \App\Models\Hotel\HotelModel::slbStatus($params['item']['status']) !!}
                                    <div class="input-error"></div>
                                </div>
                                <div class="form-group col-12 p-2 mb-0">
                                    <label class="col-form-label text-right" for="description">Mô tả <span
                                            style="color: red">(*)</span></label>
                                    {{-- <p style="color: red; font-size: 14px">Vui lòng không sao chép nội dung từ trang web khác và không chỉnh sửa định dạng hình ảnh! </p> --}}
                                    {!! \App\Helpers\Template::InputText($params, 'description', $params['item']['description'] ?? '') !!}
                                    <div class="input-error"></div>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body p-1 -->
                    </div>
                </div>
                <div class="col-6 col-md-6 col-sm-12">
                    <div class="d-flex" style="flex-direction: column;gap:8px">
                        @include('hotel.hotel.album.edit')
                        @include('hotel.hotel.address.edit')
                        @include('hotel.hotel.customer.edit')
                    </div>
                </div>
            </div>

            {{-- start nearby locaton --}}
            @include('hotel.hotel.nearby-location.edit')


        </form>

    </div>





@endsection
@push('js2')
    <script src="{{ asset('assets/js/widgets.bundle.js') }}"></script>
    <script src="{{ asset('assets/js/custom/widgets.js') }}"></script>
    <script src="{{ asset('assets/js/custom/apps/chat/chat.js') }}"></script>
    <script src="{{ asset('assets/js/custom/utilities/modals/users-search.js') }}"></script>
    <script src="{{ asset('assets/js/custom/apps/ecommerce/catalog/save-product.js') }}"></script>
    <script>
        $('#admin-{{ $params['prefix'] }}-form').on('keydown', 'input', function(e) {
            if (e.key === "Enter") {
                e.preventDefault(); // Ngăn chặn submit khi nhấn Enter
            }
        });
        // form submit
        $('#admin-{{ $params['prefix'] }}-form').submit(function(e) {
            e.preventDefault();
            $('.input-error').html('');
            const formEl = $(this)
            $(this).find('.indicator-label').hide()
            $(this).find('.indicator-progress').show()
            $(this).find(`button[type='submit']`).prop('disabled', true);
            $('.input-error').html('');
            $('.form-group row p-0 m-0 mb-2 input').removeClass('is-invalid');
            var formData = new FormData(this);
            $.ajax({
                type: 'POST',
                url: "{{ route($params['prefix'] . '.' . $params['controller'] . '.update', ['hotel' => $params['item']['id']]) }}",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: (res) => {
                    console.log(res);

                    $(formEl).find('.indicator-label').show()
                    $(formEl).find('.indicator-progress').hide()
                    $(formEl).find(`button[type='submit']`).prop('disabled', false);

                    if (res.success) {
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
                            }))
                    } else {
                        Swal.fire({
                            html: res.message ??
                                "Sorry, looks like there are some errors detected, please try again: ",
                            icon: "error",
                            buttonsStyling: !1,
                            confirmButtonText: "Ok, got it!",
                            customClass: {
                                confirmButton: "btn btn-primary"
                            }
                        })
                    }

                },
                error: function(data) {
                    console.log(data.responseJSON.errors);


                    $(formEl).find('.indicator-label').show()
                    $(formEl).find('.indicator-progress').hide()
                    $(formEl).find(`button[type='submit']`).prop('disabled', false);
                    let errorMs = '<ul class="text-right text-start text-danger mt-3">';
                    for (x in data.responseJSON.errors) {
                        errorMs += `<li><i class="">${data.responseJSON.errors[x]}</i></li>`
                        $('#' + x).parents('.form-group').find('.input-error').html(data
                            .responseJSON.errors[x]);
                        $('#' + x).parents('.form-group').find('.input-error').show();
                        $('#' + x).addClass('is-invalid');
                    }
                    errorMs += '</ul>'
                    if (data.status == 400) {
                        errorMs =
                            `<div class="text-danger mt-2"> ${ data.responseJSON.message ?? 'Error from server' }</div>`
                    }
                    Swal.fire({
                        html: "Sorry, something errors please try again: " +
                            errorMs,
                        icon: "error",
                        buttonsStyling: !1,
                        confirmButtonText: "Ok, got it!",
                        customClass: {
                            confirmButton: "btn btn-primary"
                        }
                    })
                }
            });
        });

        function showInvalid(key, mess) {
            let inputName = key.replace(/\./g, '][').replace(/^/, '[').replace(/$/, ']');
            const x = key.split('.')
            let element = '#' + x[0]
            if (x.length >= 3) {
                element = $(`input[name="${x[0]}[${x[1]}][${x[2]}]${x[2]=='images'?'[]':''}"]`)
                if (x[2] == 'images' && x.length == 4) {
                    element = $(`input[name^="${x[0]}[${x[1]}][${x[2]}]"]`)
                    $(element).parents('.form-group').find('.input-error')
                        .append(`<li>Hình số ${+x[3]+1} ${mess}</li>`);
                } else {
                    $(element).parents('.form-group').find('.input-error').html(mess);
                }
            } else {
                $(element).parents('.form-group').find('.input-error').html(mess);
            }
            $(element).parents('.form-group').find('.input-error').show();
            $(element).addClass('is-invalid');
        }

        function hideInvalid(x) {
            $('#' + x).parents('.form-group').find('.input-error').html('');
            $('#' + x).parents('.form-group').find('.input-error').hide();
            $('#' + x).removeClass('is-invalid');
        }
    </script>
@endpush
