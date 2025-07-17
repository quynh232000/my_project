<style>
    .img_show_delete{
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        display: none;
        justify-content: center;
        align-items: center;
        background-color: rgba(22,22,24,.6)
    }
    .img_item_wrapper:hover .img_show_delete{
        display: flex;
        transition: .3s ease all;
        cursor: pointer;
    }
    .image-wrapper{
        height: 120px;
    }
    .image-wrapper img{
        height: 100%;
        object-fit: cover;
    }
</style>
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Media</h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body px-2 row">
       
       <div class="form-group col-12 p-2 mb-0">
            <div class="row">
                <label class="col-form-label col-12" for="image">Ảnh bìa</label>
            </div>
            <div class="row">
                <div class="col-12 image-preview-container d-flex flex-wrap">
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="custom-file">
                        <input type="file" name="image" accept="image/*" class="custom-file-input image-input" >
                        <label class="custom-file-label">Chọn file</label>
                    </div>
                    <div class="input-error"></div>
                </div>
            </div>
        </div>
        <div class="form-group col-md-12 p-2 px-2 mb-4">
            <label class="col-form-label" for="contract_file">File hợp đồng </label>
            <div class="custom-file">
                <input type="file" class="custom-file-input" name="contract_file" id="contract_file" 
                    accept=".pdf, .doc, .docx, .xls, .xlsx"
                >
                <label class="custom-file-label" for="file">Chọn file</label>
            </div>
            <div class="input-error"></div>
        </div>

        {{-- abumn --}}
        {{-- <div class="form-group  col-12  mb-0 d-flex justify-content-end px-3">
            <button class="btn btn-primary btn_add_abumn">
                <i class="fa-sharp fa-solid fa-plus add_icon"></i>
                Tạo album
            </button>
        </div>
        <div class="col-12 " id="abumn">
            <div id="dropzone_template" hidden>
                <div class=" drop_zone col-12 col-md-3 col-2xl-3 col-xl-4 position-relative p-1 img_item" >
                    <div class="border position-relative img_item_wrapper">
                        <span class="mailbox-attachment-icon has-img">
                            <img style="height: 120px; object-fit:cover" data-dz-thumbnail class="w-100" src="" alt="Attachment">
                        </span>
                        <div style="flex:1" class=" img_show_delete ">
                            <button data-dz-remove  onclick="removeImage(this)" class="text-danger btn btn-default btn-sm">
                                <i class="fa-regular fa-trash-can"></i>
                            </button>
                        </div>
                    </div>
                    <div class="mt-2">
                        {!! \App\Models\Hotel\HotelModel::selectImageLabel() !!}
                    </div>
                    <i class="">
                        <small style="font-size: 12px d-flex justify-content-center align-items-center" class="error text-danger w-100" data-dz-errormessage></small>
                    </i>
                </div>
            </div>
        </div> --}}
    </div>
