@extends('layout.app')
@section('title', 'Shop: '.$params['item']->name)
@section('main')
    <div id="kt_app_content_container" class="app-container ">

        <div class="card card-flush">
            <!--begin::Modal content-->
            <div class="modal-content">
                <!--begin::Modal header-->
                <div class="modal-header px-5 pt-5">
                    <!--begin::Modal title-->
                    <h2 class="fw-bold"> Infomation</h2>
                    <!--end::Modal title-->
                    <!--begin::Close-->
                    <a href="{{ route($params['prefix'] . '.' . $params['controller'] . '.index') }}" class="btn  btn-danger">
                        Back
                    </a>
                    <!--end::Close-->
                </div>

                <!--begin::Layout-->
                <div class="d-flex flex-column flex-xl-row">
                    <!--begin::Sidebar-->
                    <div class="flex-column flex-lg-row-auto w-100 w-xl-350px mb-10">
                        <!--begin::Card-->
                        <div class="card mb-5 mb-xl-8">
                            <!--begin::Card body-->
                            <div class="card-body pt-15">
                                <!--begin::Summary-->
                                <div class="d-flex flex-center flex-column mb-5">
                                    <!--begin::Avatar-->
                                    <div class="symbol symbol-100px symbol-circle mb-7">
                                        <img src="{{ $params['item']['logo'] ?? '' }}" alt="image" />
                                    </div>
                                    <!--end::Avatar-->
                                    <!--begin::Name-->
                                    <a href="#"
                                        class="fs-3 text-gray-800 text-hover-primary fw-bold mb-1">{{ $params['item']['name'] ?? '' }}</a>
                                    <!--end::Name-->
                                    <!--begin::Position-->
                                    <div class="fs-5 fw-semibold text-muted mb-6">{{ $params['item']['email'] ?? '' }}</div>
                                    <!--end::Position-->
                                    <!--begin::Info-->
                                    <div class="d-flex flex-wrap flex-center">
                                        <!--begin::Stats-->
                                        <div class="border border-gray-300 border-dashed rounded py-3 px-3 mb-3">
                                            <div class="fs-4 fw-bold text-gray-700">
                                                <span class="w-75px">{{ $params['item']->products->count() ?? '' }}</span>
                                                <i class="ki-outline ki-arrow-up fs-3 text-success"></i>
                                            </div>
                                            <div class="fw-semibold text-muted">Products</div>
                                        </div>
                                        <!--end::Stats-->
                                        <!--begin::Stats-->
                                        <div class="border border-gray-300 border-dashed rounded py-3 px-3 mx-4 mb-3">
                                            <div class="fs-4 fw-bold text-gray-700">
                                                <span class="w-50px">{{ $params['item']->orders->count() ?? '' }}</span>
                                                <i class="ki-outline ki-arrow-down fs-3 text-danger"></i>
                                            </div>
                                            <div class="fw-semibold text-muted">Orders</div>
                                        </div>
                                        <!--end::Stats-->
                                        <!--begin::Stats-->
                                        <div class="border border-gray-300 border-dashed rounded py-3 px-3 mb-3">
                                            <div class="fs-4 fw-bold text-gray-700">
                                                <span
                                                    class="w-50px">{{ $params['item']->user->ecommerce_posts->count() ?? '' }}</span>
                                                <i class="ki-outline ki-arrow-up fs-3 text-success"></i>
                                            </div>
                                            <div class="fw-semibold text-muted">Posts</div>
                                        </div>
                                        <!--end::Stats-->
                                    </div>
                                    <!--end::Info-->
                                </div>
                                <!--end::Summary-->
                                <!--begin::Details toggle-->
                                <div class="d-flex flex-stack fs-4 py-3">
                                    <div class="fw-bold rotate collapsible" data-bs-toggle="collapse"
                                        href="#kt_customer_view_details" role="button" aria-expanded="false"
                                        aria-controls="kt_customer_view_details">Details
                                        <span class="ms-2 rotate-180">
                                            <i class="ki-outline ki-down fs-3"></i>
                                        </span>
                                    </div>
                                    <span data-bs-toggle="tooltip" data-bs-trigger="hover" title="Edit customer details">
                                        <a href="#" class="btn btn-sm btn-light-primary" data-bs-toggle="modal"
                                            data-bs-target="#kt_modal_update_customer">Edit</a>
                                    </span>
                                </div>
                                <!--end::Details toggle-->
                                <div class="separator separator-dashed my-3"></div>
                                <!--begin::Details content-->
                                <div id="kt_customer_view_details" class="collapse show">
                                    <div class="py-5 fs-6">
                                        <!--begin::Badge-->
                                        <div class="badge badge-light-info d-inline">Premium shop</div>
                                        <!--begin::Badge-->
                                        <!--begin::Details item-->
                                        <div class="fw-bold mt-5">Account ID</div>
                                        <div class="text-gray-600">ID-{{ $params['item']->id }}</div>
                                        <!--begin::Details item-->
                                        <!--begin::Details item-->
                                        <div class="fw-bold mt-5"> Email</div>
                                        <div class="text-gray-600">
                                            <a href="#"
                                                class="text-gray-600 text-hover-primary">{{ $params['item']->email }}</a>
                                        </div>
                                        <!--begin::Details item-->
                                        <!--begin::Details item-->
                                        <div class="fw-bold mt-5"> Address</div>
                                        <div class="text-gray-600">{{ $params['item']->address_detail ?? '_' }}
                                        </div>
                                        <!--begin::Details item-->
                                        <!--begin::Details item-->
                                        <div class="fw-bold mt-5">Phone</div>
                                        <div class="text-gray-600">{{ $params['item']->phone_number ?? '_' }}</div>
                                        <!--begin::Details item-->
                                        <!--begin::Details item-->
                                        <div class="fw-bold mt-5">Shop code</div>
                                        <div class="text-gray-600">{{ $params['item']->shop_code ?? '_' }}</div>
                                        <!--begin::Details item-->

                                    </div>
                                </div>
                                <!--end::Details content-->
                            </div>
                            <!--end::Card body-->
                        </div>
                    </div>
                    <!--end::Sidebar-->
                    <!--begin::Content-->
                    <div class="flex-lg-row-fluid ms-lg-15">
                        <!--begin:::Tabs-->
                        <ul class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-4 fw-semibold mb-8">
                            <!--begin:::Tab item-->
                            <li class="nav-item">
                                <a class="nav-link text-active-primary pb-4 active" data-bs-toggle="tab"
                                    href="#kt_customer_view_overview_tab">Overview</a>
                            </li>
                            <!--end:::Tab item-->
                            <!--begin:::Tab item-->
                            {{-- <li class="nav-item">
                                <a class="nav-link text-active-primary pb-4" data-bs-toggle="tab"
                                    href="#kt_customer_view_overview_events_and_logs_tab">Events & Logs</a>
                            </li>
                            <!--end:::Tab item-->
                            <!--begin:::Tab item-->
                            <li class="nav-item">
                                <a class="nav-link text-active-primary pb-4" data-kt-countup-tabs="true"
                                    data-bs-toggle="tab" href="#kt_customer_view_overview_statements">Statements</a>
                            </li> --}}
                            <!--end:::Tab item-->
                            <!--begin:::Tab item-->

                        </ul>
                        <!--end:::Tabs-->
                        <!--begin:::Tab content-->
                        <div class="tab-content" id="myTabContent">
                            <!--begin:::Tab pane-->
                            <div class="tab-pane fade show active" id="kt_customer_view_overview_tab" role="tabpanel">
                                <!--begin::Card-->
                                <div class="card pt-4 mb-6 mb-xl-9">
                                    @php
                                        $products = $params['item']->products()->paginate(10);
                                    @endphp
                                    <!--begin::Card header-->
                                    <div class="card-header border-0">
                                        <!--begin::Card title-->
                                        <div class="card-title">
                                            <h2>Products ({{ $products->count() }})</h2>
                                        </div>
                                        <!--end::Card title-->
                                        <!--begin::Card toolbar-->
                                        <div class="card-toolbar">
                                            <!--begin::Filter-->
                                            <a href="#" type="button" class="btn btn-sm btn-flex btn-light-primary"
                                                data-bs-toggle="modal" data-bs-target="#kt_modal_add_payment">
                                                <i class="ki-outline ki-plus-square fs-3"></i>Add new</a>
                                            <!--end::Filter-->
                                        </div>
                                        <!--end::Card toolbar-->
                                    </div>
                                    <!--end::Card header-->
                                    <!--begin::Card body-->
                                    <div class="card-body pt-0 pb-5">
                                        <!--begin::Table-->
                                        <table class="table align-middle table-row-dashed gy-5"
                                            id="kt_table_customers_payment">
                                            <thead class="border-bottom border-gray-200 fs-7 fw-bold">
                                                <tr class="text-start text-muted text-uppercase gs-0">
                                                    <th class="min-w-100px">Id.</th>
                                                    <th>Image</th>
                                                    <th>Name</th>
                                                    <th>Price</th>
                                                    <th>Stock</th>
                                                    <th>Status</th>
                                                    <th class="min-w-100px">Created At</th>
                                                    <th class="text-end min-w-100px pe-4">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody class="fs-6 fw-semibold text-gray-600">
                                                @foreach ($products as $item)
                                                    <tr>
                                                        <td>
                                                            <a href="#"
                                                                class="text-gray-600 text-hover-primary mb-1">{{ $item->id }}</a>
                                                        </td>
                                                        <td>
                                                            <div class="d-flex justify-content-center px-5">
                                                                <div
                                                                    class="icon-wrapper cursor-pointer symbol symbol-40px d-flex jusitfy-content-center">
                                                                    <img src="{{ $item->image }}" alt="">
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <a href="#"
                                                                class="text-gray-600 text-hover-primary mb-1">{{ $item->name }}</a>
                                                        </td>
                                                        <td>
                                                            <strong
                                                                class="text-gray-600 text-hover-primary mb-1">{{ $item->price }}</strong>
                                                        </td>
                                                        <td>
                                                            <strong
                                                                class="text-gray-600 text-hover-primary mb-1">{{ $item->stock }}</strong>
                                                        </td>
                                                        <td>

                                                            <span
                                                                class="badge badge-light-{{ $item->status == 'active' ? 'success' : 'danger' }}">{{ $item->status }}</span>
                                                        </td>

                                                        <td>{{ $item->created_at }}</td>
                                                        <td class="pe-0 text-end">
                                                            <a href="{{ route($params['prefix'] . '.product.show', $item->id) }}"
                                                                class="btn btn-sm btn-light image.png btn-active-light-primary">View
                                                                <i class="ki-outline ki-right fs-5 ms-1"></i></a>

                                                        </td>
                                                    </tr>
                                                @endforeach

                                            </tbody>
                                            <!--end::Table body-->
                                        </table>
                                        <hr>
                                        <div>
                                            {{ $products->links() }}
                                        </div>
                                        <!--end::Table-->
                                    </div>
                                    <!--end::Card body-->
                                </div>
                                <!--end::Card-->
                                <!--begin::Card-->
                                <div class="card pt-4 mb-6 mb-xl-9">
                                    <!--begin::Card header-->
                                    <div class="card-header border-0">
                                        <!--begin::Card title-->
                                        <div class="card-title">
                                            <h2 class="fw-bold mb-0">Bankings</h2>
                                        </div>
                                        <!--end::Card title-->
                                        <!--begin::Card toolbar-->
                                        <div class="card-toolbar">
                                            <a href="#" class="btn btn-sm btn-flex btn-light-primary"
                                                data-bs-toggle="modal" data-bs-target="#kt_modal_new_card">
                                                <i class="ki-outline ki-plus-square fs-3"></i>Add new</a>
                                        </div>
                                        <!--end::Card toolbar-->
                                    </div>
                                    <!--end::Card header-->
                                    <!--begin::Card body-->
                                    <div id="kt_customer_view_payment_method" class="card-body pt-0">
                                        @foreach ($params['item']->user->ecommerce_banks as $item)
                                            <div class="py-0" data-kt-customer-payment-method="row">
                                                <!--begin::Header-->
                                                <div class="py-3 d-flex flex-stack flex-wrap">
                                                    <!--begin::Toggle-->
                                                    <div class="d-flex align-items-center collapsible rotate"
                                                        data-bs-toggle="collapse"
                                                        href="#kt_customer_view_payment_method_1{{ $item->id }}"
                                                        role="button" aria-expanded="false"
                                                        aria-controls="kt_customer_view_payment_method_1{{ $item->id }}">
                                                        <!--begin::Arrow-->
                                                        <div class="me-3 rotate-90">
                                                            <i class="ki-outline ki-right fs-3"></i>
                                                        </div>
                                                        <!--end::Arrow-->
                                                        <!--begin::Logo-->
                                                        <img src="assets/media/svg/card-logos/mastercard.svg"
                                                            class="w-40px me-3" alt="" />
                                                        <!--end::Logo-->
                                                        <!--begin::Summary-->
                                                        <div class="me-3">
                                                            <div class="d-flex align-items-center">
                                                                <div class="text-gray-800 fw-bold">{{ $item->bank->name }}
                                                                </div>
                                                                <div class="badge badge-light-primary ms-5">
                                                                    {{ $item->bank->symbol }}</div>
                                                            </div>
                                                            <div class="text-muted">
                                                                {{ $item->bank->short_name . ' - ' . $item->bank->bin }}
                                                            </div>
                                                        </div>
                                                        <!--end::Summary-->
                                                    </div>
                                                    <!--end::Toggle-->
                                                    <!--begin::Toolbar-->
                                                    <div class="d-flex my-3 ms-9">
                                                        <!--begin::Edit-->
                                                        <a href="#"
                                                            class="btn btn-icon btn-active-light-primary w-30px h-30px me-3"
                                                            data-bs-toggle="modal" data-bs-target="#kt_modal_new_card">
                                                            <span data-bs-toggle="tooltip" data-bs-trigger="hover"
                                                                title="Edit">
                                                                <i class="ki-outline ki-pencil fs-3"></i>
                                                            </span>
                                                        </a>
                                                        <!--end::Edit-->
                                                        <!--begin::Delete-->
                                                        <a href="#"
                                                            class="btn btn-icon btn-active-light-primary w-30px h-30px me-3"
                                                            data-bs-toggle="tooltip" title="Delete"
                                                            data-kt-customer-payment-method="delete">
                                                            <i class="ki-outline ki-trash fs-3"></i>
                                                        </a>
                                                        <!--end::Delete-->
                                                        <!--begin::More-->
                                                        <a href="#"
                                                            class="btn btn-icon btn-active-light-primary w-30px h-30px"
                                                            data-bs-toggle="tooltip" title="More Options"
                                                            data-kt-menu-trigger="click"
                                                            data-kt-menu-placement="bottom-end">
                                                            <i class="ki-outline ki-setting-3 fs-3"></i>
                                                        </a>
                                                        <!--begin::Menu-->
                                                        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold w-150px py-3"
                                                            data-kt-menu="true">
                                                            <!--begin::Menu item-->
                                                            <div class="menu-item px-3">
                                                                <a href="#" class="menu-link px-3"
                                                                    data-kt-payment-mehtod-action="set_as_primary">Set as
                                                                    Primary</a>
                                                            </div>
                                                            <!--end::Menu item-->
                                                        </div>
                                                        <!--end::Menu-->
                                                        <!--end::More-->
                                                    </div>
                                                    <!--end::Toolbar-->
                                                </div>
                                                <!--end::Header-->
                                                <!--begin::Body-->
                                                <div id="kt_customer_view_payment_method_1{{ $item->id }}"
                                                    class="collapse fs-6 ps-10"
                                                    data-bs-parent="#kt_customer_view_payment_method">
                                                    <!--begin::Details-->
                                                    <div class="d-flex flex-wrap py-5">
                                                        <!--begin::Col-->
                                                        <div class="flex-equal me-5">
                                                            <table class="table table-flush fw-semibold gy-1">
                                                                <tr>
                                                                    <td class="text-muted min-w-125px w-125px">Name</td>
                                                                    <td class="text-gray-800">{{ $item->name }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="text-muted min-w-125px w-125px">Number</td>
                                                                    <td class="text-gray-800">**** {{ $item->bank->code }}
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="text-muted min-w-125px w-125px">Created At
                                                                    </td>
                                                                    <td class="text-gray-800">{{ $item->created_at }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="text-muted min-w-125px w-125px">Email</td>
                                                                    <td class="text-gray-800">{{ $item->user->email }}
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="text-muted min-w-125px w-125px">Phone</td>
                                                                    <td class="text-gray-800">
                                                                        {{ $item->user->phone_number ?? '_' }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="text-muted min-w-125px w-125px">Address</td>
                                                                    <td class="text-gray-800">
                                                                        {{ $item->bank->address ?? '_' }}</td>
                                                                </tr>
                                                            </table>
                                                        </div>

                                                    </div>
                                                    <!--end::Details-->
                                                </div>
                                                <!--end::Body-->
                                            </div>
                                            <!--end::Option-->
                                            <div class="separator separator-dashed"></div>
                                        @endforeach

                                    </div>
                                    <!--end::Card body-->
                                </div>
                                <!--end::Card-->
                                <!--begin::Card-->
                                <div class="card pt-4 mb-6 mb-xl-9">
                                    <!--begin::Card header-->
                                    <div class="card-header border-0">
                                        <!--begin::Card title-->
                                        <div class="card-title">
                                            <h2 class="fw-bold">Balance</h2>
                                        </div>
                                        <!--end::Card title-->
                                        <!--begin::Card toolbar-->
                                        <div class="card-toolbar">
                                            <a href="#" class="btn btn-sm btn-flex btn-light-primary"
                                                data-bs-toggle="modal" data-bs-target="#kt_modal_adjust_balance">
                                                <i class="ki-outline ki-pencil fs-3"></i>Adjust Balance</a>
                                        </div>
                                        <!--end::Card toolbar-->
                                    </div>
                                    <!--end::Card header-->
                                    <!--begin::Card body-->
                                    <div class="card-body pt-0 row">
                                        <div class="fw-bold col-md-6 fs-2">
                                            {{ number_format($params['item']->orders->sum('total'), 0, ',', '.') }}
                                            <span class="text-muted fs-4 fw-semibold">vnd</span>
                                            <div class="fs-7 fw-normal text-muted">Balance will increase the amount due on
                                                the shop's next invoice.</div>
                                        </div>
                                        <div class="fw-bold col-md-6 fs-2">{{ $params['item']->orders->count() }}
                                            <span class="text-muted fs-4 fw-semibold">orders</span>
                                            <div class="fs-7 fw-normal text-muted">Total orders from 1 year</div>
                                        </div>
                                    </div>
                                    <!--end::Card body-->
                                </div>
                                <!--end::Card-->
                                <!--begin::Card-->
                                <div class="card pt-2 mb-6 mb-xl-9">
                                    <!--begin::Card header-->
                                    <div class="card-header border-0">
                                        <!--begin::Card title-->
                                        <div class="card-title">
                                            <h2>Invoices</h2>
                                        </div>

                                    </div>
                                    <!--end::Card header-->
                                    <!--begin::Card body-->
                                    <div class="card-body pt-0">
                                        <!--begin::Tab Content-->
                                        <div id="kt_referred_users_tab_content" class="tab-content">
                                            <!--begin::Tab panel-->
                                            <div id="kt_customer_details_invoices_1"
                                                class="py-0 tab-pane fade show active" role="tabpanel">
                                                <!--begin::Table-->
                                                <table id="kt_customer_details_invoices_table_1"
                                                    class="table align-middle table-row-dashed fs-6 fw-bold gy-5">
                                                    <thead
                                                        class="border-bottom border-gray-200 fs-7 text-uppercase fw-bold">
                                                        <tr class="text-start text-muted gs-0">
                                                            <th class="min-w-100px">Order ID</th>
                                                            <th class="min-w-100px">Total</th>
                                                            <th class="min-w-100px">Sub Total</th>
                                                            <th class="min-w-100px">Shipping fee</th>
                                                            <th class="min-w-100px">Status</th>
                                                            <th class="min-w-100px">Payment Status</th>
                                                            <th class="min-w-125px">Date</th>
                                                            <th class="min-w-100px text-end pe-7">Invoice</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="fs-6 fw-semibold text-gray-600">
                                                        @php
                                                            $orders = $params['item']->orders()->paginate(20);
                                                        @endphp
                                                        @foreach ($orders as $item)
                                                            <tr>
                                                                <td>
                                                                    <a href="#"
                                                                        class="text-gray-600 text-hover-primary">OR-{{ $item->id }}</a>
                                                                </td>
                                                                <td class="text-success fw-bold">
                                                                    {{ number_format($item->total, 0, ',', '.') }} vnd</td>
                                                                <td class="text-warning">
                                                                    {{ number_format($item->subtotal, 0, ',', '.') }} vnd
                                                                </td>
                                                                <td class="text-danger">
                                                                    {{ number_format($item->shipping_fee, 0, ',', '.') }}
                                                                    vnd
                                                                </td>
                                                                <td>
                                                                    <span
                                                                        class="badge badge-light-info">{{ $item->status }}</span>
                                                                </td>
                                                                <td>
                                                                    <span
                                                                        class="badge badge-light-warning">{{ $item->payment_status }}</span>
                                                                </td>
                                                                <td>{{ $item->created_at }}</td>
                                                                <td class="text-end">
                                                                    <a href="{{ route($params['prefix'] . '.order-shop.show', $item->id) }}"
                                                                        class="btn btn-sm btn-light btn-active-light-primary">Detail</a>
                                                                </td>
                                                            </tr>
                                                        @endforeach

                                                    </tbody>
                                                </table>
                                                <div>
                                                    {{ $orders->links() }}
                                                </div>
                                                <!--end::Table-->
                                            </div>
                                            <!--end::Tab panel-->
                                            <!--begin::Tab panel-->
                                            <div id="kt_customer_details_invoices_2" class="py-0 tab-pane fade"
                                                role="tabpanel">
                                                <!--begin::Table-->
                                                <table id="kt_customer_details_invoices_table_2"
                                                    class="table align-middle table-row-dashed fs-6 fw-bold gy-5">
                                                    <thead
                                                        class="border-bottom border-gray-200 fs-7 text-uppercase fw-bold">
                                                        <tr class="text-start text-muted gs-0">
                                                            <th class="min-w-100px">Order ID</th>
                                                            <th class="min-w-100px">Amount</th>
                                                            <th class="min-w-100px">Status</th>
                                                            <th class="min-w-125px">Date</th>
                                                            <th class="min-w-100px text-end pe-7">Invoice</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="fs-6 fw-semibold text-gray-600">
                                                        <tr>
                                                            <td>
                                                                <a href="#"
                                                                    class="text-gray-600 text-hover-primary">523445943</a>
                                                            </td>
                                                            <td class="text-danger">$-1.30</td>
                                                            <td>
                                                                <span class="badge badge-light-warning">Pending</span>
                                                            </td>
                                                            <td>May 30, 2020</td>
                                                            <td class="text-end">
                                                                <button
                                                                    class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <a href="#"
                                                                    class="text-gray-600 text-hover-primary">231445943</a>
                                                            </td>
                                                            <td class="text-success">$204.00</td>
                                                            <td>
                                                                <span class="badge badge-light-success">Approved</span>
                                                            </td>
                                                            <td>Apr 22, 2020</td>
                                                            <td class="text-end">
                                                                <button
                                                                    class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <a href="#"
                                                                    class="text-gray-600 text-hover-primary">426445943</a>
                                                            </td>
                                                            <td class="text-success">$31.00</td>
                                                            <td>
                                                                <span class="badge badge-light-warning">Pending</span>
                                                            </td>
                                                            <td>Feb 09, 2020</td>
                                                            <td class="text-end">
                                                                <button
                                                                    class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <a href="#"
                                                                    class="text-gray-600 text-hover-primary">984445943</a>
                                                            </td>
                                                            <td class="text-success">$52.00</td>
                                                            <td>
                                                                <span class="badge badge-light-success">Approved</span>
                                                            </td>
                                                            <td>Nov 01, 2020</td>
                                                            <td class="text-end">
                                                                <button
                                                                    class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <a href="#"
                                                                    class="text-gray-600 text-hover-primary">324442313</a>
                                                            </td>
                                                            <td class="text-danger">$-0.80</td>
                                                            <td>
                                                                <span class="badge badge-light-success">Approved</span>
                                                            </td>
                                                            <td>Jan 04, 2020</td>
                                                            <td class="text-end">
                                                                <button
                                                                    class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <a href="#"
                                                                    class="text-gray-600 text-hover-primary">102445788</a>
                                                            </td>
                                                            <td class="text-success">$38.00</td>
                                                            <td>
                                                                <span class="badge badge-light-success">Approved</span>
                                                            </td>
                                                            <td>Nov 01, 2020</td>
                                                            <td class="text-end">
                                                                <button
                                                                    class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <a href="#"
                                                                    class="text-gray-600 text-hover-primary">423445721</a>
                                                            </td>
                                                            <td class="text-danger">$-2.60</td>
                                                            <td>
                                                                <span class="badge badge-light-warning">Pending</span>
                                                            </td>
                                                            <td>Oct 24, 2020</td>
                                                            <td class="text-end">
                                                                <button
                                                                    class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <a href="#"
                                                                    class="text-gray-600 text-hover-primary">312445984</a>
                                                            </td>
                                                            <td class="text-success">$76.00</td>
                                                            <td>
                                                                <span class="badge badge-light-danger">Rejected</span>
                                                            </td>
                                                            <td>Oct 08, 2020</td>
                                                            <td class="text-end">
                                                                <button
                                                                    class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <a href="#"
                                                                    class="text-gray-600 text-hover-primary">312445984</a>
                                                            </td>
                                                            <td class="text-success">$5.00</td>
                                                            <td>
                                                                <span class="badge badge-light-success">Approved</span>
                                                            </td>
                                                            <td>Sep 15, 2020</td>
                                                            <td class="text-end">
                                                                <button
                                                                    class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <!--end::Table-->
                                            </div>
                                            <!--end::Tab panel-->
                                            <!--begin::Tab panel-->
                                            <div id="kt_customer_details_invoices_3" class="py-0 tab-pane fade"
                                                role="tabpanel">
                                                <!--begin::Table-->
                                                <table id="kt_customer_details_invoices_table_3"
                                                    class="table align-middle table-row-dashed fs-6 fw-bold gy-5">
                                                    <thead
                                                        class="border-bottom border-gray-200 fs-7 text-uppercase fw-bold">
                                                        <tr class="text-start text-muted gs-0">
                                                            <th class="min-w-100px">Order ID</th>
                                                            <th class="min-w-100px">Amount</th>
                                                            <th class="min-w-100px">Status</th>
                                                            <th class="min-w-125px">Date</th>
                                                            <th class="min-w-100px text-end pe-7">Invoice</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="fs-6 fw-semibold text-gray-600">
                                                        <tr>
                                                            <td>
                                                                <a href="#"
                                                                    class="text-gray-600 text-hover-primary">426445943</a>
                                                            </td>
                                                            <td class="text-success">$31.00</td>
                                                            <td>
                                                                <span class="badge badge-light-success">Approved</span>
                                                            </td>
                                                            <td>Feb 09, 2020</td>
                                                            <td class="text-end">
                                                                <button
                                                                    class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <a href="#"
                                                                    class="text-gray-600 text-hover-primary">984445943</a>
                                                            </td>
                                                            <td class="text-success">$52.00</td>
                                                            <td>
                                                                <span class="badge badge-light-success">Approved</span>
                                                            </td>
                                                            <td>Nov 01, 2020</td>
                                                            <td class="text-end">
                                                                <button
                                                                    class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <a href="#"
                                                                    class="text-gray-600 text-hover-primary">324442313</a>
                                                            </td>
                                                            <td class="text-danger">$-0.80</td>
                                                            <td>
                                                                <span class="badge badge-light-warning">Pending</span>
                                                            </td>
                                                            <td>Jan 04, 2020</td>
                                                            <td class="text-end">
                                                                <button
                                                                    class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <a href="#"
                                                                    class="text-gray-600 text-hover-primary">312445984</a>
                                                            </td>
                                                            <td class="text-success">$5.00</td>
                                                            <td>
                                                                <span class="badge badge-light-warning">Pending</span>
                                                            </td>
                                                            <td>Sep 15, 2020</td>
                                                            <td class="text-end">
                                                                <button
                                                                    class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <a href="#"
                                                                    class="text-gray-600 text-hover-primary">102445788</a>
                                                            </td>
                                                            <td class="text-success">$38.00</td>
                                                            <td>
                                                                <span class="badge badge-light-info">In progress</span>
                                                            </td>
                                                            <td>Nov 01, 2020</td>
                                                            <td class="text-end">
                                                                <button
                                                                    class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <a href="#"
                                                                    class="text-gray-600 text-hover-primary">423445721</a>
                                                            </td>
                                                            <td class="text-danger">$-2.60</td>
                                                            <td>
                                                                <span class="badge badge-light-info">In progress</span>
                                                            </td>
                                                            <td>Oct 24, 2020</td>
                                                            <td class="text-end">
                                                                <button
                                                                    class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <a href="#"
                                                                    class="text-gray-600 text-hover-primary">312445984</a>
                                                            </td>
                                                            <td class="text-success">$76.00</td>
                                                            <td>
                                                                <span class="badge badge-light-danger">Rejected</span>
                                                            </td>
                                                            <td>Oct 08, 2020</td>
                                                            <td class="text-end">
                                                                <button
                                                                    class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <a href="#"
                                                                    class="text-gray-600 text-hover-primary">523445943</a>
                                                            </td>
                                                            <td class="text-danger">$-1.30</td>
                                                            <td>
                                                                <span class="badge badge-light-success">Approved</span>
                                                            </td>
                                                            <td>May 30, 2020</td>
                                                            <td class="text-end">
                                                                <button
                                                                    class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <a href="#"
                                                                    class="text-gray-600 text-hover-primary">231445943</a>
                                                            </td>
                                                            <td class="text-success">$204.00</td>
                                                            <td>
                                                                <span class="badge badge-light-info">In progress</span>
                                                            </td>
                                                            <td>Apr 22, 2020</td>
                                                            <td class="text-end">
                                                                <button
                                                                    class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <!--end::Table-->
                                            </div>
                                            <!--end::Tab panel-->
                                            <!--begin::Tab panel-->
                                            <div id="kt_customer_details_invoices_4" class="py-0 tab-pane fade"
                                                role="tabpanel">
                                                <!--begin::Table-->
                                                <table id="kt_customer_details_invoices_table_4"
                                                    class="table align-middle table-row-dashed fs-6 fw-bold gy-5">
                                                    <thead
                                                        class="border-bottom border-gray-200 fs-7 text-uppercase fw-bold">
                                                        <tr class="text-start text-muted gs-0">
                                                            <th class="min-w-100px">Order ID</th>
                                                            <th class="min-w-100px">Amount</th>
                                                            <th class="min-w-100px">Status</th>
                                                            <th class="min-w-125px">Date</th>
                                                            <th class="min-w-100px text-end pe-7">Invoice</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="fs-6 fw-semibold text-gray-600">
                                                        <tr>
                                                            <td>
                                                                <a href="#"
                                                                    class="text-gray-600 text-hover-primary">102445788</a>
                                                            </td>
                                                            <td class="text-success">$38.00</td>
                                                            <td>
                                                                <span class="badge badge-light-danger">Rejected</span>
                                                            </td>
                                                            <td>Nov 01, 2020</td>
                                                            <td class="text-end">
                                                                <button
                                                                    class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <a href="#"
                                                                    class="text-gray-600 text-hover-primary">423445721</a>
                                                            </td>
                                                            <td class="text-danger">$-2.60</td>
                                                            <td>
                                                                <span class="badge badge-light-success">Approved</span>
                                                            </td>
                                                            <td>Oct 24, 2020</td>
                                                            <td class="text-end">
                                                                <button
                                                                    class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <a href="#"
                                                                    class="text-gray-600 text-hover-primary">102445788</a>
                                                            </td>
                                                            <td class="text-success">$38.00</td>
                                                            <td>
                                                                <span class="badge badge-light-danger">Rejected</span>
                                                            </td>
                                                            <td>Nov 01, 2020</td>
                                                            <td class="text-end">
                                                                <button
                                                                    class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <a href="#"
                                                                    class="text-gray-600 text-hover-primary">423445721</a>
                                                            </td>
                                                            <td class="text-danger">$-2.60</td>
                                                            <td>
                                                                <span class="badge badge-light-danger">Rejected</span>
                                                            </td>
                                                            <td>Oct 24, 2020</td>
                                                            <td class="text-end">
                                                                <button
                                                                    class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <a href="#"
                                                                    class="text-gray-600 text-hover-primary">426445943</a>
                                                            </td>
                                                            <td class="text-success">$31.00</td>
                                                            <td>
                                                                <span class="badge badge-light-info">In progress</span>
                                                            </td>
                                                            <td>Feb 09, 2020</td>
                                                            <td class="text-end">
                                                                <button
                                                                    class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <a href="#"
                                                                    class="text-gray-600 text-hover-primary">984445943</a>
                                                            </td>
                                                            <td class="text-success">$52.00</td>
                                                            <td>
                                                                <span class="badge badge-light-warning">Pending</span>
                                                            </td>
                                                            <td>Nov 01, 2020</td>
                                                            <td class="text-end">
                                                                <button
                                                                    class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <a href="#"
                                                                    class="text-gray-600 text-hover-primary">324442313</a>
                                                            </td>
                                                            <td class="text-danger">$-0.80</td>
                                                            <td>
                                                                <span class="badge badge-light-success">Approved</span>
                                                            </td>
                                                            <td>Jan 04, 2020</td>
                                                            <td class="text-end">
                                                                <button
                                                                    class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <a href="#"
                                                                    class="text-gray-600 text-hover-primary">312445984</a>
                                                            </td>
                                                            <td class="text-success">$76.00</td>
                                                            <td>
                                                                <span class="badge badge-light-info">In progress</span>
                                                            </td>
                                                            <td>Oct 08, 2020</td>
                                                            <td class="text-end">
                                                                <button
                                                                    class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <a href="#"
                                                                    class="text-gray-600 text-hover-primary">312445984</a>
                                                            </td>
                                                            <td class="text-success">$76.00</td>
                                                            <td>
                                                                <span class="badge badge-light-danger">Rejected</span>
                                                            </td>
                                                            <td>Oct 08, 2020</td>
                                                            <td class="text-end">
                                                                <button
                                                                    class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <!--end::Table-->
                                            </div>
                                            <!--end::Tab panel-->
                                        </div>
                                        <!--end::Tab Content-->
                                    </div>
                                    <!--end::Card body-->
                                </div>
                                <!--end::Card-->
                            </div>
                            <!--end:::Tab pane-->
                            <!--begin:::Tab pane-->
                            <div class="tab-pane fade" id="kt_customer_view_overview_events_and_logs_tab"
                                role="tabpanel">
                                <!--begin::Card-->
                                <div class="card pt-4 mb-6 mb-xl-9">
                                    <!--begin::Card header-->
                                    <div class="card-header border-0">
                                        <!--begin::Card title-->
                                        <div class="card-title">
                                            <h2>Logs</h2>
                                        </div>
                                        <!--end::Card title-->
                                        <!--begin::Card toolbar-->
                                        <div class="card-toolbar">
                                            <!--begin::Button-->
                                            <button type="button" class="btn btn-sm btn-light-primary">
                                                <i class="ki-outline ki-cloud-download fs-3"></i>Download Report</button>
                                            <!--end::Button-->
                                        </div>
                                        <!--end::Card toolbar-->
                                    </div>
                                    <!--end::Card header-->
                                    <!--begin::Card body-->
                                    <div class="card-body py-0">
                                        <!--begin::Table wrapper-->
                                        <div class="table-responsive">
                                            <!--begin::Table-->
                                            <table
                                                class="table align-middle table-row-dashed fw-semibold text-gray-600 fs-6 gy-5"
                                                id="kt_table_customers_logs">
                                                <tbody>
                                                    <tr>
                                                        <td class="min-w-70px">
                                                            <div class="badge badge-light-success">200 OK</div>
                                                        </td>
                                                        <td>POST /v1/invoices/in_6834_7796/payment</td>
                                                        <td class="pe-0 text-end min-w-200px">25 Jul 2024, 6:05 pm</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="min-w-70px">
                                                            <div class="badge badge-light-success">200 OK</div>
                                                        </td>
                                                        <td>POST /v1/invoices/in_6834_7796/payment</td>
                                                        <td class="pe-0 text-end min-w-200px">25 Jul 2024, 6:43 am</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="min-w-70px">
                                                            <div class="badge badge-light-success">200 OK</div>
                                                        </td>
                                                        <td>POST /v1/invoices/in_8147_4776/payment</td>
                                                        <td class="pe-0 text-end min-w-200px">05 May 2024, 8:43 pm</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="min-w-70px">
                                                            <div class="badge badge-light-warning">404 WRN</div>
                                                        </td>
                                                        <td>POST /v1/customer/c_66782a637f52b/not_found</td>
                                                        <td class="pe-0 text-end min-w-200px">10 Mar 2024, 2:40 pm</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="min-w-70px">
                                                            <div class="badge badge-light-warning">404 WRN</div>
                                                        </td>
                                                        <td>POST /v1/customer/c_66782a637f52c/not_found</td>
                                                        <td class="pe-0 text-end min-w-200px">21 Feb 2024, 11:30 am</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="min-w-70px">
                                                            <div class="badge badge-light-success">200 OK</div>
                                                        </td>
                                                        <td>POST /v1/invoices/in_6834_7796/payment</td>
                                                        <td class="pe-0 text-end min-w-200px">10 Nov 2024, 10:30 am</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="min-w-70px">
                                                            <div class="badge badge-light-success">200 OK</div>
                                                        </td>
                                                        <td>POST /v1/invoices/in_9670_7311/payment</td>
                                                        <td class="pe-0 text-end min-w-200px">20 Jun 2024, 5:20 pm</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="min-w-70px">
                                                            <div class="badge badge-light-success">200 OK</div>
                                                        </td>
                                                        <td>POST /v1/invoices/in_6528_7646/payment</td>
                                                        <td class="pe-0 text-end min-w-200px">22 Sep 2024, 10:30 am</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="min-w-70px">
                                                            <div class="badge badge-light-warning">404 WRN</div>
                                                        </td>
                                                        <td>POST /v1/customer/c_66782a637f52b/not_found</td>
                                                        <td class="pe-0 text-end min-w-200px">20 Jun 2024, 6:43 am</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="min-w-70px">
                                                            <div class="badge badge-light-success">200 OK</div>
                                                        </td>
                                                        <td>POST /v1/invoices/in_2704_4692/payment</td>
                                                        <td class="pe-0 text-end min-w-200px">24 Jun 2024, 10:10 pm</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <!--end::Table wrapper-->
                                    </div>
                                    <!--end::Card body-->
                                </div>
                                <!--end::Card-->
                                <!--begin::Card-->
                                <div class="card pt-4 mb-6 mb-xl-9">
                                    <!--begin::Card header-->
                                    <div class="card-header border-0">
                                        <!--begin::Card title-->
                                        <div class="card-title">
                                            <h2>Events</h2>
                                        </div>
                                        <!--end::Card title-->
                                        <!--begin::Card toolbar-->
                                        <div class="card-toolbar">
                                            <!--begin::Button-->
                                            <button type="button" class="btn btn-sm btn-light-primary">
                                                <i class="ki-outline ki-cloud-download fs-3"></i>Download Report</button>
                                            <!--end::Button-->
                                        </div>
                                        <!--end::Card toolbar-->
                                    </div>
                                    <!--end::Card header-->
                                    <!--begin::Card body-->
                                    <div class="card-body py-0">
                                        <!--begin::Table-->
                                        <table
                                            class="table align-middle table-row-dashed fs-6 text-gray-600 fw-semibold gy-5"
                                            id="kt_table_customers_events">
                                            <tbody>
                                                <tr>
                                                    <td class="min-w-400px">Invoice
                                                        <a href="#"
                                                            class="fw-bold text-gray-900 text-hover-primary me-1">#WER-45670</a>is
                                                        <span class="badge badge-light-info">In Progress</span>
                                                    </td>
                                                    <td class="pe-0 text-gray-600 text-end min-w-200px">19 Aug 2024, 10:30
                                                        am</td>
                                                </tr>
                                                <tr>
                                                    <td class="min-w-400px">
                                                        <a href="#"
                                                            class="text-gray-600 text-hover-primary me-1">Brian Cox</a>has
                                                        made payment to
                                                        <a href="#"
                                                            class="fw-bold text-gray-900 text-hover-primary">#OLP-45690</a>
                                                    </td>
                                                    <td class="pe-0 text-gray-600 text-end min-w-200px">15 Apr 2024, 5:20
                                                        pm</td>
                                                </tr>
                                                <tr>
                                                    <td class="min-w-400px">
                                                        <a href="#"
                                                            class="text-gray-600 text-hover-primary me-1">Max Smith</a>has
                                                        made payment to
                                                        <a href="#"
                                                            class="fw-bold text-gray-900 text-hover-primary">#SDK-45670</a>
                                                    </td>
                                                    <td class="pe-0 text-gray-600 text-end min-w-200px">05 May 2024, 11:05
                                                        am</td>
                                                </tr>
                                                <tr>
                                                    <td class="min-w-400px">Invoice
                                                        <a href="#"
                                                            class="fw-bold text-gray-900 text-hover-primary me-1">#DER-45645</a>status
                                                        has changed from
                                                        <span class="badge badge-light-info me-1">In Progress</span>to
                                                        <span class="badge badge-light-primary">In Transit</span>
                                                    </td>
                                                    <td class="pe-0 text-gray-600 text-end min-w-200px">25 Jul 2024, 5:30
                                                        pm</td>
                                                </tr>
                                                <tr>
                                                    <td class="min-w-400px">
                                                        <a href="#"
                                                            class="text-gray-600 text-hover-primary me-1">Brian Cox</a>has
                                                        made payment to
                                                        <a href="#"
                                                            class="fw-bold text-gray-900 text-hover-primary">#OLP-45690</a>
                                                    </td>
                                                    <td class="pe-0 text-gray-600 text-end min-w-200px">25 Jul 2024, 2:40
                                                        pm</td>
                                                </tr>
                                                <tr>
                                                    <td class="min-w-400px">
                                                        <a href="#"
                                                            class="text-gray-600 text-hover-primary me-1">Melody
                                                            Macy</a>has made payment to
                                                        <a href="#"
                                                            class="fw-bold text-gray-900 text-hover-primary">#XRS-45670</a>
                                                    </td>
                                                    <td class="pe-0 text-gray-600 text-end min-w-200px">15 Apr 2024, 11:30
                                                        am</td>
                                                </tr>
                                                <tr>
                                                    <td class="min-w-400px">Invoice
                                                        <a href="#"
                                                            class="fw-bold text-gray-900 text-hover-primary me-1">#LOP-45640</a>has
                                                        been
                                                        <span class="badge badge-light-danger">Declined</span>
                                                    </td>
                                                    <td class="pe-0 text-gray-600 text-end min-w-200px">05 May 2024, 11:30
                                                        am</td>
                                                </tr>
                                                <tr>
                                                    <td class="min-w-400px">
                                                        <a href="#"
                                                            class="text-gray-600 text-hover-primary me-1">Sean Bean</a>has
                                                        made payment to
                                                        <a href="#"
                                                            class="fw-bold text-gray-900 text-hover-primary">#XRS-45670</a>
                                                    </td>
                                                    <td class="pe-0 text-gray-600 text-end min-w-200px">25 Oct 2024, 5:30
                                                        pm</td>
                                                </tr>
                                                <tr>
                                                    <td class="min-w-400px">Invoice
                                                        <a href="#"
                                                            class="fw-bold text-gray-900 text-hover-primary me-1">#LOP-45640</a>has
                                                        been
                                                        <span class="badge badge-light-danger">Declined</span>
                                                    </td>
                                                    <td class="pe-0 text-gray-600 text-end min-w-200px">20 Jun 2024, 6:05
                                                        pm</td>
                                                </tr>
                                                <tr>
                                                    <td class="min-w-400px">Invoice
                                                        <a href="#"
                                                            class="fw-bold text-gray-900 text-hover-primary me-1">#KIO-45656</a>status
                                                        has changed from
                                                        <span class="badge badge-light-succees me-1">In Transit</span>to
                                                        <span class="badge badge-light-success">Approved</span>
                                                    </td>
                                                    <td class="pe-0 text-gray-600 text-end min-w-200px">10 Nov 2024, 10:10
                                                        pm</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <!--end::Table-->
                                    </div>
                                    <!--end::Card body-->
                                </div>
                                <!--end::Card-->
                            </div>
                            <!--end:::Tab pane-->
                            <!--begin:::Tab pane-->
                            <div class="tab-pane fade" id="kt_customer_view_overview_statements" role="tabpanel">
                                <!--begin::Earnings-->
                                <div class="card mb-6 mb-xl-9">
                                    <!--begin::Header-->
                                    <div class="card-header border-0">
                                        <div class="card-title">
                                            <h2>Earnings</h2>
                                        </div>
                                    </div>
                                    <!--end::Header-->
                                    <!--begin::Body-->
                                    <div class="card-body py-0">
                                        <div class="fs-5 fw-semibold text-gray-500 mb-4">Last 30 day earnings calculated.
                                            Apart from arranging the order of topics.</div>
                                        <!--begin::Left Section-->
                                        <div class="d-flex flex-wrap flex-stack mb-5">
                                            <!--begin::Row-->
                                            <div class="d-flex flex-wrap">
                                                <!--begin::Col-->
                                                <div
                                                    class="border border-dashed border-gray-300 w-150px rounded my-3 p-4 me-6">
                                                    <span class="fs-1 fw-bold text-gray-800 lh-1">
                                                        <span data-kt-countup="true" data-kt-countup-value="6,840"
                                                            data-kt-countup-prefix="$">0</span>
                                                        <i class="ki-outline ki-arrow-up fs-1 text-success"></i>
                                                    </span>
                                                    <span class="fs-6 fw-semibold text-muted d-block lh-1 pt-2">Net
                                                        Earnings</span>
                                                </div>
                                                <!--end::Col-->
                                                <!--begin::Col-->
                                                <div
                                                    class="border border-dashed border-gray-300 w-125px rounded my-3 p-4 me-6">
                                                    <span class="fs-1 fw-bold text-gray-800 lh-1">
                                                        <span class="" data-kt-countup="true"
                                                            data-kt-countup-value="16">0</span>%
                                                        <i class="ki-outline ki-arrow-down fs-1 text-danger"></i></span>
                                                    <span
                                                        class="fs-6 fw-semibold text-muted d-block lh-1 pt-2">Change</span>
                                                </div>
                                                <!--end::Col-->
                                                <!--begin::Col-->
                                                <div
                                                    class="border border-dashed border-gray-300 w-150px rounded my-3 p-4 me-6">
                                                    <span class="fs-1 fw-bold text-gray-800 lh-1">
                                                        <span data-kt-countup="true" data-kt-countup-value="1,240"
                                                            data-kt-countup-prefix="$">0</span>
                                                        <span class="text-primary">--</span>
                                                    </span>
                                                    <span class="fs-6 fw-semibold text-muted d-block lh-1 pt-2">Fees</span>
                                                </div>
                                                <!--end::Col-->
                                            </div>
                                            <!--end::Row-->
                                            <a href="#" class="btn btn-sm btn-light-primary flex-shrink-0">Withdraw
                                                Earnings</a>
                                        </div>
                                        <!--end::Left Section-->
                                    </div>
                                    <!--end::Body-->
                                </div>
                                <!--end::Earnings-->
                                <!--begin::Statements-->
                                <div class="card mb-6 mb-xl-9">
                                    <!--begin::Header-->
                                    <div class="card-header">
                                        <!--begin::Title-->
                                        <div class="card-title">
                                            <h2>Statement</h2>
                                        </div>
                                        <!--end::Title-->
                                        <!--begin::Toolbar-->
                                        <div class="card-toolbar">
                                            <!--begin::Tab nav-->
                                            <ul class="nav nav-stretch fs-5 fw-semibold nav-line-tabs nav-line-tabs-2x border-transparent"
                                                role="tablist">
                                                <li class="nav-item" role="presentation">
                                                    <a class="nav-link text-active-primary active" data-bs-toggle="tab"
                                                        role="tab" href="#kt_customer_view_statement_1">This
                                                        Year</a>
                                                </li>
                                                <li class="nav-item" role="presentation">
                                                    <a class="nav-link text-active-primary ms-3" data-bs-toggle="tab"
                                                        role="tab" href="#kt_customer_view_statement_2">2020</a>
                                                </li>
                                                <li class="nav-item" role="presentation">
                                                    <a class="nav-link text-active-primary ms-3" data-bs-toggle="tab"
                                                        role="tab" href="#kt_customer_view_statement_3">2019</a>
                                                </li>
                                                <li class="nav-item" role="presentation">
                                                    <a class="nav-link text-active-primary ms-3" data-bs-toggle="tab"
                                                        role="tab" href="#kt_customer_view_statement_4">2018</a>
                                                </li>
                                            </ul>
                                            <!--end::Tab nav-->
                                        </div>
                                        <!--end::Toolbar-->
                                    </div>
                                    <!--end::Header-->
                                    <!--begin::Card body-->
                                    <div class="card-body pb-5">
                                        <!--begin::Tab Content-->
                                        <div id="kt_customer_view_statement_tab_content" class="tab-content">
                                            <!--begin::Tab panel-->
                                            <div id="kt_customer_view_statement_1" class="py-0 tab-pane fade show active"
                                                role="tabpanel">
                                                <!--begin::Table-->
                                                <table id="kt_customer_view_statement_table_1"
                                                    class="table align-middle table-row-dashed fs-6 text-gray-600 fw-semibold gy-4">
                                                    <thead class="border-bottom border-gray-200">
                                                        <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                                                            <th class="w-125px">Date</th>
                                                            <th class="w-100px">Order ID</th>
                                                            <th class="w-300px">Details</th>
                                                            <th class="w-100px">Amount</th>
                                                            <th class="w-100px text-end pe-7">Invoice</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>Nov 01, 2021</td>
                                                            <td>
                                                                <a href="#"
                                                                    class="text-gray-600 text-hover-primary">102445788</a>
                                                            </td>
                                                            <td>Darknight transparency 36 Icons Pack</td>
                                                            <td class="text-success">$38.00</td>
                                                            <td class="text-end">
                                                                <button
                                                                    class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Oct 24, 2021</td>
                                                            <td>
                                                                <a href="#"
                                                                    class="text-gray-600 text-hover-primary">423445721</a>
                                                            </td>
                                                            <td>Seller Fee</td>
                                                            <td class="text-danger">$-2.60</td>
                                                            <td class="text-end">
                                                                <button
                                                                    class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Oct 08, 2021</td>
                                                            <td>
                                                                <a href="#"
                                                                    class="text-gray-600 text-hover-primary">312445984</a>
                                                            </td>
                                                            <td>Cartoon Mobile Emoji Phone Pack</td>
                                                            <td class="text-success">$76.00</td>
                                                            <td class="text-end">
                                                                <button
                                                                    class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Sep 15, 2021</td>
                                                            <td>
                                                                <a href="#"
                                                                    class="text-gray-600 text-hover-primary">312445984</a>
                                                            </td>
                                                            <td>Iphone 12 Pro Mockup Mega Bundle</td>
                                                            <td class="text-success">$5.00</td>
                                                            <td class="text-end">
                                                                <button
                                                                    class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>May 30, 2021</td>
                                                            <td>
                                                                <a href="#"
                                                                    class="text-gray-600 text-hover-primary">523445943</a>
                                                            </td>
                                                            <td>Seller Fee</td>
                                                            <td class="text-danger">$-1.30</td>
                                                            <td class="text-end">
                                                                <button
                                                                    class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Apr 22, 2021</td>
                                                            <td>
                                                                <a href="#"
                                                                    class="text-gray-600 text-hover-primary">231445943</a>
                                                            </td>
                                                            <td>Parcel Shipping / Delivery Service App</td>
                                                            <td class="text-success">$204.00</td>
                                                            <td class="text-end">
                                                                <button
                                                                    class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Feb 09, 2021</td>
                                                            <td>
                                                                <a href="#"
                                                                    class="text-gray-600 text-hover-primary">426445943</a>
                                                            </td>
                                                            <td>Visual Design Illustration</td>
                                                            <td class="text-success">$31.00</td>
                                                            <td class="text-end">
                                                                <button
                                                                    class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Nov 01, 2021</td>
                                                            <td>
                                                                <a href="#"
                                                                    class="text-gray-600 text-hover-primary">984445943</a>
                                                            </td>
                                                            <td>Abstract Vusial Pack</td>
                                                            <td class="text-success">$52.00</td>
                                                            <td class="text-end">
                                                                <button
                                                                    class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Jan 04, 2021</td>
                                                            <td>
                                                                <a href="#"
                                                                    class="text-gray-600 text-hover-primary">324442313</a>
                                                            </td>
                                                            <td>Seller Fee</td>
                                                            <td class="text-danger">$-0.80</td>
                                                            <td class="text-end">
                                                                <button
                                                                    class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Nov 01, 2021</td>
                                                            <td>
                                                                <a href="#"
                                                                    class="text-gray-600 text-hover-primary">102445788</a>
                                                            </td>
                                                            <td>Darknight transparency 36 Icons Pack</td>
                                                            <td class="text-success">$38.00</td>
                                                            <td class="text-end">
                                                                <button
                                                                    class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Oct 24, 2021</td>
                                                            <td>
                                                                <a href="#"
                                                                    class="text-gray-600 text-hover-primary">423445721</a>
                                                            </td>
                                                            <td>Seller Fee</td>
                                                            <td class="text-danger">$-2.60</td>
                                                            <td class="text-end">
                                                                <button
                                                                    class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Oct 08, 2021</td>
                                                            <td>
                                                                <a href="#"
                                                                    class="text-gray-600 text-hover-primary">312445984</a>
                                                            </td>
                                                            <td>Cartoon Mobile Emoji Phone Pack</td>
                                                            <td class="text-success">$76.00</td>
                                                            <td class="text-end">
                                                                <button
                                                                    class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Sep 15, 2021</td>
                                                            <td>
                                                                <a href="#"
                                                                    class="text-gray-600 text-hover-primary">312445984</a>
                                                            </td>
                                                            <td>Iphone 12 Pro Mockup Mega Bundle</td>
                                                            <td class="text-success">$5.00</td>
                                                            <td class="text-end">
                                                                <button
                                                                    class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>May 30, 2021</td>
                                                            <td>
                                                                <a href="#"
                                                                    class="text-gray-600 text-hover-primary">523445943</a>
                                                            </td>
                                                            <td>Seller Fee</td>
                                                            <td class="text-danger">$-1.30</td>
                                                            <td class="text-end">
                                                                <button
                                                                    class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Apr 22, 2021</td>
                                                            <td>
                                                                <a href="#"
                                                                    class="text-gray-600 text-hover-primary">231445943</a>
                                                            </td>
                                                            <td>Parcel Shipping / Delivery Service App</td>
                                                            <td class="text-success">$204.00</td>
                                                            <td class="text-end">
                                                                <button
                                                                    class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Feb 09, 2021</td>
                                                            <td>
                                                                <a href="#"
                                                                    class="text-gray-600 text-hover-primary">426445943</a>
                                                            </td>
                                                            <td>Visual Design Illustration</td>
                                                            <td class="text-success">$31.00</td>
                                                            <td class="text-end">
                                                                <button
                                                                    class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Nov 01, 2021</td>
                                                            <td>
                                                                <a href="#"
                                                                    class="text-gray-600 text-hover-primary">984445943</a>
                                                            </td>
                                                            <td>Abstract Vusial Pack</td>
                                                            <td class="text-success">$52.00</td>
                                                            <td class="text-end">
                                                                <button
                                                                    class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Jan 04, 2021</td>
                                                            <td>
                                                                <a href="#"
                                                                    class="text-gray-600 text-hover-primary">324442313</a>
                                                            </td>
                                                            <td>Seller Fee</td>
                                                            <td class="text-danger">$-0.80</td>
                                                            <td class="text-end">
                                                                <button
                                                                    class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <!--end::Table-->
                                            </div>
                                            <!--end::Tab panel-->
                                            <!--begin::Tab panel-->
                                            <div id="kt_customer_view_statement_2" class="py-0 tab-pane fade"
                                                role="tabpanel">
                                                <!--begin::Table-->
                                                <table id="kt_customer_view_statement_table_2"
                                                    class="table align-middle table-row-dashed fs-6 text-gray-600 fw-semibold gy-4">
                                                    <thead class="border-bottom border-gray-200">
                                                        <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                                                            <th class="w-125px">Date</th>
                                                            <th class="w-100px">Order ID</th>
                                                            <th class="w-300px">Details</th>
                                                            <th class="w-100px">Amount</th>
                                                            <th class="w-100px text-end pe-7">Invoice</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>May 30, 2020</td>
                                                            <td>
                                                                <a href="#"
                                                                    class="text-gray-600 text-hover-primary">523445943</a>
                                                            </td>
                                                            <td>Seller Fee</td>
                                                            <td class="text-danger">$-1.30</td>
                                                            <td class="text-end">
                                                                <button
                                                                    class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Apr 22, 2020</td>
                                                            <td>
                                                                <a href="#"
                                                                    class="text-gray-600 text-hover-primary">231445943</a>
                                                            </td>
                                                            <td>Parcel Shipping / Delivery Service App</td>
                                                            <td class="text-success">$204.00</td>
                                                            <td class="text-end">
                                                                <button
                                                                    class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Feb 09, 2020</td>
                                                            <td>
                                                                <a href="#"
                                                                    class="text-gray-600 text-hover-primary">426445943</a>
                                                            </td>
                                                            <td>Visual Design Illustration</td>
                                                            <td class="text-success">$31.00</td>
                                                            <td class="text-end">
                                                                <button
                                                                    class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Nov 01, 2020</td>
                                                            <td>
                                                                <a href="#"
                                                                    class="text-gray-600 text-hover-primary">984445943</a>
                                                            </td>
                                                            <td>Abstract Vusial Pack</td>
                                                            <td class="text-success">$52.00</td>
                                                            <td class="text-end">
                                                                <button
                                                                    class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Jan 04, 2020</td>
                                                            <td>
                                                                <a href="#"
                                                                    class="text-gray-600 text-hover-primary">324442313</a>
                                                            </td>
                                                            <td>Seller Fee</td>
                                                            <td class="text-danger">$-0.80</td>
                                                            <td class="text-end">
                                                                <button
                                                                    class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Nov 01, 2020</td>
                                                            <td>
                                                                <a href="#"
                                                                    class="text-gray-600 text-hover-primary">102445788</a>
                                                            </td>
                                                            <td>Darknight transparency 36 Icons Pack</td>
                                                            <td class="text-success">$38.00</td>
                                                            <td class="text-end">
                                                                <button
                                                                    class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Oct 24, 2020</td>
                                                            <td>
                                                                <a href="#"
                                                                    class="text-gray-600 text-hover-primary">423445721</a>
                                                            </td>
                                                            <td>Seller Fee</td>
                                                            <td class="text-danger">$-2.60</td>
                                                            <td class="text-end">
                                                                <button
                                                                    class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Oct 08, 2020</td>
                                                            <td>
                                                                <a href="#"
                                                                    class="text-gray-600 text-hover-primary">312445984</a>
                                                            </td>
                                                            <td>Cartoon Mobile Emoji Phone Pack</td>
                                                            <td class="text-success">$76.00</td>
                                                            <td class="text-end">
                                                                <button
                                                                    class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Sep 15, 2020</td>
                                                            <td>
                                                                <a href="#"
                                                                    class="text-gray-600 text-hover-primary">312445984</a>
                                                            </td>
                                                            <td>Iphone 12 Pro Mockup Mega Bundle</td>
                                                            <td class="text-success">$5.00</td>
                                                            <td class="text-end">
                                                                <button
                                                                    class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>May 30, 2020</td>
                                                            <td>
                                                                <a href="#"
                                                                    class="text-gray-600 text-hover-primary">523445943</a>
                                                            </td>
                                                            <td>Seller Fee</td>
                                                            <td class="text-danger">$-1.30</td>
                                                            <td class="text-end">
                                                                <button
                                                                    class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Apr 22, 2020</td>
                                                            <td>
                                                                <a href="#"
                                                                    class="text-gray-600 text-hover-primary">231445943</a>
                                                            </td>
                                                            <td>Parcel Shipping / Delivery Service App</td>
                                                            <td class="text-success">$204.00</td>
                                                            <td class="text-end">
                                                                <button
                                                                    class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Feb 09, 2020</td>
                                                            <td>
                                                                <a href="#"
                                                                    class="text-gray-600 text-hover-primary">426445943</a>
                                                            </td>
                                                            <td>Visual Design Illustration</td>
                                                            <td class="text-success">$31.00</td>
                                                            <td class="text-end">
                                                                <button
                                                                    class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Nov 01, 2020</td>
                                                            <td>
                                                                <a href="#"
                                                                    class="text-gray-600 text-hover-primary">984445943</a>
                                                            </td>
                                                            <td>Abstract Vusial Pack</td>
                                                            <td class="text-success">$52.00</td>
                                                            <td class="text-end">
                                                                <button
                                                                    class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Jan 04, 2020</td>
                                                            <td>
                                                                <a href="#"
                                                                    class="text-gray-600 text-hover-primary">324442313</a>
                                                            </td>
                                                            <td>Seller Fee</td>
                                                            <td class="text-danger">$-0.80</td>
                                                            <td class="text-end">
                                                                <button
                                                                    class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Nov 01, 2020</td>
                                                            <td>
                                                                <a href="#"
                                                                    class="text-gray-600 text-hover-primary">102445788</a>
                                                            </td>
                                                            <td>Darknight transparency 36 Icons Pack</td>
                                                            <td class="text-success">$38.00</td>
                                                            <td class="text-end">
                                                                <button
                                                                    class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Oct 24, 2020</td>
                                                            <td>
                                                                <a href="#"
                                                                    class="text-gray-600 text-hover-primary">423445721</a>
                                                            </td>
                                                            <td>Seller Fee</td>
                                                            <td class="text-danger">$-2.60</td>
                                                            <td class="text-end">
                                                                <button
                                                                    class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Oct 08, 2020</td>
                                                            <td>
                                                                <a href="#"
                                                                    class="text-gray-600 text-hover-primary">312445984</a>
                                                            </td>
                                                            <td>Cartoon Mobile Emoji Phone Pack</td>
                                                            <td class="text-success">$76.00</td>
                                                            <td class="text-end">
                                                                <button
                                                                    class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Sep 15, 2020</td>
                                                            <td>
                                                                <a href="#"
                                                                    class="text-gray-600 text-hover-primary">312445984</a>
                                                            </td>
                                                            <td>Iphone 12 Pro Mockup Mega Bundle</td>
                                                            <td class="text-success">$5.00</td>
                                                            <td class="text-end">
                                                                <button
                                                                    class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <!--end::Table-->
                                            </div>
                                            <!--end::Tab panel-->
                                            <!--begin::Tab panel-->
                                            <div id="kt_customer_view_statement_3" class="py-0 tab-pane fade"
                                                role="tabpanel">
                                                <!--begin::Table-->
                                                <table id="kt_customer_view_statement_table_3"
                                                    class="table align-middle table-row-dashed fs-6 text-gray-600 fw-semibold gy-4">
                                                    <thead class="border-bottom border-gray-200">
                                                        <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                                                            <th class="w-125px">Date</th>
                                                            <th class="w-100px">Order ID</th>
                                                            <th class="w-300px">Details</th>
                                                            <th class="w-100px">Amount</th>
                                                            <th class="w-100px text-end pe-7">Invoice</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>Feb 09, 2019</td>
                                                            <td>
                                                                <a href="#"
                                                                    class="text-gray-600 text-hover-primary">426445943</a>
                                                            </td>
                                                            <td>Visual Design Illustration</td>
                                                            <td class="text-success">$31.00</td>
                                                            <td class="text-end">
                                                                <button
                                                                    class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Nov 01, 2019</td>
                                                            <td>
                                                                <a href="#"
                                                                    class="text-gray-600 text-hover-primary">984445943</a>
                                                            </td>
                                                            <td>Abstract Vusial Pack</td>
                                                            <td class="text-success">$52.00</td>
                                                            <td class="text-end">
                                                                <button
                                                                    class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Jan 04, 2019</td>
                                                            <td>
                                                                <a href="#"
                                                                    class="text-gray-600 text-hover-primary">324442313</a>
                                                            </td>
                                                            <td>Seller Fee</td>
                                                            <td class="text-danger">$-0.80</td>
                                                            <td class="text-end">
                                                                <button
                                                                    class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Sep 15, 2019</td>
                                                            <td>
                                                                <a href="#"
                                                                    class="text-gray-600 text-hover-primary">312445984</a>
                                                            </td>
                                                            <td>Iphone 12 Pro Mockup Mega Bundle</td>
                                                            <td class="text-success">$5.00</td>
                                                            <td class="text-end">
                                                                <button
                                                                    class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Nov 01, 2019</td>
                                                            <td>
                                                                <a href="#"
                                                                    class="text-gray-600 text-hover-primary">102445788</a>
                                                            </td>
                                                            <td>Darknight transparency 36 Icons Pack</td>
                                                            <td class="text-success">$38.00</td>
                                                            <td class="text-end">
                                                                <button
                                                                    class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Oct 24, 2019</td>
                                                            <td>
                                                                <a href="#"
                                                                    class="text-gray-600 text-hover-primary">423445721</a>
                                                            </td>
                                                            <td>Seller Fee</td>
                                                            <td class="text-danger">$-2.60</td>
                                                            <td class="text-end">
                                                                <button
                                                                    class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Oct 08, 2019</td>
                                                            <td>
                                                                <a href="#"
                                                                    class="text-gray-600 text-hover-primary">312445984</a>
                                                            </td>
                                                            <td>Cartoon Mobile Emoji Phone Pack</td>
                                                            <td class="text-success">$76.00</td>
                                                            <td class="text-end">
                                                                <button
                                                                    class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>May 30, 2019</td>
                                                            <td>
                                                                <a href="#"
                                                                    class="text-gray-600 text-hover-primary">523445943</a>
                                                            </td>
                                                            <td>Seller Fee</td>
                                                            <td class="text-danger">$-1.30</td>
                                                            <td class="text-end">
                                                                <button
                                                                    class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Apr 22, 2019</td>
                                                            <td>
                                                                <a href="#"
                                                                    class="text-gray-600 text-hover-primary">231445943</a>
                                                            </td>
                                                            <td>Parcel Shipping / Delivery Service App</td>
                                                            <td class="text-success">$204.00</td>
                                                            <td class="text-end">
                                                                <button
                                                                    class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Feb 09, 2019</td>
                                                            <td>
                                                                <a href="#"
                                                                    class="text-gray-600 text-hover-primary">426445943</a>
                                                            </td>
                                                            <td>Visual Design Illustration</td>
                                                            <td class="text-success">$31.00</td>
                                                            <td class="text-end">
                                                                <button
                                                                    class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Nov 01, 2019</td>
                                                            <td>
                                                                <a href="#"
                                                                    class="text-gray-600 text-hover-primary">984445943</a>
                                                            </td>
                                                            <td>Abstract Vusial Pack</td>
                                                            <td class="text-success">$52.00</td>
                                                            <td class="text-end">
                                                                <button
                                                                    class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Jan 04, 2019</td>
                                                            <td>
                                                                <a href="#"
                                                                    class="text-gray-600 text-hover-primary">324442313</a>
                                                            </td>
                                                            <td>Seller Fee</td>
                                                            <td class="text-danger">$-0.80</td>
                                                            <td class="text-end">
                                                                <button
                                                                    class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Sep 15, 2019</td>
                                                            <td>
                                                                <a href="#"
                                                                    class="text-gray-600 text-hover-primary">312445984</a>
                                                            </td>
                                                            <td>Iphone 12 Pro Mockup Mega Bundle</td>
                                                            <td class="text-success">$5.00</td>
                                                            <td class="text-end">
                                                                <button
                                                                    class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Nov 01, 2019</td>
                                                            <td>
                                                                <a href="#"
                                                                    class="text-gray-600 text-hover-primary">102445788</a>
                                                            </td>
                                                            <td>Darknight transparency 36 Icons Pack</td>
                                                            <td class="text-success">$38.00</td>
                                                            <td class="text-end">
                                                                <button
                                                                    class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Oct 24, 2019</td>
                                                            <td>
                                                                <a href="#"
                                                                    class="text-gray-600 text-hover-primary">423445721</a>
                                                            </td>
                                                            <td>Seller Fee</td>
                                                            <td class="text-danger">$-2.60</td>
                                                            <td class="text-end">
                                                                <button
                                                                    class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Oct 08, 2019</td>
                                                            <td>
                                                                <a href="#"
                                                                    class="text-gray-600 text-hover-primary">312445984</a>
                                                            </td>
                                                            <td>Cartoon Mobile Emoji Phone Pack</td>
                                                            <td class="text-success">$76.00</td>
                                                            <td class="text-end">
                                                                <button
                                                                    class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>May 30, 2019</td>
                                                            <td>
                                                                <a href="#"
                                                                    class="text-gray-600 text-hover-primary">523445943</a>
                                                            </td>
                                                            <td>Seller Fee</td>
                                                            <td class="text-danger">$-1.30</td>
                                                            <td class="text-end">
                                                                <button
                                                                    class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Apr 22, 2019</td>
                                                            <td>
                                                                <a href="#"
                                                                    class="text-gray-600 text-hover-primary">231445943</a>
                                                            </td>
                                                            <td>Parcel Shipping / Delivery Service App</td>
                                                            <td class="text-success">$204.00</td>
                                                            <td class="text-end">
                                                                <button
                                                                    class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <!--end::Table-->
                                            </div>
                                            <!--end::Tab panel-->
                                            <!--begin::Tab panel-->
                                            <div id="kt_customer_view_statement_4" class="py-0 tab-pane fade"
                                                role="tabpanel">
                                                <!--begin::Table-->
                                                <table id="kt_customer_view_statement_table_4"
                                                    class="table align-middle table-row-dashed fs-6 text-gray-600 fw-semibold gy-4">
                                                    <thead class="border-bottom border-gray-200">
                                                        <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                                                            <th class="w-125px">Date</th>
                                                            <th class="w-100px">Order ID</th>
                                                            <th class="w-300px">Details</th>
                                                            <th class="w-100px">Amount</th>
                                                            <th class="w-100px text-end pe-7">Invoice</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>Nov 01, 2018</td>
                                                            <td>
                                                                <a href="#"
                                                                    class="text-gray-600 text-hover-primary">102445788</a>
                                                            </td>
                                                            <td>Darknight transparency 36 Icons Pack</td>
                                                            <td class="text-success">$38.00</td>
                                                            <td class="text-end">
                                                                <button
                                                                    class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Oct 24, 2018</td>
                                                            <td>
                                                                <a href="#"
                                                                    class="text-gray-600 text-hover-primary">423445721</a>
                                                            </td>
                                                            <td>Seller Fee</td>
                                                            <td class="text-danger">$-2.60</td>
                                                            <td class="text-end">
                                                                <button
                                                                    class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Nov 01, 2018</td>
                                                            <td>
                                                                <a href="#"
                                                                    class="text-gray-600 text-hover-primary">102445788</a>
                                                            </td>
                                                            <td>Darknight transparency 36 Icons Pack</td>
                                                            <td class="text-success">$38.00</td>
                                                            <td class="text-end">
                                                                <button
                                                                    class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Oct 24, 2018</td>
                                                            <td>
                                                                <a href="#"
                                                                    class="text-gray-600 text-hover-primary">423445721</a>
                                                            </td>
                                                            <td>Seller Fee</td>
                                                            <td class="text-danger">$-2.60</td>
                                                            <td class="text-end">
                                                                <button
                                                                    class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Feb 09, 2018</td>
                                                            <td>
                                                                <a href="#"
                                                                    class="text-gray-600 text-hover-primary">426445943</a>
                                                            </td>
                                                            <td>Visual Design Illustration</td>
                                                            <td class="text-success">$31.00</td>
                                                            <td class="text-end">
                                                                <button
                                                                    class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Nov 01, 2018</td>
                                                            <td>
                                                                <a href="#"
                                                                    class="text-gray-600 text-hover-primary">984445943</a>
                                                            </td>
                                                            <td>Abstract Vusial Pack</td>
                                                            <td class="text-success">$52.00</td>
                                                            <td class="text-end">
                                                                <button
                                                                    class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Jan 04, 2018</td>
                                                            <td>
                                                                <a href="#"
                                                                    class="text-gray-600 text-hover-primary">324442313</a>
                                                            </td>
                                                            <td>Seller Fee</td>
                                                            <td class="text-danger">$-0.80</td>
                                                            <td class="text-end">
                                                                <button
                                                                    class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Oct 08, 2018</td>
                                                            <td>
                                                                <a href="#"
                                                                    class="text-gray-600 text-hover-primary">312445984</a>
                                                            </td>
                                                            <td>Cartoon Mobile Emoji Phone Pack</td>
                                                            <td class="text-success">$76.00</td>
                                                            <td class="text-end">
                                                                <button
                                                                    class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Oct 08, 2018</td>
                                                            <td>
                                                                <a href="#"
                                                                    class="text-gray-600 text-hover-primary">312445984</a>
                                                            </td>
                                                            <td>Cartoon Mobile Emoji Phone Pack</td>
                                                            <td class="text-success">$76.00</td>
                                                            <td class="text-end">
                                                                <button
                                                                    class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Feb 09, 2019</td>
                                                            <td>
                                                                <a href="#"
                                                                    class="text-gray-600 text-hover-primary">426445943</a>
                                                            </td>
                                                            <td>Visual Design Illustration</td>
                                                            <td class="text-success">$31.00</td>
                                                            <td class="text-end">
                                                                <button
                                                                    class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Nov 01, 2019</td>
                                                            <td>
                                                                <a href="#"
                                                                    class="text-gray-600 text-hover-primary">984445943</a>
                                                            </td>
                                                            <td>Abstract Vusial Pack</td>
                                                            <td class="text-success">$52.00</td>
                                                            <td class="text-end">
                                                                <button
                                                                    class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Jan 04, 2019</td>
                                                            <td>
                                                                <a href="#"
                                                                    class="text-gray-600 text-hover-primary">324442313</a>
                                                            </td>
                                                            <td>Seller Fee</td>
                                                            <td class="text-danger">$-0.80</td>
                                                            <td class="text-end">
                                                                <button
                                                                    class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Sep 15, 2019</td>
                                                            <td>
                                                                <a href="#"
                                                                    class="text-gray-600 text-hover-primary">312445984</a>
                                                            </td>
                                                            <td>Iphone 12 Pro Mockup Mega Bundle</td>
                                                            <td class="text-success">$5.00</td>
                                                            <td class="text-end">
                                                                <button
                                                                    class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Nov 01, 2019</td>
                                                            <td>
                                                                <a href="#"
                                                                    class="text-gray-600 text-hover-primary">102445788</a>
                                                            </td>
                                                            <td>Darknight transparency 36 Icons Pack</td>
                                                            <td class="text-success">$38.00</td>
                                                            <td class="text-end">
                                                                <button
                                                                    class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Oct 24, 2019</td>
                                                            <td>
                                                                <a href="#"
                                                                    class="text-gray-600 text-hover-primary">423445721</a>
                                                            </td>
                                                            <td>Seller Fee</td>
                                                            <td class="text-danger">$-2.60</td>
                                                            <td class="text-end">
                                                                <button
                                                                    class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Oct 08, 2019</td>
                                                            <td>
                                                                <a href="#"
                                                                    class="text-gray-600 text-hover-primary">312445984</a>
                                                            </td>
                                                            <td>Cartoon Mobile Emoji Phone Pack</td>
                                                            <td class="text-success">$76.00</td>
                                                            <td class="text-end">
                                                                <button
                                                                    class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>May 30, 2019</td>
                                                            <td>
                                                                <a href="#"
                                                                    class="text-gray-600 text-hover-primary">523445943</a>
                                                            </td>
                                                            <td>Seller Fee</td>
                                                            <td class="text-danger">$-1.30</td>
                                                            <td class="text-end">
                                                                <button
                                                                    class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Apr 22, 2019</td>
                                                            <td>
                                                                <a href="#"
                                                                    class="text-gray-600 text-hover-primary">231445943</a>
                                                            </td>
                                                            <td>Parcel Shipping / Delivery Service App</td>
                                                            <td class="text-success">$204.00</td>
                                                            <td class="text-end">
                                                                <button
                                                                    class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <!--end::Table-->
                                            </div>
                                            <!--end::Tab panel-->
                                        </div>
                                        <!--end::Tab Content-->
                                    </div>
                                    <!--end::Card body-->
                                </div>
                                <!--end::Statements-->
                            </div>
                            <!--end:::Tab pane-->
                        </div>
                        <!--end:::Tab content-->
                    </div>
                    <!--end::Content-->
                </div>
                <!--end::Layout-->
                <!--begin::Modals-->
                <!--begin::Modal - Add Payment-->
                <div class="modal fade" id="kt_modal_add_payment" tabindex="-1" aria-hidden="true">
                    <!--begin::Modal dialog-->
                    <div class="modal-dialog mw-650px">
                        <!--begin::Modal content-->
                        <div class="modal-content">
                            <!--begin::Modal header-->
                            <div class="modal-header">
                                <!--begin::Modal title-->
                                <h2 class="fw-bold">Add a Payment Record</h2>
                                <!--end::Modal title-->
                                <!--begin::Close-->
                                <div id="kt_modal_add_payment_close"
                                    class="btn btn-icon btn-sm btn-active-icon-primary">
                                    <i class="ki-outline ki-cross fs-1"></i>
                                </div>
                                <!--end::Close-->
                            </div>
                            <!--end::Modal header-->
                            <!--begin::Modal body-->
                            <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                                <!--begin::Form-->
                                <form id="kt_modal_add_payment_form" class="form" action="#">
                                    <!--begin::Input group-->
                                    <div class="fv-row mb-7">
                                        <!--begin::Label-->
                                        <label class="fs-6 fw-semibold form-label mb-2">
                                            <span class="required">Invoice Number</span>
                                            <span class="ms-2" data-bs-toggle="tooltip"
                                                title="The invoice number must be unique.">
                                                <i class="ki-outline ki-information fs-7"></i>
                                            </span>
                                        </label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <input type="text" class="form-control form-control-solid" name="invoice"
                                            value="" />
                                        <!--end::Input-->
                                    </div>
                                    <!--end::Input group-->
                                    <!--begin::Input group-->
                                    <div class="fv-row mb-7">
                                        <!--begin::Label-->
                                        <label class="required fs-6 fw-semibold form-label mb-2">Status</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <select class="form-select form-select-solid fw-bold" name="status"
                                            data-control="select2" data-placeholder="Select an option"
                                            data-hide-search="true">
                                            <option></option>
                                            <option value="0">Approved</option>
                                            <option value="1">Pending</option>
                                            <option value="2">Rejected</option>
                                            <option value="3">In progress</option>
                                            <option value="4">Completed</option>
                                        </select>
                                        <!--end::Input-->
                                    </div>
                                    <!--end::Input group-->
                                    <!--begin::Input group-->
                                    <div class="fv-row mb-7">
                                        <!--begin::Label-->
                                        <label class="required fs-6 fw-semibold form-label mb-2">Invoice Amount</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <input type="text" class="form-control form-control-solid" name="amount"
                                            value="" />
                                        <!--end::Input-->
                                    </div>
                                    <!--end::Input group-->
                                    <!--begin::Input group-->
                                    <div class="fv-row mb-15">
                                        <!--begin::Label-->
                                        <label class="fs-6 fw-semibold form-label mb-2">
                                            <span class="required">Additional Information</span>
                                            <span class="ms-2" data-bs-toggle="tooltip"
                                                title="Information such as description of invoice or product purchased.">
                                                <i class="ki-outline ki-information fs-7"></i>
                                            </span>
                                        </label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <textarea class="form-control form-control-solid rounded-3" name="additional_info"></textarea>
                                        <!--end::Input-->
                                    </div>
                                    <!--end::Input group-->
                                    <!--begin::Actions-->
                                    <div class="text-center">
                                        <button type="reset" id="kt_modal_add_payment_cancel"
                                            class="btn btn-light me-3">Discard</button>
                                        <button type="submit" id="kt_modal_add_payment_submit"
                                            class="btn btn-primary">
                                            <span class="indicator-label">Submit</span>
                                            <span class="indicator-progress">Please wait...
                                                <span
                                                    class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
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
                    <!--end::Modal dialog-->
                </div>
                <!--end::Modal - New Card-->
                <!--begin::Modal - Adjust Balance-->
                <div class="modal fade" id="kt_modal_adjust_balance" tabindex="-1" aria-hidden="true">
                    <!--begin::Modal dialog-->
                    <div class="modal-dialog modal-dialog-centered mw-650px">
                        <!--begin::Modal content-->
                        <div class="modal-content">
                            <!--begin::Modal header-->
                            <div class="modal-header">
                                <!--begin::Modal title-->
                                <h2 class="fw-bold">Adjust Balance</h2>
                                <!--end::Modal title-->
                                <!--begin::Close-->
                                <div id="kt_modal_adjust_balance_close"
                                    class="btn btn-icon btn-sm btn-active-icon-primary">
                                    <i class="ki-outline ki-cross fs-1"></i>
                                </div>
                                <!--end::Close-->
                            </div>
                            <!--end::Modal header-->
                            <!--begin::Modal body-->
                            <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                                <!--begin::Balance preview-->
                                <div class="d-flex text-center mb-9">
                                    <div class="w-50 border border-dashed border-gray-300 rounded mx-2 p-4">
                                        <div class="fs-6 fw-semibold mb-2 text-muted">Current Balance</div>
                                        <div class="fs-2 fw-bold" kt-modal-adjust-balance="current_balance">US$
                                            32,487.57</div>
                                    </div>
                                    <div class="w-50 border border-dashed border-gray-300 rounded mx-2 p-4">
                                        <div class="fs-6 fw-semibold mb-2 text-muted">New Balance
                                            <span class="ms-2" data-bs-toggle="tooltip"
                                                title="Enter an amount to preview the new balance.">
                                                <i class="ki-outline ki-information fs-7"></i>
                                            </span>
                                        </div>
                                        <div class="fs-2 fw-bold" kt-modal-adjust-balance="new_balance">--</div>
                                    </div>
                                </div>
                                <!--end::Balance preview-->
                                <!--begin::Form-->
                                <form id="kt_modal_adjust_balance_form" class="form" action="#">
                                    <!--begin::Input group-->
                                    <div class="fv-row mb-7">
                                        <!--begin::Label-->
                                        <label class="required fs-6 fw-semibold form-label mb-2">Adjustment type</label>
                                        <!--end::Label-->
                                        <!--begin::Dropdown-->
                                        <select class="form-select form-select-solid fw-bold" name="adjustment"
                                            aria-label="Select an option" data-control="select2"
                                            data-dropdown-parent="#kt_modal_adjust_balance"
                                            data-placeholder="Select an option" data-hide-search="true">
                                            <option></option>
                                            <option value="1">Credit</option>
                                            <option value="2">Debit</option>
                                        </select>
                                        <!--end::Dropdown-->
                                    </div>
                                    <!--end::Input group-->
                                    <!--begin::Input group-->
                                    <div class="fv-row mb-7">
                                        <!--begin::Label-->
                                        <label class="required fs-6 fw-semibold form-label mb-2">Amount</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <input id="kt_modal_inputmask" type="text"
                                            class="form-control form-control-solid" name="amount" value="" />
                                        <!--end::Input-->
                                    </div>
                                    <!--end::Input group-->
                                    <!--begin::Input group-->
                                    <div class="fv-row mb-7">
                                        <!--begin::Label-->
                                        <label class="fs-6 fw-semibold form-label mb-2">Add adjustment note</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <textarea class="form-control form-control-solid rounded-3 mb-5"></textarea>
                                        <!--end::Input-->
                                    </div>
                                    <!--end::Input group-->
                                    <!--begin::Disclaimer-->
                                    <div class="fs-7 text-muted mb-15">Please be aware that all manual balance changes
                                        will be audited by the financial team every fortnight. Please maintain your invoices
                                        and receipts until then. Thank you.</div>
                                    <!--end::Disclaimer-->
                                    <!--begin::Actions-->
                                    <div class="text-center">
                                        <button type="reset" id="kt_modal_adjust_balance_cancel"
                                            class="btn btn-light me-3">Discard</button>
                                        <button type="submit" id="kt_modal_adjust_balance_submit"
                                            class="btn btn-primary">
                                            <span class="indicator-label">Submit</span>
                                            <span class="indicator-progress">Please wait...
                                                <span
                                                    class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
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
                    <!--end::Modal dialog-->
                </div>
                <!--end::Modal - New Card-->
                <!--begin::Modal - New Address-->
                <div class="modal fade" id="kt_modal_update_customer" tabindex="-1" aria-hidden="true">
                    <!--begin::Modal dialog-->
                    <div class="modal-dialog modal-dialog-centered mw-950px">
                        <!--begin::Modal content-->
                        <div class="modal-content">
                            <!--begin::Form-->
                            <form class="form" enctype="multipart/form-data" method="POST"
                                id="admin-{{ $params['prefix'] }}-form"
                                action="{{ route($params['prefix'] . '.' . $params['controller'] . '.update', $params['item']->id) }}">
                                @csrf
                                @method('PUT')
                                <!--begin::Modal header-->
                                <div class="modal-header" id="kt_modal_update_customer_header">
                                    <!--begin::Modal title-->
                                    <h2 class="fw-bold">Update Shop</h2>
                                    <!--end::Modal title-->
                                    <!--begin::Close-->
                                    <div id="kt_modal_update_customer_close"
                                        class="btn btn-icon btn-sm btn-active-icon-primary btn_close_model">
                                        <i class="ki-outline ki-cross fs-1"></i>
                                    </div>
                                    <!--end::Close-->
                                </div>
                                <!--end::Modal header-->
                                <!--begin::Modal body-->
                                <div class="modal-body py-10 px-lg-17">
                                    <!--begin::Scroll-->
                                    <div class="d-flex flex-column scroll-y me-n7 pe-7"
                                        id="kt_modal_update_customer_scroll" data-kt-scroll="true"
                                        data-kt-scroll-activate="{default: false, lg: true}"
                                        data-kt-scroll-max-height="auto"
                                        data-kt-scroll-dependencies="#kt_modal_update_customer_header"
                                        data-kt-scroll-wrappers="#kt_modal_update_customer_scroll"
                                        data-kt-scroll-offset="300px">
                                        <!--begin::Notice-->
                                        <!--begin::Notice-->
                                        <div
                                            class="notice d-flex bg-light-primary rounded border-primary border border-dashed mb-9 p-6">
                                            <!--begin::Icon-->
                                            <i class="ki-outline ki-information fs-2tx text-primary me-4"></i>
                                            <!--end::Icon-->
                                            <!--begin::Wrapper-->
                                            <div class="d-flex flex-stack flex-grow-1">
                                                <!--begin::Content-->
                                                <div class="fw-semibold">
                                                    <div class="fs-6 text-gray-700">Updating shop details will receive
                                                        a privacy audit. For more info, please read our
                                                        <a href="#">Privacy Policy</a>
                                                    </div>
                                                </div>
                                                <!--end::Content-->
                                            </div>
                                            <!--end::Wrapper-->
                                        </div>
                                        <!--end::Notice-->
                                        <!--end::Notice-->
                                        <!--begin::User toggle-->
                                        <div class="fw-bold fs-3 rotate collapsible mb-7" data-bs-toggle="collapse"
                                            href="#kt_modal_update_customer_user_info" role="button"
                                            aria-expanded="false" aria-controls="kt_modal_update_customer_user_info">
                                            Shop Information
                                            <span class="ms-2 rotate-180">
                                                <i class="ki-outline ki-down fs-3"></i>
                                            </span>
                                        </div>
                                        <!--end::User toggle-->
                                        <!--begin::User form-->
                                        <div id="kt_modal_update_customer_user_info" class="collapse show">
                                            <!--begin::Input group-->
                                            <div class="mb-7">
                                                <!--begin::Label-->
                                                <label class="fs-6 fw-semibold mb-2">
                                                    <span>Update Logo</span>
                                                    <span class="ms-1" data-bs-toggle="tooltip"
                                                        title="Allowed file types: png, jpg, jpeg.">
                                                        <i class="ki-outline ki-information fs-7"></i>
                                                    </span>
                                                </label>
                                                <!--end::Label-->
                                                <!--begin::Image input wrapper-->
                                                <div class="mt-1">
                                                    <!--begin::Image input-->
                                                    <div class="image-input image-input-outline"
                                                        data-kt-image-input="true"
                                                        style="background-image: url('{{ $params['item']->logo ?? asset('assets/media/svg/avatars/blank.svg') }}')">
                                                        <!--begin::Preview existing avatar-->
                                                        <div class="image-input-wrapper w-125px h-125px"
                                                            style="background-image: url({{ $params['item']->logo ?? asset('assets/media/avatars/300-1.jpg') }})">
                                                        </div>
                                                        <!--end::Preview existing avatar-->
                                                        <!--begin::Edit-->
                                                        <label
                                                            class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                                            data-kt-image-input-action="change" data-bs-toggle="tooltip"
                                                            title="Change avatar">
                                                            <i class="ki-outline ki-pencil fs-7"></i>
                                                            <!--begin::Inputs-->
                                                            <input type="file" name="logo"
                                                                accept=".png, .jpg, .jpeg" />
                                                            <!--end::Inputs-->
                                                        </label>
                                                        <!--end::Edit-->
                                                        <!--begin::Cancel-->
                                                        <span
                                                            class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                                            data-kt-image-input-action="cancel" data-bs-toggle="tooltip"
                                                            title="Cancel avatar">
                                                            <i class="ki-outline ki-cross fs-2"></i>
                                                        </span>
                                                        <!--end::Cancel-->
                                                        <!--begin::Remove-->
                                                        <span
                                                            class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                                            data-kt-image-input-action="remove" data-bs-toggle="tooltip"
                                                            title="Remove avatar">
                                                            <i class="ki-outline ki-cross fs-2"></i>
                                                        </span>
                                                        <!--end::Remove-->
                                                    </div>
                                                    <!--end::Image input-->
                                                </div>
                                                <!--end::Image input wrapper-->
                                            </div>
                                            <!--end::Input group-->
                                            <!--begin::Input group-->
                                            <div class="fv-row mb-7">
                                                <!--begin::Label-->
                                                <label class="fs-6 fw-semibold mb-2">Name</label>
                                                <!--end::Label-->
                                                <!--begin::Input-->
                                                <input type="text" class="form-control form-control-solid"
                                                    placeholder="" name="name"
                                                    value="{{ $params['item']->name }}" />
                                                <div class="input-error"></div>
                                                <!--end::Input-->
                                            </div>
                                            <!--end::Input group-->
                                            <!--begin::Input group-->
                                            <div class="fv-row mb-7">
                                                <!--begin::Label-->
                                                <label class="fs-6 fw-semibold mb-2">
                                                    <span>Email</span>
                                                    <span class="ms-1" data-bs-toggle="tooltip"
                                                        title="Email address must be active">
                                                        <i class="ki-outline ki-information fs-7"></i>
                                                    </span>
                                                </label>
                                                <!--end::Label-->
                                                <!--begin::Input-->
                                                <input type="email" class="form-control form-control-solid"
                                                    placeholder="" name="email"
                                                    value="{{ $params['item']->email }}" />
                                                <!--end::Input-->
                                            </div>
                                            <!--end::Input group-->
                                            <!--begin::Input group-->
                                            <div class="fv-row mb-15">
                                                <!--begin::Label-->
                                                <label class="fs-6 fw-semibold mb-2">Bio</label>
                                                <!--end::Label-->
                                                <!--begin::Input-->
                                                <input type="text" class="form-control form-control-solid"
                                                    placeholder="" name="bio"
                                                    value="{{ $params['item']->bio }}" />
                                                <!--end::Input-->
                                            </div>
                                            <!--end::Input group-->
                                        </div>
                                        <!--end::User form-->
                                        <!--begin::Billing toggle-->
                                        <div class="fw-bold fs-3 rotate collapsible collapsed mb-7"
                                            data-bs-toggle="collapse" href="#kt_modal_update_customer_billing_info"
                                            role="button" aria-expanded="false"
                                            aria-controls="kt_modal_update_customer_billing_info">More Information
                                            <span class="ms-2 rotate-180">
                                                <i class="ki-outline ki-down fs-3"></i>
                                            </span>
                                        </div>
                                        <!--end::Billing toggle-->
                                        <!--begin::Billing form-->
                                        <div id="kt_modal_update_customer_billing_info" class="collapse show">
                                            <!--begin::Input group-->
                                            <div class="d-flex flex-column mb-7 fv-row">
                                                <!--begin::Label-->
                                                <label class="fs-6 fw-semibold mb-2">Addres</label>
                                                <!--end::Label-->
                                                <!--begin::Input-->
                                                <input class="form-control form-control-solid" placeholder=""
                                                    name="address_detail"
                                                    value="{{ $params['item']->address_detail }}" />
                                                <!--end::Input-->
                                            </div>
                                            <!--end::Input group-->
                                            <!--begin::Input group-->
                                            <div class="d-flex flex-column mb-7 fv-row">
                                                <!--begin::Label-->
                                                <label class="fs-6 fw-semibold mb-2">Phone number</label>
                                                <!--end::Label-->
                                                <!--begin::Input-->
                                                <input class="form-control form-control-solid" placeholder=""
                                                    name="phone_number" value="{{ $params['item']->phone_number }}" />
                                                <!--end::Input-->
                                            </div>
                                            <!--end::Input group-->
                                            <!--begin::Input group-->
                                            <div class="d-flex flex-column mb-7 fv-row">
                                                <!--begin::Label-->
                                                <label class="fs-6 fw-semibold mb-2">Shop code</label>
                                                <!--end::Label-->
                                                <!--begin::Input-->
                                                <input class="form-control form-control-solid" placeholder=""
                                                    name="" readonly value="{{ $params['item']->shop_code }}" />
                                                <!--end::Input-->
                                            </div>

                                            <div class="fv-row mb-7">
                                                <!--begin::Wrapper-->
                                                <div class="d-flex flex-stack">
                                                    <!--begin::Label-->
                                                    <div class="me-5">
                                                        <!--begin::Label-->
                                                        <label class="fs-6 fw-semibold">Status</label>
                                                        <!--end::Label-->
                                                        <!--begin::Input-->
                                                        <div class="fs-7 fw-semibold text-muted">If you need more info,
                                                            please check privacy</div>
                                                        <!--end::Input-->
                                                    </div>
                                                    <!--end::Label-->
                                                    <!--begin::Switch-->
                                                    <label
                                                        class="form-check form-switch form-check-custom form-check-solid">
                                                        <!--begin::Input-->
                                                        <input class="form-check-input" name="status" type="checkbox"
                                                            value="active" id="kt_modal_update_customer_billing"
                                                            {{ $params['item']->status == 'active' ? 'checked' : '' }} />
                                                        <!--end::Input-->
                                                        <!--begin::Label-->
                                                        <span class="form-check-label fw-semibold text-muted"
                                                            for="kt_modal_update_customer_billing">Yes</span>
                                                        <!--end::Label-->
                                                    </label>
                                                    <!--end::Switch-->
                                                </div>
                                                <!--begin::Wrapper-->
                                            </div>
                                            <!--end::Input group-->
                                        </div>
                                        <!--end::Billing form-->
                                    </div>
                                    <!--end::Scroll-->
                                </div>
                                <!--end::Modal body-->
                                <!--begin::Modal footer-->
                                <div class="modal-footer flex-center">
                                    <!--begin::Button-->
                                    <button type="reset" id="kt_modal_update_customer_cancel"
                                        class="btn btn-light me-3 btn_close_model">Discard</button>
                                    <!--end::Button-->
                                    <!--begin::Button-->
                                    <button type="submit" id="kt_modal_update_customer_submit"
                                        class="btn btn-primary">
                                        <span class="indicator-label">Submit</span>
                                        <span class="indicator-progress">Please wait...
                                            <span
                                                class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                    </button>
                                    <!--end::Button-->
                                </div>
                                <!--end::Modal footer-->
                            </form>
                            <!--end::Form-->
                        </div>
                    </div>
                </div>
                <!--end::Modal - New Address-->
                <!--begin::Modal - New Card-->
                <div class="modal fade" id="kt_modal_new_card" tabindex="-1" aria-hidden="true">
                    <!--begin::Modal dialog-->
                    <div class="modal-dialog modal-dialog-centered mw-650px">
                        <!--begin::Modal content-->
                        <div class="modal-content">
                            <!--begin::Modal header-->
                            <div class="modal-header">
                                <!--begin::Modal title-->
                                <h2>Add New Card</h2>
                                <!--end::Modal title-->
                                <!--begin::Close-->
                                <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                                    <i class="ki-outline ki-cross fs-1"></i>
                                </div>
                                <!--end::Close-->
                            </div>
                            <!--end::Modal header-->
                            <!--begin::Modal body-->
                            <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                                <!--begin::Form-->
                                <form id="kt_modal_new_card_form" class="form" action="#">
                                    <!--begin::Input group-->
                                    <div class="d-flex flex-column mb-7 fv-row">
                                        <!--begin::Label-->
                                        <label class="d-flex align-items-center fs-6 fw-semibold form-label mb-2">
                                            <span class="required">Name On Card</span>
                                            <span class="ms-1" data-bs-toggle="tooltip"
                                                title="Specify a card holder's name">
                                                <i class="ki-outline ki-information-5 text-gray-500 fs-6"></i>
                                            </span>
                                        </label>
                                        <!--end::Label-->
                                        <input type="text" class="form-control form-control-solid" placeholder=""
                                            name="card_name" value="Max Doe" />
                                    </div>
                                    <!--end::Input group-->
                                    <!--begin::Input group-->
                                    <div class="d-flex flex-column mb-7 fv-row">
                                        <!--begin::Label-->
                                        <label class="required fs-6 fw-semibold form-label mb-2">Card Number</label>
                                        <!--end::Label-->
                                        <!--begin::Input wrapper-->
                                        <div class="position-relative">
                                            <!--begin::Input-->
                                            <input type="text" class="form-control form-control-solid"
                                                placeholder="Enter card number" name="card_number"
                                                value="4111 1111 1111 1111" />
                                            <!--end::Input-->
                                            <!--begin::Card logos-->
                                            <div class="position-absolute translate-middle-y top-50 end-0 me-5">
                                                <img src="assets/media/svg/card-logos/visa.svg" alt=""
                                                    class="h-25px" />
                                                <img src="assets/media/svg/card-logos/mastercard.svg" alt=""
                                                    class="h-25px" />
                                                <img src="assets/media/svg/card-logos/american-express.svg"
                                                    alt="" class="h-25px" />
                                            </div>
                                            <!--end::Card logos-->
                                        </div>
                                        <!--end::Input wrapper-->
                                    </div>
                                    <!--end::Input group-->
                                    <!--begin::Input group-->
                                    <div class="row mb-10">
                                        <!--begin::Col-->
                                        <div class="col-md-8 fv-row">
                                            <!--begin::Label-->
                                            <label class="required fs-6 fw-semibold form-label mb-2">Expiration
                                                Date</label>
                                            <!--end::Label-->
                                            <!--begin::Row-->
                                            <div class="row fv-row">
                                                <!--begin::Col-->
                                                <div class="col-6">
                                                    <select name="card_expiry_month"
                                                        class="form-select form-select-solid" data-control="select2"
                                                        data-hide-search="true" data-placeholder="Month">
                                                        <option></option>
                                                        <option value="1">1</option>
                                                        <option value="2">2</option>
                                                        <option value="3">3</option>
                                                        <option value="4">4</option>
                                                        <option value="5">5</option>
                                                        <option value="6">6</option>
                                                        <option value="7">7</option>
                                                        <option value="8">8</option>
                                                        <option value="9">9</option>
                                                        <option value="10">10</option>
                                                        <option value="11">11</option>
                                                        <option value="12">12</option>
                                                    </select>
                                                </div>
                                                <!--end::Col-->
                                                <!--begin::Col-->
                                                <div class="col-6">
                                                    <select name="card_expiry_year"
                                                        class="form-select form-select-solid" data-control="select2"
                                                        data-hide-search="true" data-placeholder="Year">
                                                        <option></option>
                                                        <option value="2024">2024</option>
                                                        <option value="2025">2025</option>
                                                        <option value="2026">2026</option>
                                                        <option value="2027">2027</option>
                                                        <option value="2028">2028</option>
                                                        <option value="2029">2029</option>
                                                        <option value="2030">2030</option>
                                                        <option value="2031">2031</option>
                                                        <option value="2032">2032</option>
                                                        <option value="2033">2033</option>
                                                        <option value="2034">2034</option>
                                                    </select>
                                                </div>
                                                <!--end::Col-->
                                            </div>
                                            <!--end::Row-->
                                        </div>
                                        <!--end::Col-->
                                        <!--begin::Col-->
                                        <div class="col-md-4 fv-row">
                                            <!--begin::Label-->
                                            <label class="d-flex align-items-center fs-6 fw-semibold form-label mb-2">
                                                <span class="required">CVV</span>
                                                <span class="ms-1" data-bs-toggle="tooltip"
                                                    title="Enter a card CVV code">
                                                    <i class="ki-outline ki-information-5 text-gray-500 fs-6"></i>
                                                </span>
                                            </label>
                                            <!--end::Label-->
                                            <!--begin::Input wrapper-->
                                            <div class="position-relative">
                                                <!--begin::Input-->
                                                <input type="text" class="form-control form-control-solid"
                                                    minlength="3" maxlength="4" placeholder="CVV"
                                                    name="card_cvv" />
                                                <!--end::Input-->
                                                <!--begin::CVV icon-->
                                                <div class="position-absolute translate-middle-y top-50 end-0 me-3">
                                                    <i class="ki-outline ki-credit-cart fs-2hx"></i>
                                                </div>
                                                <!--end::CVV icon-->
                                            </div>
                                            <!--end::Input wrapper-->
                                        </div>
                                        <!--end::Col-->
                                    </div>
                                    <!--end::Input group-->
                                    <!--begin::Input group-->
                                    <div class="d-flex flex-stack">
                                        <!--begin::Label-->
                                        <div class="me-5">
                                            <label class="fs-6 fw-semibold form-label">Save Card for further
                                                billing?</label>
                                            <div class="fs-7 fw-semibold text-muted">If you need more info, please check
                                                budget planning</div>
                                        </div>
                                        <!--end::Label-->
                                        <!--begin::Switch-->
                                        <label class="form-check form-switch form-check-custom form-check-solid">
                                            <input class="form-check-input" type="checkbox" value="1"
                                                checked="checked" />
                                            <span class="form-check-label fw-semibold text-muted">Save Card</span>
                                        </label>
                                        <!--end::Switch-->
                                    </div>
                                    <!--end::Input group-->
                                    <!--begin::Actions-->
                                    <div class="text-center pt-15">
                                        <button type="reset" id="kt_modal_new_card_cancel"
                                            class="btn btn-light me-3">Discard</button>
                                        <button type="submit" id="kt_modal_new_card_submit" class="btn btn-primary">
                                            <span class="indicator-label">Submit</span>
                                            <span class="indicator-progress">Please wait...
                                                <span
                                                    class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
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
                    <!--end::Modal dialog-->
                </div>
                <!--end::Modal - New Card-->
                <!--end::Modals-->
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
            $('.btn_close_model').on('click',function(){
                const myModalEl = $(this).closest('.modal')
                if(myModalEl){
                    const modal = bootstrap.Modal.getInstance(myModalEl) || new bootstrap.Modal(myModalEl);
                    modal.hide();
                }
            })
            $('#admin-{{ $params['prefix'] }}-form').submit(function(e) {
                e.preventDefault();
                const formEl = $(this)
                $(this).find('.indicator-label').hide()
                $(this).find('.indicator-progress').show()
                $(this).find(`button[type='submit']`).prop('disabled', true);
                $('.input-error').html('');
                $('.form-group row p-0 m-0 mb-2 input').removeClass('is-invalid');
                e.preventDefault();
                var formData = new FormData(this);
                $.ajax({
                    type: 'POST',
                    url: "{{ route($params['prefix'] . '.' . $params['controller'] . '.update', $params['item']->id) }}",
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
                        console.log('====================================');
                        console.log(123);
                        console.log('====================================');
                        if (res.status) {
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
                        } else {
                            Swal.fire({
                                html: res.message ??
                                    "Sorry, looks like there are some errors detected, please try again: ",
                                icon: "error",
                                buttonsStyling: !1,
                                confirmButtonText: "Ok, got it!",
                                customClass: {
                                    confirmButton: "btn btn-primary"
                                }
                            })
                        }
                    },
                    error: function(data) {
                        console.log('====================================');
                        console.log(data.responseJSON);
                        console.log('====================================');

                        $(formEl).find('.indicator-label').show()
                        $(formEl).find('.indicator-progress').hide()
                        $(formEl).find(`button[type='submit']`).prop('disabled', false);
                        let errorMs = '<ul class="text-right text-start text-danger mt-3">';
                        for (x in data.responseJSON.errors) {
                            errorMs += `<li><i class="">${data.responseJSON.errors[x]}</i></li>`
                        }
                        errorMs += '</ul>'
                        if(data.status == 400){
                            errorMs = `<div class="text-danger mt-2"> ${ data.responseJSON.message ?? 'Error from server' }</div>`
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
@endpush
