@extends('layout.app')
@section('view_title')
    {{ $user->full_name }}
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
                            <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ route('user.list') }}">Thành
                                    viên</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Cập nhật thông tin</li>
                        </ol>
                    </nav>

                    <h1 class="page-header-title">Cập nhật thông tin</h1>
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
                        <form method="post" action="{{route('user._update',['uuid'=>$user->uuid])}}" id="addUserStepProfile" class="card card-lg active"
                            enctype="multipart/form-data">
                            @csrf
                            <!-- Body -->
                            <div class="card-body">
                                <!-- Form Group -->
                                <div class="row form-group">
                                    <label class="col-sm-3 col-form-label input-label">Ảnh</label>

                                    <div class="col-sm-9">
                                        <div class="d-flex align-items-center">
                                            <!-- Avatar -->
                                            <label class="avatar avatar-xl avatar-circle avatar-uploader mr-5"
                                                for="avatarUploader">
                                                <img id="avatarImg" class="avatar-img" src="{{ $user->avatar_url }}"
                                                    alt="Image Description" />

                                                <input type="file" name="avatar_url"
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
                                    <label for="firstNameLabel" class="col-sm-3 col-form-label input-label">Họ tên <span
                                            class="text-danger">*</span>
                                        <i class="tio-help-outlined text-body ml-1" data-toggle="tooltip"
                                            data-placement="top"
                                            title="Displayed on public forums, such as Front."></i></label>

                                    <div class="col-sm-9">
                                        <div class="input-group input-group-sm-down-break">
                                            <input type="text" class="form-control"
                                                value="{{ old('full_name') ? old('full_name') : $user->full_name }}"
                                                name="full_name" id="firstNameLabel" placeholder="Clarice"
                                                aria-label="Clarice" />
                                        </div>
                                        @error('full_name')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <!-- End Form Group -->

                                <!-- Form Group -->
                                <div class="row form-group">
                                    <label for="emailLabel" class="col-sm-3 col-form-label input-label">Email <span
                                            class="text-danger">*</span></label>

                                    <div class="col-sm-9">
                                        <input readonly type="email" class="form-control" name="email" id="emailLabel"
                                            placeholder="example@gmail.com"
                                            value="{{ old('email') ? old('email') : $user->email }}" />
                                    </div>
                                    @error('email')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="row form-group">
                                    <label for="emailLabel" class="col-sm-3 col-form-label input-label">Bio</label>

                                    <div class="col-sm-9">
                                        <textarea name="bio" id="" cols="30" class="form-control" placeholder="Giới thiệu" rows="3">{{ old('bio') ? old('bio') : $user->bio }}</textarea>
                                    </div>
                                </div>
                                <!-- End Form Group -->

                                <!-- Form Group -->
                                <div class="js-add-field row form-group"
                                    data-hs-add-field-options='{
                                    "template": "#addPhoneFieldTemplate",
                                    "container": "#addPhoneFieldContainer",
                                    "defaultCreated": 0
                                  }'>
                                    <label for="phoneLabel" class="col-sm-3 col-form-label input-label">Số điện
                                        thoại</label>
                                    <div class="col-sm-9">
                                        <div class="input-group input-group-sm-down-break align-items-center">
                                            <input type="text"
                                                value="{{ old('phone_number') ? old('phone_number') : $user->phone_number }}"
                                                class="js-masked-input form-control" name="phone_number" id="phoneLabel"
                                                placeholder="+x(xxx)xxx-xx-xx" />
                                        </div>
                                    </div>
                                </div>

                                <!-- Form Group -->
                                <div class="row form-group">
                                    <label for="organizationLabel" class="col-sm-3 col-form-label input-label">Địa
                                        chỉ</label>

                                    <div class="col-sm-9">
                                        <input value="{{ old('address') ? old('address') : $user->address }}"
                                            type="text" class="form-control" name="address" id="organizationLabel"
                                            placeholder="Q12, Tp.HCM" aria-label="Htmlstream" />
                                    </div>
                                </div>
                                <!-- End Form Group -->

                                <!-- Form Group -->
                                <div class="row form-group">
                                    <label for="departmentLabel" class="col-sm-3 col-form-label input-label">Ngày
                                        sinh</label>
                                    <div class="col-sm-9">
                                        <input type="date"
                                            value="{{ old('birthday') ? old('birthday') : $user->birthday }}"
                                            class="form-control" name="birthday" id="departmentLabel"
                                            placeholder="Human resources" aria-label="Human resources" />
                                    </div>
                                </div>
                                <!-- End Form Group -->

                                <!-- Form Group -->
                                <div class="row">
                                    <label class="col-sm-3 col-form-label input-label">Trạng thái</label>

                                    <div class="col-sm-9">
                                        <div class="input-group input-group-sm-down-break">
                                            <!-- Custom Radio -->
                                            <div class="form-control">
                                                <div class="custom-control custom-radio">

                                                    <input type="radio"
                                                        {{ $user->is_blocked == false ? 'checked' : '' }}
                                                        class="custom-control-input" name="is_blocked"
                                                        id="userAccountTypeRadio1" value="false" />
                                                    <label class="custom-control-label" for="userAccountTypeRadio1">Hoạt
                                                        động</label>
                                                </div>
                                            </div>
                                            <!-- End Custom Radio -->

                                            <!-- Custom Radio -->
                                            <div class="form-control">
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" {{ $user->is_blocked == true ? 'checked' : '' }}
                                                        class="custom-control-input" name="is_blocked"
                                                        id="userAccountTypeRadio2" value="true" />
                                                    <label class="custom-control-label"
                                                        for="userAccountTypeRadio2">Khóa</label>
                                                </div>
                                            </div>
                                            <!-- End Custom Radio -->
                                        </div>
                                    </div>
                                </div>

                                <div class="row form-group pt-4">
                                    <label for="departmentLabel" class="col-sm-3 col-form-label input-label">Vai
                                        trò <span class="text-danger">*</span></label>
                                    <div class="col-sm-5">
                                        <select class="js-select2-custom custom-select" name="role_id" id="">
                                            <option value="">--Chọn--</option>
                                            @foreach ($roles as $item)
                                                @if (!in_array($item->name, $user->roles()->toArray()))
                                                    <option {{ old('role_id') == $item->id ? 'selected' : '' }}
                                                        title="{{ $item->description }}" value="{{ $item->id }}">
                                                        {{ $item->name }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                        @error('role_id')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row form-group ">
                                    <label for="departmentLabel" class="col-sm-3 col-form-label input-label"></label>
                                    <div class="col-sm-5 d-flex gap-4" style="gap:10px">
                                        @foreach ($user->user_roles as $item)
                                            <div class="dropdown">
                                                <button title="{{ $item->role->description }}"
                                                    style="border:none !important" type="button"
                                                    class="badge border-0 badge-soft-success p-1 cursor-pointer"
                                                    id="dropdownMenuButton{{ $item->id }}" data-toggle="dropdown"
                                                    aria-haspopup="true"
                                                    aria-expanded="false">{{ $item->role->name }}</button>
                                                @if ($item->role->id != 1)
                                                    <div class="dropdown-menu"
                                                        aria-labelledby="dropdownMenuButton{{ $item->id }}">
                                                        <a class="dropdown-item text-center btn btn-danger bg-danger text-white"
                                                            href="{{route('user.delete_user_role',['id'=>$item->id])}}">Xóa quyền</a>
                                                    </div>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                {{-- <div class="dropdown">
                                    <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                      Dropdown button
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                      <a class="dropdown-item" href="#">Action</a>
                                      <a class="dropdown-item" href="#">Another action</a>
                                      <a class="dropdown-item" href="#">Something else here</a>
                                    </div>
                                  </div> --}}
                                <div class="row form-group">
                                    <label for="departmentLabel" class="col-sm-3 col-form-label input-label">Mật
                                        khẩu <span class="text-danger">*</span></label>
                                    <div class="col-sm-9">
                                        <input value="{{ old('password') }}" type="text" name="password"
                                            placeholder="**************" class="form-control">
                                        @error('password')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <!-- End Form Group -->
                            </div>
                            <!-- End Body -->

                            <!-- Footer -->
                            <div class="card-footer d-flex justify-content-end align-items-center">
                                <button type="submit" class="btn btn-primary">
                                    Cập nhật thông tin<i class="tio-chevron-right"></i>
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
