@php
    function isValidDateTime($date, $format = 'Y-m-d H:i:s') {
        try {
            return \Carbon\Carbon::createFromFormat($format, $date) !== false;
        } catch (\Exception $e) {
            return false;
        }
    }
@endphp
<div class="modal  fade" id="modal-show">
  <div class="modal-dialog modal-dialog-centered modal-xl modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title d-flex align-items-center">
          <i class="fa-solid fa-hotel text-primary fa-xl mr-2"  style="font-size: 21px;color: #2a85ff;"></i> 
          {{$params['item']['title'] ?? 'Thông tin đăng ký đối tác'}}
      </h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="card">
            <div class="card-body pt-0 pb-2">
                <div class="row">
                    <div class="form-group col-md-3 p-2 mb-0">
                        <label class="col-form-label text-right" for="code">Mã đăng ký</label>
                        <input type="text" class="form-control"  id="code"  value="{{$params['item']['code']}}">
                        <div class="input-error"></div>
                    </div>
                    @php
                           $dataType = [
                              'pending'     => 'Chờ xử lý',
                              'processing'  => 'Đang xử lý',
                              'success'     => 'Hoàn thành',
                              'faild'       => 'Đã hủy',
                          ];
                          $status = $dataType[$params['item']['status']];
                      @endphp 
                    <div class="form-group col-md-3 p-2 mb-0">
                        <label class="col-form-label text-right" for="status">Trạng thái</label>
                        <input type="text" class="form-control "  id="status"  value="{{$status}}">
                        <div class="input-error"></div>
                    </div>
                   
                </div>
            </div>
        </div>
          <div class="card">
              <div class="card-header ">
                <h3 class="card-title text-primary" style="color: #2a85ff;">
                  <i class="fa-sharp fa-solid fa-address-card"></i>
                  Thông tin đối tác đăng ký
                </h3>
              </div>
              <div class="card-body">
                <dl class="row">
                  <dt class="col-sm-4">Tên khách sạn</dt>
                  <dd class="col-sm-8">{{$params['item']['title']}}</dd>
                  <dt class="col-sm-4">Họ tên</dt>
                  <dd class="col-sm-8">{{$params['item']['full_name']}}</dd>
                  <dt class="col-sm-4">Email</dt>
                  <dd class="col-sm-8">{{$params['item']['email']}}</dd>
                  <dt class="col-sm-4">Số điện thoại</dt>
                  <dd class="col-sm-8">{{$params['item']['phone']}}</dd>

                  <dt class="col-sm-4">Ghi chú</dt>
                  <dd class="col-sm-8">{{$params['item']['note']}}</dd>
                  <dt class="col-sm-4 mt-2">IP</dt>
                  <dd class="col-sm-8 mt-2">{{$params['item']['ip']}}</dd>
                 
                </dl>
               
              </div>
          </div>

          <div class="card bg-light">
              <div class="card-header d-flex justify-content-between">
                  <h3 class="card-title text-primary" style="color: #2a85ff;">
                      <i class="fa-solid fa-clock"></i> Trạng thái xử lý
                  </h3>
              </div>
              <div class="card-body">
                  <div class="timeline">
                      <div class="time-label">
                        <span class="bg-primary">{{ $params['item']['created_at']}}</span>
                      </div>
                      
                      @if ($params['item']['updated_by'])
                          <div class="mt-4">
                              <i class="fas fa-user-check bg-info pl-1"></i>
                              <div class="timeline-item">
                                  <span class="time"><i class="fas fa-clock mr-2"></i>{{$params['item']['updated_at']}}</span>
                                  <h3 class="timeline-header no-border">Nhân viên <a href="#">{{$params['item']['created_by']}}</a> đã cập nhật trạng thái</h3>
                                  @if ($params['item']['admin_note'])
                                      <div class="timeline-body">
                                        <span style="font-weight: bold">Ghi chú: </span>
                                      {{$params['item']['admin_note']}}
                                      </div>
                                  @endif
                              </div>
                          </div>
                      @endif
                      @if ($params['item']['created_by'])
                          <div class="mt-4">
                              <i class="fas fa-user bg-blue"></i>
                              <div class="timeline-item">
                                  <span class="time"><i class="fas fa-clock mr-2"></i>{{\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $params['item']['processing_at'])->format('Y-m-d H:i:s')}}</span>
                                  <h3 class="timeline-header no-border">Nhân viên <a href="#">{{$params['item']['created_by']}}</a> đã chọn xử lý</h3>
                              </div>
                          </div>
                      @endif

                      <div class="mt-4">
                          <i class="fas fa-clock bg-green"></i>
                          <div class="timeline-item">
                              <span class="time"><i class="fas fa-clock mr-2"></i>{{$params['item']['created_at']}}</span>
                              <h3 class="timeline-header no-border">Khách hàng <a href="#">{{$params['item']['full_name']}}</a> đã gửi yêu cầu đăng ký đối tác</h3>
                          </div>
                      </div>
                    </div>
              </div>
          </div>
          
      </div>
    </div>
  </div>
</div>
