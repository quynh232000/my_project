@extends('layout.app')
@section('title', 'Update infomation ngân hàng')

@section('main')

    <!-- Content Header (Page header) -->
    <form class="form-horizontal app-container" id="admin-{{ $params['prefix'] }}-form"
        name="admin-{{ $params['prefix'] }}-form" enctype="multipart/form-data" method="POST"
        action="{{ route($params['prefix'] . '.' . $params['controller'] . '.update', ['bank' => $params['item']['id']]) }}">
        <input type="hidden" name="_method" value="PUT">
        <input type="hidden" name="id" value="{{ $params['item']['id'] }}">
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
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="row m-0">
                            <div class="form-group col-6 p-2 mb-0">
                                <label class="col-form-label text-right" for="name">Tên<span
                                        style="color: red">(*)</span></label>
                                <input type="text" class="form-control generate-slug" id="name" name="name"
                                    placeholder="Nhập tên.." value="{{ $params['item']['name'] }}">
                                <div class="input-error"></div>
                            </div>
                            <div class="form-group col-6 p-2 mb-0">
                                <label class="col-form-label text-right" for="short_name">Tên viết tắt<span
                                        style="color: red">(*)</span></label>
                                <input type="text" class="form-control generate-slug" id="short_name" name="short_name"
                                    placeholder="Nhập tên.." value="{{ $params['item']['short_name'] }}">
                                <div class="input-error"></div>
                            </div>
                            <div class="form-group col-6 p-2 mb-0">
                                <label class="col-form-label text-right" for="code">Code<span
                                        style="color: red">(*)</span></label>
                                <input type="text" class="form-control generate-slug" id="code" name="code"
                                    placeholder="Nhập tên.." value="{{ $params['item']['code'] }}">
                                <div class="input-error"></div>
                            </div>


                            <div class="form-group col-6 p-2 mb-0">
                                <label class="col-form-label text-right" for="status">Trạng Thái </label>
                                {!! \App\Models\Hotel\BankModel::slbStatus($params['item']['status']) !!}
                                <div class="input-error"></div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
        </div>


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
                    url: "{{ route($params['prefix'] . '.' . $params['controller'] . '.update', ['bank' => $params['item']['id']]) }}",
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
                            console.log('data.responseJSON.errors', $('#' + x).parents());
                            $('#' + x).parents('.form-group').find('.input-error').html(data
                                .responseJSON.errors[x]);
                            $('#' + x).parents('.form-group').find('.input-error').show();
                            $('#' + x).addClass('is-invalid');
                        }
                    }
                });
            });

            let index = 1;
            const itemClone = $('.template_clone').html()
            $('.template_clone').remove()
            $('.name_add').on('click', function(e) {
                e.preventDefault();
                $(itemClone).find('input').val('');
                $(itemClone).find('input').each(function() {
                    const currentName = $(this).attr('name');
                    const newName = currentName.replace(/\[\d+\]/, `[${index}]`); // <-- fix đúng nè
                    // console.log(newName);
                    $(this).attr('name', newName);
                });
                $('.name_list').prepend(itemClone);
                index++;
            });
            $('.name_body').on('click', '.name_delete', function(e) { //delete faqs
                e.preventDefault();
                if ($('.name_body').find('.name_item').length > 1) {
                    $(this).closest('.name_item')?.remove()
                }
            })
        });
    </script>
@endsection
