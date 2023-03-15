@php
  $configData = Helper::applClasses();
@endphp
<div
  class="main-menu menu-fixed {{($configData['theme'] === 'light') ? "menu-light" : "menu-dark"}} menu-accordion menu-shadow"
  data-scroll-to-active="true">
  <div class="navbar-header">
    <ul class="nav navbar-nav flex-row">
      <li class="nav-item mr-auto">
        <a class="navbar-brand" href="#">
          <div>
            <img width="200px" id="logo" class="toggle1" src="/images/{{$configData['page_logo']}}">
          </div>
        </a>
      </li>
      <li class="nav-item nav-toggle" style="color:#fff; position: relative;">
        <a class="nav-link modern-nav-toggle pr-0" data-toggle="collapse" style="position: absolute; right:10px;">
          <i class="feather icon-x d-block d-xl-none font-medium-4 primary toggle-icon"  style="color:#fff !important;" ></i>
          <i class="toggle-icon feather icon-disc font-medium-4 d-none d-xl-block primary collapse-toggle-icon"
            data-ticon="icon-disc"  style="color:#fff !important;">
          </i>
        </a>
      </li>
    </ul>
  </div>
  <div class="shadow-bottom"></div>
  <div class="main-menu-content">
    <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
      {{-- Foreach menu item starts --}}
      @if(isset($menuData))
        @foreach($menuData->menu as $menu)
          @if(isset($menu->navheader))
            <li class="navigation-header">
              <span>{{ $menu->navheader }}</span>
            </li>
          @else
          {{-- Add Custom Class with nav-item --}}
            @php
            $custom_classes = "";
            if(isset($menu->classlist)) {
              $custom_classes = $menu->classlist;
            }

            $translation = "";
            if(isset($menu->i18n)){
            $translation = $menu->i18n;
          }

            @endphp
            <li class="nav-item {{ $menu->active ? 'active' : '' }} {{ $custom_classes }}">
              <a href="{{ url('/' . $menu->url) }}">
                <i class="{{ $menu->icon }}"></i>
                <span class="menu-title" data-i18n="{{ $translation }}">{{ ($menu->name) }}</span>

                @if (isset($menu->badge))
                <?php $badgeClasses = "badge badge-pill badge-primary float-right" ?>
                <span class="{{ isset($menu->badgeClass) ? $menu->badgeClass.' test' : $badgeClasses.' notTest' }} ">
                  {{$menu->badge}}
                </span>
                @endif
              </a>

              @if(isset($menu->submenu))
                @include('panels/submenu', ['menu' => $menu->submenu])
              @endif
            </li>
          @endif
        @endforeach
      @endif
      {{-- Foreach menu item ends --}}
    </ul>
  </div>
</div>
<!-- END: Main Menu-->