<nav class="m-3 bg-white rounded-lg shadow">
    <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <a href="{{ url('/') }}" class="text-xl font-bold text-gray-700 hover:text-blue-600">MyApp</a>
            </div>

            <!-- Hamburger (mobile) -->
            <div class="flex items-center md:hidden">
                <button id="menu-toggle" class="text-gray-600 focus:outline-none focus:text-blue-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>

            <!-- Menu Items (desktop) -->
            {{-- <div class="hidden space-x-6 md:flex md:items-center">
                <a href="" class="text-gray-700 hover:text-blue-600">Dashboard</a>
                <a href="" class="text-gray-700 hover:text-blue-600">Weekly Report</a>

                @auth
                    <span class="text-gray-600">{{ Auth::user()->fullname }}</span>
                    <form action="" method="POST">
                        @csrf
                        <button type="submit" class="text-red-500 hover:underline">Logout</button>
                    </form>
                @else
                    <a href="" class="text-blue-500 hover:underline">Login</a>
                    <a href="" class="text-green-500 hover:underline">Register</a>
                @endauth
            </div> --}}
        </div>
    </div>

    <!-- Dropdown menu (mobile) -->
    <div id="mobile-menu" class="hidden px-4 pt-2 pb-4 space-y-2 md:hidden">
        <a href="" class="block text-gray-700 hover:text-blue-600">Dashboard</a>
        <a href="" class="block text-gray-700 hover:text-blue-600">Weekly Report</a>

        @auth
            <div class="text-gray-600">{{ Auth::user()->fullname }}</div>
            <form action="" method="POST">
                @csrf
                <button type="submit" class="text-red-500 hover:underline">Logout</button>
            </form>
        @else
            <a href="" class="block text-blue-500 hover:underline">Login</a>
            <a href="" class="block text-green-500 hover:underline">Register</a>
        @endauth
    </div>

    <!-- Script -->
    <script>
        document.getElementById('menu-toggle').addEventListener('click', function() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        });
    </script>
</nav>
