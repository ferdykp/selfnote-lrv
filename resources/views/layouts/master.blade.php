<!DOCTYPE html>
{{-- <html lang="en"> --}}
<html lang="en" class="transition-colors duration-300">


<head>
    @include('layouts.head')
    @stack('head')
</head>

<body class="flex h-screen overflow-hidden font-serif bg-gray-100">
    {{-- Sidebar (tetap) --}}
    @include('layouts.aside')

    {{-- Main Content Area --}}
    <div class="flex flex-col flex-1 h-full overflow-hidden transition-all duration-300">
        {{-- Navbar (tetap di atas) --}}
        {{-- @include('layouts.navbar') --}}

        {{-- Scrollable Page Content --}}
        <main class="flex-1 overflow-y-auto">
            @yield('content')
        </main>
    </div>

    @include('layouts.scripts')
    @stack('scripts')
</body>

</html>
