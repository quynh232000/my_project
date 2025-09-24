@extends('layout.app')
@section('main')

<main >
    <!-- Content -->
    <div class="content container-fluid">
        <div class="row justify-content-sm-center text-center py-10">
            <div class="col-sm-8 col-md-6">
                <img class="img-fluid mb-5" src="assets\svg\illustrations\graphs.svg" alt="Image Description"
                    style="max-width: 21rem;">

                <div>
                    <h1>Hello <span class="text-primary">{{auth()->user()->full_name}}</span>, chào mừng bạn quay lại!</h1>
                </div>
                <p>Cảm ơn bạn đã đồng hành cùng hệ thống. <br>
                    Mỗi hành động của bạn đều góp phần tạo nên trải nghiệm mua sắm tuyệt vời cho khách hàng. Hãy cùng nhau phát triển và lan tỏa giá trị nhé!</p>

                <a class="btn btn-primary" href="{{route('dashboard')}}">Bắt đầu ngay</a>
            </div>
        </div>
        <!-- End Row -->
    </div>
    <!-- End Content -->

    <!-- Footer -->

    <div class="footer">
        <div class="row justify-content-between align-items-center">
            <div class="col">
                <p class="font-size-sm mb-0">&copy; Front. <span class="d-none d-sm-inline-block">2020
                        Htmlstream.</span></p>
            </div>
            <div class="col-auto">
                <div class="d-flex justify-content-end">
                    <!-- List Dot -->
                    <ul class="list-inline list-separator">
                        <li class="list-inline-item">
                            <a class="list-separator-link" href="#">FAQ</a>
                        </li>

                        <li class="list-inline-item">
                            <a class="list-separator-link" href="#">License</a>
                        </li>

                        <li class="list-inline-item">
                            <!-- Keyboard Shortcuts Toggle -->
                            <div class="hs-unfold">
                                <a class="js-hs-unfold-invoker btn btn-icon btn-ghost-secondary rounded-circle"
                                    href="javascript:;"
                                    data-hs-unfold-options='{
                            "target": "#keyboardShortcutsSidebar",
                            "type": "css-animation",
                            "animationIn": "fadeInRight",
                            "animationOut": "fadeOutRight",
                            "hasOverlay": true,
                            "smartPositionOff": true
                           }'>
                                    <i class="tio-command-key"></i>
                                </a>
                            </div>
                            <!-- End Keyboard Shortcuts Toggle -->
                        </li>
                    </ul>
                    <!-- End List Dot -->
                </div>
            </div>
        </div>
    </div>



    <!-- End Footer -->
</main>
@endsection
