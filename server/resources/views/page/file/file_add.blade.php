@extends('layout.app')
@section('view_title')
    Thêm ảnh
@endsection
@section('main')
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-sm mb-2 mb-sm-0">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-no-gutter">
                            <li class="breadcrumb-item"><a class="breadcrumb-link" href="javascript:;">Quản trị</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Files</li>
                        </ol>
                    </nav>

                    <h1 class="page-header-title">Thêm ảnh mới</h1>
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
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card mb-3 mb-lg-5">
                    <!-- Header -->
                    <div class="card-header">
                        <h4 class="card-header-title">Hình ảnh</h4>
                        <!-- Unfold -->
                        <div class="hs-unfold">
                            <a class="js-hs-unfold-invoker btn btn-sm btn-ghost-secondary" href="javascript:;"
                                data-hs-unfold-options='{
                                 "target": "#mediaDropdown",
                                 "type": "css-animation"
                               }'>
                                Tải lên từ URL <i class="tio-chevron-down"></i>
                            </a>

                            <div id="mediaDropdown"
                                class="hs-unfold-content dropdown-unfold dropdown-menu dropdown-menu-right mt-1">
                                <a class="dropdown-item" href="javascript:;" data-toggle="modal"
                                    data-target="#addImageFromURLModal">
                                    <i class="tio-link dropdown-item-icon"></i> Add image from URL
                                </a>
                                <a class="dropdown-item" href="javascript:;" data-toggle="modal"
                                    data-target="#embedVideoModal">
                                    <i class="tio-youtube-outlined dropdown-item-icon"></i> Embed video
                                </a>
                            </div>
                        </div>
                        <!-- End Unfold -->
                    </div>
                    <form method="post" enctype="multipart/form-data" class="card-body">
                        @csrf
                        <!-- Dropzone -->
                        <label for="imageInput" id="attachFilesNewProjectLabel"
                            class="js-dropzone dropzone-custom custom-file-boxed">
                            <div class="dz-message custom-file-boxed-label">
                                <img id="imagePreview" class="avatar avatar-xl avatar-4by3 mb-3"
                                    src="{{ asset('assets\svg\illustrations\browse.svg') }}" alt="Image Description">
                                <h5 class="mb-1">Chọn ảnh để upload</h5>
                               
                            </div>
                            <input type="file" name="image" hidden id="imageInput">
                        </label>

                        <!-- End Dropzone -->
                        <div class="mt-5 d-flex justify-content-center w-100 ">
                            <button type="submit" class="btn btn-sm btn-primary px-5">Tải ảnh lên</button>
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
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
