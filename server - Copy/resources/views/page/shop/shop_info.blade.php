@extends('layout.app')
@section('view_title')
    Shop: {{ $shop->name }}
@endsection

@section('main')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col-sm mb-2 mb-sm-0">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-no-gutter">
                            <li class="breadcrumb-item"><a class="breadcrumb-link" href="/">Trang chủ</a></li>
                            <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ route('shop.list') }}">Cửa hàng</a></li>
                        </ol>
                    </nav>
                    <h1 class="page-header-title">Cửa hàng: {{ $shop->name }}</h1>
                </div>
            </div>
        </div>
        <!-- End Page Header -->

        <div class="row">
            <div class="col-lg-8">
                <div class="card card-body mb-3 mb-lg-5">
                    <div class="row gx-lg-4">
                        <div class="col-sm-6 col-lg-3">
                            <div class="media">
                                <div class="media-body">
                                    <h6 class="card-subtitle">Tổng Sản phẩm</h6>
                                    <span class="card-title h3">{{ $shop->count()['product'] }}</span>


                                </div>

                                <span class="icon icon-sm icon-soft-secondary icon-circle ml-3">
                                    <i class="tio-shop"></i>
                                </span>
                            </div>

                            <div class="d-lg-none">
                                <hr>
                            </div>
                        </div>

                        <div class="col-sm-6 col-lg-3 column-divider-sm">
                            <div class="media">
                                <div class="media-body">
                                    <h6 class="card-subtitle">Sản phẩm hoạt động</h6>
                                    <span class="card-title h3">{{ $shop->count()['product_active'] }}</span>


                                </div>

                                <span class="icon icon-sm icon-soft-secondary icon-circle ml-3">
                                    <i class="tio-website"></i>
                                </span>
                            </div>

                            <div class="d-lg-none">
                                <hr>
                            </div>
                        </div>

                        <div class="col-sm-6 col-lg-3 column-divider-lg">
                            <div class="media">
                                <div class="media-body">
                                    <h6 class="card-subtitle">Sản phẩm chờ duyệt</h6>
                                    <span class="card-title h3">{{ $shop->count()['product_new'] }}</span>


                                </div>

                                <span class="icon icon-sm icon-soft-secondary icon-circle ml-3">
                                    <i class="tio-label-off"></i>
                                </span>
                            </div>

                            <div class="d-sm-none">
                                <hr>
                            </div>
                        </div>

                        <div class="col-sm-6 col-lg-3 column-divider-sm">
                            <div class="media">
                                <div class="media-body">
                                    <h6 class="card-subtitle">Sản phẩm từ chối</h6>
                                    <span class="card-title h3">{{ $shop->count()['product_deny'] }}</span>


                                </div>

                                <span class="icon icon-sm icon-soft-secondary icon-circle ml-3">
                                    <i class="tio-users-switch"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
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
                <!-- Card -->

                <!-- End Card -->

                <!-- Card -->
                <div class="card mb-3 mb-lg-5">
                    <!-- Header -->
                    <div class="card-header">
                        <div class="row justify-content-between align-items-center flex-grow-1">
                            <div class="col-sm mb-3 mb-sm-0">
                                <h4 class="card-header-title">Sản phẩm ({{ $data->total() }})</h4>
                            </div>


                        </div>
                        <!-- End Row -->
                    </div>
                    <!-- End Header -->

                    <!-- Body -->
                    <div class="card-body">
                        <!-- Input Group -->
                        <form class="input-group input-group-merge">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="tio-search"></i>
                                </span>
                            </div>

                            <input id="datatableSearch" name="search" type="search" value="{{ request()->search }}"
                                class="form-control" placeholder="Tìm kiếm" aria-label="Search orders">
                            <button type="submit" class="btn btn-sm btn-warning">Tìm</button>
                        </form>
                        <!-- End Input Group -->
                    </div>
                    <!-- End Body -->

                    <!-- Table -->
                    <div class="table-responsive datatable-custom">
                        <table id="datatable"
                            class="table table-borderless table-thead-bordered table-nowrap table-align-middle card-table">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">Sản phẩm</th>
                                    <th scope="col">Số lượng</th>
                                    <th scope="col">Giá</th>
                                    <th scope="col">Đã bán</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse ($data as $item)
                                    <tr>
                                        <td>
                                            <!-- Media -->
                                            <a class="media align-items-center"
                                                href="{{ route('product.update', ['id' => $item->id]) }}">
                                                <img style="object-fit:cover" class="avatar mr-3 object-fit-cover"
                                                    src="{{ $item->image }}" alt="Image Description">

                                                <div class="media-body">
                                                    <h5 class="text-hover-primary mb-0">{{ $item->name }}</h5>
                                                </div>
                                            </a>
                                            <!-- End Media -->
                                        </td>
                                        <td><i class="tio-trending-up text-success mr-1"></i> {{ $item->stock }}</td>
                                        <td>
                                            <div>
                                                <div>Giá bán: {{ number_format($item->price, 0, ',', '.') }} vnd</div>
                                                <div>% giảm: {{ $item->percent_sale ?? '0' }}</div>
                                            </div>
                                        </td>
                                        <td>{{ $item->sold }}</td>

                                    </tr>

                                @empty
                                    <tr>
                                        <td class="text-center text-danger py-5" colspan="5">Không tìm thấy dữ liệu
                                            nào!</td>
                                    </tr>
                                @endforelse


                            </tbody>
                        </table>
                    </div>
                    <!-- End Table -->

                    <!-- Footer -->
                    <div class="card-footer">
                        <!-- Pagination -->
                        <div class="row justify-content-center justify-content-sm-between align-items-sm-center">
                            <div class="col-sm mb-2 mb-sm-0">
                                <div class="d-flex justify-content-center justify-content-sm-start align-items-center">
                                    {{ $data->links() }}
                                </div>
                            </div>

                            <div class="col-sm-auto">
                                <div class="d-flex justify-content-center justify-content-sm-end">
                                    <!-- Pagination -->
                                    <nav id="datatablePagination" aria-label="Activity pagination"></nav>
                                </div>
                            </div>
                        </div>
                        <!-- End Pagination -->
                    </div>
                    <!-- End Footer -->
                </div>
                <!-- End Card -->



                @if (in_array('Supper Admin',auth()->user()->roles()->toArray()))
                <div class="d-none d-lg-block">
                    <button type="button" class="btn btn-danger">Xóa cửa hàng</button>
                </div>
                @endif
            </div>

            <div class="col-lg-4">
                <div class="card mb-3 mb-lg-5">
                    <!-- Body -->
                    <div class="card-body">
                        <!-- Media -->
                        <div class="d-flex align-items-center mb-5">
                            <div class="avatar avatar-lg avatar-circle">
                                <img  class="avatar-img w-100 h-100" id="logo_preview" style="object-fit: cover"
                                    src="{{ $shop->logo && $shop->logo != '' ? $shop->logo : asset('assets\img\quin\shop.png') }}"
                                    alt="Image Description">
                            </div>

                            <div class="mx-3">
                                <div class="d-flex mb-1">
                                    <h3 class="mb-0 mr-3">{{ $shop->name }}</h3>

                                    <!-- Unfold -->
                                    <div class="hs-unfold">
                                        <a class="js-hs-unfold-invoker btn btn-icon btn-xs btn-white rounded-circle"
                                            href="javascript:;" data-toggle="tooltip" data-placement="top" title="Edit"
                                            data-hs-unfold-options='{
                                                "target": "#editDropdown",
                                                "type": "css-animation"
                                            }'>
                                            <i class="tio-edit"></i>
                                        </a>

                                        <div id="editDropdown"
                                            class="hs-unfold-content dropdown-unfold dropdown-menu dropdown-card mt-1"
                                            style="min-width: 20rem;">
                                            <!-- Card -->
                                            <form class="card" method="POST" action="{{route('shop.update',['shop_id'=>$shop->id])}}" enctype="multipart/form-data">
                                                <div class="card-body">
                                                    @csrf
                                                    <div class="form-row">
                                                        <label for="logo" class="col-sm-12">
                                                            <label class="input-label" for="logo">Logo</label>
                                                            <label for="logo"
                                                                class=" w-100 btn btn-outline-primary px-2 text-center">Tải
                                                                lên</label>
                                                            <input type="file" hidden class="form-control" name="logo"
                                                                id="logo" placeholder="Clarice" aria-label="Clarice"
                                                                value="Anna">
                                                        </label>
                                                        <div class="col-sm-12">
                                                            <label for="name" class="input-label">Tên cửa
                                                                hàng</label>
                                                            <input type="text" class="form-control" name="name"
                                                                id="name" placeholder="Clarice" aria-label="Clarice"
                                                                value="{{ $shop->name }}">
                                                        </div>

                                                        <script>
                                                            $(document).ready(function() {
                                                                $('#logo').on('change', function(e) {
                                                                    const file = e.target.files[0];
                                                                    if (file) {
                                                                        const reader = new FileReader();
                                                                        reader.onload = function(e) {
                                                                            $('#logo_preview').attr('src', e.target.result);
                                                                        };
                                                                        reader.readAsDataURL(file);
                                                                    }
                                                                });
                                                            });
                                                        </script>
                                                    </div>
                                                    <!-- End Row -->

                                                    <div class="d-flex justify-content-end mt-3">
                                                        <button type="submit" class="btn btn-sm btn-primary">Lưu</button>
                                                    </div>
                                                </div>
                                            </form>
                                            <!-- End Body -->
                                        </div>
                                    </div>
                                    <!-- End Unfold -->
                                </div>

                                <span class="font-size-sm">{{ $shop->created_at->diffForHumans() }}</span>
                            </div>


                        </div>
                        <!-- End Media -->

                        <label class="input-label">Giới thiệu của hàng</label>

                        <!-- Quill -->
                        <form method="POST" action="{{route('shop.update',['shop_id'=>$shop->id])}}" class="quill-custom">
                            @csrf
                            <textarea class="form-control" id="" cols="30" name="bio" rows="5">{{ $shop->bio }}</textarea>
                            <div class="d-flex justify-content-end mt-2">
                                {{-- <button type="submit" class="btn btn-white mr-2">Discard</button> --}}
                                <button type="submit" class="btn btn-primary btn-sm">Cập nhật</button>
                            </div>
                        </form>
                        <!-- End Quill -->
                    </div>
                    <!-- Body -->

                    <!-- Footer -->
                    <div class="card-footer">

                    </div>
                    <!-- End Footer -->
                </div>
                <!-- Card -->
                <div class="card mb-3 mb-lg-5">
                    <!-- Body -->
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5>Thông tin liên hệ</h5>
                            {{-- <a class="link" href="javascript:;">Edit</a> --}}
                        </div>

                        <form method="POST" action="{{route('shop.update',['shop_id'=>$shop->id])}}" class="list-unstyled list-unstyled-py-2">
                            <li class="d-flex align-items-center mb-2">
                                <div class="" style="min-width: 22px">
                                    <i class="fa-solid fa-location-dot me-2"></i>
                                </div>
                                @csrf
                                <div class="" style="flex:1">
                                    <input type="text" name="address_detail" value="{{ $shop->address_detail }}" class="form-control">
                                </div>
                            </li>
                            <li class="d-flex align-items-center mb-2">
                                <div class="" style="min-width: 22px">
                                    <i class="tio-android-phone-vs mr-2"></i>
                                </div>
                                <div class="" style="flex:1">
                                    <input name="phone_number" type="text" value="{{ $shop->phone_number }}" class="form-control">
                                </div>
                            </li>
                            <li>
                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary btn-sm">Cập nhật</button>
                                </div>
                            </li>

                        </form>

                        <hr>

                        <div class="d-flex justify-content-between align-items-center">
                            <h5>Tài khoản</h5>
                            <a class="link" href="javascript:;">Edit</a>
                        </div>
                        <ul class="list-unstyled list-unstyled-py-2">
                            <li class="">
                                <div class="avatar avatar-lg avatar-circle">
                                    <img class="avatar-img" src="{{ $shop->user->avatar_url }}" alt="">
                                </div>
                            </li>
                            <li>
                                <i class="fa-solid fa-user mr-2"></i>
                                {{ $shop->user->full_name }}
                            </li>
                            <li>
                                <a href="{{ route('user.info', ['uuid' => $shop->user->uuid]) }}">
                                    <i class="tio-online mr-2"></i>
                                    {{ $shop->user->email }}
                                </a>
                            </li>
                        </ul>
                        <hr>
                        <div class="mt-3">
                            <h5 class="mb-2">Tài khoản ngân hàng</h5>
                            @foreach ($shop->banks() as $item)
                                <div class=" p-2 rounded-2 mb-2" style="border:1px dashed green; background-color:azure">
                                    <span class="d-block">Tên: <strong>{{ $item->name }}</strong></span>
                                    <span class="d-block">Số TK: <strong>{{ $item->code }}</strong></span>
                                    <span class="d-block">Ngân hàng: <strong>
                                            {{ $item->bank->short_name }}</strong></span>
                                </div>
                            @endforeach
                        </div>



                    </div>
                    <!-- End Body -->
                </div>
                <!-- End Card -->





            </div>
        </div>
        <!-- End Row -->

        <div class="d-lg-none">
            <button type="button" class="btn btn-danger">Delete customer</button>
        </div>
    </div>
@endsection
