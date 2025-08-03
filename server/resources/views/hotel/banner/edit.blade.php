@extends('layout.app')
@section('title', 'Update infomation chuỗi khách sạn')

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
    @php
        $item = $params['item'];
    @endphp
    <!-- Content Header (Page header) -->
    <form class="form-horizontal app-container" id="admin-{{ $params['prefix'] }}-form"
        name="admin-{{ $params['prefix'] }}-form" enctype="multipart/form-data" method="POST">
        <input type="hidden" name="_method" value="PUT">
        <input type="hidden" name="id" value="{{ $params['item']['id'] }}">
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
                                <label class="col-form-label text-right" for="title">Tên<span
                                        style="color: red">(*)</span></label>
                                <input type="text" class="form-control generate-slug" id="title" name="title"
                                    placeholder="Nhập tiêu đề" value="{{ $item['title'] ?? '' }}">
                                <div class="input-error"></div>
                            </div>
                            <div class="form-group col-12 col-md-6 p-2 mb-0">
                                <label class="col-form-label text-right" for="slug">Slug<span
                                        style="color: red">(*)</span></label>
                                <input type="text" class="form-control" id="slug" name="slug"
                                    placeholder="Nhập slug" value="{{ $item['slug'] ?? '' }}">
                                <div class="input-error"></div>
                            </div>

                            <div class="form-group col-12 col-md-6 p-2 mb-0">
                                <label class="col-form-label text-right" for="status">Loại<span
                                        style="color: red">(*)</span></label>
                                <select name="type" class="form-control" data-control="select2" id="">
                                    <option value="__blank" selected>Blank</option>
                                </select>
                                <div class="input-error"></div>
                            </div>
                            <div class="form-group col-6 p-2 mb-0">
                                <label class="col-form-label text-right" for="priority">Thứ tự</label>
                                <input type="number" class="form-control" id="priority" name="priority"
                                    placeholder="Thứ tự" value="{{ $item['priority'] ?? '' }}">
                                <div class="input-error"></div>
                            </div>
                            <div class="form-group col-12 col-md-6 p-2 mb-0">
                                <label class="col-form-label text-right" for="status">Trạng Thái</label>
                                {!! \App\Models\Hotel\ChainModel::slbStatus($item['status'] ?? '') !!}
                                <div class="input-error"></div>
                            </div>
                            <div class="form-group col-12 p-2 mb-0">
                                <label class="col-form-label text-right" for="description">Mô tả</label>
                                <textarea id="description" name="description" class="form-control" rows="3">{{ $item['description'] ?? '' }}</textarea>
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
                                <div class="row">
                                    <label class="col-form-label col-12" for="image">Hình ảnh</label>
                                </div>
                                <x-admin.input.upload :name="'image'" :url="$item['image'] ?? ''"></x-admin.input.upload>

                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>

        </div><!-- /.row -->
        <div class="row">&nbsp;</div>
    </form>
    <script>
        $(document).ready(function() {
            $('#admin-{{ $params['prefix'] }}-form').submit(function(e) {

                $('.input-error').html('');
                $('.form-group row p-0 m-0 mb-2 input').removeClass('is-invalid');
                e.preventDefault();
                $(this).find(`button[type='submit']`).prop('disabled', true);
                var formData = new FormData(this);
                const formEl = $(this)
                $.ajax({
                    type: 'POST',
                    url: "{{ route($params['prefix'] . '.' . $params['controller'] . '.update', $params['item']['id']) }}",
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
                    }
                });
            });

        });
    </script>
@endsection
