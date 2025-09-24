@extends('layout.app')
@section('view_title')
    Thêm thông báo mới
@endsection
@push('js1')

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
                            <li class="breadcrumb-item active" aria-current="page">Chi tiết thông báo</li>
                        </ol>
                    </nav>

                </div>
            </div>
            <!-- End Row -->
        </div>
        <!-- End Page Header -->
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
        <div class="row ">
            <div class="col-12">
                <h1>{{$data->title}}</h1>

                <div class="d-flex" style="gap: 20px">
                    <div>
                        <strong>Ngày tạo:</strong> {{ $data->created_at->format('d/m/Y H:i:s') }}
                    </div>
                    <div>
                        <strong>Từ:</strong> {{ $data->from }}
                    </div>
                    <div>
                        <strong>Đến:</strong> {{ $data->to }}
                    </div>
                </div>
                <hr>
                <div class="mt-4">
                    {!!$data->message!!}
                </div>
            </div>
        </div>
    </div>

@endsection
