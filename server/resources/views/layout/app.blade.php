@extends('layout.root')

@section('root')
<script src="{{asset('assets\vendor\hs-navbar-vertical-aside\hs-navbar-vertical-aside-mini-cache.js')}}"></script>

<!-- ONLY DEV -->

<!-- Builder -->
<div id="styleSwitcherDropdown" class="hs-unfold-content sidebar sidebar-bordered sidebar-box-shadow"
    style="width: 35rem">
    <div class="card card-lg border-0 h-100">
        <div class="card-header align-items-start">
            <div class="mr-2">
                <h3 class="card-header-title">Front Builder</h3>
                <p>
                    Customize your overview page layout. Choose the one that best fits
                    your needs.
                </p>
            </div>

            <!-- Toggle Button -->
            <a class="js-hs-unfold-invoker btn btn-icon btn-xs btn-ghost-dark" href="javascript:;"
                data-hs-unfold-options='{
              "target": "#styleSwitcherDropdown",
              "type": "css-animation",
              "animationIn": "fadeInRight",
              "animationOut": "fadeOutRight",
              "hasOverlay": true,
              "smartPositionOff": true
             }'>
                <i class="tio-clear tio-lg"></i>
            </a>
            <!-- End Toggle Button -->
        </div>

        <!-- Body -->
        <div class="card-body sidebar-scrollbar">
            <h4 class="mb-1">
                Layout skins
                <span id="js-builder-disabled" class="badge badge-soft-danger" style="opacity: 0">Disabled</span>
            </h4>
            <p>3 kinds of layout skins to choose from.</p>

            <div class="row gx-2 mb-5">
                <!-- Custom Radio -->
                <div class="col-4 text-center">
                    <div class="text-center">
                        <div class="custom-checkbox-card mb-2">
                            <input type="radio" class="custom-checkbox-card-input" name="layoutSkinsRadio"
                                id="layoutSkinsRadio1" checked="" value="default" />
                            <label class="custom-checkbox-card-label" for="layoutSkinsRadio1">
                                <img class="custom-checkbox-card-img"
                                    src="{{asset('assets\svg\layouts\layouts-sidebar-default.svg')}}" alt="Image Description" />
                            </label>
                            <span class="custom-checkbox-card-text">Default</span>
                        </div>
                    </div>
                </div>
                <!-- End Custom Radio -->

                <!-- Custom Radio -->
                <div class="col-4 text-center">
                    <div class="text-center">
                        <div class="custom-checkbox-card mb-2">
                            <input type="radio" class="custom-checkbox-card-input" name="layoutSkinsRadio"
                                id="layoutSkinsRadio2" value="navbar-dark" />
                            <label class="custom-checkbox-card-label" for="layoutSkinsRadio2">
                                <img class="custom-checkbox-card-img"
                                    src="{{asset('assets\svg\layouts\layouts-sidebar-dark.svg')}}" alt="Image Description" />
                            </label>
                            <span class="custom-checkbox-card-text">Dark</span>
                        </div>
                    </div>
                </div>
                <!-- End Custom Radio -->

                <!-- Custom Radio -->
                <div class="col-4 text-center">
                    <div class="text-center">
                        <div class="custom-checkbox-card mb-2">
                            <input type="radio" class="custom-checkbox-card-input" name="layoutSkinsRadio"
                                id="layoutSkinsRadio3" value="navbar-light" />
                            <label class="custom-checkbox-card-label" for="layoutSkinsRadio3">
                                <img class="custom-checkbox-card-img"
                                    src="{{asset('assets\svg\layouts\layouts-sidebar-light.svg')}}" alt="Image Description" />
                            </label>
                            <span class="custom-checkbox-card-text">Light</span>
                        </div>
                    </div>
                </div>
                <!-- End Custom Radio -->
            </div>
            <!-- End Row -->

            <h4 class="mb-1">Sidebar layout options</h4>
            <p>
                Choose between standard navigation sizing, mini or even compact with
                icons.
            </p>

            <div class="row gx-2 mb-5">
                <!-- Custom Radio -->
                <div class="col-4 text-center">
                    <div class="text-center">
                        <div class="custom-checkbox-card mb-2">
                            <input type="radio" class="custom-checkbox-card-input" name="sidebarLayoutOptions"
                                id="sidebarLayoutOptions1" checked="" value="default" />
                            <label class="custom-checkbox-card-label" for="sidebarLayoutOptions1">
                                <img class="custom-checkbox-card-img"
                                    src="{{asset('assets\svg\layouts\sidebar-default-classic.svg')}}" alt="Image Description" />
                            </label>
                            <span class="custom-checkbox-card-text">Default</span>
                        </div>
                    </div>
                </div>
                <!-- End Custom Radio -->

                <!-- Custom Radio -->
                <div class="col-4 text-center">
                    <div class="text-center">
                        <div class="custom-checkbox-card mb-2">
                            <input type="radio" class="custom-checkbox-card-input" name="sidebarLayoutOptions"
                                id="sidebarLayoutOptions2" value="navbar-vertical-aside-compact-mode" />
                            <label class="custom-checkbox-card-label" for="sidebarLayoutOptions2">
                                <img class="custom-checkbox-card-img" src="{{asset('assets\svg\layouts\sidebar-compact.svg')}}"
                                    alt="Image Description" />
                            </label>
                            <span class="custom-checkbox-card-text">Compact</span>
                        </div>
                    </div>
                </div>
                <!-- End Custom Radio -->

                <!-- Custom Radio -->
                <div class="col-4 text-center">
                    <div class="text-center">
                        <div class="custom-checkbox-card mb-2">
                            <input type="radio" class="custom-checkbox-card-input" name="sidebarLayoutOptions"
                                id="sidebarLayoutOptions3" value="navbar-vertical-aside-mini-mode" />
                            <label class="custom-checkbox-card-label" for="sidebarLayoutOptions3">
                                <img class="custom-checkbox-card-img" src="{{asset('assets\svg\layouts\sidebar-mini.svg')}}"
                                    alt="Image Description" />
                            </label>
                            <span class="custom-checkbox-card-text">Mini</span>
                        </div>
                    </div>
                </div>
                <!-- End Custom Radio -->
            </div>
            <!-- End Row -->

            <h4 class="mb-1">Header layout options</h4>
            <p>Choose the primary navigation of your header layout.</p>

            <div class="row gx-2">
                <!-- Custom Radio -->
                <div class="col-4 text-center">
                    <div class="text-center">
                        <div class="custom-checkbox-card mb-2">
                            <input type="radio" class="custom-checkbox-card-input" name="headerLayoutOptions"
                                id="headerLayoutOptions1" value="single" />
                            <label class="custom-checkbox-card-label" for="headerLayoutOptions1">
                                <img class="custom-checkbox-card-img"
                                    src="{{asset('assets\svg\layouts\header-default-fluid.svg')}}" alt="Image Description" />
                            </label>
                            <span class="custom-checkbox-card-text">Default (Fluid)</span>
                        </div>
                    </div>
                </div>
                <!-- End Custom Radio -->

                <!-- Custom Radio -->
                <div class="col-4 text-center">
                    <div class="text-center">
                        <div class="custom-checkbox-card mb-2">
                            <input type="radio" class="custom-checkbox-card-input" name="headerLayoutOptions"
                                id="headerLayoutOptions2" value="single-container" />
                            <label class="custom-checkbox-card-label" for="headerLayoutOptions2">
                                <img class="custom-checkbox-card-img"
                                    src="{{asset('assets\svg\layouts\header-default-container.svg')}}"
                                    alt="Image Description" />
                            </label>
                            <span class="custom-checkbox-card-text">Default (Container)</span>
                        </div>
                    </div>
                </div>
                <!-- End Custom Radio -->

                <!-- Custom Radio -->
                <div class="col-4 text-center">
                    <div class="text-center">
                        <div class="custom-checkbox-card mb-2">
                            <input type="radio" class="custom-checkbox-card-input" name="headerLayoutOptions"
                                id="headerLayoutOptions3" value="double" />
                            <label class="custom-checkbox-card-label" for="headerLayoutOptions3">
                                <img class="custom-checkbox-card-img"
                                    src="{{asset('assets\svg\layouts\header-double-line-fluid.svg')}}"
                                    alt="Image Description" />
                            </label>
                            <span class="custom-checkbox-card-text">Double line (Fluid)</span>
                        </div>
                    </div>
                </div>
                <!-- End Custom Radio -->

                <!-- Custom Radio -->
                <div class="col-4 text-center mt-2">
                    <div class="text-center">
                        <div class="custom-checkbox-card mb-2">
                            <input type="radio" class="custom-checkbox-card-input" name="headerLayoutOptions"
                                id="headerLayoutOptions4" value="double-container" />
                            <label class="custom-checkbox-card-label" for="headerLayoutOptions4">
                                <img class="custom-checkbox-card-img"
                                    src="{{asset('assets\svg\layouts\header-double-line-container.svg')}}"
                                    alt="Image Description" />
                            </label>
                            <span class="custom-checkbox-card-text">Double line (Container)</span>
                        </div>
                    </div>
                </div>
                <!-- End Custom Radio -->
            </div>
            <!-- End Row -->
        </div>
        <!-- End Body -->

        <!-- Footer -->
        <div class="card-footer">
            <div class="row gx-2">
                <div class="col">
                    <button type="button" id="js-builder-reset" class="btn btn-block btn-lg btn-white">
                        <i class="tio-restore"></i> Reset
                    </button>
                </div>
                <div class="col">
                    <button type="button" id="js-builder-preview" class="btn btn-block btn-lg btn-primary">
                        <i class="tio-visible"></i> Preview
                    </button>
                </div>
            </div>
            <!-- End Row -->
        </div>
        <!-- End Footer -->
    </div>
</div>
<!-- End Builder -->

<!-- Builder Toggle -->
<div class="d-none d-md-block position-fixed bottom-0 right-0 mr-5 mb-10" style="z-index: 3">
    <div
        style="
      position: fixed;
      top: 50%;
      right: 0;
      margin-right: -0.25rem;
      transform: translateY(-50%);
      writing-mode: vertical-rl;
      text-orientation: sideways;
    ">
        <div class="hs-unfold">
            <a id="builderPopover" class="js-hs-unfold-invoker btn btn-sm btn-soft-dark py-3" href="javascript:;"
                data-template='<div class="d-none d-md-block popover" role="tooltip"><div class="arrow"></div><h3 class="popover-header"></h3><div class="popover-body"></div></div>'
                data-toggle="popover" data-placement="left"
                title="<div class='d-flex align-items-center'>Front Builder <a href='#!' class='close close-light ml-auto'><i id='closeBuilderPopover' class='tio-clear'></i></a></div>"
                data-content="Customize your overview page layout. Choose the one that best fits your needs."
                data-html="true"
                data-hs-unfold-options='{
            "target": "#styleSwitcherDropdown",
            "type": "css-animation",
            "animationIn": "fadeInRight",
            "animationOut": "fadeOutRight",
            "hasOverlay": true,
            "smartPositionOff": true
           }'>
                <i class="tio-tune mr-2"></i>
                <span class="font-weight-bold text-uppercase">Builder</span>
            </a>
        </div>
    </div>
</div>
<!-- End Builder Toggle -->

