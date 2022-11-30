@php
    $backgroundImage='';
@endphp
<div class="wrapper wrapper-full-page ">
    @include('pub_theme::layouts.navbars.navs.guest')
    <div class="full-page register-page section-image" filter-color="black" data-image="{{ $backgroundImage }}">
        @yield('content')
        @include('pub_theme::layouts.footer')
    </div>
</div>
