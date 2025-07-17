<style>

</style>
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Thông tin quản lý</h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body px-1 row">
        
        <div class="form-group col-md-8 p-2 px-3 mb-0">
            <label class="col-form-label" for="customer_ids">Thêm nhân viên</label>
                {!! \App\Models\Hotel\HotelModel::selectCustomer() !!}
            <div class="input-error"></div>
        </div>
        <div class="form-group col-md-4 p-2 px-3 mb-0">
            <label class="col-form-label" for="customer_ids">Vai trò</label>
                {!! \App\Models\Hotel\HotelModel::selectRole(null,'role','lg') !!}
            <div class="input-error"></div>
        </div>
    </div>
</div>
<script>
    
    
</script>
