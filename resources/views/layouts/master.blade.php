<!DOCTYPE html>
<html lang="en" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @include('layouts.head')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @stack('head')
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
    {{-- Deteksi Tema Instan Sebelum Render Mencegah Efek Putih Berkedip --}}
    <script>
        if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia(
                '(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
</head>

<body
    class="h-full overflow-hidden transition-colors duration-300 bg-slate-50 text-slate-800 dark:bg-slate-950 dark:text-slate-50">

    <div class="flex h-screen overflow-hidden">
        {{-- Sidebar --}}
        @include('layouts.aside')

        {{-- Main Area Workspace --}}
        <div class="flex flex-col flex-1 min-w-0 pl-20 transition-all duration-300">

            {{-- Top Global Header --}}
            <header
                class="flex items-center justify-between px-8 transition-colors duration-300 border-b h-14 bg-white/80 border-slate-200/80 dark:border-slate-900 dark:bg-slate-950/50 backdrop-blur-md">
                <div class="flex items-center space-x-3">
                    <span
                        class="text-[11px] font-medium px-2.5 py-0.5 rounded-md bg-indigo-50 text-indigo-600 border border-indigo-100 dark:bg-indigo-950/60 dark:text-indigo-400 dark:border-indigo-900/50 tracking-wide">
                        Personal Workspace
                    </span>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="rounded-full shadow-sm w-7 h-7 bg-gradient-to-tr from-indigo-500 to-purple-500"></div>
                </div>
            </header>

            {{-- Main Content Window --}}
            <main
                class="flex-1 overflow-y-auto transition-colors duration-300 bg-slate-100/60 dark:bg-slate-950/40 focus:outline-none">
                @yield('content')
            </main>
        </div>
    </div>

    @include('layouts.scripts')
    @stack('scripts')
</body>

</html>
