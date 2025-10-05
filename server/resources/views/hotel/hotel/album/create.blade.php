<style>
    .img_show_delete {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        display: none;
        justify-content: center;
        align-items: center;
        background-color: rgba(22, 22, 24, .6)
    }

    .img_item_wrapper:hover .img_show_delete {
        display: flex;
        transition: .3s ease all;
        cursor: pointer;
    }

    .image-wrapper {
        height: 120px;
    }

    .image-wrapper img {
        height: 100%;
        object-fit: cover;
    }
</style>
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Media</h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body px-2 row p-2">

        <div class="form-group col-12 p-2 mb-0">

            <div class="row">
                <div class="col-12 image-preview-container d-flex flex-wrap">
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="form-group col-12 p-2 mb-0">
                        <label class="col-form-label col-12" for="image">Thumbnail</label>
                        <x-admin.input.upload :name="'image'"></x-admin.input.upload>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group col-md-12 p-2 px-2 mb-4">
            <label class="col-form-label" for="contract_file">File hợp đồng </label>
            <div class="custom-file">
                <input type="file" class="form-control" name="contract_file" id="contract_file"
                    accept=".pdf, .doc, .docx, .xls, .xlsx">
            </div>
            <div class="input-error"></div>
        </div>


    </div>
</div>
