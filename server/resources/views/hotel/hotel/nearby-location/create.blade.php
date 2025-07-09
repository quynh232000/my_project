<div class="d-flex align-items-center" style="justify-content: space-between">
    <h4 class="py-2">Địa điểm lân cận</h4>
</div>
<div class=" nearby_location">
    <div class="card">
        <!-- /.card-header -->
        <div class="card-body p-2">
            <div class="row m-0 border-bottom parent_location template_location location_item" style="display: none">
                <div class="form-group col-12 col-lg-4 p-2 mb-0">
                    <label class="col-form-label text-right" for="">
                        Tên địa điểm
                        <span style="color: red">(*)</span>
                    </label>
                    <input type="text" class="form-control name"  name="location[0][name]"  placeholder="Nhập tên.." value="">
                    <div class="input-error"></div>
                </div>
                <div class="form-group col-12 col-lg-8  p-2 mb-0">
                    <div class="d-flex justify-content-between">
                        <label for="address" class="col-form-label text-right">Địa chỉ chi tiết <span style="color: red">(*)</span></label>
                        <button class="btn btn-danger btn-sm location_delete" style="height: fit-content">
                            <i class="fa-regular fa-trash-can"></i>
                        </button>
                    </div>
                    <input type="text" class="form-control"  name="location[0][address]" placeholder="42 Phan Bội Châu..">
                    <div class="input-error"></div>
                </div>
                <div class="form-group col-12 col-lg-4  p-2 mb-0">
                    <label for="" >Kinh độ <span  style="color: red">(*)</span></label>
                    <input type="text" class="form-control longitude"  name="location[0][longitude]" placeholder="Nhập..">
                    <div class="input-error"></div>
                </div>
                <div class="form-group col-12 col-lg-4  p-2 mb-0">
                    <label for="" >Vĩ độ <span style="color: red">(*)</span></label>
                    <input type="text" class="form-control latitude"  name="location[0][latitude]" placeholder="Nhập..">
                    <div class="input-error"></div>
                </div>
                <div class="form-group col-12 col-lg-4  p-2 mb-0">
                    <label for="" >Hoặc Link Google map</label>
                    <input type="text" class="form-control input_location_link"   placeholder="Nhập link Google map..">
                    <div class="input-error"></div>
                </div>
            </div>
            <div class="list_location">

            </div>
            <button  class="btn btn-primary float-right btn_add_location my-2"><i class="fa-sharp fa-solid fa-plus"></i> Thêm địa điểm</button>
           
        </div>
        <!-- /.card-body -->
    </div>
</div><!-- /.row -->


<script>
   const template_location = $('.template_location').show().clone()
    $('.template_location').remove()//remove template in view
    let locationIndex         = 0;
    $('.btn_add_location').click(function(e){//add location
        e.preventDefault();
        const htmlApend       = template_location.clone();
        $(htmlApend).find('input[name^="location["]').each(function() {
            const currentName = $(this).attr('name');
            const newName     = currentName.replace(/\[0\]/, `[${locationIndex}]`);// replace index array input
            $(this).attr('name', newName);
        });
        $('.list_location').append(htmlApend);
        locationIndex ++;
    })
    $(document).on('click','.location_delete',function(e){// delete location
        e.preventDefault();
        $(this).parent().parent().parent().remove();
    })

</script>
