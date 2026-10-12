{{-- Mobile/PWA native-style navigation. Only real routes and working actions are exposed. --}}
<nav class="mobile-bottom-nav" aria-label="Navigasi mobile utama">
    <a href="{{ route('content.index') }}" class="mobile-tab {{ request()->routeIs('home', 'content.index', 'content.edit', 'content.show', 'content.revisions') ? 'is-active' : '' }}" @if(request()->routeIs('home', 'content.index', 'content.edit', 'content.show', 'content.revisions')) aria-current="page" @endif>
        <i class="fa-regular fa-note-sticky" aria-hidden="true"></i><span>Catatan</span>
    </a>
    <a href="{{ asset('offline.html') }}" class="mobile-tab" aria-label="Quick Capture offline">
        <i class="fa-solid fa-bolt" aria-hidden="true"></i><span>Capture</span>
    </a>
    <a href="{{ route('content.create') }}" class="mobile-tab mobile-tab-compose {{ request()->routeIs('content.create') ? 'is-active' : '' }}" aria-label="Tulis catatan baru" @if(request()->routeIs('content.create')) aria-current="page" @endif>
        <span class="mobile-compose-icon"><i class="fa-solid fa-plus" aria-hidden="true"></i></span><span>Tulis</span>
    </a>
    <a href="{{ route('content.trash') }}" class="mobile-tab {{ request()->routeIs('content.trash') ? 'is-active' : '' }}" @if(request()->routeIs('content.trash')) aria-current="page" @endif>
        <i class="fa-regular fa-trash-can" aria-hidden="true"></i><span>Sampah</span>
    </a>
    <button type="button" id="mobileThemeToggle" class="mobile-tab" aria-label="Ganti tema tampilan" aria-pressed="false">
        <i id="mobileThemeIcon" class="fa-solid fa-moon" aria-hidden="true"></i><span id="mobileThemeLabel">Tema</span>
    </button>
</nav>