</div>
<script>
    
    const dropzone_templete = $('#dropzone_template').html()
    $('#dropzone_template').remove()
    let indexAbumn          = 0

    // Thêm album mới
    $('.btn_add_abumn').on('click', function(e) {//add new album
        e.preventDefault()
        addAlbum()
    })
    // Khởi tạo ảnh thumbnail
    addAlbum(true);
    function addAlbum(isThumb = false) {
        $('#abumn').append(`
                <div class=" abumn-item">
                    <label class="col-form-label text-right px-2" for="name">
                        <span class="text-normal" style="font-style: normal;font-weight: normal;">${isThumb ? '<strong>Ảnh bìa </strong>':'Album ảnh'}</span>
                    </label>
                    <div class=" px-2 d-flex form-group" style="gap: 10px">
                        ${isThumb ? `{!!\App\Models\Hotel\HotelModel::slbAlbumType(null,true)!!}`
                        :
                        `{!!\App\Models\Hotel\HotelModel::slbAlbumType(null,false)!!} 
                            <select onchange="handleSelectOpt(this)" class="form-control select2 select2-primary select_album_value" data-type=''   data-dropdown-css-class="select2-primary">
                                <option value="">-- Chọn --</option>
                            </select>`}
                        <div class="input-error"></div>
                    </div>
                    <div class="p-0 mb-0 abumn_item form-group">
                        <div class="dropzone dropzone border-dashed row mx-1" >
                            <input type="file" abumn-index="${indexAbumn}" name="abumn[${isThumb ? 'thumbnail':'other'}][]" multiple hidden>
                            <div class="dz-default dz-message text-secondary col-12 d-flex justify-content-center align-items-center">
                                <i class="fa-regular fa-images mr-2 fa-xl"></i> 
                                Tải lên hoặc kéo thả file ảnh
                            </div>
                        </div>
                        <div class="input-error"></div>
                    </div>
                </div>
            `)
        initDropzone('#abumn')
        indexAbumn++
        !isThumb && $('.abumn-item .select2').select2()
    }
    
    // initDropzone('.thumbnail')
    function initDropzone(element) {
        var myDropzone = new Dropzone(`${element} .abumn-item:last-child .dropzone`, {
            url: "#", // Đặt URL giả vì không tải lên
            paramName: "file", // Tên trường tệp (chỉ dùng cho mục đích tham khảo)
            maxFilesize: 2, // Kích thước tối đa (MB)
            acceptedFiles: "image/*", // Chỉ chấp nhận hình ảnh
            addRemoveLinks: false, // Cho phép người dùng xóa ảnh đã xem trước
            thumbnailWidth: 150, // Kích thước ảnh thu nhỏ
            thumbnailHeight: 150, // Kích thước ảnh thu nhỏ
            previewTemplate: dropzone_templete,
            autoProcessQueue: false, // Không tự động tải tệp lên khi được chọn
            uploadMultiple: false, // Không tải nhiều tệp cùng lúc
            // Tạo preview khi chọn tệp
            init: function() {
                var dropzoneElement                = this.element;
                dropzoneElement.style.border       = "2px dashed #dbdbdb"; // Chọn màu viền mới
                dropzoneElement.style.borderRadius = "12px";
                this.on("error", function(file, errorMessage) {
                    // Sự kiện khi tệp không hợp lệ (quá lớn hoặc không đúng định dạng)
                    let errorElement = file.previewElement.querySelector("[data-dz-errormessage]");
                    if (errorMessage.includes("File is too big")) {
                        errorElement.textContent = "Tệp quá lớn! Vui lòng chọn tệp nhỏ hơn 2MB.";
                    } else if (errorMessage.includes("You can't upload files of this type")) {
                        errorElement.textContent = "Loại tệp không hợp lệ! Vui lòng chọn tệp khác.";
                    } else {
                        errorElement.textContent = errorMessage; // Hiển thị lỗi mặc định
                    }
                });
                var dataTransfer    = new DataTransfer();
                var fileInput       = this.element.querySelector("input[type='file']");
                this.on("addedfile", function(file) {
                    let nameFile                    = ($(fileInput).attr('name'));//abumn[service|30][]
                    const matchName                 = nameFile.match(/\[(.*?)\]/)[1] ?? 'other';//edit:2046 service|30
                    $(dropzoneElement).find('.image_name').attr('name',`image_name[${matchName}][]`)// set name for each input image
                    $(dropzoneElement).find('.select2').select2()
                    dataTransfer.items.add(file);
                    fileInput.files = dataTransfer.files;
                });
                this.on("thumbnail", function(file, dataUrl) {
                    // Thêm logic tùy chỉnh cho ảnh thu nhỏ
                });
                // Khi tệp bị xóa khỏi Dropzone
                this.on("removedfile", function(file) {
                    // Loại bỏ tệp khỏi DataTransfer object
                    var newFileList = Array.from(dataTransfer.files).filter(f => f !==
                        file);
                    dataTransfer    = new DataTransfer();
                    newFileList.forEach(f => dataTransfer.items.add(f));
                    // Cập nhật lại giá trị của input file sau khi xóa tệp
                    fileInput.files = dataTransfer.files;
                });
            }
        });
        
    }
    
    // ================= start select type album =============
    function selectTypeImg(el){
        const nextSelect = $(el).closest('.form-group').find('.select_album_value')//tim select value
        const name = $(el).val() ?? 'other'
        let data         = []
        if(name == "type"){
            data = []
        }else if(name == "service"){
            data = @json($params['data']['facilities'])
        }
        // $(nextSelect).attr('name',`abumn[${name}][]`)
        nextSelect.empty() // xoa option cu
        
        $(nextSelect).attr('data-type',name)
        $(nextSelect).append(`<option value="other">-- Chọn --</option>`)
        
        data.forEach(i=>{
            $(nextSelect).append(`<option value="${i.id}">${i.name}</option>`)
        })
        // change name input
        $(el).closest('.abumn-item').find('input[type="file"]').attr('data-name',name)
        $(el).closest('.abumn-item').find('.image_name').attr('name',`image_name[${name}][]`)//update name input image
        
    }
    function handleSelectOpt (el){
        const fileEl  = $(el).closest('.abumn-item').find('input[type="file"]')
        const keyName = $(fileEl).attr('data-name') + '|' + $(el).val()
        $(fileEl).attr('name',`abumn[${keyName}][]`) // service|4;room|12;other,thumbnail
        $(el).closest('.abumn-item').find('.image_name').attr('name',`image_name[${keyName}][]`)//update name input image
        
    }
    
    // ================= end select type album =============
</script>
