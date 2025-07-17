@extends('layout.app')
@section('title', 'Cập nhật thông tin khách sạn')
@section('main')
    <style>
        .drop_zone .preview img{
            width: 100%;
            height: 100px;
            object-fit: cover;
        }
        .dropzone{
            display: flex;
            flex-wrap: wrap;
            text-align: center
        }
        .dz-default.dz-message{
            width: 100%;
        }
        .drop_zone .preview img {
            width: 100%;
            height: 100px;
            object-fit: cover;
        }
        .dropzone {
            display: flex;
            flex-wrap: wrap;
            text-align: center
        }
        .dz-default.dz-message {
            width: 100%;
        }
        .text-truncate-1 {
            display: -webkit-box;
            -webkit-line-clamp: 1; /* Số dòng muốn hiển thị */
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .custom_scroll{
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
        .img_item button.delete{
            display: none;
            transition: .3s ease all
        }
        .img_item:hover button.delete{
            display: flex;
        }
    </style>

    <form class="form-horizontal app-container" id="admin-{{ $params['prefix'] }}-form" name="admin-{{ $params['prefix'] }}-form"
        enctype="multipart/form-data" method="POST"
        action="{{ route($params['prefix'] . '.' . $params['controller'] . '.update',['hotel' => $params['item']['id']]) }}">
        <input type="hidden" name="_method" value="PUT">
         <input type="hidden" name="id" value="{{ $params['item']['id'] }}">
        <div class="row">

            <div class="col-6 col-md-6 col-sm-12 ">
                <div class="card">
                     <div class="card-header d-flex justify-content-between align-items-center">
                        Infomation
                        <div class="">
                            @include('include.btn.cancel', [
                                'href' => route($params['prefix'] . '.' . $params['controller'] . '.index'),
                            ])
                            @include('include.btn.save')
                        </div> <h3>Thông tin chung</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body p-1">
                        <div class="row m-0  pt-2">
                            <div class="form-group col-6 p-2 mb-0">
                                <label class="col-form-label text-right" for="name">Tên khách sạn<span style="color: red">(*)</span></label>
                                <input type="text" class="form-control generate-slug" id="name" name="name" placeholder="Nhập tiêu đề" value="{{$params['item']['name']}}">
                                <div class="input-error"></div>
                            </div>
                            <div class="form-group col-6 p-2 mb-0">
                                <label class="col-form-label text-right" for="slug">Slug<span style="color: red">(*)</span></label>
                                <input type="text" class="form-control" id="slug" name="slug" placeholder="Nhập slug" value="{{$params['item']['slug']}}">
                                <div class="input-error"></div>
                            </div>

                            <div class="form-group col-6 p-2 mb-0">
                                <label class="col-form-label text-right" for="commission_rate">Phí triết khấu(%)</label>
                                <input type="number" step="0.01" min="0" max="100" class="form-control" id="commission_rate" name="commission_rate"
                                    placeholder="Nhập phí triết khấu" value="{{$params['item']['commission_rate']}}" >
                                <div class="input-error"></div>
                            </div>
                            <div class="form-group col-6 p-2 mb-0">
                                <label class="col-form-label text-right" for="status">Loại hình cư trú <span style="color: red">(*)</span></label>
                                {!! \App\Models\Hotel\HotelModel::selectAccommodation($params['item']['accommodation_id']) !!}
                                <div class="input-error"></div>
                            </div>
                            <div class="form-group col-6 p-2 mb-0">
                                <label class="col-form-label text-right" for="time_checkin">Giờ nhận phòng</label>
                                <input type="time" class="form-control" id="time_checkin" name="time_checkin" placeholder="Nhập.." value="{{$params['item']['time_checkin']}}">
                                <div class="input-error"></div>
                            </div>
                            <div class="form-group col-6 p-2 mb-0">
                                <label class="col-form-label text-right" for="time_checkout">Giờ trả phòng</label>
                                <input type="time" class="form-control" id="time_checkout" name="time_checkout" placeholder="Nhập.." value="{{$params['item']['time_checkout']}}">
                                <div class="input-error"></div>
                            </div>
                            <div class="form-group col-6 p-2 mb-0">
                                <label class="col-form-label text-right" for="construction_year">Năm xây dựng</label>
                                <input type="number"  min="1900" max="2100" value="{{$params['item']['construction_year']}}" id="construction_year" class="form-control"  name="construction_year" placeholder="Chọn năm">
                                <div class="input-error"></div>
                            </div>
                            <div class="form-group col-6 p-2 mb-0 star">
                                <label class="col-form-label text-right" for="commission_rate">Hạng sao</label>
                                <div class="d-flex justify-content-center align-items-center mb-2" style="gap: 5px">
                                    <div class="number_star">({{$params['item']['stars']}})</div>
                                    <div class=" d-flex justify-content-center star_html" style="gap: 5px">
                                        @for ($i = 0; $i < 5; $i++)
                                            @php
                                                $stars = $params['item']['stars'];
                                            @endphp
                                            @if ($i < floor($stars))
                                                <i class="fas fa-star text-warning"></i>
                                            @elseif ($i < ceil($stars))
                                                <i class="fas fa-star-half-stroke text-warning"></i>
                                            @else
                                                <i class="far fa-star text-secondary"></i>
                                            @endif
                                        @endfor
                                    </div>
                                </div>
                                <input type="range" class="custom-range" min="0" max="5" step="0.5" name="stars" value="{{$params['item']['stars']}}" id="customRange1">
                                <div class="input-error"></div>
                            </div>
                            <div class="form-group col-6 p-2 mb-0">
                                <label class="col-form-label text-right" for="floor_count">Số tầng</label>
                                <input type="number" min="0" max="100" class="form-control" id="floor_count" name="floor_count" placeholder="Nhập số.." value="{{$params['item']['floor_count']}}">
                                <div class="input-error"></div>
                            </div>
                            <div class="form-group col-6 p-2 mb-0">
                                <label class="col-form-label text-right" for="floor_count">Số phòng</label>
                                <input type="number" min="1" max="100" class="form-control" id="room_count" name="room_count" placeholder="Nhập số.." value="{{$params['item']['room_count']}}">
                                <div class="input-error"></div>
                            </div>
                            <div class="form-group col-6 p-2 mb-0">
                                <label class="col-form-label text-right" for="bar_count">Số quán bar</label>
                                <input type="number" min="0" max="100"  class="form-control" id="bar_count" name="bar_count" placeholder="Nhập số.." value="{{$params['item']['bar_count']}}">
                                <div class="input-error"></div>
                            </div>
                            <div class="form-group col-6 p-2 mb-0">
                                <label class="col-form-label text-right" for="restaurant_count">Số nhà hàng</label>
                                <input type="number" class="form-control" id="restaurant_count" name="restaurant_count" placeholder="Nhập số.." value="{{$params['item']['restaurant_count']}}">
                                <div class="input-error"></div>
                            </div>
                            <div class="form-group col-6 p-2 mb-0">
                                <label class="col-form-label text-right" for="language">Ngôn ngữ hỗ trợ</label>
                                <input type="text" class="form-control" id="language" name="language" placeholder="Nhập slug" value="{{$params['item']['language']}}">
                                <div class="input-error"></div>
                            </div>
                            <div class="form-group col-6 p-2 mb-0">
                                <label class="col-form-label text-right" for="category_id">Danh mục</label>
                                @php
                                    $categories = collect($params['item']['categories'] ?? [])->map(function($item)  {
                                        return $item['id'];
                                    });
                                @endphp
                                {!! \App\Models\Hotel\HotelModel::selectCategory($categories ?? []) !!}
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
                                <label class="col-form-label text-right" for="description">Mô tả</label>
                                <p style="color: red; font-size: 14px">Vui lòng không sao chép nội dung từ trang web khác
                                    và không chỉnh sửa định dạng hình ảnh! </p>
                                {!! \App\Helpers\CKEditor::getInstance('description', [
                                    'type' => 'Advance',
                                    'width' => '100%',
                                    'height' => '300px',
                                    'prefix' => $params['prefix'],
                                    'controller' => $params['controller'],
                                ], $params['item']['description']) !!}
                                <div class="input-error"></div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body p-1 -->
                </div>
            </div>
            <div class="col-6 col-md-6 col-sm-12">
                @include('hotel.hotel.album.edit')
                @include('hotel.hotel.address.edit')
                @include('hotel.hotel.customer.edit')
            </div>
        </div>

        {{-- start nearby locaton --}}
        @include('hotel.hotel.nearby-location.edit')
        {{-- end nearby locaton --}}

        {{-- dich vu tien ich --}}
        <div class="border-top " style="display: none">
            <div class="d-flex justify-between align-items-center" style="justify-content: space-between">
                <h4 class="py-2">Tiện ích và dịch vụ</h4>
            </div>
            <div class="card">
                <div class="card-body row p-2">
                    <div class="col-12 col-md-4 border-right service_parent custom_scroll"  id="list_check">
                        <h5 class="border-bottom pb-2">Chọn tiện ích</h5>
                        <div class="form-check border-bottom py-2">
                            <input class="form-check-input" data-type='check-list-all' type="checkbox" id="check_all">
                            <label class="form-check-label fw-bold" for="check_all">
                                Chọn tất cả tiện ích
                            </label>
                        </div>
                        @foreach ($params['info']['services'] as $parent)
                            <div class="px-3 py-2 border-bottom service_parent service_group" data-service-id="{{ $parent['id'] }}">
                                <div class="form-check">
                                    <input class="form-check-input input_service" data-type="check-list" type="checkbox" id="service_parent_{{ $parent['id'] }}">
                                    <label class="form-check-label fw-bold" for="service_parent_{{ $parent['id'] }}">
                                        {{ $parent['name'] }} ({{count($parent['children']) ?? 0}})
                                    </label>
                                </div>
                                <div class="p-2 px-4">
                                    @foreach ($parent['children'] ?? [] as $child)
                                        <div class="form-check">
                                            <input name="facility[{{$parent['id'].'_'.$child['id']}}]" {{in_array($child['id'],array_column($params['item']['facilities'],'service_id'))?'checked':''}}  data-type="check-item" value="{{ $child['id'] }}" class="form-check-input input_item" id="service_child_{{ $child['id'] }}" type="checkbox">
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
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- start faqs --}}
        {{-- @include('hotel.hotel.faqs.edit') --}}
        {{-- end faqs --}}

        </div>
    </form>


    <script>
        $('#admin-{{ $params['prefix'] }}-form').on('keydown','input', function(e) {
            if (e.key === "Enter") {
                e.preventDefault(); // Ngăn chặn submit khi nhấn Enter
            }
        });
        // form submit
        $('#admin-{{ $params['prefix'] }}-form').submit(function(e) {
            e.preventDefault();

            $('.input-error').html('');
            $('input, textarea').removeClass('is-invalid');
            const formData = new FormData(this);
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
                success: (data) => {
                    if (data.success) {

                        setTimeout(() => {
                            if ($('#save-and-edit').is(':focus')) {
                                if (data.id) {
                                    window.location.href = "{{ route($params['prefix'] . '.' . $params['controller'] . '.edit', ':id') }}".replace(':id', data.id);
                                }
                            }else{
                                window.location.reload()
                            }
                        }, 1500);
                    } else {
                        toastr.error(data.message);
                    }

                },
                error: function(data) {

                    for (x in data.responseJSON.errors) {
                        showInvalid( x, data.responseJSON.errors[x])
                    }
                }
            });
        });
        function showInvalid(key, mess) {
            let inputName = key.replace(/\./g, '][').replace(/^/, '[').replace(/$/, ']');
            console.log(inputName);

            const x = key.split('.')
            let element = '#' + x[0]
            if(x.length >= 3){
                element = $(`input[name="${x[0]}[${x[1]}][${x[2]}]${x[2]=='images'?'[]':''}"]`)
                if(x[2]=='images' && x.length==4 ){
                    element = $(`input[name^="${x[0]}[${x[1]}][${x[2]}]"]`)
                    $(element).parents('.form-group').find('.input-error')
                              .append(`<li>Hình số ${+x[3]+1} ${mess}</li>`);
                }else{
                    $(element).parents('.form-group').find('.input-error').html(mess);
                }
            }else{
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
    <script>
        $(document).ready(function() {
            $('#image').on('change', function(event) {
                var file = event.target.files[0];
                if (file) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $('#image_preview').html(createImg(e.target.result,1,true))
                    }
                    reader.readAsDataURL(file);
                }
            });
        })

        // ======================== start service ================================
        const facilitiesHotel   = @json($params['data']['facilitiesHotel']);
        const services          = @json($params['data']['services']);
        const inputEl           = '#list_check input';
        const listResultEl      = '#list-service-select';
        const list              = '#list_check'

        $(inputEl).on('change',function(){//change input
            const dataType = $(this).attr('data-type')
            if(dataType && dataType.includes('check-list')){
                $(this).closest('.service_parent').find('input').prop('checked',$(this).prop('checked'))
                if(!$(this).prop('checked') && dataType !=='check-list-all'){
                    $('#check_all').prop('checked',false)
                }
            }
            checkParent()//check parent input
            renderSelectService()
        })
        checkParent()//check parent input
        renderSelectService()
        function renderSelectService(){
            let dataIds = {}
            $(inputEl).each(function(input){
                if($(this).attr('data-type') =='check-item' && $(this).prop('checked')){
                    const service_id = $(this).closest('.service_parent').attr('data-service-id')
                    const value      = $(this).val()
                    dataIds          = {
                                            ...dataIds,
                                            [service_id]: [
                                                ...(dataIds[service_id] || []),// add item to service
                                                +value
                                            ]
                                        };
                }
            })
            renderSericeHtml(dataIds)
        }
        function renderSericeHtml(dataIds){
            let html = '';
            for (const key in dataIds) {
                if (Object.prototype.hasOwnProperty.call(dataIds, key)) {
                    const faciId       = dataIds[key];
                    const facilityHtml = faciId.map(f=>{
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
            if(html == ''){
                html = '<div class="col-12 text-center py-5">Chưa chọn dịch vụ nào</div>'
            }
            $(listResultEl).html(html)

        }
        function checkParent() {
            $('.service_group').each(function(index, el){// check service
                if ($(el).find('.input_item:checked').length == $(el).find('.input_item').length) {
                    $(el).find('.input_service').prop('checked', true);
                }else{
                    $(el).find('.input_service').prop('checked', false);
                }
            })
            if ($(list).find('.service_parent .input_service:checked').length == $(list).find('.service_parent .input_service').length) {//check all
                $(list).find('#check_all').prop('checked', true);
            }else{
                $(list).find('#check_all').prop('checked', false);
            }
        }
        checkParent()
        // ======================== end service ================================
        // star hotel
        $('#customRange1').change(function(){
            const stars        = $(this).val()
            let starHtml       = "";
            for (let i = 0; i < 5; i++) {
                if (i < Math.floor(stars)) {
                    starHtml += '<i class="fas fa-star text-warning"></i>'; // Sao đầy
                } else if (i < Math.ceil(stars)) {
                    starHtml += '<i class="fas fa-star-half-stroke text-warning"></i>'; // Sao nửa
                } else {
                    starHtml += '<i class="far fa-star text-secondary"></i>'; // Sao rỗng
                }
            }
            $('.star_html').html(starHtml)
            $('.number_star').html(`(${stars}${stars%1 >0 ?'':'.0'})`)
        })
        // star hotel

    </script>

@endsection
