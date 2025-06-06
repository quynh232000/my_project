@extends('layout.app')
@section('view_title')
    {{ $voucher->name }}
@endsection

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
                            <li class="breadcrumb-item"><a class="breadcrumb-link"
                                    href="{{ route('marketing.voucher.list') }}">Khuyến mãi
                                </a></li>
                            <li class="breadcrumb-item active" aria-current="page">Khuyến mãi mới</li>
                        </ol>
                    </nav>

                    <h1 class="page-header-title">Cập nhật khuyến mãi</h1>
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
                <div class="col-lg-8">
                    <div id="addUserStepFormContent">
                        <!-- Card -->
                        <form method="post" id="addUserStepProfile"
                            action="{{ route('marketing.voucher._update', ['id' => $voucher->id]) }}"
                            class="card card-lg active" enctype="multipart/form-data">
                            @csrf
                            <!-- Body -->
                            <div class="card-body">

                                <div class="row form-group">
                                    <label for="firstNameLabel" class="col-sm-3 col-form-label input-label">Tên chương trình
                                        <span class="text-danger">*</span>
                                    </label>

                                    <div class="col-sm-9">
                                        <div class="input-group input-group-sm-down-break">
                                            <input type="text" class="form-control"
                                                value="{{ old('name') ?? $voucher->name }}" name="name"
                                                placeholder="Aa.." aria-label="Clarice" />
                                        </div>
                                        @error('name')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <label for="firstNameLabel" class="col-sm-3 col-form-label input-label">Mã voucher (9)
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-sm-9">
                                        <div class="input-group input-group-sm-down-break">
                                            <input type="text" readonly class="form-control"
                                                value="{{ old('code') ?? $voucher->code }}" name="code"
                                                placeholder="Aa.." aria-label="Clarice" />
                                        </div>
                                        @error('code')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <label for="firstNameLabel" class="col-sm-3 col-form-label input-label">Ngày bắt đầu
                                    </label>

                                    <div class="col-sm-9">
                                        <div class="input-group input-group-sm-down-break">
                                            <input type="datetime-local" class="form-control"
                                                value="{{ old('date_start') ?? $voucher->date_start }}" name="date_start"
                                                placeholder="1,2" aria-label="Clarice" value="1" />
                                        </div>
                                        @error('date_start')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <label for="firstNameLabel" class="col-sm-3 col-form-label input-label">Ngày kết thúc
                                    </label>

                                    <div class="col-sm-9">
                                        <div class="input-group input-group-sm-down-break">
                                            <input type="datetime-local" class="form-control"
                                                value="{{ old('date_end') ?? $voucher->date_end }}" name="date_end"
                                                placeholder="1,2" aria-label="Clarice" value="1" />
                                        </div>
                                        @error('date_end')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row form-group">
                                    <label for="firstNameLabel" class="col-sm-3 col-form-label input-label">Số tiền giảm
                                        <span class="text-danger">*</span>
                                    </label>

                                    <div class="col-sm-9">
                                        <div class="input-group input-group-sm-down-break">
                                            <input type="number" class="form-control"
                                                value="{{ old('discount_amount') ?? $voucher->discount_amount }}"
                                                name="discount_amount" placeholder="Aa.." aria-label="Clarice" />
                                        </div>
                                        @error('discount_amount')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <label for="firstNameLabel" class="col-sm-3 col-form-label input-label">Đơn hàng tối
                                        thiểu<span class="text-danger">*</span>
                                    </label>

                                    <div class="col-sm-9">
                                        <div class="input-group input-group-sm-down-break">
                                            <input type="text" class="form-control"
                                                value="{{ old('minimum_price') ?? $voucher->minimum_price }}"
                                                name="minimum_price" placeholder="Aa.." aria-label="Clarice" />
                                        </div>
                                        @error('minimum_price')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <label for="firstNameLabel" class="col-sm-3 col-form-label input-label">Số lượng <span
                                            class="text-danger">*</span>
                                    </label>

                                    <div class="col-sm-9">
                                        <div class="input-group input-group-sm-down-break">
                                            <input type="number" class="form-control"
                                                value="{{ old('quantity') ?? $voucher->quantity }}" name="quantity"
                                                value="1" placeholder="Aa.." aria-label="Clarice" />
                                        </div>
                                        @error('quantity')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <label for="firstNameLabel" class="col-sm-3 col-form-label input-label">Lượt sử
                                        dụng/Người
                                    </label>
                                    <div class="col-sm-9">
                                        <div class="input-group input-group-sm-down-break">
                                            <input type="number" class="form-control"
                                                value="{{ old('max_usage_per_user') ?? $voucher->max_usage_per_user }}"
                                                name="max_usage_per_user" placeholder="1,2" aria-label="Clarice"
                                                value="1" />
                                        </div>
                                        @error('max_usage_per_user')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                            </div>
                            <!-- End Body -->

                            <!-- Footer -->
                            <div class="card-footer d-flex justify-content-end align-items-center">
                                <button type="submit" class="btn btn-primary">
                                    Cập nhật
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
@endsection
