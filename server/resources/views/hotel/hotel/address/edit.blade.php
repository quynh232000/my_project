<style>
    .cursor-pointer{
        cursor: pointer;
    }
    .is-invalid ~ .select2 .select2-selection {
        border: 1px solid red;
    }
</style>
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Địa chỉ</h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body hotel_address row m-0 px-0 px-1  pt-2">
          {!! \App\Helpers\Template::address([
                                    'country_id'    => $params['item']['country_id'] ?? '',
                                    'city_id'       => $params['item']['city_id'] ?? '',
                                    'district_id'   => $params['item']['district_id'] ?? '',
                                    'ward_id'       => $params['item']['ward_id'] ?? ''
            ],[
                'class_label'   => '',
                'class_group'   => 'col-12 col-lg-6 form-group p-2 mb-0',
                'required'      => true
            ]) !!}
        <div class="form-group col-12  p-2 mb-0">
            <label  for="address">Địa chỉ <span style="color: red">(*)</span></label>
            <input type="text" class="form-control" id="address" value="{{$params['item']['address']}}" name="address"
                placeholder="42 Phan Bội Châu..">
            <div class="input-error"></div>
        </div>
        <div class=" col-12  p-2 mb-0 parent_location">
            <div class="d-flex"> 
                <div class=" pr-4 cursor-pointer">
                    <input type="radio" name="location_type" value="location_coordinate" checked id="location_type1">
                    <label  for="location_type1" class="m-0">Tọa độ</label>
                </div>
                <div class="cursor-pointer">
                    <input type="radio" value="location_link" name="location_type" id="location_type2">
                    <label  for="location_type2" class="m-0">Link Google map</label>
                </div>
            </div>
            <div  class="location_link pt-2 form-group" style="display: none">
                <input type="text" class="form-control input_location_link" id="location_link" placeholder="Nhập link Google map địa chỉ.." >
                <div class="input-error"></div>
            </div>
            <div class="row ">
                <div class="form-group col-12 col-lg-6  p-2 mb-0">
                    <label  for="longitude" class="font-weight-normal">Kinh độ</label>
                    <input type="text" class="form-control longitude" value="{{$params['item']['longitude']}}" id="longitude" name="longitude"
                        placeholder="Nhập..">
                    <div class="input-error"></div>
                </div>
                <div class="form-group col-12 col-lg-6  p-2 mb-0">
                    <label  for="latitude" class="font-weight-normal">Vĩ độ</label>
                    <input type="text" class="form-control latitude" value="{{$params['item']['latitude']}}" id="latitude" name="latitude"
                        placeholder="Nhập..">
                    <div class="input-error"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        const addressEl = '.hotel_address'
        $(`input[name='location_type']`).on('change',function(){// select location address
            const type = $(this).val()
            const parentEl = $(this).closest('.parent_location')
            if(type == 'location_coordinate'){
                $(parentEl).find('.location_link').hide()
            }else{
                $(parentEl).find('.location_link').show()
            }
            $(parentEl).find('.location_link input').val('')
        })
        $(document).on('change','.input_location_link' ,function() {//show latitude and longitude from input link google map
            const parent = $(this).closest('.parent_location')
            const error = $(this).parents('.form-group').find('.input-error')
            error.text('')
            error.html('');
            error.hide();
            $(this).removeClass('is-invalid');
            const url = $(this).val()
            if (!url) return false
            const regex = /@(-?\d+\.\d+),(-?\d+\.\d+)/;
            const matches = url.match(regex);
            if (matches) {
                const latitude = parseFloat(matches[1]);
                const longitude = parseFloat(matches[2]);
                $(parent).find('input.latitude').val(latitude)
                $(parent).find('input.longitude').val(longitude)
            } else {
                $(parent).find('input.latitude').val('')
                $(parent).find('input.longitude').val('')
                error.html('Link không đúng định dạng');
                error.show();
                $(this).addClass('is-invalid');
            }

            // add name location 
            const nameLocation = extractPlaceNameFromUrl(url)
            if(nameLocation){
                $(parent).find('input.name')?.val(nameLocation)
            }
        })
        function extractPlaceNameFromUrl(url) {
            const pattern = /\/place\/([^\/?]+)/;
            const match = url.match(pattern);
            if (match) {
                const placeName = decodeURIComponent(match[1]);
                return placeName.replace(/\+/g, ' ');
            }
            return false;
        }
    })
</script>
