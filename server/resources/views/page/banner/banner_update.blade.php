@extends('layout.app')
@section('view_title')
    Cập nhật banners
@endsection
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
                            <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ route('banner.list') }}">Banner
                                </a></li>
                            <li class="breadcrumb-item active" aria-current="page">Cập nhật banner</li>
                        </ol>
                    </nav>

                    <h1 class="page-header-title">Thêm banner mới</h1>
                </div>
            </div>
            <!-- End Row -->
        </div>
        <!-- End Page Header -->
        <div class="js-step-form py-md-5">
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
            <div class="row justify-content-lg-center">
                <div class="col-lg-8">
                    <div id="addUserStepFormContent">
                        <!-- Card -->
                        <form method="post" id="addUserStepProfile"
                            action="{{ route('banner._update', ['id' => $banner->id]) }}" class="card card-lg active"
                            enctype="multipart/form-data">
                            @csrf
                            <!-- Body -->
                            <div class="card-body">
                                <!-- Form Group -->
                                <div class="row form-group">
                                    <label class="col-sm-3 col-form-label input-label">Ảnh</label>

                                    <div class="col-sm-9">
                                        <label for="avatarUploader" class="d-flex flex-direction-column align-items-center"
                                            style="flex-direction: column">
                                            <!-- Avatar -->
                                            <img style="width: 100%; height:240px;object-fit:cover" id="avatarImg"
                                                src="{{ $banner->banner_url }}" alt="">

                                            <input type="file" name="banner_url"
                                                class="js-file-attach avatar-uploader-input" id="avatarUploader" />
                                            <span class=" btn btn-outline-primary d-flex gap-2 mt-4 align-items-center"
                                                style="gap:5px">
                                                Tải lên
                                                <i class="fa-solid fa-upload"></i>
                                            </span>
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
                                        </label>
                                        @error('banner_url')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <!-- End Form Group -->

                                <!-- Form Group -->
                                <div class="row form-group">
                                    <label for="firstNameLabel" class="col-sm-3 col-form-label input-label">Title <span
                                            class="text-danger">*</span>
                                    </label>

                                    <div class="col-sm-9">
                                        <div class="input-group input-group-sm-down-break">
                                            <input type="text" class="form-control"
                                                value="{{ old('title') ?? $banner->title }}" name="title"
                                                placeholder="Aa.." aria-label="Clarice" />
                                        </div>
                                        @error('title')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <label for="firstNameLabel" class="col-sm-3 col-form-label input-label">Alt(SEO) <span
                                            class="text-danger">*</span>
                                    </label>
                                    <div class="col-sm-9">
                                        <div class="input-group input-group-sm-down-break">
                                            <input type="text" class="form-control"
                                                value="{{ old('alt') ?? $banner->alt }}" name="alt" placeholder="Aa.."
                                                aria-label="Clarice" />
                                        </div>
                                        @error('alt')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <label for="firstNameLabel" class="col-sm-3 col-form-label input-label">Mô tả <span
                                            class="text-danger">*</span>
                                    </label>
                                    <div class="col-sm-9">
                                        <div class="input-group input-group-sm-down-break">
                                            <textarea name="description" class="form-control" placeholder="Aa.." id="" cols="30" rows="3">{{ old('description') ?? $banner->description }}</textarea>
                                        </div>
                                        @error('description')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <label for="firstNameLabel" class="col-sm-3 col-form-label input-label">Link đến <span
                                            class="text-danger">*</span>
                                    </label>

                                    <div class="col-sm-9">
                                        <div class="input-group input-group-sm-down-break">
                                            <input type="text" class="form-control"
                                                value="{{ old('link_to') ?? $banner->link_to }}" name="link_to"
                                                placeholder="Aa.." aria-label="Clarice" />
                                        </div>
                                        @error('link_to')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <label for="firstNameLabel" class="col-sm-3 col-form-label input-label">Vị trí
                                        hiện<span class="text-danger">*</span>
                                    </label>

                                    <div class="col-sm-9">
                                        <div class="input-group input-group-sm-down-break">
                                            <input type="text" class="form-control"
                                                value="{{ old('placement') ?? $banner->placement }}" name="placement"
                                                placeholder="Aa.." aria-label="Clarice" />
                                        </div>
                                        @error('placement')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <label for="firstNameLabel" class="col-sm-3 col-form-label input-label">Loại <span
                                            class="text-danger">*</span>
                                    </label>

                                    <div class="col-sm-9">
                                        <div class="input-group input-group-sm-down-break">
                                            <input type="text" class="form-control"
                                                value="{{ old('type') ?? $banner->type }}" name="type"
                                                placeholder="Aa.." aria-label="Clarice" />
                                        </div>
                                        @error('type')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <label for="firstNameLabel" class="col-sm-3 col-form-label input-label">Ngày hết hạn
                                    </label>

                                    <div class="col-sm-9">
                                        <div class="input-group input-group-sm-down-break">
                                            <input type="date" class="form-control"
                                                value="{{ old('expired_at') ?? \Carbon\Carbon::parse($banner->expired_at)->format('Y-m-d')  }}" name="expired_at"
                                                placeholder="1,2" aria-label="Clarice" value="1" />
                                        </div>
                                        @error('expired_at')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row form-group">
                                    <label for="firstNameLabel" class="col-sm-3 col-form-label input-label">Thứ tự
                                    </label>
                                    <div class="col-sm-9">
                                        <div class="input-group input-group-sm-down-break">
                                            <input type="number" class="form-control"
                                                value="{{ old('priority') ?? $banner->priority }}" name="priority"
                                                placeholder="1,2" aria-label="Clarice" value="1" />
                                        </div>
                                        @error('priority')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <label for="firstNameLabel" class="col-sm-3 col-form-label input-label">Is_Bank
                                    </label>
                                    <div class="col-sm-9">
                                        <div class="input-group input-group-sm-down-break">
                                            <label class="toggle-switch toggle-switch-sm" for="stocksCheckbox2">
                                                <input type="checkbox" name="is_blank" class="toggle-switch-input"
                                                    id="stocksCheckbox2" {{ $banner->is_blank ? 'checked' : '' }}>
                                                <span class="toggle-switch-label">
                                                    <span class="toggle-switch-indicator"></span>
                                                </span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <label for="firstNameLabel" class="col-sm-3 col-form-label input-label">Hiện
                                    </label>
                                    <div class="col-sm-9">
                                        <div class="input-group input-group-sm-down-break">
                                            <label class="toggle-switch toggle-switch-sm" for="stocksCheckbox3">
                                                <input type="checkbox" name="is_show" class="toggle-switch-input"
                                                    id="stocksCheckbox3" {{ $banner->is_show ? 'checked' : '' }}>
                                                <span class="toggle-switch-label">
                                                    <span class="toggle-switch-indicator"></span>
                                                </span>
                                            </label>
                                        </div>
                                        @error('is_show')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <!-- End Body -->

                            <!-- Footer -->
                            <div class="card-footer d-flex justify-content-end align-items-center">
                                <button type="submit" class="btn btn-primary">
                                    Cập nhật<i class="tio-chevron-right"></i>
                                </button>
                            </div>
                            <!-- End Footer -->
                        </form>
                        <!-- End Card -->

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
