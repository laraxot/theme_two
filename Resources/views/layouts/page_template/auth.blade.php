
<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>
@include('pub_theme::layouts.navbars.sidebar')
<div class="main-panel">
    @include('pub_theme::layouts.navbars.navs.auth')
    @yield('content')
    @include('pub_theme::layouts.footer')
</div>
