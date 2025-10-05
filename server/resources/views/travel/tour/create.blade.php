@extends('layout.app')
@section('title', 'Add Tour')
@section('main')
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet" />
    <div id="kt_app_content_container" class="app-container ">

        <div class="card card-flush">
            <!--begin::Modal content-->
            <div class="modal-content">
                <!--begin::Modal header-->
                <div class="modal-header px-5 pt-5">
                    <!--begin::Modal title-->
                    <h2 class="fw-bold">Add Infomation</h2>
                    <!--end::Modal title-->
                    <!--begin::Close-->
                    <a href="{{ route($params['prefix'] . '.' . $params['controller'] . '.index') }}" class="btn  btn-danger">
                        Back
                    </a>
                    <!--end::Close-->
                </div>

                <div class=" mx-lg-5 my-7">
                    <!--begin::Form-->
                    <form class="form-horizontal app-container" id="admin-{{ $params['prefix'] }}-form"
                        name="admin-{{ $params['prefix'] }}-form" enctype="multipart/form-data" method="POST"
                        action="{{ route($params['prefix'] . '.' . $params['controller'] . '.store') }}">
                        <input type="hidden" name="_method" value="POST">
                        @csrf
                        <!--begin::Scroll-->

                        <div class="row">
                            <div class="col-md-7 ">
                                <div>
                                    <div class="mb-2">
                                        <label for="title" class="form-label">Tiêu đề</label>
                                        <input type="text" value="{{ old('title') }}" class="form-control"
                                            id="title" name="title">
                                    </div>


                                    <div class="form-group col-12 p-2 mb-0">
                                        <label class="col-form-label col-12" for="image">Thumbnail</label>
                                        <x-admin.input.upload :name="'image'"></x-admin.input.upload>
                                    </div>

                                    <div class="mb-2">
                                        <label for="images" class="form-label">Images (max4)</label>
                                        <input type="file" multiple class="form-control" id="images" name="images[]">
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-2">
                                                <label for="title" class="form-label">Type</label>
                                                <select name="type" class="form-control" id="">
                                                    <option value="">--Select--</option>
                                                    <option value="inside" selected>Trong nước</option>
                                                    <option value="ouside">Nước ngoài</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-2">
                                                <label for="title" class="form-label">Category</label>
                                                <select name="category" class="form-control" id="">
                                                    <option value="">--Select--</option>
                                                    <option value="tour" selected>Tour du lịch</option>
                                                    <option value="hotel">Khách sạn</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="mb-2">
                                                <label for="price" class="form-label">Giá</label>
                                                <input type="number" value="{{ old('price') }}" class="form-control"
                                                    id="price" name="price">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-2">
                                                <label for="price_child" class="form-label">Giá trẻ em</label>
                                                <input type="number" value="{{ old('price_child') }}" class="form-control"
                                                    id="price_child" name="price_child">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-2">
                                                <label for="price_baby" class="form-label">Giá baby</label>
                                                <input type="number" value="{{ old('price_baby') }}" class="form-control"
                                                    id="price_baby" name="price_baby">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-2">
                                                <label for="percent_sale" class="form-label">Giảm giá (%)</label>
                                                <input type="number" class="form-control" value="0" id="percent_sale"
                                                    name="percent_sale">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-2">
                                                <label for="additional_fee" class="form-label">Phí phụ thu</label>
                                                <input type="number" class="form-control" value="0"
                                                    id="additional_fee" name="additional_fee">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="mb-2">
                                                <label for="title" class="form-label">Nước</label>
                                                {!! \App\Models\Travel\TourModel::countries() !!}

                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-2">
                                                <label for="title" class="form-label">Tỉnh bắt đầu</label>
                                                {!! \App\Models\Travel\TourModel::location('province_start_id') !!}

                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-2">
                                                <label for="title" class="form-label">Tỉnh kết thúc</label>
                                                {!! \App\Models\Travel\TourModel::location('province_end_id') !!}

                                            </div>
                                        </div>
                                    </div>


                                </div>
                            </div>
                            <div class="col-md-5">
                                <div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-2">
                                                <label for="number_of_day" class="form-label">Số ngày đi</label>
                                                <input type="number" class="form-control" id="number_of_day"
                                                    name="number_of_day" value="1" />
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-2">
                                                <label for="description" class="form-label">Dòng tour</label>
                                                <select name="tour_pakage" class="form-control" id="">
                                                    <option value="">--Select--</option>
                                                    <option value="luxury">Cao cấp</option>
                                                    <option value="standard" selected>Tiêu chuẩn</option>
                                                    <option value="affordable">Giá tốt</option>
                                                    <option value="saving">Tiết kiệm</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">

                                            <div class="mb-2">
                                                <label for="quantity" class="form-label">Số lượng vé</label>
                                                <input type="number" class="form-control" id="quantity"
                                                    name="quantity" value="10" />
                                            </div>

                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-2">
                                                <label for="number_of_day" class="form-label">Transportation</label>
                                                <select name="transportation" class="form-control" id="">
                                                    <option value="">--Select--</option>
                                                    <option value="airplane" selected>Máy bay</option>
                                                    <option value="car">Ô tô</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">

                                            <div class="mb-2">
                                                <label for="date_start" class="form-label">Ngày khởi hành</label>
                                                <input class="form-control" type="date" id="date_start"
                                                    name="date_start" />
                                            </div>

                                        </div>

                                        <div class="col-md-6">
                                            <div class="mb-2">
                                                <label for="time_start" class="form-label">Giờ khởi hành</label>
                                                <input class="form-control" type="text" id="time_start"
                                                    value="08:30" name="time_start" />
                                            </div>
                                        </div>

                                    </div>

                                    <div
                                        class="fw-bold py-2 mb-2 border-top mt-2 pt-2 text-white px-2 d-flex justify-content-between">
                                        <div>Lịch trình Tour</div>
                                        <div class="btn btn-sm btn-info" id="btn-add">Thêm</div>
                                    </div>
                                    <div id="process_detail">
                                        {{-- <div class="border p-2 border-primary mb-2">
                                <div class="mb-2">
                                    <label class="fw-bold" for="">Ngày <span></span></label>
                                    <input type="date" name="date[]" class="form-control">
                                </div>
                                <div class="mb-2">
                                    <label class="fw-bold" for="">Tiêu đề <span></span></label>
                                    <input type="date" name="title_process[]" class="form-control">
                                </div>
                                <div class="mb-2">
                                    <label class="fw-bold" for="">Content <span></span></label>
                                    <div id="editor"  style="min-height: 60px">

                                    </div>
                                </div>
                                <input type="text" name="content[]" hidden>
                            </div> --}}




                                    </div>

                                </div>
                            </div>
                            <!--end::Scroll-->
                            <!--begin::Actions-->
                            <div class="text-center pt-15">
                                <button type="submit" class="btn btn-primary" data-kt-roles-modal-action="submit">
                                    <span class="indicator-label">Submit</span>
                                    <span class="indicator-progress">Please wait...
                                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                </button>
                            </div>
                            <!--end::Actions-->
                    </form>
                    <!--end::Form-->
                </div>
                <!--end::Modal body-->
            </div>
            <!--end::Modal content-->
        </div>



    </div>
