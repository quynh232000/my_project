@php
    $sidebars = [
        [
            'icon' => '<i class="fa-solid fa-people-group nav-icon"></i>',
            'key' => 'user',
            'name' => 'Thành viên',
            'link' => '#',
            'haschild' => true,
            'children' => [
                [
                    'icon' => '<i class="fa-solid fa-people-line"></i>',
                    'key' => 'user.list',
                    'name' => 'Tất cả',
                    'link' => route('user.list'),
                    'haschild' => false,
                ],
                [
                    'icon' => '<i class="fa-solid fa-user-plus"></i>',
                    'key' => 'user.add',
                    'name' => 'Thêm người dùng',
                    'link' => route('user.add'),
                    'haschild' => false,
                ],
                [
                    'icon' => '<i class="fa-solid fa-user-tie"></i>',
                    'key' => 'user.profile',
                    'name' => 'Hồ sơ',
                    'link' => '#',
                    'haschild' => false,
                ],
                [
                    'icon' => '<i class="fa-solid fa-paint-roller"></i>',
                    'key' => 'user.role',
                    'name' => 'Vài trò',
                    'link' => route('user.role.list'),
                    'haschild' => false,
                ],
            ],
        ],
        [
            'icon' => '<i class="fa-solid fa-layer-group"></i>',
            'key' => 'product',
            'name' => 'Sản phẩm',
            'link' => '#',
            'haschild' => true,
            'children' => [
                [
                    'icon' => '',
                    'key' => 'product.category.list',
                    'name' => 'Danh mục',
                    'link' => route('product.category.list'),
                    'haschild' => false,
                ],
                [
                    'icon' => '',
                    'key' => 'product.add',
                    'name' => 'Thêm sản phẩm',
                    'link' => route('product.add'),
                    'haschild' => false,
                ],
                [
                    'icon' => '',
                    'key' => 'product.list',
                    'name' => 'Danh sách sản phẩm',
                    'link' => route('product.list'),
                    'haschild' => false,
                ],
            ],
        ],
        [
            'icon' => '<i class="fa-solid fa-calendar-days"></i>',
            'key' => 'order',
            'name' => 'Quản lý đơn hàng',
            'link' => '#',
            'haschild' => true,
            'children' => [
                [
                    'icon' => '',
                    'key' => 'order.user',
                    'name' => 'Đơn hàng người dùng',
                    'link' => route('order.user'),
                    'haschild' => false,
                ],
                [
                    'icon' => '',
                    'key' => 'order.index',
                    'name' => 'Đơn hàng cửa hàng',
                    'link' => route('order.index'),
                    'haschild' => false,
                ],
            ],
        ],
        [
            'icon' => '<i class="fa-solid fa-truck"></i>',
            'key' => 'order.delivery',
            'name' => 'Trang Shipping',
            'link' => '#',
            'haschild' => true,
            'children' => [
                [
                    'icon' => '',
                    'key' => 'order.delivery',
                    'name' => 'Đơn hàng vận chuyển',
                    'link' => route('order.delivery'),
                    'haschild' => false,
                ],
            ],
        ],
        [
            'icon' => '<i class="fa-solid fa-folder-open"></i>',
            'key' => 'file',
            'name' => 'Quản lý Files',
            'link' => '#',
            'haschild' => true,
            'children' => [
                [
                    'icon' => '',
                    'key' => 'file.list',
                    'name' => 'Thư viện',
                    'link' => route('file.list'),
                    'haschild' => false,
                ],
                [
                    'icon' => '',
                    'key' => 'file.add',
                    'name' => 'Thêm ảnh',
                    'link' => route('file.add'),
                    'haschild' => false,
                ],
            ],
        ],
        [
            'icon' => '<i class="fa-solid fa-images"></i>',
            'key' => 'banner',
            'name' => 'Quản lý Banner',
            'link' => '#',
            'haschild' => true,
            'children' => [
                [
                    'icon' => '',
                    'key' => 'banner.add',
                    'name' => 'Thêm Banner ',
                    'link' => route('banner.add'),
                    'haschild' => false,
                ],
                [
                    'icon' => '',
                    'key' => 'banner.list',
                    'name' => 'Danh sách Banner',
                    'link' => route('banner.list'),
                    'haschild' => false,
                ],
            ],
        ],
        [
            'icon' => '<i class="fa-solid fa-blog"></i>',
            'key' => 'marketing',
            'name' => 'Quản trị marketing',
            'link' => '#',
            'haschild' => true,
            'children' => [
                [
                    'icon' => '',
                    'key' => 'marketing.voucher.add',
                    'name' => 'Thêm khuyến mãi ',
                    'link' => route('marketing.voucher.add'),
                    'haschild' => false,
                ],
                [
                    'icon' => '',
                    'key' => 'marketing.voucher.list',
                    'name' => 'Danh sách khuyến mãi',
                    'link' => route('marketing.voucher.list'),
                    'haschild' => false,
                ],
            ],
        ],
        [
            'icon' => '<i class="fa-solid fa-video"></i>',
            'key' => 'live',
            'name' => 'Phiên live stream',
            'link' => '#',
            'haschild' => true,
            'children' => [
                [
                    'icon' => '',
                    'key' => 'live.index',
                    'name' => 'Danh sách',
                    'link' => route('live.index'),
                    'haschild' => false,
                ]
            ],
        ],
        [
            'icon' => '<i class="fa-solid fa-shop"></i>',
            'key' => 'shop.list',
            'name' => 'Cửa hàng',
            'link' => '#',
            'haschild' => true,
            'children' => [
                [
                    'icon' => '',
                    'key' => 'shop.list',
                    'name' => 'Danh sách cửa hàng',
                    'link' => route('shop.list'),
                    'haschild' => false,
                ],
            ],
        ],
        [
            'icon' => '<i class="fa-regular fa-newspaper"></i>',
            'key' => 'post.list',
            'name' => 'Bài viết',
            'link' => '#',
            'haschild' => true,
            'children' => [
                [
                    'icon' => '',
                    'key' => 'post.list',
                    'name' => 'Danh sách bài viết',
                    'link' => route('post.list'),
                    'haschild' => false,
                ],
                [
                    'icon' => '',
                    'key' => 'post.add',
                    'name' => 'Thêm bài viết',
                    'link' => route('post.add'),
                    'haschild' => false,
                ],
                [
                    'icon' => '',
                    'key' => 'post.category',
                    'name' => 'Danh mục bài viết',
                    'link' => route('post.category'),
                    'haschild' => false,
                ],
                [
                    'icon' => '',
                    'key' => 'post.settings',
                    'name' => 'Cài đặt bài viết',
                    'link' => route('post.settings'),
                    'haschild' => false,
                ],
            ],
        ],
        [
            'icon' => '<i class="fa-solid fa-coins"></i>',
            'key' => 'coin.list',
            'name' => 'Quin Xu',
            'link' => route('coin.list'),
            'haschild' => true,
            'children' => [
                [
                    'icon' => '',
                    'key' => 'coin.list',
                    'name' => 'Tổng quan',
                    'link' => route('coin.list'),
                    'haschild' => false,
                ],
                [
                    'icon' => '',
                    'key' => 'post.list',
                    'name' => 'Quy tắc xu',
                    'link' => route('coin.rules'),
                    'haschild' => false,
                ],
            ],
        ],
        [
            'icon' => '<i class="fa-solid fa-bell"></i>',
            'key' => 'notify.list',
            'name' => 'Cài đặt thông báo',
            'link' => route('notify.list'),
            'haschild' => true,
            'children' => [
                [
                    'icon' => '',
                    'key' => 'notify.list',
                    'name' => 'Danh sách thông báo',
                    'link' => route('notify.list'),
                    'haschild' => false,
                ],
                [
                    'icon' => '',
                    'key' => 'notify.list.history',
                    'name' => 'Lịch sử thông báo',
                    'link' => route('notify.list.history'),
                    'haschild' => false,
                ],
                [
                    'icon' => '',
                    'key' => 'notify.add',
                    'name' => 'Thêm thông báo mới',
                    'link' => route('notify.add'),
                    'haschild' => false,
                ],
            ],
        ],
        [
            'icon' => '<i class="fa-solid fa-gear"></i>',
            'key' => 'settings',
            'name' => 'Cài đặt',
            'link' => route('settings'),
            'haschild' => true,
            'children' => [
                [
                    'icon' => '',
                    'key' => 'settings',
                    'name' => 'Cài đặt chung',
                    'link' => route('settings'),
                    'haschild' => false,
                ],
                [
                    'icon' => '',
                    'key' => 'payment-method.index',
                    'name' => 'Phương thức thanh toán',
                    'link' => route('payment-method.index'),
                    'haschild' => false,
                ],
                // [
                //     'icon' => '',
                //     'key' => 'notify.add',
                //     'name' => 'Thêm thông báo mới',
                //     'link' => route('notify.add'),
                //     'haschild' => false,
                // ],
            ],
        ],
    ];
