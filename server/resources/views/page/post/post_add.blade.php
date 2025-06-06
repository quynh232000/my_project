@extends('layout.app')
@section('view_title')
    @if ($post)
        {{ $post->title }}
    @else
        Thêm bài viết mới
    @endif
@endsection
@push('js1')
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
@endpush
@section('main')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-sm mb-2 mb-sm-0">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-no-gutter">
                            <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ route('dashboard') }}">Trang
                                    chủ</a></li>
                            <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ route('post.list') }}">Bài viết
                                </a></li>
                            <li class="breadcrumb-item active" aria-current="page">
                                {{ $post ? 'Cập nhật bài viết' : 'Thêm bài viết mới' }}</li>
                        </ol>
                    </nav>

                    <h1 class="page-header-title">{{ $post ? 'Cập nhật bài viết' : 'Thêm bài viết mới' }}</h1>
                </div>
            </div>
            <!-- End Row -->
        </div>
        <!-- End Page Header -->
        <div class="js-step-form py-md-5">
            <div>
                @if (session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
            </div>
            <div class="row justify-content-lg-center">
                <div class="col-lg-8">
                    <div id="addUserStepFormContent">
                        <!-- Card -->
                        @if ($post)
                            <form method="post" action="{{ route('post._update', ['id' => $post->id]) }}" id="form-add-post"
                                class="card card-lg active" enctype="multipart/form-data">
                                @csrf
                                <!-- Body -->
                                <div class="card-body">
                                    <!-- Form Group -->
                                    <div class="row form-group">
                                        <label class="col-sm-3 col-form-label input-label">Ảnh</label>

                                        <div class="col-sm-9">
                                            <div class="d-flex align-items-center">
                                                <!-- Avatar -->
                                                <label class=" mr-5 w-100" for="avatarUploader">
                                                    <img id="avatarImg" class=""
                                                        style="width:100%;height:160px;object-fit:cover"
                                                        src="{{ $post->thumbnail ?? asset('assets\img\quin\bg1.avif') }}"
                                                        alt="Image Description" />

                                                    <input type="file" name="thumbnail"
                                                        class="js-file-attach avatar-uploader-input" id="avatarUploader" />

                                                    <span class="avatar-uploader-trigger">
                                                        <i class="tio-edit avatar-uploader-icon shadow-soft"></i>
                                                    </span>
                                                </label>
                                                <script>
                                                    document.getElementById('avatarUploader').addEventListener('change', function(event) {
                                                        const file = event.target.files[0];
                                                        if (file) {
                                                            const reader = new FileReader();
                                                            reader.onload = function(e) {
                                                                const preview = document.getElementById('avatarImg');
                                                                preview.src = e.target.result;
                                                                preview.style.display = 'block';
                                                            }
                                                            reader.readAsDataURL(file);
                                                        }
                                                    });
                                                </script>
                                                <!-- End Avatar -->
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Form Group -->

                                    <!-- Form Group -->
                                    <div class="row form-group">
                                        <label for="firstNameLabel" class="col-sm-3 col-form-label input-label">Tiêu đề
                                            <span class="text-danger">*</span>
                                            <i class="tio-help-outlined text-body ml-1" data-toggle="tooltip"
                                                data-placement="top"
                                                title="Displayed on public forums, such as Front."></i></label>

                                        <div class="col-sm-9">
                                            <div class="input-group input-group-sm-down-break">
                                                <input type="text" class="form-control"
                                                    value="{{ old('title') ?? $post->title }}" name="title"
                                                    id="firstNameLabel" placeholder="Clarice" aria-label="Clarice" />
                                            </div>
                                            @error('title')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <!-- End Form Group -->

                                    <!-- Form Group -->
                                    <div class="row form-group">
                                        <label for="emailLabel" class="col-sm-3 col-form-label input-label">Danh mục <span
                                                class="text-danger">*</span></label>

                                        <div class="col-sm-9">
                                            <select name="category_post_id" id="" class="form-control">
                                                <option value="">--Chọn--</option>
                                                @foreach ($categories as $item)
                                                    <option value="{{ $item->id }}"
                                                        {{ old('category_post_id') == $item->id ? 'selected' : ($post->category_post_id == $item->id ? 'selected' : '') }}>
                                                        {{ $item->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @error('email')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="row form-group">
                                        <label for="emailLabel" class="col-sm-3 col-form-label input-label">Hashtag</label>

                                        <div class="col-sm-9">
                                            @php
                                                $tagsvalue = '';
                                                if ($post->post_tags->count() > 0) {
                                                    $tags = [];
                                                    foreach ($post->post_tags as $item) {
                                                        $tags[] = $item->tag->tag_name;
                                                    }
                                                    $tagsvalue = implode(', ', $tags);
                                                }
                                            @endphp
                                            <input type="text" value="{{ old('hashtag') ?? $tagsvalue }}"
                                                class="js-masked-input form-control" name="hashtag" id=""
                                                placeholder="thoisu, tintuc,.." />
                                        </div>
                                    </div>

                                    <div class="row form-group mt-5">
                                        <label for="organizationLabel" class="col-sm-3 col-form-label input-label">Nội dung
                                        </label>

                                        <div class="col-sm-9">
                                            <div class="quill-custom">
                                                <div class="js-quill" id="editor-container" style="min-height: 15rem;">
                                                    {!! $post->content !!}
                                                </div>
                                                <input type="text"value="{{ old('content') ?? $post->content }}"
                                                    id="content" name="content" hidden>
                                                @error('description')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Form Group -->

                                    <!-- End Form Group -->
                                </div>
                                <!-- End Body -->

                                <!-- Footer -->
                                <div class="card-footer d-flex justify-content-end align-items-center">
                                    <button type="submit" class="btn btn-primary">
                                        Cập nhật bài viết<i class="tio-chevron-right"></i>
                                    </button>
                                </div>
                                <!-- End Footer -->
                            </form>
                        @else
                            <form method="post" action="{{ route('post._add') }}" id="form-add-post"
                                class="card card-lg active" enctype="multipart/form-data">
                                @csrf
                                <!-- Body -->
                                <div class="card-body">
                                    <!-- Form Group -->
                                    <div class="row form-group">
                                        <label class="col-sm-3 col-form-label input-label">Ảnh</label>

                                        <div class="col-sm-9">
                                            <div class="d-flex align-items-center">
                                                <!-- Avatar -->
                                                <label class=" mr-5 w-100" for="avatarUploader">
                                                    <img id="avatarImg" class=""
                                                        style="width:100%;height:160px;object-fit:cover"
                                                        src="{{ asset('assets\img\quin\bg1.avif') }}"
                                                        alt="Image Description" />

                                                    <input type="file" name="thumbnail"
                                                        class="js-file-attach avatar-uploader-input"
                                                        id="avatarUploader" />

                                                    <span class="avatar-uploader-trigger">
                                                        <i class="tio-edit avatar-uploader-icon shadow-soft"></i>
                                                    </span>
                                                </label>
                                                <script>
                                                    document.getElementById('avatarUploader').addEventListener('change', function(event) {
                                                        const file = event.target.files[0];
                                                        if (file) {
                                                            const reader = new FileReader();
                                                            reader.onload = function(e) {
                                                                const preview = document.getElementById('avatarImg');
                                                                preview.src = e.target.result;
                                                                preview.style.display = 'block';
                                                            }
                                                            reader.readAsDataURL(file);
                                                        }
                                                    });
                                                </script>
                                                <!-- End Avatar -->
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Form Group -->

                                    <!-- Form Group -->
                                    <div class="row form-group">
                                        <label for="firstNameLabel" class="col-sm-3 col-form-label input-label">Tiêu đề
                                            <span class="text-danger">*</span>
                                            <i class="tio-help-outlined text-body ml-1" data-toggle="tooltip"
                                                data-placement="top"
                                                title="Displayed on public forums, such as Front."></i></label>

                                        <div class="col-sm-9">
                                            <div class="input-group input-group-sm-down-break">
                                                <input type="text" class="form-control" value="{{ old('title') }}"
                                                    name="title" id="firstNameLabel" placeholder="Clarice"
                                                    aria-label="Clarice" />
                                            </div>
                                            @error('title')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <!-- End Form Group -->

                                    <!-- Form Group -->
                                    <div class="row form-group">
                                        <label for="emailLabel" class="col-sm-3 col-form-label input-label">Danh mục <span
                                                class="text-danger">*</span></label>

                                        <div class="col-sm-9">
                                            <select name="category_post_id" id="" class="form-control">
                                                <option value="">--Chọn--</option>
                                                @foreach ($categories as $item)
                                                    <option value="{{ $item->id }}"
                                                        {{ old('category_post_id') == $item->id ? 'selected' : '' }}>
                                                        {{ $item->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @error('email')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="row form-group">
                                        <label for="emailLabel"
                                            class="col-sm-3 col-form-label input-label">Hashtag</label>

                                        <div class="col-sm-9">
                                            <input type="text" value="{{ old('hashtag') }}"
                                                class="js-masked-input form-control" name="hashtag" id=""
                                                placeholder="thoisu, tintuc,.." />
                                        </div>
                                    </div>

                                    <div class="row form-group mt-5">
                                        <label for="organizationLabel" class="col-sm-3 col-form-label input-label">Nội
                                            dung
                                        </label>

                                        <div class="col-sm-9">
                                            <div class="quill-custom">
                                                <div class="js-quill" id="editor-container" style="min-height: 15rem;">

                                                </div>
                                                <input type="text"value="" id="content" name="content" hidden>
                                                @error('description')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Form Group -->

                                    <!-- End Form Group -->
                                </div>
                                <!-- End Body -->

                                <!-- Footer -->
                                <div class="card-footer d-flex justify-content-end align-items-center">
                                    <button type="submit" class="btn btn-primary">
                                        Thêm bài viết mới<i class="tio-chevron-right"></i>
                                    </button>
                                </div>
                                <!-- End Footer -->
                            </form>
                        @endif
                        <!-- End Card -->

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js2')
    <script>
        var quill = new Quill('#editor-container', {
            theme: 'snow'
        });
        $('#form-add-post').submit(function() {
            $('input[name="content"]').val(quill.root.innerHTML);
        })
    </script>
@endpush
