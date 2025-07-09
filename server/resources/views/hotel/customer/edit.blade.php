@extends('layout.app')
@section('title', 'Cập nhật thông tin tài khoản')

@push('css')
    <!-- CSS -->
@endpush
@section('main')

    <style>
        /* ============ */
        .hotel_select select {
            max-height: 500px;
            overflow-y: scroll
        }

        .hotel_select select::-webkit-scrollbar {
            width: 12px;
        }

        .hotel_select select::-webkit-scrollbar-track {
            box-shadow: inset 0 0 6px rgba(54, 55, 55, 0.3);
        }

        .hotel_select select::-webkit-scrollbar-thumb {
            background-color: rgb(0, 36, 153);
            outline: 1px solid rgb(225, 225, 226);
        }

        .hotel_select .info {
            font-size: 16px;
            color: gray
        }

        .hotel_select .form-control.filter {
            padding: 8px 16px;
        }

        .hotel_select select {
            max-height: 320px;
            min-height: 320px;
        }

        .hotel_select select option {
            padding: 5px 10px;
        }

        .hotel_select .btn-group.buttons button:hover {
            background-color: rgb(23, 162, 184);
            color: white
        }
    </style>
    <!-- Content Header (Page header) -->
    <form class="form-horizontal app-container" id="admin-{{ $params['prefix'] }}-form"
        name="admin-{{ $params['prefix'] }}-form" enctype="multipart/form-data" method="POST"
        action="{{ route($params['prefix'] . '.' . $params['controller'] . '.update', ['customer' => $params['item']['id']]) }}">
        <input type="hidden" name="_method" value="PUT">
        <input type="hidden" name="id" value="{{ $params['item']['id'] }}">
        <div class="pb-5 d-flex justify-content-end" style="gap: 10px">
            @include('include.btn.cancel', [
                'href' => route($params['prefix'] . '.' . $params['controller'] . '.index'),
            ])
            @include('include.btn.save')
        </div>
        <div class="row">
            <div class="col-12 col-md-6 col-sm-12 ">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        Infomation

                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="row m-0">
                            <div class="form-group col-6 p-2 mb-0">
                                <label class="col-form-label text-right" for="register_id">Đối tác đăng ký</label>
                                {!! \App\Models\Hotel\CustomerModel::selectPartner($params['item']['register_id'], true) !!}
                                <div class="input-error"></div>
                            </div>
                            <div class="form-group col-6 p-2 mb-0">
                                <label class="col-form-label text-right" for="full_name">Họ tên<span
                                        style="color: red">(*)</span></label>
                                <input type="text" class="form-control " id="full_name" name="full_name"
                                    placeholder="Nhập..." value="{{ $params['item']['full_name'] }}">
                                <div class="input-error"></div>
                            </div>
                            <div class="form-group col-6 p-2 mb-0">
                                <label class="col-form-label text-right" for="email">Email<span
                                        style="color: red">(*)</span></label>
                                <input type="text" class="form-control " id="email" name="email"
                                    placeholder="Nhập..." value="{{ $params['item']['email'] }}">
                                <div class="input-error"></div>
                            </div>
                            <div class="form-group col-6 p-2 mb-0">
                                <label class="col-form-label text-right" for="username">Username<span
                                        style="color: red">(*)</span></label>
                                <input type="text" class="form-control " id="username" name="username"
                                    placeholder="Nhập..." value="{{ $params['item']['username'] }}">
                                <div class="input-error"></div>
                            </div>
                            <div class="form-group col-6 p-2 mb-0">
                                <label class="col-form-label text-right" for="phone">Số điện thoại<span
                                        style="color: red">(*)</span></label>
                                <input type="text" class="form-control " id="phone" name="phone"
                                    placeholder="Nhập..." value="{{ $params['item']['phone'] }}">
                                <div class="input-error"></div>
                            </div>
                            <div class="form-group col-6 p-2 mb-0">
                                <label class="col-form-label text-right" for="password">Mật khẩu</label>
                                <input type="text" class="form-control " id="password" name="password"
                                    placeholder="Nhập..." value="">
                                <div class="input-error"></div>
                            </div>
                            <div class="form-group col-6 p-2 mb-0">
                                <label class="col-form-label col-12" for="image"> Hình ảnh</label>
                                @if ($params['item']['image'])
                                    <div class=" image-preview-container d-flex flex-wrap">
                                        <div class="image-wrapper position-relative mr-2 mb-2">
                                            <img id="previewImage"
                                                src="{{ $params['item']['image'] . '?time=' . time() ?? '' }}"
                                                alt="No image" class="preview-image img-thumbnail" style="width: 130px;">
                                        </div>
                                    </div>
                                @else
                                    <div class=" image-preview-container d-flex flex-wrap">
                                        <div class="image-wrapper position-relative mr-2 mb-2">
                                            <img id="previewImage" src="" alt="No image"
                                                class="preview-image d-none img-thumbnail" style="width: 130px;">
                                        </div>
                                    </div>
                                @endif
                                <div class="custom-file">
                                    <input type="file" name="image" id="image"
                                        class="custom-file-input image-input" accept="image/*">
                                    <label class="custom-file-label" for="image">Chọn file</label>
                                </div>
                                <div class="input-error"></div>
                            </div>
                            <div class="form-group col-6 p-2 mb-0">
                                <label class="col-form-label text-right" for="status">Trạng thái</label>
                                {!! \App\Models\Hotel\CustomerModel::slbStatus($params['item']['status']) !!}
                                <div class="input-error"></div>
                            </div>

                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
            <div class="col-md-6">

                <div class="col-12 col-sm-12 ">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Thêm quản lý khách sạn</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="form-group p-2 mb-0">
                                <label class="col-form-label text-right" for="full_name">Vai trò</label>
                                {!! \App\Models\Hotel\CustomerModel::selectRole('manager') !!}
                            </div>

                            <div class="form-group  hotel_select px-2">
                                <label class="col-form-label text-right" for="full_name">Thêm khách sạn</label>
                                <select class="form-select mb-2" name="hotels_select[]" data-control="select2"
                                    data-placeholder="Select an option" data-allow-clear="true" multiple="multiple">
                                    <option></option>
                                    @foreach ($params['item']['hotels_select'] as $hotel)
                                        <option value="{{ $hotel['id'] }}">{{ $hotel['name'] }}</option>
                                    @endforeach
                                </select>

                            </div>
                            <i>
                                <small class="text-danger">(Click để chọn khách sạn)</small>
                            </i>

                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>

                <div class="col-12 col-sm-12 ">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Danh sách khách sạn đang quản lý</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr class="text-sm">
                                        <th style="width: 10px">ID</th>
                                        <th>Khách sạn</th>
                                        {{-- <th>Email</th> --}}
                                        <th>Trạng thái</th>
                                        <th style="width: 160px">Vai trò</th>
                                        <th>Hành động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($params['item']['hotels'] as $hotel)
                                        <tr>
                                            <td>
                                                {{ $hotel['id'] }}
                                                <input type="text" hidden name="hotel_customer_ids[]"
                                                    value="{{ $hotel['pivot']['id'] }}">
                                            </td>
                                            <td>

                                                <a href="{{ route('hotel.hotel.edit', ['hotel' => $hotel['id']]) }}">
                                                    {{ $hotel['name'] }}
                                                </a>
                                            </td>
                                            <td>
                                                <div class="text-center align-middle p-1">
                                                    <div style="cursor:pointer" class="btn-status"
                                                        data-status="{{ $hotel['pivot']['status'] }}">
                                                        <input type="text"
                                                            name="hotel_customer[{{ $hotel['id'] }}][status]"
                                                            value="{{ $hotel['pivot']['status'] }}" hidden>
                                                        @if ($hotel['pivot']['status'] == 'active')
                                                            <i class="fa-solid fa-circle-check fa-lg text-success"></i>
                                                        @else
                                                            <i class="fa-sharp fa-solid fa-ban fa-lg text-danger"></i>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                {!! \App\Models\Hotel\HotelModel::selectRole(
                                                    $hotel['pivot']['role'],
                                                    'hotel_customer[' . $hotel['id'] . '][role]',
                                                ) !!}
                                            <td class="text-center align-middle p-1">
                                                <div class="btn-delete-role" style="cursor:pointer">
                                                    <i class="fa-solid fa-trash-can text-danger" title="Xóa"></i>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center text-danger">Không tìm thấy dữ liệu nào!
                                            </td>
                                        </tr>
                                    @endforelse


                                </tbody>
                            </table>

                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
            </div>
        </div>
    </form>
    <script
        src="{{ url('assets/plugins/admin-lte/plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js?t=' . now()) }}">
    </script>
    <script>
        $(document).ready(function() {
            $('#admin-{{ $params['prefix'] }}-form').submit(function(e) {

                $('.input-error').html('');
                $('.form-group row p-0 m-0 mb-2 input').removeClass('is-invalid');
                e.preventDefault();
                var formData = new FormData(this);
                const formEl = $(this)
                $.ajax({
                    type: 'POST',
                    url: "{{ route($params['prefix'] . '.' . $params['controller'] . '.update', ['customer' => $params['item']['id']]) }}",
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

            // selecte parnter register
            $('#register_id').change(function() {
                const selectedElement = $(this).find('option:selected')
                const dataFill = ['full_name', 'email', 'username', 'phone'];
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

            // update lít customer hotel
            $('.btn-delete-role').click(function() {
                $(this).closest('tr').remove()
            })
            $('.btn-status').click(function() {
                const status = $(this).data('status')
                $(this).find('input').val(status == 'active' ? 'inactive' : 'active')

                $(this).find('i').attr('class', status == 'active' ?
                    'fa-sharp fa-solid fa-ban fa-lg text-danger' :
                    'fa-solid fa-circle-check fa-lg text-success')
                $(this).data('status', status == 'active' ? 'inactive' : 'active')
            })



        });
    </script>

@endsection