<!-- JS Preview mode only -->
<div id="headerMain" class="d-none">
    <header id="header"
        class="navbar navbar-expand-lg navbar-fixed navbar-height navbar-flush navbar-container navbar-bordered">
        <div class="navbar-nav-wrap">
            <div class="navbar-brand-wrapper">
                <!-- Logo -->
                <a class="navbar-brand" href="index.html" aria-label="Front">
                    <img class="navbar-brand-logo" src="{{asset('assets\svg\logos\logo.png')}}" alt="Logo" />
                    <img class="navbar-brand-logo-mini" src="{{asset('assets\svg\logos\logo-short.svg')}}" alt="Logo" />
                </a>
                <!-- End Logo -->
            </div>

            <div class="navbar-nav-wrap-content-left">
                <!-- Navbar Vertical Toggle -->
                <button type="button" class="js-navbar-vertical-aside-toggle-invoker close mr-3">
                    <i class="tio-first-page navbar-vertical-aside-toggle-short-align" data-toggle="tooltip"
                        data-placement="right" title="Collapse"></i>
                    <i class="tio-last-page navbar-vertical-aside-toggle-full-align"
                        data-template='<div class="tooltip d-none d-sm-block" role="tooltip"><div class="arrow"></div><div class="tooltip-inner"></div></div>'
                        data-toggle="tooltip" data-placement="right" title="Expand"></i>
                </button>
                <!-- End Navbar Vertical Toggle -->

                <!-- Search Form -->
                <div class="d-none d-md-block">
                    <form class="position-relative">
                        <!-- Input Group -->
                        <div
                            class="input-group input-group-merge input-group-borderless input-group-hover-light navbar-input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="tio-search"></i>
                                </div>
                            </div>
                            <input type="search" class="js-form-search form-control"
                                placeholder="Search in front" aria-label="Search in front"
                                data-hs-form-search-options='{
                 "clearIcon": "#clearSearchResultsIcon",
                 "dropMenuElement": "#searchDropdownMenu",
                 "dropMenuOffset": 20,
                 "toggleIconOnFocus": true,
                 "activeClass": "focus"
               }' />
                            <a class="input-group-append" href="javascript:;">
                                <span class="input-group-text">
                                    <i id="clearSearchResultsIcon" class="tio-clear" style="display: none"></i>
                                </span>
                            </a>
                        </div>
                        <!-- End Input Group -->

                        <!-- Card Search Content -->
                        <div id="searchDropdownMenu"
                            class="hs-form-search-menu-content card dropdown-menu dropdown-card overflow-hidden">
                            <!-- Body -->
                            <div class="card-body-height py-3">
                                <small class="dropdown-header mb-n2">Recent searches</small>

                                <div class="dropdown-item bg-transparent text-wrap my-2">
                                    <span class="h4 mr-1">
                                        <a class="btn btn-xs btn-soft-dark btn-pill" href="index.html">
                                            Gulp <i class="tio-search ml-1"></i>
                                        </a>
                                    </span>
                                    <span class="h4">
                                        <a class="btn btn-xs btn-soft-dark btn-pill" href="index.html">
                                            Notification panel <i class="tio-search ml-1"></i>
                                        </a>
                                    </span>
                                </div>

                                <div class="dropdown-divider my-3"></div>

                                <small class="dropdown-header mb-n2">Tutorials</small>

                                <a class="dropdown-item my-2" href="index.html">
                                    <div class="media align-items-center">
                                        <span class="icon icon-xs icon-soft-dark icon-circle mr-2">
                                            <i class="tio-tune"></i>
                                        </span>

                                        <div class="media-body text-truncate">
                                            <span>How to set up Gulp?</span>
                                        </div>
                                    </div>
                                </a>

                                <a class="dropdown-item my-2" href="index.html">
                                    <div class="media align-items-center">
                                        <span class="icon icon-xs icon-soft-dark icon-circle mr-2">
                                            <i class="tio-paint-bucket"></i>
                                        </span>

                                        <div class="media-body text-truncate">
                                            <span>How to change theme color?</span>
                                        </div>
                                    </div>
                                </a>

                                <div class="dropdown-divider my-3"></div>

                                <small class="dropdown-header mb-n2">Members</small>

                                <a class="dropdown-item my-2" href="index.html">
                                    <div class="media align-items-center">
                                        <img class="avatar avatar-xs avatar-circle mr-2"
                                            src="{{asset('assets\img\160x160\img10.jpg')}}" alt="Image Description" />
                                        <div class="media-body text-truncate">
                                            <span>Amanda Harvey
                                                <i class="tio-verified text-primary" data-toggle="tooltip"
                                                    data-placement="top" title="Top endorsed"></i></span>
                                        </div>
                                    </div>
                                </a>

                                <a class="dropdown-item my-2" href="index.html">
                                    <div class="media align-items-center">
                                        <img class="avatar avatar-xs avatar-circle mr-2"
                                            src="{{asset('assets\img\160x160\img3.jpg')}}" alt="Image Description" />
                                        <div class="media-body text-truncate">
                                            <span>David Harrison</span>
                                        </div>
                                    </div>
                                </a>

                                <a class="dropdown-item my-2" href="index.html">
                                    <div class="media align-items-center">
                                        <div class="avatar avatar-xs avatar-soft-info avatar-circle mr-2">
                                            <span class="avatar-initials">A</span>
                                        </div>
                                        <div class="media-body text-truncate">
                                            <span>Anne Richard</span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <!-- End Body -->

                            <!-- Footer -->
                            <a class="card-footer text-center" href="index.html">
                                See all results
                                <i class="tio-chevron-right"></i>
                            </a>
                            <!-- End Footer -->
                        </div>
                        <!-- End Card Search Content -->
                    </form>
                </div>
                <!-- End Search Form -->
            </div>

            <!-- Secondary Content -->
            <div class="navbar-nav-wrap-content-right">
                <!-- Navbar -->
                <ul class="navbar-nav align-items-center flex-row">
                    <li class="nav-item d-md-none">
                        <!-- Search Trigger -->
                        <div class="hs-unfold">
                            <a class="js-hs-unfold-invoker btn btn-icon btn-ghost-secondary rounded-circle"
                                href="javascript:;"
                                data-hs-unfold-options='{
                                    "target": "#searchDropdown",
                                    "type": "css-animation",
                                    "animationIn": "fadeIn",
                                    "hasOverlay": "rgba(46, 52, 81, 0.1)",
                                    "closeBreakpoint": "md"
                                }'>
                                <i class="tio-search"></i>
                            </a>
                        </div>
                        <!-- End Search Trigger -->
                    </li>

                    <li class="nav-item d-none d-sm-inline-block">
                        <!-- Notification -->
                        <div class="hs-unfold">
                            <a class="js-hs-unfold-invoker btn btn-icon btn-ghost-secondary rounded-circle"
                                href="javascript:;"
                                data-hs-unfold-options='{
                                        "target": "#notificationDropdown",
                                        "type": "css-animation"
                                    }'>
                                <i class="tio-notifications-on-outlined"></i>
                                <span class="btn-status btn-sm-status btn-status-danger"></span>
                            </a>

                            <div id="notificationDropdown"
                                class="hs-unfold-content dropdown-unfold dropdown-menu dropdown-menu-right navbar-dropdown-menu"
                                style="width: 25rem">
                                <!-- Header -->
                                <div class="card-header">
                                    <span class="card-title h4">Notifications</span>

                                    <!-- Unfold -->
                                    <div class="hs-unfold">
                                        <a class="js-hs-unfold-invoker btn btn-icon btn-sm btn-ghost-secondary rounded-circle"
                                            href="javascript:;"
                                            data-hs-unfold-options='{
                                            "target": "#notificationSettingsOneDropdown",
                                            "type": "css-animation"
                                            }'>
                                            <i class="tio-more-vertical"></i>
                                        </a>
                                        <div id="notificationSettingsOneDropdown"
                                            class="hs-unfold-content dropdown-unfold dropdown-menu dropdown-menu-right">
                                            <span class="dropdown-header">Settings</span>
                                            <a class="dropdown-item" href="#">
                                                <i class="tio-archive dropdown-item-icon"></i>
                                                Archive all
                                            </a>
                                            <a class="dropdown-item" href="#">
                                                <i class="tio-all-done dropdown-item-icon"></i> Mark
                                                all as read
                                            </a>
                                            <a class="dropdown-item" href="#">
                                                <i class="tio-toggle-off dropdown-item-icon"></i>
                                                Disable notifications
                                            </a>
                                            <a class="dropdown-item" href="#">
                                                <i class="tio-gift dropdown-item-icon"></i> What's
                                                new?
                                            </a>
                                            <div class="dropdown-divider"></div>
                                            <span class="dropdown-header">Feedback</span>
                                            <a class="dropdown-item" href="#">
                                                <i class="tio-chat-outlined dropdown-item-icon"></i>
                                                Report
                                            </a>
                                        </div>
                                    </div>
                                    <!-- End Unfold -->
                                </div>
                                <!-- End Header -->

                                <!-- Nav -->
                                <ul class="nav nav-tabs nav-justified" id="notificationTab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="notificationNavOne-tab" data-toggle="tab"
                                            href="#notificationNavOne" role="tab"
                                            aria-controls="notificationNavOne" aria-selected="true">Messages
                                            (3)</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="notificationNavTwo-tab" data-toggle="tab"
                                            href="#notificationNavTwo" role="tab"
                                            aria-controls="notificationNavTwo" aria-selected="false">Archived</a>
                                    </li>
                                </ul>
                                <!-- End Nav -->

                                <!-- Body -->
                                <div class="card-body-height">
                                    <!-- Tab Content -->
                                    <div class="tab-content" id="notificationTabContent">
                                        <div class="tab-pane fade show active" id="notificationNavOne"
                                            role="tabpanel" aria-labelledby="notificationNavOne-tab">
                                            <ul class="list-group list-group-flush navbar-card-list-group">
                                                <!-- Item -->
                                                <li class="list-group-item custom-checkbox-list-wrapper">
                                                    <div class="row">
                                                        <div class="col-auto position-static">
                                                            <div class="d-flex align-items-center">
                                                                <div
                                                                    class="custom-control custom-checkbox custom-checkbox-list">
                                                                    <input type="checkbox"
                                                                        class="custom-control-input"
                                                                        id="notificationCheck1" checked="" />
                                                                    <label class="custom-control-label"
                                                                        for="notificationCheck1"></label>
                                                                    <span
                                                                        class="custom-checkbox-list-stretched-bg"></span>
                                                                </div>
                                                                <div class="avatar avatar-sm avatar-circle">
                                                                    <img class="avatar-img"
                                                                        src="{{asset('assets\img\160x160\img3.jpg')}}"
                                                                        alt="Image Description" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col ml-n3">
                                                            <span class="card-title h5">Brian Warner</span>
                                                            <p class="card-text font-size-sm">
                                                                changed an issue from "In Progress" to
                                                                <span class="badge badge-success">Review</span>
                                                            </p>
                                                        </div>
                                                        <small class="col-auto text-muted text-cap">2hr</small>
                                                    </div>
                                                    <a class="stretched-link" href="#"></a>
                                                </li>
                                                <!-- End Item -->

                                                <!-- Item -->
                                                <li class="list-group-item custom-checkbox-list-wrapper">
                                                    <div class="row">
                                                        <div class="col-auto position-static">
                                                            <div class="d-flex align-items-center">
                                                                <div
                                                                    class="custom-control custom-checkbox custom-checkbox-list">
                                                                    <input type="checkbox"
                                                                        class="custom-control-input"
                                                                        id="notificationCheck2" checked="" />
                                                                    <label class="custom-control-label"
                                                                        for="notificationCheck2"></label>
                                                                    <span
                                                                        class="custom-checkbox-list-stretched-bg"></span>
                                                                </div>
                                                                <div
                                                                    class="avatar avatar-sm avatar-soft-dark avatar-circle">
                                                                    <span class="avatar-initials">K</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col ml-n3">
                                                            <span class="card-title h5">Klara Hampton</span>
                                                            <p class="card-text font-size-sm">
                                                                mentioned you in a comment
                                                            </p>
                                                            <blockquote class="blockquote blockquote-sm">
                                                                Nice work, love! You really nailed it. Keep
                                                                it up!
                                                            </blockquote>
                                                        </div>
                                                        <small class="col-auto text-muted text-cap">10hr</small>
                                                    </div>
                                                    <a class="stretched-link" href="#"></a>
                                                </li>
                                                <!-- End Item -->

                                                <!-- Item -->
                                                <li class="list-group-item custom-checkbox-list-wrapper">
                                                    <div class="row">
                                                        <div class="col-auto position-static">
                                                            <div class="d-flex align-items-center">
                                                                <div
                                                                    class="custom-control custom-checkbox custom-checkbox-list">
                                                                    <input type="checkbox"
                                                                        class="custom-control-input"
                                                                        id="notificationCheck4" checked="" />
                                                                    <label class="custom-control-label"
                                                                        for="notificationCheck4"></label>
                                                                    <span
                                                                        class="custom-checkbox-list-stretched-bg"></span>
                                                                </div>
                                                                <div class="avatar avatar-sm avatar-circle">
                                                                    <img class="avatar-img"
                                                                        src="{{asset('assets\img\160x160\img10.jpg')}}"
                                                                        alt="Image Description" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col ml-n3">
                                                            <span class="card-title h5">Ruby Walter</span>
                                                            <p class="card-text font-size-sm">
                                                                joined the Slack group HS Team
                                                            </p>
                                                        </div>
                                                        <small class="col-auto text-muted text-cap">3dy</small>
                                                    </div>
                                                    <a class="stretched-link" href="#"></a>
                                                </li>
                                                <!-- End Item -->

                                                <!-- Item -->
                                                <li class="list-group-item custom-checkbox-list-wrapper">
                                                    <div class="row">
                                                        <div class="col-auto position-static">
                                                            <div class="d-flex align-items-center">
                                                                <div
                                                                    class="custom-control custom-checkbox custom-checkbox-list">
                                                                    <input type="checkbox"
                                                                        class="custom-control-input"
                                                                        id="notificationCheck3" />
                                                                    <label class="custom-control-label"
                                                                        for="notificationCheck3"></label>
                                                                    <span
                                                                        class="custom-checkbox-list-stretched-bg"></span>
                                                                </div>
                                                                <div class="avatar avatar-sm avatar-circle">
                                                                    <img class="avatar-img"
                                                                        src="{{asset('assets\svg\brands\google.svg')}}"
                                                                        alt="Image Description" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col ml-n3">
                                                            <span class="card-title h5">from Google</span>
                                                            <p class="card-text font-size-sm">
                                                                Start using forms to capture the information
                                                                of prospects visiting your Google website
                                                            </p>
                                                        </div>
                                                        <small class="col-auto text-muted text-cap">17dy</small>
                                                    </div>
                                                    <a class="stretched-link" href="#"></a>
                                                </li>
                                                <!-- End Item -->

                                                <!-- Item -->
                                                <li class="list-group-item custom-checkbox-list-wrapper">
                                                    <div class="row">
                                                        <div class="col-auto position-static">
                                                            <div class="d-flex align-items-center">
                                                                <div
                                                                    class="custom-control custom-checkbox custom-checkbox-list">
                                                                    <input type="checkbox"
                                                                        class="custom-control-input"
                                                                        id="notificationCheck5" />
                                                                    <label class="custom-control-label"
                                                                        for="notificationCheck5"></label>
                                                                    <span
                                                                        class="custom-checkbox-list-stretched-bg"></span>
                                                                </div>
                                                                <div class="avatar avatar-sm avatar-circle">
                                                                    <img class="avatar-img"
                                                                        src="{{asset('assets\img\160x160\img7.jpg')}}"
                                                                        alt="Image Description" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col ml-n3">
                                                            <span class="card-title h5">Sara Villar</span>
                                                            <p class="card-text font-size-sm">
                                                                completed
                                                                <i class="tio-folder-bookmarked text-primary"></i>
                                                                FD-7 task
                                                            </p>
                                                        </div>
                                                        <small class="col-auto text-muted text-cap">2mn</small>
                                                    </div>
                                                    <a class="stretched-link" href="#"></a>
                                                </li>
                                                <!-- End Item -->
                                            </ul>
                                        </div>

                                        <div class="tab-pane fade" id="notificationNavTwo" role="tabpanel"
                                            aria-labelledby="notificationNavTwo-tab">
                                            <ul class="list-group list-group-flush navbar-card-list-group">
                                                <!-- Item -->
                                                <li class="list-group-item custom-checkbox-list-wrapper">
                                                    <div class="row">
                                                        <div class="col-auto position-static">
                                                            <div class="d-flex align-items-center">
                                                                <div
                                                                    class="custom-control custom-checkbox custom-checkbox-list">
                                                                    <input type="checkbox"
                                                                        class="custom-control-input"
                                                                        id="notificationCheck7" />
                                                                    <label class="custom-control-label"
                                                                        for="notificationCheck7"></label>
                                                                    <span
                                                                        class="custom-checkbox-list-stretched-bg"></span>
                                                                </div>
                                                                <div
                                                                    class="avatar avatar-sm avatar-soft-dark avatar-circle">
                                                                    <span class="avatar-initials">A</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col ml-n3">
                                                            <span class="card-title h5">Anne Richard</span>
                                                            <p class="card-text font-size-sm">
                                                                accepted your invitation to join Notion
                                                            </p>
                                                        </div>
                                                        <small class="col-auto text-muted text-cap">1dy</small>
                                                    </div>
                                                    <a class="stretched-link" href="#"></a>
                                                </li>
                                                <!-- End Item -->

                                                <!-- Item -->
                                                <li class="list-group-item custom-checkbox-list-wrapper">
                                                    <div class="row">
                                                        <div class="col-auto position-static">
                                                            <div class="d-flex align-items-center">
                                                                <div
                                                                    class="custom-control custom-checkbox custom-checkbox-list">
                                                                    <input type="checkbox"
                                                                        class="custom-control-input"
                                                                        id="notificationCheck6" />
                                                                    <label class="custom-control-label"
                                                                        for="notificationCheck6"></label>
                                                                    <span
                                                                        class="custom-checkbox-list-stretched-bg"></span>
                                                                </div>
                                                                <div class="avatar avatar-sm avatar-circle">
                                                                    <img class="avatar-img"
                                                                        src="{{asset('assets\img\160x160\img5.jpg')}}"
                                                                        alt="Image Description" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col ml-n3">
                                                            <span class="card-title h5">Finch Hoot</span>
                                                            <p class="card-text font-size-sm">
                                                                left Slack group HS projects
                                                            </p>
                                                        </div>
                                                        <small class="col-auto text-muted text-cap">3dy</small>
                                                    </div>
                                                    <a class="stretched-link" href="#"></a>
                                                </li>
                                                <!-- End Item -->

                                                <!-- Item -->
                                                <li class="list-group-item custom-checkbox-list-wrapper">
                                                    <div class="row">
                                                        <div class="col-auto position-static">
                                                            <div class="d-flex align-items-center">
                                                                <div
                                                                    class="custom-control custom-checkbox custom-checkbox-list">
                                                                    <input type="checkbox"
                                                                        class="custom-control-input"
                                                                        id="notificationCheck8" />
                                                                    <label class="custom-control-label"
                                                                        for="notificationCheck8"></label>
                                                                    <span
                                                                        class="custom-checkbox-list-stretched-bg"></span>
                                                                </div>
                                                                <div
                                                                    class="avatar avatar-sm avatar-dark avatar-circle">
                                                                    <span class="avatar-initials">HS</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col ml-n3">
                                                            <span class="card-title h5">Htmlstream</span>
                                                            <p class="card-text font-size-sm">
                                                                you earned a "Top endorsed"
                                                                <i class="tio-verified text-primary"></i>
                                                                badge
                                                            </p>
                                                        </div>
                                                        <small class="col-auto text-muted text-cap">6dy</small>
                                                    </div>
                                                    <a class="stretched-link" href="#"></a>
                                                </li>
                                                <!-- End Item -->

                                                <!-- Item -->
                                                <li class="list-group-item custom-checkbox-list-wrapper">
                                                    <div class="row">
                                                        <div class="col-auto position-static">
                                                            <div class="d-flex align-items-center">
                                                                <div
                                                                    class="custom-control custom-checkbox custom-checkbox-list">
                                                                    <input type="checkbox"
                                                                        class="custom-control-input"
                                                                        id="notificationCheck9" />
                                                                    <label class="custom-control-label"
                                                                        for="notificationCheck9"></label>
                                                                    <span
                                                                        class="custom-checkbox-list-stretched-bg"></span>
                                                                </div>
                                                                <div class="avatar avatar-sm avatar-circle">
                                                                    <img class="avatar-img"
                                                                        src="{{asset('assets\img\160x160\img8.jpg')}}"
                                                                        alt="Image Description" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col ml-n3">
                                                            <span class="card-title h5">Linda Bates</span>
                                                            <p class="card-text font-size-sm">
                                                                Accepted your connection
                                                            </p>
                                                        </div>
                                                        <small class="col-auto text-muted text-cap">17dy</small>
                                                    </div>
                                                    <a class="stretched-link" href="#"></a>
                                                </li>
                                                <!-- End Item -->

                                                <!-- Item -->
                                                <li class="list-group-item custom-checkbox-list-wrapper">
                                                    <div class="row">
                                                        <div class="col-auto position-static">
                                                            <div class="d-flex align-items-center">
                                                                <div
                                                                    class="custom-control custom-checkbox custom-checkbox-list">
                                                                    <input type="checkbox"
                                                                        class="custom-control-input"
                                                                        id="notificationCheck10" />
                                                                    <label class="custom-control-label"
                                                                        for="notificationCheck10"></label>
                                                                    <span
                                                                        class="custom-checkbox-list-stretched-bg"></span>
                                                                </div>
                                                                <div
                                                                    class="avatar avatar-sm avatar-soft-dark avatar-circle">
                                                                    <span class="avatar-initials">L</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col ml-n3">
                                                            <span class="card-title h5">Lewis Clarke</span>
                                                            <p class="card-text font-size-sm">
                                                                completed
                                                                <i class="tio-folder-bookmarked text-primary"></i>
                                                                FD-134 task
                                                            </p>
                                                        </div>
                                                        <small class="col-auto text-muted text-cap">2mn</small>
                                                    </div>
                                                    <a class="stretched-link" href="#"></a>
                                                </li>
                                                <!-- End Item -->
                                            </ul>
                                        </div>
                                    </div>
                                    <!-- End Tab Content -->
                                </div>
                                <!-- End Body -->

                                <!-- Card Footer -->
                                <a class="card-footer text-center" href="#">
                                    View all notifications
                                    <i class="tio-chevron-right"></i>
                                </a>
                                <!-- End Card Footer -->
                            </div>
                        </div>
                        <!-- End Notification -->
                    </li>

                    <li class="nav-item d-none d-sm-inline-block">
                        <!-- Apps -->
                        <div class="hs-unfold">
                            <a class="js-hs-unfold-invoker btn btn-icon btn-ghost-secondary rounded-circle"
                                href="javascript:;"
                                data-hs-unfold-options='{
                                    "target": "#appsDropdown",
                                    "type": "css-animation"
                                }'>
                                <i class="tio-menu-vs-outlined"></i>
                            </a>

                            <div id="appsDropdown"
                                class="hs-unfold-content dropdown-unfold dropdown-menu dropdown-menu-right navbar-dropdown-menu"
                                style="width: 25rem">
                                <!-- Header -->
                                <div class="card-header">
                                    <span class="card-title h4">Web apps &amp; services</span>
                                </div>
                                <!-- End Header -->

                                <!-- Body -->
                                <div class="card-body card-body-height">
                                    <!-- Nav -->
                                    <div class="nav nav-pills flex-column">
                                        <a class="nav-link" href="#">
                                            <div class="media align-items-center">
                                                <span class="mr-3">
                                                    <img class="avatar avatar-xs avatar-4by3"
                                                        src="{{asset('assets\svg\brands\atlassian.svg')}}"
                                                        alt="Image Description" />
                                                </span>
                                                <div class="media-body text-truncate">
                                                    <span class="h5 mb-0">Atlassian</span>
                                                    <span class="d-block font-size-sm text-body">Security and
                                                        control across Cloud</span>
                                                </div>
                                            </div>
                                        </a>

                                        <a class="nav-link" href="#">
                                            <div class="media align-items-center">
                                                <span class="mr-3">
                                                    <img class="avatar avatar-xs avatar-4by3"
                                                        src="{{asset('assets\svg\brands\slack.svg')}}"
                                                        alt="Image Description" />
                                                </span>
                                                <div class="media-body text-truncate">
                                                    <span class="h5 mb-0">Slack
                                                        <span
                                                            class="badge badge-primary badge-pill text-uppercase ml-1">Try</span></span>
                                                    <span class="d-block font-size-sm text-body">Email
                                                        collaboration software</span>
                                                </div>
                                            </div>
                                        </a>

                                        <a class="nav-link" href="#">
                                            <div class="media align-items-center">
                                                <span class="mr-3">
                                                    <img class="avatar avatar-xs avatar-4by3"
                                                        src="{{asset('assets\svg\brands\google-webdev.svg')}}"
                                                        alt="Image Description" />
                                                </span>
                                                <div class="media-body text-truncate">
                                                    <span class="h5 mb-0">Google webdev</span>
                                                    <span class="d-block font-size-sm text-body">Work involved in
                                                        developing a website</span>
                                                </div>
                                            </div>
                                        </a>

                                        <a class="nav-link" href="#">
                                            <div class="media align-items-center">
                                                <span class="mr-3">
                                                    <img class="avatar avatar-xs avatar-4by3"
                                                        src="{{asset('assets\svg\brands\frontapp.svg')}}"
                                                        alt="Image Description" />
                                                </span>
                                                <div class="media-body text-truncate">
                                                    <span class="h5 mb-0">Frontapp</span>
                                                    <span class="d-block font-size-sm text-body">The inbox for
                                                        teams</span>
                                                </div>
                                            </div>
                                        </a>

                                        <a class="nav-link" href="#">
                                            <div class="media align-items-center">
                                                <span class="mr-3">
                                                    <img class="avatar avatar-xs avatar-4by3"
                                                        src="{{asset('assets\svg\illustrations\review-rating-shield.svg')}}"
                                                        alt="Image Description" />
                                                </span>
                                                <div class="media-body text-truncate">
                                                    <span class="h5 mb-0">HS Support</span>
                                                    <span class="d-block font-size-sm text-body">Customer service
                                                        and support</span>
                                                </div>
                                            </div>
                                        </a>

                                        <a class="nav-link" href="#">
                                            <div class="media align-items-center">
                                                <span class="avatar avatar-xs avatar-soft-dark mr-3">
                                                    <span class="avatar-initials"><i class="tio-apps"></i></span>
                                                </span>
                                                <div class="media-body text-truncate">
                                                    <span class="h5 mb-0">More Front products</span>
                                                    <span class="d-block font-size-sm text-body">Check out more HS
                                                        products</span>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    <!-- End Nav -->
                                </div>
                                <!-- End Body -->

                                <!-- Footer -->
                                <a class="card-footer text-center" href="#">
                                    View all apps
                                    <i class="tio-chevron-right"></i>
                                </a>
                                <!-- End Footer -->
                            </div>
                        </div>
                        <!-- End Apps -->
                    </li>

                    <li class="nav-item d-none d-sm-inline-block">
                        <!-- Activity -->
                        <div class="hs-unfold">
                            <a class="js-hs-unfold-invoker btn btn-icon btn-ghost-secondary rounded-circle"
                                href="javascript:;"
                                data-hs-unfold-options='{
                                    "target": "#activitySidebar",
                                    "type": "css-animation",
                                    "animationIn": "fadeInRight",
                                    "animationOut": "fadeOutRight",
                                    "hasOverlay": true,
                                    "smartPositionOff": true
                                }'>
                                <i class="tio-voice-line"></i>
                            </a>
                        </div>
                        <!-- Activity -->
                    </li>

                    <li class="nav-item">
                        <!-- Account -->
                        <div class="hs-unfold">
                            <a class="js-hs-unfold-invoker navbar-dropdown-account-wrapper" href="javascript:;"
                                data-hs-unfold-options='{
                                    "target": "#accountNavbarDropdown",
                                    "type": "css-animation"
                                }'>
                                <div class="avatar avatar-sm avatar-circle">
                                    <img style="width:35px;height:35px" class="avatar-img" src="{{auth()->user()->avatar_url}}"
                                        alt="Image Description" />
                                    <span class="avatar-status avatar-sm-status avatar-status-success"></span>
                                </div>
                            </a>

                            <div id="accountNavbarDropdown"
                                class="hs-unfold-content dropdown-unfold dropdown-menu dropdown-menu-right navbar-dropdown-menu navbar-dropdown-account"
                                style="width: 16rem">
                                <div class="dropdown-item-text">
                                    <div class="media align-items-center d-flex flex-column">
                                        <div class="avatar avatar-sm avatar-circle mr-2">
                                            <img width="42px" height="42px" class="avatar-img" src="{{auth()->user()->avatar_url??asset('assets\img\160x160\img6.jpg')}}"
                                                alt="Image Description" />
                                        </div>
                                        <div class="media-body" style="flex: 1">
                                            <span class="card-title h5">{{auth()->user()->full_name}}</span>
                                            <span class="card-text">{{auth()->user()->email}}</span>
                                        </div>
                                    </div>
                                </div>

                                {{-- <div class="dropdown-divider"></div> --}}

                                {{-- <!-- Unfold -->
                                <div class="hs-unfold w-100">
                                    <a class="js-hs-unfold-invoker navbar-dropdown-submenu-item dropdown-item d-flex align-items-center"
                                        href="javascript:;"
                                        data-hs-unfold-options='{
                                                "target": "#navSubmenuPagesAccountDropdown1",
                                                "event": "hover"
                                            }'>
                                        <span class="text-truncate pr-2" title="Set status">Trạng thái</span>
                                        <i
                                            class="tio-chevron-right navbar-dropdown-submenu-item-invoker ml-auto"></i>
                                    </a>

                                    <div id="navSubmenuPagesAccountDropdown1"
                                        class="hs-unfold-content hs-unfold-has-submenu dropdown-unfold dropdown-menu navbar-dropdown-sub-menu">
                                        <a class="dropdown-item" href="#">
                                            <span class="legend-indicator bg-success mr-1"></span>
                                            <span class="text-truncate pr-2" title="Available">Available</span>
                                        </a>
                                        <a class="dropdown-item" href="#">
                                            <span class="legend-indicator bg-danger mr-1"></span>
                                            <span class="text-truncate pr-2" title="Busy">Busy</span>
                                        </a>
                                        <a class="dropdown-item" href="#">
                                            <span class="legend-indicator bg-warning mr-1"></span>
                                            <span class="text-truncate pr-2" title="Away">Away</span>
                                        </a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="#">
                                            <span class="text-truncate pr-2" title="Reset status">Reset
                                                status</span>
                                        </a>
                                    </div>
                                </div>
                                <!-- End Unfold -->

                                <a class="dropdown-item" href="{{route('user.info',["uuid"=>auth()->user()->uuid])}}">
                                    <span class="text-truncate pr-2" title="Profile &amp; account">Hồ sơ</span>
                                </a>

                                <a class="dropdown-item" href="#">
                                    <span class="text-truncate pr-2" title="Settings">Settings</span>
                                </a>

                                <div class="dropdown-divider"></div>

                                <a class="dropdown-item" href="#">
                                    <div class="media align-items-center">
                                        <div class="avatar avatar-sm avatar-dark avatar-circle mr-2">
                                            <span class="avatar-initials">HS</span>
                                        </div>
                                        <div class="media-body">
                                            <span class="card-title h5">Htmlstream
                                                <span
                                                    class="badge badge-primary badge-pill text-uppercase ml-1">PRO</span></span>
                                            <span class="card-text">hs.example.com</span>
                                        </div>
                                    </div>
                                </a>

                                <div class="dropdown-divider"></div>

                                <!-- Unfold -->
                                <div class="hs-unfold w-100">
                                    <a class="js-hs-unfold-invoker navbar-dropdown-submenu-item dropdown-item d-flex align-items-center"
                                        href="javascript:;"
                                        data-hs-unfold-options='{
                                                "target": "#navSubmenuPagesAccountDropdown2",
                                                "event": "hover"
                                            }'>
                                        <span class="text-truncate pr-2"
                                            title="Customization">Customization</span>
                                        <i
                                            class="tio-chevron-right navbar-dropdown-submenu-item-invoker ml-auto"></i>
                                    </a>

                                    <div id="navSubmenuPagesAccountDropdown2"
                                        class="hs-unfold-content hs-unfold-has-submenu dropdown-unfold dropdown-menu navbar-dropdown-sub-menu">
                                        <a class="dropdown-item" href="#">
                                            <span class="text-truncate pr-2" title="Invite people">Invite
                                                people</span>
                                        </a>
                                        <a class="dropdown-item" href="#">
                                            <span class="text-truncate pr-2" title="Analytics">Analytics</span>
                                            <i class="tio-open-in-new"></i>
                                        </a>
                                        <a class="dropdown-item" href="#">
                                            <span class="text-truncate pr-2" title="Customize Front">Customize
                                                Front</span>
                                            <i class="tio-open-in-new"></i>
                                        </a>
                                    </div>
                                </div>
                                <!-- End Unfold -->

                                <a class="dropdown-item" href="#">
                                    <span class="text-truncate pr-2" title="Manage team">Manage team</span>
                                </a> --}}

                                <div class="dropdown-divider"></div>

                                <a class="dropdown-item" href="{{route('auth.logout')}}">
                                    <span class="text-truncate pr-2" title="Sign out">Đăng xuất</span>
                                </a>
                            </div>
                        </div>
                        <!-- End Account -->
                    </li>
                </ul>
                <!-- End Navbar -->
            </div>
            <!-- End Secondary Content -->
        </div>
    </header>
