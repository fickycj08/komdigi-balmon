<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Gangguan Page</title>
  @vite('resources/css/app.css')
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&display=swap" rel="stylesheet" />
  <!-- Leaflet CSS -->
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin="" />
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<style>
  
</style>

<body class="bg-[#DFF9FF]">
  <div class="loading-animation">
    <div class="spinner"></div>
  </div>

  <!-- HEADER -->
  <header
    class="fixed top-0 left-0 w-full bg-[#378EC3] text-white shadow-md p-4 text-[22px] flex flex-col justify-center items-center font-[Inter] font-bold tracking-[8px]">
    <h1 class="text-xl font-bold">BALAI MONITORING</h1>
    <h1 class="text-xl font-bold">SPEKTRUM FREKUENSI RADIO KELAS 1 BANDUNG</h1>
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
      class="fixed md:relative md:translate-x-0 transform -translate-x-full transition-transform duration-300 ease-in-out w-64 bg-white h-screen p-4 flex flex-col z-40">
      <div class="flex-1 overflow-y-auto">
        <!-- Logo -->
        <a href="#" class="flex items-center ps-2.5 pl-[45px] pt-[18px] pb-[74px]">
          <img src="/images/logo_kominfo.png" class="h-[145px] w-[145px] me-3 sm:h-[145px] sm:w-[145px]"
            alt="Logo Kominfo" />
        </a>

        <!-- Menu -->
        <ul class="space-y-2 font-medium">
          <li class="h-[20px] w-[215px] pl-[20px] pr-[10px]">
            <a href="#"
              class="flex items-center p-2 pl-[20px] bg-[#ffffff] text-gray-900 rounded-lg hover:bg-[#70C1F3] group">
              <x-heroicon-s-home class="w-6 h-6 text-gray-900" />
              <span class="ms-3 text-[26px] text-gray-900">Beranda</span>
            </a>
          </li>
          <div class="ms-3 text-[22px] pt-[60px] pb-[20px] text-zinc-600">Menu Layanan</div>
          <li>
            <a href="#" class="flex items-center p-2 px-[20px] text-gray-900 rounded-lg hover:bg-[#70C1F3] group">
              <x-heroicon-o-computer-desktop class="w-6 h-6" />
              <span class="ms-3 text-[26px] text-stone-950">Monitoring</span>
            </a>
          </li>
          <li class="pt-[10px]">
            <a href="#" class="flex items-center p-2 px-[20px] text-gray-900 rounded-lg hover:bg-[#70C1F3] group">
              <x-heroicon-o-arrow-trending-up class="w-6 h-6" />
              <span class="ms-3 text-[26px] text-stone-950">Pengukuran</span>
            </a>
          </li>
          <li class="h-[20px] w-[215px] pt-[10px] px-[10px]">
            <a href="#"
              class="flex items-center p-2 pl-[20px] bg-[#70C1F3] text-gray-900 rounded-lg hover:bg-[#70C1F3] group">
              <x-heroicon-s-exclamation-triangle class="w-6 h-6 text-green-50" />
              <span class="ms-3 font-bold text-[26px] text-green-50">Gangguan</span>
            </a>
          </li>
          <li class="pt-[60px]">
            <a href="/admin" class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-[#70C1F3] group">
              <x-heroicon-o-key class="w-6 h-6 text-stone-950" />
              <span class="flex-1 ms-3 whitespace-nowrap text-[22px] text-stone-950">Edit Menu</span>
              <span
                class="inline-flex items-center justify-center px-2 ms-3 text-sm font-medium text-gray-800 bg-gray-100 rounded-full">Admin</span>
            </a>
          </li>
        </ul>
      </div>

      <!-- Tombol Logout -->
      <div class="p-4">
        <a href="#" class="flex items-center p-2 px-[30px] bg-[#FF0000] text-white rounded-lg hover:bg-red-600 group">
          <x-heroicon-s-exclamation-triangle class="w-6 h-6 text-white" />
          <span class="ms-3 text-[22px] text-white font-bold">Log-Out</span>
        </a>
      </div>
    </aside>

    <!-- Ubah bagian Main Content -->
    <main class="flex-1 p-8 min-h-screen main-content md:ml-[100px] md:mr-[100px] pt-[130px]">
      <!-- Container untuk Filter -->
      <div class="bg-white shadow-md rounded-lg p-4 mb-4 flex flex-wrap items-center gap-4">
        <div>
          <label for="filterKota" class="block text-gray-700 font-bold mb-1">Filter Kota:</label>
          <select id="filterKota" class="border border-gray-300 rounded-md px-4 py-2">
            <option value="">Semua</option>
            @foreach ($locations as $kota)
        <option value="{{ $kota }}">{{ $kota }}</option>
      @endforeach
          </select>
        </div>

        <div>
          <label for="filterTahun" class="block text-gray-700 font-bold mb-1">Filter Tahun:</label>
          <select id="filterTahun" class="border border-gray-300 rounded-md px-4 py-2">
            <option value="">Semua</option>
            @for ($tahun = date('Y'); $tahun >= 2000; $tahun--)
        <option value="{{ $tahun }}">{{ $tahun }}</option>
      @endfor
          </select>
        </div>
      </div>

      <!-- Container untuk Maps dan Buttons -->
      <div class="bg-stone-50 rounded-lg p-4 mb-6">
        <!-- Toggle Buttons -->
        <div class="flex space-x-4 mb-4" id="toggleButtons">
        <button id="showMap" class="px-4 py-2 bg-[#EDBC1B] text-white rounded-[6px] transition-colors font-[Inter]">
  Tampilkan Maps
</button>
<button id="showTable" class="px-4 py-2 bg-[#006DB0] text-white rounded-[6px] transition-colors font-[Inter]">
  Tampilkan Gangguan
</button>
        </div>
        <!-- Map Container -->
        <div id="mapContainer" class="rounded-lg">
          <div id="map" class="w-full h-full rounded-lg"></div>
        </div>
      </div>

      <!-- Table Container -->
      <div id="tableContainer" class="bg-white shadow-md rounded-lg p-4 table-container">
        <h1 class="text-2xl md:text-3xl font-bold mb-4">Daftar Gangguan</h1>
        <div class="overflow-x-visible">
          <table class="w-full border-collapse border border-gray-300">
            <thead>
              <tr class="bg-gray-200">
                <th class="border border-gray-300 p-2 text-sm md:text-base">Nama Client</th>
                <th class="border border-gray-300 p-2 text-sm md:text-base">Lokasi</th>
                <th class="border border-gray-300 p-2 text-sm md:text-base">Frekuensi</th>
                <th class="border border-gray-300 p-2 text-sm md:text-base">No ST</th>
                <th class="border border-gray-300 p-2 text-sm md:text-base">VIC</th>
                <th class="border border-gray-300 p-2 text-sm md:text-base">No Laporan</th>
                <th class="border border-gray-300 p-2 text-sm md:text-base hidden md:table-cell">Band</th>
                <th class="border border-gray-300 p-2 text-sm md:text-base hidden lg:table-cell">Sub-Service</th>
                <th class="border border-gray-300 p-2 text-sm md:text-base">Jenis</th>
                <th class="border border-gray-300 p-2 text-sm md:text-base hidden xl:table-cell">Koordinat</th>
                <th class="border border-gray-300 p-2 text-sm md:text-base">Uraian</th>
                <th class="border border-gray-300 p-2 text-sm md:text-base">Waktu Kejadian</th>
                <th class="border border-gray-300 p-2 text-sm md:text-base">Aksi</th>
                <th class="border border-gray-300 p-2 text-sm md:text-base">File</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($gangguan as $item)
            <tr class="hover:bg-gray-100">
            <td class="border border-gray-300 p-2 text-sm md:text-base">{{ $item->nama_client }}</td>
            <td class="border border-gray-300 p-2 text-sm md:text-base">
              {{ $item->location->kota ?? 'N/A' }}
            </td>
            <td class="border border-gray-300 p-2 text-sm md:text-base text-center">
              {{ $item->frekuensi }}
            </td>
            <td class="border border-gray-300 p-2 text-sm md:text-base text-center">
              {{ $item->no_st }}
            </td>
            <td class="border border-gray-300 p-2 text-sm md:text-base text-center">
              {{ $item->vic }}
            </td>
            <td class="border border-gray-300 p-2 text-sm md:text-base text-center">
              {{ $item->no_laporan }}
            </td>
            <td class="border border-gray-300 p-2 text-sm md:text-base hidden md:table-cell">
              {{ $item->band_frekuensi }}
            </td>
            <td class="border border-gray-300 p-2 text-sm md:text-base hidden lg:table-cell">
              {{ $item->sub_service }}
            </td>
            <td class="border border-gray-300 p-2 text-sm md:text-base">
              {{ $item->jenis_gangguan }}
            </td>
            <td class="border border-gray-300 p-2 text-sm md:text-base hidden xl:table-cell">
              {{ round($item->latitude, 3) }}, {{ round($item->longitude, 3) }}
            </td>
            <td class="border border-gray-300 p-2 text-sm md:text-base">
              <div class="max-w-[200px] md:max-w-[300px] lg:max-w-[400px] truncate hover:whitespace-normal">
              {{ $item->uraian_gangguan }}
              </div>
            </td>
            <td class="border border-gray-300 p-2 text-sm md:text-base">
              <div class="max-w-[200px] md:max-w-[300px] lg:max-w-[400px] truncate hover:whitespace-normal">
              {{ $item->waktu_kejadian }}
              </div>
            </td>
            <td class="border border-gray-300 p-2 text-sm md:text-base text-center">
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
          '{{ optional($item->pengganggu->first())->longitude ?? 'N/A' }}'
        )" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-3 rounded">
              Lihat Detail
              </button>

            </td>
            <td class="border border-gray-300 p-2 text-sm md:text-base text-center">
              @if($item->file_path)
          <a href="{{ asset('storage/' . $item->file_path) }}" download
          class="bg-green-500 hover:bg-green-700 text-white font-bold py-1 px-3 rounded">
          Download File
          </a>
        @else
        <span class="text-gray-400">Tidak ada file</span>
      @endif
            </td>
            </tr>
        @endforeach
            </tbody>
          </table>
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
                    <p class="text-xs text-gray-500">VIC</p>
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
            <a href="{{ route('export.pdf') }}"
              class="px-6 py-2 bg-[#EDBC1B] hover:bg-[#d6a716] text-white rounded-lg font-medium transition-colors">
              <x-heroicon-s-arrow-down-tray class="w-5 h-5 inline mr-2" />
              Export PDF
            </a>
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

    // Filter untuk tabel
    document.addEventListener("DOMContentLoaded", function () {
      const filterKota = document.getElementById("filterKota");
      const filterTahun = document.getElementById("filterTahun");
      const gangguanRows = document.querySelectorAll("#tableContainer tbody tr");

      function applyFilters() {
        const selectedKota = filterKota.value.toLowerCase().trim();
        const selectedTahun = filterTahun.value.trim();

        gangguanRows.forEach(row => {
          const kota = row.cells[1].textContent.toLowerCase().trim();
          // Misal tanggal terdapat di cell ke-4 (sesuaikan bila perlu)
          const tanggal = row.cells[11].textContent.trim();
          const tahun = tanggal.substring(0, 4);
          const kotaMatch = selectedKota === "" || kota.includes(selectedKota);
          const tahunMatch = selectedTahun === "" || tahun === selectedTahun;
          row.style.display = (kotaMatch && tahunMatch) ? "" : "none";
        });
      }

      filterKota.addEventListener("change", applyFilters);
      filterTahun.addEventListener("change", applyFilters);
      applyFilters();
    });

    // Map & Table Toggle
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

      var gangguanData = {!! json_encode($gangguan, JSON_HEX_TAG) !!};

      gangguanData.forEach(gangguan => {
        if (gangguan.latitude && gangguan.longitude) {
          // Buat marker tanpa bindPopup
          const marker = L.marker([gangguan.latitude, gangguan.longitude]).addTo(map);
          // Tambahkan event listener pada marker untuk membuka modal detail
          // Untuk marker map
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
      });

      showTableBtn.addEventListener("click", () => {
        hideAllContainers();
        tableContainer.classList.remove("hidden");
      });

      // Default tampilkan map
      hideAllContainers();
      mapContainer.classList.remove("hidden");
    });

    // Hilangkan loading animation
    document.addEventListener("DOMContentLoaded", function () {
      setTimeout(() => {
        document.querySelector(".loading-animation").style.display = "none";
      }, 500);
    });

    // Fungsi untuk menampilkan modal detail (menampilkan seluruh data gangguan dan pengganggu)
    function showDetail(
      namaClient,
      kecamatan,
      waktuKejadian,
      jenisGangguan,
      severity,
      frekuensi,
      bandFrekuensi,
      service,
      subService,
      sifatGangguan,
      uraianGangguan,
      latitude,
      longitude,
      penggangguNama,
      penggangguJenisOrg,
      penggangguFrekuensi,
      penggangguStatus,
      penggangguKota,
      // Parameter tambahan
      noST,
      vic,
      noLaporan,

      penggangguBandFrekuensi,
      penggangguService,
      penggangguSubService,
      penggangguKecamatan,
      penggangguLatitude,
      penggangguLongitude
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
        // Coba parse tanggal
        const date = new Date(dateString);

        // Format tanggal ke format yang diinginkan (DD-MM-YYYY HH:MM:SS)
        const day = String(date.getDate()).padStart(2, '0');
        const month = String(date.getMonth() + 1).padStart(2, '0');
        const year = date.getFullYear();
        const hours = String(date.getHours()).padStart(2, '0');
        const minutes = String(date.getMinutes()).padStart(2, '0');
        const seconds = String(date.getSeconds()).padStart(2, '0');

        return `${day}-${month}-${year} ${hours}:${minutes}:${seconds}`;
      } catch (e) {
        // Jika gagal parsing, kembalikan string asli
        return dateString;
      }
    }

    
    const mapContainer = document.getElementById("mapContainer");
  const tableContainer = document.getElementById("tableContainer");
  const showMapBtn = document.getElementById("showMap");
  const showTableBtn = document.getElementById("showTable");

  function hideAllContainers() {
    mapContainer.classList.add("hidden");
    tableContainer.classList.add("hidden");
  }

  // Event listener untuk tombol "Tampilkan Maps"
  showMapBtn.addEventListener("click", () => {
    hideAllContainers();
    mapContainer.classList.remove("hidden");
    // Jika menggunakan Leaflet, pastikan map menyesuaikan ukurannya
    setTimeout(() => {
      map.invalidateSize();
    }, 200);
    
    // Update warna tombol
    showMapBtn.style.backgroundColor = "#EDBC1B";   // aktif
    showTableBtn.style.backgroundColor = "#006DB0";   // tidak aktif
  });

  // Event listener untuk tombol "Tampilkan Gangguan"
  showTableBtn.addEventListener("click", () => {
    hideAllContainers();
    tableContainer.classList.remove("hidden");

    // Update warna tombol
    showTableBtn.style.backgroundColor = "#EDBC1B";    // aktif
    showMapBtn.style.backgroundColor = "#006DB0";      // tidak aktif
  });


  </script>

  <!-- Leaflet JS -->
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin=""></script>
  </main>
  </div>
</body>

</html>