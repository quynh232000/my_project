@extends('layout.app')
@section('title', 'Update infomation đánh giá')
@section('main')
<style>
    .remove-location {
    position: absolute;
    top: 65%;
    left: 50%;
    transform: translate(-50%, -50%);
}
</style>
    <!-- Content Header (Page header) -->
    <form class="form-horizontal app-container" id="admin-{{ $params['prefix'] }}-form" name="admin-{{ $params['prefix'] }}-form"
        enctype="multipart/form-data" method="POST"
        action="{{ route($params['prefix'] . '.' . $params['controller'] . '.update', ['review' => $params['item']['id']]) }}">
        <input type="hidden" name="_method" value="PUT">
         <input type="hidden" name="id" value="{{ $params['item']['id'] }}">
        <div class="row">
            <div class="col-6 col-sm-12 col-md-7">
                <div class="card">
                     <div class="card-header d-flex justify-content-between align-items-center">
                        Infomation
                        <div class="">
                            @include('include.btn.cancel', [
                                'href' => route($params['prefix'] . '.' . $params['controller'] . '.index'),
                            ])
                            @include('include.btn.save')
                        </div> <h3>Thông tin đánh giá</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="row m-0 pt-2">
                            <div class="form-group col-6 p-2 mb-0">
                                <label class="col-form-label text-right" for="hotel">Khách sạn <span style="color: red">(*)</span></label>
                                <select class="form-control select2 select-bluer" id="hotel_id" name="hotel_id">
                                    <option value="">-- Chọn khách sạn --</option>
                                    @foreach ($params['hotel'] as $hotel)
                                    <option value="{{ $hotel['id'] }}" {{  $hotel['id'] == $params['item']['hotel_id'] ? 'selected' : ''}}>{{ $hotel['name'] }}</option>
                                    @endforeach
                                </select>
                                <div class="input-error"></div>
                            </div>
                            <div class="form-group col-6 p-2 mb-0">
                                <label class="col-form-label text-right" for="type">Loại đánh giá </label>
                                <select class="form-control select2 select-blue" id="type" name="type[]" multiple>
                                    <option value="">-- Chọn loại đánh giá --</option>
                                    @foreach ($params['reviewType'] as $type)
                                        <option value="{{ $type }}"
                                        @if(isset($params['item']['type']) && !is_null($params['item']['type']) && in_array($type, json_decode($params['item']['type'])))
                                            selected
                                        @endif >
                                        {{ $type }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="input-error"></div>
                            </div>

                            <div class="form-group col-6 p-2 mb-0">
                                <label class="col-form-label text-right" for="like">Lượt thích</label>
                                <input type="number" class="form-control" id="like" min="0" name="like"
                                    placeholder="Nhập lượt thích" value="{{isset($params['item']['like']) ? $params['item']['like'] : ''}}">
                                <div class="input-error"></div>
                            </div>
                            <div class="form-group col-6 p-2 mb-0">
                                <label class="col-form-label text-right" for="point">Điểm đánh giá <span style="color: red">(*)</span></label>
                                <input id="point" type="text" name="point" value="" class="irs-hidden-input" tabindex="-1" readonly="" hidden>
                                <div class="input-error"></div>
                            </div>
                            <div class="col-12 p-2 mb-0">
                                <div id="quality-container">
                                    @foreach ($params['item']['qualities'] as $qualities)
                                    <div class="row quality-row">
                                        <div class="form-group col-6 p-2 mb-0">
                                            <label class="col-form-label text-right" for="quality">Tiêu chí</label>
                                            <select class="form-control select2" id="quality_{{ $loop->index }}" name="qualities[{{ $loop->index }}][quality]">
                                                <option value="">-- Chọn tiêu chí --</option>
                                                @foreach ($params['reviewQuality'] as $key => $quality)
                                                <option value="{{ $key }}" {{ $qualities['quality'] == $key && $qualities['quality'] != null ? 'selected' : ''}}>{{ $quality }}</option>
                                                @endforeach
                                            </select>
                                            <div class="input-error"></div>
                                        </div>
                                        <div class="form-group col-5 p-2 mb-0">
                                            <label class="col-form-label text-right" for="quality_point"></label>
                                            <input type="number" class="form-control" id="quality_point_{{ $loop->index }}" name="qualities[{{ $loop->index }}][quality_point]"
                                                placeholder="Nhập điểm đánh giá" >
                                            <div class="input-error quality_point_{{ $loop->index }}"></div>
                                        </div>
                                        <div class="form-group col-1 p-2 mb-0 ">
                                            <label class="col-form-label text-right" for="quality"></label>
                                            <button type="button" class="btn btn-danger remove-location float-right btn-sm" data-index="{{ $loop->index }}" disabled>
                                                <i class="fa-sharp fa-solid fa-trash text-white"></i>
                                            </button>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                <div class="form-group col-12 p-2 mb-0">
                                    <button type="button" class="btn btn-primary float-right add-quality btn-sm">
                                        <i class="fa-sharp fa-solid fa-plus"></i> Thêm
                                    </button>
                                </div>
                            </div>
                            <div class="form-group col-6 p-2 mb-0">
                            <label class="col-form-label text-right" for="time">Thời gian lưu trú</label>
                            <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                <input type="text" class="form-control datetimepicker-input" id="time" name="time" data-target="#reservationdate"
                                value="{{isset($params['item']['time']) ? $params['item']['time'] : ''}}">
                                <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                        </div>
                            <div class="form-group col-12 p-2 mb-0">
                                <label class="col-form-label text-right" for="description">Đánh giá </label>
                                <div class="input-error"></div>
                                    {!! \App\Helpers\CKEditorHelper::render(
                                        [
                                            'input'         => 'review',
                                            'value'         => isset($params['item']['review']) ? $params['item']['review'] : '',
                                            'prefix'        => $params['prefix'],
                                            'controller'    => $params['controller'],
                                            'images'        => (isset($params['id']) && $params['id'] > 0) ? $params['id']: "temp/" . Auth::user()->id,
                                        ],
                                        [
                                            'width'     => '100%',
                                            'height'    => '400px',
                                        ],
                                    ) !!}
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
            </div><!-- /.row -->
            {{-- Seo --}}
            <div class="col-6 col-sm-12 col-md-5">
                <div class="card">
                     <div class="card-header d-flex justify-content-between align-items-center">
                        Infomation
                        <div class="">
                            @include('include.btn.cancel', [
                                'href' => route($params['prefix'] . '.' . $params['controller'] . '.index'),
                            ])
                            @include('include.btn.save')
                        </div> <h3>Hình ảnh & trạng thái</h3>
                    </div>
                    <!-- /.card-header -->
                            <div class="form-group col-12 p-2 mb-0">
                                <!-- Label Section -->
                                <div class="row m-0 pt-2">
                                    <label class="col-form-label col-12" for="image">Hình ảnh</label>
                                </div>
                                <!-- /.card-header -->
                                <div id="dropzone_template" hidden>
                                    <div class=" drop_zone col-12 col-md-3 col-2xl-4 col-xl-3 position-relative p-1 img_item" >
                                        <div class="border">
                                            <span class="mailbox-attachment-icon has-img">
                                                <img style="height: 110px; object-fit:cover" data-dz-thumbnail class="w-100" src="">
                                            </span>
                                            <div class="mailbox-attachment-info d-flex justify-content-between" style="gap: 5px">
                                                <div style="flex:1" class="d-flex justify-content-end ">
                                                    <div data-dz-remove class="text-danger btn btn-default btn-sm float-right">
                                                        <i class="fa-regular fa-trash-can"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <i class="">
                                            <small style="font-size: 12px d-flex justify-content-center align-items-center" class="error text-danger w-100" data-dz-errormessage></small>
                                        </i>
                                    </div>
                                </div>
                                <div class="images-item border-bottom pb-3">
                                    <div class="mt-4">
                                        <div class="dropzone border-dashed row mx-1 multipleImageDropzone" >
                                            <input type="file" name="images[review][]" multiple hidden>
                                            <div class="dz-default dz-message text-secondary col-12"><i class="fa-regular fa-images mr-2 fa-xl"></i> Tải lên hoặc kéo thả file ảnh ( .jpeg, .png, .jpg, .gif, .webp)</div>
                                        </div>
                                    </div>
                                    <div class="input-error"></div>
                                </div>
                            </div>
                            <div class="form-group col-6 p-2 mb-0">
                                <label class="col-form-label text-right" for="status">Trạng Thái </label>
                                {!! \App\Models\Hotel\ReviewModel::slbStatus('inactive',$params) !!}
                                <div class="input-error"></div>
                            </div>
                    <!-- /.card-body -->
                </div>
                <div class="card">
                     <div class="card-header d-flex justify-content-between align-items-center">
                        Infomation
                        <div class="">
                            @include('include.btn.cancel', [
                                'href' => route($params['prefix'] . '.' . $params['controller'] . '.index'),
                            ])
                            @include('include.btn.save')
                        </div> <h3>Thông tin người dùng</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="form-group col-12 p-2 mb-0">
                            <label class="col-form-label text-right " for="name">Tên người dùng <span style="color: red">(*)</span></label>
                            <input type="text" class="form-control generate-slug" id="username" name="username"
                                placeholder="Nhập tên người dùng" value="{{isset($params['item']['username']) ? $params['item']['username'] : ''}}">
                                <input type="text" id="slug" name="slug" hidden>
                            <div class="input-error"></div>
                        </div>
                        <div class="form-group col-12 p-2 mb-0">
                            <div class="row m-0 pt-2">
                                <label class="col-form-label col-12" for="image">Hình ảnh</label>
                            </div>
                            <!-- /.card-header -->
                            <div id="dropzone_template" hidden>
                                <div class=" drop_zone col-12 col-md-3 col-2xl-4 col-xl-3 position-relative p-1 img_item" >
                                    <div class="border">
                                        <span class="mailbox-attachment-icon has-img">
                                            <img style="height: 110px; object-fit:cover" data-dz-thumbnail class="w-100" src="">
                                            <input type="hidden" name="image_name" value="{{ $params['item']['nameImage'] }}">
                                        </span>
                                        <div class="mailbox-attachment-info d-flex justify-content-between" style="gap: 5px">
                                            <div style="flex:1" class="d-flex justify-content-end">
                                                <div data-dz-remove class="text-danger btn btn-default btn-sm float-right">
                                                    <i class="fa-regular fa-trash-can"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <i class="">
                                        <small style="font-size: 12px d-flex justify-content-center align-items-center" class="error text-danger w-100" data-dz-errormessage></small>
                                    </i>
                                </div>
                            </div>
                            <div class="images-item border-bottom pb-3">
                                <div class="mt-4">
                                    <div class="dropzone border-dashed row mx-1 singleImageDropzone" >
                                        <input type="file" id="" name="images[user]" hidden>
                                        <div class="dz-default dz-message text-secondary col-12"><i class="fa-regular fa-images mr-2 fa-xl"></i> Tải lên hoặc kéo thả file ảnh ( .jpeg, .png, .jpg, .gif, .webp)</div>
                                    </div>
                                </div>
                                <div class="input-error"></div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
            <div class="row">&nbsp;</div>
        </div>
    </form>
    <script src="{{ url('assets/plugins/admin-lte/plugins/dropzone/min/dropzone.min.js') }}"></script>
    <script src="{{ url('assets/plugins/ion.rangeSlider/js/ion.rangeSlider.min.js') }}"></script>
    <script src="{{ url('assets/js/admin-image.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#admin-{{ $params['prefix'] }}-form').submit(function(e) {

                $('.input-error').html('');
                $('.form-group input, .select2').removeClass('is-invalid');
                e.preventDefault();
                var formData = new FormData(this);const formEl = $(this)
                formData.append("listImage", JSON.stringify(listImage));
                $.ajax({
                    type: 'POST',
                    url: "{{ route($params['prefix'] . '.' . $params['controller'] . '.update', ['review' => $params['item']['id']]) }}",
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
                            if (x.includes('.')) {
                                let parts       = x.split('.'); // ['fee', '0']
                                let fieldName   = parts[2]; // 'fee'
                                let index       = parts[1]; // '0'
                                let inputField = $(`#${fieldName}_${index}`);
                                if (inputField.length) {
                                    inputField.addClass('is-invalid');
                                    inputField.parents('.form-group').find('.input-error').html(data.responseJSON.errors[x]);
                                    inputField.parents('.form-group').find('.input-error').show();
                                    // $(`.${fieldName}_${index}`).html(data.responseJSON.errors[x]);
                                    // $(`.${fieldName}_${index}`).show();
                                }
                            }
                            $('#' + x).parents('.form-group').find('.input-error').html(data
                                .responseJSON.errors[x]);
                            $('#' + x).parents('.form-group').find('.input-error').show();
                            $('#' + x).addClass('is-invalid');
                        }
                    }
                });
            });
            var title   = $('.generate-slug').val();
            var slug    = generateSlug(title);
            $("#slug").val(slug);
            $('.generate-slug').on('input', function () {
                var title   = $(this).val();
                var slug    = generateSlug(title);
                $("#slug").val(slug);
            });
            $('#reservationdate').datetimepicker({
                format: 'L'
            });
        });
         ///////////dropzone-preimage/////////////
        const imageSingle = @json(isset($params['item']['nameImage']) && $params['item']['nameImage'] ? [$params['item']] : []);
        const imageMultiple = @json($params['item']['images']);
        initializeImage('.singleImageDropzone', true, imageSingle);
        var listImage = initializeImage('.multipleImageDropzone', false, imageMultiple, 10, "image/jpeg,png,jpg,gif,webp");
        //////////dropzone-preimage/////////////
        $("#point").ionRangeSlider({
            min: 0,
            max: 10,
            from: {{isset($params['item']['point']) ? $params['item']['point'] : ''}},
            to: 10,
            type: 'single',
            step: 0.1,
            prefix: "Điểm:",
        });
        @foreach ($params['item']['qualities'] as $quality)
            $('#quality_point_{{$loop->index}}').ionRangeSlider({
                min: 1,
                max: 5,
                from: {{$quality['quality_point']}},
                to: 5,
                type: 'single',
                step: 0.1,
                prefix: "Điểm:",
            });
        @endforeach
        var index   = {{count($params['item']['qualities'])}};
        var quality = $(".quality-row");
        $(".add-quality").on("click", function() {
            $('#quality-container input').each(function() {
                var $p = $(this).parent();
                $(this).data("ionRangeSlider").destroy();
            });
            quality.find('#quality_0').select2('destroy');
            var newQuality = quality.first().clone();
            newQuality.find("input, select").val('');
            newQuality.find("select, input, .input-error").each(function() {
                var nameAttr    = $(this).attr("name");
                var idAttr      = $(this).attr("id");
                var classAttr   = $(this).attr('class');
                if (nameAttr) {
                    $(this).attr("name", nameAttr.replace(/\[\d+\]/, "[" + index + "]"));
                }
                if (idAttr) {
                    $(this).attr("id", idAttr.replace(/\d+$/, index));
                }
                if (classAttr) {
                    $(this).attr('class', classAttr.replace(/\d+$/, index));
                }
                $(this).attr("data-index", index);
            });
            newQuality.find(".remove-location").attr("data-index", index);
            $("#quality-container").append(newQuality);
            newQuality.find('.input-error').html('');
            newQuality.find('select').select2({
                    dropdownCssClass: 'select2-blue'
            });
            quality.find('#quality_0').select2();
            $('#quality-container input').each(function() {
                var $p = $(this).parent();
                $(this).ionRangeSlider({
                    min: 1,
                    max: 5,
                    from: 0,
                    to: 5,
                    type: 'single',
                    step: 0.1,
                    prefix: "Điểm:",
                });
            });
            index++;
            updateRemoveButtons();
        });
        function updateRemoveButtons() {

            var rowCount = $(".quality-row").length;
            if (rowCount === 1) {
                $(".remove-location").attr("disabled", true);
            } else {
                $(".remove-location").attr("disabled", false);
            }
            $('.remove-location').each(function() {
                    $(this).attr('data-index') == 0 ? $(this).attr("disabled", true) : $(this).attr("disabled", false);
                });
            $(".remove-location").off("click").on("click", function() {

                $(this).closest('.quality-row').remove();
                $(this).find()
                var rowCount = $(".quality-row").length;
                if (rowCount === 1) {
                    $(".remove-location").attr("disabled", true);
                } else {
                    $(".remove-location").attr("disabled", false);
                }
                $('.remove-location').each(function() {
                    $(this).attr('data-index') == 0 ? $(this).attr("disabled", true) : $(this).attr("disabled", false);
                });
                index = 0;
                $(".quality-row").each(function() {
                    $(this).find("select, input, button, .input-error").each(function() {
                        var nameAttr    = $(this).attr("name");
                        var idAttr      = $(this).attr("id");
                        var classAttr   = $(this).attr('class');
                        if (nameAttr) {
                            $(this).attr("name", nameAttr.replace(/\[\d+\]/, "[" + index + "]"));
                        }
                        if (idAttr) {
                            $(this).attr("id", idAttr.replace(/\d+$/, index));
                        }
                        if (classAttr) {
                        $(this).attr('class', classAttr.replace(/\d+$/, index));
                    }
                        $(this).attr("data-index", index);
                    });
                    index++;
                });
            });
        }
        updateRemoveButtons();
    </script>
@endsection
