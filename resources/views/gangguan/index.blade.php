<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Gangguan Page</title>
  @vite('resources/css/app.css')
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />
  <!-- Leaflet CSS -->
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin="" />
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
  <style>
    body {
      font-family: 'Inter', sans-serif;
    }

    /* Custom Scrollbar */
    ::-webkit-scrollbar {
      width: 8px;
      height: 8px;
    }

    ::-webkit-scrollbar-track {
      background: #f1f5f9;
      border-radius: 10px;
    }

    ::-webkit-scrollbar-thumb {
      background: #94a3b8;
      border-radius: 10px;
    }

    ::-webkit-scrollbar-thumb:hover {
      background: #64748b;
    }

    /* Table Row Hover Effect */
    tbody tr {
      transition: transform 0.15s ease;
    }

    tbody tr:hover {
      transform: translateY(-2px);
      box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
      z-index: 10;
      position: relative;
    }

    /* Custom Severity Colors */
    .High {
      background-color: #fee2e2;
      color: #b91c1c;
      padding: 2px 8px;
      border-radius: 9999px;
      font-weight: 600;
    }

    .Medium {
      background-color: #ffedd5;
      color: #c2410c;
      padding: 2px 8px;
      border-radius: 9999px;
      font-weight: 600;
    }

    .Low {
      background-color: #ecfccb;
      color: #3f6212;
      padding: 2px 8px;
      border-radius: 9999px;
      font-weight: 600;
    }

    /* Button Transitions */
    button,
    a.bg-blue-500,
    a.bg-green-500 {
      transition: all 0.2s ease;
    }

    button:hover,
    a.bg-blue-500:hover,
    a.bg-green-500:hover {
      transform: translateY(-2px);
    }

    /* Table Animation */
    @keyframes fadeIn {
      0% {
        opacity: 0;
        transform: translateY(10px);
      }

      100% {
        opacity: 1;
        transform: translateY(0);
      }
    }

    #tableContainer {
      animation: fadeIn 0.5s ease-out forwards;
    }

    /* Map Animation */
    @keyframes fadeInMap {
      0% {
        opacity: 0;
      }

      100% {
        opacity: 1;
      }
    }

    #mapContainer {
      animation: fadeInMap 0.5s ease-out forwards;
    }

    /* CSS Menu Gangguan START */