</div>
<div id="headerFluid" class="d-none">
    <header id="header"
        class="navbar navbar-expand-xl navbar-fixed navbar-height navbar-flush navbar-container navbar-bordered">
        <div class="js-mega-menu navbar-nav-wrap">
            <div class="navbar-brand-wrapper">
                <!-- Logo -->

                <a class="navbar-brand" href="index.html" aria-label="Front">
                    <img class="navbar-brand-logo" src="{{asset('assets\svg\logos\logo.png')}}" alt="Logo" />
                </a>

                <!-- End Logo -->
            </div>

            <!-- Secondary Content -->
            <div class="navbar-nav-wrap-content-right">
                <!-- Navbar -->
                <ul class="navbar-nav align-items-center flex-row">
                    <li class="nav-item d-none d-sm-inline-block">
                        <!-- Notification -->
                        <div class="hs-unfold">
                            <a class="js-hs-unfold-invoker btn btn-icon btn-ghost-secondary rounded-circle"
                                href="javascript:;"
                                data-hs-unfold-options='{
             "target": "#notificationDropdown",
             "type": "css-animation"
           }'>
                                <i class="tio-notifications-on-outlined"></i>
                                <span class="btn-status btn-sm-status btn-status-danger"></span>
                            </a>

                            <div id="notificationDropdown"
                                class="hs-unfold-content dropdown-unfold dropdown-menu dropdown-menu-right navbar-dropdown-menu"
                                style="width: 25rem">
                                <!-- Header -->
                                <div class="card-header">
                                    <span class="card-title h4">Notifications</span>

                                    <!-- Unfold -->
                                    <div class="hs-unfold">
                                        <a class="js-hs-unfold-invoker btn btn-icon btn-sm btn-ghost-secondary rounded-circle"
                                            href="javascript:;"
                                            data-hs-unfold-options='{
                   "target": "#notificationSettingsOneDropdown",
                   "type": "css-animation"
                 }'>
                                            <i class="tio-more-vertical"></i>
                                        </a>
                                        <div id="notificationSettingsOneDropdown"
                                            class="hs-unfold-content dropdown-unfold dropdown-menu dropdown-menu-right">
                                            <span class="dropdown-header">Settings</span>
                                            <a class="dropdown-item" href="#">
                                                <i class="tio-archive dropdown-item-icon"></i>
                                                Archive all
                                            </a>
                                            <a class="dropdown-item" href="#">
                                                <i class="tio-all-done dropdown-item-icon"></i> Mark
                                                all as read
                                            </a>
                                            <a class="dropdown-item" href="#">
                                                <i class="tio-toggle-off dropdown-item-icon"></i>
                                                Disable notifications
                                            </a>
                                            <a class="dropdown-item" href="#">
                                                <i class="tio-gift dropdown-item-icon"></i> What's
                                                new?
                                            </a>
                                            <div class="dropdown-divider"></div>
                                            <span class="dropdown-header">Feedback</span>
                                            <a class="dropdown-item" href="#">
                                                <i class="tio-chat-outlined dropdown-item-icon"></i>
                                                Report
                                            </a>
                                        </div>
                                    </div>
                                    <!-- End Unfold -->
                                </div>
                                <!-- End Header -->

                                <!-- Nav -->
                                <ul class="nav nav-tabs nav-justified" id="notificationTab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="notificationNavOne-tab" data-toggle="tab"
                                            href="#notificationNavOne" role="tab"
                                            aria-controls="notificationNavOne" aria-selected="true">Messages
                                            (3)</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="notificationNavTwo-tab" data-toggle="tab"
                                            href="#notificationNavTwo" role="tab"
                                            aria-controls="notificationNavTwo" aria-selected="false">Archived</a>
                                    </li>
                                </ul>
                                <!-- End Nav -->

                                <!-- Body -->
                                <div class="card-body-height">
                                    <!-- Tab Content -->
                                    <div class="tab-content" id="notificationTabContent">
                                        <div class="tab-pane fade show active" id="notificationNavOne"
                                            role="tabpanel" aria-labelledby="notificationNavOne-tab">
                                            <ul class="list-group list-group-flush navbar-card-list-group">
                                                <!-- Item -->
                                                <li class="list-group-item custom-checkbox-list-wrapper">
                                                    <div class="row">
                                                        <div class="col-auto position-static">
                                                            <div class="d-flex align-items-center">
                                                                <div
                                                                    class="custom-control custom-checkbox custom-checkbox-list">
                                                                    <input type="checkbox"
                                                                        class="custom-control-input"
                                                                        id="notificationCheck1" checked="" />
                                                                    <label class="custom-control-label"
                                                                        for="notificationCheck1"></label>
                                                                    <span
                                                                        class="custom-checkbox-list-stretched-bg"></span>
                                                                </div>
                                                                <div class="avatar avatar-sm avatar-circle">
                                                                    <img class="avatar-img"
                                                                        src="{{asset('assets\img\160x160\img3.jpg')}}"
                                                                        alt="Image Description" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col ml-n3">
                                                            <span class="card-title h5">Brian Warner</span>
                                                            <p class="card-text font-size-sm">
                                                                changed an issue from "In Progress" to
                                                                <span class="badge badge-success">Review</span>
                                                            </p>
                                                        </div>
                                                        <small class="col-auto text-muted text-cap">2hr</small>
                                                    </div>
                                                    <a class="stretched-link" href="#"></a>
                                                </li>
                                                <!-- End Item -->

                                                <!-- Item -->
                                                <li class="list-group-item custom-checkbox-list-wrapper">
                                                    <div class="row">
                                                        <div class="col-auto position-static">
                                                            <div class="d-flex align-items-center">
                                                                <div
                                                                    class="custom-control custom-checkbox custom-checkbox-list">
                                                                    <input type="checkbox"
                                                                        class="custom-control-input"
                                                                        id="notificationCheck2" checked="" />
                                                                    <label class="custom-control-label"
                                                                        for="notificationCheck2"></label>
                                                                    <span
                                                                        class="custom-checkbox-list-stretched-bg"></span>
                                                                </div>
                                                                <div
                                                                    class="avatar avatar-sm avatar-soft-dark avatar-circle">
                                                                    <span class="avatar-initials">K</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col ml-n3">
                                                            <span class="card-title h5">Klara Hampton</span>
                                                            <p class="card-text font-size-sm">
                                                                mentioned you in a comment
                                                            </p>
                                                            <blockquote class="blockquote blockquote-sm">
                                                                Nice work, love! You really nailed it. Keep
                                                                it up!
                                                            </blockquote>
                                                        </div>
                                                        <small class="col-auto text-muted text-cap">10hr</small>
                                                    </div>
                                                    <a class="stretched-link" href="#"></a>
                                                </li>
                                                <!-- End Item -->

                                                <!-- Item -->
                                                <li class="list-group-item custom-checkbox-list-wrapper">
                                                    <div class="row">
                                                        <div class="col-auto position-static">
                                                            <div class="d-flex align-items-center">
                                                                <div
                                                                    class="custom-control custom-checkbox custom-checkbox-list">
                                                                    <input type="checkbox"
                                                                        class="custom-control-input"
                                                                        id="notificationCheck4" checked="" />
                                                                    <label class="custom-control-label"
                                                                        for="notificationCheck4"></label>
                                                                    <span
                                                                        class="custom-checkbox-list-stretched-bg"></span>
                                                                </div>
                                                                <div class="avatar avatar-sm avatar-circle">
                                                                    <img class="avatar-img"
                                                                        src="{{asset('assets\img\160x160\img10.jpg')}}"
                                                                        alt="Image Description" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col ml-n3">
                                                            <span class="card-title h5">Ruby Walter</span>
                                                            <p class="card-text font-size-sm">
                                                                joined the Slack group HS Team
                                                            </p>
                                                        </div>
                                                        <small class="col-auto text-muted text-cap">3dy</small>
                                                    </div>
                                                    <a class="stretched-link" href="#"></a>
                                                </li>
                                                <!-- End Item -->

                                                <!-- Item -->
                                                <li class="list-group-item custom-checkbox-list-wrapper">
                                                    <div class="row">
                                                        <div class="col-auto position-static">
                                                            <div class="d-flex align-items-center">
                                                                <div
                                                                    class="custom-control custom-checkbox custom-checkbox-list">
                                                                    <input type="checkbox"
                                                                        class="custom-control-input"
                                                                        id="notificationCheck3" />
                                                                    <label class="custom-control-label"
                                                                        for="notificationCheck3"></label>
                                                                    <span
                                                                        class="custom-checkbox-list-stretched-bg"></span>
                                                                </div>
                                                                <div class="avatar avatar-sm avatar-circle">
                                                                    <img class="avatar-img"
                                                                        src="{{asset('assets\svg\brands\google.svg')}}"
                                                                        alt="Image Description" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col ml-n3">
                                                            <span class="card-title h5">from Google</span>
                                                            <p class="card-text font-size-sm">
                                                                Start using forms to capture the information
                                                                of prospects visiting your Google website
                                                            </p>
                                                        </div>
                                                        <small class="col-auto text-muted text-cap">17dy</small>
                                                    </div>
                                                    <a class="stretched-link" href="#"></a>
                                                </li>
                                                <!-- End Item -->

                                                <!-- Item -->
                                                <li class="list-group-item custom-checkbox-list-wrapper">
                                                    <div class="row">
                                                        <div class="col-auto position-static">
                                                            <div class="d-flex align-items-center">
                                                                <div
                                                                    class="custom-control custom-checkbox custom-checkbox-list">
                                                                    <input type="checkbox"
                                                                        class="custom-control-input"
                                                                        id="notificationCheck5" />
                                                                    <label class="custom-control-label"
                                                                        for="notificationCheck5"></label>
                                                                    <span
                                                                        class="custom-checkbox-list-stretched-bg"></span>
                                                                </div>
                                                                <div class="avatar avatar-sm avatar-circle">
                                                                    <img class="avatar-img"
                                                                        src="{{asset('assets\img\160x160\img7.jpg')}}"
                                                                        alt="Image Description" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col ml-n3">
                                                            <span class="card-title h5">Sara Villar</span>
                                                            <p class="card-text font-size-sm">
                                                                completed
                                                                <i class="tio-folder-bookmarked text-primary"></i>
                                                                FD-7 task
                                                            </p>
                                                        </div>
                                                        <small class="col-auto text-muted text-cap">2mn</small>
                                                    </div>
                                                    <a class="stretched-link" href="#"></a>
                                                </li>
                                                <!-- End Item -->
                                            </ul>
                                        </div>

                                        <div class="tab-pane fade" id="notificationNavTwo" role="tabpanel"
                                            aria-labelledby="notificationNavTwo-tab">
                                            <ul class="list-group list-group-flush navbar-card-list-group">
                                                <!-- Item -->
                                                <li class="list-group-item custom-checkbox-list-wrapper">
                                                    <div class="row">
                                                        <div class="col-auto position-static">
                                                            <div class="d-flex align-items-center">
                                                                <div
                                                                    class="custom-control custom-checkbox custom-checkbox-list">
                                                                    <input type="checkbox"
                                                                        class="custom-control-input"
                                                                        id="notificationCheck7" />
                                                                    <label class="custom-control-label"
                                                                        for="notificationCheck7"></label>
                                                                    <span
                                                                        class="custom-checkbox-list-stretched-bg"></span>
                                                                </div>
                                                                <div
                                                                    class="avatar avatar-sm avatar-soft-dark avatar-circle">
                                                                    <span class="avatar-initials">A</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col ml-n3">
                                                            <span class="card-title h5">Anne Richard</span>
                                                            <p class="card-text font-size-sm">
                                                                accepted your invitation to join Notion
                                                            </p>
                                                        </div>
                                                        <small class="col-auto text-muted text-cap">1dy</small>
                                                    </div>
                                                    <a class="stretched-link" href="#"></a>
                                                </li>
                                                <!-- End Item -->

                                                <!-- Item -->
                                                <li class="list-group-item custom-checkbox-list-wrapper">
                                                    <div class="row">
                                                        <div class="col-auto position-static">
                                                            <div class="d-flex align-items-center">
                                                                <div
                                                                    class="custom-control custom-checkbox custom-checkbox-list">
                                                                    <input type="checkbox"
                                                                        class="custom-control-input"
                                                                        id="notificationCheck6" />
                                                                    <label class="custom-control-label"
                                                                        for="notificationCheck6"></label>
                                                                    <span
                                                                        class="custom-checkbox-list-stretched-bg"></span>
                                                                </div>
                                                                <div class="avatar avatar-sm avatar-circle">
                                                                    <img class="avatar-img"
                                                                        src="{{asset('assets\img\160x160\img5.jpg')}}"
                                                                        alt="Image Description" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col ml-n3">
                                                            <span class="card-title h5">Finch Hoot</span>
                                                            <p class="card-text font-size-sm">
                                                                left Slack group HS projects
                                                            </p>
                                                        </div>
                                                        <small class="col-auto text-muted text-cap">3dy</small>
                                                    </div>
                                                    <a class="stretched-link" href="#"></a>
                                                </li>
                                                <!-- End Item -->

                                                <!-- Item -->
                                                <li class="list-group-item custom-checkbox-list-wrapper">
                                                    <div class="row">
                                                        <div class="col-auto position-static">
                                                            <div class="d-flex align-items-center">
                                                                <div
                                                                    class="custom-control custom-checkbox custom-checkbox-list">
                                                                    <input type="checkbox"
                                                                        class="custom-control-input"
                                                                        id="notificationCheck8" />
                                                                    <label class="custom-control-label"
                                                                        for="notificationCheck8"></label>
                                                                    <span
                                                                        class="custom-checkbox-list-stretched-bg"></span>
                                                                </div>
                                                                <div
                                                                    class="avatar avatar-sm avatar-dark avatar-circle">
                                                                    <span class="avatar-initials">HS</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col ml-n3">
                                                            <span class="card-title h5">Htmlstream</span>
                                                            <p class="card-text font-size-sm">
                                                                you earned a "Top endorsed"
                                                                <i class="tio-verified text-primary"></i>
                                                                badge
                                                            </p>
                                                        </div>
                                                        <small class="col-auto text-muted text-cap">6dy</small>
                                                    </div>
                                                    <a class="stretched-link" href="#"></a>
                                                </li>
                                                <!-- End Item -->

                                                <!-- Item -->
                                                <li class="list-group-item custom-checkbox-list-wrapper">
                                                    <div class="row">
                                                        <div class="col-auto position-static">
                                                            <div class="d-flex align-items-center">
                                                                <div
                                                                    class="custom-control custom-checkbox custom-checkbox-list">
                                                                    <input type="checkbox"
                                                                        class="custom-control-input"
                                                                        id="notificationCheck9" />
                                                                    <label class="custom-control-label"
                                                                        for="notificationCheck9"></label>
                                                                    <span
                                                                        class="custom-checkbox-list-stretched-bg"></span>
                                                                </div>
                                                                <div class="avatar avatar-sm avatar-circle">
                                                                    <img class="avatar-img"
                                                                        src="{{asset('assets\img\160x160\img8.jpg')}}"
                                                                        alt="Image Description" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col ml-n3">
                                                            <span class="card-title h5">Linda Bates</span>
                                                            <p class="card-text font-size-sm">
                                                                Accepted your connection
                                                            </p>
                                                        </div>
                                                        <small class="col-auto text-muted text-cap">17dy</small>
                                                    </div>
                                                    <a class="stretched-link" href="#"></a>
                                                </li>
                                                <!-- End Item -->

                                                <!-- Item -->
                                                <li class="list-group-item custom-checkbox-list-wrapper">
                                                    <div class="row">
                                                        <div class="col-auto position-static">
                                                            <div class="d-flex align-items-center">
                                                                <div
                                                                    class="custom-control custom-checkbox custom-checkbox-list">
                                                                    <input type="checkbox"
                                                                        class="custom-control-input"
                                                                        id="notificationCheck10" />
                                                                    <label class="custom-control-label"
                                                                        for="notificationCheck10"></label>
                                                                    <span
                                                                        class="custom-checkbox-list-stretched-bg"></span>
                                                                </div>
                                                                <div
                                                                    class="avatar avatar-sm avatar-soft-dark avatar-circle">
                                                                    <span class="avatar-initials">L</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col ml-n3">
                                                            <span class="card-title h5">Lewis Clarke</span>
                                                            <p class="card-text font-size-sm">
                                                                completed
                                                                <i class="tio-folder-bookmarked text-primary"></i>
                                                                FD-134 task
                                                            </p>
                                                        </div>
                                                        <small class="col-auto text-muted text-cap">2mn</small>
                                                    </div>
                                                    <a class="stretched-link" href="#"></a>
                                                </li>
                                                <!-- End Item -->
                                            </ul>
                                        </div>
                                    </div>
                                    <!-- End Tab Content -->
                                </div>
                                <!-- End Body -->

                                <!-- Card Footer -->
                                <a class="card-footer text-center" href="#">
                                    View all notifications
                                    <i class="tio-chevron-right"></i>
                                </a>
                                <!-- End Card Footer -->
                            </div>
                        </div>
                        <!-- End Notification -->
                    </li>

                    <li class="nav-item d-none d-sm-inline-block">
                        <!-- Apps -->
                        <div class="hs-unfold">
                            <a class="js-hs-unfold-invoker btn btn-icon btn-ghost-secondary rounded-circle"
                                href="javascript:;"
                                data-hs-unfold-options='{
             "target": "#appsDropdown",
             "type": "css-animation"
           }'>
                                <i class="tio-menu-vs-outlined"></i>
                            </a>

                            <div id="appsDropdown"
                                class="hs-unfold-content dropdown-unfold dropdown-menu dropdown-menu-right navbar-dropdown-menu"
                                style="width: 25rem">
                                <!-- Header -->
                                <div class="card-header">
                                    <span class="card-title h4">Web apps &amp; services</span>
                                </div>
                                <!-- End Header -->

                                <!-- Body -->
                                <div class="card-body card-body-height">
                                    <!-- Nav -->
                                    <div class="nav nav-pills flex-column">
                                        <a class="nav-link" href="#">
                                            <div class="media align-items-center">
                                                <span class="mr-3">
                                                    <img class="avatar avatar-xs avatar-4by3"
                                                        src="{{asset('assets\svg\brands\atlassian.svg')}}"
                                                        alt="Image Description" />
                                                </span>
                                                <div class="media-body text-truncate">
                                                    <span class="h5 mb-0">Atlassian</span>
                                                    <span class="d-block font-size-sm text-body">Security and
                                                        control across Cloud</span>
                                                </div>
                                            </div>
                                        </a>

                                        <a class="nav-link" href="#">
                                            <div class="media align-items-center">
                                                <span class="mr-3">
                                                    <img class="avatar avatar-xs avatar-4by3"
                                                        src="{{asset('assets\svg\brands\slack.svg')}}"
                                                        alt="Image Description" />
                                                </span>
                                                <div class="media-body text-truncate">
                                                    <span class="h5 mb-0">Slack
                                                        <span
                                                            class="badge badge-primary badge-pill text-uppercase ml-1">Try</span></span>
                                                    <span class="d-block font-size-sm text-body">Email
                                                        collaboration software</span>
                                                </div>
                                            </div>
                                        </a>

                                        <a class="nav-link" href="#">
                                            <div class="media align-items-center">
                                                <span class="mr-3">
                                                    <img class="avatar avatar-xs avatar-4by3"
                                                        src="{{asset('assets\svg\brands\google-webdev.svg')}}"
                                                        alt="Image Description" />
                                                </span>
                                                <div class="media-body text-truncate">
                                                    <span class="h5 mb-0">Google webdev</span>
                                                    <span class="d-block font-size-sm text-body">Work involved in
                                                        developing a website</span>
                                                </div>
                                            </div>
                                        </a>

                                        <a class="nav-link" href="#">
                                            <div class="media align-items-center">
                                                <span class="mr-3">
                                                    <img class="avatar avatar-xs avatar-4by3"
                                                        src="{{asset('assets\svg\brands\frontapp.svg')}}"
                                                        alt="Image Description" />
                                                </span>
                                                <div class="media-body text-truncate">
                                                    <span class="h5 mb-0">Frontapp</span>
                                                    <span class="d-block font-size-sm text-body">The inbox for
                                                        teams</span>
                                                </div>
                                            </div>
                                        </a>

                                        <a class="nav-link" href="#">
                                            <div class="media align-items-center">
                                                <span class="mr-3">
                                                    <img class="avatar avatar-xs avatar-4by3"
                                                        src="{{asset('assets\svg\illustrations\review-rating-shield.svg')}}"
                                                        alt="Image Description" />
                                                </span>
                                                <div class="media-body text-truncate">
                                                    <span class="h5 mb-0">HS Support</span>
                                                    <span class="d-block font-size-sm text-body">Customer service
                                                        and support</span>
                                                </div>
                                            </div>
                                        </a>

                                        <a class="nav-link" href="#">
                                            <div class="media align-items-center">
                                                <span class="avatar avatar-xs avatar-soft-dark mr-3">
                                                    <span class="avatar-initials"><i
                                                            class="tio-apps"></i></span>
                                                </span>
                                                <div class="media-body text-truncate">
                                                    <span class="h5 mb-0">More Front products</span>
                                                    <span class="d-block font-size-sm text-body">Check out more HS
                                                        products</span>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    <!-- End Nav -->
                                </div>
                                <!-- End Body -->

                                <!-- Footer -->
                                <a class="card-footer text-center" href="#">
                                    View all apps
                                    <i class="tio-chevron-right"></i>
                                </a>
                                <!-- End Footer -->
                            </div>
                        </div>
                        <!-- End Apps -->
                    </li>

                    <li class="nav-item d-none d-sm-inline-block">
                        <!-- Activity -->
                        <div class="hs-unfold">
                            <a class="js-hs-unfold-invoker btn btn-icon btn-ghost-secondary rounded-circle"
                                href="javascript:;"
                                data-hs-unfold-options='{
            "target": "#activitySidebar",
            "type": "css-animation",
            "animationIn": "fadeInRight",
            "animationOut": "fadeOutRight",
            "hasOverlay": true,
            "smartPositionOff": true
           }'>
                                <i class="tio-voice-line"></i>
                            </a>
                        </div>
                        <!-- Activity -->
                    </li>

                    <li class="nav-item">
                        <!-- Account -->
                        <div class="hs-unfold">
                            <a class="js-hs-unfold-invoker navbar-dropdown-account-wrapper" href="javascript:;"
                                data-hs-unfold-options='{
             "target": "#accountNavbarDropdown",
             "type": "css-animation"
           }'>
                                <div class="avatar avatar-sm avatar-circle">
                                    <img class="avatar-img" src="{{asset('assets\img\160x160\img6.jpg')}}"
                                        alt="Image Description" />
                                    <span class="avatar-status avatar-sm-status avatar-status-success"></span>
                                </div>
                            </a>

                            <div id="accountNavbarDropdown"
                                class="hs-unfold-content dropdown-unfold dropdown-menu dropdown-menu-right navbar-dropdown-menu navbar-dropdown-account"
                                style="width: 16rem">
                                <div class="dropdown-item-text">
                                    <div class="media align-items-center">
                                        <div class="avatar avatar-sm avatar-circle mr-2">
                                            <img class="avatar-img" src="{{asset('assets\img\160x160\img6.jpg')}}"
                                                alt="Image Description" />
                                        </div>
                                        <div class="media-body">
                                            <span class="card-title h5">Mark Williams</span>
                                            <span class="card-text">mark@example.com</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="dropdown-divider"></div>

                                <!-- Unfold -->
                                <div class="hs-unfold w-100">
                                    <a class="js-hs-unfold-invoker navbar-dropdown-submenu-item dropdown-item d-flex align-items-center"
                                        href="javascript:;"
                                        data-hs-unfold-options='{
                 "target": "#navSubmenuPagesAccountDropdown1",
                 "event": "hover"
               }'>
                                        <span class="text-truncate pr-2" title="Set status">Set status</span>
                                        <i
                                            class="tio-chevron-right navbar-dropdown-submenu-item-invoker ml-auto"></i>
                                    </a>

                                    <div id="navSubmenuPagesAccountDropdown1"
                                        class="hs-unfold-content hs-unfold-has-submenu dropdown-unfold dropdown-menu navbar-dropdown-sub-menu">
                                        <a class="dropdown-item" href="#">
                                            <span class="legend-indicator bg-success mr-1"></span>
                                            <span class="text-truncate pr-2" title="Available">Available</span>
                                        </a>
                                        <a class="dropdown-item" href="#">
                                            <span class="legend-indicator bg-danger mr-1"></span>
                                            <span class="text-truncate pr-2" title="Busy">Busy</span>
                                        </a>
                                        <a class="dropdown-item" href="#">
                                            <span class="legend-indicator bg-warning mr-1"></span>
                                            <span class="text-truncate pr-2" title="Away">Away</span>
                                        </a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="#">
                                            <span class="text-truncate pr-2" title="Reset status">Reset
                                                status</span>
                                        </a>
                                    </div>
                                </div>
                                <!-- End Unfold -->

                                <a class="dropdown-item" href="#">
                                    <span class="text-truncate pr-2" title="Profile &amp; account">Profile &amp;
                                        account</span>
                                </a>

                                <a class="dropdown-item" href="#">
                                    <span class="text-truncate pr-2" title="Settings">Settings</span>
                                </a>

                                <div class="dropdown-divider"></div>

                                <a class="dropdown-item" href="#">
                                    <div class="media align-items-center">
                                        <div class="avatar avatar-sm avatar-dark avatar-circle mr-2">
                                            <span class="avatar-initials">HS</span>
                                        </div>
                                        <div class="media-body">
                                            <span class="card-title h5">Htmlstream
                                                <span
                                                    class="badge badge-primary badge-pill text-uppercase ml-1">PRO</span></span>
                                            <span class="card-text">hs.example.com</span>
                                        </div>
                                    </div>
                                </a>

                                <div class="dropdown-divider"></div>

                                <!-- Unfold -->
                                <div class="hs-unfold w-100">
                                    <a class="js-hs-unfold-invoker navbar-dropdown-submenu-item dropdown-item d-flex align-items-center"
                                        href="javascript:;"
                                        data-hs-unfold-options='{
                 "target": "#navSubmenuPagesAccountDropdown2",
                 "event": "hover"
               }'>
                                        <span class="text-truncate pr-2"
                                            title="Customization">Customization</span>
                                        <i
                                            class="tio-chevron-right navbar-dropdown-submenu-item-invoker ml-auto"></i>
                                    </a>

                                    <div id="navSubmenuPagesAccountDropdown2"
                                        class="hs-unfold-content hs-unfold-has-submenu dropdown-unfold dropdown-menu navbar-dropdown-sub-menu">
                                        <a class="dropdown-item" href="#">
                                            <span class="text-truncate pr-2" title="Invite people">Invite
                                                people</span>
                                        </a>
                                        <a class="dropdown-item" href="#">
                                            <span class="text-truncate pr-2" title="Analytics">Analytics</span>
                                            <i class="tio-open-in-new"></i>
                                        </a>
                                        <a class="dropdown-item" href="#">
                                            <span class="text-truncate pr-2" title="Customize Front">Customize
                                                Front</span>
                                            <i class="tio-open-in-new"></i>
                                        </a>
                                    </div>
                                </div>
                                <!-- End Unfold -->

                                <a class="dropdown-item" href="#">
                                    <span class="text-truncate pr-2" title="Manage team">Manage team</span>
                                </a>

                                <div class="dropdown-divider"></div>

                                <a class="dropdown-item" href="#">
                                    <span class="text-truncate pr-2" title="Sign out">Sign out</span>
                                </a>
                            </div>
                        </div>
                        <!-- End Account -->
                    </li>

                    <li class="nav-item">
                        <!-- Toggle -->
                        <button type="button" class="navbar-toggler btn btn-ghost-secondary rounded-circle"
                            aria-label="Toggle navigation" aria-expanded="false" aria-controls="navbarNavMenu"
                            data-toggle="collapse" data-target="#navbarNavMenu">
                            <i class="tio-menu-hamburger"></i>
                        </button>
                        <!-- End Toggle -->
                    </li>
                </ul>
                <!-- End Navbar -->
            </div>
            <!-- End Secondary Content -->

            <!-- Navbar -->
            <div class="navbar-nav-wrap-content-left collapse navbar-collapse" id="navbarNavMenu">
                <div class="navbar-body">
                    <ul class="navbar-nav flex-grow-1">
                        <!-- Dashboards -->
                        <li class="hs-has-sub-menu">
                            <a id="dashboardsDropdown"
                                class="hs-mega-menu-invoker navbar-nav-link nav-link nav-link-toggle"
                                href="javascript:;" aria-haspopup="true" aria-expanded="false"
                                aria-labelledby="navLinkDashboardsDropdown">
                                <i class="tio-home-vs-1-outlined nav-icon"></i> Dashboards
                            </a>

                            <!-- Dropdown -->
                            <ul id="navLinkDashboardsDropdown"
                                class="hs-sub-menu dropdown-menu dropdown-menu-lg"
                                aria-labelledby="dashboardsDropdown" style="min-width: 16rem">
                                <li>
                                    <a class="dropdown-item" href="index.html">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        Default
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="dashboard-alternative.html">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        Alternative
                                    </a>
                                </li>
                            </ul>
                            <!-- End Dropdown -->
                        </li>
                        <!-- End Dashboards -->

                        <!-- Pages -->
                        <li class="hs-has-sub-menu">
                            <a id="pagesDropdown"
                                class="hs-mega-menu-invoker navbar-nav-link nav-link nav-link-toggle"
                                href="javascript:;" aria-haspopup="true" aria-expanded="false"
                                aria-labelledby="navLinkPagesDropdown">
                                <i class="tio-pages-outlined nav-icon"></i> Pages
                            </a>

                            <!-- Dropdown -->
                            <ul id="navLinkPagesDropdown" class="hs-sub-menu dropdown-menu dropdown-menu-lg"
                                aria-labelledby="pagesDropdown" style="min-width: 16rem">
                                <!-- Users -->
                                <li class="hs-has-sub-menu">
                                    <a id="pagesDropdownUsers"
                                        class="hs-mega-menu-invoker dropdown-item dropdown-item-toggle"
                                        href="javascript:;" aria-haspopup="true" aria-expanded="false"
                                        aria-controls="navLinkPagesDropdownUsers">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        Users
                                    </a>

                                    <ul id="navLinkPagesDropdownUsers"
                                        class="hs-sub-menu dropdown-menu dropdown-menu-lg"
                                        aria-labelledby="pagesDropdownUsers" style="min-width: 16rem">
                                        <li>
                                            <a class="dropdown-item" href="users.html">
                                                <span class="tio-circle-outlined nav-indicator-icon"></span>
                                                Overview
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="users-leaderboard.html">
                                                <span class="tio-circle-outlined nav-indicator-icon"></span>
                                                Leaderboard
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="users-add-user.html">
                                                <span class="tio-circle-outlined nav-indicator-icon"></span>
                                                Add User
                                                <span class="badge badge-info badge-pill ml-1">Hot</span>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <!-- End Users -->

                                <!-- User Profile -->
                                <li class="hs-has-sub-menu">
                                    <a id="pagesDropdownUserProfile"
                                        class="hs-mega-menu-invoker dropdown-item dropdown-item-toggle"
                                        href="javascript:;" aria-haspopup="true" aria-expanded="false"
                                        aria-controls="navLinkPagesDropdownUserProfile">
                                        <span class="tio-circle nav-indicator-icon"></span> User
                                        Profile
                                        <span class="badge badge-primary badge-pill ml-2">5</span>
                                    </a>

                                    <ul id="navLinkPagesDropdownUserProfile"
                                        class="hs-sub-menu dropdown-menu dropdown-menu-lg"
                                        aria-labelledby="pagesDropdownUserProfile" style="min-width: 16rem">
                                        <li>
                                            <a class="dropdown-item" href="user-profile.html">
                                                <span class="tio-circle-outlined nav-indicator-icon"></span>
                                                Profile
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="user-profile-teams.html">
                                                <span class="tio-circle-outlined nav-indicator-icon"></span>
                                                Teams
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="user-profile-projects.html">
                                                <span class="tio-circle-outlined nav-indicator-icon"></span>
                                                Projects
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="user-profile-connections.html">
                                                <span class="tio-circle-outlined nav-indicator-icon"></span>
                                                Connections
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="user-profile-my-profile.html">
                                                <span class="tio-circle-outlined nav-indicator-icon"></span>
                                                My Profile
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <!-- End User Profile -->

                                <!-- Account -->
                                <li class="hs-has-sub-menu">
                                    <a id="pagesDropdownAccount"
                                        class="hs-mega-menu-invoker dropdown-item dropdown-item-toggle"
                                        href="javascript:;" aria-haspopup="true" aria-expanded="false"
                                        aria-controls="navLinkPagesDropdownAccount">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        Account
                                    </a>

                                    <ul id="navLinkPagesDropdownAccount"
                                        class="hs-sub-menu dropdown-menu dropdown-menu-lg"
                                        aria-labelledby="pagesDropdownAccount" style="min-width: 16rem">
                                        <li>
                                            <a class="dropdown-item" href="account-settings.html">
                                                <span class="tio-circle-outlined nav-indicator-icon"></span>
                                                Settings
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="account-billing.html">
                                                <span class="tio-circle-outlined nav-indicator-icon"></span>
                                                Billing
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="account-invoice.html">
                                                <span class="tio-circle-outlined nav-indicator-icon"></span>
                                                Invoice
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="account-api-keys.html">
                                                <span class="tio-circle-outlined nav-indicator-icon"></span>
                                                API Keys
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <!-- End Account -->

                                <!-- E-commerce -->
                                <li class="hs-has-sub-menu">
                                    <a id="pagesDropdownEcommerce"
                                        class="hs-mega-menu-invoker dropdown-item dropdown-item-toggle"
                                        href="javascript:;" aria-haspopup="true" aria-expanded="false"
                                        aria-controls="navLinkPagesDropdownEcommerce">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        E-commerce
                                    </a>

                                    <ul id="navLinkPagesDropdownEcommerce"
                                        class="hs-sub-menu dropdown-menu dropdown-menu-lg"
                                        aria-labelledby="pagesDropdownEcommerce" style="min-width: 16rem">
                                        <li>
                                            <a class="dropdown-item" href="ecommerce.html">
                                                <span class="tio-circle-outlined nav-indicator-icon"></span>
                                                Overview
                                            </a>
                                        </li>

                                        <li class="hs-has-sub-menu navbar-nav-item">
                                            <a id="pagesDropdownEcommerceSublevel"
                                                class="hs-mega-menu-invoker dropdown-item dropdown-item-toggle"
                                                href="javascript:;" aria-haspopup="true" aria-expanded="false"
                                                aria-controls="navLinkPagesDropdownEcommerceProducts">
                                                <span class="tio-circle nav-indicator-icon"></span>
                                                E-commerce
                                            </a>

                                            <ul id="navLinkPagesDropdownEcommerceProducts"
                                                class="hs-sub-menu dropdown-menu dropdown-menu-lg"
                                                aria-labelledby="pagesDropdownEcommerceSublevel"
                                                style="min-width: 16rem">
                                                <li>
                                                    <a class="dropdown-item" href="ecommerce-products.html">
                                                        <span
                                                            class="tio-circle-outlined nav-indicator-icon"></span>
                                                        Products
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item"
                                                        href="ecommerce-product-details.html">
                                                        <span
                                                            class="tio-circle-outlined nav-indicator-icon"></span>
                                                        Product Details
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="ecommerce-add-product.html">
                                                        <span class="tio-circle nav-indicator-icon"></span>
                                                        Add Product
                                                    </a>
                                                </li>
                                            </ul>
                                        </li>

                                        <li class="hs-has-sub-menu navbar-nav-item">
                                            <a id="pagesDropdownEcommerceSublevel"
                                                class="hs-mega-menu-invoker dropdown-item dropdown-item-toggle"
                                                href="javascript:;" aria-haspopup="true" aria-expanded="false"
                                                aria-controls="navLinkPagesDropdownEcommerceOrders">
                                                <span class="tio-circle nav-indicator-icon"></span>
                                                Orders
                                            </a>

                                            <ul id="navLinkPagesDropdownEcommerceOrders"
                                                class="hs-sub-menu dropdown-menu dropdown-menu-lg"
                                                aria-labelledby="pagesDropdownEcommerceSublevel"
                                                style="min-width: 16rem">
                                                <li>
                                                    <a class="dropdown-item" href="ecommerce-orders.html">
                                                        <span
                                                            class="tio-circle-outlined nav-indicator-icon"></span>
                                                        Orders
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item"
                                                        href="ecommerce-order-details.html">
                                                        <span
                                                            class="tio-circle-outlined nav-indicator-icon"></span>
                                                        Order Details
                                                    </a>
                                                </li>
                                            </ul>
                                        </li>

                                        <li class="hs-has-sub-menu navbar-nav-item">
                                            <a id="pagesDropdownEcommerceSublevel"
                                                class="hs-mega-menu-invoker dropdown-item dropdown-item-toggle"
                                                href="javascript:;" aria-haspopup="true" aria-expanded="false"
                                                aria-controls="navLinkPagesDropdownEcommerceCustomers">
                                                <span class="tio-circle nav-indicator-icon"></span>
                                                Customers
                                            </a>

                                            <ul id="navLinkPagesDropdownEcommerceCustomers"
                                                class="hs-sub-menu dropdown-menu dropdown-menu-lg"
                                                aria-labelledby="pagesDropdownEcommerceSublevel"
                                                style="min-width: 16rem">
                                                <li>
                                                    <a class="dropdown-item" href="ecommerce-customers.html">
                                                        <span
                                                            class="tio-circle-outlined nav-indicator-icon"></span>
                                                        Customers
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item"
                                                        href="ecommerce-customer-details.html">
                                                        <span
                                                            class="tio-circle-outlined nav-indicator-icon"></span>
                                                        Customer Details
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item"
                                                        href="ecommerce-add-customers.html">
                                                        <span
                                                            class="tio-circle-outlined nav-indicator-icon"></span>
                                                        Add Customers
                                                    </a>
                                                </li>
                                            </ul>
                                        </li>

                                        <li>
                                            <a class="dropdown-item" href="ecommerce-manage-reviews.html">
                                                <span class="tio-circle-outlined nav-indicator-icon"></span>
                                                Manage Reviews
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="ecommerce-checkout.html">
                                                <span class="tio-circle-outlined nav-indicator-icon"></span>
                                                Checkout
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <!-- End E-commerce -->

                                <!-- Projects -->
                                <li class="hs-has-sub-menu">
                                    <a id="pagesDropdownProjects"
                                        class="hs-mega-menu-invoker dropdown-item dropdown-item-toggle"
                                        href="javascript:;" aria-haspopup="true" aria-expanded="false"
                                        aria-controls="navLinkPagesDropdownProjects">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        Projects
                                    </a>

                                    <ul id="navLinkPagesDropdownProjects"
                                        class="hs-sub-menu dropdown-menu dropdown-menu-lg"
                                        aria-labelledby="pagesDropdownProjects" style="min-width: 16rem">
                                        <li>
                                            <a class="dropdown-item" href="projects.html">
                                                <span class="tio-circle-outlined nav-indicator-icon"></span>
                                                Overview
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="projects-timeline.html">
                                                <span class="tio-circle-outlined nav-indicator-icon"></span>
                                                Timeline
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <!-- End Projects -->

                                <!-- Project -->
                                <li class="hs-has-sub-menu">
                                    <a id="pagesDropdownProject"
                                        class="hs-mega-menu-invoker dropdown-item dropdown-item-toggle"
                                        href="javascript:;" aria-haspopup="true" aria-expanded="false"
                                        aria-controls="navLinkPagesDropdownProject">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        Project
                                    </a>

                                    <ul id="navLinkPagesDropdownProject"
                                        class="hs-sub-menu dropdown-menu dropdown-menu-lg"
                                        aria-labelledby="pagesDropdownProject" style="min-width: 16rem">
                                        <li>
                                            <a class="dropdown-item" href="project.html">
                                                <span class="tio-circle-outlined nav-indicator-icon"></span>
                                                Overview
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="project-files.html">
                                                <span class="tio-circle-outlined nav-indicator-icon"></span>
                                                Files
                                                <span class="badge badge-info badge-pill ml-1">Hot</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="project-activity.html">
                                                <span class="tio-circle-outlined nav-indicator-icon"></span>
                                                Activity
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="project-teams.html">
                                                <span class="tio-circle-outlined nav-indicator-icon"></span>
                                                Teams
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="project-settings.html">
                                                <span class="tio-circle-outlined nav-indicator-icon"></span>
                                                Settings
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <!-- End Project -->

                                <li>
                                    <a class="dropdown-item" href="referrals.html">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        Referrals
                                    </a>
                                </li>

                                <li class="dropdown-divider"></li>

                                <!-- Signin -->
                                <li class="hs-has-sub-menu">
                                    <a id="pagesDropdownSignin"
                                        class="hs-mega-menu-invoker dropdown-item dropdown-item-toggle"
                                        href="javascript:;" aria-haspopup="true" aria-expanded="false"
                                        aria-controls="navLinkPagesDropdownSignin">
                                        <span class="tio-circle nav-indicator-icon"></span> Sign
                                        In
                                    </a>

                                    <ul id="navLinkPagesDropdownSignin"
                                        class="hs-sub-menu dropdown-menu dropdown-menu-lg"
                                        aria-labelledby="pagesDropdownSignin" style="min-width: 16rem">
                                        <li>
                                            <a class="dropdown-item" href="authentication-signin-basic.html">
                                                <span class="tio-circle-outlined nav-indicator-icon"></span>
                                                Basic
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="authentication-signin-cover.html">
                                                <span class="tio-circle-outlined nav-indicator-icon"></span>
                                                Cover
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <!-- End Signin -->

                                <!-- Signup -->
                                <li class="hs-has-sub-menu">
                                    <a id="pagesDropdownSignup"
                                        class="hs-mega-menu-invoker dropdown-item dropdown-item-toggle"
                                        href="javascript:;" aria-haspopup="true" aria-expanded="false"
                                        aria-controls="navLinkPagesDropdownSignup">
                                        <span class="tio-circle nav-indicator-icon"></span> Sign
                                        Up
                                    </a>

                                    <ul id="navLinkPagesDropdownSignup"
                                        class="hs-sub-menu dropdown-menu dropdown-menu-lg"
                                        aria-labelledby="pagesDropdownSignup" style="min-width: 16rem">
                                        <li>
                                            <a class="dropdown-item" href="authentication-signup-basic.html">
                                                <span class="tio-circle-outlined nav-indicator-icon"></span>
                                                Basic
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="authentication-signup-cover.html">
                                                <span class="tio-circle-outlined nav-indicator-icon"></span>
                                                Cover
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <!-- End Signup -->

                                <!-- Reset Password -->
                                <li class="hs-has-sub-menu">
                                    <a id="pagesDropdownResetPassword"
                                        class="hs-mega-menu-invoker dropdown-item dropdown-item-toggle"
                                        href="javascript:;" aria-haspopup="true" aria-expanded="false"
                                        aria-controls="navLinkPagesDropdownResetPassword">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        Reset Password
                                    </a>

                                    <ul id="navLinkPagesDropdownResetPassword"
                                        class="hs-sub-menu dropdown-menu dropdown-menu-lg"
                                        aria-labelledby="pagesDropdownResetPassword" style="min-width: 16rem">
                                        <li>
                                            <a class="dropdown-item"
                                                href="authentication-reset-password-basic.html">
                                                <span class="tio-circle-outlined nav-indicator-icon"></span>
                                                Basic
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item"
                                                href="authentication-reset-password-cover.html">
                                                <span class="tio-circle-outlined nav-indicator-icon"></span>
                                                Cover
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <!-- End Reset Password -->

                                <!-- Email Verification -->
                                <li class="hs-has-sub-menu">
                                    <a id="pagesDropdownEmailVerification"
                                        class="hs-mega-menu-invoker dropdown-item dropdown-item-toggle"
                                        href="javascript:;" aria-haspopup="true" aria-expanded="false"
                                        aria-controls="navLinkPagesDropdownEmailVerification">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        Email Verification
                                    </a>

                                    <ul id="navLinkPagesDropdownEmailVerification"
                                        class="hs-sub-menu dropdown-menu dropdown-menu-lg"
                                        aria-labelledby="pagesDropdownEmailVerification"
                                        style="min-width: 16rem">
                                        <li>
                                            <a class="dropdown-item"
                                                href="authentication-email-verification-basic.html">
                                                <span class="tio-circle-outlined nav-indicator-icon"></span>
                                                Basic
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item"
                                                href="authentication-email-verification-cover.html">
                                                <span class="tio-circle-outlined nav-indicator-icon"></span>
                                                Cover
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <!-- End Email Verification -->

                                <!-- 2-step Verification -->
                                <li class="hs-has-sub-menu">
                                    <a id="pagesDropdown2StepVerification"
                                        class="hs-mega-menu-invoker dropdown-item dropdown-item-toggle"
                                        href="javascript:;" aria-haspopup="true" aria-expanded="false"
                                        aria-controls="navLinkPagesDropdown2StepVerification">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        2-step Verification
                                    </a>

                                    <ul id="navLinkPagesDropdown2StepVerification"
                                        class="hs-sub-menu dropdown-menu dropdown-menu-lg"
                                        aria-labelledby="pagesDropdown2StepVerification"
                                        style="min-width: 16rem">
                                        <li>
                                            <a class="dropdown-item"
                                                href="authentication-two-step-verification-basic.html">
                                                <span class="tio-circle-outlined nav-indicator-icon"></span>
                                                Basic
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item"
                                                href="authentication-two-step-verification-cover.html">
                                                <span class="tio-circle-outlined nav-indicator-icon"></span>
                                                Cover
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <!-- End 2-step Verification -->

                                <li class="dropdown-divider"></li>

                                <!-- Welcome Page -->
                                <li>
                                    <a class="dropdown-item" href="error-404.html">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        Error 404
                                    </a>
                                </li>
                                <!-- ENd Welcome Page -->

                                <!-- Welcome Page -->
                                <li>
                                    <a class="dropdown-item" href="error-500.html">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        Error 500
                                    </a>
                                </li>
                                <!-- ENd Welcome Page -->

                                <li class="dropdown-divider"></li>

                                <!-- Welcome Page -->
                                <li>
                                    <a class="dropdown-item" href="welcome-page.html">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        Welcome Page
                                    </a>
                                </li>
                                <!-- ENd Welcome Page -->
                            </ul>
                            <!-- End Dropdown -->
                        </li>
                        <!-- End Pages -->

                        <!-- Documentation -->
                        <li class="hs-has-sub-menu">
                            <a id="appsNavDropdown"
                                class="hs-mega-menu-invoker navbar-nav-link nav-link nav-link-toggle"
                                href="javascript:;" aria-haspopup="true" aria-expanded="false"
                                aria-labelledby="navLinkappsNavDropdown">
                                <i class="tio-apps nav-icon"></i> Apps
                            </a>

                            <!-- Dropdown -->
                            <ul id="navLinkappsNavDropdown" class="hs-sub-menu dropdown-menu dropdown-menu-lg"
                                aria-labelledby="appsNavDropdown" style="min-width: 16rem">
                                <li>
                                    <a class="dropdown-item" href="apps-kanban.html">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        Kanban
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="apps-calendar.html">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        Calendar
                                        <span class="badge badge-info badge-pill ml-1">New</span>
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="apps-invoice-generator.html">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        Invoice Generator
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="apps-file-manager.html">
                                        <span class="tio-circle nav-indicator-icon"></span> File
                                        Manager
                                    </a>
                                </li>
                            </ul>
                            <!-- End Dropdown -->
                        </li>
                        <!-- End Documentation -->

                        <!-- Layouts -->
                        <li>
                            <a class="navbar-nav-link nav-link" href="layouts\layouts.html">
                                <i class="tio-dashboard-vs-outlined nav-icon"></i> Layouts
                            </a>
                        </li>
                        <!-- End Layouts -->

                        <!-- Documentation -->
                        <li class="hs-has-sub-menu">
                            <a id="documentationDropdown"
                                class="hs-mega-menu-invoker navbar-nav-link nav-link nav-link-toggle"
                                href="javascript:;" aria-haspopup="true" aria-expanded="false"
                                aria-labelledby="navLinkDocumentationDropdown">
                                <i class="tio-book-opened nav-icon"></i> Docs
                            </a>

                            <!-- Dropdown -->
                            <ul id="navLinkDocumentationDropdown"
                                class="hs-sub-menu dropdown-menu dropdown-menu-lg"
                                aria-labelledby="documentationDropdown" style="min-width: 16rem">
                                <li>
                                    <a class="dropdown-item" href="documentation\index.html">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        Documentation
                                        <span class="badge badge-primary badge-pill ml-1">v1.0</span>
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="documentation\index.html">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        Components
                                    </a>
                                </li>
                            </ul>
                            <!-- End Dropdown -->
                        </li>
                        <!-- End Documentation -->
                    </ul>
                </div>
            </div>
            <!-- End Navbar -->
        </div>
    </header>
