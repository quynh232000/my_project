@extends('layout.app')
@section('title', 'Cập nhật thong tin nhà hàng')

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
        name="admin-{{ $params['prefix'] }}-form" enctype="multipart/form-data" method="POST"
        action="{{ route($params['prefix'] . '.' . $params['controller'] . '.update',  $params['item']['id']) }}">
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
                                <label class="col-form-label text-right" for="name">Tên của hàng<span
                                        style="color: red">(*)</span></label>
                                <input type="text" class="form-control generate-slug" id="name" name="name"
                                    placeholder="Nhập tiêu đề" value="{{ $item['name'] ?? '' }}">
                                <div class="input-error"></div>
                            </div>
                            <div class="form-group col-12 col-md-6 p-2 mb-0">
                                <label class="col-form-label text-right" for="type">Chủ cửa hàng<span
                                        style="color: red">(*)</span></label>
                                {!! \App\Models\Cms\RestaurantModel::selectUser($item['owner_id'] ?? '') !!}
                                <div class="input-error"></div>
                            </div>
                            {{-- <div class="form-group col-12 col-md-6 p-2 mb-0">
                                <label class="col-form-label text-right" for="slug">Slug<span
                                        style="color: red">(*)</span></label>
                                <input type="text" class="form-control" id="slug" name="slug"
                                    placeholder="Nhập slug" value="{{ $item['slug'] ?? '' }}">
                                <div class="input-error"></div>
                            </div> --}}
                            <div class="form-group col-6 p-2 mb-0">
                                <label class="col-form-label text-right" for="phone">Số điện thoại</label>
                                <input type="text" class="form-control" id="phone" name="phone"
                                    placeholder="Nhập ..." value="{{ $item['phone'] ?? '' }}">
                                <div class="input-error"></div>
                            </div>
                            <div class="form-group col-6 p-2 mb-0">
                                <label class="col-form-label text-right" for="address">Địa chỉ</label>
                                <input type="text" class="form-control" id="address" name="address"
                                    placeholder="Nhập ..." value="{{ $item['address'] ?? '' }}">
                                <div class="input-error"></div>
                            </div>

                            <div class="form-group col-12 col-md-6 p-2 mb-0">
                                <label class="col-form-label text-right" for="type">Chủ cửa hàng<span
                                        style="color: red">(*)</span></label>
                                {!! \App\Models\Cms\RestaurantModel::selectType($item['type'] ?? '') !!}
                                <div class="input-error"></div>
                            </div>
                            <div class="form-group col-12 col-md-6 p-2 mb-0">
                                <label class="col-form-label text-right" for="state">Trạng thái hoạt động<span
                                        style="color: red">(*)</span></label>
                                {!! \App\Models\Cms\RestaurantModel::selectState($item['state'] ?? '') !!}
                                <div class="input-error"></div>
                            </div>


                            <div class="form-group col-6 p-2 mb-0">
                                <label class="col-form-label text-right" for="time_open">Thời gian mở cửa</label>
                                <input type="text" class="form-control" id="time_open" name="time_open"
                                    placeholder="Nhập ..." value="{{ $item['time_open'] ?? '' }}">
                                <div class="input-error"></div>
                            </div>
                            <div class="form-group col-6 p-2 mb-0">
                                <label class="col-form-label text-right" for="time_close">Thời gian đóng cửa</label>
                                <input type="text" class="form-control" id="time_close" name="time_close"
                                    placeholder="Nhập ..." value="{{ $item['time_close'] ?? '' }}">
                                <div class="input-error"></div>
                            </div>
                            <div   div class="form-group col-6 p-2 mb-0">
                                <label class="col-form-label text-right" for="branch">Chi nhánh</label>
                                <input type="text" class="form-control" id="branch" name="branch"
                                    placeholder="Nhập ..." value="{{ $item['branch'] ?? '' }}">
                                <div class="input-error"></div>
                            </div>
                            <div class="form-group col-6 p-2 mb-0">
                                <label class="col-form-label text-right" for="currentcy">Tiền tệ</label>
                                <input type="text" class="form-control" id="currentcy" name="currentcy"
                                    placeholder="Nhập ..." value="{{ $item['currentcy'] ?? '' }}">
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
                             <div class="form-group col-12 col-md-6 p-2 mb-0">
                                <label class="col-form-label text-right" for="plan_id">Gói dịch vụ</label>
                                {!! \App\Models\Cms\RestaurantModel::selectPlan($item['plan_id'] ?? '') !!}
                                <div class="input-error"></div>
                            </div>
                            <div class="form-group col-12 p-2 mb-0">
                                <label class="col-form-label text-right" for="note">Ghi chú</label>
                                <textarea id="note" name="note" class="form-control" rows="3">{{ $item['note'] ?? '' }}</textarea>
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
                                <label class="col-form-label col-12" for="image">Logo</label>
                                <x-admin.input.upload :name="'logo'" :url="$item['logo'] ?? ''"></x-admin.input.upload>
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
                    url: "{{ route($params['prefix'] . '.' . $params['controller'] . '.update',  $params['item']['id']) }}",
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
