<nav class="sticky top-0 bg-white border-b border-gray-200 z-50">
  <div class="max-w-7xl mx-auto px-5 h-16 flex items-center justify-between">
    <!-- Brand -->
    <div class="flex items-center">
      <a href="/" class="flex items-center text-gray-800 font-bold text-xl no-underline">
      <img src="/logo.png" alt="UrbanNest Logo" class="w-6 h-6 mr-2 object-contain" />  
        UrbanNest
      </a>
    </div>

    <!-- Nav Links -->
    <ul class="hidden md:flex space-x-8 text-gray-600">
      <li><a href="/cariproperti" class="hover:text-gray-900 transition">Properties</a></li>
      <li><a href="/services" class="hover:text-gray-900 transition">Services</a></li>
      <li><a href="/about" class="hover:text-gray-900 transition">About</a></li>
      <li><a href="/contact" class="hover:text-gray-900 transition">Contact</a></li>
    </ul>

    <!-- Actions -->
    <div class="hidden md:flex space-x-4 items-center">
        @guest
            <a href="{{ route('login') }}" class="text-gray-600 hover:text-gray-900 transition text-sm font-medium">Log in</a>
            <a href="{{ route('signup') }}" class="bg-blue-600 hover:bg-blue-700 text-white rounded px-4 py-2 text-sm font-semibold transition">
              Sign up
            </a>
        @endguest

        @auth
        <div class="relative inline-block text-left group">
        <button class="flex items-center space-x-1 text-gray-800 text-sm font-medium focus:outline-none px-4 py-2">
            <span>Hello, {{ Auth::user()->name }}</span>
            <svg class="w-4 h-4 mt-[1px]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
            </svg>
        </button>

          <!-- Dropdown -->
          <div
            class="absolute w-40 bg-white border border-gray-200 rounded-lg shadow-lg opacity-0 invisible
                  group-hover:visible group-hover:opacity-100 transition-opacity duration-150 z-50"
            style="pointer-events: auto;"
          >
            <a href="/#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile</a>
            <a href="/favorite" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Favorite</a>
            <a href="/transactions" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">History</a>
            <form action="{{ route('logout') }}" method="POST">
              @csrf
              <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100">Logout</button>
            </form>
          </div>
        </div>
        @endauth
    </div>

    <!-- Mobile menu button (optional, buat nanti kalo mau responsive) -->
    <button class="md:hidden text-gray-600 focus:outline-none">
      <!-- icon hamburger bisa dimasukin sini nanti -->
      <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <path d="M4 6h16M4 12h16M4 18h16"/>
      </svg>
    </button>
  </div>
</nav>