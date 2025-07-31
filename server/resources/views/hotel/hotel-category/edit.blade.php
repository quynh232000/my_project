@extends('layout.app')
@section('title', 'Sửa danh mục')
@section('main')
    <style>
        .image-wrapper {
            height: 120px;
        }

        .image-wrapper img {
            height: 100%;
            object-fit: cover;
        }
    </style>
    <div id="kt_app_content_container" class="app-container ">
        <form class="form-horizontal" id="admin-{{ $params['prefix'] }}-form" name="admin-{{ $params['prefix'] }}-form"
            enctype="multipart/form-data" method="POST" action="">
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

            <div class="row">
                <div class="col-md-7">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Thông tin danh mục</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="row m-0  pt-2">
                                <div class="form-group col-6 p-2 mb-0">
                                    <label class="col-form-label text-right" for="name">Tiêu đề danh mục<span
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
                                    <label class="col-form-label text-right" for="image">Danh mục cha</label>
                                    <select class="form-control" id="parent_id" name="parent_id">
                                        <option value="">-- Chọn category cha (nếu có) --</option>
                                        {!! \App\Models\Hotel\HotelCategoryModel::treeSelectCategory($params['item']['parent_id'] ?? '') !!}
                                    </select>
                                    <div class="input-error"></div>
                                </div>
                                <div class="form-group col-md-6 p-2 mb-0">
                                    <label class="col-form-label text-right" for="type">Mặc định <i
                                            class="fa-regular fa-circle-info"
                                            title="Danh mục mặc định theo địa chỉ"></i></label>
                                    <div class="pt-2">
                                        <div class="icheck-primary d-inline ml-2 mt-2">
                                            <input type="checkbox" value="1"
                                                {{ $params['item']['is_default'] == 1 ? 'checked' : '' }} name="is_default"
                                                id="is_default">
                                            <label for="is_default"></label>
                                        </div>
                                    </div>
                                    <div class="input-error"></div>
                                </div>
                                <div class="form-group col-md-6 p-2 mb-0">
                                    <label class="col-form-label text-right" for="type">Vị trí</label>
                                    {!! \App\Models\Hotel\HotelCategoryModel::selectPosition($params['item']['position'] ?? null) !!}
                                    <div class="input-error"></div>
                                </div>

                                <div class="form-group col-6 p-2 mb-0">
                                    <label class="col-form-label text-right" for="priority">Thứ tự</label>
                                    <input type="text" class="form-control" id="priority" name="priority"
                                        placeholder="9999" value="{{ $params['item']['priority'] }}">
                                    <div class="input-error"></div>
                                </div>
                                <div class="form-group col-6 p-2 mb-0">
                                    <label class="col-form-label text-right" for="status">Trạng Thái </label>
                                    {!! \App\Models\Hotel\HotelCategoryModel::slbStatus($params['item']['status']) !!}
                                    <div class="input-error"></div>
                                </div>
                            </div>
                            <div class="form-group col-12 p-2 mb-0">
                                <label class="col-form-label text-right" for="description">Mô tả</label>
                                <div class="input-error"></div>
                                {!! \App\Helpers\Template::InputText($params, 'description', $params['item']['description'] ?? '') !!}


                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
                <div class="col-md-5">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Hình ảnh</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="row m-0  pt-2">
                                <div class="form-group col-12 p-2 mb-0">
                                    <label class="col-form-label col-12" for="image">Hình ảnh</label>
                                    <x-admin.input.upload :name="'image'" :url="$params['item']['image']"></x-admin.input.upload>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Loại danh mục</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">

                            <div class="row m-0  pt-2">
                                <div class="form-group col-md-12 p-2 mb-0">
                                    <label class="col-form-label text-right" for="type_location">Loại địa điểm Index <span
                                            style="color: red">(*)</span></label>
                                    {!! \App\Models\Hotel\HotelCategoryModel::selectTypeLocation($params['item']['type_location'] ?? '', false) !!}
                                    <div class="input-error"></div>
                                </div>


                                <div class="col-12 row">
                                    {!! \App\Helpers\Template::address(
                                        [
                                            'country_id' => $params['item']['country_id'] ?? '245',
                                            'province_id' => $params['item']['province_id'] ?? '',
                                            'ward_id' => $params['item']['ward_id'] ?? '',
                                        ],
                                        [
                                            'class_label' => '',
                                            'class_group' => 'col-12 col-lg-6 form-group p-2 mb-0',
                                        ],
                                    ) !!}
                                </div>
                                <div class="col-12">
                                    <hr>
                                </div>
                                <div class="form-group col-md-12 p-2 mb-0">
                                    <label class="col-form-label text-right" for="type">Loại danh mục<span
                                            style="color: red">(*)</span></label>
                                    {!! \App\Models\Hotel\HotelCategoryModel::selectType($params['item']['type'] ?? 'location', false) !!}
                                    <div class="input-error"></div>
                                </div>

                                <div class="form-group col-md-12 p-2 mb-0 field-accommodation">
                                    <label class="col-form-label text-right" for="accommodation_id">Loại hình lưu
                                        trú</label>
                                    {!! \App\Models\Hotel\HotelCategoryModel::selectAccommodation($params['item']['accommodation_id'] ?? '') !!}
                                    <div class="input-error"></div>
                                </div>
                                <div class="form-group col-md-12 p-2 mb-0 field-facility">
                                    <label class="col-form-label text-right" for="facility_id">Khác<span
                                            style="color: red">(*)</span></label>
                                    {!! \App\Models\Hotel\HotelCategoryModel::selectOther($params['item']['facility_id'] ?? '') !!}
                                    <div class="input-error"></div>
                                </div>
                                <div class="form-group col-12  p-2 mb-0 field-address-detail">
                                    <label for="address">Địa chỉ chi tiết <span style="color: red">(*)</span></label>
                                    <input type="text" class="form-control"
                                        value="{{ $params['item']['address'] ?? '' }}" id="address" name="address"
                                        placeholder="42 Phan Bội Châu..">
                                    <div class="input-error"></div>
                                </div>
                                <div class=" col-12  p-2 mb-0 parent_location field-location">
                                    <div class="row ">
                                        <div class="form-group col-12 col-lg-6  p-2 mb-0">
                                            <label class="col-form-label text-right" for="lon">Kinh độ <span
                                                    style="color: red">(*)</span></label>
                                            <input type="text" class="form-control longitude" id="lon"
                                                name="lon" placeholder="Nhập.."
                                                value="{{ $params['item']['lon'] ?? '' }}">
                                            <div class="input-error"></div>
                                        </div>
                                        <div class="form-group col-12 col-lg-6  p-2 mb-0">
                                            <label class="col-form-label text-right" for="lat">Vĩ độ <span
                                                    style="color: red">(*)</span></label>
                                            <input type="text" class="form-control latitude" id="lat"
                                                name="lat" placeholder="Nhập.."
                                                value="{{ $params['item']['lat'] ?? '' }}">
                                            <div class="input-error"></div>
                                        </div>
                                    </div>
                                    <div class="form-group col-12 col-lg-12  p-2 mb-0">
                                        <label class="col-form-label text-right" for="location_radius">Bán kính (km)<span
                                                style="color: red">(*)</span></label>
                                        <input type="number" class="form-control" id="location_radius"
                                            name="location_radius" placeholder="Nhập.."
                                            value="{{ $params['item']['location_radius'] ?? '' }}">
                                        <div class="input-error"></div>
                                    </div>
                                    <div class="location_link pt-2 form-group">
                                        <label class="col-form-label text-right" for="type">Hoặc link Google
                                            map</label>
                                        <input type="text" class="form-control input_location_link" id="location_link"
                                            placeholder="Nhập link Google map địa chỉ..">
                                        <div class="input-error"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Thông tin SEO</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="row m-0  pt-2">
                                <div class="form-group col-6 p-2 mb-0">
                                    <label class="col-form-label text-right" for="meta_title">Meta title</label>
                                    <input type="text" class="form-control" id="meta_title" name="meta_title"
                                        placeholder="Nhập tiêu đề" value="{{ $params['item']['meta_title'] }}">
                                    <div class="input-error"></div>
                                </div>
                                <div class="form-group col-6 p-2 mb-0">
                                    <label class="col-form-label text-right" for="meta_keyword">Meta keyword</label>
                                    <input type="text" class="form-control" name="meta_keyword"
                                        value="{{ $params['item']['meta_keyword'] }}"
                                        placeholder="Nhập meta keyword"></input>
                                    <div class="input-error"></div>
                                </div>
                                <div class="form-group col-12 p-2 mb-0">
                                    <label class="col-form-label text-right" for="meta_description">Meta
                                        description</label>
                                    <textarea class="form-control" name="meta_description" id="meta_description" placeholder="Nhập meta description">{{ $params['item']['meta_description'] }}</textarea>
                                    <div class="input-error"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- /.row -->
            </div>
            <div class="row">&nbsp;</div><!-- /.row -->

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
                url: "{{ route($params['prefix'] . '.' . $params['controller'] . '.update', $params['item']['id']) }}",
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

        // select category type start=======
        function toggleFields(type) {
            // Ẩn hết các nhóm
            $('.field-address-group').hide();
            $('.field-address-detail').hide();
            $('.field-location').hide();
            $('.field-accommodation').hide();
            $('.field-facility').hide();

            switch (type) {
                case 'country':
                case 'city':
                case 'district':
                case 'ward':
                    $('.field-address-group').show(); // hiển thị selector địa giới hành chính
                    break;

                case 'location_radius':
                    $('.field-address-group').show(); // địa phương (city/district)
                    $('.field-address-detail').show(); // địa chỉ chi tiết
                    $('.field-location').show(); // tọa độ lat/lon
                    break;

                case 'landmark':
                    $('.field-address-group').show(); // địa phương nếu gắn
                    $('.field-address-detail').show();
                    $('.field-location').show(); // tọa độ địa điểm cụ thể
                    break;

                case 'road':
                    $('.field-address-group').show(); // city / district liên quan
                    $('.field-address-detail').show(); // tên đường cụ thể
                    break;

                case 'area':
                    $('.field-address-group').show(); // city_id (nếu gắn), optional
                    $('.field-address-detail').show(); // mô tả khu vực
                    $('.field-location').show(); // optional: toạ độ trung tâm khu vực
                    break;

                case 'transport_hub':
                    $('.field-address-group').show(); // TP / quận nếu có
                    $('.field-address-detail').show();
                    $('.field-location').show(); // sân bay, ga tàu...
                    break;

                case 'admin_region':
                    $('.field-address-group').show(); // tổng hợp, có thể có city/district
                    $('.field-address-detail').show();
                    break;

                case 'accommodation':
                    $('.field-accommodation').show(); // hiển thị dropdown chọn loại hình lưu trú
                    break;

                case 'custom_group':
                    $('.field-address-group').show(); // kết hợp tuỳ ý
                    $('.field-address-detail').show();
                    $('.field-location').show();
                    $('.field-accommodation').show(); // có thể kèm accommodation
                    break;
                case 'facility':
                    $('.field-address-group').show(); // kết hợp tuỳ ý
                    // $('.field-address-detail').show();
                    // $('.field-location').show();
                    $('.field-facility').show(); // có thể kèm accommodation
                    break;

                default:
                    break;
            }
        }

        // Khi vừa load trang
        const currentType = $('select[name="type"]').val();

        toggleFields(currentType);

        // Khi thay đổi category_type
        $('select[name="type"]').on('change', function() {

            var selected = $(this).val();
            toggleFields(selected);
        });
        // select category type end=======
        $(document).on('change', '.input_location_link',
            function() { //show latitude and longitude from input link google map
                const parent = $(this).closest('.parent_location')

                const error = $(this).parents('.form-group').find('.input-error')
                error.text('')
                error.html('');
                error.hide();
                $(this).removeClass('is-invalid');
                const url = $(this).val()

                if (!url) return false

                const regex = /@(-?\d+\.\d+),(-?\d+\.\d+)/;
                const matches = url.match(regex);
                if (matches) {
                    const latitude = parseFloat(matches[1]);
                    const longitude = parseFloat(matches[2]);
                    $(parent).find('input[name="lat"]').val(latitude)
                    $(parent).find('input[name="lon"]').val(longitude)
                } else {
                    $(parent).find('input[name="lat"]').val('')
                    $(parent).find('input[name="lon"]').val('')
                    error.html('Link không đúng định dạng');
                    error.show();
                    $(this).addClass('is-invalid');
                }
                console.log(123, url);
                // add name location
                const nameLocation = extractPlaceNameFromUrl(url)
                if (nameLocation) {
                    $(parent).find('input.name')?.val(nameLocation)
                }

            })

        function extractPlaceNameFromUrl(url) {
            const pattern = /\/place\/([^\/?]+)/;
            const match = url.match(pattern);
            if (match) {
                const placeName = decodeURIComponent(match[1]);
                return placeName.replace(/\+/g, ' ');
            }
            return false;
        }
    </script>
@endpush