</div>
<div id="headerDouble" class="d-none">
    <header id="header" class="navbar navbar-expand-lg navbar-bordered flex-lg-column px-0">
        <div class="navbar-dark w-100">
            <div class="container-fluid">
                <div class="navbar-nav-wrap">
                    <div class="navbar-brand-wrapper">
                        <!-- Logo -->
                        <a class="navbar-brand" href="index.html" aria-label="Front">
                            <img class="navbar-brand-logo" src="{{asset('assets\svg\logos\logo-white.svg')}}"
                                alt="Logo" />
                        </a>
                        <!-- End Logo -->
                    </div>

                    <div class="navbar-nav-wrap-content-left">
                        <!-- Search Form -->
                        <div class="d-none d-lg-block">
                            <form class="position-relative">
                                <!-- Input Group -->
                                <div
                                    class="input-group input-group-merge input-group-borderless input-group-hover-light navbar-input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="tio-search"></i>
                                        </div>
                                    </div>
                                    <input type="search" class="js-form-search form-control"
                                        placeholder="Search in front" aria-label="Search in front"
                                        data-hs-form-search-options='{
                     "clearIcon": "#clearSearchResultsIcon",
                     "dropMenuElement": "#searchDropdownMenu",
                     "dropMenuOffset": 20,
                     "toggleIconOnFocus": true,
                     "activeClass": "focus"
                   }' />
                                    <a class="input-group-append" href="javascript:;">
                                        <span class="input-group-text">
                                            <i id="clearSearchResultsIcon" class="tio-clear"
                                                style="display: none"></i>
                                        </span>
                                    </a>
                                </div>
                                <!-- End Input Group -->

                                <!-- Card Search Content -->
                                <div id="searchDropdownMenu"
                                    class="hs-form-search-menu-content card dropdown-menu dropdown-card overflow-hidden">
                                    <!-- Body -->
                                    <div class="card-body-height py-3">
                                        <small class="dropdown-header mb-n2">Recent searches</small>

                                        <div class="dropdown-item bg-transparent text-wrap my-2">
                                            <span class="h4 mr-1">
                                                <a class="btn btn-xs btn-soft-dark btn-pill" href="index.html">
                                                    Gulp <i class="tio-search ml-1"></i>
                                                </a>
                                            </span>
                                            <span class="h4">
                                                <a class="btn btn-xs btn-soft-dark btn-pill" href="index.html">
                                                    Notification panel <i class="tio-search ml-1"></i>
                                                </a>
                                            </span>
                                        </div>

                                        <div class="dropdown-divider my-3"></div>

                                        <small class="dropdown-header mb-n2">Tutorials</small>

                                        <a class="dropdown-item my-2" href="index.html">
                                            <div class="media align-items-center">
                                                <span class="icon icon-xs icon-soft-dark icon-circle mr-2">
                                                    <i class="tio-tune"></i>
                                                </span>

                                                <div class="media-body text-truncate">
                                                    <span>How to set up Gulp?</span>
                                                </div>
                                            </div>
                                        </a>

                                        <a class="dropdown-item my-2" href="index.html">
                                            <div class="media align-items-center">
                                                <span class="icon icon-xs icon-soft-dark icon-circle mr-2">
                                                    <i class="tio-paint-bucket"></i>
                                                </span>

                                                <div class="media-body text-truncate">
                                                    <span>How to change theme color?</span>
                                                </div>
                                            </div>
                                        </a>

                                        <div class="dropdown-divider my-3"></div>

                                        <small class="dropdown-header mb-n2">Members</small>

                                        <a class="dropdown-item my-2" href="index.html">
                                            <div class="media align-items-center">
                                                <img class="avatar avatar-xs avatar-circle mr-2"
                                                    src="{{asset('assets\img\160x160\img10.jpg')}}"
                                                    alt="Image Description" />
                                                <div class="media-body text-truncate">
                                                    <span>Amanda Harvey
                                                        <i class="tio-verified text-primary"
                                                            data-toggle="tooltip" data-placement="top"
                                                            title="Top endorsed"></i></span>
                                                </div>
                                            </div>
                                        </a>

                                        <a class="dropdown-item my-2" href="index.html">
                                            <div class="media align-items-center">
                                                <img class="avatar avatar-xs avatar-circle mr-2"
                                                    src="{{asset('assets\img\160x160\img3.jpg')}}" alt="Image Description" />
                                                <div class="media-body text-truncate">
                                                    <span>David Harrison</span>
                                                </div>
                                            </div>
                                        </a>

                                        <a class="dropdown-item my-2" href="index.html">
                                            <div class="media align-items-center">
                                                <div class="avatar avatar-xs avatar-soft-info avatar-circle mr-2">
                                                    <span class="avatar-initials">A</span>
                                                </div>
                                                <div class="media-body text-truncate">
                                                    <span>Anne Richard</span>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    <!-- End Body -->

                                    <!-- Footer -->
                                    <a class="card-footer text-center" href="index.html">
                                        See all results
                                        <i class="tio-chevron-right"></i>
                                    </a>
                                    <!-- End Footer -->
                                </div>
                                <!-- End Card Search Content -->
                            </form>
                        </div>
                        <!-- End Search Form -->
                    </div>

                    <!-- Secondary Content -->
                    <div class="navbar-nav-wrap-content-right">
                        <!-- Navbar -->
                        <ul class="navbar-nav align-items-center flex-row">
                            <li class="nav-item d-lg-none">
                                <!-- Search Trigger -->
                                <div class="hs-unfold">
                                    <a class="js-hs-unfold-invoker btn btn-icon btn-ghost-light rounded-circle"
                                        href="javascript:;"
                                        data-hs-unfold-options='{
                 "target": "#searchDropdown",
                 "type": "css-animation",
                 "animationIn": "fadeIn",
                 "hasOverlay": "rgba(46, 52, 81, 0.1)",
                 "closeBreakpoint": "md"
               }'>
                                        <i class="tio-search"></i>
                                    </a>
                                </div>
                                <!-- End Search Trigger -->
                            </li>

                            <li class="nav-item d-none d-sm-inline-block">
                                <!-- Notification -->
                                <div class="hs-unfold">
                                    <a class="js-hs-unfold-invoker btn btn-icon btn-ghost-light rounded-circle"
                                        href="javascript:;"
                                        data-hs-unfold-options='{
                 "target": "#notificationNavbarDropdown",
                 "type": "css-animation"
               }'>
                                        <i class="tio-notifications-on-outlined"></i>
                                        <span class="btn-status btn-sm-status btn-status-danger"></span>
                                    </a>

                                    <div id="notificationNavbarDropdown"
                                        class="hs-unfold-content dropdown-unfold dropdown-menu dropdown-menu-right navbar-dropdown-menu"
                                        style="width: 25rem">
                                        <!-- Header -->
                                        <div class="card-header">
                                            <span class="card-title h4">Notifications</span>

                                            <!-- Unfold -->
                                            <div class="hs-unfold">
                                                <a class="js-hs-unfold-invoker btn btn-icon btn-sm btn-ghost-secondary rounded-circle"
                                                    href="javascript:;"
                                                    data-hs-unfold-options='{
                       "target": "#notificationSettingsOneDropdown",
                       "type": "css-animation"
                     }'>
                                                    <i class="tio-more-vertical"></i>
                                                </a>
                                                <div id="notificationSettingsOneDropdown"
                                                    class="hs-unfold-content dropdown-unfold dropdown-menu dropdown-menu-right">
                                                    <span class="dropdown-header">Settings</span>
                                                    <a class="dropdown-item" href="#">
                                                        <i class="tio-archive dropdown-item-icon"></i>
                                                        Archive all
                                                    </a>
                                                    <a class="dropdown-item" href="#">
                                                        <i class="tio-all-done dropdown-item-icon"></i>
                                                        Mark all as read
                                                    </a>
                                                    <a class="dropdown-item" href="#">
                                                        <i class="tio-toggle-off dropdown-item-icon"></i>
                                                        Disable notifications
                                                    </a>
                                                    <a class="dropdown-item" href="#">
                                                        <i class="tio-gift dropdown-item-icon"></i>
                                                        What's new?
                                                    </a>
                                                    <div class="dropdown-divider"></div>
                                                    <span class="dropdown-header">Feedback</span>
                                                    <a class="dropdown-item" href="#">
                                                        <i class="tio-chat-outlined dropdown-item-icon"></i>
                                                        Report
                                                    </a>
                                                </div>
                                            </div>
                                            <!-- End Unfold -->
                                        </div>
                                        <!-- End Header -->

                                        <!-- Nav -->
                                        <ul class="nav nav-tabs nav-justified" id="notificationTab"
                                            role="tablist">
                                            <li class="nav-item">
                                                <a class="nav-link active" id="notificationNavOne-tab"
                                                    data-toggle="tab" href="#notificationNavOne"
                                                    role="tab" aria-controls="notificationNavOne"
                                                    aria-selected="true">Messages (3)</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="notificationNavTwo-tab"
                                                    data-toggle="tab" href="#notificationNavTwo"
                                                    role="tab" aria-controls="notificationNavTwo"
                                                    aria-selected="false">Archived</a>
                                            </li>
                                        </ul>
                                        <!-- End Nav -->

                                        <!-- Body -->
                                        <div class="card-body-height">
                                            <!-- Tab Content -->
                                            <div class="tab-content" id="notificationTabContent">
                                                <div class="tab-pane fade show active" id="notificationNavOne"
                                                    role="tabpanel" aria-labelledby="notificationNavOne-tab">
                                                    <ul
                                                        class="list-group list-group-flush navbar-card-list-group">
                                                        <!-- Item -->
                                                        <li class="list-group-item custom-checkbox-list-wrapper">
                                                            <div class="row">
                                                                <div class="col-auto position-static">
                                                                    <div class="d-flex align-items-center">
                                                                        <div
                                                                            class="custom-control custom-checkbox custom-checkbox-list">
                                                                            <input type="checkbox"
                                                                                class="custom-control-input"
                                                                                id="notificationCheck1"
                                                                                checked="" />
                                                                            <label class="custom-control-label"
                                                                                for="notificationCheck1"></label>
                                                                            <span
                                                                                class="custom-checkbox-list-stretched-bg"></span>
                                                                        </div>
                                                                        <div
                                                                            class="avatar avatar-sm avatar-circle">
                                                                            <img class="avatar-img"
                                                                                src="{{asset('assets\img\160x160\img3.jpg')}}"
                                                                                alt="Image Description" />
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col ml-n3">
                                                                    <span class="card-title h5">Brian
                                                                        Warner</span>
                                                                    <p class="card-text font-size-sm">
                                                                        changed an issue from "In Progress" to
                                                                        <span
                                                                            class="badge badge-success">Review</span>
                                                                    </p>
                                                                </div>
                                                                <small
                                                                    class="col-auto text-muted text-cap">2hr</small>
                                                            </div>
                                                            <a class="stretched-link" href="#"></a>
                                                        </li>
                                                        <!-- End Item -->

                                                        <!-- Item -->
                                                        <li class="list-group-item custom-checkbox-list-wrapper">
                                                            <div class="row">
                                                                <div class="col-auto position-static">
                                                                    <div class="d-flex align-items-center">
                                                                        <div
                                                                            class="custom-control custom-checkbox custom-checkbox-list">
                                                                            <input type="checkbox"
                                                                                class="custom-control-input"
                                                                                id="notificationCheck2"
                                                                                checked="" />
                                                                            <label class="custom-control-label"
                                                                                for="notificationCheck2"></label>
                                                                            <span
                                                                                class="custom-checkbox-list-stretched-bg"></span>
                                                                        </div>
                                                                        <div
                                                                            class="avatar avatar-sm avatar-soft-dark avatar-circle">
                                                                            <span class="avatar-initials">K</span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col ml-n3">
                                                                    <span class="card-title h5">Klara
                                                                        Hampton</span>
                                                                    <p class="card-text font-size-sm">
                                                                        mentioned you in a comment
                                                                    </p>
                                                                    <blockquote class="blockquote blockquote-sm">
                                                                        Nice work, love! You really nailed it.
                                                                        Keep it up!
                                                                    </blockquote>
                                                                </div>
                                                                <small
                                                                    class="col-auto text-muted text-cap">10hr</small>
                                                            </div>
                                                            <a class="stretched-link" href="#"></a>
                                                        </li>
                                                        <!-- End Item -->

                                                        <!-- Item -->
                                                        <li class="list-group-item custom-checkbox-list-wrapper">
                                                            <div class="row">
                                                                <div class="col-auto position-static">
                                                                    <div class="d-flex align-items-center">
                                                                        <div
                                                                            class="custom-control custom-checkbox custom-checkbox-list">
                                                                            <input type="checkbox"
                                                                                class="custom-control-input"
                                                                                id="notificationCheck4"
                                                                                checked="" />
                                                                            <label class="custom-control-label"
                                                                                for="notificationCheck4"></label>
                                                                            <span
                                                                                class="custom-checkbox-list-stretched-bg"></span>
                                                                        </div>
                                                                        <div
                                                                            class="avatar avatar-sm avatar-circle">
                                                                            <img class="avatar-img"
                                                                                src="{{asset('assets\img\160x160\img10.jpg')}}"
                                                                                alt="Image Description" />
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col ml-n3">
                                                                    <span class="card-title h5">Ruby Walter</span>
                                                                    <p class="card-text font-size-sm">
                                                                        joined the Slack group HS Team
                                                                    </p>
                                                                </div>
                                                                <small
                                                                    class="col-auto text-muted text-cap">3dy</small>
                                                            </div>
                                                            <a class="stretched-link" href="#"></a>
                                                        </li>
                                                        <!-- End Item -->

                                                        <!-- Item -->
                                                        <li class="list-group-item custom-checkbox-list-wrapper">
                                                            <div class="row">
                                                                <div class="col-auto position-static">
                                                                    <div class="d-flex align-items-center">
                                                                        <div
                                                                            class="custom-control custom-checkbox custom-checkbox-list">
                                                                            <input type="checkbox"
                                                                                class="custom-control-input"
                                                                                id="notificationCheck3" />
                                                                            <label class="custom-control-label"
                                                                                for="notificationCheck3"></label>
                                                                            <span
                                                                                class="custom-checkbox-list-stretched-bg"></span>
                                                                        </div>
                                                                        <div
                                                                            class="avatar avatar-sm avatar-circle">
                                                                            <img class="avatar-img"
                                                                                src="{{asset('assets\svg\brands\google.svg')}}"
                                                                                alt="Image Description" />
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col ml-n3">
                                                                    <span class="card-title h5">from Google</span>
                                                                    <p class="card-text font-size-sm">
                                                                        Start using forms to capture the
                                                                        information of prospects visiting your
                                                                        Google website
                                                                    </p>
                                                                </div>
                                                                <small
                                                                    class="col-auto text-muted text-cap">17dy</small>
                                                            </div>
                                                            <a class="stretched-link" href="#"></a>
                                                        </li>
                                                        <!-- End Item -->

                                                        <!-- Item -->
                                                        <li class="list-group-item custom-checkbox-list-wrapper">
                                                            <div class="row">
                                                                <div class="col-auto position-static">
                                                                    <div class="d-flex align-items-center">
                                                                        <div
                                                                            class="custom-control custom-checkbox custom-checkbox-list">
                                                                            <input type="checkbox"
                                                                                class="custom-control-input"
                                                                                id="notificationCheck5" />
                                                                            <label class="custom-control-label"
                                                                                for="notificationCheck5"></label>
                                                                            <span
                                                                                class="custom-checkbox-list-stretched-bg"></span>
                                                                        </div>
                                                                        <div
                                                                            class="avatar avatar-sm avatar-circle">
                                                                            <img class="avatar-img"
                                                                                src="{{asset('assets\img\160x160\img7.jpg')}}"
                                                                                alt="Image Description" />
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col ml-n3">
                                                                    <span class="card-title h5">Sara Villar</span>
                                                                    <p class="card-text font-size-sm">
                                                                        completed
                                                                        <i
                                                                            class="tio-folder-bookmarked text-primary"></i>
                                                                        FD-7 task
                                                                    </p>
                                                                </div>
                                                                <small
                                                                    class="col-auto text-muted text-cap">2mn</small>
                                                            </div>
                                                            <a class="stretched-link" href="#"></a>
                                                        </li>
                                                        <!-- End Item -->
                                                    </ul>
                                                </div>

                                                <div class="tab-pane fade" id="notificationNavTwo"
                                                    role="tabpanel" aria-labelledby="notificationNavTwo-tab">
                                                    <ul
                                                        class="list-group list-group-flush navbar-card-list-group">
                                                        <!-- Item -->
                                                        <li class="list-group-item custom-checkbox-list-wrapper">
                                                            <div class="row">
                                                                <div class="col-auto position-static">
                                                                    <div class="d-flex align-items-center">
                                                                        <div
                                                                            class="custom-control custom-checkbox custom-checkbox-list">
                                                                            <input type="checkbox"
                                                                                class="custom-control-input"
                                                                                id="notificationCheck7" />
                                                                            <label class="custom-control-label"
                                                                                for="notificationCheck7"></label>
                                                                            <span
                                                                                class="custom-checkbox-list-stretched-bg"></span>
                                                                        </div>
                                                                        <div
                                                                            class="avatar avatar-sm avatar-soft-dark avatar-circle">
                                                                            <span class="avatar-initials">A</span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col ml-n3">
                                                                    <span class="card-title h5">Anne
                                                                        Richard</span>
                                                                    <p class="card-text font-size-sm">
                                                                        accepted your invitation to join Notion
                                                                    </p>
                                                                </div>
                                                                <small
                                                                    class="col-auto text-muted text-cap">1dy</small>
                                                            </div>
                                                            <a class="stretched-link" href="#"></a>
                                                        </li>
                                                        <!-- End Item -->

                                                        <!-- Item -->
                                                        <li class="list-group-item custom-checkbox-list-wrapper">
                                                            <div class="row">
                                                                <div class="col-auto position-static">
                                                                    <div class="d-flex align-items-center">
                                                                        <div
                                                                            class="custom-control custom-checkbox custom-checkbox-list">
                                                                            <input type="checkbox"
                                                                                class="custom-control-input"
                                                                                id="notificationCheck6" />
                                                                            <label class="custom-control-label"
                                                                                for="notificationCheck6"></label>
                                                                            <span
                                                                                class="custom-checkbox-list-stretched-bg"></span>
                                                                        </div>
                                                                        <div
                                                                            class="avatar avatar-sm avatar-circle">
                                                                            <img class="avatar-img"
                                                                                src="{{asset('assets\img\160x160\img5.jpg')}}"
                                                                                alt="Image Description" />
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col ml-n3">
                                                                    <span class="card-title h5">Finch Hoot</span>
                                                                    <p class="card-text font-size-sm">
                                                                        left Slack group HS projects
                                                                    </p>
                                                                </div>
                                                                <small
                                                                    class="col-auto text-muted text-cap">3dy</small>
                                                            </div>
                                                            <a class="stretched-link" href="#"></a>
                                                        </li>
                                                        <!-- End Item -->

                                                        <!-- Item -->
                                                        <li class="list-group-item custom-checkbox-list-wrapper">
                                                            <div class="row">
                                                                <div class="col-auto position-static">
                                                                    <div class="d-flex align-items-center">
                                                                        <div
                                                                            class="custom-control custom-checkbox custom-checkbox-list">
                                                                            <input type="checkbox"
                                                                                class="custom-control-input"
                                                                                id="notificationCheck8" />
                                                                            <label class="custom-control-label"
                                                                                for="notificationCheck8"></label>
                                                                            <span
                                                                                class="custom-checkbox-list-stretched-bg"></span>
                                                                        </div>
                                                                        <div
                                                                            class="avatar avatar-sm avatar-dark avatar-circle">
                                                                            <span
                                                                                class="avatar-initials">HS</span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col ml-n3">
                                                                    <span class="card-title h5">Htmlstream</span>
                                                                    <p class="card-text font-size-sm">
                                                                        you earned a "Top endorsed"
                                                                        <i class="tio-verified text-primary"></i>
                                                                        badge
                                                                    </p>
                                                                </div>
                                                                <small
                                                                    class="col-auto text-muted text-cap">6dy</small>
                                                            </div>
                                                            <a class="stretched-link" href="#"></a>
                                                        </li>
                                                        <!-- End Item -->

                                                        <!-- Item -->
                                                        <li class="list-group-item custom-checkbox-list-wrapper">
                                                            <div class="row">
                                                                <div class="col-auto position-static">
                                                                    <div class="d-flex align-items-center">
                                                                        <div
                                                                            class="custom-control custom-checkbox custom-checkbox-list">
                                                                            <input type="checkbox"
                                                                                class="custom-control-input"
                                                                                id="notificationCheck9" />
                                                                            <label class="custom-control-label"
                                                                                for="notificationCheck9"></label>
                                                                            <span
                                                                                class="custom-checkbox-list-stretched-bg"></span>
                                                                        </div>
                                                                        <div
                                                                            class="avatar avatar-sm avatar-circle">
                                                                            <img class="avatar-img"
                                                                                src="{{asset('assets\img\160x160\img8.jpg')}}"
                                                                                alt="Image Description" />
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col ml-n3">
                                                                    <span class="card-title h5">Linda Bates</span>
                                                                    <p class="card-text font-size-sm">
                                                                        Accepted your connection
                                                                    </p>
                                                                </div>
                                                                <small
                                                                    class="col-auto text-muted text-cap">17dy</small>
                                                            </div>
                                                            <a class="stretched-link" href="#"></a>
                                                        </li>
                                                        <!-- End Item -->

                                                        <!-- Item -->
                                                        <li class="list-group-item custom-checkbox-list-wrapper">
                                                            <div class="row">
                                                                <div class="col-auto position-static">
                                                                    <div class="d-flex align-items-center">
                                                                        <div
                                                                            class="custom-control custom-checkbox custom-checkbox-list">
                                                                            <input type="checkbox"
                                                                                class="custom-control-input"
                                                                                id="notificationCheck10" />
                                                                            <label class="custom-control-label"
                                                                                for="notificationCheck10"></label>
                                                                            <span
                                                                                class="custom-checkbox-list-stretched-bg"></span>
                                                                        </div>
                                                                        <div
                                                                            class="avatar avatar-sm avatar-soft-dark avatar-circle">
                                                                            <span class="avatar-initials">L</span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col ml-n3">
                                                                    <span class="card-title h5">Lewis
                                                                        Clarke</span>
                                                                    <p class="card-text font-size-sm">
                                                                        completed
                                                                        <i
                                                                            class="tio-folder-bookmarked text-primary"></i>
                                                                        FD-134 task
                                                                    </p>
                                                                </div>
                                                                <small
                                                                    class="col-auto text-muted text-cap">2mn</small>
                                                            </div>
                                                            <a class="stretched-link" href="#"></a>
                                                        </li>
                                                        <!-- End Item -->
                                                    </ul>
                                                </div>
                                            </div>
                                            <!-- End Tab Content -->
                                        </div>
                                        <!-- End Body -->

                                        <!-- Card Footer -->
                                        <a class="card-footer text-center" href="#">
                                            View all notifications
                                            <i class="tio-chevron-right"></i>
                                        </a>
                                        <!-- End Card Footer -->
                                    </div>
                                </div>
                                <!-- End Notification -->
                            </li>

                            <li class="nav-item d-none d-sm-inline-block">
                                <!-- Apps -->
                                <div class="hs-unfold">
                                    <a class="js-hs-unfold-invoker btn btn-icon btn-ghost-light rounded-circle"
                                        href="javascript:;"
                                        data-hs-unfold-options='{
                 "target": "#appsNavbarDropdown",
                 "type": "css-animation"
               }'>
                                        <i class="tio-menu-vs-outlined"></i>
                                    </a>

                                    <div id="appsNavbarDropdown"
                                        class="hs-unfold-content dropdown-unfold dropdown-menu dropdown-menu-right navbar-dropdown-menu"
                                        style="width: 25rem">
                                        <!-- Header -->
                                        <div class="card-header">
                                            <span class="card-title h4">Web apps &amp; services</span>
                                        </div>
                                        <!-- End Header -->

                                        <!-- Body -->
                                        <div class="card-body card-body-height">
                                            <!-- Nav -->
                                            <div class="nav nav-pills flex-column">
                                                <a class="nav-link" href="#">
                                                    <div class="media align-items-center">
                                                        <span class="mr-3">
                                                            <img class="avatar avatar-xs"
                                                                src="{{asset('assets\svg\brands\atlassian.svg')}}"
                                                                alt="Image Description" />
                                                        </span>
                                                        <div class="media-body text-truncate">
                                                            <span class="h5 mb-0">Atlassian</span>
                                                            <span class="d-block font-size-sm text-body">Security
                                                                and control across Cloud</span>
                                                        </div>
                                                    </div>
                                                </a>

                                                <a class="nav-link" href="#">
                                                    <div class="media align-items-center">
                                                        <span class="mr-3">
                                                            <img class="avatar avatar-xs"
                                                                src="{{asset('assets\svg\brands\slack.svg')}}"
                                                                alt="Image Description" />
                                                        </span>
                                                        <div class="media-body text-truncate">
                                                            <span class="h5 mb-0">Slack
                                                                <span
                                                                    class="badge badge-primary badge-pill text-uppercase ml-1">Try</span></span>
                                                            <span class="d-block font-size-sm text-body">Email
                                                                collaboration software</span>
                                                        </div>
                                                    </div>
                                                </a>

                                                <a class="nav-link" href="#">
                                                    <div class="media align-items-center">
                                                        <span class="mr-3">
                                                            <img class="avatar avatar-xs"
                                                                src="{{asset('assets\svg\brands\frontapp.svg')}}"
                                                                alt="Image Description" />
                                                        </span>
                                                        <div class="media-body text-truncate">
                                                            <span class="h5 mb-0">Frontapp</span>
                                                            <span class="d-block font-size-sm text-body">The inbox
                                                                for teams</span>
                                                        </div>
                                                    </div>
                                                </a>

                                                <a class="nav-link" href="#">
                                                    <div class="media align-items-center">
                                                        <span class="mr-3">
                                                            <img class="avatar avatar-xs"
                                                                src="{{asset('assets\svg\illustrations\review-rating-shield.svg')}}"
                                                                alt="Image Description" />
                                                        </span>
                                                        <div class="media-body text-truncate">
                                                            <span class="h5 mb-0">HS Support</span>
                                                            <span class="d-block font-size-sm text-body">Customer
                                                                service and support</span>
                                                        </div>
                                                    </div>
                                                </a>

                                                <a class="nav-link" href="#">
                                                    <div class="media align-items-center">
                                                        <span class="avatar avatar-xs avatar-soft-dark mr-3">
                                                            <span class="avatar-initials"><i
                                                                    class="tio-apps"></i></span>
                                                        </span>
                                                        <div class="media-body text-truncate">
                                                            <span class="h5 mb-0">More Front products</span>
                                                            <span class="d-block font-size-sm text-body">Check out
                                                                more HS products</span>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                            <!-- End Nav -->
                                        </div>
                                        <!-- End Body -->

                                        <!-- Footer -->
                                        <a class="card-footer text-center" href="#">
                                            View all apps
                                            <i class="tio-chevron-right"></i>
                                        </a>
                                        <!-- End Footer -->
                                    </div>
                                </div>
                                <!-- End Apps -->
                            </li>

                            <li class="nav-item d-none d-sm-inline-block">
                                <!-- Activity -->
                                <div class="hs-unfold">
                                    <a class="js-hs-unfold-invoker btn btn-icon btn-ghost-light rounded-circle"
                                        href="javascript:;"
                                        data-hs-unfold-options='{
                "target": "#activitySidebar",
                "type": "css-animation",
                "animationIn": "fadeInRight",
                "animationOut": "fadeOutRight",
                "hasOverlay": true,
                "smartPositionOff": true
               }'>
                                        <i class="tio-voice-line"></i>
                                    </a>
                                </div>
                                <!-- Activity -->
                            </li>

                            <li class="nav-item">
                                <!-- Account -->
                                <div class="hs-unfold">
                                    <a class="js-hs-unfold-invoker navbar-dropdown-account-wrapper"
                                        href="javascript:;"
                                        data-hs-unfold-options='{
                 "target": "#accountNavbarDropdown",
                 "type": "css-animation"
               }'>
                                        <div class="avatar avatar-sm avatar-circle">
                                            <img class="avatar-img" src="{{asset('assets\img\160x160\img6.jpg')}}"
                                                alt="Image Description" />
                                            <span
                                                class="avatar-status avatar-sm-status avatar-status-success"></span>
                                        </div>
                                    </a>

                                    <div id="accountNavbarDropdown"
                                        class="hs-unfold-content dropdown-unfold dropdown-menu dropdown-menu-right navbar-dropdown-menu navbar-dropdown-account"
                                        style="width: 16rem">
                                        <div class="dropdown-item-text">
                                            <div class="media align-items-center">
                                                <div class="avatar avatar-sm avatar-circle mr-2">
                                                    <img class="avatar-img" src="{{asset('assets\img\160x160\img6.jpg')}}"
                                                        alt="Image Description" />
                                                </div>
                                                <div class="media-body">
                                                    <span class="card-title h5">Mark Williams</span>
                                                    <span class="card-text">mark@example.com</span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="dropdown-divider"></div>

                                        <!-- Unfold -->
                                        <div class="hs-unfold w-100">
                                            <a class="js-hs-unfold-invoker navbar-dropdown-submenu-item dropdown-item d-flex align-items-center"
                                                href="javascript:;"
                                                data-hs-unfold-options='{
                     "target": "#navSubmenuPagesAccountDropdown1",
                     "event": "hover"
                   }'>
                                                <span class="text-truncate pr-2" title="Set status">Set
                                                    status</span>
                                                <i
                                                    class="tio-chevron-right navbar-dropdown-submenu-item-invoker ml-auto"></i>
                                            </a>

                                            <div id="navSubmenuPagesAccountDropdown1"
                                                class="hs-unfold-content hs-unfold-has-submenu dropdown-unfold dropdown-menu navbar-dropdown-sub-menu">
                                                <a class="dropdown-item" href="#">
                                                    <span class="legend-indicator bg-success mr-1"></span>
                                                    <span class="text-truncate pr-2"
                                                        title="Available">Available</span>
                                                </a>
                                                <a class="dropdown-item" href="#">
                                                    <span class="legend-indicator bg-danger mr-1"></span>
                                                    <span class="text-truncate pr-2" title="Busy">Busy</span>
                                                </a>
                                                <a class="dropdown-item" href="#">
                                                    <span class="legend-indicator bg-warning mr-1"></span>
                                                    <span class="text-truncate pr-2" title="Away">Away</span>
                                                </a>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item" href="#">
                                                    <span class="text-truncate pr-2" title="Reset status">Reset
                                                        status</span>
                                                </a>
                                            </div>
                                        </div>
                                        <!-- End Unfold -->

                                        <a class="dropdown-item" href="#">
                                            <span class="text-truncate pr-2"
                                                title="Profile &amp; account">Profile &amp; account</span>
                                        </a>

                                        <a class="dropdown-item" href="#">
                                            <span class="text-truncate pr-2" title="Settings">Settings</span>
                                        </a>

                                        <div class="dropdown-divider"></div>

                                        <a class="dropdown-item" href="#">
                                            <div class="media align-items-center">
                                                <div class="avatar avatar-sm avatar-dark avatar-circle mr-2">
                                                    <span class="avatar-initials">HS</span>
                                                </div>
                                                <div class="media-body">
                                                    <span class="card-title h5">Htmlstream
                                                        <span
                                                            class="badge badge-primary badge-pill text-uppercase ml-1">PRO</span></span>
                                                    <span class="card-text">hs.example.com</span>
                                                </div>
                                            </div>
                                        </a>

                                        <div class="dropdown-divider"></div>

                                        <!-- Unfold -->
                                        <div class="hs-unfold w-100">
                                            <a class="js-hs-unfold-invoker navbar-dropdown-submenu-item dropdown-item d-flex align-items-center"
                                                href="javascript:;"
                                                data-hs-unfold-options='{
                     "target": "#navSubmenuPagesAccountDropdown2",
                     "event": "hover"
                   }'>
                                                <span class="text-truncate pr-2"
                                                    title="Customization">Customization</span>
                                                <i
                                                    class="tio-chevron-right navbar-dropdown-submenu-item-invoker ml-auto"></i>
                                            </a>

                                            <div id="navSubmenuPagesAccountDropdown2"
                                                class="hs-unfold-content hs-unfold-has-submenu dropdown-unfold dropdown-menu navbar-dropdown-sub-menu">
                                                <a class="dropdown-item" href="#">
                                                    <span class="text-truncate pr-2"
                                                        title="Invite people">Invite people</span>
                                                </a>
                                                <a class="dropdown-item" href="#">
                                                    <span class="text-truncate pr-2"
                                                        title="Analytics">Analytics</span>
                                                    <i class="tio-open-in-new"></i>
                                                </a>
                                                <a class="dropdown-item" href="#">
                                                    <span class="text-truncate pr-2"
                                                        title="Customize Front">Customize Front</span>
                                                    <i class="tio-open-in-new"></i>
                                                </a>
                                            </div>
                                        </div>
                                        <!-- End Unfold -->

                                        <a class="dropdown-item" href="#">
                                            <span class="text-truncate pr-2" title="Manage team">Manage
                                                team</span>
                                        </a>

                                        <div class="dropdown-divider"></div>

                                        <a class="dropdown-item" href="#">
                                            <span class="text-truncate pr-2" title="Sign out">Sign out</span>
                                        </a>
                                    </div>
                                </div>
                                <!-- End Account -->
                            </li>

                            <li class="nav-item">
                                <!-- Toggle -->
                                <button type="button" class="navbar-toggler btn btn-ghost-light rounded-circle"
                                    aria-label="Toggle navigation" aria-expanded="false"
                                    aria-controls="navbarNavMenu" data-toggle="collapse"
                                    data-target="#navbarNavMenu">
                                    <i class="tio-menu-hamburger"></i>
                                </button>
                                <!-- End Toggle -->
                            </li>
                        </ul>
                        <!-- End Navbar -->
                    </div>
                    <!-- End Secondary Content -->
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <nav class="js-mega-menu flex-grow-1">
                <!-- Navbar -->
                <div class="navbar-nav-wrap-navbar collapse navbar-collapse" id="navbarNavMenu">
                    <div class="navbar-body">
                        <ul class="navbar-nav flex-grow-1">
                            <!-- Dashboards -->
                            <li class="hs-has-sub-menu navbar-nav-item">
                                <a id="dashboardsDropdown"
                                    class="hs-mega-menu-invoker navbar-nav-link nav-link nav-link-toggle"
                                    href="javascript:;" aria-haspopup="true" aria-expanded="false"
                                    aria-labelledby="navLinkDashboardsDropdown">
                                    <i class="tio-home-vs-1-outlined nav-icon"></i> Dashboards
                                </a>

                                <!-- Dropdown -->
                                <ul id="navLinkDashboardsDropdown"
                                    class="hs-sub-menu dropdown-menu dropdown-menu-lg"
                                    aria-labelledby="dashboardsDropdown" style="min-width: 16rem">
                                    <li>
                                        <a class="dropdown-item" href="index.html">
                                            <span class="tio-circle nav-indicator-icon"></span>
                                            Default
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="dashboard-alternative.html">
                                            <span class="tio-circle nav-indicator-icon"></span>
                                            Alternative
                                        </a>
                                    </li>
                                </ul>
                                <!-- End Dropdown -->
                            </li>
                            <!-- End Dashboards -->

                            <!-- Pages -->
                            <li class="hs-has-sub-menu navbar-nav-item">
                                <a id="pagesDropdown"
                                    class="hs-mega-menu-invoker navbar-nav-link nav-link nav-link-toggle"
                                    href="javascript:;" aria-haspopup="true" aria-expanded="false"
                                    aria-labelledby="navLinkPagesDropdown">
                                    <i class="tio-pages-outlined nav-icon"></i> Pages
                                </a>

                                <!-- Dropdown -->
                                <ul id="navLinkPagesDropdown" class="hs-sub-menu dropdown-menu dropdown-menu-lg"
                                    aria-labelledby="pagesDropdown" style="min-width: 16rem">
                                    <!-- Users -->
                                    <li class="hs-has-sub-menu navbar-nav-item">
                                        <a id="pagesDropdownUsers"
                                            class="hs-mega-menu-invoker dropdown-item dropdown-item-toggle"
                                            href="javascript:;" aria-haspopup="true" aria-expanded="false"
                                            aria-controls="navLinkPagesDropdownUsers">
                                            <span class="tio-circle nav-indicator-icon"></span>
                                            Users
                                        </a>

                                        <ul id="navLinkPagesDropdownUsers"
                                            class="hs-sub-menu dropdown-menu dropdown-menu-lg"
                                            aria-labelledby="pagesDropdownUsers" style="min-width: 16rem">
                                            <li>
                                                <a class="dropdown-item" href="users.html">
                                                    <span class="tio-circle-outlined nav-indicator-icon"></span>
                                                    Overview
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="users-leaderboard.html">
                                                    <span class="tio-circle-outlined nav-indicator-icon"></span>
                                                    Leaderboard
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="users-add-user.html">
                                                    <span class="tio-circle-outlined nav-indicator-icon"></span>
                                                    Add User
                                                    <span class="badge badge-info badge-pill ml-1">Hot</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                    <!-- End Users -->

                                    <!-- User Profile -->
                                    <li class="hs-has-sub-menu navbar-nav-item">
                                        <a id="pagesDropdownUserProfile"
                                            class="hs-mega-menu-invoker dropdown-item dropdown-item-toggle"
                                            href="javascript:;" aria-haspopup="true" aria-expanded="false"
                                            aria-controls="navLinkPagesDropdownUserProfile">
                                            <span class="tio-circle nav-indicator-icon"></span>
                                            User Profile
                                            <span class="badge badge-primary badge-pill ml-2">5</span>
                                        </a>

                                        <ul id="navLinkPagesDropdownUserProfile"
                                            class="hs-sub-menu dropdown-menu dropdown-menu-lg"
                                            aria-labelledby="pagesDropdownUserProfile" style="min-width: 16rem">
                                            <li>
                                                <a class="dropdown-item" href="user-profile.html">
                                                    <span class="tio-circle-outlined nav-indicator-icon"></span>
                                                    Profile
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="user-profile-teams.html">
                                                    <span class="tio-circle-outlined nav-indicator-icon"></span>
                                                    Teams
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="user-profile-projects.html">
                                                    <span class="tio-circle-outlined nav-indicator-icon"></span>
                                                    Projects
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="user-profile-connections.html">
                                                    <span class="tio-circle-outlined nav-indicator-icon"></span>
                                                    Connections
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="user-profile-my-profile.html">
                                                    <span class="tio-circle-outlined nav-indicator-icon"></span>
                                                    My Profile
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                    <!-- End User Profile -->

                                    <!-- Account -->
                                    <li class="hs-has-sub-menu navbar-nav-item">
                                        <a id="pagesDropdownAccount"
                                            class="hs-mega-menu-invoker dropdown-item dropdown-item-toggle"
                                            href="javascript:;" aria-haspopup="true" aria-expanded="false"
                                            aria-controls="navLinkPagesDropdownAccount">
                                            <span class="tio-circle nav-indicator-icon"></span>
                                            Account
                                        </a>

                                        <ul id="navLinkPagesDropdownAccount"
                                            class="hs-sub-menu dropdown-menu dropdown-menu-lg"
                                            aria-labelledby="pagesDropdownAccount" style="min-width: 16rem">
                                            <li>
                                                <a class="dropdown-item" href="account-settings.html">
                                                    <span class="tio-circle-outlined nav-indicator-icon"></span>
                                                    Settings
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="account-billing.html">
                                                    <span class="tio-circle-outlined nav-indicator-icon"></span>
                                                    Billing
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="account-invoice.html">
                                                    <span class="tio-circle-outlined nav-indicator-icon"></span>
                                                    Invoice
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="account-api-keys.html">
                                                    <span class="tio-circle-outlined nav-indicator-icon"></span>
                                                    API Keys
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                    <!-- End Account -->

                                    <!-- E-commerce -->
                                    <li class="hs-has-sub-menu navbar-nav-item">
                                        <a id="pagesDropdownEcommerce"
                                            class="hs-mega-menu-invoker dropdown-item dropdown-item-toggle"
                                            href="javascript:;" aria-haspopup="true" aria-expanded="false"
                                            aria-controls="navLinkPagesDropdownEcommerce">
                                            <span class="tio-circle nav-indicator-icon"></span>
                                            E-commerce
                                        </a>

                                        <ul id="navLinkPagesDropdownEcommerce"
                                            class="hs-sub-menu dropdown-menu dropdown-menu-lg"
                                            aria-labelledby="pagesDropdownEcommerce" style="min-width: 16rem">
                                            <li>
                                                <a class="dropdown-item" href="ecommerce.html">
                                                    <span class="tio-circle-outlined nav-indicator-icon"></span>
                                                    Overview
                                                </a>
                                            </li>

                                            <li class="hs-has-sub-menu navbar-nav-item">
                                                <a id="pagesDropdownEcommerceSublevel"
                                                    class="hs-mega-menu-invoker dropdown-item dropdown-item-toggle"
                                                    href="javascript:;" aria-haspopup="true"
                                                    aria-expanded="false"
                                                    aria-controls="navLinkPagesDropdownEcommerceProducts">
                                                    <span class="tio-circle nav-indicator-icon"></span>
                                                    E-commerce
                                                </a>

                                                <ul id="navLinkPagesDropdownEcommerceProducts"
                                                    class="hs-sub-menu dropdown-menu dropdown-menu-lg"
                                                    aria-labelledby="pagesDropdownEcommerceSublevel"
                                                    style="min-width: 16rem">
                                                    <li>
                                                        <a class="dropdown-item" href="ecommerce-products.html">
                                                            <span
                                                                class="tio-circle-outlined nav-indicator-icon"></span>
                                                            Products
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item"
                                                            href="ecommerce-product-details.html">
                                                            <span
                                                                class="tio-circle-outlined nav-indicator-icon"></span>
                                                            Product Details
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item"
                                                            href="ecommerce-add-product.html">
                                                            <span class="tio-circle nav-indicator-icon"></span>
                                                            Add Product
                                                        </a>
                                                    </li>
                                                </ul>
                                            </li>

                                            <li class="hs-has-sub-menu navbar-nav-item">
                                                <a id="pagesDropdownEcommerceSublevel"
                                                    class="hs-mega-menu-invoker dropdown-item dropdown-item-toggle"
                                                    href="javascript:;" aria-haspopup="true"
                                                    aria-expanded="false"
                                                    aria-controls="navLinkPagesDropdownEcommerceOrders">
                                                    <span class="tio-circle nav-indicator-icon"></span>
                                                    Orders
                                                </a>

                                                <ul id="navLinkPagesDropdownEcommerceOrders"
                                                    class="hs-sub-menu dropdown-menu dropdown-menu-lg"
                                                    aria-labelledby="pagesDropdownEcommerceSublevel"
                                                    style="min-width: 16rem">
                                                    <li>
                                                        <a class="dropdown-item" href="ecommerce-orders.html">
                                                            <span
                                                                class="tio-circle-outlined nav-indicator-icon"></span>
                                                            Orders
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item"
                                                            href="ecommerce-order-details.html">
                                                            <span
                                                                class="tio-circle-outlined nav-indicator-icon"></span>
                                                            Order Details
                                                        </a>
                                                    </li>
                                                </ul>
                                            </li>

                                            <li class="hs-has-sub-menu navbar-nav-item">
                                                <a id="pagesDropdownEcommerceSublevel"
                                                    class="hs-mega-menu-invoker dropdown-item dropdown-item-toggle"
                                                    href="javascript:;" aria-haspopup="true"
                                                    aria-expanded="false"
                                                    aria-controls="navLinkPagesDropdownEcommerceCustomers">
                                                    <span class="tio-circle nav-indicator-icon"></span>
                                                    Customers
                                                </a>

                                                <ul id="navLinkPagesDropdownEcommerceCustomers"
                                                    class="hs-sub-menu dropdown-menu dropdown-menu-lg"
                                                    aria-labelledby="pagesDropdownEcommerceSublevel"
                                                    style="min-width: 16rem">
                                                    <li>
                                                        <a class="dropdown-item"
                                                            href="ecommerce-customers.html">
                                                            <span
                                                                class="tio-circle-outlined nav-indicator-icon"></span>
                                                            Customers
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item"
                                                            href="ecommerce-customer-details.html">
                                                            <span
                                                                class="tio-circle-outlined nav-indicator-icon"></span>
                                                            Customer Details
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item"
                                                            href="ecommerce-add-customers.html">
                                                            <span
                                                                class="tio-circle-outlined nav-indicator-icon"></span>
                                                            Add Customers
                                                        </a>
                                                    </li>
                                                </ul>
                                            </li>

                                            <li>
                                                <a class="dropdown-item" href="ecommerce-manage-reviews.html">
                                                    <span class="tio-circle-outlined nav-indicator-icon"></span>
                                                    Manage Reviews
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="ecommerce-checkout.html">
                                                    <span class="tio-circle-outlined nav-indicator-icon"></span>
                                                    Checkout
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                    <!-- End E-commerce -->

                                    <!-- Projects -->
                                    <li class="hs-has-sub-menu navbar-nav-item">
                                        <a id="pagesDropdownProjects"
                                            class="hs-mega-menu-invoker dropdown-item dropdown-item-toggle"
                                            href="javascript:;" aria-haspopup="true" aria-expanded="false"
                                            aria-controls="navLinkPagesDropdownProjects">
                                            <span class="tio-circle nav-indicator-icon"></span>
                                            Projects
                                        </a>

                                        <ul id="navLinkPagesDropdownProjects"
                                            class="hs-sub-menu dropdown-menu dropdown-menu-lg"
                                            aria-labelledby="pagesDropdownProjects" style="min-width: 16rem">
                                            <li>
                                                <a class="dropdown-item" href="projects.html">
                                                    <span class="tio-circle-outlined nav-indicator-icon"></span>
                                                    Overview
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="projects-timeline.html">
                                                    <span class="tio-circle-outlined nav-indicator-icon"></span>
                                                    Timeline
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                    <!-- End Projects -->

                                    <!-- Project -->
                                    <li class="hs-has-sub-menu navbar-nav-item">
                                        <a id="pagesDropdownProject"
                                            class="hs-mega-menu-invoker dropdown-item dropdown-item-toggle"
                                            href="javascript:;" aria-haspopup="true" aria-expanded="false"
                                            aria-controls="navLinkPagesDropdownProject">
                                            <span class="tio-circle nav-indicator-icon"></span>
                                            Project
                                        </a>

                                        <ul id="navLinkPagesDropdownProject"
                                            class="hs-sub-menu dropdown-menu dropdown-menu-lg"
                                            aria-labelledby="pagesDropdownProject" style="min-width: 16rem">
                                            <li>
                                                <a class="dropdown-item" href="project.html">
                                                    <span class="tio-circle-outlined nav-indicator-icon"></span>
                                                    Overview
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="project-files.html">
                                                    <span class="tio-circle-outlined nav-indicator-icon"></span>
                                                    Files
                                                    <span class="badge badge-info badge-pill ml-1">Hot</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="project-activity.html">
                                                    <span class="tio-circle-outlined nav-indicator-icon"></span>
                                                    Activity
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="project-teams.html">
                                                    <span class="tio-circle-outlined nav-indicator-icon"></span>
                                                    Teams
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="project-settings.html">
                                                    <span class="tio-circle-outlined nav-indicator-icon"></span>
                                                    Settings
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                    <!-- End Project -->

                                    <li class="navbar-nav-item">
                                        <a class="dropdown-item" href="referrals.html">
                                            <span class="tio-circle nav-indicator-icon"></span>
                                            Referrals
                                        </a>
                                    </li>

                                    <li class="dropdown-divider"></li>

                                    <!-- Signin -->
                                    <li class="hs-has-sub-menu navbar-nav-item">
                                        <a id="pagesDropdownSignin"
                                            class="hs-mega-menu-invoker dropdown-item dropdown-item-toggle"
                                            href="javascript:;" aria-haspopup="true" aria-expanded="false"
                                            aria-controls="navLinkPagesDropdownSignin">
                                            <span class="tio-circle nav-indicator-icon"></span>
                                            Sign In
                                        </a>

                                        <ul id="navLinkPagesDropdownSignin"
                                            class="hs-sub-menu dropdown-menu dropdown-menu-lg"
                                            aria-labelledby="pagesDropdownSignin" style="min-width: 16rem">
                                            <li>
                                                <a class="dropdown-item"
                                                    href="authentication-signin-basic.html">
                                                    <span class="tio-circle-outlined nav-indicator-icon"></span>
                                                    Basic
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item"
                                                    href="authentication-signin-cover.html">
                                                    <span class="tio-circle-outlined nav-indicator-icon"></span>
                                                    Cover
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                    <!-- End Signin -->

                                    <!-- Signup -->
                                    <li class="hs-has-sub-menu navbar-nav-item">
                                        <a id="pagesDropdownSignup"
                                            class="hs-mega-menu-invoker dropdown-item dropdown-item-toggle"
                                            href="javascript:;" aria-haspopup="true" aria-expanded="false"
                                            aria-controls="navLinkPagesDropdownSignup">
                                            <span class="tio-circle nav-indicator-icon"></span>
                                            Sign Up
                                        </a>

                                        <ul id="navLinkPagesDropdownSignup"
                                            class="hs-sub-menu dropdown-menu dropdown-menu-lg"
                                            aria-labelledby="pagesDropdownSignup" style="min-width: 16rem">
                                            <li>
                                                <a class="dropdown-item"
                                                    href="authentication-signup-basic.html">
                                                    <span class="tio-circle-outlined nav-indicator-icon"></span>
                                                    Basic
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item"
                                                    href="authentication-signup-cover.html">
                                                    <span class="tio-circle-outlined nav-indicator-icon"></span>
                                                    Cover
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                    <!-- End Signup -->

                                    <!-- Reset Password -->
                                    <li class="hs-has-sub-menu navbar-nav-item">
                                        <a id="pagesDropdownResetPassword"
                                            class="hs-mega-menu-invoker dropdown-item dropdown-item-toggle"
                                            href="javascript:;" aria-haspopup="true" aria-expanded="false"
                                            aria-controls="navLinkPagesDropdownResetPassword">
                                            <span class="tio-circle nav-indicator-icon"></span>
                                            Reset Password
                                        </a>

                                        <ul id="navLinkPagesDropdownResetPassword"
                                            class="hs-sub-menu dropdown-menu dropdown-menu-lg"
                                            aria-labelledby="pagesDropdownResetPassword"
                                            style="min-width: 16rem">
                                            <li>
                                                <a class="dropdown-item"
                                                    href="authentication-reset-password-basic.html">
                                                    <span class="tio-circle-outlined nav-indicator-icon"></span>
                                                    Basic
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item"
                                                    href="authentication-reset-password-cover.html">
                                                    <span class="tio-circle-outlined nav-indicator-icon"></span>
                                                    Cover
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                    <!-- End Reset Password -->

                                    <!-- Email Verification -->
                                    <li class="hs-has-sub-menu navbar-nav-item">
                                        <a id="pagesDropdownEmailVerification"
                                            class="hs-mega-menu-invoker dropdown-item dropdown-item-toggle"
                                            href="javascript:;" aria-haspopup="true" aria-expanded="false"
                                            aria-controls="navLinkPagesDropdownEmailVerification">
                                            <span class="tio-circle nav-indicator-icon"></span>
                                            Email Verification
                                        </a>

                                        <ul id="navLinkPagesDropdownEmailVerification"
                                            class="hs-sub-menu dropdown-menu dropdown-menu-lg"
                                            aria-labelledby="pagesDropdownEmailVerification"
                                            style="min-width: 16rem">
                                            <li>
                                                <a class="dropdown-item"
                                                    href="authentication-email-verification-basic.html">
                                                    <span class="tio-circle-outlined nav-indicator-icon"></span>
                                                    Basic
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item"
                                                    href="authentication-email-verification-cover.html">
                                                    <span class="tio-circle-outlined nav-indicator-icon"></span>
                                                    Cover
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                    <!-- End Email Verification -->

                                    <!-- 2-step Verification -->
                                    <li class="hs-has-sub-menu navbar-nav-item">
                                        <a id="pagesDropdown2StepVerification"
                                            class="hs-mega-menu-invoker dropdown-item dropdown-item-toggle"
                                            href="javascript:;" aria-haspopup="true" aria-expanded="false"
                                            aria-controls="navLinkPagesDropdown2StepVerification">
                                            <span class="tio-circle nav-indicator-icon"></span>
                                            2-step Verification
                                        </a>

                                        <ul id="navLinkPagesDropdown2StepVerification"
                                            class="hs-sub-menu dropdown-menu dropdown-menu-lg"
                                            aria-labelledby="pagesDropdown2StepVerification"
                                            style="min-width: 16rem">
                                            <li>
                                                <a class="dropdown-item"
                                                    href="authentication-two-step-verification-basic.html">
                                                    <span class="tio-circle-outlined nav-indicator-icon"></span>
                                                    Basic
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item"
                                                    href="authentication-two-step-verification-cover.html">
                                                    <span class="tio-circle-outlined nav-indicator-icon"></span>
                                                    Cover
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                    <!-- End 2-step Verification -->

                                    <li class="dropdown-divider"></li>

                                    <!-- Welcome Page -->
                                    <li class="navbar-nav-item">
                                        <a class="dropdown-item" href="error-404.html">
                                            <span class="tio-circle nav-indicator-icon"></span>
                                            Error 404
                                        </a>
                                    </li>
                                    <!-- ENd Welcome Page -->

                                    <!-- Welcome Page -->
                                    <li class="navbar-nav-item">
                                        <a class="dropdown-item" href="error-500.html">
                                            <span class="tio-circle nav-indicator-icon"></span>
                                            Error 500
                                        </a>
                                    </li>
                                    <!-- ENd Welcome Page -->

                                    <li class="dropdown-divider"></li>

                                    <!-- Welcome Page -->
                                    <li class="navbar-nav-item">
                                        <a class="dropdown-item" href="welcome-page.html">
                                            <span class="tio-circle nav-indicator-icon"></span>
                                            Welcome Page
                                        </a>
                                    </li>
                                    <!-- ENd Welcome Page -->
                                </ul>
                                <!-- End Dropdown -->
                            </li>
                            <!-- End Pages -->

                            <!-- Documentation -->
                            <li class="hs-has-sub-menu navbar-nav-item">
                                <a id="appsNavDropdown"
                                    class="hs-mega-menu-invoker navbar-nav-link nav-link nav-link-toggle"
                                    href="javascript:;" aria-haspopup="true" aria-expanded="false"
                                    aria-labelledby="navLinkappsNavDropdown">
                                    <i class="tio-apps nav-icon"></i> Apps
                                </a>

                                <!-- Dropdown -->
                                <ul id="navLinkappsNavDropdown"
                                    class="hs-sub-menu dropdown-menu dropdown-menu-lg"
                                    aria-labelledby="appsNavDropdown" style="min-width: 16rem">
                                    <li>
                                        <a class="dropdown-item" href="apps-kanban.html">
                                            <span class="tio-circle nav-indicator-icon"></span>
                                            Kanban
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="apps-calendar.html">
                                            <span class="tio-circle nav-indicator-icon"></span>
                                            Calendar
                                            <span class="badge badge-info badge-pill ml-1">New</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="apps-invoice-generator.html">
                                            <span class="tio-circle nav-indicator-icon"></span>
                                            Invoice Generator
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="apps-file-manager.html">
                                            <span class="tio-circle nav-indicator-icon"></span>
                                            File Manager
                                        </a>
                                    </li>
                                </ul>
                                <!-- End Dropdown -->
                            </li>
                            <!-- End Documentation -->

                            <!-- Layouts -->
                            <li class="navbar-nav-item">
                                <a class="navbar-nav-link nav-link" href="layouts\layouts.html">
                                    <i class="tio-dashboard-vs-outlined nav-icon"></i> Layouts
                                </a>
                            </li>
                            <!-- End Layouts -->

                            <!-- Documentation -->
                            <li class="hs-has-sub-menu navbar-nav-item">
                                <a id="documentationDropdown"
                                    class="hs-mega-menu-invoker navbar-nav-link nav-link nav-link-toggle"
                                    href="javascript:;" aria-haspopup="true" aria-expanded="false"
                                    aria-labelledby="navLinkDocumentationDropdown">
                                    <i class="tio-book-opened nav-icon"></i> Docs
                                </a>

                                <!-- Dropdown -->
                                <ul id="navLinkDocumentationDropdown"
                                    class="hs-sub-menu dropdown-menu dropdown-menu-lg"
                                    aria-labelledby="documentationDropdown" style="min-width: 16rem">
                                    <li>
                                        <a class="dropdown-item" href="documentation\index.html">
                                            <span class="tio-circle nav-indicator-icon"></span>
                                            Documentation
                                            <span class="badge badge-primary badge-pill ml-1">v1.0</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="documentation\alerts.html">
                                            <span class="tio-circle nav-indicator-icon"></span>
                                            Components
                                        </a>
                                    </li>
                                </ul>
                                <!-- End Dropdown -->
                            </li>
                            <!-- End Documentation -->
                        </ul>
                    </div>
                </div>
                <!-- End Navbar -->
            </nav>
        </div>
    </header>
