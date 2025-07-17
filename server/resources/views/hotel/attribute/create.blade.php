@extends('layout.app')
@section('title', 'Update infomation chung')
@section('main')


    <!-- Content Header (Page header) -->

    <form class="form-horizontal app-container" id="admin-{{ $params['prefix'] }}-form"
        name="admin-{{ $params['prefix'] }}-form" enctype="multipart/form-data" method="POST"
        action="{{ route($params['prefix'] . '.' . $params['controller'] . '.store') }}">
        <input type="hidden" name="_method" value="POST">

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        Infomation
                        <div>
                            @include('include.btn.cancel', [
                                'href' => route($params['prefix'] . '.' . $params['controller'] . '.index'),
                            ])
                            @include('include.btn.save')
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="row m-0  pt-2">
                            <div class="form-group col-6 p-2 mb-0">
                                <label class="col-form-label text-right" for="name">Tên <span
                                        style="color: red">(*)</span></label>
                                <input type="text" class="form-control generate-slug" id="name" name="name"
                                    placeholder="Nhập tên danh mục" value="">
                                <div class="input-error"></div>
                            </div>
                            <div class="form-group col-6 p-2 mb-0">
                                <label class="col-form-label text-right" for="name_en">Tên En </label>
                                <input type="text" class="form-control " id="name_en" name="name_en"
                                    placeholder="Nhập tên danh mục" value="">
                                <div class="input-error"></div>
                            </div>
                            <div class="form-group col-6 p-2 mb-0">
                                <label class="col-form-label text-right" for="slug">Slug <span
                                        style="color: red">(*)</span></label>
                                <input type="text" class="form-control" id="slug" name="slug"
                                    placeholder="Nhập slug" value="">
                                <div class="input-error"></div>
                            </div>
                            <div class="form-group col-6 p-2 mb-0">
                                <label class="col-form-label text-right" for="image">Danh mục cha</label>
                                <select class=" form-select" data-control="select2" id="parent_id" name="parent_id">
                                    <option value="">-- Chọn category cha (nếu có) --</option>
                                    {!! \App\Models\Hotel\AttributeModel::treeSelectCategory($parentCategories, '') !!}
                                </select>
                                <div class="input-error"></div>
                            </div>
                            <div class="form-group col-6 p-2 mb-0">
                                <label class="col-form-label text-right" for="status">Trạng Thái </label>
                                {!! \App\Models\Hotel\AttributeModel::slbStatus('inactive') !!}
                                <div class="input-error"></div>
                            </div>

                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
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
    {{-- https://yaireo.github.io/tagify/ --}}
@endsection
