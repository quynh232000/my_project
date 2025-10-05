@extends('layout.app')
@section('title', 'Thêm mới ' . $params['controller'])
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
                <div class="col-6 col-md-8 col-sm-12 ">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Chi tiết</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="row m-0  pt-2">
                                <div class="form-group col-6 p-2 mb-0">
                                    <label class="col-form-label text-right" for="position">Vị trí</label>
                                    <input type="text" class="form-control " id="position" name="position"
                                        placeholder="Nhập.." value="">
                                    <div class="input-error"></div>
                                </div>
                                <div class="form-group col-6 p-2 mb-0">
                                    <label class="col-form-label text-right" for="company">Công ty</label>
                                    <input type="text" class="form-control " id="company" name="company"
                                        placeholder="Nhập.." value="">
                                    <div class="input-error"></div>
                                </div>
                                <div class="form-group col-6 p-2 mb-0">
                                    <label class="col-form-label text-right" for="address">Địa chỉ</label>
                                    <input type="text" class="form-control " id="address" name="address"
                                        placeholder="Nhập.." value="">
                                    <div class="input-error"></div>
                                </div>
                                <div class="form-group col-md-6 p-2 mb-0">
                                    <label class="col-form-label text-right" for="category_id">Trạng thái <span
                                            style="color: red">(*)</span>
                                    </label>

                                    {!! \App\Models\Portfolio\JobModel::stateSelect('new') !!}
                                    <div class="input-error "></div>
                                </div>

                                <div class="form-group col-12 p-2 mb-0">
                                    <label class="col-form-label text-right" for="content">Cover</label>

                                    {!! \App\Helpers\Template::InputText($params, 'description') !!}
                                    <div class="input-error"></div>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
                {{-- Seo --}}
                <div class="col-6 col-md-4 col-sm-12">
                    <div class="card mb-5">
                        <div class="card-header">
                            <h3 class="card-title">Thông tin chung</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="row m-0  pt-2">
                                <div class="form-group col-12 p-2 mb-0">
                                    <label class="col-form-label col-12" for="cv_link">CV</label>
                                    <x-admin.input.upload :name="'cv_link'" :accept="'*'"></x-admin.input.upload>
                                </div>
                                <div class="form-group col-12 p-2 mb-0">
                                    <label class="col-form-label text-right" for="cv_canvas">Cv Canvas Link</label>
                                    <input type="text" class="form-control" id="cv_canvas" name="cv_canvas"
                                        placeholder="Nhập.." value="{{$params['item']['cv_canvas'] ?? ''}}">
                                    <div class="input-error"></div>
                                </div>
                                <div class="form-group col-12 p-2 mb-0">
                                    <label class="col-form-label text-right" for="job_link">Job Link</label>
                                    <input type="text" class="form-control" id="job_link" name="job_link"
                                        placeholder="Nhập.." value="{{$params['item']['job_link'] ?? ''}}">
                                    <div class="input-error"></div>
                                </div>

                                <div class="form-group col-12 p-2 mb-0">
                                    <label class="col-form-label text-right" for="status">Trạng thái </label>
                                    {!! \App\Models\Hotel\PostModel::slbStatus($params['item']['status'] ?? '') !!}
                                    <div class="input-error"></div>
                                </div>


                            </div>
                        </div>

                    </div>
                </div>
            </div><!-- /.row -->
            <div class="row">&nbsp;
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
    </script>
@endpush