</div>
@include('components.sidebar')
<div id="sidebarCompact" class="d-none">
    <aside
        class="js-navbar-vertical-aside navbar navbar-vertical-aside navbar-vertical navbar-vertical-fixed navbar-expand-xl navbar-bordered">
        <div class="navbar-vertical-container">
            <div class="navbar-brand d-flex justify-content-center">
                <!-- Logo -->

                <a class="navbar-brand" href="index.html" aria-label="Front">
                    <img class="navbar-brand-logo-short" src="{{asset('assets\svg\logos\logo-short.svg')}}"
                        alt="Logo" />
                </a>

                <!-- End Logo -->
            </div>

            <!-- Content -->
            <div class="navbar-vertical-content">
                <ul class="navbar-nav nav-compact">
                    <!-- Dashboards -->
                    <li class="navbar-vertical-aside-has-menu nav-item">
                        <a class="js-navbar-vertical-aside-menu-link nav-link" href="javascript:;"
                            title="Dashboards">
                            <i class="tio-home-vs-1-outlined nav-icon"></i>
                            <span class="nav-compact-title text-truncate">Dashboards</span>
                        </a>

                        <ul class="js-navbar-vertical-aside-submenu nav nav-sub">
                            <li class="nav-item">
                                <a class="nav-link" href="index.html" title="Default">
                                    <span class="tio-circle nav-indicator-icon"></span>
                                    <span class="text-truncate">Default</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="dashboard-alternative.html" title="Alternative">
                                    <span class="tio-circle nav-indicator-icon"></span>
                                    <span class="text-truncate">Alternative</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <!-- End Dashboards -->

                    <!-- Pages -->
                    <li class="navbar-vertical-aside-has-menu nav-item">
                        <a class="js-navbar-vertical-aside-menu-link nav-link" href="javascript:;"
                            title="Pages">
                            <i class="tio-pages-outlined nav-icon"></i>
                            <span class="nav-compact-title text-truncate">Pages</span>
                        </a>

                        <ul class="js-navbar-vertical-aside-submenu nav nav-sub">
                            <li class="navbar-vertical-aside-has-menu">
                                <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle"
                                    href="javascript:;" title="Users">
                                    <span class="tio-circle nav-indicator-icon"></span>
                                    <span class="text-truncate">Users</span>
                                </a>

                                <ul class="js-navbar-vertical-aside-submenu nav nav-sub">
                                    <li class="nav-item">
                                        <a class="nav-link" href="users.html" title="Overview">
                                            <span class="tio-circle-outlined nav-indicator-icon"></span>
                                            <span class="text-truncate">Overview</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="users-leaderboard.html" title="Leaderboard">
                                            <span class="tio-circle-outlined nav-indicator-icon"></span>
                                            <span class="text-truncate">Leaderboard</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="users-add-user.html" title="Add User">
                                            <span class="tio-circle-outlined nav-indicator-icon"></span>
                                            <span class="text-truncate">Add User
                                                <span class="badge badge-info badge-pill ml-1">Hot</span></span>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li class="navbar-vertical-aside-has-menu">
                                <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle"
                                    href="javascript:;" title="User Profile">
                                    <span class="tio-circle nav-indicator-icon"></span>
                                    <span class="text-truncate">User Profile
                                        <span class="badge badge-primary badge-pill ml-1">5</span></span>
                                </a>

                                <ul class="js-navbar-vertical-aside-submenu nav nav-sub">
                                    <li class="nav-item">
                                        <a class="nav-link" href="user-profile.html" title="Profile">
                                            <span class="tio-circle-outlined nav-indicator-icon"></span>
                                            <span class="text-truncate">Profile</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="user-profile-teams.html" title="Teams">
                                            <span class="tio-circle-outlined nav-indicator-icon"></span>
                                            <span class="text-truncate">Teams</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="user-profile-projects.html"
                                            title="Projects">
                                            <span class="tio-circle-outlined nav-indicator-icon"></span>
                                            <span class="text-truncate">Projects</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="user-profile-connections.html"
                                            title="Connections">
                                            <span class="tio-circle-outlined nav-indicator-icon"></span>
                                            <span class="text-truncate">Connections</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="user-profile-my-profile.html"
                                            title="My Profile">
                                            <span class="tio-circle-outlined nav-indicator-icon"></span>
                                            <span class="text-truncate">My Profile</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li class="navbar-vertical-aside-has-menu">
                                <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle"
                                    href="javascript:;" title="Account">
                                    <span class="tio-circle nav-indicator-icon"></span>
                                    <span class="text-truncate">Account</span>
                                </a>

                                <ul class="js-navbar-vertical-aside-submenu nav nav-sub">
                                    <li class="nav-item">
                                        <a class="nav-link" href="account-settings.html" title="Settings">
                                            <span class="tio-circle-outlined nav-indicator-icon"></span>
                                            <span class="text-truncate">Settings</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="account-billing.html" title="Billing">
                                            <span class="tio-circle-outlined nav-indicator-icon"></span>
                                            <span class="text-truncate">Billing</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="account-invoice.html" title="Invoice">
                                            <span class="tio-circle-outlined nav-indicator-icon"></span>
                                            <span class="text-truncate">Invoice</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="account-api-keys.html" title="API Keys">
                                            <span class="tio-circle-outlined nav-indicator-icon"></span>
                                            <span class="text-truncate">API Keys</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li class="navbar-vertical-aside-has-menu">
                                <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle"
                                    href="javascript:;" title="E-commerce">
                                    <span class="tio-circle nav-indicator-icon"></span>
                                    <span class="text-truncate">E-commerce</span>
                                </a>

                                <ul class="js-navbar-vertical-aside-submenu nav nav-sub">
                                    <li class="nav-item">
                                        <a class="nav-link" href="ecommerce.html" title="Overview">
                                            <span class="tio-circle-outlined nav-indicator-icon"></span>
                                            <span class="text-truncate">Overview</span>
                                        </a>
                                    </li>

                                    <li class="navbar-vertical-aside-has-menu">
                                        <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle"
                                            href="javascript:;" title="Products">
                                            <span class="tio-circle-outlined nav-indicator-icon"></span>
                                            <span class="text-truncate">Products</span>
                                        </a>

                                        <ul class="js-navbar-vertical-aside-submenu nav nav-sub">
                                            <li class="nav-item">
                                                <a class="nav-link" href="ecommerce-products.html"
                                                    title="Products">
                                                    <span class="tio-circle nav-indicator-icon"></span>
                                                    <span class="text-truncate">Products</span>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" href="ecommerce-product-details.html"
                                                    title="Product Details">
                                                    <span class="tio-circle nav-indicator-icon"></span>
                                                    <span class="text-truncate">Product Details</span>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" href="ecommerce-add-product.html"
                                                    title="Add Product">
                                                    <span class="tio-circle-outlined nav-indicator-icon"></span>
                                                    <span class="text-truncate">Add Product</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>

                                    <li class="navbar-vertical-aside-has-menu">
                                        <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle"
                                            href="javascript:;" title="Orders">
                                            <span class="tio-circle-outlined nav-indicator-icon"></span>
                                            <span class="text-truncate">Orders</span>
                                        </a>

                                        <ul class="js-navbar-vertical-aside-submenu nav nav-sub">
                                            <li class="nav-item">
                                                <a class="nav-link" href="ecommerce-orders.html"
                                                    title="Orders">
                                                    <span class="tio-circle nav-indicator-icon"></span>
                                                    <span class="text-truncate">Orders</span>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" href="ecommerce-order-details.html"
                                                    title="Order Details">
                                                    <span class="tio-circle nav-indicator-icon"></span>
                                                    <span class="text-truncate">Order Details</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>

                                    <li class="navbar-vertical-aside-has-menu">
                                        <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle"
                                            href="javascript:;" title="Customers">
                                            <span class="tio-circle-outlined nav-indicator-icon"></span>
                                            <span class="text-truncate">Customers</span>
                                        </a>

                                        <ul class="js-navbar-vertical-aside-submenu nav nav-sub">
                                            <li class="nav-item">
                                                <a class="nav-link" href="ecommerce-customers.html"
                                                    title="Customers">
                                                    <span class="tio-circle nav-indicator-icon"></span>
                                                    <span class="text-truncate">Customers</span>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" href="ecommerce-customer-details.html"
                                                    title="Customer Details">
                                                    <span class="tio-circle nav-indicator-icon"></span>
                                                    <span class="text-truncate">Customer Details</span>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" href="ecommerce-add-customers.html"
                                                    title="Add Customers">
                                                    <span class="tio-circle nav-indicator-icon"></span>
                                                    <span class="text-truncate">Add Customers</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>

                                    <li class="nav-item">
                                        <a class="nav-link" href="ecommerce-manage-reviews.html"
                                            title="Manage Reviews">
                                            <span class="tio-circle-outlined nav-indicator-icon"></span>
                                            <span class="text-truncate">Manage Reviews</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="ecommerce-checkout.html" title="Checkout">
                                            <span class="tio-circle-outlined nav-indicator-icon"></span>
                                            <span class="text-truncate">Checkout</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li class="navbar-vertical-aside-has-menu">
                                <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle"
                                    href="javascript:;" title="Projects">
                                    <span class="tio-circle nav-indicator-icon"></span>
                                    <span class="text-truncate">Projects</span>
                                </a>

                                <ul class="js-navbar-vertical-aside-submenu nav nav-sub">
                                    <li class="nav-item">
                                        <a class="nav-link" href="projects.html" title="Overview">
                                            <span class="tio-circle-outlined nav-indicator-icon"></span>
                                            <span class="text-truncate">Overview</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="projects-timeline.html" title="Timeline">
                                            <span class="tio-circle-outlined nav-indicator-icon"></span>
                                            <span class="text-truncate">Timeline</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li class="navbar-vertical-aside-has-menu">
                                <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle"
                                    href="javascript:;" title="Project">
                                    <span class="tio-circle nav-indicator-icon"></span>
                                    <span class="text-truncate">Project</span>
                                </a>

                                <ul class="js-navbar-vertical-aside-submenu nav nav-sub">
                                    <li class="nav-item">
                                        <a class="nav-link" href="project.html" title="Overview">
                                            <span class="tio-circle-outlined nav-indicator-icon"></span>
                                            <span class="text-truncate">Overview</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="project-files.html" title="Files">
                                            <span class="tio-circle-outlined nav-indicator-icon"></span>
                                            <span class="text-truncate">Files
                                                <span class="badge badge-info badge-pill ml-1">Hot</span></span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="project-activity.html" title="Activity">
                                            <span class="tio-circle-outlined nav-indicator-icon"></span>
                                            <span class="text-truncate">Activity</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="project-teams.html" title="Teams">
                                            <span class="tio-circle-outlined nav-indicator-icon"></span>
                                            <span class="text-truncate">Teams</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="project-settings.html" title="Settings">
                                            <span class="tio-circle-outlined nav-indicator-icon"></span>
                                            <span class="text-truncate">Settings</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="referrals.html" title="Referrals">
                                    <span class="tio-circle nav-indicator-icon"></span>
                                    <span class="text-truncate">Referrals</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <!-- End Pages -->

                    <!-- Apps -->
                    <li class="navbar-vertical-aside-has-menu nav-item">
                        <a class="js-navbar-vertical-aside-menu-link nav-link" href="javascript:;"
                            title="Apps">
                            <i class="tio-apps nav-icon"></i>
                            <span class="nav-compact-title text-truncate">Apps</span>
                        </a>

                        <ul class="js-navbar-vertical-aside-submenu nav nav-sub">
                            <li class="nav-item">
                                <a class="nav-link" href="apps-kanban.html" title="Kanban">
                                    <span class="tio-circle nav-indicator-icon"></span>
                                    <span class="text-truncate">Kanban</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="apps-calendar.html" title="Calendar">
                                    <span class="tio-circle nav-indicator-icon"></span>
                                    <span class="text-truncate">Calendar
                                        <span class="badge badge-info badge-pill ml-1">New</span></span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="apps-invoice-generator.html"
                                    title="Invoice Generator">
                                    <span class="tio-circle nav-indicator-icon"></span>
                                    <span class="text-truncate">Invoice Generator</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="apps-file-manager.html" title="File Manager">
                                    <span class="tio-circle nav-indicator-icon"></span>
                                    <span class="text-truncate">File Manager</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <!-- End Apps -->

                    <!-- Authentication -->
                    <li class="navbar-vertical-aside-has-menu nav-item">
                        <a class="js-navbar-vertical-aside-menu-link nav-link" href="javascript:;"
                            title="Authentication">
                            <i class="tio-lock-outlined nav-icon"></i>
                            <span class="nav-compact-title text-truncate">Authentication</span>
                        </a>

                        <ul class="js-navbar-vertical-aside-submenu nav nav-sub">
                            <li class="navbar-vertical-aside-has-menu nav-item">
                                <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle"
                                    href="javascript:;" title="Sign In">
                                    <span class="tio-circle nav-indicator-icon"></span>
                                    <span class="text-truncate">Sign In</span>
                                </a>

                                <ul class="js-navbar-vertical-aside-submenu nav nav-sub">
                                    <li class="nav-item">
                                        <a class="nav-link" href="authentication-signin-basic.html"
                                            title="Basic">
                                            <span class="tio-circle-outlined nav-indicator-icon"></span>
                                            <span class="text-truncate">Basic</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="authentication-signin-cover.html"
                                            title="Cover">
                                            <span class="tio-circle-outlined nav-indicator-icon"></span>
                                            <span class="text-truncate">Cover</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li class="navbar-vertical-aside-has-menu nav-item">
                                <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle"
                                    href="javascript:;" title="Sign Up">
                                    <span class="tio-circle nav-indicator-icon"></span>
                                    <span class="text-truncate">Sign Up</span>
                                </a>

                                <ul class="js-navbar-vertical-aside-submenu nav nav-sub">
                                    <li class="nav-item">
                                        <a class="nav-link" href="authentication-signup-basic.html"
                                            title="Basic">
                                            <span class="tio-circle-outlined nav-indicator-icon"></span>
                                            <span class="text-truncate">Basic</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="authentication-signup-cover.html"
                                            title="Cover">
                                            <span class="tio-circle-outlined nav-indicator-icon"></span>
                                            <span class="text-truncate">Cover</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li class="navbar-vertical-aside-has-menu nav-item">
                                <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle"
                                    href="javascript:;" title="Reset Password">
                                    <span class="tio-circle nav-indicator-icon"></span>
                                    <span class="text-truncate">Reset Password</span>
                                </a>

                                <ul class="js-navbar-vertical-aside-submenu nav nav-sub">
                                    <li class="nav-item">
                                        <a class="nav-link" href="authentication-reset-password-basic.html"
                                            title="Basic">
                                            <span class="tio-circle-outlined nav-indicator-icon"></span>
                                            <span class="text-truncate">Basic</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="authentication-reset-password-cover.html"
                                            title="Cover">
                                            <span class="tio-circle-outlined nav-indicator-icon"></span>
                                            <span class="text-truncate">Cover</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li class="navbar-vertical-aside-has-menu nav-item">
                                <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle"
                                    href="javascript:;" title="Email Verification">
                                    <span class="tio-circle nav-indicator-icon"></span>
                                    <span class="text-truncate">Email Verification</span>
                                </a>

                                <ul class="js-navbar-vertical-aside-submenu nav nav-sub">
                                    <li class="nav-item">
                                        <a class="nav-link" href="authentication-email-verification-basic.html"
                                            title="Basic">
                                            <span class="tio-circle-outlined nav-indicator-icon"></span>
                                            <span class="text-truncate">Basic</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="authentication-email-verification-cover.html"
                                            title="Cover">
                                            <span class="tio-circle-outlined nav-indicator-icon"></span>
                                            <span class="text-truncate">Cover</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li class="navbar-vertical-aside-has-menu nav-item">
                                <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle"
                                    href="javascript:;" title="2-step Verification">
                                    <span class="tio-circle nav-indicator-icon"></span>
                                    <span class="text-truncate">2-step Verification</span>
                                </a>

                                <ul class="js-navbar-vertical-aside-submenu nav nav-sub">
                                    <li class="nav-item">
                                        <a class="nav-link"
                                            href="authentication-two-step-verification-basic.html"
                                            title="Basic">
                                            <span class="tio-circle-outlined nav-indicator-icon"></span>
                                            <span class="text-truncate">Basic</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link"
                                            href="authentication-two-step-verification-cover.html"
                                            title="Cover">
                                            <span class="tio-circle-outlined nav-indicator-icon"></span>
                                            <span class="text-truncate">Cover</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="javascript:;" data-toggle="modal"
                                    data-target="#welcomeMessageModal" title="Welcome Message">
                                    <span class="tio-circle nav-indicator-icon"></span>
                                    <span class="text-truncate">Welcome Message</span>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="error-404.html" title="Error 404">
                                    <span class="tio-circle nav-indicator-icon"></span>
                                    <span class="text-truncate">Error 404</span>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="error-500.html" title="Error 500">
                                    <span class="tio-circle nav-indicator-icon"></span>
                                    <span class="text-truncate">Error 500</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <!-- End Authentication -->

                    <li class="nav-item">
                        <a class="nav-link" href="welcome-page.html" title="Welcome Page">
                            <i class="tio-visible-outlined nav-icon"></i>
                            <span class="nav-compact-title text-truncate">Welcome Page</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="layouts\layouts.html" title="Layouts">
                            <i class="tio-dashboard-vs-outlined nav-icon"></i>
                            <span class="nav-compact-title text-truncate">Layouts</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="documentation\index.html" title="Documentation">
                            <i class="tio-book-opened nav-icon"></i>
                            <span class="nav-compact-title text-truncate">Documentation</span>
                            <span class="badge badge-primary badge-pill">v1.1</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="documentation\typography.html" title="Components">
                            <i class="tio-layers-outlined nav-icon"></i>
                            <span class="nav-compact-title text-truncate">Components</span>
                        </a>
                    </li>
                </ul>
            </div>
            <!-- End Content -->
        </div>
    </aside>