#detailModal {
    animation: modalEnter 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
    z-index: 10000;
  }

  @keyframes modalEnter {
    from {
      opacity: 0;
      transform: translateY(30px) scale(0.95);
    }

    to {
      opacity: 1;
      transform: translateY(0) scale(1);
    }
  }

  /* Backdrop blur yang lebih halus */
  #detailModal {
    backdrop-filter: blur(8px);
  }

  /* Desain Modal Container */
  #detailModal .bg-gradient-to-br {
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    border: 1px solid rgba(255, 255, 255, 0.3);
  }

  /* Header Modal dengan Efek Gelombang */
  #detailModal .bg-gradient-to-r {
    position: relative;
    overflow: hidden;
  }

  #detailModal .bg-gradient-to-r:before {
    content: '';
    position: absolute;
    top: -50%;
    left: -50%;
    width: 200%;
    height: 200%;
    background: radial-gradient(circle, rgba(255, 255, 255, 0.2) 0%, transparent 50%);
    animation: ripple 15s infinite linear;
    z-index: 0;
  }

  @keyframes ripple {
    0% {
      transform: rotate(0deg);
    }

    100% {
      transform: rotate(360deg);
    }
  }

  #detailModal .bg-gradient-to-r>* {
    position: relative;
    z-index: 1;
  }

  /* Icon Container dalam Header */
  #detailModal .bg-white\/20 {
    backdrop-filter: blur(4px);
    box-shadow: 0 0 15px rgba(255, 255, 255, 0.3);
    animation: pulse 2s infinite;
  }

  @keyframes pulse {
    0% {
      transform: scale(1);
    }

    50% {
      transform: scale(1.05);
    }

    100% {
      transform: scale(1);
    }
  }

  /* Card Styling */
  #detailModal .bg-white\/80 {
    background: rgba(255, 255, 255, 0.85);
    backdrop-filter: blur(5px);
    border: 1px solid rgba(255, 255, 255, 0.5);
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05);
    transition: all 0.3s ease;
  }

  #detailModal .bg-white\/80:hover {
    transform: translateY(-3px);
    box-shadow: 0 15px 20px -3px rgba(0, 0, 0, 0.1);
  }

  /* Label Styling */
  #detailModal label.text-sm {
    position: relative;
    padding-left: 12px;
    font-weight: 600;
    letter-spacing: 0.5px;
  }

  #detailModal label.text-sm:before {
    content: '';
    position: absolute;
    left: 0;
    top: 50%;
    height: 100%;
    width: 4px;
    background: #006DB0;
    transform: translateY(-50%);
    border-radius: 2px;
  }

  /* Severity Badge dengan Efek Glow */
  #modalSeverity {
    display: inline-block;
    padding: 0.25rem 0.75rem;
    border-radius: 9999px;
    text-transform: uppercase;
    font-size: 0.75rem;
    font-weight: bold;
    letter-spacing: 1px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
  }

  #modalSeverity.High {
    background: linear-gradient(135deg, #fecaca 0%, #fee2e2 100%);
    color: #dc2626;
    box-shadow: 0 0 15px rgba(220, 38, 38, 0.2);
    animation: glowRed 2s infinite alternate;
  }

  #modalSeverity.Medium {
    background: linear-gradient(135deg, #fef08a 0%, #fef9c3 100%);
    color: #ca8a04;
    box-shadow: 0 0 15px rgba(202, 138, 4, 0.2);
    animation: glowYellow 2s infinite alternate;
  }

  #modalSeverity.Low {
    background: linear-gradient(135deg, #bbf7d0 0%, #dcfce7 100%);
    color: #16a34a;
    box-shadow: 0 0 15px rgba(22, 163, 74, 0.2);
    animation: glowGreen 2s infinite alternate;
  }

  @keyframes glowRed {
    0% {
      box-shadow: 0 0 5px rgba(220, 38, 38, 0.2);
    }

    100% {
      box-shadow: 0 0 15px rgba(220, 38, 38, 0.4);
    }
  }

  @keyframes glowYellow {
    0% {
      box-shadow: 0 0 5px rgba(202, 138, 4, 0.2);
    }

    100% {
      box-shadow: 0 0 15px rgba(202, 138, 4, 0.4);
    }
  }

  @keyframes glowGreen {
    0% {
      box-shadow: 0 0 5px rgba(22, 163, 74, 0.2);
    }

    100% {
      box-shadow: 0 0 15px rgba(22, 163, 74, 0.4);
    }
  }

  /* Frekuensi Display */
  #detailModal #modalFrekuensi {
    background: linear-gradient(135deg, #378EC3 0%, #70C1F3 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    font-size: 1.75rem;
    font-weight: 800;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  }

  /* Section Pengganggu dengan Efek Khusus */
  #detailModal .bg-red-50\/80 {
    background: linear-gradient(135deg, rgba(254, 226, 226, 0.9) 0%, rgba(254, 202, 202, 0.8) 100%);
    border-left: 5px solid #dc2626;
    box-shadow: 0 10px 15px -3px rgba(220, 38, 38, 0.1);
    position: relative;
    overflow: hidden;
  }

  #detailModal .bg-red-50\/80:before {
    content: '';
    position: absolute;
    top: 0;
    right: 0;
    width: 100px;
    height: 100px;
    background: radial-gradient(circle, rgba(254, 202, 202, 0.8) 0%, transparent 70%);
    z-index: 0;
  }

  /* Footer Styling */
  #detailModal .bg-gray-50 {
    background: linear-gradient(to top, #f9fafb 0%, #f3f4f6 100%);
    border-top: 1px solid rgba(0, 0, 0, 0.05);
  }

  #detailModal button,
  #detailModal a {
    transition: all 0.3s ease;
    transform: translateY(0);
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
  }

  #detailModal button:hover,
  #detailModal a:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
  }

  /* Export Button dengan Efek Khusus */
  #detailModal a.bg-\[\#EDBC1B\] {
    background: linear-gradient(135deg, #EDBC1B 0%, #ffd700 100%);
    position: relative;
    overflow: hidden;
  }

  #detailModal a.bg-\[\#EDBC1B\]:before {
    content: '';
    position: absolute;
    top: -50%;
    left: -50%;
    width: 200%;
    height: 200%;
    background: radial-gradient(circle, rgba(255, 255, 255, 0.3) 0%, transparent 60%);
    transform: rotate(45deg);
    transition: all 0.5s ease;
  }

  #detailModal a.bg-\[\#EDBC1B\]:hover:before {
    transform: rotate(90deg);
  }

  /* Animasi untuk Icon */
  #detailModal svg {
    transition: all 0.3s ease;
  }

  #detailModal svg:hover {
    transform: scale(1.2);
  }

  /* Efek Hover untuk Text Fields */
  #detailModal p.font-medium {
    transition: all 0.2s ease;
    padding: 2px 0;
  }

  #detailModal p.font-medium:hover {
    background-color: rgba(55, 142, 195, 0.1);
    border-radius: 4px;
    padding: 2px 4px;
    margin: 0 -4px;
  }

  /* Scrollbar Styling */
  #detailModal .max-h-\[90vh\]::-webkit-scrollbar {
    width: 8px;
  }

  #detailModal .max-h-\[90vh\]::-webkit-scrollbar-track {
    background: rgba(241, 245, 249, 0.5);
    border-radius: 10px;
  }

  #detailModal .max-h-\[90vh\]::-webkit-scrollbar-thumb {
    background: rgba(55, 142, 195, 0.5);
    border-radius: 10px;
  }

  #detailModal .max-h-\[90vh\]::-webkit-scrollbar-thumb:hover {
    background: rgba(55, 142, 195, 0.7);
  }

  /* Efek Hover untuk Card */
  .bg-white\/80:hover {
    transform: translateY(-2px);
    transition: all 0.2s ease;
  }

  header {
    background: linear-gradient(135deg, #378ec3 0%, #70c1f3 100%);
    padding: 1.5rem;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
  }

  header h1 {
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
    font-size: 1.8rem;
    letter-spacing: 4px;
  }

  aside {
    transition: all 0.3s ease;
    box-shadow: 4px 0 15px rgba(0, 0, 0, 0.1);
  }

  aside:hover {
    transform: translateX(5px);
  }

  .menu-item {
    transition: all 0.2s ease;
  }

  .menu-item:hover {
    transform: scale(1.05);
  }

  .filter-container {
    background: linear-gradient(to right, #fff, #f8f9fa);
    border-radius: 12px;
    padding: 1.5rem;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
  }

  select {
    transition: all 0.3s ease;
    border-radius: 8px;
    border: 2px solid #e2e8f0;
  }

  select:hover {
    border-color: #70c1f3;
  }

  .toggle-button {
    background: linear-gradient(135deg, #edbc1b 0%, #ffd700 100%);
    transition: all 0.3s ease;
    transform: scale(1);
  }

  .toggle-button:hover {
    transform: scale(1.05);
    box-shadow: 0 4px 15px rgba(237, 188, 27, 0.3);
  }

  .table-container {
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
  }

  table thead th {
    background: linear-gradient(135deg, #378ec3 0%, #70c1f3 100%);
    color: white;
    font-weight: 600;
  }

  table tbody tr:hover {
    background-color: #f0f9ff;
    transform: scale(1.01);
    transition: all 0.2s ease;
  }

  .loading-animation {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(255, 255, 255, 0.9);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 9999;
  }

  .spinner {
    width: 50px;
    height: 50px;
    border: 5px solid #f3f3f3;
    border-top: 5px solid #378ec3;
    border-radius: 50%;
    animation: spin 1s linear infinite;
  }

  @keyframes spin {
    0% {
      transform: rotate(0deg);
    }

    100% {
      transform: rotate(360deg);
    }
  }

  #mapContainer {
    box-sizing: border-box;
    position: relative;
    overflow: hidden;
    width: 100%;
    height: 60vh;
    z-index: 10;
  }

  #map {
    width: 100%;
    height: 100%;
    border-radius: 0.5rem;
  }

  /* Responsive Styles */
  @media (max-width: 768px) {
    #mapContainer {
      height: 50vh;
    }

    .main-content {
      padding: 1rem;
      margin-left: 0;
    }

    #toggleButtons {
      justify-content: center;
    }

    #toggleButtons button {
      font-size: 0.875rem;
      padding: 0.5rem 1rem;
    }
  }

  /* CSS Menu Gangguan END */
  </style>
</head>

