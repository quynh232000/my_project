<style>

</style>
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Thông tin quản lý</h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body px-1 row">
      
        <div class="form-group col-12 p-2 px-3 mb-0">
            <label class="col-form-label" for="customer_ids">Thêm nhân viên</label>
                {!! \App\Models\Hotel\HotelModel::selectCustomer([],$params['item']['id']) !!}
            <div class="input-error"></div>
        </div>
        <div class="col-12 px-3 mt-2">
            <label for="">Danh sách nhân viên</label>
            <table class="table table-bordered">
                <thead>
                  <tr class="text-sm">
                    <th style="width: 10px">ID</th>
                    <th>Nhân viên</th>
                    {{-- <th>Email</th> --}}
                    <th>Trạng thái</th>
                    <th style="width: 160px">Vai trò</th>
                    <th>Hành động</th>
                  </tr>
                </thead>
                <tbody>
                    @forelse ($params['item']['customers'] as $user)
                    <tr>
                        <td>{{$user['id']}}
                            <input type="text" hidden name="hotel_customer_ids[]" value="{{$user['pivot']['id']}}">
                        </td>
                        {{-- <td>
                            {{$user['full_name']}}
                        </td> --}}
                        <td>
                            <div>
                                {{$user['full_name']}}
                            </div>
                            <a href="{{route('hotel.customer.edit',['customer'=>$user['id']])}}">
                                {{$user['email']}}
                            </a>
                        </td>
                        <td>
                            <div class="text-center align-middle p-1">
                                <div style="cursor:pointer" class="btn-status" data-status="{{$user['pivot']['status']}}">
                                    <input type="text" name="hotel_customer[{{$user['id']}}][status]" value="{{$user['pivot']['status']}}" hidden>
                                    @if ($user['pivot']['status'] == 'active')
                                        <i class="fa-solid fa-circle-check fa-lg text-success"></i>
                                    @else
                                        <i class="fa-sharp fa-solid fa-ban fa-lg text-danger"></i>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td>
                            {!! \App\Models\Hotel\HotelModel::selectRole($user['pivot']['role'],"hotel_customer[".$user['id']."][role]") !!}
                        <td class="text-center align-middle p-1">
                            <div class="btn-delete-role" style="cursor:pointer">
                                <i class="fa-solid fa-trash-can text-danger" title="Xóa"></i>
                            </div>
                        </td>
                      </tr>
                    @empty
                        
                    <tr>
                        <td colspan="5" class="text-center text-danger">Không tìm thấy dữ liệu nào!</td>
                    </tr>
                    @endforelse
                   
                   
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
    
    $('.btn-delete-role').click(function () {
        $(this).closest('tr').remove()
    })
    $('.btn-status').click(function () {
        const status = $(this).data('status')
        $(this).find('input').val(status == 'active'?'inactive':'active')
        
        $(this).find('i').attr('class',status =='active'?'fa-sharp fa-solid fa-ban fa-lg text-danger':'fa-solid fa-circle-check fa-lg text-success')
        $(this).data('status',status == 'active'?'inactive':'active')
    })
</script>
