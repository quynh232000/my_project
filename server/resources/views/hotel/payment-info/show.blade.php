
<div class="modal  fade" id="modal-show">
  <div class="modal-dialog modal-dialog-centered modal-xl modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title d-flex align-items-center">
          <i class="fa-solid fa-address-card  text-primary fa-xl mr-2" style="font-size: 21px;color: #2a85ff;"></i>
          Thông tin đăng ký tài khoản thanh toán
      </h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      
      
      <div class="modal-body">
        <div class="">
          <div class="row">
            <div class="form-group col-md-6 p-2 mb-0">
                <label class=" text-right font-weight-normal" for="bank">Ngân hàng</label>
                <input type="text" class="form-control " readonly  id="bank"  value="{{$params['item']->bank->name}}">
                <div class="input-error"></div>
            </div>
            <div class="form-group col-md-6 p-2 mb-0">
                <label class=" text-right font-weight-normal" for="bank_branch">Chi nhánh ngân hàng</label>
                <input type="text" class="form-control " readonly  id="bank_branch"  value="{{$params['item']->bank_branch}}">
                <div class="input-error"></div>
            </div>
            <div class="form-group col-md-6 p-2 mb-0">
                <label class=" text-right font-weight-normal" for="name_account">Tên tài khoản</label>
                <input type="text" class="form-control " readonly  id="name_account"  value="{{$params['item']->name_account}}">
                <div class="input-error"></div>
            </div>
            <div class="form-group col-md-6 p-2 mb-0">
                <label class=" text-right font-weight-normal" for="number">Số tài khoản</label>
                <input type="text" class="form-control " readonly  id="number"  value="{{$params['item']->number}}">
                <div class="input-error"></div>
            </div>
            <div class="form-group col-md-6 p-2 mb-0">
                <label class=" text-right font-weight-normal" for="type">Loại tài khoản</label>
                <input type="text" class="form-control " readonly  id="type"  value="{{$params['item']->type == 'personal' ? 'Cá nhân': 'Doanh nghiệp'}}">
                <div class="input-error"></div>
            </div>
            @php
                $dataStatus = [
                              'new'                   => 'Chờ xử lý',
                              'processing'            => 'Đang xử lý',
                              'verified'              => 'Hoàn thành',
                              'requires_update'       => 'Bổ sung thông tin',
                              'failed'                => 'Đã hủy',
                          ];
            @endphp 
            <div class="form-group col-md-6 p-2 mb-0">
                <label class=" text-right font-weight-normal" for="status">Trạng thái</label>
                <input type="text" class="form-control " readonly  id="status"  value="{{$dataStatus[$params['item']['status']]}}">
                <div class="input-error"></div>
            </div>
          </div>
          @if ($params['item']->type != 'personal')
            <label class="py-2">Thông tin xuất hóa đơn</label>
            <div class="row">
              <div class="form-group col-md-6 p-2 mb-0">
                  <label class=" text-right font-weight-normal" for="name_company">Tên công ty</label>
                  <input type="text" class="form-control " readonly  id="name_company"  value="{{$params['item']->name_company}}">
                  <div class="input-error"></div>
              </div>
              <div class="form-group col-md-6 p-2 mb-0">
                  <label class=" text-right font-weight-normal" for="contact_person">Người đại diện</label>
                  <input type="text" class="form-control " readonly  id="contact_person"  value="{{$params['item']->contact_person}}">
                  <div class="input-error"></div>
              </div>
              <div class="form-group col-md-6 p-2 mb-0">
                  <label class=" text-right font-weight-normal" for="address">Địa chỉ</label>
                  <input type="text" class="form-control " readonly  id="address"  value="{{$params['item']->address}}">
                  <div class="input-error"></div>
              </div>
              <div class="form-group col-md-6 p-2 mb-0">
                  <label class=" text-right font-weight-normal" for="tax_code">Mã số thuế</label>
                  <input type="text" class="form-control " readonly  id="tax_code"  value="{{$params['item']->tax_code}}">
                  <div class="input-error"></div>
              </div>
              <div class="form-group col-md-6 p-2 mb-0">
                  <label class=" text-right font-weight-normal" for="email">Email</label>
                  <input type="text" class="form-control " readonly  id="email"  value="{{$params['item']->email}}">
                  <div class="input-error"></div>
              </div>
              <div class="form-group col-md-6 p-2 mb-0">
                  <label class=" text-right font-weight-normal" for="phone">Số điện thoại</label>
                  <input type="text" class="form-control " readonly  id="phone"  value="{{$params['item']->phone}}">
                  <div class="input-error"></div>
              </div>
              <div class="form-group col-md-6 p-2 mb-0">
                  <label class=" text-right font-weight-normal" for="phone">Người tạo</label>
                  <input type="text" class="form-control " readonly  id="phone"  value="{{$params['item']->creator->full_name}}">
                  <div class="input-error"></div>
              </div>
              <div class="form-group col-md-6 p-2 mb-0">
                  <label class=" text-right font-weight-normal" for="phone">Ngày tạo</label>
                  <input type="text" class="form-control " readonly  id="phone"  value="{{$params['item']->created_at}}">
                  <div class="input-error"></div>
              </div>
            </div>
              
          @endif
        </div>

        <div class="card bg-light mt-4">
            <div class="card-header d-flex justify-content-between">
                <h3 class="card-title text-primary" style="color: #2a85ff;">
                    <i class="fa-solid fa-clock"></i> Nhân viên xử lý
                </h3>
            </div>
            <div class="p-2">
              @if ($params['item']->approver)
                <div class="px-3">
                  <div class="form-group  mb-0">
                    <label class=" text-right " for="">
                      {{$params['item']['approve_at']}}
                    </label>
                    <div class="">
                      Nhân viên {{$params['item']->approver->full_name}} đã xử lý thông tin này.
                    </div>
                  </div>
                  <div class="mt-2">
                      <label class=" text-right " >
                        Ghi chú
                      </label>
                     <div>
                      {{$params['item']->note}}
                     </div>
                  </div>
                </div>
              @else
                    <div class="alert alert-warning mt-4 text-center">Thông tin chưa được xử lý</div>
              @endif
            </div>
            
            
        </div>
          
      </div>
    </div>
  </div>
</div>