<body class="bg-gradient-to-br from-[#e0f2fe] to-[#DFF9FF]">
  <div class="loading-animation">
    <div class="spinner"></div>
  </div>

  <!-- HEADER -->
  <header
    class="fixed top-0 left-0 w-full bg-gradient-to-r from-[#378EC3] to-[#70C1F3] text-white shadow-lg p-4 flex flex-col justify-center items-center font-[Inter] font-bold tracking-[4px] z-50">
    <div class="container mx-auto flex items-center justify-center space-x-3">
      
      <div class="text-center">
        <h1 class="text-xl md:text-2xl font-bold mb-1">BALAI MONITORING</h1>
        <h1 class="text-xl md:text-2xl font-bold">SPEKTRUM FREKUENSI RADIO KELAS 1 BANDUNG</h1>
      </div>
    </div>
  </header>

  <div class="flex">
    <!-- Tombol Hamburger untuk Mobile -->
    <button id="toggleSidebar" class="md:hidden fixed top-4 left-4 z-50 p-2 bg-[#70C1F3] rounded-lg">
      <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
      </svg>
    </button>

    <!-- Sidebar -->
    <aside id="sidebar"
      class="fixed md:relative md:translate-x-0 transform -translate-x-full transition-transform duration-300 ease-in-out w-64 bg-white min-h-screen p-4 flex flex-col z-40 shadow-xl pt-[130px]">

      <div class="flex-1 overflow-y-auto custom-scrollbar">
        <!-- Logo -->
        <a href="#" class="flex justify-center items-center p-2 mb-8 mt-2">
          <img src="/images/logo_kominfo.png" class="h-[100px] w-auto transition-transform hover:scale-105"
            alt="Logo Kominfo" />
        </a>

        <!-- Menu -->
        <nav>
          

          <ul class="space-y-1 px-2">
            

            <div class="px-2 py-2 mb-1">
              <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Menu Layanan</h3>
            </div>

            <li>
              <a href="{{ route('monitoring.index') }}"
                class="flex items-center p-3 text-gray-700 rounded-xl hover:bg-blue-50 group transition-colors">
                <div class="flex items-center justify-center w-8 h-8 text-indigo-600 bg-indigo-100 rounded-lg mr-3">
                  <x-heroicon-o-computer-desktop class="w-5 h-5" />
                </div>
                <span class="text-base font-medium">Monitoring</span>
              </a>
            </li>

            <li>
              <a href="{{ route('pengukuran.index') }}"
                class="flex items-center p-3 text-gray-700 rounded-xl hover:bg-blue-50 group transition-colors">
                <div class="flex items-center justify-center w-8 h-8 text-emerald-600 bg-emerald-100 rounded-lg mr-3">
                  <x-heroicon-o-arrow-trending-up class="w-5 h-5" />
                </div>
                <span class="text-base font-medium">Pengukuran FM</span>
              </a>
            </li>

            <li>
              <a href="#"
                class="flex items-center p-3 text-white rounded-xl bg-gradient-to-r from-[#378EC3] to-[#70C1F3] shadow-md group">
                <div class="flex items-center justify-center w-8 h-8 bg-white/20 backdrop-blur-sm rounded-lg mr-3">
                  <x-heroicon-s-exclamation-triangle class="w-5 h-5 text-white" />
                </div>
                <span class="text-base font-medium">Gangguan</span>
              </a>
            </li>
          </ul>

          <div class="border-t border-gray-100 my-4"></div>

          <ul class="space-y-1 px-2">
            <li>
              <a href="/admin"
                class="flex items-center justify-between p-3 text-gray-700 rounded-xl hover:bg-gray-100 group transition-colors">
                <div class="flex items-center">
                  <div class="flex items-center justify-center w-8 h-8 text-amber-600 bg-amber-100 rounded-lg mr-3">
                    <x-heroicon-o-key class="w-5 h-5" />
                  </div>
                  <span class="text-base font-medium">Edit Menu</span>
                </div>
                <span
                  class="inline-flex items-center justify-center px-2 py-1 text-xs font-medium text-white bg-gray-700 rounded-md">
                  Admin
                </span>
              </a>
            </li>
          </ul>
        </nav>
      </div>

      <!-- Tombol Logout -->
      <form id="logoutForm" action="{{ route('logout') }}" method="POST" class="inline">
    @csrf
    <button type="submit"
        class="flex items-center justify-center p-3 bg-gradient-to-r from-red-600 to-red-500 text-white rounded-xl shadow-md hover:from-red-700 hover:to-red-600 transition-all transform hover:-translate-y-1 w-full">
        <x-heroicon-s-arrow-right-on-rectangle class="w-5 h-5 mr-2" />
        <span class="text-base font-medium">Logout</span>
    </button>
