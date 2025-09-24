@extends('layout.app')
@section('view_title')
    Chi tiết đơn hàng
@endsection
@section('main')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header d-print-none">
            <div class="row align-items-center">
                <div class="col-sm mb-2 mb-sm-0">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-no-gutter">
                            <li class="breadcrumb-item">
                                <a class="breadcrumb-link" href="ecommerce-orders.html">Đơn hàng</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Chi tiết đơn hàng
                            </li>
                        </ol>
                    </nav>

                    <div class="d-sm-flex align-items-sm-center">
                        <h1 class="page-header-title">Order #{{ $data->id }}</h1>

                        @if ($data->status == 'COMPLETED')
                            <span class="badge badge-soft-success ml-sm-3">
                                <span class="legend-indicator bg-success"></span>{{ $data->status }}
                            </span>
                        @elseif ($data->status == 'CANCELLED')
                            <span class="badge badge-soft-danger ml-sm-3">
                                <span class="legend-indicator bg-danger"></span>{{ $data->status }}
                            </span>
                        @else
                            <span class="badge badge-soft-warning ml-sm-3">
                                <span class="legend-indicator bg-warning"></span>{{ $data->status }}
                            </span>
                        @endif



                        <span class="ml-2 ml-sm-3">
                            <i class="tio-date-range"></i> {{ $data->created_at }}
                        </span>
                    </div>

                </div>


            </div>
        </div>
        <!-- End Page Header -->

        <div class="row">
            <div class="col-lg-8 mb-3 mb-lg-0">
                <!-- Card -->
                <div class="card mb-3 mb-lg-5">
                    <!-- Header -->
                    <div class="card-header">
                        <h4 class="card-header-title">
                            Chi tiết đơn hàng
                            <span
                                class="badge badge-soft-dark rounded-circle ml-1">{{ $data->order_details->count() }}</span>
                        </h4>
                    </div>
                    <!-- End Header -->

                    <!-- Body -->
                    <div class="card-body">
                        @foreach ($data->order_details as $item)
                            <div class="media">
                                <div class="avatar avatar-xl mr-3">
                                    <img style="height: 100px; object-fit:cover;width:100px" class="img-fluid"
                                        src="{{ $item->product->image }}" alt="Image Description" />
                                </div>

                                <div class="media-body">
                                    <div class="row">
                                        <div class="col-md-6 mb-3 mb-md-0">
                                            <a class="h5 d-block"
                                                href="ecommerce-product-details.html">{{ $item->product->name }}</a>

                                            <div class="font-size-sm text-body">
                                                <span>Danh mục:</span>
                                                <span class="font-weight-bold">{{ $item->product->category->name }}</span>
                                            </div>

                                        </div>

                                        <div class="col col-md-2 align-self-center">
                                            <h5>{{ number_format($item->price, 0, ',', '.') }} đ</h5>
                                        </div>

                                        <div class="col col-md-2 align-self-center">
                                            <h5>x{{ $item->quantity }}</h5>
                                        </div>

                                        <div class="col col-md-2 align-self-center text-right">
                                            <h5>{{ number_format($item->price * $item->quantity, 0, ',', '.') }} đ</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr />
                        @endforeach
                        <hr />
                        <div class="row justify-content-md-end mb-3">
                            <div class="col-md-8 col-lg-7">
                                <dl class="row text-sm-right">
                                    <dt class="col-sm-6">Tạm tính:</dt>
                                    <dd class="col-sm-6">{{ number_format($data->subtotal, 0, ',', '.') }}đ</dd>
                                    <dt class="col-sm-6">Khuyến mãi:</dt>
                                    <dd class="col-sm-6">
                                        {{ number_format($data->voucher_shop->discount_amount ?? 0, 0, ',', '.') }}đ</dd>
                                    <dt class="col-sm-6">Phí vận chuyển:</dt>
                                    <dd class="col-sm-6">{{ number_format($data->shipping_fee, 0, ',', '.') }}đ</dd>
                                    <hr class="border-top">
                                    <dt class="col-sm-6">Tổng tiền:</dt>
                                    <dd class="col-sm-6 mt-2 text-primary">{{ number_format($data->total, 0, ',', '.') }}đ
                                    </dd>
                                </dl>
                                <!-- End Row -->
                            </div>
                        </div>
                        <!-- End Row -->
                    </div>
                    <!-- End Body -->
                </div>
                <!-- End Card -->

                <!-- Card -->
                <div class="card">
                    <!-- Header -->
                    <div class="card-header">
                        <h4 class="card-header-title">
                            Thông tin đơn hàng
                            <span class="badge badge-soft-dark ml-1">
                                @if ($data->payment_status == 'PAID')
                                    <span class="legend-indicator bg-primary">Đã thanh toán</span>
                                @else
                                    <span class="legend-indicator bg-dark"></span>Chưa thanh toán
                                @endif
                            </span>
                        </h4>
                    </div>
                    <!-- End Header -->

                    <!-- Body -->
                    <div class="card-body">
                        <!-- Step -->
                        <ul class="step step-icon-xs">
                            @foreach ($data->trackings as $item)
                                <li class="step-item">
                                    <div class="step-content-wrapper">
                                        <small class="step-divider text-primary" style="min-width: 80px">
                                            {{ $item->status }}
                                        </small>
                                        <div class="" style="margin: 0 10px">
                                            <div style="font-weight: bold">
                                                @if ($item->status == 'NEW')
                                                    Đơn hàng mới
                                                @elseif($item->status == 'PROCESSING')
                                                    Đang xử lý
                                                @elseif($item->status == 'DELIVERED')
                                                    Giao hàng thành công
                                                @elseif($item->status == 'CANCELLED')
                                                    Đã hủy từ {{ $item->from }}
                                                @elseif($item->status == 'COMPLETED')
                                                    Đã hoàn thành
                                                @elseif($item->status == 'RETURNED')
                                                    Đã hoàn trả
                                                @endif
                                            </div>
                                            <div>{{ $item->created_at }}</div>
                                        </div>
                                    </div>
                                </li>
                            @endforeach


                        </ul>
                        <small>Tiến trình trạng thái đơn hàng</small>
                    </div>
                    <!-- End Body -->
                </div>
                <!-- End Card -->
            </div>

            <div class="col-lg-4">
                <!-- Card -->
                <div class="card">
                    <!-- Header -->
                    <div class="card-header">
                        <h4 class="card-header-title">Thông tin cửa hàng</h4>
                    </div>
                    <!-- End Header -->

                    <!-- Body -->
                    <div class="card-body">
                        <a class="media align-items-center" href="ecommerce-customer-details.html">
                            <div class="avatar avatar-circle mr-3">
                                <img class="avatar-img" src="{{ $data->shop->logo }}" alt="Image Description" />
                            </div>
                            <div class="media-body">
                                <div class="text-body text-hover-primary fw-bold">{{ $data->shop->name }}</div>
                                <div class="text-body text-hover-primary">{{ $data->shop->email }}</div>
                            </div>

                        </a>

                        <hr />

                        <a class="media align-items-center" href="ecommerce-customer-details.html">
                            <div class="icon icon-soft-info icon-circle mr-3">
                                <i class="tio-shopping-basket-outlined"></i>
                            </div>
                            <div class="media-body">
                                <span class="text-body text-hover-primary">{{ $data->order_details->count() }}</span>
                            </div>
                            <div class="media-body text-right">
                                <i class="tio-chevron-right text-body"></i>
                            </div>
                        </a>

                        <hr />

                        <div class="d-flex justify-content-between align-items-center">
                            <h5>Thông tin người mua</h5>
                            <a class="link" href="javascript:;"></a>
                        </div>

                        <ul class="list-unstyled list-unstyled-py-2">
                            <li>
                                <img class="avatar avatar-xss avatar-circle ml-1" src="{{ $data->order->user->avatar }}"
                                    alt="Great Britain Flag" />
                            </li>
                            <li>
                                <i class="tio-online mr-2"></i>
                                {{ $data->order->user->email }}
                            </li>
                            <li>
                                <i class="tio-android-phone-vs mr-2"></i>
                                {{ $data->order->user->full_name }}
                            </li>
                        </ul>

                        <hr />

                        <div class="d-flex justify-content-between align-items-center">
                            <h5>Địa chỉ giao hàng</h5>
                        </div>

                        <span class="d-block">
                            {{ $data->order->address->ward->name }}-{{ $data->order->address->district->name }}-{{ $data->order->address->province->name }}<br />
                            {{ $data->order->address->address_detail }}<br />
                            {{ $data->order->address->phone_number }}<br />

                        </span>

                        <hr />

                        <div class="d-flex justify-content-between align-items-center">
                            <h5>Ghi chú</h5>
                        </div>

                        <span class="d-block">
                            {{ $data->note != '' ?$data->note : '__' }}<br />
                        </span>
                    </div>
                    <!-- End Body -->
                </div>
                <!-- End Card -->
            </div>
        </div>
        <!-- End Row -->
    </div>
@endsection
