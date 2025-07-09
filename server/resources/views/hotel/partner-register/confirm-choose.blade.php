<div class="modal fade" id="confirm_formModalTooltip" tabindex="-1" role="dialog" aria-labelledby="confirm_deleteModalTooltip" >
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form onsubmit="return adminChangeTicket(this,'{{$params['url']}}')" id="confirm-change-ticket" role="form" method="POST"  action="{{$params['url']}}" enctype="multipart/form-data">
                @csrf 
                <input type="text" hidden name="id" value="{{$params['id']}}">
                <input type="text" hidden name="type" value="{{$params['type']}}">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="deleteModalLongTitle"><i class="mdi mdi-trash-can-outline mdi-18px"></i>
                        @if ($params['type'] == 'choose')
                            Xác nhận xử lý đăng ký đối tác
                        @else
                            Trạng thái xử lý đăng ký đối tác
                        @endif
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @if ($params['type'] == 'choose')
                        <h5>Xác nhận đồng ý với việc bạn sẽ xử lý đơn này!</h5>
                    @else
                        <div class="form-group col-12 p-2 mb-0">
                            <label class="col-form-label text-right" for="status">Trạng thái</label>
                            {!! \App\Models\Flight\ChangeTicketModel::slbStatus($params['item']['status']) !!}
                            <div class="input-error "></div>
                        </div>
                        <div class="form-group col-12 p-2 mb-0">
                            <label class="col-form-label text-right" for="admin_note">Nhân viên ghi chú</label>
                            <textarea class="form-control" name="admin_note" id="admin_note"  placeholder="Nhập ghi chú">{{$params['item']['admin_note']}}</textarea>
                            <div class="input-error "></div>
                        </div>
                    @endif
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-outline-danger btn-sm" data-dismiss="modal"><i class="mdi mdi-check-circle mdi-18px"></i>Bỏ qua</button>
                    <button type="submit" class="btn btn-success btn-sm" ><i class="mdi mdi-check-circle mdi-18px"></i>Xác nhận</button>
                </div>
            </form>
        </div>
    </div>
    <script>
        $('#status').select2()
    </script>
</div>