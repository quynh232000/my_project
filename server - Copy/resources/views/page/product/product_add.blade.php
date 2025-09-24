@extends('layout.app')
@section('view_title')
    Thêm sản phẩm mới
@endsection
@push('js1')
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
@endpush
@section('main')
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-sm mb-2 mb-sm-0">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-no-gutter">
                            <li class="breadcrumb-item"><a class="breadcrumb-link" href="javascript:;">Quản trị</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Sản phẩm</li>
                        </ol>
                    </nav>

                    <h1 class="page-header-title">Thêm sản phẩm mới</h1>
                </div>

            </div>
        </div>
        <div class="row">
            <div class="col-12">
                @if (session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @if ($errors->any())
                    <div class="alert alert-warning">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li><small>{{ $error }}</small></li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        </div>

        <form id="form_add_product" method="post" enctype="multipart/form-data" action="{{ route('product._add') }}"
            class="row">
            @csrf
            <div class="col-lg-8">
                <!-- Card -->
                <div class="card mb-3 mb-lg-5">
                    <!-- Header -->
                    <div class="card-header">
                        <h4 class="card-header-title">Thông tin sản phẩm</h4>
                    </div>
                    <!-- End Header -->

                    <!-- Body -->
                    <div class="card-body">
                        <!-- Form Group -->
                        <div class="form-group">
                            <label for="productNameLabel" class="input-label">Tên <small
                                    class="text-danger">*</small></label>

                            <input type="text" class="form-control" name="name" value="{{ old('name') }}"
                                id="productNameLabel" placeholder="Áo thun nam..." aria-label="Shirt, t-shirts, etc.">
                            @error('name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <!-- Form Group -->
                                <div class="form-group">
                                    <label for="origin" class="input-label">Nguồn gốc <small
                                            class="text-danger">*</small></label>

                                    <input type="text" value="{{ old('origin') }}" class="form-control" name="origin"
                                        id="origin" placeholder="Việt Nam, Trung Quốc,.." aria-label="eg. 348121032">
                                    @error('origin')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <!-- End Form Group -->
                            </div>

                            <div class="col-sm-6">
                                <!-- Form Group -->
                                <div class="form-group">
                                    <label for="brand" class="input-label">Thương hiệu <small
                                            class="text-danger">*</small></label>

                                    <div class="input-group input-group-merge">
                                        <input value="{{ old('brand_value') }}" type="text" class="form-control"
                                            name="brand_value" id="brand" placeholder="Aple, Gucci,.." aria-label="0.0">
                                        <div class="input-group-append">
                                            <!-- Select -->
                                            <div id="brand_select" class="select2-custom select2-custom-right">
                                                <select class="js-select2-custom custom-select" size="1"
                                                    style="opacity: 0;" name="brand_id"
                                                    data-hs-select2-options='{
                                                        "dropdownParent": "#brand_select",
                                                        "dropdownAutoWidth": true,
                                                        "width": true
                                                        }'>
                                                    <option value="">--Chọn--</option>
                                                    @foreach ($brands as $item)
                                                        <option {{ old('brand_id') == $item->id ? 'selected' : '' }}
                                                            value="{{ $item->id }}">{{ $item->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <!-- End Select -->
                                        </div>
                                    </div>
                                    @error('brand_value')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                    @error('brand_id')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <!-- End Form Group -->
                            </div>
                        </div>
                        <!-- End Form Group -->

                        <div class="row">
                            <div class="col-sm-6">
                                <!-- Form Group -->
                                <div class="form-group">
                                    <label for="price" class="input-label">Giá nhập (vnd) <small
                                            class="text-danger">*</small></label>
                                    <input type="number" class="form-control" value="{{ old('price') }}" name="price"
                                        id="price" placeholder="0" aria-label="eg. 348121032">
                                    @error('price')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <!-- End Form Group -->
                            </div>
                            <div class="col-sm-6">
                                <!-- Form Group -->
                                <div class="form-group">
                                    <label for="percent_sale" class="input-label">Khuyễn mãi (%)</label>
                                    <input type="number" class="form-control" value="{{ old('percent_sale') }}"
                                        name="percent_sale" id="percent_sale" placeholder="0" value="0"
                                        aria-label="">
                                </div>
                                <!-- End Form Group -->
                            </div>
                        </div>
                        <!-- End Row -->
                        <label class="input-label">Mô tả sản phẩm <small class="text-danger">*</small></label>

                        <!-- Quill -->
                        {{-- <div id="editor-container" style="height: 220px">

                        </div> --}}
                        <div class="quill-custom">
                            <div class="js-quill" id="editor-container" style="min-height: 15rem;">

                            </div>
                            <input type="text"value="" id="input_description" name="description" hidden>
                            @error('description')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <!-- End Quill -->
                    </div>
                    <!-- Body -->
                </div>
                <!-- End Card -->

                <!-- Card -->
                <div class="card mb-3 mb-lg-5">
                    <!-- Header -->
                    <div class="card-header">
                        <h4 class="card-header-title">Media</h4>


                    </div>
                    <!-- End Header -->
                    <style>
                        .object-fit-cover {
                            object-fit: cover !important;
                        }
                    </style>
                    <!-- Body -->
                    <div class="card-body">
                        <div class="row">
                            <label for="imageInput" class="col-md-4 border-right">
                                <div class="mb-2">Ảnh bìa <small class="text-danger">*</small></div>
                                <div style="height: 180px; " class="border">
                                    <img id="imagePreview" class="w-100 h-100 object-fit-cover"
                                        src="{{ asset('assets/img/quin/image.jpg') }}" alt="">
                                </div>
                                <input type="file" name="image" accept="image/*" value="{{ old('image') }}"
                                    id="imageInput" hidden>
                                @error('image')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                                <div class="d-flex justify-content-center mt-2">
                                    <label for="imageInput" class="btn btn-primary">Tải lên </label>
                                </div>
                                <script>
                                    document.getElementById("imageInput").addEventListener("change", function(event) {
                                        const file = event.target.files[0];
                                        if (file) {
                                            const reader = new FileReader();
                                            reader.onload = function(e) {
                                                const imagePreview = document.getElementById("imagePreview");
                                                imagePreview.src = e.target.result;
                                            };
                                            reader.readAsDataURL(file);
                                        }
                                    });
                                </script>
                            </label>
                            <div class="col-md-8">
                                <div class="mb-2">Ảnh sản phẩm <small class="text-danger">*</small></div>
                                <label for="imageInputs" class=" d-flex justify-content-center" style="flex-wrap: wrap"
                                    id="list-image" style="gap: 5px">
                                    <div style="height: 180px; width:180px" class="border p-2">
                                        <img id="imagePreview" class="w-100 h-100 object-fit-cover"
                                            src="{{ asset('assets/img/quin/images.jpg') }}" alt="">
                                    </div>
                                </label>
                                <input type="file" accept="image/*" value="{{ old('images') }}" multiple
                                    name="images[]" id="imageInputs" hidden>
                                @error('images')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                                <div class="d-flex justify-content-center mt-2">
                                    <label for="imageInputs" class="btn btn-primary">Tải lên</label>
                                </div>
                            </div>
                            <script>
                                document.getElementById("imageInputs").addEventListener("change", previewImages);

                                function previewImages(event) {
                                    const files = event.target.files;
                                    const previewContainer = document.getElementById("list-image");
                                    previewContainer.innerHTML = "";
                                    Array.from(files).forEach((file) => {
                                        if (file.type.startsWith("image/")) {
                                            const reader = new FileReader();
                                            reader.onload = (e) => {
                                                const imghtml = `
                                                <div style="height: 180px; width:180px" class="border p-2">
                                                    <img id="imagePreview" class="w-100 h-100 object-fit-cover"
                                                        src="${e.target.result}" alt="">
                                                </div>
                                                `
                                                previewContainer.insertAdjacentHTML("beforeend", imghtml);
                                            };
                                            reader.readAsDataURL(file);
                                        }
                                    });
                                }
                            </script>

                        </div>
                    </div>
                    <!-- Body -->
                </div>
                <!-- End Card -->
                <div class="card mb-3 mb-lg-5">
                    <!-- Header -->
                    <div class="card-header">
                        <h4 class="card-header-title">Video sản phẩm <small class="text-danger">*</small></h4>
                    </div>
                    <!-- End Header -->
                    <style>
                        .object-fit-cover {
                            object-fit: cover !important;
                        }
                    </style>
                    <!-- Body -->
                    <div class="card-body">
                        <div class="row">
                            <label for="videoInput" class="col-md-8 m-auto ">
                                <div id="videoPreviewContainer" style="height: 240px; "
                                    class=" d-flex justify-content-center align-items-center">
                                    <div class="" style="width:80px">
                                        <img id="imagePreview" class="w-100 h-100 object-fit-cover"
                                            src="{{ asset('assets/img/quin/video.png') }}" alt="">
                                    </div>
                                </div>
                                <input value="{{ old('video') }}" accept="video/*" type="file" id="videoInput"
                                    name="video" accept="video/*" hidden>
                                <div class="d-flex justify-content-center mt-2">
                                    <label for="videoInput" class="btn btn-primary">Tải lên</label>
                                </div>
                                <script>
                                    document.getElementById("videoInput").addEventListener("change", previewVideo);

                                    function previewVideo(event) {

                                        const file = event.target.files[0];
                                        const previewContainer = document.getElementById("videoPreviewContainer");

                                        // Clear any existing preview
                                        previewContainer.innerHTML = "";

                                        if (file && file.type.startsWith("video/")) {
                                            const video = document.createElement("video");
                                            video.controls = true;
                                            video.width = 320; // Set width for the video preview (optional)
                                            video.height = 240; // Set height for the video preview (optional)

                                            const reader = new FileReader();
                                            reader.onload = (e) => {
                                                video.src = e.target.result;
                                                previewContainer.appendChild(video); // Add the video element to the container

                                            };
                                            reader.readAsDataURL(file); // Read the file as a data URL
                                        } else {
                                            previewContainer.innerHTML = "<p>Please select a valid video file.</p>";
                                        }
                                    }
                                </script>
                            </label>
                        </div>
                    </div>
                    <!-- Body -->
                </div>
                <!-- Card -->
                <div class="card">
                    <!-- Header -->
                    <div class="card-header">
                        <h4 class="card-header-title">Thuộc tính</h4>
                    </div>
                    <!-- End Header -->
                    <div class="card-body">
                        <div class="js-add-field">
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label for="" class="input-label">Tên thuộc tính <small
                                                class="text-danger">*</small></label>
                                        <div class="input-group input-group-merge">
                                            <input type="text" class="form-control" name="attribute_name[]"
                                                id="" placeholder="Chất liệu,.." aria-label="0.0">

                                            <div>
                                                <select class=" form-control" name="attribute_name_id[]">
                                                    <option value="">--Chọn--</option>
                                                    @foreach ($attribute_names as $item)
                                                        <option value="{{ $item->id }}">{{ $item->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-7">
                                    <div class="form-group">
                                        <label for="weightLabel" class="input-label">Giá trị <small
                                                class="text-danger">*</small></label>

                                        <div class="d-flex">
                                            <input type="text" name="attribute_value[]" placeholder="Aa.."
                                                class="form-control">
                                            <button disabled class=" btn btn-sm btn-secondary">Xóa</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="list_attribute_contain">
                            </div>
                            <div id="add_attribute" class="js-create-field btn btn-sm btn-no-focus btn-ghost-primary">
                                <i class="tio-add"></i> Thêm thuộc tính
                            </div>
                        </div>
                    </div>
                    <!-- Body -->
                </div>

            </div>

            <div class="col-lg-4">
                <div class="card mb-4">
                    <!-- Header -->
                    <div class="card-header">
                        <h4 class="card-header-title">Danh mục</h4>
                    </div>
                    <!-- End Header -->

                    <!-- Body -->
                    <div class="card-body">
                        <!-- Form Group -->
                        <div class="form-group">
                            <label for="vendorLabel" class="input-label">Danh mục <small
                                    class="text-danger">*</small></label>
                            <select name="category_id" class="js-select2-custom custom-select" size="1"
                                style="opacity: 0;" id="categoryLabel"
                                data-hs-select2-options='{
                                "minimumResultsForSearch": "Infinity",
                                "placeholder": "Chọn danh mục"
                            }'>
                                <option label=""></option>
                                @foreach ($categories as $item)
                                    <option {{ old('category_id') == $item->id ? 'selected' : '' }}
                                        value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>


                    </div>
                    <!-- End Body -->
                </div>
                <!-- Card -->
                <div class="card mb-3 mb-lg-5">
                    <!-- Header -->
                    <div class="card-header">
                        <h4 class="card-header-title">Thông số</h4>
                    </div>
                    <!-- Body -->
                    <div class="card-body">
                        <!-- Form Group -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="stock" class="input-label">Kho hàng <small
                                            class="text-danger">*</small></label>
                                    <div class="input-group">
                                        <input type="text" value="{{ old('stock') }}" class="form-control"
                                            name="stock" id="stock" placeholder="0.00" aria-label="0.00">
                                    </div>
                                    @error('stock')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="priority" class="input-label">Thứ tự</label>
                                    <div class="input-group">
                                        <input type="number" value="{{ old('priority') }}" value="1"
                                            min="1" class="form-control" name="priority" id="priority"
                                            placeholder="0" aria-label="">
                                    </div>

                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="sku" class="input-label">SKU</label>
                                    <div class="input-group">
                                        <input type="text" value="{{ old('sku') }}" value=""
                                            class="form-control" name="sku" id="sku" placeholder=""
                                            aria-label="">
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Body -->
                </div>
                <div class="card mb-3 mb-lg-5">
                    <!-- Header -->
                    <div class="card-header">
                        <h4 class="card-header-title">Vận chuyển</h4>
                    </div>
                    <!-- Body -->
                    <div class="card-body">
                        <!-- Form Group -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="length" class="input-label">Chiều dài (cm) <small
                                            class="text-danger">*</small></label>
                                    <div class="input-group">
                                        <input type="number" value="{{ old('length') ?? 10 }}" class="form-control"
                                            name="length" id="length" placeholder="0" aria-label="0.00">
                                    </div>
                                    @error('length')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="width" class="input-label">Chiều rộng (cm) <small
                                            class="text-danger">*</small></label>
                                    <div class="input-group">
                                        <input type="number" class="form-control" value="{{ old('width') ?? 10 }}"
                                            name="width" id="width" placeholder="0" aria-label="0.00">
                                    </div>
                                    @error('width')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="heigth" class="input-label">Chiều cao (cm) <small
                                            class="text-danger">*</small></label>
                                    <div class="input-group">
                                        <input type="number" class="form-control" value="{{ old('height') ?? 10 }}"
                                            name="height" id="heigth" placeholder="0" aria-label="0">
                                    </div>
                                    @error('height')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="weight" class="input-label">Cân nặng (gr) <small
                                            class="text-danger">*</small></label>
                                    <div class="input-group">
                                        <input type="number" class="form-control" value="{{ old('weight') ?? 10 }}"
                                            name="weight" id="weight" placeholder="0" aria-label="0">
                                    </div>
                                    @error('weight')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Body -->
                    <div class="mt-5">
                        <button type="submit" class="btn btn-primary w-100">Tạo sản phẩm</button>
                    </div>
                </div>

            </div>
        </form>
        <!-- End Row -->

        {{-- <div class="position-fixed bottom-0 content-centered-x w-100 z-index-99 mb-3" style="max-width: 40rem;">
            <!-- Card -->
            <div class="card card-sm bg-dark border-dark mx-2">
                <div class="card-body">
                    <div class="row justify-content-center justify-content-sm-between">
                        <div class="col">
                            <button type="button" class="btn btn-ghost-danger">Delete</button>
                        </div>
                        <div class="col-auto">
                            <button type="button" class="btn btn-ghost-light mr-2">Discard</button>
                            <button type="button" class="btn btn-primary">Save</button>
                        </div>
                    </div>
                    <!-- End Row -->
                </div>
            </div>
            <!-- End Card -->
        </div> --}}
    </div>
@endsection
@push('js2')
    <script>
        var quill = new Quill('#editor-container', {
            theme: 'snow'
        });
        $('#form_add_product').submit(function() {
            $('input[name="description"]').val(quill.root.innerHTML);
        })
        // add attribute
        let indexAttr = 0;
        $('#add_attribute').click(function() {
            indexAttr++
            const html = `
                <div class="row item_attr">
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="weightLabel${indexAttr}" class="input-label">Tên thuộc tính <small class="text-danger">*</small></label>
                            <div class="input-group input-group-merge">
                                <input type="text" class="form-control" name="attribute_name[]"
                                    id="weightLabel${indexAttr}" placeholder="Mẫu, chất liệu,.." aria-label="0.0">
                                <div>
                                    <select class=" form-control" name="attribute_name_id[]">
                                        <option value="">--Chọn--</option>
                                        @foreach ($attribute_names as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-7">
                        <div class="form-group">
                            <label for="weightLabel" class="input-label">Giá trị <small class="text-danger">*</small></label>

                            <div class="d-flex">
                                <input type="text" name="attribute_value[]" placehoder="Aa.." class="form-control">
                                <button  class="btn_delete_attr btn btn-sm btn-danger">Xóa</button>
                            </div>
                        </div>
                    </div>
                </div>

            `
            $('#list_attribute_contain').append(html)
            $('.btn_delete_attr').click(function() {
                const parent = $(this).closest('.item_attr')
                if (parent) {
                    parent.remove()
                }
            })
        })

    </script>
@endpush