</form>
 
    </aside>

    <!-- Ubah bagian Main Content -->
    <main class="flex-1 p-8 min-h-screen main-content md:ml-[100px] md:mr-[100px] pt-[130px]">
      <!-- Container untuk Filter -->
      <div class="bg-white shadow-lg rounded-lg p-6 mb-6 border border-gray-100">
        <div class="flex items-center justify-between mb-4">
          <h2 class="text-xl text-[#006DB0] font-bold flex items-center">
            <x-heroicon-s-funnel class="w-5 h-5 mr-2" />
            Filter Data
          </h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div class="relative">
            <label for="filterKota" class="block text-gray-700 text-sm font-medium mb-2">Lokasi / Kota:</label>
            <div class="relative">
              <select id="filterKota"
                class="block w-full bg-gray-50 border border-gray-300 text-gray-700 py-3 px-4 pr-8 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 appearance-none transition-colors">
                <option value="">Semua Lokasi</option>
                @foreach ($locations as $kota)
          <option value="{{ $kota }}">{{ $kota }}</option>
        @endforeach
              </select>
              <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                <x-heroicon-s-chevron-down class="w-5 h-5" />
              </div>
            </div>
          </div>

          <div class="relative">
            <label for="filterTahun" class="block text-gray-700 text-sm font-medium mb-2">Tahun Kejadian:</label>
            <div class="relative">
              <select id="filterTahun"
                class="block w-full bg-gray-50 border border-gray-300 text-gray-700 py-3 px-4 pr-8 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 appearance-none transition-colors">
                <option value="">Semua Tahun</option>
                @for ($tahun = date('Y'); $tahun >= 2000; $tahun--)
          <option value="{{ $tahun }}">{{ $tahun }}</option>
        @endfor
              </select>
              <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                <x-heroicon-s-chevron-down class="w-5 h-5" />
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Container untuk Maps dan Buttons -->
      <div class="bg-white shadow-lg rounded-lg p-6 mb-6 border border-gray-100">
        <!-- Toggle Buttons -->
        <div class="flex justify-between items-center mb-4">
          <h2 class="text-xl text-[#006DB0] font-bold flex items-center">
            <x-heroicon-s-map class="w-5 h-5 mr-2" />
            Visualisasi Data
          </h2>

          <div class="relative flex items-center space-x-3" id="toggleButtons">
  <button id="showMap"
    class="relative px-5 py-2.5 bg-[#EDBC1B] text-white rounded-lg transition-all duration-200 font-medium flex items-center shadow-md hover:shadow-lg transform hover:translate-y-[-2px] group"
    type="button">
    <x-heroicon-s-globe-alt class="w-5 h-5 mr-2" />
    Tampilkan Maps
    <!-- Tooltip -->
    <span class="absolute left-1/2 bottom-full mb-3 -translate-x-1/2 px-3 py-2 bg-black text-xs text-white rounded-md opacity-0 group-hover:opacity-100 transition pointer-events-none whitespace-nowrap z-20 shadow-lg">
      Visualisasi data gangguan di peta interaktif
    </span>
  </button>
  <button id="showTable"
    class="relative px-5 py-2.5 bg-[#006DB0] text-white rounded-lg transition-all duration-200 font-medium flex items-center shadow-md hover:shadow-lg transform hover:translate-y-[-2px] group"
    type="button">
    <x-heroicon-s-table-cells class="w-5 h-5 mr-2" />
    Tampilkan Data Tabel
    <!-- Tooltip -->
    <span class="absolute left-1/2 bottom-full mb-3 -translate-x-1/2 px-3 py-2 bg-black text-xs text-white rounded-md opacity-0 group-hover:opacity-100 transition pointer-events-none whitespace-nowrap z-20 shadow-lg">
      Lihat data gangguan dalam bentuk tabel
    </span>
  </button>
