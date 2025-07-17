@extends('layout.app')
@section('title', 'Thêm mới chuỗi thương hiệu')
@section('main')
    <style>
        .is-invalid~.select2 .select2-selection {
            border: 1px solid red;
        }

        .image-wrapper {
            height: 120px;
        }

        .image-wrapper img {
            height: 100%;
            object-fit: cover;
        }
    </style>
    <!-- Content Header (Page header) -->

    <form class="form-horizontal app-container" id="admin-{{ $params['prefix'] }}-form"
        name="admin-{{ $params['prefix'] }}-form" enctype="multipart/form-data" method="POST"
        action="{{ route($params['prefix'] . '.' . $params['controller'] . '.store') }}">
        <input type="hidden" name="_method" value="POST">
        <div class="pb-5 d-flex justify-content-end" style="gap: 10px">
            @include('include.btn.cancel', [
                'href' => route($params['prefix'] . '.' . $params['controller'] . '.index'),
            ])
            @include('include.btn.save')
        </div>
        <div class="row">
            <div class="col-md-7">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        Infomation
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="row m-0 pt-2">
                            <div class="form-group col-12 col-md-6 p-2 mb-0">
                                <label class="col-form-label text-right" for="name">Tên chuỗi<span
                                        style="color: red">(*)</span></label>
                                <input type="text" class="form-control generate-slug" id="name" name="name"
                                    placeholder="Nhập tiêu đề" value="">
                                <div class="input-error"></div>
                            </div>
                            <div class="form-group col-12 col-md-6 p-2 mb-0">
                                <label class="col-form-label text-right" for="slug">Slug<span
                                        style="color: red">(*)</span></label>
                                <input type="text" class="form-control" id="slug" name="slug"
                                    placeholder="Nhập slug" value="">
                                <div class="input-error"></div>
                            </div>
                            <div class="form-group col-6 p-2 mb-0">
                                <label class="col-form-label text-right" for="head_office">Trụ sở chính</label>
                                <input type="text" class="form-control" id="head_office" name="head_office"
                                    placeholder="Nhập trụ sở chính" value="">
                                <div class="input-error"></div>
                            </div>
                            <div class="form-group col-12 col-md-6 p-2 mb-0">
                                <label class="col-form-label text-right" for="status">Loại<span
                                        style="color: red">(*)</span></label>
                                {!! \App\Models\Hotel\ChainModel::slbType() !!}
                                <div class="input-error"></div>
                            </div>
                            <div class="form-group col-6 p-2 mb-0">
                                <label class="col-form-label text-right" for="priority">Thứ tự</label>
                                <input type="number" class="form-control" id="priority" name="priority"
                                    placeholder="Thứ tự" value="">
                                <div class="input-error"></div>
                            </div>
                            <div class="form-group col-12 col-md-6 p-2 mb-0">
                                <label class="col-form-label text-right" for="status">Trạng Thái</label>
                                {!! \App\Models\Hotel\ChainModel::slbStatus('active') !!}
                                <div class="input-error"></div>
                            </div>
                            <div class="form-group col-12 p-2 mb-0">
                                <label class="col-form-label text-right" for="description">Mô tả</label>
                                <textarea id="description" name="description" class="form-control" rows="3"></textarea>
                                <div class="input-error"></div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
            <div class="col-md-5">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        Infomation

                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="row m-0 pt-2">
                            <div class="form-group col-12 p-2 mb-0">
                                <label class="col-form-label text-right" for="price">Giá chỉ từ/ Đêm <span
                                        style="color: red">(*)</span></label>
                                <input type="text" class="form-control number_format" id="price" name="price"
                                    placeholder="Giá" value="">
                                <div class="input-error"></div>
                            </div>

                            <div class="form-group col-12 p-2 mb-0">
                                <label class="col-form-label col-12" for="image">Logo</label>
                                <x-admin.input.upload :name="'logo'"></x-admin.input.upload>
                            </div>

                            <div class="form-group col-12 p-2 mb-0">
                                <div class="row">
                                    <label class="col-form-label col-12" for="image">Thumbnail</label>
                                </div>
                                <x-admin.input.upload :name="'image'"></x-admin.input.upload>

                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>

        </div><!-- /.row -->
        <div class="row">&nbsp;

        </div>
    </form>
    <script>
        $(document).ready(function() {
            $('#admin-{{ $params['prefix'] }}-form').submit(function(e) {
                e.preventDefault();
                $('.input-error').html('');
                const formEl = $(this)
                $(this).find('.indicator-label').hide()
                $(this).find('.indicator-progress').show()
                $(this).find(`button[type='submit']`).prop('disabled', true);
                var formData = new FormData(this);
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
                    success: (res) => {
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
                            }))

                    },
                    error: function(data) {
                        for (x in data.responseJSON.errors) {
                            $('#' + x).parents('.form-group').find('.input-error').html(data
                                .responseJSON.errors[x]);
                            $('#' + x).parents('.form-group').find('.input-error').show();
                            $('#' + x).addClass('is-invalid');
                        }

                        $(formEl).find('.indicator-label').show()
                        $(formEl).find('.indicator-progress').hide()
                        $(formEl).find(`button[type='submit']`).prop('disabled', false);
                        let errorMs = '<ul class="text-right text-start text-danger mt-3">';
                        for (x in data.responseJSON.errors) {
                            errorMs += `<li><i class="">${data.responseJSON.errors[x]}</i></li>`
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

        });
    </script>
@endsection
