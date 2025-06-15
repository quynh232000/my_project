@props(['item'])

@php
    $hasSub = isset($item['sub']);
@endphp

<div data-kt-menu-trigger="click" class="menu-item {{ $hasSub ? 'menu-accordion show' : '' }}  ">
    @if(isset($item['route']) && !$hasSub)
     {{-- route($item['route']) --}}
        <a href="{{route($item['route']) }}" class="menu-link {{ request()->routeIs($item['route']) ? 'active' : '' }}">
            <span class="menu-bullet">
                <span class="bullet bullet-dot"></span>
            </span>
            <span class="menu-title">{{ $item['title'] }}</span>
        </a>
    @else
        <span class="menu-link ">
            @if(isset($item['icon']))
                <span class="menu-icon">
                    <i class="{{ $item['icon'] }} fs-2"></i>
                </span>
            @else
                <span class="menu-bullet">
                    <span class="bullet bullet-dot"></span>
                </span>
            @endif
            <span class="menu-title">{{ $item['title'] }}</span>
            @if($hasSub)
                <span class="menu-arrow"></span>
            @endif
        </span>
    @endif

    @if($hasSub)
        <div class="menu-sub menu-sub-accordion">
            @foreach ($item['sub'] as $subItem)
                <x-sidebar.menu-item :item="$subItem" />
            @endforeach
        </div>
    @endif
</div>
