<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="theme-color" content="#146b64">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <link rel="manifest" href="{{ asset('manifest.webmanifest') }}">
    <link rel="apple-touch-icon" href="{{ asset('icon/pwa-192.png') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'SelfNote — Ruang untuk setiap ide')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="icon" href="{{ asset('icon/logo-tab-bg.png') }}">
    <script>try {const t=localStorage.getItem('theme');document.documentElement.classList.toggle('dark',t==='dark'||(!t&&matchMedia('(prefers-color-scheme: dark)').matches));}catch(e){}</script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('head')
</head>
<body class="app-body">
    <div class="app-shell">
        
        @include('layouts.aside')
        <div class="app-workspace">
            <header class="workspace-header">
                <div class="header-left">
                    <div class="header-breadcrumb"><span>Workspace</span><i class="fa-solid fa-chevron-right"></i><strong>@yield('page_label', 'Catatan')</strong></div>
                </div>
                <div class="header-right"><span id="pwaConnection" role="status" class="pwa-connection" aria-live="polite">Online</span><button type="button" id="pwaInstall" class="pwa-install" hidden>Install App</button><span class="header-private"><i class="fa-solid fa-pen-nib"></i> Ruang menulismu</span><span class="header-avatar" aria-hidden="true">S</span></div>
            </header>
            <main id="mainContent" class="workspace-main" tabindex="-1">@yield('content')</main>
        </div>
    </div>
    @include('layouts.mobile-nav')
    @include('layouts.scripts')
    @stack('scripts')
</body>
</html>
