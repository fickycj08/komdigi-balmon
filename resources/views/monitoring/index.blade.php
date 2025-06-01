<!DOCTYPE html>

<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Monitoring Page</title>
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

    /* Custom Capaian Colors */
    .High {
      background-color: #ecfccb;
      color: #3f6212;
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
      background-color: #fee2e2;
      color: #b91c1c;
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

    /* CSS Menu Monitoring START */
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
    #detailModal .bg-white/20 {
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
    #detailModal .bg-white/80 {
      background: rgba(255, 255, 255, 0.85);
      backdrop-filter: blur(5px);
      border: 1px solid rgba(255, 255, 255, 0.5);
      box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05);
      transition: all 0.3s ease;
    }

    #detailModal .bg-white/80:hover {
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

    /* Capaian Badge dengan Efek Glow */
    .capaian-badge {
      display: inline-block;
      padding: 0.25rem 0.75rem;
      border-radius: 9999px;
      text-transform: uppercase;
      font-size: 0.75rem;
      font-weight: bold;
      letter-spacing: 1px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .capaian-badge.High {
      background: linear-gradient(135deg, #bbf7d0 0%, #dcfce7 100%);
      color: #16a34a;
      box-shadow: 0 0 15px rgba(22, 163, 74, 0.2);
      animation: glowGreen 2s infinite alternate;
    }

    .capaian-badge.Medium {
      background: linear-gradient(135deg, #fef08a 0%, #fef9c3 100%);
      color: #ca8a04;
      box-shadow: 0 0 15px rgba(202, 138, 4, 0.2);
      animation: glowYellow 2s infinite alternate;
    }

    .capaian-badge.Low {
      background: linear-gradient(135deg, #fecaca 0%, #fee2e2 100%);
      color: #dc2626;
      box-shadow: 0 0 15px rgba(220, 38, 38, 0.2);
      animation: glowRed 2s infinite alternate;
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

    /* Nilai Capaian Display */
    #detailModal .capaian-value {
      background: linear-gradient(135deg, #378EC3 0%, #70C1F3 100%);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      font-size: 1.75rem;
      font-weight: 800;
      text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    /* Section Hasil dengan Efek Khusus */
    #detailModal .bg-blue-50/80 {
      background: linear-gradient(135deg, rgba(219, 234, 254, 0.9) 0%, rgba(191, 219, 254, 0.8) 100%);
      border-left: 5px solid #3b82f6;
      box-shadow: 0 10px 15px -3px rgba(59, 130, 246, 0.1);
      position: relative;
      overflow: hidden;
    }

    #detailModal .bg-blue-50/80:before {
      content: '';
      position: absolute;
      top: 0;
      right: 0;
      width: 100px;
      height: 100px;
      background: radial-gradient(circle, rgba(191, 219, 254, 0.8) 0%, transparent 70%);
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
    #detailModal a.bg-[#EDBC1B] {
      background: linear-gradient(135deg, #EDBC1B 0%, #ffd700 100%);
      position: relative;
      overflow: hidden;
    }

    #detailModal a.bg-[#EDBC1B]:before {
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

    #detailModal a.bg-[#EDBC1B]:hover:before {
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
    #detailModal .max-h-[90vh]::-webkit-scrollbar {
      width: 8px;
    }

    #detailModal .max-h-[90vh]::-webkit-scrollbar-track {
      background: rgba(241, 245, 249, 0.5);
      border-radius: 10px;
    }

    #detailModal .max-h-[90vh]::-webkit-scrollbar-thumb {
      background: rgba(55, 142, 195, 0.5);
      border-radius: 10px;
    }

    #detailModal .max-h-[90vh]::-webkit-scrollbar-thumb:hover {
      background: rgba(55, 142, 195, 0.7);
    }

    /* Efek Hover untuk Card */
    .bg-white/80:hover {
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

    /* Progress Bar Styling */
    .progress-container {
      width: 100%;
      background-color: #e2e8f0;
      border-radius: 9999px;
      height: 8px;
      overflow: hidden;
    }

    .progress-bar {
      height: 100%;
      border-radius: 9999px;
      transition: width 1s ease;
    }

    .progress-bar.high {
      background: linear-gradient(90deg, #10b981, #34d399);
    }

    .progress-bar.medium {
      background: linear-gradient(90deg, #f59e0b, #fbbf24);
    }

    .progress-bar.low {
      background: linear-gradient(90deg, #ef4444, #f87171);
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

    /* CSS Menu Monitoring END */
  </style>

</head>

<body class="bg-gradient-to-br from-[#e0f2fe] to-[#DFF9FF]">
  

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
          <div class="px-4 py-2 mb-2">
            <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Dashboard</h3>
          </div>

          <ul class="space-y-1 px-2">
            <li>
              <a href="#"
                class="flex items-center p-3 text-gray-700 rounded-xl hover:bg-blue-50 group transition-colors">
                <div class="flex items-center justify-center w-8 h-8 text-blue-600 bg-blue-100 rounded-lg mr-3">
                  <x-heroicon-s-home class="w-5 h-5" />
                </div>
                <span class="text-base font-medium">Beranda</span>
              </a>
            </li>

            <div class="border-t border-gray-100 my-4"></div>

            <div class="px-2 py-2 mb-1">
              <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Menu Layanan</h3>
            </div>

            <li>
              <a href="#"
                class="flex items-center p-3 text-white rounded-xl bg-gradient-to-r from-[#378EC3] to-[#70C1F3] shadow-md group">
                <div class="flex items-center justify-center w-8 h-8 bg-white/20 backdrop-blur-sm rounded-lg mr-3">
                  <x-heroicon-o-computer-desktop class="w-5 h-5 text-white" />
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
              <a href="{{ route('gangguan.index') }}"
                class="flex items-center p-3 text-gray-700 rounded-xl hover:bg-blue-50 group transition-colors">
                <div class="flex items-center justify-center w-8 h-8 text-red-600 bg-red-100 rounded-lg mr-3">
                  <x-heroicon-s-exclamation-triangle class="w-5 h-5" />
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

    <!-- Main Content -->
    <main class="flex-1 p-8 min-h-screen main-content md:ml-[100px] md:mr-[100px] pt-[130px]">
      <!-- Container untuk Filter -->
      <div class="bg-white shadow-lg rounded-lg p-6 mb-6 border border-gray-100">
  <div class="flex items-center justify-between mb-4">
    <h2 class="text-xl text-[#006DB0] font-bold flex items-center">
      <x-heroicon-s-funnel class="w-5 h-5 mr-2" />
      Filter Data
    </h2>
  </div>

  <!-- Grid 2 Kolom -->
  <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <!-- Filter Tahun -->
    <div class="relative">
      <label for="filterTahun" class="block text-gray-700 text-sm font-medium mb-2">Tahun:</label>
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
    <!-- Filter Kota/Kabupaten -->
    <div class="relative">
      <label for="filterKota" class="block text-gray-700 text-sm font-medium mb-2">Kota/Kabupaten:</label>
      <div class="relative">
        <select id="filterKota"
          class="block w-full bg-gray-50 border border-gray-300 text-gray-700 py-3 px-4 pr-8 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 appearance-none transition-colors">
          <option value="">Semua Kota/Kabupaten</option>
          @php
            $daftarKota = collect($monitoring)->pluck('location.kota')->unique()->sort()->filter();
          @endphp
          @foreach ($daftarKota as $kota)
          <option value="{{ $kota }}">{{ $kota }}</option>
          @endforeach
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

          <div class="flex space-x-3" id="toggleButtons">
  <button id="showMap"
    class="relative px-5 py-2.5 bg-[#EDBC1B] text-white rounded-lg transition-all duration-200 font-medium flex items-center shadow-md hover:shadow-lg transform hover:translate-y-[-2px] group"
    type="button">
    <x-heroicon-s-globe-alt class="w-5 h-5 mr-2" />
    Tampilkan Maps
    <!-- Tooltip -->
    <span class="absolute left-1/2 bottom-full mb-3 -translate-x-1/2 px-3 py-2 bg-black text-xs text-white rounded-md opacity-0 group-hover:opacity-100 transition pointer-events-none whitespace-nowrap z-20 shadow-lg">
      Visualisasi data monitoring dalam bentuk peta interaktif
    </span>
  </button>
  <button id="showTable"
    class="relative px-5 py-2.5 bg-[#006DB0] text-white rounded-lg transition-all duration-200 font-medium flex items-center shadow-md hover:shadow-lg transform hover:translate-y-[-2px] group"
    type="button">
    <x-heroicon-s-table-cells class="w-5 h-5 mr-2" />
    Tampilkan Data Tabel
    <!-- Tooltip -->
    <span class="absolute left-1/2 bottom-full mb-3 -translate-x-1/2 px-3 py-2 bg-black text-xs text-white rounded-md opacity-0 group-hover:opacity-100 transition pointer-events-none whitespace-nowrap z-20 shadow-lg">
      Lihat data monitoring dalam bentuk tabel
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
            <h1 class="text-2xl md:text-3xl font-bold text-[#006DB0]">Data Monitoring</h1>
            <div class="flex space-x-2">
             
            </div>
          </div>

          <div class="overflow-hidden rounded-xl shadow-md border border-gray-100">
            <div class="overflow-x-auto">
              <table class="w-full border-collapse">
                <thead>
                  <tr class="bg-gradient-to-r from-[#378EC3] to-[#70C1F3] text-white">
                    <th class="p-3 text-left font-semibold text-sm md:text-base">UPT</th>
                    <th class="p-3 text-left font-semibold text-sm md:text-base">Stasiun Monitor</th>
                    <th class="p-3 text-left font-semibold text-sm md:text-base">Tanggal</th>
                    <th class="p-3 text-left font-semibold text-sm md:text-base">Kab/Kota</th>
                    <th class="p-3 text-left font-semibold text-sm md:text-base">No SPT</th>
                    <th class="p-3 text-left font-semibold text-sm md:text-base">ISR Capaian</th>
                    <th class="p-3 text-left font-semibold text-sm md:text-base">OCC Capaian</th>
                    <th class="p-3 text-left font-semibold text-sm md:text-base">IDEN Capaian</th>
                    <th class="p-3 text-left font-semibold text-sm md:text-base">Capaian PK OBS</th>
                    <th class="p-3 text-center font-semibold text-sm md:text-base">Aksi</th>
                  </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                  @foreach ($monitoring as $index => $item)
                  <tr class="hover:bg-blue-50 transition-colors {{ $index % 2 == 0 ? 'bg-white' : 'bg-gray-50' }}">
                    <td class="p-3 text-sm md:text-base">
                      <div class="font-medium text-gray-800">{{ $item->upt }}</div>
                    </td>
                    <td class="p-3 text-sm md:text-base">
                      {{ $item->stasiun_monitor }}
                    </td>
                    <td class="p-3 text-sm md:text-base">
                      <div class="flex items-center">
                        <x-heroicon-s-calendar class="w-4 h-4 text-gray-500 mr-1 flex-shrink-0" />
                        <span>{{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') }}</span>
                      </div>
                    </td>
                    <td class="p-3 text-sm md:text-base">
                      <div class="flex items-center">
                        <x-heroicon-s-map-pin class="w-4 h-4 text-red-500 mr-1 flex-shrink-0" />
                        <span>{{ $item->location->kota ?? '-' }}</span>

                      </div>
                    </td>
                    <td class="p-3 text-sm md:text-base">
                      <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-lg text-xs">{{ $item->no_spt }}</span>
                    </td>
                    <td class="p-3 text-sm md:text-base">
                      @php
                        $isrCapaianClass = $item->isrmon_capaian >= 80 ? 'High' : ($item->isrmon_capaian >= 50 ? 'Medium' : 'Low');
                      @endphp
                      <span class="{{ $isrCapaianClass }}">{{ $item->isrmon_capaian }}%</span>
                    </td>
                    <td class="p-3 text-sm md:text-base">
                      @php
                        $occCapaianClass = $item->occ_capaian >= 80 ? 'High' : ($item->occ_capaian >= 50 ? 'Medium' : 'Low');
                      @endphp
                      <span class="{{ $occCapaianClass }}">{{ $item->occ_capaian }}%</span>
                    </td>
                    <td class="p-3 text-sm md:text-base">
                      @php
                        $idenCapaianClass = $item->iden_capaian >= 80 ? 'High' : ($item->iden_capaian >= 50 ? 'Medium' : 'Low');
                      @endphp
                      <span class="{{ $idenCapaianClass }}">{{ $item->iden_capaian }}%</span>
                    </td>
                    <td class="p-3 text-sm md:text-base">
                      @php
                        $pkObsClass = $item->capaian_pk_obs >= 80 ? 'High' : ($item->capaian_pk_obs >= 50 ? 'Medium' : 'Low');
                      @endphp
                      <span class="{{ $pkObsClass }}">{{ $item->capaian_pk_obs }}%</span>
                    </td>
                    <td class="p-3 text-sm md:text-base text-center">
                      <button onclick="showDetail(
                        '{{ $item->upt }}',
                        '{{ $item->stasiun_monitor }}',
                        '{{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') }}',
                        '{{ $item->location->kota}}',

                        '{{ $item->alamat }}',
                        '{{ $item->lat }}',
                        '{{ $item->lng }}',
                        '{{ $item->no_spt }}',
                        '{{ $item->isrmon_jumlah_isr }}',
                        '{{ $item->isrmon_target }}',
                        '{{ $item->isrmon_termonitor }}',
                        '{{ $item->isrmon_capaian }}',
                        '{{ $item->target_pita }}',
                        '{{ $item->occ_target_pita }}',
                        '{{ $item->occ_capaian }}',
                        '{{ $item->iden_jumlah_termonitor }}',
                        '{{ $item->iden_target }}',
                        '{{ $item->iden_teridentifikasi }}',
                        '{{ $item->iden_capaian }}',
                        '{{ $item->capaian_pk_obs }}',
                        '{{ $item->catatan }}'
                      )" class="inline-flex items-center px-3 py-1.5 bg-[#378EC3] hover:bg-[#277db2] text-white rounded-lg text-sm transition-colors shadow-sm">
                        <x-heroicon-s-eye class="w-4 h-4 mr-1" />
                        Detail
                      </button>
                    </td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>

          <!-- Pagination -->
          <div class="mt-6 flex justify-between items-center px-4">
            <div class="text-sm text-gray-600">Menampilkan 1-{{ count($monitoring) }} dari {{ count($monitoring) }} data
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
                <x-heroicon-o-computer-desktop class="w-8 h-8 text-white" />
              </div>
              <h2 class="text-2xl font-bold text-white">Detail Monitoring</h2>
            </div>

            <!-- Body dengan Grid Responsive -->
            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
              <!-- Kolom Kiri - Informasi Dasar -->
              <div class="space-y-4">
                <div class="bg-white/80 p-4 rounded-xl shadow-sm">
                  <label class="text-sm text-[#006DB0] font-semibold">Informasi Dasar</label>
                  <div class="mt-2 grid grid-cols-1 gap-2">
                    <div>
                      <p class="text-xs text-gray-500">UPT</p>
                      <p class="font-medium" id="modalUPT"></p>
                    </div>
                    <div>
                      <p class="text-xs text-gray-500">Stasiun Monitor</p>
                      <p class="font-medium" id="modalStasiunMonitor"></p>
                    </div>
                    <div>
                      <p class="text-xs text-gray-500">No. SPT</p>
                      <p class="font-medium" id="modalNoSPT"></p>
                    </div>
                  </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                  <div class="bg-white/80 p-4 rounded-xl shadow-sm">
                    <label class="text-sm text-[#006DB0] font-semibold">Tanggal</label>
                    <p class="text-lg font-medium flex items-center">
                      <x-heroicon-s-calendar class="w-5 h-5 mr-2 text-blue-500" />
                      <span id="modalTanggal"></span>
                    </p>
                  </div>
                  <div class="bg-white/80 p-4 rounded-xl shadow-sm">
                    <label class="text-sm text-[#006DB0] font-semibold">Kab/Kota</label>
                    <p class="text-lg font-medium flex items-center">
                      <x-heroicon-s-map-pin class="w-5 h-5 mr-2 text-red-500" />
                      <span id="modalKabKota"></span>
                    </p>
                  </div>
                </div>

                <div class="bg-white/80 p-4 rounded-xl shadow-sm">
                  <label class="text-sm text-[#006DB0] font-semibold">Alamat</label>
                  <p class="mt-2 text-gray-700" id="modalAlamat"></p>
                </div>

                <div class="bg-white/80 p-4 rounded-xl shadow-sm">
                  <label class="text-sm text-[#006DB0] font-semibold">Koordinat</label>
                  <div class="mt-2 flex items-center">
                    <x-heroicon-s-globe-alt class="w-5 h-5 mr-2 text-emerald-600" />
                    <span class="font-mono" id="modalKoordinat"></span>
                  </div>
                </div>

                <div class="bg-white/80 p-4 rounded-xl shadow-sm">
                  <label class="text-sm text-[#006DB0] font-semibold">Capaian PK OBS</label>
                  <div class="mt-2">
                    <div class="flex justify-between items-center mb-1">
                      <span class="text-2xl font-bold text-[#378EC3]" id="modalCapaianPKOBS"></span>
                      <span class="capaian-badge" id="modalCapaianPKOBSBadge"></span>
                    </div>
                    <div class="progress-container">
                      <div class="progress-bar" id="modalCapaianPKOBSBar"></div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Kolom Kanan - Detail Monitoring -->
              <div class="space-y-4">
                <!-- ISR Monitoring -->
                <div class="bg-white/80 p-4 rounded-xl shadow-sm">
                  <label class="text-sm text-[#006DB0] font-semibold">ISR Monitoring</label>
                  <div class="mt-2 grid grid-cols-2 gap-2">
                    <div>
                      <p class="text-xs text-gray-500">Jumlah ISR</p>
                      <p class="font-medium" id="modalISRJumlah"></p>
                    </div>
                    <div>
                      <p class="text-xs text-gray-500">Target</p>
                      <p class="font-medium" id="modalISRTarget"></p>
                    </div>
                    <div>
                      <p class="text-xs text-gray-500">Termonitor</p>
                      <p class="font-medium" id="modalISRTerMonitor"></p>
                    </div>
                    <div>
                      <p class="text-xs text-gray-500">Capaian</p>
                      <p class="font-medium">
                        <span class="capaian-badge" id="modalISRCapaianBadge"></span>
                      </p>
                    </div>
                  </div>
                  <div class="mt-2">
                    <div class="progress-container">
                      <div class="progress-bar" id="modalISRCapaianBar"></div>
                    </div>
                  </div>
                </div>

                <!-- Occupancy -->
                <div class="bg-white/80 p-4 rounded-xl shadow-sm">
                  <label class="text-sm text-[#006DB0] font-semibold">Occupancy</label>
                  <div class="mt-2 grid grid-cols-2 gap-2">
                    <div>
                      <p class="text-xs text-gray-500">Target Pita</p>
                      <p class="font-medium" id="modalTargetPita"></p>
                    </div>
                    <div>
                      <p class="text-xs text-gray-500">OCC Target Pita</p>
                      <p class="font-medium" id="modalOCCTargetPita"></p>
                    </div>
                    <div class="col-span-2">
                      <p class="text-xs text-gray-500">Capaian</p>
                      <p class="font-medium">
                        <span class="capaian-badge" id="modalOCCCapaianBadge"></span>
                      </p>
                    </div>
                  </div>
                  <div class="mt-2">
                    <div class="progress-container">
                      <div class="progress-bar" id="modalOCCCapaianBar"></div>
                    </div>
                  </div>
                </div>

                <!-- Identifikasi -->
                <div class="bg-white/80 p-4 rounded-xl shadow-sm">
                  <label class="text-sm text-[#006DB0] font-semibold">Identifikasi</label>
                  <div class="mt-2 grid grid-cols-2 gap-2">
                    <div>
                      <p class="text-xs text-gray-500">Jumlah Termonitor</p>
                      <p class="font-medium" id="modalIDENJumlahTerMonitor"></p>
                    </div>
                    <div>
                      <p class="text-xs text-gray-500">Target</p>
                      <p class="font-medium" id="modalIDENTarget"></p>
                    </div>
                    <div>
                      <p class="text-xs text-gray-500">Teridentifikasi</p>
                      <p class="font-medium" id="modalIDENTerIdentifikasi"></p>
                    </div>
                    <div>
                      <p class="text-xs text-gray-500">Capaian</p>
                      <p class="font-medium">
                        <span class="capaian-badge" id="modalIDENCapaianBadge"></span>
                      </p>
                    </div>
                  </div>
                  <div class="mt-2">
                    <div class="progress-container">
                      <div class="progress-bar" id="modalIDENCapaianBar"></div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Full-width Section untuk Catatan -->
              <div class="md:col-span-2 bg-blue-50/80 p-4 rounded-xl shadow-sm">
                <label class="text-sm text-[#006DB0] font-semibold">Catatan</label>
                <p class="mt-2 text-gray-700 leading-relaxed" id="modalCatatan"></p>
              </div>
            </div>

            <!-- Footer dengan Tombol Aksi -->
            <div class="bg-gray-50 p-4 flex justify-end space-x-3 border-t sticky bottom-0">
              <button onclick="closeModal()"
                class="px-6 py-2 bg-gray-100 hover:bg-gray-200 rounded-lg font-medium transition-colors">
                Tutup
              </button>
            
            </div>
          </div>
        </div>
      </div>
    </main>
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

  // --- MAIN FUNCTIONALITY (Map, Marker, Table, Filter) ---
  document.addEventListener("DOMContentLoaded", function () {
    // Map & Table Toggle
    const mapContainer = document.getElementById("mapContainer");
    const tableContainer = document.getElementById("tableContainer");
    const showMapBtn = document.getElementById("showMap");
    const showTableBtn = document.getElementById("showTable");

    // Inisialisasi map Leaflet
    const map = L.map('map', {
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

    // Ambil data dari backend
    var monitoringData = {!! json_encode($monitoring, JSON_HEX_TAG) !!};

    // Buat marker & simpan di array
    const allMarkers = [];
    monitoringData.forEach(item => {
      if (item.lat && item.lng) {
        const marker = L.marker([item.lat, item.lng]);
        marker.on('click', function () {
          showDetail(
            item.upt,
            item.stasiun_monitor,
            new Date(item.tanggal).toLocaleDateString('id-ID'),
            item.location?.kota ?? '-',


            item.alamat,
            item.lat,
            item.lng,
            item.no_spt,
            item.isrmon_jumlah_isr,
            item.isrmon_target,
            item.isrmon_termonitor,
            item.isrmon_capaian,
            item.target_pita,
            item.occ_target_pita,
            item.occ_capaian,
            item.iden_jumlah_termonitor,
            item.iden_target,
            item.iden_teridentifikasi,
            item.iden_capaian,
            item.capaian_pk_obs,
            item.catatan
          );
        });
        // Tambahkan marker ke map (nanti akan difilter, sekarang biarkan muncul semua dulu)
        marker.addTo(map);
        allMarkers.push({
          marker,
          tahun: new Date(item.tanggal).getFullYear().toString()
        });
      }
    });

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
      showMapBtn.style.backgroundColor = "#EDBC1B";   // aktif
      showTableBtn.style.backgroundColor = "#006DB0";   // tidak aktif
    });

    showTableBtn.addEventListener("click", () => {
      hideAllContainers();
      tableContainer.classList.remove("hidden");

      // Update warna tombol
      showTableBtn.style.backgroundColor = "#EDBC1B";    // aktif
      showMapBtn.style.backgroundColor = "#006DB0";      // tidak aktif
    });

    // Default tampilkan map
    hideAllContainers();
    mapContainer.classList.remove("hidden");

    // === FILTER TABLE + MAP ===
    const filterTahun = document.getElementById("filterTahun");
    const monitoringRows = document.querySelectorAll("#tableContainer tbody tr");
    const filterKota = document.getElementById("filterKota"); // Tambahan

    function applyFilters() {
      const selectedTahun = filterTahun.value.trim();
       const selectedKota = filterKota.value.trim().toLowerCase();

      // 1) Filter baris tabel
      monitoringRows.forEach(row => {
    // Ambil tahun (kolom tanggal) dan kota (kolom kota)
    const tahunRow = row.cells[2].textContent.trim().slice(-4); // Tanggal
    const kotaRow = row.cells[3].textContent.trim().toLowerCase(); // Kota
    // Filter dua-duanya
    const matchTahun = !selectedTahun || tahunRow === selectedTahun;
    const matchKota = !selectedKota || kotaRow === selectedKota;

    row.style.display = (matchTahun && matchKota) ? "" : "none";
  });

  // 2) Filter marker di map
  allMarkers.forEach(({ marker, tahun }, idx) => {
    // Cari data item yang sesuai
    const dataItem = monitoringData[idx];
    const kota = (dataItem.location?.kota || '').toLowerCase();
    const matchTahun = !selectedTahun || tahun === selectedTahun;
    const matchKota = !selectedKota || kota === selectedKota;

    if (matchTahun && matchKota) {
      if (!map.hasLayer(marker)) map.addLayer(marker);
    } else {
      if (map.hasLayer(marker)) map.removeLayer(marker);
    }
  });
}

filterTahun.addEventListener("change", applyFilters);
filterKota.addEventListener("change", applyFilters); // Jangan lupa ini

applyFilters(); // Biar sinkron awal
  });

  // --- Modal Show/Close (tidak diubah) ---
  function showDetail(
    upt,
    stasiunMonitor,
    tanggal,
    kabKota,
    alamat,
    lat,
    lng,
    noSPT,
    isrmonJumlahIsr,
    isrmonTarget,
    isrmonTerMonitor,
    isrmonCapaian,
    targetPita,
    occTargetPita,
    occCapaian,
    idenJumlahTerMonitor,
    idenTarget,
    idenTerIdentifikasi,
    idenCapaian,
    capaianPkObs,
    catatan
  ) {
    // ... fungsi showDetail tidak berubah ...
    document.getElementById('modalUPT').innerText = upt || 'N/A';
    document.getElementById('modalStasiunMonitor').innerText = stasiunMonitor || 'N/A';
    document.getElementById('modalNoSPT').innerText = noSPT || 'N/A';
    document.getElementById('modalTanggal').innerText = tanggal || 'N/A';
    document.getElementById('modalKabKota').innerText = kabKota || 'N/A';
    document.getElementById('modalAlamat').innerText = alamat || 'N/A';
    document.getElementById('modalKoordinat').innerText = (lat && lng) ? (lat + ", " + lng) : 'N/A';

    // ... sisanya tidak berubah ...
    // [copy-paste yang bagian showDetail dari kode kamu di atas]
    document.getElementById('modalCapaianPKOBS').innerText = capaianPkObs + '%' || 'N/A';

    const pkObsClass = capaianPkObs >= 80 ? 'High' : (capaianPkObs >= 50 ? 'Medium' : 'Low');
    document.getElementById('modalCapaianPKOBSBadge').innerText = capaianPkObs + '%';
    document.getElementById('modalCapaianPKOBSBadge').className = 'capaian-badge ' + pkObsClass;

    const pkObsBarClass = capaianPkObs >= 80 ? 'high' : (capaianPkObs >= 50 ? 'medium' : 'low');
    document.getElementById('modalCapaianPKOBSBar').className = 'progress-bar ' + pkObsBarClass;
    document.getElementById('modalCapaianPKOBSBar').style.width = capaianPkObs + '%';

    // ISR Monitoring
    document.getElementById('modalISRJumlah').innerText = isrmonJumlahIsr || '0';
    document.getElementById('modalISRTarget').innerText = isrmonTarget || '0';
    document.getElementById('modalISRTerMonitor').innerText = isrmonTerMonitor || '0';

    const isrCapaianClass = isrmonCapaian >= 80 ? 'High' : (isrmonCapaian >= 50 ? 'Medium' : 'Low');
    document.getElementById('modalISRCapaianBadge').innerText = isrmonCapaian + '%';
    document.getElementById('modalISRCapaianBadge').className = 'capaian-badge ' + isrCapaianClass;

    const isrBarClass = isrmonCapaian >= 80 ? 'high' : (isrmonCapaian >= 50 ? 'medium' : 'low');
    document.getElementById('modalISRCapaianBar').className = 'progress-bar ' + isrBarClass;
    document.getElementById('modalISRCapaianBar').style.width = isrmonCapaian + '%';

    // Occupancy
    document.getElementById('modalTargetPita').innerText = targetPita || '0';
    document.getElementById('modalOCCTargetPita').innerText = occTargetPita || '0';

    const occCapaianClass = occCapaian >= 80 ? 'High' : (occCapaian >= 50 ? 'Medium' : 'Low');
    document.getElementById('modalOCCCapaianBadge').innerText = occCapaian + '%';
    document.getElementById('modalOCCCapaianBadge').className = 'capaian-badge ' + occCapaianClass;

    const occBarClass = occCapaian >= 80 ? 'high' : (occCapaian >= 50 ? 'medium' : 'low');
    document.getElementById('modalOCCCapaianBar').className = 'progress-bar ' + occBarClass;
    document.getElementById('modalOCCCapaianBar').style.width = occCapaian + '%';

    // Identifikasi
    document.getElementById('modalIDENJumlahTerMonitor').innerText = idenJumlahTerMonitor || '0';
    document.getElementById('modalIDENTarget').innerText = idenTarget || '0';
    document.getElementById('modalIDENTerIdentifikasi').innerText = idenTerIdentifikasi || '0';

    const idenCapaianClass = idenCapaian >= 80 ? 'High' : (idenCapaian >= 50 ? 'Medium' : 'Low');
    document.getElementById('modalIDENCapaianBadge').innerText = idenCapaian + '%';
    document.getElementById('modalIDENCapaianBadge').className = 'capaian-badge ' + idenCapaianClass;

    const idenBarClass = idenCapaian >= 80 ? 'high' : (idenCapaian >= 50 ? 'medium' : 'low');
    document.getElementById('modalIDENCapaianBar').className = 'progress-bar ' + idenBarClass;
    document.getElementById('modalIDENCapaianBar').style.width = idenCapaian + '%';

    // Catatan
    document.getElementById('modalCatatan').innerText = catatan || 'Tidak ada catatan';

    document.getElementById('detailModal').classList.remove('hidden');
  }

  function closeModal() {
    document.getElementById('detailModal').classList.add('hidden');
  }
</script>


  <!-- Leaflet JS -->
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin=""></script>
</body>

</html>


 