</div>

<script src="{{asset('assets\js\demo.js')}}"></script>

<!-- END ONLY DEV -->

<!-- Search Form -->
<div id="searchDropdown" class="hs-unfold-content dropdown-unfold search-fullwidth d-md-none">
    <form class="input-group input-group-merge input-group-borderless">
        <div class="input-group-prepend">
            <div class="input-group-text">
                <i class="tio-search"></i>
            </div>
        </div>

        <input class="form-control rounded-0" type="search" placeholder="Search in front"
            aria-label="Search in front" />

        <div class="input-group-append">
            <div class="input-group-text">
                <div class="hs-unfold">
                    <a class="js-hs-unfold-invoker" href="javascript:;"
                        data-hs-unfold-options='{
               "target": "#searchDropdown",
               "type": "css-animation",
               "animationIn": "fadeIn",
               "hasOverlay": "rgba(46, 52, 81, 0.1)",
               "closeBreakpoint": "md"
             }'>
                        <i class="tio-clear tio-lg"></i>
                    </a>
                </div>
            </div>
        </div>
    </form>
</div>
<!-- End Search Form -->

<!-- ========== HEADER ========== -->

<!-- ========== END HEADER ========== -->

<!-- ========== MAIN CONTENT ========== -->
<!-- Navbar Vertical -->

