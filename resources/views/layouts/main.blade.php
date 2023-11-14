<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@include('layouts.header')
<body>
    <div class="container-scroller">
        @include('layouts.nav')
        <div class="container-fluid" style="padding-top: 70px;">
            @yield('main-content')
        </div>
        @include('layouts.footer')
    </div>
    @include('layouts.script')
</body>
</html>

    