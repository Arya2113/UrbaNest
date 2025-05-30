<nav class="sticky top-0 bg-white border-b border-gray-200 z-50">
  <div class="max-w-7xl mx-auto px-5 h-16 flex items-center justify-between">
    <!-- Brand -->
    <div class="flex items-center">
      <a href="/" class="flex items-center text-gray-800 font-bold text-xl no-underline">
        <span class="w-6 h-6 bg-gray-300 rounded-full mr-2"></span>
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
            <span class="text-gray-800 text-sm font-medium">Hello, {{ Auth::user()->name }}</span>
             <form action="{{ route('logout') }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="text-red-600 hover:text-red-800 transition text-sm font-medium cursor-pointer">Logout</button>
            </form>
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