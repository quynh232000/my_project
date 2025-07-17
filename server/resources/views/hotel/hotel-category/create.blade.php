@extends('layout.app')
@section('title', 'Thêm mới danh mục')
@section('main')
    <style>
        .image-wrapper{
            height: 120px;
        }
        .image-wrapper img{
            height: 100%;
            object-fit: cover;
        }
    </style>
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
            <div class="col-6 col-sm-12 col-md-7">
                <div class="card">
                     <div class="card-header d-flex justify-content-between align-items-center">
                        Infomation
                        <div class="">
                            @include('include.btn.cancel', [
                                'href' => route($params['prefix'] . '.' . $params['controller'] . '.index'),
                            ])
                            @include('include.btn.save')
                        </div> <h3>Thông tin danh mục</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="row m-0  pt-2">
                            <div class="form-group col-6 p-2 mb-0">
                                <label class="col-form-label text-right" for="name">Tên danh mục <span style="color: red">(*)</span></label>
                                <input type="text" class="form-control generate-slug" id="name" name="name"
                                    placeholder="Nhập tên danh mục" value="">
                                <div class="input-error"></div>
                            </div>
                            <div class="form-group col-6 p-2 mb-0">
                                <label class="col-form-label text-right" for="slug">Slug <span style="color: red">(*)</span></label>
                                <input type="text" class="form-control" id="slug" name="slug"
                                    placeholder="Nhập slug" value="">
                                <div class="input-error"></div>
                            </div>
                            <div class="form-group col-6 p-2 mb-0">
                                <label class="col-form-label text-right" for="image">Danh mục cha</label>
                                <select class="form-control select2" id="parent_id" name="parent_id">
                                    <option value="">-- Danh mục cha --</option>
                                    {!! \App\Models\Hotel\HotelCategoryModel::treeSelectCategory('','') !!}
                                </select>
                                <div class="input-error"></div>
                            </div>
                            <div class="form-group col-md-6 p-2 mb-0">
                                <label class="col-form-label text-right" for="type">Loại</label>
                                {!! \App\Models\Hotel\HotelCategoryModel::selectType() !!}
                                <div class="input-error"></div>
                            </div>

                            <div class="form-group col-6 p-2 mb-0">
                                <label class="col-form-label text-right" for="priority">Thứ tự</label>
                                <input type="text" class="form-control" id="priority" name="priority" placeholder="9999" value="">
                                <div class="input-error"></div>
                            </div>
                            <div class="form-group col-6 p-2 mb-0">
                                <label class="col-form-label text-right" for="status">Trạng Thái </label>
                                {!! \App\Models\Hotel\HotelCategoryModel::slbStatus('inactive') !!}
                                <div class="input-error"></div>
                            </div>

                        <div class="form-group col-12 p-2 mb-0">
                            <label class="col-form-label text-right" for="description">Mô tả</label>
                            <div class="input-error"></div>
                                {!! \App\Helpers\CKEditorHelper::render(
                                    [
                                        'input'         => 'description',
                                        'value'         => isset($params['item']['description']) ? $params['item']['description'] : '',
                                        'prefix'        => $params['prefix'],
                                        'controller'    => $params['controller'],
                                        'images'        => (isset($params['id']) && $params['id'] > 0) ? $params['id']: "temp/" . Auth::user()->id,
                                    ],
                                    [
                                        'width'     => '100%',
                                        'height'    => '200px',
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
                        </div> <h3>Hình ảnh</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="row m-0  pt-2">
                            <div class="form-group col-12 p-2 mb-0">
                                <div class="row">
                                    <label class="col-form-label col-12" for="image">Hình ảnh</label>
                                </div>
                                <div class="row">
                                    <div class="col-12 image-preview-container d-flex flex-wrap">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="custom-file">
                                            <input type="file" name="image" accept="image/*" class="custom-file-input image-input" >
                                            <label class="custom-file-label">Chọn file</label>
                                        </div>
                                        <div class="input-error"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
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
                        </div> <h3>Thông tin SEO</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="row m-0  pt-2">
                            <div class="form-group col-6 p-2 mb-0">
                                <label class="col-form-label text-right" for="meta_title">Meta title</label>
                                <input type="text" class="form-control" id="meta_title" name="meta_title"
                                    placeholder="Nhập meta title" value="">
                                <div class="input-error"></div>
                            </div>
                            <div class="form-group col-6 p-2 mb-0">
                               <label class="col-form-label text-right" for="meta_keyword">Meta keyword</label>
                               <input type="text" class="form-control" id="meta_keyword" name="meta_keyword"
                                   placeholder="Nhập meta keyword"></input>
                               <div class="input-error"></div>
                           </div>
                            <div class="form-group col-12 p-2 mb-0">
                                <label class="col-form-label text-right" for="meta_description">Meta description</label>
                                <textarea class="form-control" name="meta_description" id="meta_description" placeholder="Nhập meta description"></textarea>
                                <div class="input-error"></div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
            <div class="row">&nbsp;

            </div>
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
                            $('#' + x).parents('.form-group').find('.input-error').html(data
                                .responseJSON.errors[x]);
                            $('#' + x).parents('.form-group').find('.input-error').show();
                            $('#' + x).addClass('is-invalid');
                        }
                    }
                });
            });

        });
        ///////////dropzone-preimage/////////////
        initializeImage('.singleImageDropzone', true, [], 1, "image/*");
        //////////dropzone-preimage/////////////
    </script>
@endsection
