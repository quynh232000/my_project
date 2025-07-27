@extends('layout.app')
@section('title', 'Thêm mới khách sạn')
{{-- <script src="{{ url('assets/plugins/admin-lte/plugins/dropzone/min/dropzone.min.js') }}"></script>
<link rel="stylesheet" href="{{ url('assets/plugins/admin-lte/plugins/dropzone/min/dropzone.min.css') }}"> --}}

@section('main')

    <!-- Content Header (Page header) -->
    <style>
        .drop_zone .preview img {
            width: 100%;
            height: 100px;
            object-fit: cover;
            /* border: 1px solid rgba(22,22,24,.21) */
        }

        .dropzone {
            display: flex;
            flex-wrap: wrap;
            text-align: center;
            padding: 8px 0;
        }

        .dz-default.dz-message {
            width: 100%;
        }

        .btn.delete {
            margin: 5px 0;
        }

        .custom_scroll {
            max-height: 500px;
            overflow-y: scroll
        }

        .custom_scroll::-webkit-scrollbar {
            width: 6px;
        }

        .custom_scroll::-webkit-scrollbar-track {
            box-shadow: inset 0 0 6px rgba(233, 232, 232, 0.3);
        }

        .custom_scroll::-webkit-scrollbar-thumb {
            background-color: rgb(236, 232, 232);
            outline: 1px solid rgb(225, 225, 226);
        }

        .img_item button.delete {
            display: none;
            transition: .3s ease all
        }

        .img_item:hover button.delete {
            display: flex;
        }

        .content-wrapper {
            height: auto;
        }
    </style>
    <div id="kt_app_content_container" class="app-container ">
        <form class="form-horizontal" id="admin-{{ $params['prefix'] }}-form" name="admin-{{ $params['prefix'] }}-form"
            enctype="multipart/form-data" method="POST"
            action="{{ route($params['prefix'] . '.' . $params['controller'] . '.store') }}">
            <input type="hidden" name="_method" value="POST">
            <div class="card-header d-flex justify-content-between align-items-center mb-5">
                Infomation
                <div>
                    @include('include.btn.cancel', [
                        'href' => route($params['prefix'] . '.' . $params['controller'] . '.index'),
                    ])
                    @include('include.btn.save')
                </div>
            </div>
            <div class="row">
                <div class="col-6 col-md-6 col-sm-12 ">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Thông tin chung</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body p-2">
                            <div class="row m-0  pt-2">
                                <div class="form-group col-6 p-2 mb-0">
                                    <label class="col-form-label text-right" for="name">Tên khách sạn<span
                                            style="color: red">(*)</span></label>
                                    <input type="text" class="form-control generate-slug" id="name" name="name"
                                        placeholder="Nhập tiêu đề" value="">
                                    <div class="input-error"></div>
                                </div>
                                <div class="form-group col-6 p-2 mb-0">
                                    <label class="col-form-label text-right" for="slug">Slug<span
                                            style="color: red">(*)</span></label>
                                    <input type="text" class="form-control" id="slug" name="slug"
                                        placeholder="Nhập slug" value="">
                                    <div class="input-error"></div>
                                </div>
                                <div class="form-group col-6 p-2 mb-0">
                                    <label class="col-form-label text-right" for="commission_rate">Phí triết khấu</label>
                                    <input step="0.01" min="0" max="100" type="number" class="form-control"
                                        id="commission_rate" name="commission_rate" placeholder="Nhập phí triết khấu"
                                        value="">
                                    <div class="input-error"></div>
                                </div>
                                <div class="form-group col-12 col-md-6 p-2 mb-0">
                                    <label class="col-form-label text-right" for="status">Loại hình cư trú <span
                                            style="color: red">(*)</span></label>
                                    {!! \App\Models\Hotel\HotelModel::selectAccommodation() !!}
                                    <div class="input-error"></div>
                                </div>
                                <div class="form-group col-6 p-2 mb-0">
                                    <label class="col-form-label text-right" for="time_checkin">Giờ nhận phòng</label>
                                    <input type="time" class="form-control" id="time_checkin" name="time_checkin"
                                        placeholder="Nhập time_checkin" value="09:00">
                                    <div class="input-error"></div>
                                </div>
                                <div class="form-group col-6 p-2 mb-0">
                                    <label class="col-form-label text-right" for="time_checkout">Giờ trả phòng</label>
                                    <input type="time" class="form-control" id="time_checkout" name="time_checkout"
                                        placeholder="Nhập time_checkout" value="12:00">
                                    <div class="input-error"></div>
                                </div>
                                <div class="form-group col-6 p-2 mb-0">
                                    <label class="col-form-label text-right" for="construction_year">Năm xây dựng</label>
                                    <input type="number" min="1900" max="2100" value=""
                                        id="construction_year" class="form-control" name="construction_year"
                                        placeholder="Chọn năm">
                                    <div class="input-error"></div>
                                </div>
                                <div class="form-group col-6 p-2 mb-0 star">
                                    <label class="col-form-label text-right" for="commission_rate">Hạng sao</label>
                                    <input type="number" min="0" max="5" value=""
                                        id="construction_year" class="form-control" name="stars" placeholder="Chọn năm">
                                    <div class="input-error"></div>

                                </div>
                                <div class="form-group col-6 p-2 mb-0">
                                    <label class="col-form-label text-right" for="floor_count">Số tầng</label>
                                    <input type="number" min="0" max="100" class="form-control"
                                        id="floor_count" name="floor_count" placeholder="Nhập số.." value="0">
                                    <div class="input-error"></div>
                                </div>
                                <div class="form-group col-6 p-2 mb-0">
                                    <label class="col-form-label text-right" for="floor_count">Số phòng</label>
                                    <input type="number" min="1" max="100" class="form-control"
                                        id="room_count" name="room_count" placeholder="Nhập số.." value="1">
                                    <div class="input-error"></div>
                                </div>
                                <div class="form-group col-6 p-2 mb-0">
                                    <label class="col-form-label text-right" for="bar_count">Số quán bar</label>
                                    <input type="number" min="0" max="100" class="form-control"
                                        id="bar_count" name="bar_count" placeholder="Nhập số.." value="0">
                                    <div class="input-error"></div>
                                </div>
                                <div class="form-group col-6 p-2 mb-0">
                                    <label class="col-form-label text-right" for="restaurant_count">Số nhà hàng</label>
                                    <input type="number" class="form-control" id="restaurant_count"
                                        name="restaurant_count" placeholder="Nhập số.." value="0">
                                    <div class="input-error"></div>
                                </div>
                                <div class="form-group col-6 p-2 mb-0">
                                    <label class="col-form-label text-right" for="language">Ngôn ngữ hỗ trợ</label>
                                    {!! \App\Models\Hotel\HotelModel::selectLanguage() !!}
                                    <div class="input-error"></div>
                                </div>
                                <div class="form-group col-md-6 p-2 mb-0">
                                    <label class="col-form-label text-right" for="position">Vị trí
                                        <i class="fa-regular fa-circle-info" data-toggle="tooltip" data-placement="top"
                                            title="Vị trí sẽ xuất hiện ngoài trang chủ"></i>

                                    </label>
                                    {!! \App\Models\Hotel\HotelModel::selectPosition() !!}
                                    <div class="input-error"></div>
                                </div>
                                <div class="form-group col-6 p-2 mb-0">
                                    <label class="col-form-label text-right" for="status">Trạng Thái </label>
                                    {!! \App\Models\Hotel\HotelModel::slbStatus('active') !!}
                                    <div class="input-error"></div>
                                </div>
                                <div class="form-group col-12 p-2 mb-0">
                                    <label class="col-form-label text-right" for="description">Mô tả <span
                                            style="color: red">(*)</span></label>
                                    {{-- <p style="color: red; font-size: 14px">Vui lòng không sao chép nội dung từ trang web khác và không chỉnh sửa định dạng hình ảnh! </p> --}}
                                    {!! \App\Helpers\Template::InputText($params, 'description') !!}
                                    <div class="input-error"></div>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    @include('hotel.hotel.album.create')
                    @include('hotel.hotel.address.create')
                    @include('hotel.hotel.customer.create')
                    @include('include.common.meta-box')
                </div>

            </div>

            {{-- start nearby locaton --}}
            @include('hotel.hotel.nearby-location.create')
            {{-- end nearby locaton --}}

            <div class="d-none justify-between align-items-center" style="justify-content: space-between">
                <h4 class="py-2">Tiện ích và dịch vụ</h4>
            </div>
            <div class="card d-none">
                <div class="card-body row p-2">
                    <div class="col-12 col-md-4 border-right service_parent custom_scroll" id="list_check">
                        <h5 class="border-bottom pb-2">Chọn tiện ích</h5>
                        <div class="form-check border-bottom py-2">
                            <input class="form-check-input" data-type='check-list-all' type="checkbox" id="check_all">
                            <label class="form-check-label fw-bold" for="check_all">
                                Chọn tất cả tiện ích
                                ({{ array_reduce($params['info']['services'],function ($s, $item) {return $s + count($item['children'] ?? []);},0) }})
                            </label>
                        </div>
                        @foreach ($params['info']['services'] as $parent)
                            <div class="px-3 py-2 border-bottom service_parent service_group"
                                data-service-id="{{ $parent['id'] }}">
                                <div class="form-check">
                                    <input class="form-check-input input_service" data-type="check-list" type="checkbox"
                                        id="service_parent_{{ $parent['id'] }}">
                                    <label class="form-check-label fw-bold" for="service_parent_{{ $parent['id'] }}">
                                        {{ $parent['name'] }} ({{ count($parent['children']) ?? 0 }})
                                    </label>
                                </div>
                                <div class="p-2 px-4">
                                    @foreach ($parent['children'] ?? [] as $child)
                                        <div class="form-check">
                                            <input name="facility[{{ $parent['id'] . '_' . $child['id'] }}]"
                                                data-type="check-item" value="{{ $child['id'] }}"
                                                class="form-check-input input_item"
                                                id="service_child_{{ $child['id'] }}" type="checkbox">
                                            <label class="form-check-label" for="service_child_{{ $child['id'] }}">
                                                {{ $child['name'] }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- selected --}}
                    <div class="col-12 col-md-8 custom_scroll">
                        <h5 class="border-bottom pb-2">Tiện ích đã chọn</h5>
                        <div class="row px-2" id="list-service-select">
                            <div class="col-12 text-center py-5">
                                Chưa có tiện ích nào được chọn!
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            {{-- start faqs --}}
            {{-- @include('hotel.hotel.faqs.create') --}}
            {{-- end faqs --}}


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
        // form submit
        $('#admin-{{ $params['prefix'] }}-form').submit(function(e) {
            e.preventDefault();
            const formEl = $(this)
            $('.input-error').html('');
            $(this).find('.indicator-label').hide()
            $(this).find('.indicator-progress').show()
            $(this).find(`button[type='submit']`).prop('disabled', true);
            $('.input-error').html('');
            $('.form-group row p-0 m-0 mb-2 input').removeClass('is-invalid');
            var formData = new FormData(this);
            $.ajax({
                type: 'POST',
                url: "{{ route($params['prefix'] . '.' . $params['controller'] . '.store') }}",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: (res) => {
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

        function validateSizeImage(form) {
            const inputs = $(form).find('input[type="file"]')
            $(inputs)?.each((index, element) => {
                if ($(element).attr('multiple')) {
                    console.log('is multi');
                    console.log($(element)[0].files);

                } else {
                    const files = $(element)[0].files;
                    if (files.length > 0) {
                        const file = files[0];
                        const fileSizeMB = file.size / (1024 * 1024);
                        if (fileSizeMB > 2) {
                            $(element).closest('.form-group').find('.input-error').show().text(
                                'Vui lòng chọn File có kích thước nhỏ hơn 2mb')
                        }
                    }

                }
            });
            return false
        }
    </script>

    <script>
        // ======================== start service ================================
        const facilitiesHotel = @json($params['data']['facilitiesHotel']);
        const services = @json($params['data']['services']);
        const inputEl = '#list_check input';
        const listResultEl = '#list-service-select'
        const list = '#list_check'

        $(inputEl).on('change', function() { //change input
            const dataType = $(this).attr('data-type')
            if (dataType && dataType.includes('check-list')) {
                $(this).closest('.service_parent').find('input').prop('checked', $(this).prop('checked'))
                if (!$(this).prop('checked') && dataType !== 'check-list-all') {
                    $('#check_all').prop('checked', false)
                }
            }
            checkParent() //check parent input
            renderSelectService()
        })

        function renderSelectService() {
            let dataIds = {}
            $(inputEl).each(function(input) {
                if ($(this).attr('data-type') == 'check-item' && $(this).prop('checked')) {
                    const service_id = $(this).closest('.service_parent').attr('data-service-id')
                    const value = $(this).val()
                    dataIds = {
                        ...dataIds,
                        [service_id]: [
                            ...(dataIds[service_id] || []), // add item to service
                            +value
                        ]
                    };
                }
            })
            renderSericeHtml(dataIds)
        }

        function renderSericeHtml(dataIds) {
            let html = '';
            for (const key in dataIds) {
                if (Object.prototype.hasOwnProperty.call(dataIds, key)) {
                    const faciId = dataIds[key];
                    const facilityHtml = faciId.map(f => {
                        return `<li>${facilitiesHotel.find(faci=>faci.id == f)?.name}</li>`
                    }).join('')
                    html += `
                            <div class="col-12 col-md-6">
                                <label for="" >${services.find(s=>s.id == key)?.name} (${faciId.length})</label>
                                <ul>${facilityHtml}</ul>
                            </div>
                        `
                }
            }
            if (html == '') {
                html = '<div class="col-12 text-center py-5">Chưa chọn dịch vụ nào</div>'
            }
            $(listResultEl).html(html)

        }

        function checkParent() {
            $('.service_group').each(function(index, el) { // check service
                if ($(el).find('.input_item:checked').length == $(el).find('.input_item').length) {
                    $(el).find('.input_service').prop('checked', true);
                } else {
                    $(el).find('.input_service').prop('checked', false);
                }
            })
            if ($(list).find('.service_parent .input_service:checked').length == $(list).find(
                    '.service_parent .input_service').length) { //check all
                $(list).find('#check_all').prop('checked', true);
            } else {
                $(list).find('#check_all').prop('checked', false);
            }
        }
        // ======================== end service ================================
    </script>
@endpush
