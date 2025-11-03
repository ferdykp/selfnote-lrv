<!-- Floating Minimal Sidebar -->
<aside
    class="fixed inset-y-0 left-0 z-50 flex flex-col items-center justify-center w-20 space-y-6 transition-colors duration-300 bg-gray-100 dark:bg-gray-900">
    <!-- Dashboard -->
    <div class="relative group">
        <a href="#"
            class="flex items-center justify-center w-12 h-12 text-gray-800 transition-all duration-300 bg-gray-200 rounded-full shadow-md dark:text-gray-100 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600">
            <i class="text-lg fa-solid fa-gauge-high"></i>
        </a>
        <div
            class="absolute left-16 top-1/2 -translate-y-1/2 px-3 py-1 bg-gray-800 text-white text-sm rounded-md opacity-0 translate-x-[-10px] pointer-events-none transition-all duration-300 group-hover:opacity-100 group-hover:translate-x-0">
            Dashboard
        </div>
    </div>

    <!-- Profile -->
    <div class="relative group">
        <a href="#"
            class="flex items-center justify-center w-12 h-12 text-gray-800 transition-all duration-300 bg-gray-200 rounded-full shadow-md dark:text-gray-100 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600">
            <i class="text-lg fa-solid fa-user"></i>
        </a>
        <div
            class="absolute left-16 top-1/2 -translate-y-1/2 px-3 py-1 bg-gray-800 text-white text-sm rounded-md opacity-0 translate-x-[-10px] pointer-events-none transition-all duration-300 group-hover:opacity-100 group-hover:translate-x-0">
            Profile
        </div>
    </div>

    <!-- Settings -->
    <div class="relative group">
        <a href="#"
            class="flex items-center justify-center w-12 h-12 text-gray-800 transition-all duration-300 bg-gray-200 rounded-full shadow-md dark:text-gray-100 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600">
            <i class="text-lg fa-solid fa-gear"></i>
        </a>
        <div
            class="absolute left-16 top-1/2 -translate-y-1/2 px-3 py-1 bg-gray-800 text-white text-sm rounded-md opacity-0 translate-x-[-10px] pointer-events-none transition-all duration-300 group-hover:opacity-100 group-hover:translate-x-0">
            Settings
        </div>
    </div>

    <!-- Theme Toggle -->
    <div class="relative group">
        <button id="themeToggle"
            class="flex items-center justify-center w-12 h-12 text-gray-800 transition-all duration-300 bg-gray-200 rounded-full shadow-md dark:text-gray-100 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600">
            <i id="themeIcon" class="fa-solid fa-moon"></i>
        </button>
        <div
            class="absolute left-16 top-1/2 -translate-y-1/2 px-3 py-1 bg-gray-800 text-white text-sm rounded-md opacity-0 translate-x-[-10px] pointer-events-none transition-all duration-300 group-hover:opacity-100 group-hover:translate-x-0">
            Mode
        </div>
    </div>
</aside>

<!-- Dark Mode Script -->
<script>
    const toggle = document.getElementById('themeToggle');
    const icon = document.getElementById('themeIcon');
    const html = document.documentElement;

    // Apply saved theme
    if (localStorage.getItem('theme') === 'dark') {
        html.classList.add('dark');
        icon.classList.replace('fa-moon', 'fa-sun');
    }

    toggle.addEventListener('click', () => {
        html.classList.toggle('dark');
        const isDark = html.classList.contains('dark');
        localStorage.setItem('theme', isDark ? 'dark' : 'light');
        icon.classList.toggle('fa-moon', !isDark);
        icon.classList.toggle('fa-sun', isDark);
    });
</script>
