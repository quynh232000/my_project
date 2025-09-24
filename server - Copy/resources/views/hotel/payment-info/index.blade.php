@extends('layout.app')
@php
    $model = $params['model'];
@endphp
@section('title', trans('Thông tin thanh toán'))
@section('main')
    <script>
        function adminConfirm1(id, url, csrf_token) {

            if (id == 0) {
                id = [];
                $('input[name="id[]"]:checked').map(function() {
                    id.push($(this).val());
                });
            }
            $.ajax({
                type: 'POST',
                url: url,
                data: {
                    "_token": $('meta[name="csrf-token"]').attr('content'),
                    "id": id
                },
                datatype: 'html',
                success: (data) => {
                    if (data.success) {
                        $('#global_modal').html(data.html);
                        $("#confirm_formModalTooltip").modal('show');
                    } else {
                        toastr.error(data.message)
                    }

                },
                error: function(error) {

                }
            });
            //return false;
        }

        function adminChangeTicket(el, url) {

            const data = $(el).serializeArray()
            $.ajax({
                type: 'POST',
                url,
                data,
                datatype: 'html',
                success: (res) => {
                    if (res.status) {
                        toastr.success(res.message)
                        setTimeout(() => {
                            window.location.reload();
                        }, 1000);
                    } else {
                        toastr.error(res.message)
                    }


                },
                error: function(error) {

                }
            });
            return false;
        }
    </script>
    @if (\Session::has('info'))
        <div class="alert alert-info">
            <ul>
                <li>{!! \Session::get('info') !!}</li>
            </ul>
        </div>
    @endif
    <style>
        .bg-warning {
            background-color: #fbf0b4 !important;
        }

        thead>tr>th:first-child {
            display: none
        }

        tr>td:first-child {
            display: none
        }

        .cursor-pointer {
            cursor: pointer;
        }

        .basic-data-table thead tr th {
            min-width: 120px !important;
        }

        .basic-data-table {
            position: relative;
        }

        th:nth-last-child(1),
        td:nth-last-child(1) {
            position: sticky;
            right: 0;
            z-index: 2;
            background: white;
            box-shadow: -2px 0 5px rgba(0, 0, 0, 0.1);
            border-left: 1px solid #000000;
            margin: auto;
            padding: auto;
        }

        /* th:nth-child(2), td:nth-child(2) {
                position: sticky;
                left: 0;
                z-index: 2;
                background: white !important;
                box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
            } */
    </style>
    <div class="modals" id="global_modal"></div>
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mt-2">
                <div class="col-6 text-left"></div>
                {{-- <div class="col-6 text-right">
            @include('include.btn.delete')
            @include('include.btn.create')
        </div> --}}
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <div class="row app-container">
        <div class="col-12 p-2">
            <div class="card card-default">
                <div class="card-body p-2">
                    <div class="row p-5">
                        <div class="card-toolbar col-12 d-flex justify-content-end">
                            <!--begin::Toolbar-->
                            <div class="d-flex justify-content-end" style="gap: 10px" data-kt-user-table-toolbar="base">
                                @include('include.btn.delete')
                                @include('include.btn.create')
                            </div>
                        </div>
                    </div>
                    <form class="form-horizontal" method="GET" enctype="multipart/form-data"
                        id="admin-form-{{ $params['prefix'] }}-{{ $params['controller'] }}"
                        name="admin-form-{{ $params['prefix'] }}-{{ $params['controller'] }}">
                        <div class="row m-0 pt-2">
                            <div class="form-group col-sm-3 p-2 mb-0">
                                <label for="bank" class="font-weight-normal">Tên ngân hàng</label>
                                <input id="bank" name="bank"
                                    value="{{ isset($params['bank']) && !empty($params['bank']) ? $params['bank'] : '' }}"
                                    type="text" class="form-control event-enter" placeholder="Nhập bank">
                            </div>
                            <div class="form-group col-sm-3 p-2 mb-0">
                                <label for="hotel" class="font-weight-normal">Tên khách sạn</label>
                                <input id="hotel" name="hotel"
                                    value="{{ isset($params['hotel']) && !empty($params['hotel']) ? $params['hotel'] : '' }}"
                                    type="text" class="form-control event-enter" placeholder="Nhập tên khách sạn">
                            </div>
                            <div class="form-group col-sm-3 p-2 mb-0">
                                <label for="name_account" class="font-weight-normal">Tên tài khoản</label>
                                <input id="name_account" name="name_account"
                                    value="{{ isset($params['name_account']) && !empty($params['name_account']) ? $params['name_account'] : '' }}"
                                    type="text" class="form-control event-enter" placeholder="Nhập họ tên">
                            </div>
                            <div class="form-group col-sm-3 p-2 mb-0">
                                <label for="number" class="font-weight-normal">Số tài khoản</label>
                                <input id="number" name="number"
                                    value="{{ isset($params['number']) && !empty($params['number']) ? $params['number'] : '' }}"
                                    type="text" class="form-control event-enter" placeholder="Nhập Số tài khoản">
                            </div>


                            <div class="form-group col-sm-3 p-2 mb-0">
                                <label for="status" class="font-weight-normal">Trạng thái</label>
                                {!! \App\Models\Hotel\PaymentInfoModel::slbStatus($params['status'] ?? '', ['all' => true]) !!}
                            </div>



                            <div class="form-group col-sm-3 p-2 mb-0">
                                <label for="full_name" class="font-weight-normal">Nhân viên xử lý</label>
                                <input id="full_name" name="full_name"
                                    value="{{ isset($params['full_name']) && !empty($params['full_name']) ? $params['full_name'] : '' }}"
                                    type="text" class="form-control event-enter" placeholder="Nhập tên nhân viên xử lý">
                            </div>
                            <div class="form-group col-sm-3 p-2 mb-0">
                                <label for="created_at" class="font-weight-normal">Ngày tạo</label>
                                <input id="created_at" name="created_at"
                                    value="{{ isset($params['created_at']) && !empty($params['created_at']) ? $params['created_at'] : '' }}"
                                    type="text" class="form-control event-enter" placeholder="">
                            </div>
                            {{-- <div class="form-group col-sm-3 p-2 mb-0">
                            <label for="full_name_update" class="font-weight-normal">Nhân viên sửa</label>
                            <input id="full_name_update" name="full_name_update" value="{{isset($params['full_name_update']) && !empty($params['full_name_update']) ? $params['full_name_update'] : ''}}" type="text" class="form-control event-enter" placeholder="Nhập tên người sửa">
                        </div>
                        <div class="form-group col-sm-3 p-2 mb-0">
                            <label for="updated_at" class="font-weight-normal">Ngày sửa</label>
                            <input id="updated_at" name="updated_at" value="{{isset($params['updated_at']) && !empty($params['updated_at']) ? $params['updated_at'] : ''}}" type="text" class="form-control event-enter" placeholder="">
                        </div> --}}
                            <div class="col-12 text-right d-flex justify-content-end mb-2">
                                @include('include.btn.search')
                            </div>

                        </div>
                    </form>
                    <div class="row p-2">

                        <div class="col-12">
                            <a href="{{ route($params['prefix'] . '.' . $params['controller'] . '.index') }}"
                                class="text-dark">{{ trans('button.total') }}:&nbsp;
                                <span class="text-primary">{{ number_format($model['items']->total()) }} dòng</span>
                            </a>
                        </div>
                    </div>
                    <div class="basic-data-table">
                        {!! $model['contentHtml'] !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {

            // show detail
            $('.btn-view').on('click', function(e) {
                e.preventDefault()
                $.ajax({
                    url: $(this).attr('href'),
                    datatype: 'html',
                    data: {
                        "_token": $('meta[name="csrf-token"]').attr('content')
                    },
                    success: (res) => {
                        if (res.success) {
                            $('#global_modal').html(res.html);
                            $("#modal-show").modal('show');
                        } else {
                            toastr.error(res.message)
                        }
                    },
                    error: function(error) {

                        toastr.error(error)
                    }
                });
            })

        });
    </script>
@endsection
