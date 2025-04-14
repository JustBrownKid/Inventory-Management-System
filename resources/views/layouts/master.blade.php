<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  
  <title>@yield('title', 'Default Title')</title>

  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

  <script src="https://cdn.jsdelivr.net/npm/alpinejs@2.8.2/dist/alpine.min.js" defer></script>
</head>

<body class="bg-gray-100">
  <header class="md:hidden bg-gray-900 text-white flex justify-between items-center p-4">
    <h1 class="text-lg font-semibold">MyApp</h1>
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
        <a href="/dashboard" class="block py-2.5 px-4 rounded hover:bg-gray-700 transition">Product Create</a>
        <a href="/product/list" class="block py-2.5 px-4 rounded hover:bg-gray-700 transition">Product List</a>
        <a href="/category" class="block py-2.5 px-4 rounded hover:bg-gray-700 transition">Category Selection</a>
        <a href="/customer" class="block py-2.5 px-4 rounded hover:bg-gray-700 transition">Customer Create</a>
        <a href="/customer/list" class="block py-2.5 px-4 rounded hover:bg-gray-700 transition">Customer List</a>
        <a href="#" class="block py-2.5 px-4 rounded hover:bg-gray-700 transition">Logout</a>
      </nav>
    </div>

    <div class="flex-1 overflow-auto">
      @yield('content')
    </div>
  <
  <script>
    const toggleButton = document.getElementById('toggleSidebar');
    const sidebar = document.getElementById('sidebar');

    toggleButton.addEventListener('click', () => {
      sidebar.classList.toggle('-translate-x-full');
    });
  </script>

</body>
</html>
