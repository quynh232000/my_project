@extends('layout.app')
@section('view_title')
    Thêm thông báo mới
@endsection
@push('js1')
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
@endpush
@section('main')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-sm mb-2 mb-sm-0">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-no-gutter">
                            <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ route('dashboard') }}">Trang
                                    chủ</a></li>
                            <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ route('banner.list') }}">Thông
                                    báo
                                </a></li>
                            <li class="breadcrumb-item active" aria-current="page">Thêm thông báo mới</li>
                        </ol>
                    </nav>

                    <h1 class="page-header-title">Thêm thông báo mới</h1>
                </div>
            </div>
            <!-- End Row -->
        </div>
        <!-- End Page Header -->
        <div class="js-step-form py-md-5">
            <div class="row">
                <div class="col-12">
                    @if (session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                </div>
            </div>
            <div class="row justify-content-lg-center">
                <div class="col-12">
                    <div id="addUserStepFormContent">
                        <!-- Card -->
                        <form method="POST"  class="card card-lg active"
                             action="{{route('notify.store')}}" >
                            @csrf
                            @method('POST')
                            <!-- Body -->
                            <div class="card-body">


                                <!-- Form Group -->
                                <div class="row form-group">
                                    <label for="firstNameLabel" class="col-sm-3 col-form-label input-label">Title <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-sm-9">
                                        <div class="input-group input-group-sm-down-break">
                                            <input type="text" class="form-control" value="{{ old('title') }}" name="title" placeholder="Aa.." aria-label="Clarice" />
                                        </div>
                                        @error('title')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row form-group">
                                    <label for="firstNameLabel" class="col-sm-3 col-form-label input-label">Message <span
                                            class="text-danger">*</span>
                                    </label>
                                    <div class="quill-custom col-sm-9 m">
                                        <div class="js-quill" id="editor-container" style="min-height: 15rem;">

                                        </div>
                                        <input type="text"value="" id="input_description" name="message" hidden>
                                        @error('message')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row form-group mb-4">
                                    <label for="firstNameLabel" class="col-sm-3 col-form-label input-label">Thông báo
                                        đến<span class="text-danger">*</span>
                                    </label>
                                    <div class="col-sm-9">
                                        <div class="input-group input-group-sm-down-break">
                                            <select name="to" class="form-control" id="">
                                                <option value="">--Chọn--</option>
                                                <option value="WEB">Người mua sắm</option>
                                                {{-- <option value="ALL">Toàn hệ thống</option> --}}
                                                <option value="SHOP">Cửa hàng</option>
                                                {{-- <option value="AFFLICATE">Cộng tác viên</option> --}}
                                            </select>
                                        </div>
                                        @error('to')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <label for="firstNameLabel" class="col-sm-3 col-form-label input-label">Gửi mail<span class="text-danger">*</span>
                                    </label>
                                    <div class="col-sm-9">
                                        <div class="d-flex">
                                            <div class="mr-5">
                                                <input type="radio" name="is_send_mail" value="true" id="is_maiil1">
                                                <label for="is_maiil1">Có</label>
                                            </div>
                                            <div>
                                                <input checked type="radio" name="is_send_mail" value="false" id="is_maiil2">
                                                <label for="is_maiil2">Không</label>
                                            </div>
                                        </div>
                                        @error('sent_type')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <label for="firstNameLabel" class="col-sm-3 col-form-label input-label">Loại thông
                                        báo<span class="text-danger">*</span>
                                    </label>
                                    <div class="col-sm-9">
                                        <div class="input-group input-group-sm-down-break">
                                            <select id="sent_type" name="sent_type" class="form-control" id="">
                                                <option value="IMMEDIATE" selected>Chạy ngay</option>
                                                <option value="SCHEDULED">Đặt lịch</option>
                                            </select>
                                        </div>
                                        @error('sent_type')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row form-group" id="show_send_type">

                                </div>
                                <div class="row form-group">
                                    <label for="firstNameLabel" class="col-sm-3 col-form-label input-label">Loại người gửi
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-sm-9">
                                        <div class="input-group input-group-sm-down-break">
                                            <select name="type_target" class="form-control" id="type_target">
                                                <option value="">--Chọn--</option>
                                                <option value="ALL">Tất cả</option>
                                                <option value="GROUP">Nhóm đối tượng</option>
                                                <option value="USER">Danh sách người dùng</option>
                                            </select>
                                        </div>
                                        @error('type_target')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row form-group" id="show_select">

                                </div>
                            </div>
                            <!-- End Body -->

                            <!-- Footer -->
                            <div class="card-footer d-flex justify-content-end align-items-center">
                                <button type="submit" class="btn btn-primary">
                                    Tạo mới<i class="tio-chevron-right"></i>
                                </button>
                            </div>
                            <!-- End Footer -->
                        </form>
                        <!-- End Card -->

                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        var quill = new Quill('#editor-container', {
            theme: 'snow'
        });
        $('form').submit(function() {
            $('input[name="message"]').val(quill.root.innerHTML);
        })
        $('#sent_type').on('change', function() {
            if ($(this).val() != 'IMMEDIATE') {
                $('#show_send_type').html(`
                    <label for="firstNameLabel" class="col-sm-3 col-form-label input-label">Thời gian gửi
                    </label>
                    <div class="col-sm-9">
                        <div class="input-group input-group-sm-down-break">
                            <input type="date" class="form-control" value="{{ old('expired_at') }}"
                                name="expired_at" placeholder="1,2" aria-label="Clarice" value="1" />
                        </div>
                        @error('expired_at')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                `)
            } else {
                $('#show_send_type').html('')
            }

        })

        //
        const roles = @json($data['role']);
        const users = @json($data['user']);

        $('#type_target').on('change', function() {
            const type = $(this).val()
            let html = ''
            switch (type) {
                case 'GROUP':
                    const opts = roles.map(item => {
                        return `<option value="${item.id}">${item.name}</option>`
                    }).join('')
                    html = `
                                <label for="firstNameLabel" class="col-sm-3 col-form-label input-label">Loai nhóm người dùng
                                        <span class="text-danger">*</span>
                                </label>
                                <div class="col-sm-9">
                                    <div class="input-group input-group-sm-down-break">
                                        <select  name="target_ids[]" class="form-control" id="target_ids">
                                            <option value="">--Chọn--</option>
                                            ${opts}
                                        </select>
                                    </div>
                                    @error('target_ids')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                        `
                    break;

                case 'USER':
                    const listuser = users.map(item => {
                        return `<div>
                                    <input type="checkbox" name="target_ids[]" value="${item.id}" id="user_${item.id}">
                                    <label for="user_${item.id}">${item.full_name} (${item.email})</label>
                                </div>`
                    }).join('')
                    html = `
                        <label for="firstNameLabel" class="col-sm-3 col-form-label input-label">Chọn người dùng
                            <span class="text-danger">*</span>
                        </label>
                        <div class="col-sm-9">
                            <div>
                            ${listuser}
                            </div>
                            @error('type_target')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    `
                    break;

                default:
                    html =''
                    break;
            }
            $('#show_select').html(html)
        })
    </script>
@endsection
