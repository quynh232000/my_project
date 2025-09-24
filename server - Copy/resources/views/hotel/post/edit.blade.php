@extends('layout.app')
@section('title', 'Sửa bài viết')

@section('main')

    <style>
        .image-wrapper img {
            height: 100px;
        }

        .faqs_item {
            padding: 10px;
        }

        .faqs_list>.faqs_item:nth-child(odd) {
            border: 1px dashed rgb(218, 218, 218);
            background-color: #f8f8f8;
        }

        .faqs_list.benefit>.faqs_item {
            border: none;
            background-color: white;
            padding: 0;
        }
    </style>

    <div id="kt_app_content_container" class="app-container ">
        <form class="form-horizontal pb-5" id="admin-{{ $params['prefix'] }}-form" name="admin-{{ $params['prefix'] }}-form"
            enctype="multipart/form-data" method="POST"
            action="{{ route($params['prefix'] . '.' . $params['controller'] . '.update', $params['item']['id']) }}">
            <input type="hidden" name="_method" value="PUT">
            <input type="hidden" name="id" value="{{ $params['item']['id'] }}">
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
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Chi tiết</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="row m-0  pt-2">
                                <div class="form-group col-6 p-2 mb-0">
                                    <label class="col-form-label text-right" for="name">Tiêu đề bài viết<span
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
                            </div>
                            <div class="form-group col-12 p-2 mb-0">
                                <label class="col-form-label text-right" for="content">Nội dung</label>
                                {!! \App\Helpers\Template::InputText($params, 'description', $params['item']['description']) !!}
                                <div class="input-error"></div>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- /.card -->
                <div class="col-md-4 ">
                    <div class="card mb-5">
                        <div class="card-header">
                            <h3 class="card-title">Thông tin chung</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="row m-0  pt-2">
                                <div class="form-group col-12 p-2 mb-0">
                                    <label class="col-form-label col-12" for="image">Hình ảnh</label>
                                    <x-admin.input.upload :name="'image'" :url="$params['item']['image']"></x-admin.input.upload>
                                </div>
                                <div class="form-group col-12 p-2 mb-0">
                                    <label class="col-form-label text-right" for="category_id">Danh mục<span
                                            style="color: red">(*)</span></label>
                                    <select class="form-control" id="category_id" data-control="select2" name="category_id">
                                        <option value="">-- Chọn danh mục --</option>
                                        {!! \App\Models\Hotel\PostCategoryModel::treeSelectCategory($params['item']['category_id']) !!}
                                    </select>
                                    <div class="input-error"></div>
                                </div>

                                <div class="form-group col-12 p-2 mb-0">
                                    <label class="col-form-label text-right" for="airline_id">Tin nổi bật</label>
                                    <div>
                                        <div class="icheck-primary d-inline">
                                            <input value="0" type="radio" id="radioPrimary1" name="featured"
                                                {{ $params['item']['featured'] == 0 ? 'checked' : '' }}>
                                            <label for="radioPrimary1">
                                                Không
                                            </label>
                                        </div>
                                        <div class="icheck-primary d-inline ml-5">
                                            <input value="1" type="radio" id="radioPrimary3" name="featured"
                                                {{ $params['item']['featured'] == 1 ? 'checked' : '' }}>
                                            <label for="radioPrimary3">
                                                Có
                                            </label>
                                        </div>
                                    </div>
                                    <div class="input-error "></div>
                                </div>
                                <div class="form-group col-12 p-2 mb-0">
                                    <label class="col-form-label text-right" for="status">Trạng Thái</label>
                                    {!! \App\Models\Hotel\PostModel::slbStatus($params['item']['status']) !!}
                                    <div class="input-error"></div>
                                </div>
                                <div class="form-group col-12 p-2 mb-0 mt-2">
                                    <label class="col-form-label text-right" for="priority">Thứ tự </label>
                                    <input type="number" min="1" max="9999" class="form-control" id="priority"
                                        value="{{ $params['item']['priority'] }}" name="priority" placeholder="9999">
                                    <div class="input-error"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Thông tin SEO</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <input type="hidden" name="footer_update" id="hidden-footer" value="" disabled>

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
                url: "{{ route($params['prefix'] . '.' . $params['controller'] . '.update', $params['item']['id']) }}",
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
    </script>
@endpush