</div>

        </div>

        <!-- Map Container -->
        <div id="mapContainer" class="rounded-xl overflow-hidden shadow-inner border border-gray-200">
          <div id="map" class="w-full h-[500px] rounded-xl"></div>

        </div>

        <!-- Table Container -->
        <div id="tableContainer" class="bg-white shadow-lg rounded-lg p-6 table-container overflow-hidden">
          <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl md:text-3xl font-bold text-[#006DB0]">Daftar Gangguan</h1>
            <div class="flex space-x-2">
           
             
            </div>
          </div>

          <div class="overflow-hidden rounded-xl shadow-md border border-gray-100"> 
            <div class="overflow-x-auto">
              <table class="w-full border-collapse">
                <thead>
                  <tr class="bg-gradient-to-r from-[#378EC3] to-[#70C1F3] text-white">
                    <th class="p-3 text-left font-semibold text-sm md:text-base">Nama Client</th>
                    <th class="p-3 text-left font-semibold text-sm md:text-base">Lokasi</th>
                    <th class="p-3 text-left font-semibold text-sm md:text-base">Frekuensi</th>
                    <th class="p-3 text-left font-semibold text-sm md:text-base">No ST</th>
                    <th class="p-3 text-left font-semibold text-sm md:text-base">PIC</th>
                    <th class="p-3 text-left font-semibold text-sm md:text-base">No Laporan</th>
                    <th class="p-3 text-left font-semibold text-sm md:text-base hidden md:table-cell">Band</th>
                    <th class="p-3 text-left font-semibold text-sm md:text-base hidden lg:table-cell">Sub-Service</th>
                    <th class="p-3 text-left font-semibold text-sm md:text-base">Jenis</th>
                    <th class="p-3 text-left font-semibold text-sm md:text-base hidden xl:table-cell">Koordinat</th>
                    <th class="p-3 text-left font-semibold text-sm md:text-base">Uraian</th>
                    <th class="p-3 text-left font-semibold text-sm md:text-base">Waktu Kejadian</th>
                    <th class="p-3 text-center font-semibold text-sm md:text-base">Aksi</th>
                    <th class="p-3 text-center font-semibold text-sm md:text-base">File</th>
                  </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                  @foreach ($gangguan as $index => $item)
                  <tr class="hover:bg-blue-50 transition-colors {{ $index % 2 == 0 ? 'bg-white' : 'bg-gray-50' }}">
                  <td class="p-3 text-sm md:text-base">
                    <div class="font-medium text-gray-800">{{ $item->nama_client }}</div>
                  </td>
                  <td class="p-3 text-sm md:text-base">
                    <div class="flex items-center">
                    <x-heroicon-s-map-pin class="w-4 h-4 text-red-500 mr-1 flex-shrink-0" />
                    <span>{{ $item->location->kota ?? 'N/A' }}</span>
                    </div>
                  </td>
                  <td class="p-3 text-sm md:text-base">
                    <div class="font-mono">{{ $item->frekuensi }} <span class="text-gray-500 text-xs">MHz</span></div>
                  </td>
                  <td class="p-3 text-sm md:text-base">
                    <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-lg text-xs">{{ $item->no_st }}</span>
                  </td>
                  <td class="p-3 text-sm md:text-base">
                    {{ $item->vic }}
                  </td>
                  <td class="p-3 text-sm md:text-base">
                    <span
                    class="px-2 py-1 bg-amber-100 text-amber-800 rounded-lg text-xs">{{ $item->no_laporan }}</span>
                  </td>
                  <td class="p-3 text-sm md:text-base hidden md:table-cell">
                    {{ $item->band_frekuensi }}
                  </td>
                  <td class="p-3 text-sm md:text-base hidden lg:table-cell">
                    {{ $item->sub_service }}
                  </td>
                  <td class="p-3 text-sm md:text-base">
                    <span class="px-2 py-1 rounded-full text-xs font-medium
                  {{ $item->jenis_gangguan == 'Interferensi' ? 'bg-red-100 text-red-800' :
          ($item->jenis_gangguan == 'Harmonisa' ? 'bg-purple-100 text-purple-800' :
            'bg-gray-100 text-gray-800') }}">
                    {{ $item->jenis_gangguan }}
                    </span>
                  </td>
                  <td class="p-3 text-sm md:text-base hidden xl:table-cell">
                    <div class="flex items-center">
                    <x-heroicon-s-globe-alt class="w-4 h-4 text-gray-400 mr-1 flex-shrink-0" />
                    <span class="font-mono text-xs">{{ round($item->latitude, 3) }},
                      {{ round($item->longitude, 3) }}</span>
                    </div>
                  </td>
                  <td class="p-3 text-sm md:text-base">
                    <div class="max-w-[160px] md:max-w-[200px] truncate hover:whitespace-normal">
                    {{ $item->uraian_gangguan }}
                    </div>
                  </td>
                  <td class="p-3 text-sm md:text-base">
                    <div class="flex items-center">
                    <x-heroicon-s-clock class="w-4 h-4 text-gray-400 mr-1 flex-shrink-0" />
                    <span class="text-xs">{{ $item->waktu_kejadian }}</span>
                    </div>
                  </td>
                  <td class="p-3 text-sm md:text-base">
                    <button onclick="showDetail(
    '{{ $item->nama_client }}',
    '{{ $item->kecamatan }}',
    '{{ $item->waktu_kejadian }}',
    '{{ $item->jenis_gangguan }}',
    '{{ $item->severity }}',
    '{{ $item->frekuensi }}',
    '{{ $item->band_frekuensi }}',
    '{{ $item->service }}',
    '{{ $item->sub_service }}',
    '{{ $item->sifat_gangguan }}',
    '{{ $item->uraian_gangguan }}',
    '{{ round($item->latitude, 7) }}',
    '{{ round($item->longitude, 7) }}',
    '{{ optional($item->pengganggu->first())->nama ?? 'N/A' }}',
    '{{ optional($item->pengganggu->first())->jenis_organisasi ?? 'N/A' }}',
    '{{ optional($item->pengganggu->first())->frekuensi ?? 'N/A' }}',
    '{{ optional($item->pengganggu->first())->status_pelanggaran ?? 'N/A' }}',
    '{{ optional(optional($item->pengganggu->first())->location)->kota ?? 'N/A' }}',
    '{{ $item->no_st }}',
    '{{ $item->vic }}',
    '{{ $item->no_laporan }}',
    '{{ optional($item->pengganggu->first())->band_frekuensi ?? 'N/A' }}',
    '{{ optional($item->pengganggu->first())->service ?? 'N/A' }}',
    '{{ optional($item->pengganggu->first())->sub_service ?? 'N/A' }}',
    '{{ optional($item->pengganggu->first())->kecamatan ?? 'N/A' }}',
    '{{ optional($item->pengganggu->first())->latitude ?? 'N/A' }}',
    '{{ optional($item->pengganggu->first())->longitude ?? 'N/A' }}',
    '{{ $item->id }}' // <-- TAMBAHKAN ID ITEM DI SINI
)" class="inline-flex items-center px-3 py-1.5 bg-[#378EC3] hover:bg-[#277db2] text-white rounded-lg text-sm transition-colors shadow-sm">
    <x-heroicon-s-eye class="w-4 h-4 mr-1" />
    Detail
</button>
                  </td>
                  <td class="p-3 text-sm md:text-base text-center">
                    @if($item->file_path)
            <a href="{{ asset('storage/' . $item->file_path) }}" download
            class="inline-flex items-center px-3 py-1.5 bg-emerald-500 hover:bg-emerald-600 text-white rounded-lg text-sm transition-colors shadow-sm">
            <x-heroicon-s-document-arrow-down class="w-4 h-4 mr-1" />
            Download
            </a>
          @else
      <span class="text-gray-400 text-xs">Tidak ada file</span>
    @endif
                  </td>
                  </tr>
          @endforeach
                </tbody>
              </table>
            </div>
          </div>

          <!-- Pagination -->
          <div class="mt-6 flex justify-between items-center px-4">
            <div class="text-sm text-gray-600">Menampilkan 1-{{ count($gangguan) }} dari {{ count($gangguan) }} data
            </div>
            <div class="flex space-x-1">
              <button
                class="px-3 py-1 bg-gray-100 text-gray-700 rounded-md hover:bg-gray-200 transition-colors disabled:opacity-50"
                disabled>
                <x-heroicon-s-chevron-left class="w-5 h-5" />
              </button>
              <button
                class="px-3 py-1 bg-[#378EC3] text-white rounded-md hover:bg-[#277db2] transition-colors">1</button>
              <button
                class="px-3 py-1 bg-gray-100 text-gray-700 rounded-md hover:bg-gray-200 transition-colors disabled:opacity-50"
                disabled>
                <x-heroicon-s-chevron-right class="w-5 h-5" />
              </button>
            </div>
          </div>
        </div>

        <!-- Modal Detail -->
        <div id="detailModal"
          class="hidden fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center p-4 backdrop-blur-sm">
          <div
            class="bg-gradient-to-br from-[#f0f9ff] to-[#d2ebff] rounded-2xl shadow-2xl w-full max-w-4xl relative overflow-hidden overflow-y-auto max-h-[90vh]">
            <!-- Header dengan Gradien dan Icon -->
            <div class="bg-gradient-to-r from-[#378EC3] to-[#70C1F3] p-6 flex items-center sticky top-0 z-10">
              <div class="bg-white/20 p-3 rounded-full mr-4">
                <x-heroicon-s-exclamation-triangle class="w-8 h-8 text-white" />
              </div>
              <h2 class="text-2xl font-bold text-white">Detail Interferensi Frekuensi</h2>
            </div>

            <!-- Body dengan Grid Responsive -->
            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
              <!-- Kolom Kiri - Detail Gangguan -->
              <div class="space-y-4">
                <div class="bg-white/80 p-4 rounded-xl shadow-sm">
                  <label class="text-sm text-[#006DB0] font-semibold">Informasi Dasar</label>
                  <div class="mt-2 grid grid-cols-1 gap-2">
                    <div>
                      <p class="text-xs text-gray-500">Nama Client</p>
                      <p class="font-medium" id="modalNamaClient"></p>
                    </div>
                    <div>
                      <p class="text-xs text-gray-500">No. ST</p>
                      <p class="font-medium" id="modalNoST"></p>
                    </div>
                    <div>
                      <p class="text-xs text-gray-500">PIC</p>
                      <p class="font-medium" id="modalVIC"></p>
                    </div>
                    <div>
                      <p class="text-xs text-gray-500">No. Laporan</p>
                      <p class="font-medium" id="modalNoLaporan"></p>
                    </div>
                  </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                  <div class="bg-white/80 p-4 rounded-xl shadow-sm">
                    <label class="text-sm text-[#006DB0] font-semibold">Lokasi</label>
                    <p class="text-lg font-medium flex items-center">
                      <x-heroicon-s-map-pin class="w-5 h-5 mr-2 text-red-500" />
                      <span id="modalKecamatan"></span>
                    </p>
                  </div>
                  <div class="bg-white/80 p-4 rounded-xl shadow-sm">
                    <label class="text-sm text-[#006DB0] font-semibold">Severity</label>
                    <p class="text-lg">
                      <span id="modalSeverity" class="px-3 py-1 rounded-full text-sm font-bold"></span>
                    </p>
                  </div>
                </div>

                <div class="bg-white/80 p-4 rounded-xl shadow-sm">
                  <label class="text-sm text-[#006DB0] font-semibold">Timeline Kejadian</label>
                  <div class="flex items-center mt-2">
                    <x-heroicon-s-clock class="w-5 h-5 mr-2 text-amber-500" />
                    <span id="modalWaktuKejadian" class="font-medium"></span>
                  </div>
                </div>

                <div class="bg-white/80 p-4 rounded-xl shadow-sm">
                  <label class="text-sm text-[#006DB0] font-semibold">Frekuensi Terdampak</label>
                  <div class="mt-2 flex items-center justify-between">
                    <div>
                      <p class="text-2xl font-bold text-[#378EC3]" id="modalFrekuensi"></p>
                      <p class="text-sm" id="modalBandFrekuensi"></p>
                    </div>
                    <x-heroicon-s-signal class="w-12 h-12 text-[#70C1F3]/40" />
                  </div>
                </div>
              </div>

              <!-- Kolom Kanan - Detail Teknis -->
              <div class="space-y-4">
                <div class="bg-white/80 p-4 rounded-xl shadow-sm">
                  <label class="text-sm text-[#006DB0] font-semibold">Karakteristik Gangguan</label>
                  <div class="mt-2 grid grid-cols-2 gap-2">
                    <div>
                      <p class="text-xs text-gray-500">Jenis</p>
                      <p class="font-medium" id="modalJenisGangguan"></p>
                    </div>
                    <div>
                      <p class="text-xs text-gray-500">Sifat</p>
                      <p class="font-medium" id="modalSifatGangguan"></p>
                    </div>
                  </div>
                </div>

                <div class="bg-white/80 p-4 rounded-xl shadow-sm">
                  <label class="text-sm text-[#006DB0] font-semibold">Layanan Terdampak</label>
                  <div class="mt-2">
                    <p class="text-lg font-medium" id="modalService"></p>
                    <p class="text-sm text-gray-600" id="modalSubService"></p>
                  </div>
                </div>

                <div class="bg-white/80 p-4 rounded-xl shadow-sm">
                  <label class="text-sm text-[#006DB0] font-semibold">Koordinat</label>
                  <div class="mt-2 flex items-center">
                    <x-heroicon-s-globe-alt class="w-5 h-5 mr-2 text-emerald-600" />
                    <span class="font-mono" id="modalKoordinat"></span>
                  </div>
                </div>
              </div>

              <!-- Full-width Section untuk Uraian -->
              <div class="md:col-span-2 bg-white/80 p-4 rounded-xl shadow-sm">
                <label class="text-sm text-[#006DB0] font-semibold">Deskripsi Gangguan</label>
                <p class="mt-2 text-gray-700 leading-relaxed" id="modalUraianGangguan"></p>
              </div>

              <!-- Section Pengganggu -->
              <div class="md:col-span-2 bg-red-50/80 p-4 rounded-xl shadow-sm border border-red-200">
                <h3 class="text-lg font-semibold text-red-800 flex items-center">
                  <x-heroicon-s-shield-exclamation class="w-5 h-5 mr-2" />
                  Identitas Pengganggu
                </h3>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mt-3">
                  <div>
                    <p class="text-xs text-red-600">Nama Organisasi</p>
                    <p class="font-medium" id="modalPenggangguNama"></p>
                  </div>
                  <div>
                    <p class="text-xs text-red-600">Jenis Organisasi</p>
                    <p class="font-medium" id="modalPenggangguJenisOrg"></p>
                  </div>

                  <div>
                    <p class="text-xs text-red-600">Frekuensi</p>
                    <p class="font-medium" id="modalPenggangguFrekuensi"></p>
                  </div>
                  <div>
                    <p class="text-xs text-red-600">Band Frekuensi</p>
                    <p class="font-medium" id="modalPenggangguBandFrekuensi"></p>
                  </div>
                  <div>
                    <p class="text-xs text-red-600">Status Pelanggaran</p>
                    <p class="font-medium" id="modalPenggangguStatus"></p>
                  </div>
                  <div>
                    <p class="text-xs text-red-600">Service</p>
                    <p class="font-medium" id="modalPenggangguService"></p>
                  </div>
                  <div>
                    <p class="text-xs text-red-600">Sub-Service</p>
                    <p class="font-medium" id="modalPenggangguSubService"></p>
                  </div>
                  <div>
                    <p class="text-xs text-red-600">Kecamatan</p>
                    <p class="font-medium" id="modalPenggangguKecamatan"></p>
                  </div>
                  <div>
                    <p class="text-xs text-red-600">Lokasi</p>
                    <p class="font-medium" id="modalPenggangguKota"></p>
                  </div>
                  <div class="md:col-span-2">
                    <p class="text-xs text-red-600">Koordinat</p>
                    <p class="font-medium" id="modalPenggangguKoordinat"></p>
                  </div>
                </div>
              </div>
            </div>

            <!-- Footer dengan Tombol Aksi -->
            <div class="bg-gray-50 p-4 flex justify-end space-x-3 border-t sticky bottom-0">
    <button onclick="closeModal()"
        class="px-6 py-2 bg-gray-100 hover:bg-gray-200 rounded-lg font-medium transition-colors">
        Tutup
    </button>
    {{-- TOMBOL BARU UNTUK KE HALAMAN ADMIN --}}
    <a href="/admin/gangguans" {{-- Ganti "/admin" dengan URL halaman admin Filament Anda jika berbeda --}}
        class="px-6 py-2 bg-gradient-to-r from-[#378EC3] to-[#70C1F3] text-white rounded-lg font-medium shadow-md hover:from-[#277db2] hover:to-[#379ec3] transition-colors flex items-center">
        <x-heroicon-s-wrench-screwdriver class="w-5 h-5 mr-2" /> {{-- Contoh ikon, sesuaikan jika perlu --}}
        Ke Halaman Admin
    </a>
    {{-- AKHIR TOMBOL BARU --}}
</div>
          </div>
        </div>


      </div>
  </div>
  </div>

  <!-- Script -->
  <script>
// Toggle Sidebar
const sidebar = document.getElementById('sidebar');
const toggleButton = document.getElementById('toggleSidebar');

toggleButton.addEventListener('click', () => {
  sidebar.classList.toggle('-translate-x-full');
});

document.addEventListener('click', (event) => {
  if (window.innerWidth < 768) {
    const isClickInside = sidebar.contains(event.target);
    const isToggleButton = toggleButton.contains(event.target);
    if (!isClickInside && !isToggleButton && !sidebar.classList.contains('-translate-x-full')) {
      sidebar.classList.add('-translate-x-full');
    }
  }
});

window.addEventListener('resize', () => {
  if (window.innerWidth >= 768) {
    sidebar.classList.remove('-translate-x-full');
  } else {
    sidebar.classList.add('-translate-x-full');
  }
});

// Variabel global untuk map dan data
let map;
let gangguanData = {!! json_encode($gangguan, JSON_HEX_TAG) !!};
let markers = [];

// Fungsi untuk clear markers
function clearAllMarkers() {
  for (let i = 0; i < markers.length; i++) {
    map.removeLayer(markers[i]);
  }
  markers = [];
}

// Fungsi untuk update marker berdasarkan filter
function updateMarkerFromFilter(selectedKota = "", selectedTahun = "") {
  // Jika tidak ada parameter, ambil dari form
  if (selectedKota === "" && selectedTahun === "") {
    selectedKota = document.getElementById("filterKota").value.toLowerCase().trim();
    selectedTahun = document.getElementById("filterTahun").value.trim();
  }
  
  clearAllMarkers();

  gangguanData.forEach(gangguan => {
    // Pastikan data kota konsisten dengan yang di tabel
    let kota = '';
    if (gangguan.location && gangguan.location.kota) {
      kota = gangguan.location.kota.toLowerCase().trim();
    }
    
    // Pastikan format tahun konsisten dengan yang di tabel
    const tahun = gangguan.waktu_kejadian ? gangguan.waktu_kejadian.substring(0, 4) : '';
    
    const kotaMatch = selectedKota === "" || kota.includes(selectedKota);
    const tahunMatch = selectedTahun === "" || tahun === selectedTahun;

    if (kotaMatch && tahunMatch && gangguan.latitude && gangguan.longitude) {
  const marker = L.marker([gangguan.latitude, gangguan.longitude]).addTo(map);

  // Buat popup
  const popupContent = `
    <strong>${gangguan.nama_client}</strong><br>
    Kota: ${kota}<br>
    Tahun: ${tahun}<br>
    Frekuensi: ${gangguan.frekuensi} MHz
  `;

  // Bind popup ke marker
  marker.bindPopup(popupContent);

  // === BUAT POPUP MUNCUL SAAT HOVER ===
  marker.on('mouseover', function (e) {
    this.openPopup();
  });
  marker.on('mouseout', function (e) {
    this.closePopup();
  });

  // Tetap bisa klik untuk buka detail
  marker.on('click', function () {
    showDetail(
      gangguan.nama_client,
      gangguan.kecamatan,
      gangguan.waktu_kejadian,
      gangguan.jenis_gangguan,
      gangguan.severity,
      gangguan.frekuensi,
      gangguan.band_frekuensi,
      gangguan.service,
      gangguan.sub_service,
      gangguan.sifat_gangguan,
      gangguan.uraian_gangguan,
      gangguan.latitude,
      gangguan.longitude,
      gangguan.pengganggu && gangguan.pengganggu[0] ? gangguan.pengganggu[0].nama : 'N/A',
      gangguan.pengganggu && gangguan.pengganggu[0] ? gangguan.pengganggu[0].jenis_organisasi : 'N/A',
      gangguan.pengganggu && gangguan.pengganggu[0] ? gangguan.pengganggu[0].frekuensi : 'N/A',
      gangguan.pengganggu && gangguan.pengganggu[0] ? gangguan.pengganggu[0].status_pelanggaran : 'N/A',
      gangguan.pengganggu && gangguan.pengganggu[0] && gangguan.pengganggu[0].location ? gangguan.pengganggu[0].location.kota : 'N/A',
      gangguan.no_st,
      gangguan.vic,
      gangguan.no_laporan,
      gangguan.pengganggu && gangguan.pengganggu[0] ? gangguan.pengganggu[0].band_frekuensi : 'N/A',
      gangguan.pengganggu && gangguan.pengganggu[0] ? gangguan.pengganggu[0].service : 'N/A',
      gangguan.pengganggu && gangguan.pengganggu[0] ? gangguan.pengganggu[0].sub_service : 'N/A',
      gangguan.pengganggu && gangguan.pengganggu[0] ? gangguan.pengganggu[0].kecamatan : 'N/A',
      gangguan.pengganggu && gangguan.pengganggu[0] ? gangguan.pengganggu[0].latitude : 'N/A',
      gangguan.pengganggu && gangguan.pengganggu[0] ? gangguan.pengganggu[0].longitude : 'N/A'
    );
  });
  markers.push(marker);
}

  });
  
  console.log(`Menampilkan ${markers.length} marker setelah filter`);
}

// Map & Table Toggle
document.addEventListener("DOMContentLoaded", function () {
  const mapContainer = document.getElementById("mapContainer");
  const tableContainer = document.getElementById("tableContainer");
  const showMapBtn = document.getElementById("showMap");
  const showTableBtn = document.getElementById("showTable");

  // Inisialisasi map Leaflet
  map = L.map('map', {
    center: [-6.9147, 107.6098],
    zoom: 8,
    zoomControl: false,
    maxBounds: [
      [-8.2, 105.0],
      [-5.8, 109.0]
    ],
    maxBoundsViscosity: 1.0
  });

  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; OpenStreetMap contributors'
  }).addTo(map);

  // Panggil updateMarkerFromFilter setelah map diinisialisasi
  updateMarkerFromFilter();

  setTimeout(() => map.invalidateSize(), 100);
  window.addEventListener('resize', () => {
    map.invalidateSize();
  });

  function hideAllContainers() {
    mapContainer.classList.add("hidden");
    tableContainer.classList.add("hidden");
  }

  showMapBtn.addEventListener("click", () => {
    hideAllContainers();
    mapContainer.classList.remove("hidden");
    setTimeout(() => {
      map.invalidateSize();
    }, 200);
    
    // Update warna tombol
    showMapBtn.style.backgroundColor = "#EDBC1B";
    showTableBtn.style.backgroundColor = "#006DB0";
  });

  showTableBtn.addEventListener("click", () => {
    hideAllContainers();
    tableContainer.classList.remove("hidden");
    
    // Update warna tombol
    showTableBtn.style.backgroundColor = "#EDBC1B";
    showMapBtn.style.backgroundColor = "#006DB0";
  });

  // Default tampilkan map
  hideAllContainers();
  mapContainer.classList.remove("hidden");

  // Setup filter setelah map siap
  setupFilters();
});

