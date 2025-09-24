@extends('layout.app')
@section('view_title')
    Cài đặt chung
@endsection
@section('main')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-sm mb-2 mb-sm-0">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-no-gutter">
                            <li class="breadcrumb-item"><a class="breadcrumb-link" href="/">Trang chủ</a></li>
                            <li class="breadcrumb-item"><a class="breadcrumb-link" href="javascript:;">Phương thức thanh toán</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Cập nhật</li>
                        </ol>
                    </nav>

                    <h1 class="page-header-title">Cập nhật thông tin</h1>
                </div>

            </div>
            <!-- End Row -->
        </div>
        <!-- End Page Header -->
        <div class="row">
            <div class="col-12">
                @if (session('error'))
                    <div class="alert alert-danger py-2">{{ session('error') }}</div>
                @endif
                @if (session('success'))
                    <div class="alert alert-success py-2">{{ session('success') }}</div>
                @endif
            </div>
        </div>
        <div class="card mb-3 mb-lg-5">
            <!-- Header -->

            <form method="post" action="{{ route('payment-method.update',['payment_method'=>$data->id]) }}" class="card-body">
                <!-- Form Group -->
                @method('PUT')
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="" class="input-label">Code</label>
                            <div class="input-group">
                                <input type="text" class="form-control" value="{{old('code') ?? $data['code']}}" name="code" id=""
                                    placeholder="" aria-label="">
                            </div>
                            @error('code')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="" class="input-label">Tên</label>
                            <div class="input-group">
                                <input type="text" class="form-control" value="{{ old('name') ?? $data['name']}}" name="name"
                                    id="" placeholder="" aria-label="">
                            </div>
                            @error('name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>


                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="" class="input-label">Mô tả</label>
                            <div class="input-group">
                                <input type="text" class="form-control" value="{{ old('description')?? $data['description'] }}"
                                    name="description" id="" placeholder="" aria-label="">
                            </div>
                            @error('description')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="" class="input-label">Trạng thái</label>
                            <select name="is_show" class="form-control" id="">
                                <option value="">Chọn trạng thái</option>
                                <option value="1" {{$data['is_show'] == 1 ? 'selected' : '' }}>Kích hoạt</option>
                                <option value="0" {{$data['is_show'] == 0 ? 'selected' : '' }}>Ẩn</option>
                            </select>
                            @error('is_show')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary">Cập nhật</button>
                    </div>
                </div>


            </form>

        </div>


    </div>
@endsection