<!-- End Navbar Vertical -->

<main id="content" role="main" class="main pointer-event">
    <!-- Content -->
    @yield('main')

    <!-- End Content -->

    <!-- Footer -->

    <div class="footer">
        <div class="row justify-content-between align-items-center">
            <div class="col">
                <p class="font-size-sm mb-0">
                    &copy; Quin Ecommerce.
                    <span class="d-none d-sm-inline-block">{{date("Y")}} Quin Group.</span>
                </p>
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
<!-- ========== END MAIN CONTENT ========== -->

<!-- ========== SECONDARY CONTENTS ========== -->
<!-- Keyboard Shortcuts -->
<div id="keyboardShortcutsSidebar" class="hs-unfold-content sidebar sidebar-bordered sidebar-box-shadow">
    <div class="card card-lg sidebar-card">
        <div class="card-header">
            <h4 class="card-header-title">Keyboard shortcuts</h4>

            <!-- Toggle Button -->
            <a class="js-hs-unfold-invoker btn btn-icon btn-xs btn-ghost-dark ml-2" href="javascript:;"
                data-hs-unfold-options='{
            "target": "#keyboardShortcutsSidebar",
            "type": "css-animation",
            "animationIn": "fadeInRight",
            "animationOut": "fadeOutRight",
            "hasOverlay": true,
            "smartPositionOff": true
           }'>
                <i class="tio-clear tio-lg"></i>
            </a>
            <!-- End Toggle Button -->
        </div>

        <!-- Body -->
        <div class="card-body sidebar-body sidebar-scrollbar">
            <div class="list-group list-group-sm list-group-flush list-group-no-gutters mb-5">
                <div class="list-group-item">
                    <h5 class="mb-1">Formatting</h5>
                </div>
                <div class="list-group-item">
                    <div class="row align-items-center">
                        <div class="col-5">
                            <span class="font-weight-bold">Bold</span>
                        </div>
                        <div class="col-7 text-right">
                            <kbd class="d-inline-block mb-1">Ctrl</kbd>
                            <small class="text-muted">+</small>
                            <kbd class="d-inline-block mb-1">b</kbd>
                        </div>
                    </div>
                </div>
                <div class="list-group-item">
                    <div class="row align-items-center">
                        <div class="col-5">
                            <em>italic</em>
                        </div>
                        <div class="col-7 text-right">
                            <kbd class="d-inline-block mb-1">Ctrl</kbd>
                            <small class="text-muted">+</small>
                            <kbd class="d-inline-block mb-1">i</kbd>
                        </div>
                    </div>
                </div>
                <div class="list-group-item">
                    <div class="row align-items-center">
                        <div class="col-5">
                            <u>Underline</u>
                        </div>
                        <div class="col-7 text-right">
                            <kbd class="d-inline-block mb-1">Ctrl</kbd>
                            <small class="text-muted">+</small>
                            <kbd class="d-inline-block mb-1">u</kbd>
                        </div>
                    </div>
                </div>
                <div class="list-group-item">
                    <div class="row align-items-center">
                        <div class="col-5">
                            <s>Strikethrough</s>
                        </div>
                        <div class="col-7 text-right">
                            <kbd class="d-inline-block mb-1">Ctrl</kbd>
                            <small class="text-muted">+</small>
                            <kbd class="d-inline-block mb-1">Alt</kbd>
                            <small class="text-muted">+</small>
                            <kbd class="d-inline-block mb-1">s</kbd>
                        </div>
                    </div>
                </div>
                <div class="list-group-item">
                    <div class="row align-items-center">
                        <div class="col-5">
                            <span class="small">Small text</span>
                        </div>
                        <div class="col-7 text-right">
                            <kbd class="d-inline-block mb-1">Ctrl</kbd>
                            <small class="text-muted">+</small>
                            <kbd class="d-inline-block mb-1">s</kbd>
                        </div>
                    </div>
                </div>
                <div class="list-group-item">
                    <div class="row align-items-center">
                        <div class="col-5">
                            <mark>Highlight</mark>
                        </div>
                        <div class="col-7 text-right">
                            <kbd class="d-inline-block mb-1">Ctrl</kbd>
                            <small class="text-muted">+</small>
                            <kbd class="d-inline-block mb-1">e</kbd>
                        </div>
                    </div>
                </div>
            </div>

            <div class="list-group list-group-sm list-group-flush list-group-no-gutters mb-5">
                <div class="list-group-item">
                    <h5 class="mb-1">Insert</h5>
                </div>
                <div class="list-group-item">
                    <div class="row align-items-center">
                        <div class="col-5">
                            <span>Mention person <a href="#">(@Brian)</a></span>
                        </div>
                        <div class="col-7 text-right">
                            <kbd class="d-inline-block mb-1">@</kbd>
                        </div>
                    </div>
                </div>
                <div class="list-group-item">
                    <div class="row align-items-center">
                        <div class="col-5">
                            <span>Link to doc <a href="#">(+Meeting notes)</a></span>
                        </div>
                        <div class="col-7 text-right">
                            <kbd class="d-inline-block mb-1">+</kbd>
                        </div>
                    </div>
                </div>
                <div class="list-group-item">
                    <div class="row align-items-center">
                        <div class="col-5">
                            <a href="#">#hashtag</a>
                        </div>
                        <div class="col-7 text-right">
                            <kbd class="d-inline-block mb-1">#hashtag</kbd>
                        </div>
                    </div>
                </div>
                <div class="list-group-item">
                    <div class="row align-items-center">
                        <div class="col-5">
                            <span>Date</span>
                        </div>
                        <div class="col-7 text-right">
                            <kbd class="d-inline-block mb-1">/date</kbd>
                            <kbd class="d-inline-block mb-1">Space</kbd>
                            <kbd class="d-inline-block mb-1">/datetime</kbd>
                            <kbd class="d-inline-block mb-1">/datetime</kbd>
                            <kbd class="d-inline-block mb-1">Space</kbd>
                        </div>
                    </div>
                </div>
                <div class="list-group-item">
                    <div class="row align-items-center">
                        <div class="col-5">
                            <span>Time</span>
                        </div>
                        <div class="col-7 text-right">
                            <kbd class="d-inline-block mb-1">/time</kbd>
                            <kbd class="d-inline-block mb-1">Space</kbd>
                        </div>
                    </div>
                </div>
                <div class="list-group-item">
                    <div class="row align-items-center">
                        <div class="col-5">
                            <span>Note box</span>
                        </div>
                        <div class="col-7 text-right">
                            <kbd class="d-inline-block mb-1">/note</kbd>
                            <kbd class="d-inline-block mb-1">Enter</kbd>
                            <kbd class="d-inline-block mb-1">/note red</kbd>
                            <kbd class="d-inline-block mb-1">/note red</kbd>
                            <kbd class="d-inline-block mb-1">Enter</kbd>
                        </div>
                    </div>
                </div>
            </div>

            <div class="list-group list-group-sm list-group-flush list-group-no-gutters mb-5">
                <div class="list-group-item">
                    <h5 class="mb-1">Editing</h5>
                </div>
                <div class="list-group-item">
                    <div class="row align-items-center">
                        <div class="col-5">
                            <span>Find and replace</span>
                        </div>
                        <div class="col-7 text-right">
                            <kbd class="d-inline-block mb-1">Ctrl</kbd>
                            <small class="text-muted">+</small>
                            <kbd class="d-inline-block mb-1">r</kbd>
                        </div>
                    </div>
                </div>
                <div class="list-group-item">
                    <div class="row align-items-center">
                        <div class="col-5">
                            <span>Find next</span>
                        </div>
                        <div class="col-7 text-right">
                            <kbd class="d-inline-block mb-1">Ctrl</kbd>
                            <small class="text-muted">+</small>
                            <kbd class="d-inline-block mb-1">n</kbd>
                        </div>
                    </div>
                </div>
                <div class="list-group-item">
                    <div class="row align-items-center">
                        <div class="col-5">
                            <span>Find previous</span>
                        </div>
                        <div class="col-7 text-right">
                            <kbd class="d-inline-block mb-1">Ctrl</kbd>
                            <small class="text-muted">+</small>
                            <kbd class="d-inline-block mb-1">p</kbd>
                        </div>
                    </div>
                </div>
                <div class="list-group-item">
                    <div class="row align-items-center">
                        <div class="col-5">
                            <span>Indent</span>
                        </div>
                        <div class="col-7 text-right">
                            <kbd class="d-inline-block mb-1">Tab</kbd>
                        </div>
                    </div>
                </div>
                <div class="list-group-item">
                    <div class="row align-items-center">
                        <div class="col-5">
                            <span>Un-indent</span>
                        </div>
                        <div class="col-7 text-right">
                            <kbd class="d-inline-block mb-1">Shift</kbd>
                            <small class="text-muted">+</small>
                            <kbd class="d-inline-block mb-1">Tab</kbd>
                        </div>
                    </div>
                </div>
                <div class="list-group-item">
                    <div class="row align-items-center">
                        <div class="col-5">
                            <span>Move line up</span>
                        </div>
                        <div class="col-7 text-right">
                            <kbd class="d-inline-block mb-1">Ctrl</kbd>
                            <small class="text-muted">+</small>
                            <kbd class="d-inline-block mb-1">Shift</kbd>
                            <small class="text-muted">+</small>
                            <kbd class="d-inline-block mb-1"><i
                                    class="tio-arrow-large-upward-outlined"></i></kbd>
                        </div>
                    </div>
                </div>
                <div class="list-group-item">
                    <div class="row align-items-center">
                        <div class="col-5">
                            <span>Move line down</span>
                        </div>
                        <div class="col-7 text-right">
                            <kbd class="d-inline-block mb-1">Ctrl</kbd>
                            <small class="text-muted">+</small>
                            <kbd class="d-inline-block mb-1">Shift</kbd>
                            <small class="text-muted">+</small>
                            <kbd class="d-inline-block mb-1"><i
                                    class="tio-arrow-large-downward-outlined font-size-sm"></i></kbd>
                        </div>
                    </div>
                </div>
                <div class="list-group-item">
                    <div class="row align-items-center">
                        <div class="col-5">
                            <span>Add a comment</span>
                        </div>
                        <div class="col-7 text-right">
                            <kbd class="d-inline-block mb-1">Ctrl</kbd>
                            <small class="text-muted">+</small>
                            <kbd class="d-inline-block mb-1">Alt</kbd>
                            <small class="text-muted">+</small>
                            <kbd class="d-inline-block mb-1">m</kbd>
                        </div>
                    </div>
                </div>
                <div class="list-group-item">
                    <div class="row align-items-center">
                        <div class="col-5">
                            <span>Undo</span>
                        </div>
                        <div class="col-7 text-right">
                            <kbd class="d-inline-block mb-1">Ctrl</kbd>
                            <small class="text-muted">+</small>
                            <kbd class="d-inline-block mb-1">z</kbd>
                        </div>
                    </div>
                </div>
                <div class="list-group-item">
                    <div class="row align-items-center">
                        <div class="col-5">
                            <span>Redo</span>
                        </div>
                        <div class="col-7 text-right">
                            <kbd class="d-inline-block mb-1">Ctrl</kbd>
                            <small class="text-muted">+</small>
                            <kbd class="d-inline-block mb-1">y</kbd>
                        </div>
                    </div>
                </div>
            </div>

            <div class="list-group list-group-sm list-group-flush list-group-no-gutters">
                <div class="list-group-item">
                    <h5 class="mb-1">Application</h5>
                </div>
                <div class="list-group-item">
                    <div class="row align-items-center">
                        <div class="col-5">
                            <span>Create new doc</span>
                        </div>
                        <div class="col-7 text-right">
                            <kbd class="d-inline-block mb-1">Ctrl</kbd>
                            <small class="text-muted">+</small>
                            <kbd class="d-inline-block mb-1">Alt</kbd>
                            <small class="text-muted">+</small>
                            <kbd class="d-inline-block mb-1">n</kbd>
                        </div>
                    </div>
                </div>
                <div class="list-group-item">
                    <div class="row align-items-center">
                        <div class="col-5">
                            <span>Present</span>
                        </div>
                        <div class="col-7 text-right">
                            <kbd class="d-inline-block mb-1">Ctrl</kbd>
                            <small class="text-muted">+</small>
                            <kbd class="d-inline-block mb-1">Shift</kbd>
                            <small class="text-muted">+</small>
                            <kbd class="d-inline-block mb-1">p</kbd>
                        </div>
                    </div>
                </div>
                <div class="list-group-item">
                    <div class="row align-items-center">
                        <div class="col-5">
                            <span>Share</span>
                        </div>
                        <div class="col-7 text-right">
                            <kbd class="d-inline-block mb-1">Ctrl</kbd>
                            <small class="text-muted">+</small>
                            <kbd class="d-inline-block mb-1">Shift</kbd>
                            <small class="text-muted">+</small>
                            <kbd class="d-inline-block mb-1">s</kbd>
                        </div>
                    </div>
                </div>
                <div class="list-group-item">
                    <div class="row align-items-center">
                        <div class="col-5">
                            <span>Search docs</span>
                        </div>
                        <div class="col-7 text-right">
                            <kbd class="d-inline-block mb-1">Ctrl</kbd>
                            <small class="text-muted">+</small>
                            <kbd class="d-inline-block mb-1">Shift</kbd>
                            <small class="text-muted">+</small>
                            <kbd class="d-inline-block mb-1">o</kbd>
                        </div>
                    </div>
                </div>
                <div class="list-group-item">
                    <div class="row align-items-center">
                        <div class="col-5">
                            <span>Keyboard shortcuts</span>
                        </div>
                        <div class="col-7 text-right">
                            <kbd class="d-inline-block mb-1">Ctrl</kbd>
                            <small class="text-muted">+</small>
                            <kbd class="d-inline-block mb-1">Shift</kbd>
                            <small class="text-muted">+</small>
                            <kbd class="d-inline-block mb-1">/</kbd>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Body -->
    </div>