// Fungsi untuk setup filter
function setupFilters() {
  const filterKota = document.getElementById("filterKota");
  const filterTahun = document.getElementById("filterTahun");
  const gangguanRows = document.querySelectorAll("#tableContainer tbody tr");

  function applyFilters() {
    const selectedKota = filterKota.value.toLowerCase().trim();
    const selectedTahun = filterTahun.value.trim();

    // Filter tabel
    gangguanRows.forEach(row => {
      const kota = row.cells[1].textContent.toLowerCase().trim();
      const tanggal = row.cells[11].textContent.trim();
      const tahun = tanggal.substring(0, 4);
      const kotaMatch = selectedKota === "" || kota.includes(selectedKota);
      const tahunMatch = selectedTahun === "" || tahun === selectedTahun;
      row.style.display = (kotaMatch && tahunMatch) ? "" : "none";
    });

    // Filter marker
    updateMarkerFromFilter(selectedKota, selectedTahun);
  }

  filterKota.addEventListener("change", applyFilters);
  filterTahun.addEventListener("change", applyFilters);
  applyFilters();
}

// Hilangkan loading animation
document.addEventListener("DOMContentLoaded", function () {
  setTimeout(() => {
    document.querySelector(".loading-animation").style.display = "none";
  }, 500);
});

