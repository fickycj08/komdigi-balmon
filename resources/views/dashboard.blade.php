<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    @vite('resources/css/app.css')
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&display=swap" rel="stylesheet">
</head>

<body class="bg-[#DFF9FF]">
    <div class="flex">
        <!-- Tombol Hamburger untuk Mobile -->
        <button id="toggleSidebar" class="md:hidden fixed top-4 left-4 z-50 p-2 bg-[#70C1F3] rounded-lg">
            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
        </button>

        <!-- Sidebar -->
        <aside id="sidebar" class="fixed md:relative md:translate-x-0 transform -translate-x-full transition-transform duration-300 ease-in-out w-64 bg-white h-screen p-4 flex flex-col z-40">
            <div class="flex-1 overflow-y-auto">
                <!-- Logo -->
                <a href="#" class="flex items-center ps-2.5 pl-[41px] pt-[18px] pb-[74px]">
                    <img src="/images/logo_kominfo.png" 
                         class="h-[145px] w-[145px] me-3 sm:h-[145px] sm:w-[145px]" 
                         alt="Logo Kominfo" />
                </a>
                
                <!-- Menu -->
                <ul class="space-y-2 font-medium">
                <li class="h-[20px] w-[215px] pl-[20px] pr-[10px]">
                        <a href="#"
                            class="flex items-center p-2 pl-[20px] bg-[#70C1F3] text-gray-900 rounded-lg hover:bg-[#70C1F3] group">
                            <x-heroicon-s-home class="w-6 h-6 text-green-50" />
                            <span class="ms-3 font-bold text-[22px] text-green-50">Beranda</span>
                        </a>
                    </li>
                    <div class="ms-3 text-[22px] pt-[60px] pb-[20px] text-zinc-600">Menu Layanan</div>
                    <li>
                        <a href="#"
                            class="flex items-center p-2 px-[20px] text-gray-900 rounded-lg hover:bg-[#70C1F3] group">
                            <x-heroicon-o-computer-desktop class="w-6 h-6" />
                            <span class="ms-3 text-[26px] text-stone-950">Monitoring</span>
                        </a>
                    </li>
                    <li class="pt-[10px]">
                        <a href="#"
                            class="flex items-center p-2 px-[20px] text-gray-900 rounded-lg hover:bg-[#70C1F3] group">
                            <x-heroicon-o-arrow-trending-up class="w-6 h-6" />
                            <span class="ms-3 text-[26px] text-stone-950">Pengukuran</span>
                        </a>
                    </li>
                    <li class="pt-[10px]">
                        <a href="{{ route('gangguan.index') }}"
                            class="flex items-center p-2 px-[20px] text-gray-900 rounded-lg hover:bg-[#70C1F3] group">
                            <x-heroicon-s-exclamation-triangle class="w-6 h-6" />
                            <span class="ms-3 text-[26px] text-stone-950">Gangguan</span>
                        </a>
                    </li>
                    <li class="pt-[15px]">
                        <a href="#"
                            class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-[#70C1F3] group">
                            <x-heroicon-o-key class="w-6 h-6 text-stone-950" />
                            <span class="flex-1 ms-3 whitespace-nowrap text-[22px] text-stone-950">Edit Menu</span>
                            <span class="inline-flex items-center justify-center px-2 ms-3 text-sm font-medium text-gray-800 bg-gray-100 rounded-full">Admin</span>
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Tombol Logout -->
            <div class="p-4">
                <a href="#"
                    class="flex items-center p-2 px-[30px] bg-[#FF0000] text-white rounded-lg hover:bg-red-600 group">
                    <x-heroicon-s-exclamation-triangle class="w-6 h-6 text-white" />
                    <span class="ms-3 text-[22px] text-white font-bold">Log-Out</span>
                </a>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 md:ml-64 p-8 min-h-screen">
            
        </main>
    </div>

    <!-- Script untuk Toggle Sidebar -->
    <script>
        const sidebar = document.getElementById('sidebar');
        const toggleButton = document.getElementById('toggleSidebar');

        // Toggle sidebar
        toggleButton.addEventListener('click', () => {
            sidebar.classList.toggle('-translate-x-full');
        });

        // Close sidebar ketika klik di luar area sidebar (mobile)
        document.addEventListener('click', (event) => {
            if (window.innerWidth < 768) {
                const isClickInside = sidebar.contains(event.target);
                const isToggleButton = toggleButton.contains(event.target);
                
                if (!isClickInside && !isToggleButton && !sidebar.classList.contains('-translate-x-full')) {
                    sidebar.classList.add('-translate-x-full');
                }
            }
        });

        // Responsif saat resize window
        window.addEventListener('resize', () => {
            if (window.innerWidth >= 768) {
                sidebar.classList.remove('-translate-x-full');
            } else {
                sidebar.classList.add('-translate-x-full');
            }
        });
    </script>
</body>
</html>