@php
    $menus = config('constants.menus._register');
    // dd($menus);
    // die();
@endphp


<!--end::Sidebar-->
<!--begin::sidebar-panel-->
<div id="kt_app_sidebar_panel" class="app-sidebar-panel" style="margin:0; border-radius:0" data-kt-drawer="true"
    data-kt-drawer-name="app-sidebar-panel" data-kt-drawer-activate="{default: true, lg: false}"
    data-kt-drawer-overlay="true" data-kt-drawer-width="250px" data-kt-drawer-direction="start"
    data-kt-drawer-toggle="#kt_app_sidebar_panel_mobile_toggle">

    <!--begin::Sidebar panel body-->
    <div class="hover-scroll-y scroll-ps m-2" id="kt_sidebar_panel_body" data-kt-scroll="true"
        data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_app_header"
        data-kt-scroll-wrappers="#kt_sidebar_panel_body" data-kt-scroll-offset="5px">
        <!--begin::Sidebar secondary menu-->
        <div class="app-sidebar-secondary-menu menu menu-sub-indention menu-rounded menu-column menu-active-bg menu-title-gray-600 menu-icon-gray-500 menu-state-primary menu-arrow-gray-500 fw-semibold fs-6 py-2"
            id="kt_app_sidebar_secondary_menu" data-kt-menu="true">

            @foreach ($menus as $menu)
                <x-sidebar.menu-item :item="$menu" />
            @endforeach

        </div>
        <!--end::Sidebar secondary menu-->
    </div>
    <!--end::Sidebar panel body-->
</div>