@endphp



<div id="sidebarMain" class="d-none">
    <aside
        class="js-navbar-vertical-aside navbar navbar-vertical-aside navbar-vertical navbar-vertical-fixed navbar-expand-xl navbar-bordered">
        <div class="navbar-vertical-container">
            <div class="navbar-vertical-footer-offset">
                <div class="navbar-brand-wrapper justify-content-between">
                    <!-- Logo -->

                    <a class="navbar-brand" href="{{ route('dashboard') }}" aria-label="Front">
                        <img class="navbar-brand-logo" src="{{ asset('assets\svg\logos\logo.png') }}" alt="Logo" />
                        <img class="navbar-brand-logo-mini" src="{{ asset('assets\svg\logos\logo-short.svg') }}"
                            alt="Logo" />
                    </a>

                    <!-- End Logo -->

                    <!-- Navbar Vertical Toggle -->
                    <button type="button"
                        class="js-navbar-vertical-aside-toggle-invoker navbar-vertical-aside-toggle btn btn-icon btn-xs btn-ghost-dark">
                        <i class="tio-clear tio-lg"></i>
                    </button>
                    <!-- End Navbar Vertical Toggle -->
                </div>

                <!-- Content -->
                <div class="navbar-vertical-content">
                    <ul class="navbar-nav navbar-nav-lg nav-tabs">
                        <!-- Dashboards -->
                        <li
                            class="navbar-vertical-aside-has-menu {{ str_contains(Route::currentRouteName(), 'dashboard') ? 'show' : '' }}">
                            <a class="j nav-link nav-link-toggle active"
                            href="{{ route('dashboard') }}" title="Dashboards">
                                <i class="tio-home-vs-1-outlined nav-icon"></i>
                                <span class=" text-truncate">Trang quản
                                    trị</span>
                            </a>


                        </li>
                        <!-- End Dashboards -->
                        @php
                            function renderSidebar($data)
                            {
                                $html = '';
                                foreach ($data as $item) {
                                    $active = str_contains(Route::currentRouteName(), $item['key']) ? 'show' : '';
                                    $childHtml = '';
                                    if ($item['haschild']) {
                                        $childHtml .= ' <ul class="js-navbar-vertical-aside-submenu nav nav-sub">';
                                        $childHtml .= renderSidebar($item['children']);
                                        $childHtml .= ' </ul>';

                                        $name =
                                            '<a  class="d-flex align-items-center js-navbar-vertical-aside-menu-link nav-link nav-link-toggle "
                                                    href="javascript:;" title="' .
                                            $item['name'] .
                                            '">
                                                <span style="min-width:30px"> ' .
                                            $item['icon'] .
                                            '</span>
                                                    <span
                                                        class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">' .
                                            $item['name'] .
                                            '</span>
                                                </a>';
                                    } else {
                                        $name =
                                            '<a class="nav-link" href="' .
                                            $item['link'] .
                                            '" title="' .
                                            $item['name'] .
                                            '">
                                                    <span class="tio-circle-outlined nav-indicator-icon"></span>
                                                    <span class="text-truncate">' .
                                            $item['name'] .
                                            '</span>
                                                </a>';
                                    }
                                    $html .=
                                        '<li class="navbar-vertical-aside-has-menu ' .
                                        $active .
                                        '">
                                                ' .
                                        $name .
                                        '
                                                ' .
                                        $childHtml .
                                        '
                                            </li>';
                                }
                                return $html;
                            }
                        @endphp

                        @php
                            echo renderSidebar($sidebars);
                        @endphp



                    </ul>
                </div>
                <!-- End Content -->

                <!-- Footer -->
                <div class="navbar-vertical-footer">
                    <ul class="navbar-vertical-footer-list">
                        <li class="navbar-vertical-footer-list-item">
                            <!-- Unfold -->
                            <div class="hs-unfold">
                                <a class="js-hs-unfold-invoker btn btn-icon btn-ghost-secondary rounded-circle"
                                    href="javascript:;"
                                    data-hs-unfold-options='{
              "target": "#styleSwitcherDropdown",
              "type": "css-animation",
              "animationIn": "fadeInRight",
              "animationOut": "fadeOutRight",
              "hasOverlay": true,
              "smartPositionOff": true
             }'>
                                    <i class="tio-tune"></i>
                                </a>
                            </div>
                            <!-- End Unfold -->
                        </li>

                        <li class="navbar-vertical-footer-list-item">
                            <!-- Other Links -->
                            <div class="hs-unfold">
                                <a class="js-hs-unfold-invoker btn btn-icon btn-ghost-secondary rounded-circle"
                                    href="javascript:;"
                                    data-hs-unfold-options='{
              "target": "#otherLinksDropdown",
              "type": "css-animation",
              "animationIn": "slideInDown",
              "hideOnScroll": true
             }'>
                                    <i class="tio-help-outlined"></i>
                                </a>

                                <div id="otherLinksDropdown"
                                    class="hs-unfold-content dropdown-unfold dropdown-menu navbar-vertical-footer-dropdown">
                                    <span class="dropdown-header">Help</span>
                                    <a class="dropdown-item" href="#">
                                        <i class="tio-book-outlined dropdown-item-icon"></i>
                                        <span class="text-truncate pr-2" title="Resources &amp; tutorials">Resources
                                            &amp; tutorials</span>
                                    </a>
                                    <a class="dropdown-item" href="#">
                                        <i class="tio-command-key dropdown-item-icon"></i>
                                        <span class="text-truncate pr-2" title="Keyboard shortcuts">Keyboard
                                            shortcuts</span>
                                    </a>
                                    <a class="dropdown-item" href="#">
                                        <i class="tio-alt dropdown-item-icon"></i>
                                        <span class="text-truncate pr-2" title="Connect other apps">Connect
                                            other apps</span>
                                    </a>
                                    <a class="dropdown-item" href="#">
                                        <i class="tio-gift dropdown-item-icon"></i>
                                        <span class="text-truncate pr-2" title="What's new?">What's new?</span>
                                    </a>
                                    <div class="dropdown-divider"></div>
                                    <span class="dropdown-header">Contacts</span>
                                    <a class="dropdown-item" href="#">
                                        <i class="tio-chat-outlined dropdown-item-icon"></i>
                                        <span class="text-truncate pr-2" title="Contact support">Contact
                                            support</span>
                                    </a>
                                </div>
                            </div>
                            <!-- End Other Links -->
                        </li>

                        <li class="navbar-vertical-footer-list-item">
                            <!-- Language -->
                            <div class="hs-unfold">
                                <a class="js-hs-unfold-invoker btn btn-icon btn-ghost-secondary rounded-circle"
                                    href="javascript:;"
                                    data-hs-unfold-options='{
              "target": "#languageDropdown",
              "type": "css-animation",
              "animationIn": "slideInDown",
              "hideOnScroll": true
             }'>
                                    <img class="avatar avatar-xss avatar-circle"
                                        src="{{ asset('assets\vendor\flag-icon-css\flags\1x1\us.svg') }}"
                                        alt="United States Flag" />
                                </a>

                                <div id="languageDropdown"
                                    class="hs-unfold-content dropdown-unfold dropdown-menu navbar-vertical-footer-dropdown">
                                    <span class="dropdown-header">Select language</span>
                                    <a class="dropdown-item" href="#">
                                        <img class="avatar avatar-xss avatar-circle mr-2"
                                            src="{{ asset('assets\vendor\flag-icon-css\flags\1x1\us.svg') }}"
                                            alt="Flag" />
                                        <span class="text-truncate pr-2" title="English">English (US)</span>
                                    </a>
                                    <a class="dropdown-item" href="#">
                                        <img class="avatar avatar-xss avatar-circle mr-2"
                                            src="{{ asset('assets\vendor\flag-icon-css\flags\1x1\gb.svg') }}"
                                            alt="Flag" />
                                        <span class="text-truncate pr-2" title="English">English (UK)</span>
                                    </a>
                                    <a class="dropdown-item" href="#">
                                        <img class="avatar avatar-xss avatar-circle mr-2"
                                            src="{{ asset('assets\vendor\flag-icon-css\flags\1x1\de.svg') }}"
                                            alt="Flag" />
                                        <span class="text-truncate pr-2" title="Deutsch">Deutsch</span>
                                    </a>
                                    <a class="dropdown-item" href="#">
                                        <img class="avatar avatar-xss avatar-circle mr-2"
                                            src="{{ asset('assets\vendor\flag-icon-css\flags\1x1\dk.svg') }}"
                                            alt="Flag" />
                                        <span class="text-truncate pr-2" title="Dansk">Dansk</span>
                                    </a>
                                    <a class="dropdown-item" href="#">
                                        <img class="avatar avatar-xss avatar-circle mr-2"
                                            src="{{ asset('assets\vendor\flag-icon-css\flags\1x1\it.svg') }}"
                                            alt="Flag" />
                                        <span class="text-truncate pr-2" title="Italiano">Italiano</span>
                                    </a>
                                    <a class="dropdown-item" href="#">
                                        <img class="avatar avatar-xss avatar-circle mr-2"
                                            src="{{ asset('assets\vendor\flag-icon-css\flags\1x1\cn.svg') }}"
                                            alt="Flag" />
                                        <span class="text-truncate pr-2" title="中文 (繁體)">中文 (繁體)</span>
                                    </a>
                                </div>
                            </div>
                            <!-- End Language -->
                        </li>
                    </ul>
                </div>
                <!-- End Footer -->
            </div>
        </div>
    </aside>
</div>
