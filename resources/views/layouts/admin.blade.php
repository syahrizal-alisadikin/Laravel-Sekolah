<!DOCTYPE html>
<html lang="en">

{{-- Style --}}
@include('includes.styles')
{{-- end style --}}
<body style="background: #e2e8f0">
    <div id="app">
        <div class="main-wrapper main-wrapper-1">
            <div class="navbar-bg"></div>
            {{-- Navbar --}}
            @include('includes.navbar')
            {{-- end navbar --}}

            {{-- Sidebar --}}
            @include('includes.sidebar')
            {{-- end sidebar --}}

            <!-- Main Content -->
            @yield('content')

            {{-- Footer --}}
            @include('includes.footer')
            {{-- End Footer --}}
        </div>
    </div>

    {{-- Script --}}
    @include('includes.script')
    {{-- End Script --}}
</body>
</html>