@extends('layout.app')
@section('title', 'Thêm mới tài khoản')
@section('main')

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
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        Infomation

                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="row m-0">
                            <div class="form-group col-6 p-2 mb-0">
                                <label class="col-form-label text-right" for="register_id">Đối tác đăng ký</label>
                                {!! \App\Models\Hotel\CustomerModel::selectPartner() !!}
                                <div class="input-error"></div>
                            </div>
                            <div class="form-group col-6 p-2 mb-0">
                                <label class="col-form-label text-right" for="full_name">Họ tên<span
                                        style="color: red">(*)</span></label>
                                <input type="text" class="form-control " id="full_name" name="full_name"
                                    placeholder="Nhập tên.." value="">
                                <div class="input-error"></div>
                            </div>
                            <div class="form-group col-6 p-2 mb-0">
                                <label class="col-form-label text-right" for="email">Email<span
                                        style="color: red">(*)</span></label>
                                <input type="text" class="form-control " id="email" name="email"
                                    placeholder="Nhập tên.." value="">
                                <div class="input-error"></div>
                            </div>
                            <div class="form-group col-6 p-2 mb-0">
                                <label class="col-form-label text-right" for="username">Username<span
                                        style="color: red">(*)</span></label>
                                <input type="text" class="form-control " id="username" name="username"
                                    placeholder="Nhập tên.." value="">
                                <div class="input-error"></div>
                            </div>
                            <div class="form-group col-6 p-2 mb-0">
                                <label class="col-form-label text-right" for="phone">Số điện thoại<span
                                        style="color: red">(*)</span></label>
                                <input type="text" class="form-control " id="phone" name="phone"
                                    placeholder="Nhập tên.." value="">
                                <div class="input-error"></div>
                            </div>
                            <div class="form-group col-6 p-2 mb-0">
                                <label class="col-form-label text-right" for="password">Mật khẩu<span
                                        style="color: red">(*)</span></label>
                                <input type="text" class="form-control " id="password" name="password"
                                    placeholder="Nhập tên.." value="">
                                <div class="input-error"></div>
                            </div>
                            <div class="form-group col-6 p-2 mb-0">
                                <label class="col-form-label text-right" for="image">Hình ảnh</label>
                                <x-admin.input.upload :name="'image'"></x-admin.input.upload>
                                <div class="input-error"></div>

                            </div>
                            <div class="form-group col-6 p-2 mb-0">
                                <label class="col-form-label text-right" for="partner_id">Trạng thái</label>
                                {!! \App\Models\Hotel\CustomerModel::slbStatus('active') !!}
                                <div class="input-error"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- <div class="col-12 col-md-6 col-sm-12 ">
                <div class="card">
                     <div class="card-header d-flex justify-content-between align-items-center">
                        Infomation
                        <div class="">
                            @include('include.btn.cancel', [
                                'href' => route($params['prefix'] . '.' . $params['controller'] . '.index'),
                            ])
                            @include('include.btn.save')
                        </div> <h3>Thông tin khách sạn</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="row m-0">
                            <div class="form-group col-12 p-2 mb-0">
                                <label class="col-form-label text-right" for="title">Tên khách sạn<span  style="color: red">(*)</span></label>
                                <input type="text" class="form-control " id="title" name="title" placeholder="Nhập tên.." value="">
                                <div class="input-error"></div>
                            </div>
                            <div class="form-group col-12 p-2 mb-0">
                                <label class="col-form-label text-right" for="address">Địa chỉ</label>
                                <input type="text" class="form-control " id="address" name="address" placeholder="Nhập tên.." value="">
                                <div class="input-error"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}
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

            // selecte parnter register
            $('#register_id').change(function() {
                const selectedElement = $(this).find('option:selected')
                const dataFill = ['full_name', 'email', 'username', 'phone', 'title', 'address'];
                dataFill.forEach(function(item) {
                    const value = $(selectedElement).data(item)
                    $('#' + item).val(value);
                });
                $('#password').val(generatePassword())
            })
            // random password
            function generatePassword(length = 12) {
                const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789!@#$%^&*()_+[]{}<>?';
                let password = '';
                const array = new Uint32Array(length);
                crypto.getRandomValues(array);
                for (let i = 0; i < length; i++) {
                    password += chars[array[i] % chars.length];
                }
                return password;
            }

        });
    </script>


@endsection
