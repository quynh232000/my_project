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
                            <!--begin::Input group-->
                            <div class="fv-row mb-10">
                                <!--begin::Label-->
                                <label class="fs-5 fw-bold form-label mb-2">
                                    <span class="required">Name Project</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input class="form-control form-control-solid" placeholder="Enter Aa.."
                                    value="{{ old('title') ?? $params['item']->title }}" name="title" />
                                @error('title')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="fv-row mb-10">
                                <!--begin::Label-->
                                <label class="fs-5 fw-bold form-label mb-2 d-flex" style="gap: 10px">
                                    <span class=" mr-5 pr-5">Is Home</span>
                                    <div class=" form-check form-check-sm form-check-custom form-check-solid me-3">
                                        <input class="form-check-input" type="checkbox" data-kt-check="true"
                                            data-kt-check-target="" value="1" checked name="isHome">
                                    </div>
                                </label>
                                <label class="form-check-label">This will show in home page</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                @error('isHome')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="fv-row mb-10">
                                <!--begin::Label-->
                                <label class="fs-5 fw-bold form-label mb-2 w-100">
                                    <span class=" mb-5">Thumbnail</span>
                                    <input type="text" class="form-control form-control-solid my-5"
                                        placeholder="Or Enter https.." value="{{ $params['item']->thumbnail }}"
                                        name="image_link" />
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                {{-- <input type="file" class="form-control form-control-solid" placeholder="Enter Aa.."
                                    name="icon" /> --}}
                                <div class="card-body text-center pt-0">
                                    <!--begin::Image input-->
                                    <!--begin::Image input placeholder-->
                                    <style>
                                        .image-input-placeholder {
                                            background-image: url(' {{ $params['item']->thumbnail ?? asset('assets/media/svg/files/blank-image.svg') }}');
                                        }

                                        [data-bs-theme="dark"] .image-input-placeholder {
                                            background-image: url('{{ asset('assets/media/svg/files/blank-image-dark.svg') }}');
                                        }
                                    </style>
                                    <!--end::Image input placeholder-->
                                    <div class="image-input image-input-empty image-input-outline image-input-placeholder mb-3"
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
                                        <!--end::Label-->
                                        <!--begin::Cancel-->
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

                            <div class="fv-row mb-10">
                                <!--begin::Label-->
                                <label class="fs-5 fw-bold form-label mb-2">
                                    <span class="">List Images</span>
                                </label>
                                <div>
                                    <label class="form-check-label">Item | item |....</label>
                                </div>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <textarea name="images" id="" class="form-control form-control-solid" cols="30" rows="4">{{ $params['item']->images }}</textarea>

                                <!--end::Input-->
                            </div>
                            <div class="fv-row mb-10">
                                <!--begin::Label-->
                                <label class="fs-5 fw-bold form-label mb-2">
                                    <span class="">Feature Main</span>
                                </label>
                                <div>
                                    <label class="form-check-label">Item | item |....</label>
                                </div>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <textarea name="featuremain" id="" class="form-control form-control-solid" cols="30" rows="4">{{ $params['item']->featuremain }}</textarea>

                                <!--end::Input-->
                            </div>
                            <div class="mb-10">
                                <!--begin::Label-->
                                <label class="form-label">Description</label>
                                <!--end::Label-->
                                <!--begin::Editor-->
                                <div id="kt_ecommerce_add_product_meta_description" name="description"
                                    class="min-h-200px mb-2">{!!$params['item']->description!!}</div>
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
                            <div class="fv-row mb-10">
                                <!--begin::Label-->
                                <label class="fs-5 fw-bold form-label mb-2">
                                    <span class="">Categories</span>
                                </label>

                                <select name="category[]" class="form-select mb-2" data-control="select2"
                                    data-placeholder="Select an option" data-allow-clear="true" multiple="multiple">
                                    <option></option>
                                    @foreach ($params['categories'] ?? [] as $item)
                                        <option value="{{ $item->name }}"
                                            {{ in_array($item->name, $params['item']->category ?? []) ? 'selected' : '' }}>
                                            {{ $item->name }}</option>
                                    @endforeach

                                </select>
                            </div>


                            <div class="fv-row mb-10">
                                <label class="fs-5 fw-bold form-label mb-2">
                                    <span class="">Features</span>
                                </label>
                                <div id="kt_ecommerce_add_product_options">
                                    <!--begin::Form group-->
                                    <div class="list_item_feature">
                                        @foreach ($params['item']->feature ?? [] as $item)
                                            <div class="form-group d-flex item_feature mb-5"
                                                style="align-items: center; gap:10px">
                                                <button onclick="remove(this)" type="button" data-repeater-delete=""
                                                    class="btn btn-sm btn-icon btn-light-danger btn_delete">
                                                    <i class="ki-outline ki-cross fs-1"></i>
                                                </button>
                                                <input type="text" class="form-control " name="feature[]"
                                                    placeholder="Feature project" value="{{$item}}" />

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


                            <script>
                                $('.btn_add').click(function(e) {
                                    e.preventDefault()
                                    $('.list_item_feature').append(`<div class="form-group mb-5 d-flex item_feature" style="align-items: center; gap:10px">
                                            <button onclick="remove(this)" type="button" data-repeater-delete=""
                                                class="btn btn-sm btn-icon btn-light-danger btn_delete">
                                                <i class="ki-outline ki-cross fs-1"></i>
                                            </button>
                                            <input type="text" class="form-control " name="feature[]"
                                                placeholder="Feature project" />


                                        </div>`)
                                })

                                function remove(element) {
                                    $(element).closest('.item_feature').remove()
                                }
                            </script>

                            <div class="fv-row mb-10">
                                <!--begin::Label-->
                                <label class="fs-5 fw-bold form-label mb-2">
                                    <span class="">Link demo</span>
                                </label>
                                <input type="text" class="form-control form-control-solid" placeholder=""
                                    placeholder="Aa.." name="demo" value="{{old('demo') ?? $params['item']->demo}}"/>
                            </div>
                            <div class="fv-row mb-10">
                                <!--begin::Label-->
                                <label class="fs-5 fw-bold form-label mb-2">
                                    <span class="">Link Source</span>
                                </label>
                                <input type="text" class="form-control form-control-solid" placeholder=""
                                    placeholder="Aa.." name="source" value="{{old('source') ?? $params['item']->source}}" />
                            </div>
                            <div class="fv-row mb-10">
                                <!--begin::Label-->
                                <label class="fs-5 fw-bold form-label mb-2">
                                    <span class="">Priority</span>
                                </label>
                                <input type="number" min="1" value="{{old('priority') ?? $params['item']->priority}}"
                                    class="form-control form-control-solid" placeholder="" placeholder="Aa.."
                                    name="priority" />
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
                                    <option value="active" {{$params['item']->status == 'active' ? 'selected':''}}>Active</option>
                                    <option value="inactive" {{$params['item']->status == 'inactive' ? 'selected':''}}>Inactive</option>

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