</div>
<!-- End Keyboard Shortcuts -->

<!-- Activity -->
<div id="activitySidebar" class="hs-unfold-content sidebar sidebar-bordered sidebar-box-shadow">
    <div class="card card-lg sidebar-card">
        <div class="card-header">
            <h4 class="card-header-title">Activity stream</h4>

            <!-- Toggle Button -->
            <a class="js-hs-unfold-invoker btn btn-icon btn-xs btn-ghost-dark ml-2" href="javascript:;"
                data-hs-unfold-options='{
          "target": "#activitySidebar",
          "type": "css-animation",
          "animationIn": "fadeInRight",
          "animationOut": "fadeOutRight",
          "hasOverlay": true,
          "smartPositionOff": true
         }'>
                <i class="tio-clear tio-lg"></i>
            </a>
            <!-- End Toggle Button -->
        </div>

        <!-- Body -->
        <div class="card-body sidebar-body sidebar-scrollbar">
            <!-- Step -->
            <ul class="step step-icon-sm step-avatar-sm">
                <!-- Step Item -->
                <li class="step-item">
                    <div class="step-content-wrapper">
                        <div class="step-avatar">
                            <img class="step-avatar-img" src="{{asset('assets\img\160x160\img9.jpg')}}"
                                alt="Image Description" />
                        </div>

                        <div class="step-content">
                            <h5 class="mb-1">Iana Robinson</h5>

                            <p class="font-size-sm mb-1">
                                Added 2 files to task
                                <a class="text-uppercase" href="#"><i class="tio-folder-bookmarked"></i>
                                    Fd-7</a>
                            </p>

                            <ul class="list-group list-group-sm">
                                <!-- List Item -->
                                <li class="list-group-item list-group-item-light">
                                    <div class="row gx-1">
                                        <div class="col-6">
                                            <div class="media">
                                                <span class="mt-1 mr-2">
                                                    <img class="avatar avatar-xs"
                                                        src="{{asset('assets\svg\brands\excel.svg')}}"
                                                        alt="Image Description" />
                                                </span>
                                                <div class="media-body text-truncate">
                                                    <span class="d-block font-size-sm text-dark text-truncate"
                                                        title="weekly-reports.xls">weekly-reports.xls</span>
                                                    <small class="d-block text-muted">12kb</small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="media">
                                                <span class="mt-1 mr-2">
                                                    <img class="avatar avatar-xs"
                                                        src="{{asset('assets\svg\brands\word.svg')}}"
                                                        alt="Image Description" />
                                                </span>
                                                <div class="media-body text-truncate">
                                                    <span class="d-block font-size-sm text-dark text-truncate"
                                                        title="weekly-reports.xls">weekly-reports.xls</span>
                                                    <small class="d-block text-muted">4kb</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <!-- End List Item -->
                            </ul>

                            <small class="text-muted text-uppercase">Now</small>
                        </div>
                    </div>
                </li>
                <!-- End Step Item -->

                <!-- Step Item -->
                <li class="step-item">
                    <div class="step-content-wrapper">
                        <span class="step-icon step-icon-soft-dark">B</span>

                        <div class="step-content">
                            <h5 class="mb-1">Bob Dean</h5>

                            <p class="font-size-sm mb-1">
                                Marked
                                <a class="text-uppercase" href="#"><i class="tio-folder-bookmarked"></i>
                                    Fr-6</a>
                                as
                                <span class="badge badge-soft-success badge-pill"><span
                                        class="legend-indicator bg-success"></span>"Completed"</span>
                            </p>

                            <small class="text-muted text-uppercase">Today</small>
                        </div>
                    </div>
                </li>
                <!-- End Step Item -->

                <!-- Step Item -->
                <li class="step-item">
                    <div class="step-content-wrapper">
                        <div class="step-avatar">
                            <img class="step-avatar-img" src="{{asset('assets\img\160x160\img3.jpg')}}"
                                alt="Image Description" />
                        </div>

                        <div class="step-content">
                            <h5 class="h5 mb-1">Crane</h5>

                            <p class="font-size-sm mb-1">
                                Added 5 card to <a href="#">Payments</a>
                            </p>

                            <ul class="list-group list-group-sm">
                                <li class="list-group-item list-group-item-light">
                                    <div class="row gx-1">
                                        <div class="col">
                                            <img class="img-fluid rounded ie-sidebar-activity-img"
                                                src="{{asset('assets\svg\illustrations\card-1.svg')}}"
                                                alt="Image Description" />
                                        </div>
                                        <div class="col">
                                            <img class="img-fluid rounded ie-sidebar-activity-img"
                                                src="{{asset('assets\svg\illustrations\card-2.svg')}}"
                                                alt="Image Description" />
                                        </div>
                                        <div class="col">
                                            <img class="img-fluid rounded ie-sidebar-activity-img"
                                                src="{{asset('assets\svg\illustrations\card-3.svg')}}"
                                                alt="Image Description" />
                                        </div>
                                        <div class="col-auto align-self-center">
                                            <div class="text-center">
                                                <a href="#">+2</a>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>

                            <small class="text-muted text-uppercase">May 12</small>
                        </div>
                    </div>
                </li>
                <!-- End Step Item -->

                <!-- Step Item -->
                <li class="step-item">
                    <div class="step-content-wrapper">
                        <span class="step-icon step-icon-soft-info">D</span>

                        <div class="step-content">
                            <h5 class="mb-1">David Lidell</h5>

                            <p class="font-size-sm mb-1">
                                Added a new member to Front Dashboard
                            </p>

                            <small class="text-muted text-uppercase">May 15</small>
                        </div>
                    </div>
                </li>
                <!-- End Step Item -->

                <!-- Step Item -->
                <li class="step-item">
                    <div class="step-content-wrapper">
                        <div class="step-avatar">
                            <img class="step-avatar-img" src="{{asset('assets\img\160x160\img7.jpg')}}"
                                alt="Image Description" />
                        </div>

                        <div class="step-content">
                            <h5 class="mb-1">Rachel King</h5>

                            <p class="font-size-sm mb-1">
                                Marked
                                <a class="text-uppercase" href="#"><i class="tio-folder-bookmarked"></i>
                                    Fr-3</a>
                                as
                                <span class="badge badge-soft-success badge-pill"><span
                                        class="legend-indicator bg-success"></span>"Completed"</span>
                            </p>

                            <small class="text-muted text-uppercase">Apr 29</small>
                        </div>
                    </div>
                </li>
                <!-- End Step Item -->

                <!-- Step Item -->
                <li class="step-item">
                    <div class="step-content-wrapper">
                        <div class="step-avatar">
                            <img class="step-avatar-img" src="{{asset('assets\img\160x160\img5.jpg')}}"
                                alt="Image Description" />
                        </div>

                        <div class="step-content">
                            <h5 class="mb-1">Finch Hoot</h5>

                            <p class="font-size-sm mb-1">
                                Earned a "Top endorsed"
                                <i class="tio-verified text-primary"></i> badge
                            </p>

                            <small class="text-muted text-uppercase">Apr 06</small>
                        </div>
                    </div>
                </li>
                <!-- End Step Item -->

                <!-- Step Item -->
                <li class="step-item">
                    <div class="step-content-wrapper">
                        <span class="step-icon step-icon-soft-primary">
                            <i class="tio-user"></i>
                        </span>

                        <div class="step-content">
                            <h5 class="mb-1">Project status updated</h5>

                            <p class="font-size-sm mb-1">
                                Marked
                                <a class="text-uppercase" href="#"><i class="tio-folder-bookmarked"></i>
                                    Fr-3</a>
                                as
                                <span class="badge badge-soft-primary badge-pill"><span
                                        class="legend-indicator bg-primary"></span>"In
                                    progress"</span>
                            </p>

                            <small class="text-muted text-uppercase">Feb 10</small>
                        </div>
                    </div>
                </li>
                <!-- End Step Item -->
            </ul>
            <!-- End Step -->

            <a class="btn btn-block btn-white" href="javascript:;">View all <i
                    class="tio-chevron-right"></i></a>
        </div>
        <!-- End Body -->
    </div>
</div>
<!-- End Activity -->

<!-- Welcome Message Modal -->
<div class="modal fade" id="welcomeMessageModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <!-- Header -->
            <div class="modal-close">
                <button type="button" class="btn btn-icon btn-sm btn-ghost-secondary" data-dismiss="modal"
                    aria-label="Close">
                    <i class="tio-clear tio-lg"></i>
                </button>
            </div>
            <!-- End Header -->

            <!-- Body -->
            <div class="modal-body p-sm-5">
                <div class="text-center">
                    <div class="w-75 w-sm-50 mx-auto mb-4">
                        <img class="img-fluid" src="{{asset('assets\svg\illustrations\graphs.svg')}}"
                            alt="Image Description" />
                    </div>

                    <h4 class="h1">Welcome to Front</h4>

                    <p>We're happy to see you in our community.</p>
                </div>
            </div>
            <!-- End Body -->

            <!-- Footer -->
            <div class="modal-footer d-block text-center py-sm-5">
                <small class="text-cap mb-4">Trusted by the world's best teams</small>

                <div class="w-85 mx-auto">
                    <div class="row justify-content-between">
                        <div class="col">
                            <img class="img-fluid ie-welcome-brands" src="{{asset('assets\svg\brands\gitlab-gray.svg')}}"
                                alt="Image Description" />
                        </div>
                        <div class="col">
                            <img class="img-fluid ie-welcome-brands" src="{{asset('assets\svg\brands\fitbit-gray.svg')}}"
                                alt="Image Description" />
                        </div>
                        <div class="col">
                            <img class="img-fluid ie-welcome-brands" src="{{asset('assets\svg\brands\flow-xo-gray.svg')}}"
                                alt="Image Description" />
                        </div>
                        <div class="col">
                            <img class="img-fluid ie-welcome-brands" src="{{asset('assets\svg\brands\layar-gray.svg')}}"
                                alt="Image Description" />
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Footer -->
        </div>
    </div>
</div>
<!-- End Welcome Message Modal -->


<!-- ========== END SECONDARY CONTENTS ========== -->

<!-- JS Implementing Plugins -->
<script src="{{asset('assets\js\vendor.min.js')}}"></script>
<script src="{{asset('assets\vendor\chart.js\dist\Chart.min.js')}}"></script>
<script src="{{asset('assets\vendor\chart.js.extensions\chartjs-extensions.js')}}"></script>
<script src="{{asset('assets\vendor\chartjs-plugin-datalabels\dist\chartjs-plugin-datalabels.min.js')}}"></script>

<!-- JS Front -->
<script src="{{asset('assets\js\theme.min.js')}}"></script>

<!-- JS Plugins Init. -->
<script>

    $(document).on("ready", function() {
        // ONLY DEV
        // =======================================================

        if (window.localStorage.getItem("hs-builder-popover") === null) {
            $("#builderPopover")
                .popover("show")
                .on("shown.bs.popover", function() {
                    $(".popover").last().addClass("popover-dark");
                });

            $(document).on("click", "#closeBuilderPopover", function() {
                window.localStorage.setItem("hs-builder-popover", true);
                $("#builderPopover").popover("dispose");
            });
        } else {
            $("#builderPopover").on("show.bs.popover", function() {
                return false;
            });
        }

        // END ONLY DEV
        // =======================================================

        // BUILDER TOGGLE INVOKER
        // =======================================================
        $(".js-navbar-vertical-aside-toggle-invoker").click(function() {
            $(".js-navbar-vertical-aside-toggle-invoker i").tooltip("hide");
        });

        // INITIALIZATION OF MEGA MENU
        // =======================================================
        var megaMenu = new HSMegaMenu($(".js-mega-menu"), {
            desktop: {
                position: "left",
            },
        }).init();

        // INITIALIZATION OF NAVBAR VERTICAL NAVIGATION
        // =======================================================
        var sidebar = $(".js-navbar-vertical-aside").hsSideNav();

        // INITIALIZATION OF TOOLTIP IN NAVBAR VERTICAL MENU
        // =======================================================
        $(".js-nav-tooltip-link").tooltip({
            boundary: "window"
        });

        $(".js-nav-tooltip-link").on("show.bs.tooltip", function(e) {
            if (!$("body").hasClass("navbar-vertical-aside-mini-mode")) {
                return false;
            }
        });

        // INITIALIZATION OF UNFOLD
        // =======================================================
        $(".js-hs-unfold-invoker").each(function() {
            var unfold = new HSUnfold($(this)).init();
        });

        // INITIALIZATION OF FORM SEARCH
        // =======================================================
        $(".js-form-search").each(function() {
            new HSFormSearch($(this)).init();
        });

        // INITIALIZATION OF SELECT2
        // =======================================================
        $(".js-select2-custom").each(function() {
            var select2 = $.HSCore.components.HSSelect2.init($(this));
        });

        // INITIALIZATION OF CHARTJS
        // =======================================================
        Chart.plugins.unregister(ChartDataLabels);

        $(".js-chart").each(function() {
            $.HSCore.components.HSChartJS.init($(this));
        });

        var updatingChart = $.HSCore.components.HSChartJS.init(
            $("#updatingData")
        );

        // CALL WHEN TAB IS CLICKED
        // =======================================================
        $('[data-toggle="chart-bar"]').click(function(e) {
            let keyDataset = $(e.currentTarget).attr("data-datasets");

            if (keyDataset === "lastWeek") {
                updatingChart.data.labels = [
                    "Apr 22",
                    "Apr 23",
                    "Apr 24",
                    "Apr 25",
                    "Apr 26",
                    "Apr 27",
                    "Apr 28",
                    "Apr 29",
                    "Apr 30",
                    "Apr 31",
                ];
                updatingChart.data.datasets = [{
                        data: [120, 250, 300, 200, 300, 290, 350, 100, 125, 320],
                        backgroundColor: "#377dff",
                        hoverBackgroundColor: "#377dff",
                        borderColor: "#377dff",
                    },
                    {
                        data: [250, 130, 322, 144, 129, 300, 260, 120, 260, 245, 110],
                        backgroundColor: "#e7eaf3",
                        borderColor: "#e7eaf3",
                    },
                ];
                updatingChart.update();
            } else {
                updatingChart.data.labels = [
                    "May 1",
                    "May 2",
                    "May 3",
                    "May 4",
                    "May 5",
                    "May 6",
                    "May 7",
                    "May 8",
                    "May 9",
                    "May 10",
                ];
                updatingChart.data.datasets = [{
                        data: [200, 300, 290, 350, 150, 350, 300, 100, 125, 220],
                        backgroundColor: "#377dff",
                        hoverBackgroundColor: "#377dff",
                        borderColor: "#377dff",
                    },
                    {
                        data: [150, 230, 382, 204, 169, 290, 300, 100, 300, 225, 120],
                        backgroundColor: "#e7eaf3",
                        borderColor: "#e7eaf3",
                    },
                ];
                updatingChart.update();
            }
        });

        // INITIALIZATION OF BUBBLE CHARTJS WITH DATALABELS PLUGIN
        // =======================================================
        $(".js-chart-datalabels").each(function() {
            $.HSCore.components.HSChartJS.init($(this), {
                plugins: [ChartDataLabels],
                options: {
                    plugins: {
                        datalabels: {
                            anchor: function(context) {
                                var value = context.dataset.data[context.dataIndex];
                                return value.r < 20 ? "end" : "center";
                            },
                            align: function(context) {
                                var value = context.dataset.data[context.dataIndex];
                                return value.r < 20 ? "end" : "center";
                            },
                            color: function(context) {
                                var value = context.dataset.data[context.dataIndex];
                                return value.r < 20 ?
                                    context.dataset.backgroundColor :
                                    context.dataset.color;
                            },
                            font: function(context) {
                                var value = context.dataset.data[context.dataIndex],
                                    fontSize = 25;

                                if (value.r > 50) {
                                    fontSize = 35;
                                }

                                if (value.r > 70) {
                                    fontSize = 55;
                                }

                                return {
                                    weight: "lighter",
                                    size: fontSize,
                                };
                            },
                            offset: 2,
                            padding: 0,
                        },
                    },
                },
            });
        });

        // INITIALIZATION OF DATERANGEPICKER
        // =======================================================
        $(".js-daterangepicker").daterangepicker();

        $(".js-daterangepicker-times").daterangepicker({
            timePicker: true,
            startDate: moment().startOf("hour"),
            endDate: moment().startOf("hour").add(32, "hour"),
            locale: {
                format: "M/DD hh:mm A",
            },
        });

        var start = moment();
        var end = moment();

        function cb(start, end) {
            $(
                "#js-daterangepicker-predefined .js-daterangepicker-predefined-preview"
            ).html(start.format("MMM D") + " - " + end.format("MMM D, YYYY"));
        }

        $("#js-daterangepicker-predefined").daterangepicker({
                startDate: start,
                endDate: end,
                ranges: {
                    Today: [moment(), moment()],
                    Yesterday: [
                        moment().subtract(1, "days"),
                        moment().subtract(1, "days"),
                    ],
                    "Last 7 Days": [moment().subtract(6, "days"), moment()],
                    "Last 30 Days": [moment().subtract(29, "days"), moment()],
                    "This Month": [
                        moment().startOf("month"),
                        moment().endOf("month"),
                    ],
                    "Last Month": [
                        moment().subtract(1, "month").startOf("month"),
                        moment().subtract(1, "month").endOf("month"),
                    ],
                },
            },
            cb
        );

        cb(start, end);

        // INITIALIZATION OF DATATABLES
        // =======================================================
        var datatable = $.HSCore.components.HSDatatables.init($("#datatable"), {
            select: {
                style: "multi",
                selector: 'td:first-child input[type="checkbox"]',
                classMap: {
                    checkAll: "#datatableCheckAll",
                    counter: "#datatableCounter",
                    counterInfo: "#datatableCounterInfo",
                },
            },
            language: {
                zeroRecords: '<div class="text-center p-4">' +
                    '<img class="mb-3" src="./assets/svg/illustrations/sorry.svg" alt="Image Description" style="width: 7rem;">' +
                    '<p class="mb-0">No data to show</p>' +
                    "</div>",
            },
        });

        $(".js-datatable-filter").on("change", function() {
            var $this = $(this),
                elVal = $this.val(),
                targetColumnIndex = $this.data("target-column-index");

            datatable.column(targetColumnIndex).search(elVal).draw();
        });

        $("#datatableSearch").on("mouseup", function(e) {
            var $input = $(this),
                oldValue = $input.val();

            if (oldValue == "") return;

            setTimeout(function() {
                var newValue = $input.val();

                if (newValue == "") {
                    // Gotcha
                    datatable.search("").draw();
                }
            }, 1);
        });

        // INITIALIZATION OF CLIPBOARD
        // =======================================================
        $(".js-clipboard").each(function() {
            var clipboard = $.HSCore.components.HSClipboard.init(this);
        });
    });
</script>

<!-- IE Support -->
<script>

    if (/MSIE \d|Trident.*rv:/.test(navigator.userAgent))
       {
        document.write(
         `<script src="${{{asset('assets/vendor/babel-polyfill/polyfill.min.js')}}}"><\/script>`
        );
    }

</script>
@endsection


