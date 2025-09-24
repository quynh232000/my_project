@extends('layout.app')
@section('title', 'Update infomation')

@section('main')
<style>
    .is-invalid ~ .select2 .select2-selection {
        border: 1px solid red;
    }
</style>
    <!-- Content Header (Page header) -->
    <form class="form-horizontal app-container" id="admin-{{ $params['prefix'] }}-form" name="admin-{{ $params['prefix'] }}-form"
        enctype="multipart/form-data" method="POST"
        action="{{ route($params['prefix'] . '.' . $params['controller'] . '.update', ['priority' => $params['item']['id']]) }}">
        <input type="hidden" name="_method" value="PUT">
         <input type="hidden" name="id" value="{{ $params['item']['id'] }}">
       <div class="row">
            <div class="col-md-6">
                <div class="card">
                     <div class="card-header d-flex justify-content-between align-items-center">
                        Infomation
                        <div class="">
                            @include('include.btn.cancel', [
                                'href' => route($params['prefix'] . '.' . $params['controller'] . '.index'),
                            ])
                            @include('include.btn.save')
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="row m-0 ">
                            <div class="form-group col-md-12 p-2 mb-0">
                                <label class="col-form-label text-right" for="hotel_id">Khách sạn<span  style="color: red">(*)</span></label>
                                {!! \App\Models\Hotel\PriorityModel::selectData($params['item']['hotel_id'] ?? '','hotel_id') !!}
                                <div class="input-error"></div>
                            </div>
                            <div class="form-group col-md-6 p-2 mb-0">
                                <label class="col-form-label text-right" for="priority">Thứ tự<span style="color: red">(*)</span></label>
                                <input type="number" class="form-control generate-slug" id="priority" name="priority" placeholder="Nhập.." value="{{$params['item']['priority'] ?? ''}}">
                                <div class="input-error"></div>
                            </div>

                            <div class="form-group col-md-6 p-2 mb-0">
                                <label class="col-form-label text-right" for="">Trạng Thái </label>
                                {!! \App\Models\Hotel\PriorityModel::slbStatus($params['item']['status'] ?? 'active') !!}
                                <div class="input-error"></div>
                            </div>
                            <div class="form-group col-md-12 p-2 mb-0">
                                <label class="col-form-label text-right" for="note">Ghi chú</label>
                                <textarea id="note" name="note"  class="form-control" rows="3" >{{$params['item']['note'] ?? ''}}</textarea>
                                <div class="input-error"></div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                     <div class="card-header d-flex justify-content-between align-items-center">
                        Infomation
                        <div class="">
                            @include('include.btn.cancel', [
                                'href' => route($params['prefix'] . '.' . $params['controller'] . '.index'),
                            ])
                            @include('include.btn.save')
                        </div> <h3>Lựa chọn</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="row m-0 ">
                            <div class="form-group col-md-12 p-2 mb-0">
                                <label class="col-form-label text-right" for="category_id">Danh mục</label>
                                {!! \App\Models\Hotel\PriorityModel::selectData($params['item']['category_id'] ?? '','category_id') !!}
                                <div class="input-error"></div>
                            </div>

                            <div class="form-group col-md-12 p-2 mb-0">
                                <label class="col-form-label text-right" for="">Địa chỉ</label>
                                <input type="text" class="form-control generate-slug" id="address" name="address" placeholder="Nhập.." value="{{$params['item']['address'] ?? ''}}">
                                <div class="input-error"></div>
                            </div>

                            <div class="col-1 row">
                                <div class="col-12 d-flex align-items-center" style="padding-top: 30px;">
                                    <div class="icheck-primary  d-inline ">
                                        <input type="checkbox" value="1" {{$params['item']['is_country'] ? 'checked' : ''}}  name="is_country" id="is_country">
                                        <label for="is_country"></label>
                                    </div>
                                </div>
                                <div class="col-12 d-flex align-items-center" style="padding-top: 30px;">
                                    <div class="icheck-primary  d-inline ">
                                        <input type="checkbox" value="1" {{$params['item']['is_city'] ? 'checked' : ''}}  name="is_city" id="is_city">
                                        <label for="is_city"></label>
                                    </div>
                                </div>
                                <div class="col-12 d-flex align-items-center" style="padding-top: 30px;">
                                    <div class="icheck-primary  d-inline ">
                                        <input type="checkbox" value="1" {{$params['item']['is_district'] ? 'checked' : ''}}  name="is_district" id="is_district">
                                        <label for="is_district"></label>
                                    </div>
                                </div>
                                <div class="col-12 d-flex align-items-center" style="padding-top: 30px;">
                                    <div class="icheck-primary  d-inline ">
                                        <input type="checkbox" value="1" {{$params['item']['is_ward'] ? 'checked' : ''}}  name="is_ward" id="is_ward">
                                        <label for="is_ward"></label>
                                    </div>
                                </div>

                            </div>
                            <div class="col-11 row pl-5">
                                 {!! \App\Helpers\Template::address([
                                    'country_id'    => $params['item']['country_id'] ?? '',
                                    'city_id'       => $params['item']['city_id'] ?? '',
                                    'district_id'   => $params['item']['district_id'] ?? '',
                                    'ward_id'       => $params['item']['ward_id'] ?? ''
                                ],[
                                    'class_group' => 'form-group col-md-12 p-2 mb-0'
                                ]) !!}
                            </div>

                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>

        </div>
        <div class="row">&nbsp;</div>
    </form>
    <script>
        $(document).ready(function() {
            $('#admin-{{ $params['prefix'] }}-form').submit(function(e) {

                $('.input-error').html('');
                $('.form-group row p-0 m-0 mb-2 input').removeClass('is-invalid');
                e.preventDefault();
                var formData = new FormData(this);const formEl = $(this)
                $.ajax({
                    type: 'POST',
                    url: "{{ route($params['prefix'] . '.' . $params['controller'] . '.update', ['priority' => $params['item']['id']]) }}",
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

            // select type
            $('#type').on('change', function() {
                window.location.href = '?type=' + $(this).val();
            });

        });
    </script>
@endsection
