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
                    <h2 class="fw-bold">Edit data</h2>
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
                                    <span class="required">Title</span>
                                </label>

                                <input class="form-control form-control-solid" placeholder="Enter Aa.." name="title"
                                    value="{{ $params['item']->title }}" />
                                @error('title')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>


                            <div class="row">
                                <div class="fv-row mb-10 col-md-6">
                                    <!--begin::Label-->
                                    <label class="fs-5 fw-bold form-label mb-2 w-100">
                                        <span class=" mb-5">Avatar</span>
                                        <input type="text" class="form-control form-control-solid my-5"
                                            placeholder="Or Enter https.." value="{{ $params['item']->image }}"
                                            name="image_link" />
                                    </label>

                                    <div class="card-body text-center pt-0">

                                        <style>
                                            .image-input-placeholder.avatar {
                                                background-image: url('{{ $params['item']->image ?? asset('assets/media/svg/files/blank-image.svg') }}');
                                            }

                                            [data-bs-theme="dark"] .image-input-placeholder.avatar {
                                                background-image: url('{{ $params['item']->image ?? asset('assets/media/svg/files/blank-image-dark.svg') }}');
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
                                                <input type="file" name="image" accept=".png, .jpg, .jpeg" />
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


                            <div class="fv-row mb-10">
                                <label class="fs-5 fw-bold form-label mb-2">
                                    <span class="">Tags</span>
                                </label>
                                <div class="list_item_feature_group">
                                    <!--begin::Form group-->
                                    <div class="list_item_feature">
                                        @foreach ($params['item']->tags ?? [] as $key => $item)
                                            <div class="form-group d-flex item_feature mb-5"
                                                style="align-items: center; gap:10px">
                                                <button onclick="remove(this)" type="button" data-repeater-delete=""
                                                    class="btn btn-sm btn-icon btn-light-danger btn_delete">
                                                    <i class="ki-outline ki-cross fs-1"></i>
                                                </button>
                                                <input type="text" class="form-control " value="{{ $item }}"
                                                    name="tags[{{ $key }}]"
                                                    placeholder="tags." />

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
                            <div class="mb-10">
                                <!--begin::Label-->
                                <label class="form-label">Description</label>
                                <!--end::Label-->
                                <!--begin::Editor-->
                                <div id="kt_ecommerce_add_product_meta_description" name="description"
                                    class=" mb-2" style="min-height: 500px">{!!$params['item']->description!!}</div>
                                <!--end::Editor-->
                                <input type="text" name="description" id="hidden_description"
                                    value="{{ $params['item']->description }}" class="hidden" hidden>
                                <script>
                                    // const quill = new Quill('#kt_ecommerce_add_product_meta_description', {
                                    //     theme: 'snow'
                                    // });

                                    $('#form_main').on('submit', function(e) {
                                        const html = $('#kt_ecommerce_add_product_meta_description .ql-editor').html();

                                        $('#hidden_description').val(html);
                                    });
                                </script>
                                <!--begin::Description-->
                                <div class="text-muted fs-7">Set a description to the project
                                    ranking.</div>
                            </div>

                            <script>
                                $('.btn_add').click(function(e) {
                                    let index = ($(this).closest('.list_item_feature_group').find('.item_feature')?.length ?? 0) + 1
                                    e.preventDefault()
                                    const type = $(this).data('type') ?? ''
                                    let input = ''
                                    switch (type) {

                                        case 'extra_skills':
                                            input = `<input type="text" class="form-control " name="tags[${index}]"
                                                        placeholder="tags." />`
                                            break;

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
                                    <span class="">Priority</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="number" min="1" class="form-control form-control-solid" value="{{$params['item']->priority}}" placeholder=""
                                    name="priority" />
                                <!--end::Input-->
                            </div>
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
