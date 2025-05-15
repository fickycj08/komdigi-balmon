<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Pengukuran Page</title>
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

    /* CSS Menu Pengukuran START */
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

    /* Severity Badge dengan Efek Glow */
    .severity-badge {
      display: inline-block;
      padding: 0.25rem 0.75rem;
      border-radius: 9999px;
      text-transform: uppercase;
      font-size: 0.75rem;
      font-weight: bold;
      letter-spacing: 1px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .severity-badge.High {
      background: linear-gradient(135deg, #fecaca 0%, #fee2e2 100%);
      color: #dc2626;
      box-shadow: 0 0 15px rgba(220, 38, 38, 0.2);
      animation: glowRed 2s infinite alternate;
    }

    .severity-badge.Medium {
      background: linear-gradient(135deg, #fef08a 0%, #fef9c3 100%);
      color: #ca8a04;
      box-shadow: 0 0 15px rgba(202, 138, 4, 0.2);
      animation: glowYellow 2s infinite alternate;
    }

    .severity-badge.Low {
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

    /* Wilayah Marker Styles */
    .wilayah-marker {
      display: flex;
      align-items: center;
      justify-content: center;
    }
    
    .wilayah-marker:hover {
      transform: scale(1.2);
      transition: transform 0.2s ease;
    }

    /* CSS Menu Pengukuran END */
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
              <a href="{{ route('monitoring.index') }}"
                class="flex items-center p-3 text-gray-700 rounded-xl hover:bg-blue-50 group transition-colors">
                <div class="flex items-center justify-center w-8 h-8 text-indigo-600 bg-indigo-100 rounded-lg mr-3">
                  <x-heroicon-o-computer-desktop class="w-5 h-5" />
                </div>
                <span class="text-base font-medium">Monitoring</span>
              </a>
            </li>

            <li>
              <a href="#"
                class="flex items-center p-3 text-white rounded-xl bg-gradient-to-r from-[#378EC3] to-[#70C1F3] shadow-md group">
                <div class="flex items-center justify-center w-8 h-8 bg-white/20 backdrop-blur-sm rounded-lg mr-3">
                  <x-heroicon-o-arrow-trending-up class="w-5 h-5 text-white" />
                </div>
                <span class="text-base font-medium">Pengukuran</span>
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
      <div class="p-3 mt-2">
        <a href="#"
          class="flex items-center justify-center p-3 bg-gradient-to-r from-red-600 to-red-500 text-white rounded-xl shadow-md hover:from-red-700 hover:to-red-600 transition-all transform hover:-translate-y-1">
          <x-heroicon-s-arrow-right-on-rectangle class="w-5 h-5 mr-2" />
          <span class="text-base font-medium">Logout</span>
        </a>
      </div>
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

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
          <div class="relative">
            <label for="filterKota" class="block text-gray-700 text-sm font-medium mb-2">Lokasi / Kota:</label>
            <div class="relative">
              <select id="filterKota"
                class="block w-full bg-gray-50 border border-gray-300 text-gray-700 py-3 px-4 pr-8 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 appearance-none transition-colors">
                <option value="">Semua Lokasi</option>
                @foreach ($lokasiPemancars as $lokasi)
                <option value="{{ $lokasi->kota }}">{{ $lokasi->kota }}</option>
                @endforeach
              </select>
              <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                <x-heroicon-s-chevron-down class="w-5 h-5" />
              </div>
            </div>
          </div>

          <div class="relative">
            <label for="filterTahun" class="block text-gray-700 text-sm font-medium mb-2">Tahun Pengukuran:</label>
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

          <div class="flex space-x-3" id="toggleButtons">
            <button id="showMap"
              class="px-5 py-2.5 bg-[#EDBC1B] text-white rounded-lg transition-all duration-200 font-medium flex items-center shadow-md hover:shadow-lg transform hover:translate-y-[-2px]">
              <x-heroicon-s-globe-alt class="w-5 h-5 mr-2" />
              Tampilkan Maps
            </button>
            <button id="showTable"
              class="px-5 py-2.5 bg-[#006DB0] text-white rounded-lg transition-all duration-200 font-medium flex items-center shadow-md hover:shadow-lg transform hover:translate-y-[-2px]">
              <x-heroicon-s-table-cells class="w-5 h-5 mr-2" />
              Tampilkan Data Pengukuran
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
            <h1 class="text-2xl md:text-3xl font-bold text-[#006DB0]">Data Pengukuran</h1>
            <div class="flex space-x-2">
              
            </div>
          </div>

          <div class="overflow-hidden rounded-xl shadow-md border border-gray-100">
            <div class="overflow-x-auto">
              <table class="w-full border-collapse">
                <thead>
                  <tr class="bg-gradient-to-r from-[#378EC3] to-[#70C1F3] text-white">
                    <th class="p-3 text-left font-semibold text-sm md:text-base">Nomor ISR</th>
                    <th class="p-3 text-left font-semibold text-sm md:text-base">Frekuensi (MHz)</th>
                    <th class="p-3 text-left font-semibold text-sm md:text-base">Bandwidth</th>
                    <th class="p-3 text-left font-semibold text-sm md:text-base">Daya</th>
                    <th class="p-3 text-left font-semibold text-sm md:text-base">Koordinat</th>
                    <th class="p-3 text-left font-semibold text-sm md:text-base hidden lg:table-cell">H-1</th>
                    <th class="p-3 text-left font-semibold text-sm md:text-base hidden xl:table-cell">H-2</th>
                    <th class="p-3 text-left font-semibold text-sm md:text-base">H-3</th>
                    <th class="p-3 text-center font-semibold text-sm md:text-base">Aksi</th>
                  </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                  @foreach ($pengukurans as $index => $item)
                    <tr class="hover:bg-blue-50 transition-colors {{ $index % 2 == 0 ? 'bg-white' : 'bg-gray-50' }}">
                      <!-- Nomor ISR -->
                      <td class="p-3 text-sm text-gray-800">
                        <div class="font-medium text-gray-800">{{ $item->data_isr->no_isr ?? '-' }}</div>
                      </td>
                      @php
                        $pengukuranPertama = $item->pengukuranFrekuensi ?? null;
                      @endphp
                      <td class="p-3 text-sm text-gray-800">
                        <div class="font-medium text-blue-600">{{ $pengukuranPertama->frekuensi_terukur_mhz ?? '-' }}</div>
                      </td>
                      <td class="p-3 text-sm text-gray-800">
                        <div>{{ $pengukuranPertama->bandwidth_khz ?? '-' }} kHz</div>
                      </td>
                      <td class="p-3 text-sm text-gray-800">
                        <div>{{ $pengukuranPertama->output_power_tx ?? '-' }} W</div>
                      </td>
                      <td class="p-3 text-sm text-gray-800">
                        <div class="flex items-center">
                          <x-heroicon-s-map-pin class="w-4 h-4 text-red-500 mr-1 flex-shrink-0" />
                          <span>{{ $item->lokasi_pemancar->latitude ?? '-' }}, {{ $item->lokasi_pemancar->longitude ?? '-' }}</span>
                        </div>
                      </td>
                      <td class="p-3 text-sm text-gray-800 hidden lg:table-cell">
                        <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-lg text-xs">
                          {{ $pengukuranPertama->level_h1_dbm ?? '-' }} dBm
                        </span>
                      </td>
                      <td class="p-3 text-sm text-gray-800 hidden xl:table-cell">
                        <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-lg text-xs">
                          {{ $pengukuranPertama->level_h2_dbm ?? '-' }} dBm
                        </span>
                      </td>
                      <td class="p-3 text-sm text-gray-800">
                        <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-lg text-xs">
                          {{ $pengukuranPertama->level_h3_dbm ?? '-' }} dBm
                        </span>
                      </td>
                      <!-- Aksi -->
                      <td class="p-3 text-sm text-center">
                        <button onclick="showDetail(
                          '{{ $item->data_isr->no_isr ?? '-' }}',
                          '{{ $pengukuranPertama->frekuensi_terukur_mhz ?? '-' }}',
                          '{{ $pengukuranPertama->bandwidth_khz ?? '-' }}',
                          '{{ $pengukuranPertama->output_power_tx ?? '-' }}',
                          '{{ $item->LokasiPemancar->latitude ?? '-' }}',
                          '{{ $item->LokasiPemancar->longitude ?? '-' }}',
                          '{{ $pengukuranPertama->level_h1_dbm ?? '-' }}',
                          '{{ $pengukuranPertama->level_h2_dbm ?? '-' }}',
                          '{{ $pengukuranPertama->level_h3_dbm ?? '-' }}',
                          '{{ $item->lokasi_pemancar->alamat ?? '-' }}',
                          '{{ $item->LokasiPemancar->kota ?? '-' }}',
                          '{{ $item->LokasiPemancar->kecamatan ?? '-' }}',
                          '{{ $item->LokasiPemancar->kelurahan ?? '-' }}',
                          '{{ $pengukuranPertama->tanggal_ukur ?? '-' }}',
                          '{{ $pengukuranPertama->field_strength ?? '-' }}',
                          '{{ $pengukuranPertama->deviasi_freq ?? '-' }}',
                          '{{ $pengukuranPertama->catatan ?? '-' }}'
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
            <div class="text-sm text-gray-600">Menampilkan 1-{{ count($pengukurans) }} dari {{ count($pengukurans) }} data
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
                <x-heroicon-o-arrow-trending-up class="w-8 h-8 text-white" />
              </div>
              <h2 class="text-2xl font-bold text-white">Detail Pengukuran</h2>
            </div>

            <!-- Body dengan Grid Responsive -->
            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
              <!-- Kolom Kiri - Informasi Dasar -->
              <div class="space-y-4">
                <div class="bg-white/80 p-4 rounded-xl shadow-sm">
                  <label class="text-sm text-[#006DB0] font-semibold">Informasi Dasar</label>
                  <div class="mt-2 grid grid-cols-1 gap-2">
                    <div>
                      <p class="text-xs text-gray-500">Nomor ISR</p>
                      <p class="font-medium" id="modalNoISR"></p>
                    </div>
                    <div>
                      <p class="text-xs text-gray-500">Tanggal Pengukuran</p>
                      <p class="font-medium" id="modalTanggalUkur"></p>
                    </div>
                  </div>
                </div>

                <div class="bg-white/80 p-4 rounded-xl shadow-sm">
                  <label class="text-sm text-[#006DB0] font-semibold">Lokasi Pemancar</label>
                  <div class="mt-2 grid grid-cols-1 gap-2">
                    <div>
                      <p class="text-xs text-gray-500">Alamat</p>
                      <p class="font-medium" id="modalAlamat"></p>
                    </div>
                    <div class="grid grid-cols-2 gap-2">
                      <div>
                        <p class="text-xs text-gray-500">Kota</p>
                        <p class="font-medium" id="modalKota"></p>
                      </div>
                      <div>
                        <p class="text-xs text-gray-500">Kecamatan</p>
                        <p class="font-medium" id="modalKecamatan"></p>
                      </div>
                    </div>
                    <div>
                      <p class="text-xs text-gray-500">Kelurahan</p>
                      <p class="font-medium" id="modalKelurahan"></p>
                    </div>
                    <div>
                      <p class="text-xs text-gray-500">Koordinat</p>
                      <p class="font-medium flex items-center">
                        <x-heroicon-s-map-pin class="w-4 h-4 text-red-500 mr-1" />
                        <span id="modalKoordinat"></span>
                      </p>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Kolom Kanan - Detail Pengukuran -->
              <div class="space-y-4">
                <div class="bg-white/80 p-4 rounded-xl shadow-sm">
                  <label class="text-sm text-[#006DB0] font-semibold">Parameter Teknis</label>
                  <div class="mt-2 grid grid-cols-2 gap-4">
                    <div>
                      <p class="text-xs text-gray-500">Frekuensi Terukur</p>
                      <p class="font-medium text-blue-600" id="modalFrekuensi"></p>
                    </div>
                    <div>
                      <p class="text-xs text-gray-500">Bandwidth</p>
                      <p class="font-medium" id="modalBandwidth"></p>
                    </div>
                    <div>
                      <p class="text-xs text-gray-500">Daya Pancar</p>
                      <p class="font-medium" id="modalDaya"></p>
                    </div>
                   <div>
  <p class="text-xs text-gray-500">Deviasi Frekuensi</p>
  <p class="font-medium" id="modalDeviasi"></p>
</div>

                  </div>
                </div>

                <div class="bg-white/80 p-4 rounded-xl shadow-sm">
                  <label class="text-sm text-[#006DB0] font-semibold">Harmonisa</label>
                  <div class="mt-2 grid grid-cols-3 gap-2">
                    <div>
                      <p class="text-xs text-gray-500">H-1</p>
                      <p class="font-medium" id="modalH1"></p>
                    </div>
                    <div>
                      <p class="text-xs text-gray-500">H-2</p>
                      <p class="font-medium" id="modalH2"></p>
                    </div>
                    <div>
                      <p class="text-xs text-gray-500">H-3</p>
                      <p class="font-medium" id="modalH3"></p>
                    </div>
                  </div>
                  <div class="mt-4">
                    <div class="grid grid-cols-3 gap-2">
                      <div class="col-span-1">
                        <p class="text-xs text-gray-500">H-1 Level</p>
                        <div class="mt-1 progress-container">
                          <div class="progress-bar high" id="modalH1Bar" style="width: 75%"></div>
                        </div>
                      </div>
                      <div class="col-span-1">
                        <p class="text-xs text-gray-500">H-2 Level</p>
                        <div class="mt-1 progress-container">
                          <div class="progress-bar medium" id="modalH2Bar" style="width: 50%"></div>
                        </div>
                      </div>
                      <div class="col-span-1">
                        <p class="text-xs text-gray-500">H-3 Level</p>
                        <div class="mt-1 progress-container">
                          <div class="progress-bar low" id="modalH3Bar" style="width: 25%"></div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Full-width Section untuk Catatan -->
              <div class="md:col-span-2 bg-blue-50/80 p-4 rounded-xl shadow-sm">
                <label class="text-sm text-[#006DB0] font-semibold">Catatan Pengukuran</label>
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
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin=""></script>
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

    // Filter untuk tabel
    document.addEventListener("DOMContentLoaded", function () {
      const filterKota = document.getElementById("filterKota");
      const filterTahun = document.getElementById("filterTahun");
      const filterFreq = document.getElementById("filterFreq");
      const pengukuranRows = document.querySelectorAll("#tableContainer tbody tr");

      function applyFilters() {
        const selectedKota = filterKota?.value?.toLowerCase().trim() || "";
        const selectedTahun = filterTahun?.value?.trim() || "";
        const selectedFreq = filterFreq?.value?.trim() || "";

        pengukuranRows.forEach(row => {
          const kota = row.querySelector("td:nth-child(5)")?.textContent.toLowerCase().trim() || "";
          const frekuensi = parseFloat(row.querySelector("td:nth-child(2)")?.textContent.trim() || "0");
          const tanggalUkur = row.getAttribute("data-tanggal") || "";
          const tahun = tanggalUkur.substring(0, 4);
          
          let kotaMatch = selectedKota === "" || kota.includes(selectedKota);
          let tahunMatch = selectedTahun === "" || tahun === selectedTahun;
          let freqMatch = true;
          
          if (selectedFreq !== "") {
            const [minFreq, maxFreq] = selectedFreq.split('-').map(Number);
            freqMatch = frekuensi >= minFreq && frekuensi <= maxFreq;
          }
          
          row.style.display = (kotaMatch && tahunMatch && freqMatch) ? "" : "none";
        });
      }

      if (filterKota) filterKota.addEventListener("change", applyFilters);
      if (filterTahun) filterTahun.addEventListener("change", applyFilters);
      if (filterFreq) filterFreq.addEventListener("change", applyFilters);
      applyFilters();
    });

    // Map & Table Toggle with Marker Highlighting
    document.addEventListener("DOMContentLoaded", function () {
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

      L.control.zoom({
        position: 'bottomright'
      }).addTo(map);

      // Menambahkan marker wilayah alokasi frekuensi
      const wilayahList = [
        {
          nama: "105",
          koordinat: [-7.02694444444444, 107.516388888889],
          radius: 12000,
          warnaLingkaran: "#8B5CF6",
          warnaIsi: "#C4B5FD",
          pembagian_kanal: "LPP RRI, Lokal, LPS",
          status: "Aktif"
        },
        {
          nama: "132",
          koordinat: [-7.32805555555556, 108.392777777778],
          radius: 12000,
          warnaLingkaran: "#8B5CF6",
          warnaIsi: "#C4B5FD",
          pembagian_kanal: "LPP RRI",
          status: "Aktif"
        },
         {
          nama: "132",
          koordinat: [-7.32805555555556, 108.392777777778],
          radius: 12000,
          warnaLingkaran: "#8B5CF6",
          warnaIsi: "#C4B5FD",
          pembagian_kanal: "LPP RRI",
          status: "Aktif"
        },
         {
          nama: "55",
          koordinat: [-7.29611111111111, 108.2525],
          radius: 12000,
          warnaLingkaran: "#8B5CF6",
          warnaIsi: "#C4B5FD",
          pembagian_kanal: "LPP RRI, Lokal, LPS",
          status: "Aktif"
        },
        {
  nama: "82",
  koordinat: [-7.185833333, 108.3697222],
  radius: 12000,
  warnaLingkaran: "#8B5CF6",
  warnaIsi: "#C4B5FD",
  pembagian_kanal: "LPP RRI",
  status: "Aktif"
},

{
  nama: "149",
  koordinat: [-7.185833333, 108.3697222],
  radius: 12000,
  warnaLingkaran: "#8B5CF6",
  warnaIsi: "#C4B5FD",
  pembagian_kanal: "LPP RRI, Lokal, LPS",
  status: "Aktif"
},
{
  nama: "43",
  koordinat: [-7.263611111, 108.5266667],
  radius: 12000,
  warnaLingkaran: "#8B5CF6",
  warnaIsi: "#C4B5FD",
  pembagian_kanal: "LPP RRI",
  status: "Aktif"
},
{
  nama: "177",
  koordinat: [-7.413055556, 106.8994444],
  radius: 12000,
  warnaLingkaran: "#8B5CF6",
  warnaIsi: "#C4B5FD",
  pembagian_kanal: "LPP RRI",
  status: "Aktif"
},
{
  nama: "186",
  koordinat: [-6.82, 107.0775],
  radius: 12000,
  warnaLingkaran: "#8B5CF6",
  warnaIsi: "#C4B5FD",
  pembagian_kanal: "LPP RRI",
  status: "Aktif"
},
{
  nama: "4",
  koordinat: [-6.969722222, 107.1352778],
  radius: 12000,
  warnaLingkaran: "#8B5CF6",
  warnaIsi: "#C4B5FD",
  pembagian_kanal: "LPP RRI, Lokal, LPS",
  status: "Aktif"
},
{
  nama: "132",
  koordinat: [-7.400555556, 107.3316667],
  radius: 12000,
  warnaLingkaran: "#8B5CF6",
  warnaIsi: "#C4B5FD",
  pembagian_kanal: "LPP RRI",
  status: "Aktif"
},
{
  nama: "8",
  koordinat: [-6.748888889, 107.1952778],
  radius: 12000,
  warnaLingkaran: "#8B5CF6",
  warnaIsi: "#C4B5FD",
  pembagian_kanal: "LPP RRI",
  status: "Aktif"
},
{
  nama: "61",
  koordinat: [-7.463888889, 107.135],
  radius: 12000,
  warnaLingkaran: "#8B5CF6",
  warnaIsi: "#C4B5FD",
  pembagian_kanal: "LPP RRI, Lokal, LPS",
  status: "Aktif"
},
{
  nama: "12",
  koordinat: [-7.121388889, 107.0552778],
  radius: 12000,
  warnaLingkaran: "#8B5CF6",
  warnaIsi: "#C4B5FD",
  pembagian_kanal: "LPP RRI",
  status: "Aktif"
},
{
  nama: "121",
  koordinat: [-6.862777778, 108.7072222],
  radius: 12000,
  warnaLingkaran: "#8B5CF6",
  warnaIsi: "#C4B5FD",
  pembagian_kanal: "LPP RRI",
  status: "Aktif"
},
{
  nama: "11",
  koordinat: [-6.653611111, 108.4455556],
  radius: 12000,
  warnaLingkaran: "#8B5CF6",
  warnaIsi: "#C4B5FD",
  pembagian_kanal: "LPP RRI, Lokal, LPS",
  status: "Aktif"
},
{
  nama: "73",
  koordinat: [-6.76, 108.4952778],
  radius: 12000,
  warnaLingkaran: "#8B5CF6",
  warnaIsi: "#C4B5FD",
  pembagian_kanal: "LPP RRI",
  status: "Aktif"
},
{
  nama: "186",
  koordinat: [-7.441111111, 107.9036111],
  radius: 12000,
  warnaLingkaran: "#8B5CF6",
  warnaIsi: "#C4B5FD",
  pembagian_kanal: "LPP RRI",
  status: "Aktif"
},
{
  nama: "107",
  koordinat: [-7.486666667, 107.5416667],
  radius: 12000,
  warnaLingkaran: "#8B5CF6",
  warnaIsi: "#C4B5FD",
  pembagian_kanal: "LPP RRI",
  status: "Aktif"
},
{
  nama: "79",
  koordinat: [-7.034722222, 107.9844444],
  radius: 12000,
  warnaLingkaran: "#8B5CF6",
  warnaIsi: "#C4B5FD",
  pembagian_kanal: "LPP RRI",
  status: "Aktif"
},
{
  nama: "83",
  koordinat: [-7.375277778, 107.8186111],
  radius: 12000,
  warnaLingkaran: "#8B5CF6",
  warnaIsi: "#C4B5FD",
  pembagian_kanal: "LPP RRI",
  status: "Aktif"
},
{
  nama: "66",
  koordinat: [-7.292222222, 107.5305556],
  radius: 12000,
  warnaLingkaran: "#8B5CF6",
  warnaIsi: "#C4B5FD",
  pembagian_kanal: "LPP RRI, Lokal, LPS",
  status: "Aktif"
},
{
  nama: "28",
  koordinat: [-7.200555556, 107.9063889],
  radius: 12000,
  warnaLingkaran: "#8B5CF6",
  warnaIsi: "#C4B5FD",
  pembagian_kanal: "LPP RRI, Lokal, LPS",
  status: "Aktif"
},
{
  nama: "40",
  koordinat: [-7.600555556, 107.7708333],
  radius: 12000,
  warnaLingkaran: "#8B5CF6",
  warnaIsi: "#C4B5FD",
  pembagian_kanal: "LPP RRI, Lokal, LPS",
  status: "Aktif"
},
{
  nama: "32",
  koordinat: [-7.2625, 107.8197222],
  radius: 12000,
  warnaLingkaran: "#8B5CF6",
  warnaIsi: "#C4B5FD",
  pembagian_kanal: "LPP RRI, Lokal, LPS",
  status: "Aktif"
},
{
  nama: "125",
  koordinat: [-6.326388889, 108.3219444],
  radius: 12000,
  warnaLingkaran: "#8B5CF6",
  warnaIsi: "#C4B5FD",
  pembagian_kanal: "LPP RRI",
  status: "Aktif"
},
{
  nama: "181",
  koordinat: [-6.335, 107.9494444],
  radius: 12000,
  warnaLingkaran: "#8B5CF6",
  warnaIsi: "#C4B5FD",
  pembagian_kanal: "LPP RRI",
  status: "Aktif"
},
{
  nama: "134",
  koordinat: [-6.512222222, 108.2138889],
  radius: 12000,
  warnaLingkaran: "#8B5CF6",
  warnaIsi: "#C4B5FD",
  pembagian_kanal: "LPP RRI, Lokal, LPS",
  status: "Aktif"
},
{
  nama: "16",
  koordinat: [-6.460277778, 107.9888889],
  radius: 12000,
  warnaLingkaran: "#8B5CF6",
  warnaIsi: "#C4B5FD",
  pembagian_kanal: "LPP RRI",
  status: "Aktif"
},
{
  nama: "24",
  koordinat: [-6.394166667, 108.1730556],
  radius: 12000,
  warnaLingkaran: "#8B5CF6",
  warnaIsi: "#C4B5FD",
  pembagian_kanal: "LPP RRI, Lokal, LPS",
  status: "Aktif"
},
{
  nama: "4",
  koordinat: [-6.480555556, 108.3502778],
  radius: 12000,
  warnaLingkaran: "#8B5CF6",
  warnaIsi: "#C4B5FD",
  pembagian_kanal: "LPP RRI, Lokal, LPS",
  status: "Aktif"
},
{
  nama: "19",
  koordinat: [-6.297777778, 107.2980556],
  radius: 12000,
  warnaLingkaran: "#8B5CF6",
  warnaIsi: "#C4B5FD",
  pembagian_kanal: "LPP RRI",
  status: "Aktif"
},
{
  nama: "44",
  koordinat: [-6.389722222, 107.4661111],
  radius: 12000,
  warnaLingkaran: "#8B5CF6",
  warnaIsi: "#C4B5FD",
  pembagian_kanal: "LPP RRI",
  status: "Aktif"
},
{
  nama: "121",
  koordinat: [-6.182222222, 107.3144444],
  radius: 12000,
  warnaLingkaran: "#8B5CF6",
  warnaIsi: "#C4B5FD",
  pembagian_kanal: "LPP RRI, Lokal, LPS",
  status: "Aktif"
},
{
  nama: "10",
  koordinat: [-6.921388889, 107.6072222],
  radius: 12000,
  warnaLingkaran: "#8B5CF6",
  warnaIsi: "#C4B5FD",
  pembagian_kanal: "LPP RRI",
  status: "Aktif"
},
{
  nama: "12",
  koordinat: [-7.369444444, 108.5416667],
  radius: 12000,
  warnaLingkaran: "#8B5CF6",
  warnaIsi: "#C4B5FD",
  pembagian_kanal: "LPP RRI",
  status: "Aktif"
},
{
  nama: "54",
  koordinat: [-6.873055556, 107.5422222],
  radius: 12000,
  warnaLingkaran: "#8B5CF6",
  warnaIsi: "#C4B5FD",
  pembagian_kanal: "LPP RRI, Lokal, LPS",
  status: "Aktif"
},
{
  nama: "100",
  koordinat: [-6.706944444, 108.5580556],
  radius: 12000,
  warnaLingkaran: "#8B5CF6",
  warnaIsi: "#C4B5FD",
  pembagian_kanal: "LPP RRI",
  status: "Aktif"
},
{
  nama: "190",
  koordinat: [-6.921111111, 106.9258333],
  radius: 12000,
  warnaLingkaran: "#8B5CF6",
  warnaIsi: "#C4B5FD",
  pembagian_kanal: "LPP RRI",
  status: "Aktif"
},
{
  nama: "106",
  koordinat: [-7.326666667, 108.2244444],
  radius: 12000,
  warnaLingkaran: "#8B5CF6",
  warnaIsi: "#C4B5FD",
  pembagian_kanal: "LPP RRI",
  status: "Aktif"
},
{
  nama: "39",
  koordinat: [-6.904722222, 108.4894444],
  radius: 12000,
  warnaLingkaran: "#8B5CF6",
  warnaIsi: "#C4B5FD",
  pembagian_kanal: "LPP RRI",
  status: "Aktif"
},
{
  nama: "23",
  koordinat: [-6.980833333, 108.4927778],
  radius: 12000,
  warnaLingkaran: "#8B5CF6",
  warnaIsi: "#C4B5FD",
  pembagian_kanal: "LPP RRI, Lokal, LPS",
  status: "Aktif"
},
{
  nama: "183",
  koordinat: [-6.825277778, 108.3072222],
  radius: 12000,
  warnaLingkaran: "#8B5CF6",
  warnaIsi: "#C4B5FD",
  pembagian_kanal: "LPP RRI",
  status: "Aktif"
},
{
  nama: "194",
  koordinat: [-6.964166667, 108.2425],
  radius: 12000,
  warnaLingkaran: "#8B5CF6",
  warnaIsi: "#C4B5FD",
  pembagian_kanal: "LPP RRI",
  status: "Aktif"
},
{
  nama: "39",
  koordinat: [-6.835277778, 108.2277778],
  radius: 12000,
  warnaLingkaran: "#8B5CF6",
  warnaIsi: "#C4B5FD",
  pembagian_kanal: "LPP RRI",
  status: "Aktif"
},
{
  nama: "107",
  koordinat: [-7.684722222, 108.6533333],
  radius: 12000,
  warnaLingkaran: "#8B5CF6",
  warnaIsi: "#C4B5FD",
  pembagian_kanal: "LPP RRI",
  status: "Aktif"
},
{
  nama: "97",
  koordinat: [-7.715833333, 108.4427778],
  radius: 12000,
  warnaLingkaran: "#8B5CF6",
  warnaIsi: "#C4B5FD",
  pembagian_kanal: "LPP RRI",
  status: "Aktif"
},
{
  nama: "134",
  koordinat: [-6.673611111, 107.4805556],
  radius: 12000,
  warnaLingkaran: "#8B5CF6",
  warnaIsi: "#C4B5FD",
  pembagian_kanal: "LPP RRI, Lokal, LPS",
  status: "Aktif"
},
{
  nama: "102",
  koordinat: [-6.641666667, 107.3902778],
  radius: 12000,
  warnaLingkaran: "#8B5CF6",
  warnaIsi: "#C4B5FD",
  pembagian_kanal: "LPP RRI",
  status: "Aktif"
},
{
  nama: "3",
  koordinat: [-6.512222222, 107.4641667],
  radius: 12000,
  warnaLingkaran: "#8B5CF6",
  warnaIsi: "#C4B5FD",
  pembagian_kanal: "LPP RRI",
  status: "Aktif"
},
{
  nama: "118",
  koordinat: [-6.318333333, 107.6902778],
  radius: 12000,
  warnaLingkaran: "#8B5CF6",
  warnaIsi: "#C4B5FD",
  pembagian_kanal: "LPP RRI",
  status: "Aktif"
},
{
  nama: "2",
  koordinat: [-6.716388889, 107.7633333],
  radius: 12000,
  warnaLingkaran: "#8B5CF6",
  warnaIsi: "#C4B5FD",
  pembagian_kanal: "LPP RRI, Lokal, LPS",
  status: "Aktif"
},
{
  nama: "79",
  koordinat: [-6.495833333, 107.6583333],
  radius: 12000,
  warnaLingkaran: "#8B5CF6",
  warnaIsi: "#C4B5FD",
  pembagian_kanal: "LPP RRI",
  status: "Aktif"
},
{
  nama: "130",
  koordinat: [-6.434166667, 107.8313889],
  radius: 12000,
  warnaLingkaran: "#8B5CF6",
  warnaIsi: "#C4B5FD",
  pembagian_kanal: "LPP RRI, Lokal, LPS",
  status: "Aktif"
},
{
  nama: "185",
  koordinat: [-6.286388889, 107.8205556],
  radius: 12000,
  warnaLingkaran: "#8B5CF6",
  warnaIsi: "#C4B5FD",
  pembagian_kanal: "LPP RRI, Lokal, LPS",
  status: "Aktif"
},
{
  nama: "194",
  koordinat: [-6.673611111, 107.6525],
  radius: 12000,
  warnaLingkaran: "#8B5CF6",
  warnaIsi: "#C4B5FD",
  pembagian_kanal: "LPP RRI",
  status: "Aktif"
},
{
  nama: "67",
  koordinat: [-6.563055556, 107.7616667],
  radius: 12000,
  warnaLingkaran: "#8B5CF6",
  warnaIsi: "#C4B5FD",
  pembagian_kanal: "LPP RRI",
  status: "Aktif"
},
{
  nama: "38",
  koordinat: [-7.008333333, 106.7527778],
  radius: 12000,
  warnaLingkaran: "#8B5CF6",
  warnaIsi: "#C4B5FD",
  pembagian_kanal: "LPP RRI",
  status: "Aktif"
},
{
  nama: "161",
  koordinat: [-6.813611111, 106.7691667],
  radius: 12000,
  warnaLingkaran: "#8B5CF6",
  warnaIsi: "#C4B5FD",
  pembagian_kanal: "LPP RRI",
  status: "Aktif"
},
{
  nama: "163",
  koordinat: [-7.335833333, 106.8052778],
  radius: 12000,
  warnaLingkaran: "#8B5CF6",
  warnaIsi: "#C4B5FD",
  pembagian_kanal: "LPP RRI",
  status: "Aktif"
},
{
  nama: "4",
  koordinat: [-7.276111111, 106.5027778],
  radius: 12000,
  warnaLingkaran: "#8B5CF6",
  warnaIsi: "#C4B5FD",
  pembagian_kanal: "LPP RRI",
  status: "Aktif"
},
{
  nama: "35",
  koordinat: [-6.918333333, 106.4661111],
  radius: 12000,
  warnaLingkaran: "#8B5CF6",
  warnaIsi: "#C4B5FD",
  pembagian_kanal: "LPP RRI, Lokal, LPS",
  status: "Aktif"
},
{
  nama: "44",
  koordinat: [-6.831388889, 106.6630556],
  radius: 12000,
  warnaLingkaran: "#8B5CF6",
  warnaIsi: "#C4B5FD",
  pembagian_kanal: "LPP RRI",
  status: "Aktif"
},
{
  nama: "87",
  koordinat: [-7.269722222, 106.6252778],
  radius: 12000,
  warnaLingkaran: "#8B5CF6",
  warnaIsi: "#C4B5FD",
  pembagian_kanal: "LPP RRI",
  status: "Aktif"
},
{
  nama: "72",
  koordinat: [-6.985555556, 106.9427778],
  radius: 12000,
  warnaLingkaran: "#8B5CF6",
  warnaIsi: "#C4B5FD",
  pembagian_kanal: "LPP RRI, Lokal, LPS",
  status: "Aktif"
},
{
  nama: "159",
  koordinat: [-7.218611111, 106.8858333],
  radius: 12000,
  warnaLingkaran: "#8B5CF6",
  warnaIsi: "#C4B5FD",
  pembagian_kanal: "LPP RRI",
  status: "Aktif"
},
{
  nama: "107",
  koordinat: [-7.036666667, 106.5733333],
  radius: 12000,
  warnaLingkaran: "#8B5CF6",
  warnaIsi: "#C4B5FD",
  pembagian_kanal: "LPP RRI",
  status: "Aktif"
},
{
  nama: "158",
  koordinat: [-6.71, 107.9155556],
  radius: 12000,
  warnaLingkaran: "#8B5CF6",
  warnaIsi: "#C4B5FD",
  pembagian_kanal: "LPP RRI, Lokal, LPS",
  status: "Aktif"
},
{
  nama: "91",
  koordinat: [-6.837777778, 107.9275],
  radius: 12000,
  warnaLingkaran: "#8B5CF6",
  warnaIsi: "#C4B5FD",
  pembagian_kanal: "LPP RRI",
  status: "Aktif"
},
{
  nama: "44",
  koordinat: [-6.917777778, 108.0744444],
  radius: 12000,
  warnaLingkaran: "#8B5CF6",
  warnaIsi: "#C4B5FD",
  pembagian_kanal: "LPP RRI, Lokal, LPS",
  status: "Aktif"
},
{
  nama: "1",
  koordinat: [-7.5425, 108.0441667],
  radius: 12000,
  warnaLingkaran: "#8B5CF6",
  warnaIsi: "#C4B5FD",
  pembagian_kanal: "LPP RRI, Lokal, LPS",
  status: "Aktif"
},
{
  nama: "68",
  koordinat: [-7.158333333, 108.1472222],
  radius: 12000,
  warnaLingkaran: "#8B5CF6",
  warnaIsi: "#C4B5FD",
  pembagian_kanal: "LPP RRI, Lokal, LPS",
  status: "Aktif"
},
{
  nama: "129",
  koordinat: [-7.692777778, 108.2188889],
  radius: 12000,
  warnaLingkaran: "#8B5CF6",
  warnaIsi: "#C4B5FD",
  pembagian_kanal: "LPP RRI",
  status: "Aktif"
},
{
  nama: "103",
  koordinat: [-7.664444444, 108.0763889],
  radius: 12000,
  warnaLingkaran: "#8B5CF6",
  warnaIsi: "#C4B5FD",
  pembagian_kanal: "LPP RRI",
  status: "Aktif"
},
{
  nama: "148",
  koordinat: [-7.382222222, 108.0572222],
  radius: 12000,
  warnaLingkaran: "#8B5CF6",
  warnaIsi: "#C4B5FD",
  pembagian_kanal: "LPP RRI",
  status: "Aktif"
},
        // ... tambahkan semua wilayah lainnya
      ];

      wilayahList.forEach(wilayah => {
        const marker = L.marker(wilayah.koordinat, {
          icon: L.divIcon({
            className: 'wilayah-marker',
            html: `<div class="flex items-center justify-center w-6 h-6 bg-purple-600 rounded-full border-2 border-white shadow-lg"></div>`,
            iconSize: [24, 24],
            iconAnchor: [12, 12]
          })
        }).addTo(map);

        L.circle(wilayah.koordinat, {
          radius: wilayah.radius,
          color: wilayah.warnaLingkaran,
          fillColor: wilayah.warnaIsi,
          fillOpacity: 0.2,
          weight: 2,
          dashArray: '5, 5'
        }).addTo(map);

        marker.bindPopup(`
          <div class="p-3">
            <h3 class="font-bold text-purple-600">Kanal ${wilayah.nama}</h3>
            <table class="w-full text-sm mt-2">
              <tr>
                <td class="font-semibold pr-2">Radius:</td>
                <td>${wilayah.radius / 1000} km</td>
              </tr>
              <tr>
                <td class="font-semibold pr-2">Koordinat:</td>
                <td>${wilayah.koordinat[0].toFixed(4)}, ${wilayah.koordinat[1].toFixed(4)}</td>
              </tr>
              <tr>
                <td class="font-semibold pr-2">Pembagian Kanal:</td>
                <td class="font-bold text-purple-600">${wilayah.pembagian_kanal}</td>
              </tr>
              <tr>
                <td class="font-semibold pr-2">Status:</td>
                <td><span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs font-medium">${wilayah.status}</span></td>
              </tr>
            </table>
          </div>
        `);
      });

      // Define icons
      const defaultIcon = L.icon({
        iconUrl: 'https://unpkg.com/leaflet@1.9.4/dist/images/marker-icon.png',
        iconSize: [25, 41],
        iconAnchor: [12, 41],
        popupAnchor: [1, -34]
      });

      const pemancarIcon = L.icon({
        iconUrl: '/images/icon-pemancar.png', // Adjust path as needed
        iconSize: [28, 28],
        iconAnchor: [14, 28],
        popupAnchor: [0, -26]
      });

      const highlightedDefaultIcon = L.icon({
        iconUrl: 'https://unpkg.com/leaflet@1.9.4/dist/images/marker-icon.png',
        iconSize: [35, 51],
        iconAnchor: [17, 51],
        popupAnchor: [1, -44]
      });

      const highlightedPemancarIcon = L.icon({
        iconUrl: '/images/icon-pemancar.png', // Adjust path as needed
        iconSize: [38, 38],
        iconAnchor: [19, 38],
        popupAnchor: [0, -36]
      });

      // Marker groups
      var markerGroups = {};

      // Add pengukuran markers
      @foreach($pengukurans as $item)
        @if($item->pengukuranFrekuensi && $item->pengukuranFrekuensi->latitude && $item->pengukuranFrekuensi->longitude)
          var lat = {{ $item->pengukuranFrekuensi->latitude }};
          var lng = {{ $item->pengukuranFrekuensi->longitude }};
          var groupId = {{ $item->lokasi_pemancar_id ?? 'null' }}; // Adjust based on actual relationship, e.g., $item->data_isr->lokasiPemancar->id
          if (groupId !== null) {
            var marker = L.marker([lat, lng], {
              groupId: groupId,
              type: 'pengukuran',
              originalIcon: defaultIcon
            }).addTo(map);
            marker.setIcon(defaultIcon);

            var popupContent = `
              <div class="p-3">
                <h3 class="font-bold text-blue-600">{{ $item->data_isr->no_isr ?? 'Tidak ada ISR' }}</h3>
                <table class="mt-2 w-full">
                  <tr>
                    <td class="font-semibold pr-2">Frekuensi:</td>
                    <td>{{ $pengukuranPertama->frekuensi_terukur_mhz ?? '-' }} MHz</td>
                  </tr>
                  <tr>
                    <td class="font-semibold pr-2">Bandwidth:</td>
                    <td>{{ $pengukuranPertama->bandwidth_khz ?? '-' }} kHz</td>
                  </tr>
                  <tr>
                    <td class="font-semibold pr-2">Daya:</td>
                    <td>{{ $pengukuranPertama->output_power_tx ?? '-' }}</td>
                  </tr>
                  <tr>
                    <td class="font-semibold pr-2">H-1:</td>
                    <td>{{ $pengukuranPertama->level_h1_dbm ?? '-' }} dBm</td>
                  </tr>
                  <tr>
                    <td class="font-semibold pr-2">H-2:</td>
                    <td>{{ $pengukuranPertama->level_h2_dbm ?? '-' }} dBm</td>
                  </tr>
                  <tr>
                    <td class="font-semibold pr-2">H-3:</td>
                    <td>{{ $pengukuranPertama->level_h3_dbm ?? '-' }} dBm</td>
                  </tr>
                </table>
                               <button onclick="showDetail(
                  '{{ $item->data_isr->no_isr ?? '-' }}',
                  '{{ $pengukuranPertama->frekuensi_terukur_mhz ?? '-' }}',
                  '{{ $pengukuranPertama->bandwidth_khz ?? '-' }}',
                  '{{ $pengukuranPertama->output_power_tx ?? '-' }}',
                  '{{ $item->LokasiPemancar->latitude ?? '-' }}',
                  '{{ $item->LokasiPemancar->longitude ?? '-' }}',
                  '{{ $pengukuranPertama->level_h1_dbm ?? '-' }}',
                  '{{ $pengukuranPertama->level_h2_dbm ?? '-' }}',
                  '{{ $pengukuranPertama->level_h3_dbm ?? '-' }}',
                  '{{ $item->LokasiPemancar->alamat ?? '-' }}',
                  '{{ $item->LokasiPemancar->kota ?? '-' }}',
                  '{{ $item->LokasiPemancar->kecamatan ?? '-' }}',
                  '{{ $item->LokasiPemancar->kelurahan ?? '-' }}',
                 '{{ \Carbon\Carbon::parse($item->data_isr->tanggal)->translatedFormat("d F Y") ?? "-" }}',

                  '{{ $pengukuranPertama->field_strength ?? '-' }}',
                  '{{ $pengukuranPertama->deviasi_freq ?? '-' }}',
                  '{{ $pengukuranPertama->catatan ?? '-' }}'
                )" class="inline-block mt-2 px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600 text-sm">Detail</button>
              </div>
            `;
            marker.bindPopup(popupContent);

            if (!markerGroups[groupId]) markerGroups[groupId] = [];
            markerGroups[groupId].push(marker);

            marker.on('click', function() {
              highlightGroup(this.options.groupId);
            });
          }
        @endif
      @endforeach

      // Add lokasiPemancar markers
      @foreach ($lokasiPemancars as $lp)
        @if ($lp->latitude && $lp->longitude)
          var lpLat = {{ $lp->latitude }};
          var lpLng = {{ $lp->longitude }};
          var groupId = {{ $lp->id }};
          var lpMarker = L.marker([lpLat, lpLng], {
            groupId: groupId,
            type: 'lokasiPemancar',
            originalIcon: pemancarIcon
          }).addTo(map);
          lpMarker.setIcon(pemancarIcon);

          var lpPopup = `
            <div class="p-3">
              <h3 class="font-bold text-red-600">Stasiun Pemancar</h3>
              <p class="mb-1">{{ $lp->alamat ?? '-' }}</p>
              <table class="w-full text-sm">
                <tr><td class="font-semibold pr-2">Koordinat:</td><td>{{ $lp->latitude }}, {{ $lp->longitude }}</td></tr>
                <tr><td class="font-semibold pr-2">Kel./Kec.:</td><td>{{ $lp->kelurahan ?? '-' }}/{{ $lp->kecamatan ?? '-' }}</td></tr>
                <tr><td class="font-semibold pr-2">Tinggi mdpl:</td><td>{{ $lp->tinggi_lokasi_mdpl ?? '-' }} m</td></tr>
              </table>
            </div>
          `;
          lpMarker.bindPopup(lpPopup);

          if (!markerGroups[groupId]) markerGroups[groupId] = [];
          markerGroups[groupId].push(lpMarker);

          lpMarker.on('click', function() {
            highlightGroup(this.options.groupId);
          });
        @endif
      @endforeach

      // Highlight function
      function highlightGroup(groupId) {
        // Reset all markers
        for (var id in markerGroups) {
          markerGroups[id].forEach(function(m) {
            m.setIcon(m.options.originalIcon);
          });
        }
        // Highlight the group
        if (markerGroups[groupId]) {
          markerGroups[groupId].forEach(function(m) {
            if (m.options.type === 'pengukuran') {
              m.setIcon(highlightedDefaultIcon);
            } else if (m.options.type === 'lokasiPemancar') {
              m.setIcon(highlightedPemancarIcon);
            }
          });
        }
      }

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
        showMapBtn.style.backgroundColor = "#EDBC1B";
        showTableBtn.style.backgroundColor = "#006DB0";
      });

      showTableBtn.addEventListener("click", () => {
        hideAllContainers();
        tableContainer.classList.remove("hidden");
        showTableBtn.style.backgroundColor = "#EDBC1B";
        showMapBtn.style.backgroundColor = "#006DB0";
      });

      // Default tampilkan map
      hideAllContainers();
      mapContainer.classList.remove("hidden");
      
      // Hapus loading animation setelah halaman selesai dimuat
      setTimeout(() => {
        document.querySelector('.loading-animation').style.display = 'none';
      }, 800);
    });
    
    // Detail Modal Functions
    function showDetail(noIsr, frekuensi, bandwidth, daya, lat, lng, h1, h2, h3, alamat, kota, kecamatan, kelurahan, tanggalUkur, fieldStrength, deviasi, catatan) {
      // Informasi Dasar
      document.getElementById('modalNoISR').innerText = noIsr;
      document.getElementById('modalTanggalUkur').innerText = tanggalUkur;
      
      // Lokasi Pemancar
      document.getElementById('modalAlamat').innerText = alamat;
      document.getElementById('modalKota').innerText = kota;
      document.getElementById('modalKecamatan').innerText = kecamatan;
      document.getElementById('modalKelurahan').innerText = kelurahan;
      document.getElementById('modalKoordinat').innerText = `${lat}, ${lng}`;
      
      // Parameter Teknis
      document.getElementById('modalFrekuensi').innerText = `${frekuensi} MHz`;
      document.getElementById('modalBandwidth').innerText = `${bandwidth} kHz`;
      document.getElementById('modalDaya').innerText = `${daya} W`;
      document.getElementById('modalDeviasi').innerText = deviasi && deviasi !== '-' ? `${deviasi} kHz` : 'Tidak tersedia';


    
      
      // Harmonisa
      document.getElementById('modalH1').innerText = `${h1} dBm`;
      document.getElementById('modalH2').innerText = `${h2} dBm`;
      document.getElementById('modalH3').innerText = `${h3} dBm`;
      
      // Menghitung persentase untuk progress bar berdasarkan nilai dBm
      // Asumsi: nilai dBm berkisar antara -120 dBm hingga 0 dBm
      // Kita konversi ke persentase 0-100%
      const h1Value = parseFloat(h1);
      const h2Value = parseFloat(h2);
      const h3Value = parseFloat(h3);
      
      const minDbm = -120;
      const maxDbm = 0;
      const range = maxDbm - minDbm;
      
      const h1Percent = Math.min(100, Math.max(0, ((h1Value - minDbm) / range) * 100));
      const h2Percent = Math.min(100, Math.max(0, ((h2Value - minDbm) / range) * 100));
      const h3Percent = Math.min(100, Math.max(0, ((h3Value - minDbm) / range) * 100));
      
      // Update progress bars
      document.getElementById('modalH1Bar').style.width = `${h1Percent}%`;
      document.getElementById('modalH2Bar').style.width = `${h2Percent}%`;
      document.getElementById('modalH3Bar').style.width = `${h3Percent}%`;
      
      // Set class untuk progress bars berdasarkan nilai
      document.getElementById('modalH1Bar').className = `progress-bar ${h1Percent > 70 ? 'high' : h1Percent > 40 ? 'medium' : 'low'}`;
      document.getElementById('modalH2Bar').className = `progress-bar ${h2Percent > 70 ? 'high' : h2Percent > 40 ? 'medium' : 'low'}`;
      document.getElementById('modalH3Bar').className = `progress-bar ${h3Percent > 70 ? 'high' : h3Percent > 40 ? 'medium' : 'low'}`;
      
      // Catatan
      document.getElementById('modalCatatan').innerText = catatan || 'Tidak ada catatan';

      // Tampilkan modal
      document.getElementById('detailModal').classList.remove('hidden');
    }

    function closeModal() {
      document.getElementById('detailModal').classList.add('hidden');
    }
  </script>
</body>
</html>