@endsection
@push('js2')
    <!--begin::Custom Javascript(used for this page only)-->
    <script src="{{ asset('assets/js/custom/apps/user-management/permissions/list.js') }}"></script>
    <script src="{{ asset('assets/js/custom/apps/user-management/permissions/add-permission.js') }}"></script>
    <script src="{{ asset('assets/js/custom/apps/user-management/permissions/update-permission.js') }}"></script>
    <script src="{{ asset('assets/js/widgets.bundle.js') }}"></script>
    <script src="{{ asset('assets/js/custom/widgets.js') }}"></script>
    <script src="{{ asset('assets/js/custom/apps/chat/chat.js') }}"></script>
    <script src="{{ asset('assets/js/custom/utilities/modals/users-search.js') }}"></script>

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


    <script>
        let quillIndex = 0;
        $("#btn-add").click(function() {

            $("#process_detail").append(`
                 <div class="border p-2 border-primary mb-2">
                     <input type="text" name="content[]" class="d-none" id="content${quillIndex}">
                    <div class="mb-2">
                        <label class="fw-bold" for="">Ngày <span>${+quillIndex+1}</span></label>
                        <input type="date" name="date[]" class="form-control">
                    </div>
                    <div class="mb-2">
                        <label class="fw-bold" for="">Tiêu đề <span></span></label>
                        <input type="text" name="title_process[]" class="form-control">
                    </div>
                    <div class="mb-2">
                        <label class="fw-bold" for="">Content <span></span></label>
                        <div id="editor${quillIndex}"  style="min-height: 60px">

                        </div>
                    </div>
                </div>

            `)
            new Quill('#editor' + quillIndex, {
                theme: 'snow'
            });
            quillIndex++;
        })
        // submit form
        $("#form-create").on('submit', function(e) {
            // e.preventDefault();
            // submit data to server
            for (let index = 0; index < quillIndex; index++) {
                $("#content" + index).val($('#editor' + index).html());
            }
        })
    </script>
    <!--end::Custom Javascript-->
    <!--end::Javascript-->
@endpush
