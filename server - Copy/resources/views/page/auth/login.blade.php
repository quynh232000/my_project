@extends('layout.root')
@section('view_title')
    Đăng nhập
@endsection
@section('root')
    <!-- ========== HEADER ========== -->
    <header class="position-absolute top-0 left-0 right-0 mt-3 mx-3">
        <div class="d-flex d-lg-none justify-content-between">
            <a href="/">
                <img class="w-100" src="{{ asset('assets\logo\logo.png') }}" alt="Image Description"
                    style="min-width: 7rem; max-width: 7rem;">
            </a>


            <!-- Select -->
            <div id="languageSelect2" class="select2-custom select2-custom-right z-index-2">
                <select class="js-select2-custom custom-select-sm" size="1" style="opacity: 0;"
                    data-hs-select2-options='{
                      "dropdownParent": "#languageSelect2",
                      "minimumResultsForSearch": "Infinity",
                      "placeholder": "Select language",
                      "customClass": "custom-select custom-select-sm custom-select-borderless bg-transparent",
                      "dropdownAutoWidth": true,
                      "dropdownWidth": "12rem"
                    }'>
                    <option label="empty"></option>
                    <option value="language1"
                        data-option-template='<span class="d-flex align-items-center"><img class="avatar avatar-xss avatar-circle mr-2" src="./assets/vendor/flag-icon-css/flags/1x1/us.svg" alt="Image description" width="16"/><span>English (US)</span></span>'>
                        Việt Nam (VI)</option>

                </select>
            </div>
            <!-- End Select -->
        </div>
    </header>
    <!-- ========== END HEADER ========== -->

    <!-- ========== MAIN CONTENT ========== -->
    <main id="content" role="main" class="main pt-0">
        <!-- Content -->
        <div class="container-fluid px-3">
            <div class="row">
                <!-- Cover -->
                <div
                    class="col-lg-6 d-none d-lg-flex justify-content-center align-items-center min-vh-lg-100 position-relative bg-light px-0">
                    <!-- Logo & Language -->
                    <div class="position-absolute top-0 left-0 right-0 mt-3 mx-3">
                        <div class="d-none d-lg-flex justify-content-between">
                            <a href="index.html">
                                <img class="w-100" src="{{ asset('assets\logo\logo.png') }}" alt="Image Description"
                                    style="min-width: 7rem; max-width: 7rem;">
                            </a>
                        </div>
                    </div>
                    <!-- End Logo & Language -->

                    <div style="max-width: 23rem;">
                        <div class="text-center mb-5">
                            <img class="img-fluid" src="{{ asset('assets\svg\illustrations\chat.svg') }}"
                                alt="Image Description" style="width: 12rem;">
                        </div>

                        <div class="mb-5">
                            <h2 class="display-4">Phát triển cùng Quin :</h2>
                        </div>

                        <!-- List Checked -->
                        <ul class="list-checked list-checked-lg list-checked-primary list-unstyled-py-4">
                            <li class="list-checked-item">
                                <span class="d-block font-weight-bold mb-1">Quản trị hệ thống</span>
                                Tạo nên sự phát triển bền vững
                            </li>

                            <li class="list-checked-item">
                                <span class="d-block font-weight-bold mb-1">Khác phục sự cố kịp thời</span>
                                Không để sảy ra lỗi hệ thống trầm trọng, rủi lo cho hệ thống Quin Ecommerce
                            </li>
                        </ul>
                        <!-- End List Checked -->

                        <div class="row justify-content-between mt-5 gx-2">
                            <div class="col">
                                <img class="img-fluid" src="{{ asset('assets\svg\brands\gitlab-gray.svg') }}"
                                    alt="Image Description">
                            </div>
                            <div class="col">
                                <img class="img-fluid" src="{{ asset('assets\svg\brands\fitbit-gray.svg') }}"
                                    alt="Image Description">
                            </div>
                            <div class="col">
                                <img class="img-fluid" src="{{ asset('assets\svg\brands\flow-xo-gray.svg') }}"
                                    alt="Image Description">
                            </div>
                            <div class="col">
                                <img class="img-fluid" src="{{ asset('assets\svg\brands\layar-gray.svg') }}"
                                    alt="Image Description">
                            </div>
                        </div>
                        <!-- End Row -->
                    </div>
                </div>
                <!-- End Cover -->

                <div class="col-lg-6 d-flex justify-content-center align-items-center min-vh-lg-100">
                    <div class="w-100 pt-10 pt-lg-7 pb-7" style="max-width: 25rem;">
                        <!-- Form -->
                        <form method="post" class="js-validate">
                            @csrf
                            <div class="text-center mb-5">
                                <h1 class="display-4"> Đăng nhập hệ thống</h1>
                                <p>Bạn chưa có tài khoản quản trị? <a href="#">Liên hệ</a>
                                </p>
                            </div>
                            <div class="js-form-message form-group">
                                <label class="input-label" for="signupSrEmail">Email của bạn</label>

                                <input type="email" class="form-control form-control-lg" name="email" id="signupSrEmail"
                                    placeholder="test@example.com" value="{{ old('email') }}" aria-label="test@example.com"
                                    required="" data-msg="Vui lòng nhập Email của bạn.">
                            </div>
                            @error('email')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                            <!-- End Form Group -->

                            <!-- Form Group -->
                            <div class="js-form-message form-group">
                                <label class="input-label" for="signupSrPassword" tabindex="0">
                                    <span class="d-flex justify-content-between align-items-center">
                                        Mật khẩu

                                    </span>
                                </label>

                                <div class="input-group input-group-merge">
                                    <input type="password" class="js-toggle-password form-control form-control-lg"
                                        name="password" id="signupSrPassword" placeholder="**********"
                                        aria-label="8+ characters required" required=""
                                        data-msg="Your password is invalid. Please try again."
                                        value="{{ old('password') }}"
                                        data-hs-toggle-password-options='{
                                            "target": "#changePassTarget",
                                            "defaultClass": "tio-hidden-outlined",
                                            "showClass": "tio-visible-outlined",
                                            "classChangeTarget": "#changePassIcon"
                                            }'>

                                </div>
                                @error('password')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                                <div>
                                    <a class="input-label-secondary" href="authentication-reset-password-cover.html">Quên
                                        mật khẩu?</a>
                                </div>
                            </div>
                            <!-- End Form Group -->

                            <!-- Checkbox -->
                            <div class="form-group">
                                @if (session('error'))
                                    <div class="text-danger">{{ session('error') }}</div>
                                @endif

                                {{-- <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="termsCheckbox"
                                        name="termsCheckbox">
                                    <label class="custom-control-label text-muted" for="termsCheckbox">Ghi nhớ</label>
                                </div> --}}
                            </div>
                            <!-- End Checkbox -->

                            <button type="submit" class="btn btn-lg btn-block btn-primary">Đăng nhập</button>
                            <div class="text-center my-4">
                                <span class="divider text-muted">HOẶC</span>
                            </div>
                            <div class="mb-4" style="gap:5px">
                                <a class="btn btn-lg btn-white btn-block"
                                    href="{{ route('auth.redirect', ['provider' => 'google']) }}">
                                    <span class="d-flex justify-content-center align-items-center">
                                        <img class="avatar avatar-xss mr-1"
                                            src="{{ asset('assets\svg\brands\google.svg') }}" alt="Image Description">
                                        Đăng nhập Google
                                    </span>
                                </a>

                                <a style="background-color: #161616;color:white" class="btn btn-lg btn-white btn-block "
                                    href="{{ route('auth.redirect', ['provider' => 'github']) }}">
                                    <span class="d-flex justify-content-center align-items-center">
                                        <img class="avatar avatar-xss mr-2"
                                            src="{{ asset('assets\img\github.jpg') }}" alt="Image Description">
                                        Đăng nhập Github
                                    </span>
                                </a>
                            </div>



                            <!-- Form Group -->

                        </form>
                        <!-- End Form -->
                    </div>
                </div>
            </div>
            <!-- End Row -->
        </div>
        <!-- End Content -->
    </main>
    <!-- ========== END MAIN CONTENT ========== -->


    <!-- JS Implementing Plugins -->
    <script src="assets\js\vendor.min.js"></script>

    <!-- JS Front -->
    <script src="assets\js\theme.min.js"></script>

    <!-- JS Plugins Init. -->
    <script>
        $(document).on('ready', function() {
            // INITIALIZATION OF SHOW PASSWORD
            // =======================================================
            $('.js-toggle-password').each(function() {
                new HSTogglePassword(this).init()
            });


            // INITIALIZATION OF FORM VALIDATION
            // =======================================================
            $('.js-validate').each(function() {
                $.HSCore.components.HSValidation.init($(this));
            });


            // INITIALIZATION OF SELECT2
            // =======================================================
            $('.js-select2-custom').each(function() {
                var select2 = $.HSCore.components.HSSelect2.init($(this));
            });
        });
    </script>

    <!-- IE Support -->
    <script>
        if (/MSIE \d|Trident.*rv:/.test(navigator.userAgent)) document.write(
            '<script src="./assets/vendor/babel-polyfill/polyfill.min.js"><\/script>');
    </script>
@endsection
