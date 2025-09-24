@extends('layout.app')
@section('title', 'Edit Project')
@section('main')
    <div id="kt_app_content_container" class="app-container container-xxl">

        <div class="card card-flush">
            <!--begin::Modal content-->
            <div class="modal-content">
                <!--begin::Modal header-->
                <div class="modal-header px-5 pt-5">
                    <!--begin::Modal title-->
                    <h2 class="fw-bold">Edit a Project</h2>
                    <!--end::Modal title-->
                    <!--begin::Close-->
                    <a href="{{ route($params['prefix'] . '.' . $params['controller'] . '.index') }}" class="btn  btn-danger">
                        Back
                    </a>
                    <!--end::Close-->
                </div>

                <!--end::Modal header-->
                <!--begin::Modal body-->
                <div class=" mx-lg-5 my-7">
                    <!--begin::Form-->
                    <form id="form_main" class="form"
                        action="{{ route($params['prefix'] . '.' . $params['controller'] . '.update', $params['item']->id) }}"
                        method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <!--begin::Scroll-->

                        <div class="d-flex flex-column scroll-y me-n7 pe-7">
                            <div class="fv-row mb-10">
                                <!--begin::Label-->
                                <label class="fs-5 fw-bold form-label mb-2">
                                    <span class="required">Belong to User</span>
                                </label>

                                <!--end::Label-->
                                <!--begin::Input-->

                                <select class="form-select mb-2" id="selectemail" data-control="select2" name="email"
                                    data-placeholder="Select an option" data-allow-clear="true"
                                    data-placeholder="Select an option" id="kt_ecommerce_add_product_status_select">
                                    <option value="">--Select--</option>
                                    @foreach ($params['users'] as $item)
                                        <option value="{{ $item->email }}"
                                            {{ isset(request()->email) ? (request()->email == $item->email ? 'selected' : '') : ($params['item']->email == $item->email ? 'selected' : '') }}>
                                            {{ $item->email }}</option>
                                    @endforeach
                                </select>
                                <script>
                                    $(document).ready(function() {
                                        $('#selectemail').select2();

                                        $('#selectemail').on('change', function(e) {
                                            window.location.href = '?email=' + $(this).val()
                                        });
                                    });
                                </script>
                                @error('email')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="fv-row mb-10">
                                <label class="fs-5 fw-bold form-label mb-2">
                                    <span class="required">Full Name</span>
                                </label>

                                <input class="form-control form-control-solid" placeholder="Enter Aa.." name="name"
                                    value="{{ $params['item']->name }}" />
                                @error('name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="fv-row mb-10">
                                        <label class="fs-5 fw-bold form-label mb-2">
                                            <span class="required">Email</span>
                                        </label>

                                        <input class="form-control form-control-solid" value="{{ $params['item']->email }}"
                                            placeholder="Enter Aa.." name="email_contact" />
                                        @error('email_contact')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="fv-row mb-10">
                                        <label class="fs-5 fw-bold form-label mb-2">
                                            <span class="required">Phone</span>
                                        </label>

                                        <input class="form-control form-control-solid" value="{{ $params['item']->phone }}"
                                            placeholder="Enter Aa.." name="phone" />
                                        @error('phone')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="fv-row mb-10">
                                        <label class="fs-5 fw-bold form-label mb-2">
                                            <span class="required">Age</span>
                                        </label>

                                        <input class="form-control form-control-solid" placeholder="Enter Aa.."
                                            name="age" value="{{ $params['item']->age }}" />
                                        @error('age')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="fv-row mb-10">
                                        <label class="fs-5 fw-bold form-label mb-2">
                                            <span class="required">Birthday</span>
                                        </label>

                                        <input class="form-control form-control-solid" placeholder="Enter Aa.."
                                            name="birthday" value="{{ $params['item']->birthday }}" />
                                        @error('birthday')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="fv-row mb-10 col-md-6">
                                    <label class="fs-5 fw-bold form-label mb-2">
                                        <span class="required">Address</span>
                                    </label>

                                    <input class="form-control form-control-solid" value="{{ $params['item']->location }}"
                                        placeholder="Quan 12 , tP. HCM.." name="location" />
                                    @error('location')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="fv-row mb-10 col-md-6">
                                    <label class="fs-5 fw-bold form-label mb-2">
                                        <span class="">Map Address full script</span>
                                    </label>

                                    <input class="form-control form-control-solid"
                                        value="{{ $params['item']->map_address ?? '' }}"
                                        placeholder='<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d14351.495813306548!2d106.59290939569469!3d10.764360898092011!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31752c5418e29ea1%3A0x5d0d5c26049741ea!2zQuG7h25oIHZp4buHbiBRdeG6rW4gQsOsbmggVMOibg!5e1!3m2!1svi!2s!4v1750600411328!5m2!1svi!2s" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>'
                                        name="map_address" />
                                    @error('map_address')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="fv-row mb-10">
                                        <label class="fs-5 fw-bold form-label mb-2">
                                            <span class="required">Major</span>
                                        </label>

                                        <input class="form-control form-control-solid" value="{{ $params['item']->major }}"
                                            placeholder="Web.." name="major" />
                                        @error('major')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="fv-row mb-10">
                                        <label class="fs-5 fw-bold form-label mb-2">
                                            <span class="required">Position</span>
                                        </label>

                                        <input class="form-control form-control-solid"
                                            value="{{ $params['item']->position }}" placeholder="Developer.."
                                            name="position" />
                                        @error('position')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="fv-row mb-10 col-md-6">
                                    <!--begin::Label-->
                                    <label class="fs-5 fw-bold form-label mb-2 w-100">
                                        <span class=" mb-5">Avatar</span>
                                        <input type="text" class="form-control form-control-solid my-5"
                                            placeholder="Or Enter https.." value="{{ $params['item']->avatar }}"
                                            name="avatar_link" />
                                    </label>

                                    <div class="card-body text-center pt-0">

                                        <style>
                                            .image-input-placeholder.avatar {
                                                background-image: url('{{ $params['item']->avatar ?? asset('assets/media/svg/files/blank-image.svg') }}');
                                            }

                                            [data-bs-theme="dark"] .image-input-placeholder.avatar {
                                                background-image: url('{{ $params['item']->avatar ?? asset('assets/media/svg/files/blank-image-dark.svg') }}');
                                            }
                                        </style>
                                        <!--end::Image input placeholder-->
                                        <div class="image-input image-input-empty image-input-outline avatar image-input-placeholder mb-3"
                                            data-kt-image-input="true">
                                            <!--begin::Preview existing avatar-->
                                            <div class="image-input-wrapper w-150px h-150px"></div>
                                            <!--end::Preview existing avatar-->
                                            <!--begin::Label-->
                                            <label
                                                class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                                data-kt-image-input-action="change" data-bs-toggle="tooltip"
                                                title="Change thumbnail">
                                                <i class="ki-outline ki-pencil fs-7"></i>
                                                <!--begin::Inputs-->
                                                <input type="file" name="avatar" accept=".png, .jpg, .jpeg" />
                                                <input type="hidden" name="avatar_remove" />
                                                <!--end::Inputs-->
                                            </label>
                                            <span
                                                class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                                data-kt-image-input-action="cancel" data-bs-toggle="tooltip"
                                                title="Cancel thumbnail">
                                                <i class="ki-outline ki-cross fs-2"></i>
                                            </span>
                                            <!--end::Cancel-->
                                            <!--begin::Remove-->
                                            <span
                                                class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                                data-kt-image-input-action="remove" data-bs-toggle="tooltip"
                                                title="Remove thumbnail">
                                                <i class="ki-outline ki-cross fs-2"></i>
                                            </span>
                                            <!--end::Remove-->
                                        </div>
                                        <!--end::Image input-->
                                        <!--begin::Description-->
                                        <div class="text-muted fs-7">Set the thumbnail image. Only *.png, *.jpg and
                                            *.jpeg image files are accepted</div>
                                        <!--end::Description-->
                                    </div>
                                    <!--end::Input-->
                                </div>
                                <div class="fv-row mb-10 col-md-6">
                                    <!--begin::Label-->
                                    <label class="fs-5 fw-bold form-label mb-2 w-100">
                                        <span class=" mb-5">Image Background</span>
                                        <input type="text" class="form-control form-control-solid my-5"
                                            placeholder="Or Enter https.." value="{{ $params['item']->img_background }}"
                                            name="img_background_link" />
                                    </label>

                                    <div class="card-body text-center pt-0">

                                        <style>
                                            .image-input-placeholder.img_background {
                                                background-image: url('{{ $params['item']->img_background ?? asset('assets/media/svg/files/blank-image.svg') }}');
                                            }

                                            [data-bs-theme="dark"] .image-input-placeholder.img_background {
                                                background-image: url('{{ asset('assets/media/svg/files/blank-image-dark.svg') }}');
                                            }
                                        </style>
                                        <!--end::Image input placeholder-->
                                        <div class="image-input image-input-empty image-input-outline image-input-placeholder img_background mb-3"
                                            data-kt-image-input="true">
                                            <!--begin::Preview existing avatar-->
                                            <div class="image-input-wrapper w-150px h-150px"></div>
                                            <!--end::Preview existing avatar-->
                                            <!--begin::Label-->
                                            <label
                                                class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                                data-kt-image-input-action="change" data-bs-toggle="tooltip"
                                                title="Change thumbnail">
                                                <i class="ki-outline ki-pencil fs-7"></i>
                                                <!--begin::Inputs-->
                                                <input type="file" name="img_background" accept=".png, .jpg, .jpeg" />
                                                <input type="hidden" name="avatar_remove" />
                                                <!--end::Inputs-->
                                            </label>
                                            <span
                                                class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                                data-kt-image-input-action="cancel" data-bs-toggle="tooltip"
                                                title="Cancel thumbnail">
                                                <i class="ki-outline ki-cross fs-2"></i>
                                            </span>
                                            <!--end::Cancel-->
                                            <!--begin::Remove-->
                                            <span
                                                class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                                data-kt-image-input-action="remove" data-bs-toggle="tooltip"
                                                title="Remove thumbnail">
                                                <i class="ki-outline ki-cross fs-2"></i>
                                            </span>
                                            <!--end::Remove-->
                                        </div>
                                        <!--end::Image input-->
                                        <!--begin::Description-->
                                        <div class="text-muted fs-7">Set the thumbnail image. Only *.png, *.jpg and
                                            *.jpeg image files are accepted</div>
                                        <!--end::Description-->
                                    </div>
                                    <!--end::Input-->
                                </div>

                            </div>

                            <div class="row">
                                <div class="fv-row mb-10 col-md-6">
                                    <label class="fs-5 fw-bold form-label mb-2">
                                        <span class="">CV</span>
                                    </label>

                                    <input type="file" class="form-control" name="cv">

                                    <!--end::Input-->
                                </div>
                                <div class="fv-row mb-10 col-md-6">
                                    <label class="fs-5 fw-bold form-label mb-2">
                                        <span class="">Or Link CV</span>
                                    </label>

                                    <input class="form-control form-control-solid" value="{{ $params['item']->cv }}"
                                        placeholder="https://.." name="cv_link" />
                                    @error('cv_link')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                            </div>
                            <div class="fv-row mb-10">
                                <label class="fs-5 fw-bold form-label mb-2">
                                    <span class="">Bio</span>
                                </label>

                                <textarea name="bio" id="" class="form-control form-control-solid" cols="30" rows="3">{{ $params['item']->bio }}</textarea>

                            </div>
                            <div class="fv-row mb-10">
                                <label class="fs-5 fw-bold form-label mb-2">
                                    <span class="">Description</span>
                                </label>
                                <div>
                                    <label class="form-check-label">Your description..</label>
                                </div>
                                <textarea name="description" id="" class="form-control form-control-solid" cols="30" rows="5">{{ $params['item']->description }}</textarea>

                            </div>
                            <div class="fv-row mb-10">
                                <label class="fs-5 fw-bold form-label mb-2">
                                    <span class="">Language</span>
                                </label>
                                <div class="list_item_feature_group">
                                    <!--begin::Form group-->
                                    <div class="list_item_feature">
                                        @foreach ($params['item']->languages ?? [] as $key => $item)
                                            <div class="form-group d-flex item_feature mb-5"
                                                style="align-items: center; gap:10px">
                                                <button onclick="remove(this)" type="button" data-repeater-delete=""
                                                    class="btn btn-sm btn-icon btn-light-danger btn_delete">
                                                    <i class="ki-outline ki-cross fs-1"></i>
                                                </button>
                                                <input type="text" value="{{ $item['name'] }}" class="form-control "
                                                    name="languages[{{ $key }}][name]" placeholder="Name.." />
                                                <input type="text" class="form-control "
                                                    value="{{ $item['content'] }}"
                                                    name="languages[{{ $key }}][content]"
                                                    placeholder="Content." />

                                            </div>
                                        @endforeach
                                    </div>

                                    <div class="form-group mt-5">
                                        <button type="button" data-repeater-create=""
                                            class="btn btn-sm btn_add btn-light-primary">
                                            <i class="ki-outline ki-plus fs-2"></i>Add more</button>
                                    </div>
                                    <!--end::Form group-->
                                </div>
                            </div>
                            <div class="fv-row mb-10">
                                <label class="fs-5 fw-bold form-label mb-2">
                                    <span class="">Skills</span>
                                </label>
                                <div class="list_item_feature_group">
                                    <!--begin::Form group-->
                                    <div class="list_item_feature">
                                        @foreach ($params['item']->skills ?? [] as $key => $item)
                                            <div class="form-group d-flex item_feature mb-5"
                                                style="align-items: center; gap:10px">
                                                <button onclick="remove(this)" type="button" data-repeater-delete=""
                                                    class="btn btn-sm btn-icon btn-light-danger btn_delete">
                                                    <i class="ki-outline ki-cross fs-1"></i>
                                                </button>
                                                <input type="text" class="form-control " value="{{ $item['name'] }}"
                                                    name="skills[{{ $key }}][name]" placeholder="Name.." />
                                                <input type="text" class="form-control "
                                                    value="{{ $item['content'] }}"
                                                    name="skills[{{ $key }}][content]" placeholder="Content." />

                                            </div>
                                        @endforeach
                                    </div>

                                    <div class="form-group mt-5">
                                        <button type="button" data-repeater-create="" data-type='skills'
                                            class="btn btn-sm btn_add btn-light-primary">
                                            <i class="ki-outline ki-plus fs-2"></i>Add more</button>
                                    </div>
                                    <!--end::Form group-->
                                </div>
                            </div>
                            <div class="fv-row mb-10">
                                <label class="fs-5 fw-bold form-label mb-2">
                                    <span class="">Extra Skills</span>
                                </label>
                                <div class="list_item_feature_group">
                                    <!--begin::Form group-->
                                    <div class="list_item_feature">
                                        @foreach ($params['item']->extra_skills ?? [] as $key => $item)
                                            <div class="form-group d-flex item_feature mb-5"
                                                style="align-items: center; gap:10px">
                                                <button onclick="remove(this)" type="button" data-repeater-delete=""
                                                    class="btn btn-sm btn-icon btn-light-danger btn_delete">
                                                    <i class="ki-outline ki-cross fs-1"></i>
                                                </button>
                                                <input type="text" class="form-control " value="{{ $item }}"
                                                    name="extra_skills[{{ $key }}]"
                                                    placeholder="Extra_skills." />

                                            </div>
                                        @endforeach
                                    </div>

                                    <div class="form-group mt-5">
                                        <button type="button" data-repeater-create="" data-type='extra_skills'
                                            class="btn btn-sm btn_add btn-light-primary">
                                            <i class="ki-outline ki-plus fs-2"></i>Add more</button>
                                    </div>
                                    <!--end::Form group-->
                                </div>
                            </div>
                            <div class="fv-row mb-10">
                                <label class="fs-5 fw-bold form-label mb-2">
                                    <span class="">Social</span>
                                </label>
                                <div class="list_item_feature_group">
                                    <!--begin::Form group-->
                                    <div class="list_item_feature">
                                        @foreach ($params['item']->socials ?? [] as $key => $item)
                                            <div class="form-group d-flex item_feature mb-5"
                                                style="align-items: center; gap:10px">
                                                <button onclick="remove(this)" type="button" data-repeater-delete=""
                                                    class="btn btn-sm btn-icon btn-light-danger btn_delete">
                                                    <i class="ki-outline ki-cross fs-1"></i>
                                                </button>

                                                <select name="socials[{{ $key }}][type]"
                                                    class="form-select mb-2" data-control="select2"
                                                    data-placeholder="Select an type" data-allow-clear="true">
                                                    <option value="">--Select Type--</option>
                                                    <option value="facebook"
                                                        {{ $item['type'] == 'facebook' ? 'selected' : '' }}>Facebook
                                                    </option>
                                                    <option value="github"
                                                        {{ $item['type'] == 'github' ? 'selected' : '' }}>Github</option>
                                                    <option value="youtube"
                                                        {{ $item['type'] == 'youtube' ? 'selected' : '' }}>Youtube</option>
                                                    <option value="instagram"
                                                        {{ $item['type'] == 'instagram' ? 'selected' : '' }}>Instagram
                                                    </option>
                                                    <option value="behance"
                                                        {{ $item['type'] == 'behance' ? 'selected' : '' }}>Behance</option>
                                                    <option value="behance"
                                                        {{ $item['type'] == 'linkin' ? 'selected' : '' }}>Linkin</option>
                                                </select>

                                                <input type="text" value="{{ $item['link'] ?? '' }}"
                                                    class="form-control " name="socials[{{ $key }}][link]"
                                                    placeholder="Link." />

                                            </div>
                                        @endforeach
                                    </div>

                                    <div class="form-group mt-5">
                                        <button type="button" data-repeater-create="" data-type='select_type'
                                            class="btn btn-sm btn_add btn-light-primary">
                                            <i class="ki-outline ki-plus fs-2"></i>Add more</button>
                                    </div>
                                    <!--end::Form group-->
                                </div>
                            </div>
                            <div class="fv-row mb-10">
                                <label class="fs-5 fw-bold form-label mb-2">
                                    <span class="">Educations/ Company</span>
                                </label>
                                <div class="list_item_feature_group">
                                    <!--begin::Form group-->
                                    <div class="list_item_feature">
                                        @foreach ($params['item']->educations ?? [] as $key => $item)
                                            <div class="form-group d-flex item_feature mb-5"
                                                style="align-items: center; gap:10px">
                                                <button onclick="remove(this)" type="button" data-repeater-delete=""
                                                    class="btn btn-sm btn-icon btn-light-danger btn_delete">
                                                    <i class="ki-outline ki-cross fs-1"></i>
                                                </button>

                                                <div style="flex:1">
                                                    <div class="" style="flex:1">
                                                        <div class=" d-flex" style="gap: 10px;margin-bottom:10px">
                                                            <input type="text" class="form-control col-md-6 w-50"
                                                                name="educations[{{ $key }}][time]"
                                                                value="{{ $item['time'] ?? '' }}"
                                                                placeholder="2023 - 12/2024." />
                                                            <input type="text" class="form-control col-md-6 w-50"
                                                                name="educations[{{ $key }}][logo]"
                                                                value="{{ $item['logo'] ?? '' }}"
                                                                placeholder="Link Logo." />
                                                        </div>
                                                        <div class=" d-flex" style="gap: 10px;margin-bottom:10px">
                                                            <input type="text" class="form-control col-md-6 w-50"
                                                                name="educations[{{ $key }}][name]"
                                                                value="{{ $item['name'] ?? '' }}" placeholder="Name.." />
                                                            <input type="text" class="form-control col-md-6 w-50"
                                                                name="educations[{{ $key }}][address]"
                                                                value="{{ $item['address'] ?? '' }}"
                                                                placeholder="Address." />
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <input type="text" class="form-control "
                                                            name="educations[{{ $key }}][content]"
                                                            value="{{ $item['content'] ?? '' }}"
                                                            placeholder="Content." />
                                                    </div>
                                                </div>

                                            </div>
                                        @endforeach
                                    </div>

                                    <div class="form-group mt-5">
                                        <button type="button" data-repeater-create="" data-type='educations_type'
                                            class="btn btn-sm btn_add btn-light-primary">
                                            <i class="ki-outline ki-plus fs-2"></i>Add more</button>
                                    </div>
                                    <!--end::Form group-->
                                </div>
                            </div>

                            <div class="fv-row mb-10">
                                <label class="fs-5 fw-bold form-label mb-2">
                                    <span class="">Reviews</span>
                                </label>
                                <div class="list_item_feature_group">
                                    <!--begin::Form group-->
                                    <div class="list_item_feature">
                                        @foreach ($params['item']->reviews ?? [] as $key => $item)
                                            <div class="form-group d-flex item_feature mb-5"
                                                style="align-items: center; gap:10px">
                                                <button onclick="remove(this)" type="button" data-repeater-delete=""
                                                    class="btn btn-sm btn-icon btn-light-danger btn_delete">
                                                    <i class="ki-outline ki-cross fs-1"></i>
                                                </button>

                                                <div class="" style="flex:1">
                                                    <div class=" d-flex" style="gap: 10px;margin-bottom:10px">
                                                        <input type="text" class="form-control col-md-6 w-50"
                                                            name="reviews[{{ $key }}][avatar]"
                                                            value="{{ $item['avatar'] ?? '' }}" placeholder="avatar.." />
                                                        <input type="text" class="form-control col-md-6 w-50"
                                                            name="reviews[{{ $key }}][name]"
                                                            value="{{ $item['name'] ?? '' }}" placeholder="Name." />
                                                    </div>
                                                    <div class=" d-flex" style="gap: 10px;margin-bottom:10px">
                                                        <input type="text" class="form-control col-md-6 w-50"
                                                            name="reviews[{{ $key }}][username]"
                                                            value="{{ $item['username'] ?? '' }}"
                                                            placeholder="Username.." />
                                                        <input type="text" class="form-control col-md-6 w-50"
                                                            name="reviews[{{ $key }}][content]"
                                                            value="{{ $item['content'] ?? '' }}"
                                                            placeholder="Content." />
                                                    </div>
                                                </div>

                                            </div>
                                        @endforeach
                                    </div>

                                    <div class="form-group mt-5">
                                        <button type="button" data-repeater-create="" data-type='reviews_type'
                                            class="btn btn-sm btn_add btn-light-primary">
                                            <i class="ki-outline ki-plus fs-2"></i>Add more</button>
                                    </div>
                                    <!--end::Form group-->
                                </div>
                            </div>

                            {{-- awards  --}}
                            <div class="fv-row mb-10">
                                <label class="fs-5 fw-bold form-label mb-2">
                                    <span class="">Awards</span>
                                </label>
                                <div class="list_item_feature_group">
                                    <!--begin::Form group-->
                                    <div class="list_item_feature">
                                        @foreach ($params['item']->awards ?? [] as $key => $item)
                                            <div class="form-group d-flex item_feature mb-5"
                                                style="align-items: center; gap:10px">
                                                <button onclick="remove(this)" type="button" data-repeater-delete=""
                                                    class="btn btn-sm btn-icon btn-light-danger btn_delete">
                                                    <i class="ki-outline ki-cross fs-1"></i>
                                                </button>

                                                <div class="" style="flex:1">
                                                    <div class=" d-flex" style="gap: 10px;margin-bottom:10px">
                                                        <input type="text" class="form-control col-md-6 w-50"
                                                            name="awards[{{ $key }}][name]"
                                                            value="{{ $item['name'] ?? '' }}" placeholder="name.." />
                                                        <input type="text" class="form-control col-md-6 w-50"
                                                            name="awards[{{ $key }}][location]"
                                                            value="{{ $item['location'] ?? '' }}"
                                                            placeholder="location." />
                                                    </div>
                                                    <div class=" d-flex" style="gap: 10px;margin-bottom:10px">
                                                        <input type="text" class="form-control col-md-6 w-50"
                                                            name="awards[{{ $key }}][date]"
                                                            value="{{ $item['date'] ?? '' }}" placeholder="date.." />
                                                        <input type="text" class="form-control col-md-6 w-50"
                                                            name="awards[{{ $key }}][content]"
                                                            value="{{ $item['content'] ?? '' }}"
                                                            placeholder="content." />
                                                    </div>
                                                    <div>
                                                        <textarea name="awards[{{ $key }}][images]"class="form-control " cols="30" rows="3"
                                                            placeholder="image|image|image">{{ $item['images'] ?? '' }}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>

                                    <div class="form-group mt-5">
                                        <button type="button" data-repeater-create="" data-type='awards_type'
                                            class="btn btn-sm btn_add btn-light-primary">
                                            <i class="ki-outline ki-plus fs-2"></i>Add more</button>
                                    </div>
                                    <!--end::Form group-->
                                </div>
                            </div>
                            {{-- awards  --}}
                            <div class="fv-row mb-10">
                                <label class="fs-5 fw-bold form-label mb-2">
                                    <span class="">Work Experiences</span>
                                </label>
                                <div class="list_item_feature_group">
                                    <!--begin::Form group-->
                                    <div class="list_item_feature">
                                        @foreach ($params['item']->work_experience ?? [] as $key => $item)
                                            <div class="form-group d-flex item_feature mb-5"
                                                style="align-items: center; gap:10px">
                                                <button onclick="remove(this)" type="button" data-repeater-delete=""
                                                    class="btn btn-sm btn-icon btn-light-danger btn_delete">
                                                    <i class="ki-outline ki-cross fs-1"></i>
                                                </button>

                                                <div class="" style="flex:1">
                                                    <div class=" d-flex" style="gap: 10px;margin-bottom:10px">
                                                        <input type="text" class="form-control col-md-6 w-50"
                                                            name="work_experience[{{ $key }}][company]" value="{{ $item['company'] ?? '' }}" placeholder="company.." />
                                                        <input type="text" class="form-control col-md-6 w-50"
                                                            name="work_experience[{{ $key }}][location]" value="{{ $item['location'] ?? '' }}" placeholder="location." />
                                                    </div>
                                                    <div class=" d-flex" style="gap: 10px;margin-bottom:10px">
                                                        <input type="text" class="form-control col-md-6 w-50"
                                                            name="work_experience[{{ $key }}][position]"value="{{ $item['position'] ?? '' }}"
                                                            placeholder="position.." />
                                                        <input type="text" class="form-control col-md-6 w-50"
                                                            name="work_experience[{{ $key }}][period]"
                                                            value="{{ $item['period'] ?? '' }}"
                                                            placeholder="Mar 2024 - Present." />
                                                    </div>
                                                    <div>
                                                        <textarea name="work_experience[{{ $key }}][achievements]"class="form-control " cols="30" rows="3"
                                                            placeholder="achievements... item|item|item">{{ $item['achievements'] ?? '' }}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>

                                    <div class="form-group mt-5">
                                        <button type="button" data-repeater-create="" data-type='work_experience_type'
                                            class="btn btn-sm btn_add btn-light-primary">
                                            <i class="ki-outline ki-plus fs-2"></i>Add more</button>
                                    </div>
                                    <!--end::Form group-->
                                </div>
                            </div>

                            <script>
                                $('.btn_add').click(function(e) {
                                    let index = ($(this).closest('.list_item_feature_group').find('.item_feature')?.length ?? 0) + 1
                                    e.preventDefault()
                                    const type = $(this).data('type') ?? ''
                                    let input = ''
                                    switch (type) {
                                        case 'select_type':
                                            input = `<select name="socials[${index}][type]" class="form-select select_2 mb-2"
                                                            data-control="select2" data-placeholder="Select an type"
                                                            data-allow-clear="true">
                                                            <option value="">--Select Type--</option>
                                                            <option value="facebook">Facebook</option>
                                                            <option value="github">Github</option>
                                                            <option value="youtube">Youtube</option>
                                                            <option value="instagram">Instagram</option>
                                                            <option value="behance">Behance</option>
                                                        </select>
                                                        <input type="text" class="form-control " name="skills[${index}][link]"
                                                    placeholder="Link." />`
                                            break;
                                        case 'skills':
                                            input = `<input type="text" class="form-control " name="skills[${index}][name]"
                                                        placeholder="Name.." />
                                                        <input type="text" class="form-control " name="skills[${index}][content]"
                                                        placeholder="Content." />`
                                            break;
                                        case 'extra_skills':
                                            input = `<input type="text" class="form-control " name="extra_skills[${index}]"
                                                        placeholder="Extra_skills." />`
                                            break;
                                        case 'educations_type':
                                            input = ` <div style="flex:1">
                                                        <div class="" style="flex:1">
                                                            <div class=" d-flex" style="gap: 10px;margin-bottom:10px">
                                                                <input type="text" class="form-control col-md-6 w-50"
                                                                    name="educations[${index}][time]" placeholder="2023 - 12/2024." />
                                                                <input type="text" class="form-control col-md-6 w-50"
                                                                    name="educations[${index}][logo]" placeholder="Link Logo." />
                                                            </div>
                                                            <div class=" d-flex" style="gap: 10px;margin-bottom:10px">
                                                                <input type="text" class="form-control col-md-6 w-50"
                                                                    name="educations[${index}][name]" placeholder="Name.." />
                                                                <input type="text" class="form-control col-md-6 w-50"
                                                                    name="educations[${index}][address]" placeholder="Address." />
                                                            </div>
                                                        </div>
                                                        <div>
                                                            <input type="text" class="form-control "
                                                                name="educations[${index}][content]" placeholder="Content." />
                                                        </div>
                                                    </div>`
                                            break
                                        case 'reviews_type':
                                            input = `<div class="" style="flex:1">
                                                        <div class=" d-flex" style="gap: 10px;margin-bottom:10px">
                                                            <input type="text" class="form-control col-md-6 w-50"
                                                                name="reviews[${index}][avatar]" placeholder="avatar.." />
                                                            <input type="text" class="form-control col-md-6 w-50"
                                                                name="reviews[${index}][name]" placeholder="Name." />
                                                        </div>
                                                        <div class=" d-flex" style="gap: 10px;margin-bottom:10px">
                                                            <input type="text" class="form-control col-md-6 w-50"
                                                                name="reviews[${index}][username]" placeholder="Username.." />
                                                            <input type="text" class="form-control col-md-6 w-50"
                                                                name="reviews[${index}][content]" placeholder="Content." />
                                                        </div>
                                                    </div>`
                                            break
                                        case 'awards_type':
                                            input = `<div class="" style="flex:1">
                                                            <div class=" d-flex" style="gap: 10px;margin-bottom:10px">
                                                                <input type="text" class="form-control col-md-6 w-50"
                                                                    name="awards[${index}][name]" placeholder="name.." />
                                                                <input type="text" class="form-control col-md-6 w-50"
                                                                    name="awards[${index}][location]" placeholder="location." />
                                                            </div>
                                                            <div class=" d-flex" style="gap: 10px;margin-bottom:10px">
                                                                <input type="text" class="form-control col-md-6 w-50"
                                                                    name="awards[${index}][date]" placeholder="date.." />
                                                                <input type="text" class="form-control col-md-6 w-50"
                                                                    name="awards[${index}][content]" placeholder="content." />
                                                            </div>
                                                            <div>
                                                                <textarea name="awards[${index}][images]"class="form-control " cols="30" rows="3" placeholder="image|image|image"></textarea>
                                                            </div>
                                                        </div>
                                                `
                                            break
                                        case 'work_experience_type':
                                            input = ` <div class="" style="flex:1">
                                                            <div class=" d-flex" style="gap: 10px;margin-bottom:10px">
                                                                <input type="text" class="form-control col-md-6 w-50"
                                                                    name="work_experience[${index}][company]" placeholder="company.." />
                                                                <input type="text" class="form-control col-md-6 w-50"
                                                                    name="work_experience[${index}][location]" placeholder="location." />
                                                            </div>
                                                            <div class=" d-flex" style="gap: 10px;margin-bottom:10px">
                                                                <input type="text" class="form-control col-md-6 w-50"
                                                                    name="work_experience[${index}][position]" placeholder="position.." />
                                                                <input type="text" class="form-control col-md-6 w-50"
                                                                    name="work_experience[${index}][period]" placeholder="Mar 2024 - Present." />
                                                            </div>
                                                            <div>
                                                                <textarea name="work_experience[${index}][achievements]"class="form-control " cols="30" rows="3"
                                                                    placeholder="achievements... item|item|item"></textarea>
                                                            </div>
                                                        </div>
                                                `
                                            break
                                        default:
                                            input = ` <input type="text" class="form-control " name="languages[${index}][name]"
                                                        placeholder="Name.." />
                                                        <input type="text" class="form-control " name="languages[${index}][content]"
                                                        placeholder="Content." />`
                                            break;

                                    }

                                    $(this).closest('.list_item_feature_group').find('.list_item_feature').append(`<div class="form-group d-flex item_feature mb-5"
                                                            style="align-items: center; gap:10px">
                                                            <button onclick="remove(this)" type="button" data-repeater-delete=""
                                                                class="btn btn-sm btn-icon btn-light-danger btn_delete">
                                                                <i class="ki-outline ki-cross fs-1"></i>
                                                            </button>
                                                        ${input}
                                                        </div>`)
                                    $('.select_2').select2()
                                    index++
                                })

                                function remove(element) {
                                    $(element).closest('.item_feature').remove()
                                }
                            </script>
                            <div class="fv-row mb-10">
                                <!--begin::Label-->
                                <label class="fs-5 fw-bold form-label mb-2">
                                    <span class="">Status</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <select class="form-select mb-2" data-control="select2" name="status"
                                    data-placeholder="Select an option" data-allow-clear="true" id="">
                                    <option value="active" {{ $params['item']->status == 'active' ? 'selected' : '' }}>
                                        Active</option>
                                    <option value="inactive"
                                        {{ $params['item']->status == 'inactive' ? 'selected' : '' }}>
                                        Inactive</option>

                                </select>
                                <!--end::Input-->
                            </div>


                        </div>
                        <!--end::Scroll-->
                        <!--begin::Actions-->
                        <div class="text-center pt-15">
                            <button type="submit" class="btn btn-primary" data-kt-roles-modal-action="submit">
                                <span class="indicator-label">Submit</span>
                                <span class="indicator-progress">Please wait...
                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                            </button>
                        </div>
                        <!--end::Actions-->
                    </form>
                    <!--end::Form-->
                </div>
                <!--end::Modal body-->
            </div>
            <!--end::Modal content-->
        </div>



    </div>
@endsection
@push('js2')
    <!--begin::Custom Javascript(used for this page only)-->
    {{-- <script src="{{ asset('assets/js/custom/apps/user-management/permissions/list.js') }}"></script>
    <script src="{{ asset('assets/js/custom/apps/user-management/permissions/add-permission.js') }}"></script>
    <script src="{{ asset('assets/js/custom/apps/user-management/permissions/update-permission.js') }}"></script> --}}
    <script src="{{ asset('assets/js/widgets.bundle.js') }}"></script>
    <script src="{{ asset('assets/js/custom/widgets.js') }}"></script>
    <script src="{{ asset('assets/js/custom/apps/chat/chat.js') }}"></script>
    <script src="{{ asset('assets/js/custom/utilities/modals/users-search.js') }}"></script>


    <script src="{{ asset('assets/js/custom/apps/ecommerce/catalog/save-product.js') }}"></script>

    <!--end::Custom Javascript-->
    <!--end::Javascript-->
@endpush
