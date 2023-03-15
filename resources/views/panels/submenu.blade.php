{{-- For submenu --}}

<style>

.main-menu.menu-dark .navigation > li ul .open > a, .main-menu.menu-dark .navigation > li ul .sidebar-group-active > a{
    background: #7367f0;
    box-shadow: 0 0 10px 1px white;
    color: #fff;
    font-weight: 400;
    border-radius: 4px;
}
</style>

<ul class="menu-content">
    @if(isset($menu))
    @foreach($menu as $submenu)
    @php
    $submenuTranslation = "";
    if(isset($menu->i18n)){
    $submenuTranslation = $menu->i18n;
    }
    @endphp
    <li class="{{ $submenu->active ? 'active' : '' }} ">
        <a href="{{ url('/' . $submenu->url) }}">
            <i class="{{ isset($submenu->icon) ? $submenu->icon : "" }}"></i>
            <span class="menu-title" data-i18n="{{ $submenuTranslation }}">{{($submenu->name) }}</span>
        </a>
        @if (isset($submenu->submenu))
        @include('panels/submenu', ['menu' => $submenu->submenu])
        @endif
    </li>
    @endforeach
    @endif
</ul>
