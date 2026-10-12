<aside id="appSidebar" class="app-sidebar" aria-label="Navigasi utama">
    <a href="{{ route('content.index') }}" class="brand" aria-label="SelfNote, ke semua catatan">
        <span class="brand-symbol"><i class="fa-solid fa-book-open"></i></span>
        <span class="brand-copy"><strong>selfnote<span> /</span></strong><small>WORKSPACE FOR IDEAS</small></span>
    </a>
    <div class="sidebar-content">
        <div class="sidebar-section-label">PUSTAKA</div>
        <nav class="sidebar-nav">
            <a href="{{ route('content.index') }}" class="nav-link {{ request()->routeIs('home', 'content.index') ? 'is-active' : '' }}" @if(request()->routeIs('home', 'content.index')) aria-current="page" @endif><i class="fa-regular fa-note-sticky"></i><span>Semua catatan</span></a>
            <a href="{{ route('content.create') }}" class="nav-link {{ request()->routeIs('content.create') ? 'is-active' : '' }}" @if(request()->routeIs('content.create')) aria-current="page" @endif><i class="fa-solid fa-plus"></i><span>Tulis catatan</span></a>
            <a href="{{ asset('offline.html') }}" class="nav-link"><i class="fa-solid fa-bolt"></i><span>Quick Capture</span></a>
            <a href="{{ route('content.trash') }}" class="nav-link {{ request()->routeIs('content.trash') ? 'is-active' : '' }}" @if(request()->routeIs('content.trash')) aria-current="page" @endif><i class="fa-regular fa-trash-can"></i><span>Sampah</span></a>
        </nav>
        <div class="sidebar-helper"><span class="helper-icon"><i class="fa-regular fa-lightbulb"></i></span><strong>Setiap ide punya tempat.</strong><p>Tulis hal penting dengan nyaman. Semua tersimpan di ruangmu.</p><a href="{{ route('content.create') }}">Mulai menulis <i class="fa-solid fa-arrow-right"></i></a></div>
    </div>
    <div class="sidebar-bottom"><button id="themeToggle" class="theme-button" type="button" aria-label="Ubah tema"><i id="themeIcon" class="fa-solid fa-moon"></i><span id="themeLabel">Mode gelap</span><i class="fa-solid fa-arrow-right-arrow-left theme-end"></i></button><div class="sidebar-version">SELFNOTE <span>·</span> PERSONAL WORKSPACE</div></div>
</aside>
