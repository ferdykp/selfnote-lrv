<!DOCTYPE html>
<html lang="en">

<head>
    @include('layouts.head')
    @stack('head')
</head>

<body class="flex min-h-screen font-serif bg-gray-100">
    {{-- Sidebar --}}
    @include('layouts.aside')

    {{-- Main Layout --}}
    <div class="flex flex-col flex-1 min-h-screen transition-all duration-300">
        @include('layouts.navbar')

        <main class="flex-1">
            @yield('content')
        </main>
    </div>

    @include('layouts.scripts')
    @stack('scripts')
</body>

</html>
