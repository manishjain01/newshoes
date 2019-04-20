<!DOCTYPE html>
<html lang="en">
    @include('includes.frontend.head')
    <body cz-shortcut-listen="true" style="padding-right: 17px;" class="modal-open">
        @include('includes.frontend.inner_header')
        @yield('content')
        @include('includes.frontend.footer')
    </body>
</html>