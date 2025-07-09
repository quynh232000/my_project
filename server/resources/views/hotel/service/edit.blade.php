@extends('layout.app')
@section('title', 'Update infomation dịch vụ')
@section('main')
    <!-- Content Header (Page header) -->
    <form class="form-horizontal app-container" id="admin-{{ $params['prefix'] }}-form" name="admin-{{ $params['prefix'] }}-form"
        enctype="multipart/form-data" method="POST"
        action="{{ route($params['prefix'] . '.' . $params['controller'] . '.update', ['service' => $params['item']['id']]) }}">
        <input type="hidden" name="_method" value="PUT">
         <input type="hidden" name="id" value="{{ $params['item']['id'] }}">
        <div class="row">
            <div class="col-6 col-sm-12 col-md-8">
                <div class="card">
                     <div class="card-header d-flex justify-content-between align-items-center">
                        Infomation
                        <div class="">
                            @include('include.btn.cancel', [
                                'href' => route($params['prefix'] . '.' . $params['controller'] . '.index'),
                            ])
                            @include('include.btn.save')
                        </div> <h3>Thông tin dịch vụ</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="row m-0  pt-2">
                            <div class="form-group col-6 p-2 mb-0">
                                <label class="col-form-label text-right" for="name">Tên dịch vụ & tiện ích<span
                                        style="color: red">(*)</span></label>
                                <input type="text" class="form-control generate-slug" id="name" name="name"
                                    placeholder="Nhập tên dịch vụ" value="{{isset($params['item']['name']) && !empty($params['item']['name']) ? $params['item']['name'] : ''}}">
                                <div class="input-error"></div>
                            </div>
                            <div class="form-group col-6 p-2 mb-0">
                                <label class="col-form-label text-right" for="slug">Slug<span style="color: red">(*)</span></label>
                                <input type="text" class="form-control" id="slug" name="slug" placeholder="Nhập slug" value="{{isset($params['item']['slug']) && !empty($params['item']['slug']) ? $params['item']['slug'] : ''}}">
                                <div class="input-error"></div>
                            </div>
                            <div class="form-group col-6 p-2 mb-0">
                                <label class="col-form-label text-right" for="price"> Dịch vụ & tiện ích cha</label>
                               <select name="parent_id" id="parent_id"  class="form-control select2 select2-blue"
                               data-dropdown-css-class="select2-blue" style="width: 100%;">
                               <option value="">-- Chọn dịch vụ & tiện ích cha (nếu có) --</option>
                                {!! \App\Models\Hotel\ServiceModel::treeSelectCategory($params['services'],$params['item']['parent_id']) !!}
                               </select>
                                <div class="input-error"></div>
                            </div>
                            <div class="form-group col-6 p-2 mb-0">
                                <label class="col-form-label text-right" for="price"> Loại dịch vụ & tiện ích<span style="color: red">(*)</span></label>
                               <select name="type" id="type"  class="form-control"
                               data-dropdown-css-class="select2-blue" style="width: 100%;">
                                    <option value="">-- Chọn loại dịch vụ & tiện ích --</option>
                                    @foreach ($params['type'] as $key => $type)
                                    <option value="{{$key}}"  {{ $params['item']['type'] == $key ? 'selected' : '' }}>{{$type}}</option>
                                    @endforeach
                               </select>
                                <div class="input-error"></div>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
            <div class="col-6 col-sm-12 col-md-4">
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
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-12 p-2 mb-0">
                                <!-- Label Section -->
                                <div class="row">
                                    <label class="col-form-label col-12" for="image">Hình ảnh</label>
                                </div>
                                <!-- /.card-header -->
                                <div id="dropzone_template" hidden>
                                    <div class=" drop_zone col-12 col-md-3 col-2xl-4 col-xl-3 position-relative p-1 img_item" >
                                        <div class="border">
                                            <span class="mailbox-attachment-icon has-img">
                                                <img style="object-fit:cover" data-dz-thumbnail class="w-100" src="">
                                                <input type="hidden" name="image_id" value="{{ $params['item']['id'] }}">
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
                                    <div class="dropzone border-dashed row mx-1 singleImageDropzone" >
                                        <input type="file" id="image" name="image" hidden>
                                        <div class="dz-default dz-message text-secondary col-12"><i class="fa-regular fa-images mr-2 fa-xl"></i> Tải lên hoặc kéo thả file ảnh ( .jpeg, .png, .jpg, .gif, .webp)</div>
                                    </div>
                                    <div class="input-error"></div>
                                </div>
                            </div>
                            <div class="form-group col-6 p-2 mb-0">
                                <label class="col-form-label text-right" for="status">Trạng Thái </label>
                                {!! \App\Models\Hotel\ServiceModel::slbStatus('inactive',$params) !!}
                                <div class="input-error"></div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>

            </div>
        </div>
        <div class="row">&nbsp;</div>
    </form>
    <script src="{{ url('assets/plugins/admin-lte/plugins/dropzone/min/dropzone.min.js') }}"></script>
    <script src="{{ url('assets/js/admin-image.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#admin-{{ $params['prefix'] }}-form').submit(function(e) {

                $('.input-error').html('');
                $('.form-group row p-0 m-0 mb-2 input').removeClass('is-invalid');
                e.preventDefault();
                var formData = new FormData(this);const formEl = $(this)
                $.ajax({
                    type: 'POST',
                    url: "{{ route($params['prefix'] . '.' . $params['controller'] . '.update', ['service' => $params['item']['id']]) }}",
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

        });
        const imageSingle = @json(!empty($params['item']['image']) && $params['item']['image'] ? [$params['item']] : []);
        initializeImage('.singleImageDropzone', true, imageSingle, 1, "image/*");
    </script>
@endsection
