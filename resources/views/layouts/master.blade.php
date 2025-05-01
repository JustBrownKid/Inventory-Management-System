<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  
  <title>@yield('title', 'Default Title')</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />

  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/alpinejs@2.8.2/dist/alpine.min.js" defer></script>
</head>

<body class="bg-gray-100">
  <header class="md:hidden bg-gray-900 text-white flex justify-between items-center p-4">
    <h1 class="text-lg font-semibold">My APP</h1>
    <button id="toggleSidebar" class="text-white focus:outline-none">
      <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
      </svg>
    </button>
  </header>
  <div class="flex h-screen overflow-hidden">
    <div id="sidebar" class="bg-gray-900 text-white w-64 space-y-6 py-7 px-4 absolute md:relative inset-y-0 left-0 transform -translate-x-full md:translate-x-0 transition duration-300 ease-in-out z-40">
      <div class="text-2xl font-bold">MyApp</div>
      <nav class="mt-10">
      @if(Auth::user()->role === 'superadmin')
        <!-- Super Admin Access -->
        <a href="/dashboard" class="block py-2.5 px-4 rounded hover:bg-gray-700 transition">Product Create</a>
        <a href="/product/list" class="block py-2.5 px-4 rounded hover:bg-gray-700 transition">Product List</a>
        <hr>
        <a href="/category" class="block py-2.5 px-4 rounded hover:bg-gray-700 transition">Category Selection</a>
        <hr>
        <a href="/customer" class="block py-2.5 px-4 rounded hover:bg-gray-700 transition">Customer Create</a>
        <a href="/customer/list" class="block py-2.5 px-4 rounded hover:bg-gray-700 transition">Customer List</a>
        <hr>
        <a href="/supplier" class="block py-2.5 px-4 rounded hover:bg-gray-700 transition">Supplier Create</a>
        <a href="/supplier/list" class="block py-2.5 px-4 rounded hover:bg-gray-700 transition">Supplier List</a>
        <hr>
        <a href="/purchases" class="block py-2.5 px-4 rounded hover:bg-gray-700 transition">Purchases Create</a>
        <a href="/purchases/list" class="block py-2.5 px-4 rounded hover:bg-gray-700 transition">Purchases List</a>
        <hr>
        <a href="/sales/create" class="block py-2.5 px-4 rounded hover:bg-gray-700 transition">Sales Create</a>
        <a href="/sales/list" class="block py-2.5 px-4 rounded hover:bg-gray-700 transition">Sales List</a>
        <hr>
        <a href="/graph" class="block py-2.5 px-4 rounded hover:bg-gray-700 transition">Graph</a>
        <hr>  
    @elseif(Auth::user()->role ==='admin')
        <!-- Admin Access -->
        <a href="/dashboard" class="block py-2.5 px-4 rounded hover:bg-gray-700 transition">Product Create</a>
        <a href="/product/list" class="block py-2.5 px-4 rounded hover:bg-gray-700 transition">Product List</a>
        <hr>
        <a href="/category" class="block py-2.5 px-4 rounded hover:bg-gray-700 transition">Category Selection</a>
        <hr>
        <a href="/customer" class="block py-2.5 px-4 rounded hover:bg-gray-700 transition">Customer Create</a>
        <a href="/customer/list" class="block py-2.5 px-4 rounded hover:bg-gray-700 transition">Customer List</a>
        <hr>
        <a href="/supplier" class="block py-2.5 px-4 rounded hover:bg-gray-700 transition">Supplier Create</a>
        <a href="/supplier/list" class="block py-2.5 px-4 rounded hover:bg-gray-700 transition">Supplier List</a>
        <hr>
        <a href="/purchases" class="block py-2.5 px-4 rounded hover:bg-gray-700 transition">Purchases Create</a>
        <a href="/purchases/list" class="block py-2.5 px-4 rounded hover:bg-gray-700 transition">Purchases List</a>
        <hr>
        <a href="/sales/create" class="block py-2.5 px-4 rounded hover:bg-gray-700 transition">Sales Create</a>
        <a href="/sales/list" class="block py-2.5 px-4 rounded hover:bg-gray-700 transition">Sales List</a>
        <hr>
    @elseif(Auth::user()->role ==='inventory')
        <a href="/customer" class="block py-2.5 px-4 rounded hover:bg-gray-700 transition">Customer Create</a>
        <a href="/customer/list" class="block py-2.5 px-4 rounded hover:bg-gray-700 transition">Customer List</a>
        <hr>
        <a href="/supplier" class="block py-2.5 px-4 rounded hover:bg-gray-700 transition">Supplier Create</a>
        <a href="/supplier/list" class="block py-2.5 px-4 rounded hover:bg-gray-700 transition">Supplier List</a>
        <hr>
        <a href="/purchases" class="block py-2.5 px-4 rounded hover:bg-gray-700 transition">Purchases Create</a>
        <a href="/purchases/list" class="block py-2.5 px-4 rounded hover:bg-gray-700 transition">Purchases List</a>
        <hr>
        <a href="/sales/create" class="block py-2.5 px-4 rounded hover:bg-gray-700 transition">Sales Create</a>
        <a href="/sales/list" class="block py-2.5 px-4 rounded hover:bg-gray-700 transition">Sales List</a>
        <hr>
    @endif
    <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <a :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
</a>
                        </form>
      </nav>
    </div>
    
    <div class="flex-1 overflow-auto bg-gray-200">
      @yield('content')
    </div>
  </div>

  <script>
    const toggleButton = document.getElementById('toggleSidebar');
    const sidebar = document.getElementById('sidebar');

    toggleButton.addEventListener('click', () => {
      sidebar.classList.toggle('-translate-x-full');
    });
  </script>

</body>
</html>