// Fungsi untuk menampilkan modal detail
function showDetail(
  namaClient, kecamatan, waktuKejadian, jenisGangguan, severity,
  frekuensi, bandFrekuensi, service, subService, sifatGangguan,
  uraianGangguan, latitude, longitude, penggangguNama, penggangguJenisOrg,
  penggangguFrekuensi, penggangguStatus, penggangguKota, noST, vic,
  noLaporan, penggangguBandFrekuensi, penggangguService, penggangguSubService,
  penggangguKecamatan, penggangguLatitude, penggangguLongitude
) {
  // Detail Gangguan
  document.getElementById('modalNamaClient').innerText = namaClient || 'N/A';
  document.getElementById('modalNoST').innerText = noST || 'N/A';
  document.getElementById('modalVIC').innerText = vic || 'N/A';
  document.getElementById('modalNoLaporan').innerText = noLaporan || 'N/A';
  document.getElementById('modalKecamatan').innerText = kecamatan || 'N/A';
  document.getElementById('modalWaktuKejadian').innerText = formatDate(waktuKejadian) || 'N/A';
  document.getElementById('modalJenisGangguan').innerText = jenisGangguan || 'N/A';
  document.getElementById('modalSeverity').innerText = severity || 'N/A';
  document.getElementById('modalSeverity').className = '';
  document.getElementById('modalSeverity').classList.add(severity);
  document.getElementById('modalFrekuensi').innerText = frekuensi ? (frekuensi + " MHz") : 'N/A';
  document.getElementById('modalBandFrekuensi').innerText = bandFrekuensi || 'N/A';
  document.getElementById('modalService').innerText = service || 'N/A';
  document.getElementById('modalSubService').innerText = subService || 'N/A';
  document.getElementById('modalSifatGangguan').innerText = sifatGangguan || 'N/A';
  document.getElementById('modalUraianGangguan').innerText = uraianGangguan || 'N/A';
  document.getElementById('modalKoordinat').innerText = (latitude && longitude) ? (latitude + ", " + longitude) : 'N/A';

  // Detail Pengganggu
  document.getElementById('modalPenggangguNama').innerText = penggangguNama || 'N/A';
  document.getElementById('modalPenggangguJenisOrg').innerText = penggangguJenisOrg || 'N/A';
  document.getElementById('modalPenggangguFrekuensi').innerText = penggangguFrekuensi ? (penggangguFrekuensi + " MHz") : 'N/A';
  document.getElementById('modalPenggangguBandFrekuensi').innerText = penggangguBandFrekuensi || 'N/A';
  document.getElementById('modalPenggangguStatus').innerText = penggangguStatus || 'N/A';
  document.getElementById('modalPenggangguService').innerText = penggangguService || 'N/A';
  document.getElementById('modalPenggangguSubService').innerText = penggangguSubService || 'N/A';
  document.getElementById('modalPenggangguKecamatan').innerText = penggangguKecamatan || 'N/A';
  document.getElementById('modalPenggangguKota').innerText = penggangguKota || 'N/A';
  document.getElementById('modalPenggangguKoordinat').innerText = (penggangguLatitude && penggangguLongitude) ?
    (penggangguLatitude + ", " + penggangguLongitude) : 'N/A';

  document.getElementById('detailModal').classList.remove('hidden');
}

function closeModal() {
  document.getElementById('detailModal').classList.add('hidden');
}

function formatDate(dateString) {
  if (!dateString) return 'N/A';

  try {
    const date = new Date(dateString);
    const day = String(date.getDate()).padStart(2, '0');
    const month = String(date.getMonth() + 1).padStart(2, '0');
    const year = date.getFullYear();
    const hours = String(date.getHours()).padStart(2, '0');
    const minutes = String(date.getMinutes()).padStart(2, '0');
    const seconds = String(date.getSeconds()).padStart(2, '0');

    return `${day}-${month}-${year} ${hours}:${minutes}:${seconds}`;
  } catch (e) {
    return dateString;
  }
}
</script>


  <!-- Leaflet JS -->
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin=""></script>
  </main>
  </div>
</body>

</html>