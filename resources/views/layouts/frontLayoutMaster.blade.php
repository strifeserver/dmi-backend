<body
    class="horizontal-layout horizontal-menu {{ $configData['horizontalMenuType'] }} {{ $configData['blankPageClass'] }} {{ $configData['bodyClass'] }}  {{ $configData['theme'] === 'dark' ? 'dark-layout' : 'light' }} {{ $configData['footerType'] }}  footer-light"
    data-menu="horizontal-menu" data-col="2-columns" data-open="hover" data-layout="{{ $configData['theme'] }}">

    @include('panels.customerNavbar')


    <!-- BEGIN: Content-->
    <div class="">

        @yield('content')
    </div>

    @include('panels/footer')
    @include('panels/scripts')

</body>

</html>
