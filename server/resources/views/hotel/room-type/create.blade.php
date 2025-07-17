@extends('layout.app')
@section('title', 'Thêm mới loại phòng')
@section('main')

    <!-- Content Header (Page header) -->

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
            <div class="col-12 col-md-12 col-sm-12 ">
                <div class="card">
                     <div class="card-header d-flex justify-content-between align-items-center">
                        Infomation
                        <div class="">
                            @include('include.btn.cancel', [
                                'href' => route($params['prefix'] . '.' . $params['controller'] . '.index'),
                            ])
                            @include('include.btn.save')
                        </div> <h3>Thông tin phòng</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="row m-0  pt-2">

                            <div class="form-group col-6 p-2 mb-0">
                                <label class="col-form-label text-right" for="name">Tên <span
                                        style="color: red">(*)</span></label>
                                <input type="text" class="form-control generate-slug" id="name" name="name"
                                    placeholder="Nhập tên.." value="">
                                <div class="input-error"></div>
                            </div>
                            <div class="form-group col-6 p-2 mb-0">
                                <label class="col-form-label text-right" for="slug">Slug<span style="color: red">(*)</span></label>
                                <input type="text" class="form-control" id="slug" name="slug" placeholder="Nhập slug.." value="">
                                <div class="input-error"></div>
                            </div>
                            <div class="form-group col-md-6 p-2 mb-0">
                                <label class="col-form-label text-right" for="status">Trạng Thái </label>
                                {!! \App\Models\Hotel\RoomTypeModel::slbStatus() !!}
                                <div class="input-error"></div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
        </div><!-- /.row -->
        <div class="row">&nbsp;

        </div>
        <div class="card faqs w-100 mx-2">
            <div class="card-header">
                <h3 class="card-title">Tên phòng</h3>
            </div>
            <div class="card-body row m-0  p-2 name_body">
                <div class="form-group col-12 p-2 mb-0 ">
                    <button  class="btn btn-primary name_add float-right">
                        <i class="fa-sharp fa-solid fa-plus"></i>
                        Thêm
                    </button>
                </div>
                <div class="col-12 p-2 mb-0 name_list">
                    <div class="name_item border-bottom pb-1 mb-2">
                        <div class="mb-2 form-group ">
                            <div class="d-flex ">
                                <input type="text" class="form-control" name="room_name[]" placeholder="Tên phòng.."></input>
                                <button class="btn btn-danger btn-sm name_delete ml-2"><i class="fa-regular fa-trash-can"></i></button>
                            </div>
                            <div class="input-error"></div>
                        </div>
                    </div>
                </div>
            </div>
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

            // add room name
            $('.name_add').on('click',function(e){//add faqs
                e.preventDefault();
                const itemClone       = $('.name_body').find('.name_item').first().clone()
                $(itemClone).find('input').val('');

                $('.name_list').prepend(itemClone)
            })
            $('.name_body').on('click','.name_delete',function(e){//delete faqs
                e.preventDefault();
                if($('.name_body').find('.name_item').length >1){
                    $(this).closest('.name_item')?.remove()
                }
            })
        });
    </script>


@endsection
