<button type="button" title="Xem" class="d-flex justify-content-center w-100 text-secondary" data-toggle="modal"
    data-target="#myModal{{ $params['id'] }}">
    <i class="fa-solid fa-users"></i>
</button>

<!-- Modal -->
<div class="modal fade" id="myModal{{ $params['id'] }}" tabindex="-1" role="dialog"
    aria-labelledby="myModalLabel{{ $params['id'] }}" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
        <div class="modal-content">

            <!-- Header -->
            <div class="modal-header">
                <h5 class="modal-title d-flex align-items-center" id="myModalLabel{{ $params['id'] }}">
                    <span class="mr-2">
                        <i class="fas fa-user-tie text-primary"></i>
                    </span>
                    <span>
                        <span class="">({{ count($params['customers']) }})</span>
                        Nhân viên quản lý khách sạn
                        <strong>"{{ $params['name'] }}"</strong>
                    </span>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Đóng">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- Body -->
            <div class="modal-body">

                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>STT</th>
                                <th>Họ và tên</th>
                                <th>Email</th>
                                <th>Số điện thoại</th>
                                <th>Chức vụ</th>
                                <th class="text-center">Chi tiết</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($params['customers'] as $key => $customer)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $customer['full_name'] }}</td>
                                    <td>{{ $customer['email'] }}</td>
                                    <td>{{ $customer['phone'] }}</td>
                                    <td>
                                        {!! \App\Models\Hotel\CustomerModel::selectRole($customer['pivot']['role'] ?? 'staff') !!}
                                    </td>
                                    <td>
                                        <div class="w-full d-flex justify-content-center">
                                            <a href="{{ route('hotel.customer.edit', $customer['id']) }}"
                                                class="btn btn-primary btn-sm">Xem</a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Footer -->
            <div class="modal-footer">
                {{-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
        <button type="button" class="btn btn-primary">Lưu thay đổi</button> --}}
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
            </div>

        </div>
    </div>
</div>
