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

    /* ==== SUPER WILAYAH POPUP - REDESIGNED ==== */
    .leaflet-popup-content-wrapper.wilayah-popup {
      max-width: 95vw !important;
      min-width: 0 !important;
      box-sizing: border-box;
      background: rgba(255, 255, 255, 0.85);
      border-radius: 20px;
      border: none;
      box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15), 0 5px 15px rgba(0, 0, 0, 0.08);
      padding: 0;
      overflow: hidden;
      backdrop-filter: blur(10px);
      transform-origin: bottom center;
      animation: popupFloat 0.5s cubic-bezier(0.34, 1.56, 0.64, 1);
    }

    @keyframes popupFloat {
      0% {
        opacity: 0;
        transform: translateY(20px) scale(0.9);
      }

      100% {
        opacity: 1;
        transform: translateY(0) scale(1);
      }
    }

    .leaflet-popup-content.wilayah-popup-content {
      padding: 0;
      margin: 0;
      min-width: 220px;
      /* boleh kecilin jadi 180-220px */
      max-width: 340px;
      /* tambah max-width agar tidak over */
      width: 100%;
      font-size: 1rem;
      /* selalu pakai rem, jangan vw/vh di popup */
    }

    .wilayah-popup-card {
      position: relative;
      overflow: hidden;
    }

    /* Animated Background */
    .wilayah-popup-card::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: linear-gradient(120deg, rgba(139, 92, 246, 0.05), rgba(56, 189, 248, 0.05), rgba(196, 181, 253, 0.05));
      background-size: 200% 200%;
      animation: gradientBG 15s ease infinite;
      z-index: -1;
    }

    @keyframes gradientBG {
      0% {
        background-position: 0% 50%
      }

      50% {
        background-position: 100% 50%
      }

      100% {
        background-position: 0% 50%
      }
    }

    /* Header Styling */
    .wilayah-popup-header {
      position: relative;
      background: linear-gradient(135deg, #8b5cf6 0%, #6366f1 100%);
      color: white;
      padding: 1.5rem 1.5rem 1.5rem 5rem;
      font-size: 1.3rem;
      font-weight: 800;
      letter-spacing: 0.5px;
      text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
      overflow: hidden;
    }

    /* Animated Wave Effect in Header */
    .wilayah-popup-header::after {
      content: '';
      position: absolute;
      left: 0;
      right: 0;
      bottom: 0;
      height: 10px;
      background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 1200 120' preserveAspectRatio='none'%3E%3Cpath d='M0,0V46.29c47.79,22.2,103.59,32.17,158,28,70.36-5.37,136.33-33.31,206.8-37.5C438.64,32.43,512.34,53.67,583,72.05c69.27,18,138.3,24.88,209.4,13.08,36.15-6,69.85-17.84,104.45-29.34C989.49,25,1113-14.29,1200,52.47V0Z' opacity='.25' fill='%23FFFFFF'%3E%3C/path%3E%3Cpath d='M0,0V15.81C13,36.92,27.64,56.86,47.69,72.05,99.41,111.27,165,111,224.58,91.58c31.15-10.15,60.09-26.07,89.67-39.8,40.92-19,84.73-46,130.83-49.67,36.26-2.85,70.9,9.42,98.6,31.56,31.77,25.39,62.32,62,103.63,73,40.44,10.79,81.35-6.69,119.13-24.28s75.16-39,116.92-43.05c59.73-5.85,113.28,22.88,168.9,38.84,30.2,8.66,59,6.17,87.09-7.5,22.43-10.89,48-26.93,60.65-49.24V0Z' opacity='.5' fill='%23FFFFFF'%3E%3C/path%3E%3Cpath d='M0,0V5.63C149.93,59,314.09,71.32,475.83,42.57c43-7.64,84.23-20.12,127.61-26.46,59-8.63,112.48,12.24,165.56,35.4C827.93,77.22,886,95.24,951.2,90c86.53-7,172.46-45.71,248.8-84.81V0Z' fill='%23FFFFFF'%3E%3C/path%3E%3C/svg%3E") no-repeat;
      background-size: cover;
    }

    /* Circular Icon in Header */
    .wilayah-popup-header::before {
      content: '';
      position: absolute;
      left: 1.2rem;
      top: 50%;
      transform: translateY(-50%);
      width: 3rem;
      height: 3rem;
      background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='%23ffffff'%3E%3Cpath d='M12 11.5A2.5 2.5 0 0 1 9.5 9 2.5 2.5 0 0 1 12 6.5 2.5 2.5 0 0 1 14.5 9a2.5 2.5 0 0 1-2.5 2.5M12 2a7 7 0 0 0-7 7c0 5.25 7 13 7 13s7-7.75 7-13a7 7 0 0 0-7-7z'/%3E%3C/svg%3E") no-repeat center center;
      background-color: rgba(255, 255, 255, 0.2);
      border-radius: 50%;
      box-shadow: 0 0 0 5px rgba(255, 255, 255, 0.1), 0 0 20px rgba(0, 0, 0, 0.2);
      animation: pulseIcon 2s infinite;
    }

    @keyframes pulseIcon {
      0% {
        transform: translateY(-50%) scale(1);
        box-shadow: 0 0 0 0 rgba(255, 255, 255, 0.4);
      }

      70% {
        transform: translateY(-50%) scale(1.05);
        box-shadow: 0 0 0 10px rgba(255, 255, 255, 0);
      }

      100% {
        transform: translateY(-50%) scale(1);
        box-shadow: 0 0 0 0 rgba(255, 255, 255, 0);
      }
    }

    /* Content Sections */
    .wilayah-popup-section {
      position: relative;
      padding: 1rem 1.5rem;
      border-bottom: 1px solid rgba(139, 92, 246, 0.1);
      transition: all 0.3s ease;
      display: flex;
      flex-direction: column;
    }

    .wilayah-popup-section:hover {
      background-color: rgba(139, 92, 246, 0.05);
      transform: translateX(5px);
    }

    .wilayah-popup-section:last-child {
      border-bottom: none;
      padding-bottom: 1.5rem;
    }

    /* Section Icon */
    .wilayah-popup-section::before {
      content: '';
      position: absolute;
      left: 0;
      top: 50%;
      transform: translateY(-50%);
      width: 4px;
      height: 60%;
      background: linear-gradient(to bottom, #8b5cf6, #6366f1);
      border-radius: 0 4px 4px 0;
      opacity: 0;
      transition: opacity 0.3s ease;
    }

    .wilayah-popup-section:hover::before {
      opacity: 1;
    }

    /* Labels and Values */
    .wilayah-popup-label {
      font-size: 0.75rem;
      text-transform: uppercase;
      letter-spacing: 1px;
      color: #6366f1;
      font-weight: 700;
      margin-bottom: 0.3rem;
      display: flex;
      align-items: center;
    }

    .wilayah-popup-label::before {
      content: '';
      display: inline-block;
      width: 8px;
      height: 8px;
      background-color: #8b5cf6;
      margin-right: 0.5rem;
      border-radius: 50%;
      box-shadow: 0 0 0 2px rgba(139, 92, 246, 0.2);
    }

    .wilayah-popup-value {
      font-size: 1.05rem;
      font-weight: 600;
      color: #1f2937;
      margin-left: 1rem;
      line-height: 1.4;
    }

    /* Status Badge */
    .wilayah-popup-badge {
      display: inline-block;
      margin: 0.5rem 0;
      align-self: flex-end;
      padding: 0.4rem 1.2rem;
      border-radius: 30px;
      font-weight: 700;
      font-size: 0.85rem;
      letter-spacing: 1px;
      text-transform: uppercase;
      background: linear-gradient(135deg, #10b981 0%, #34d399 100%);
      color: white;
      box-shadow: 0 4px 15px rgba(16, 185, 129, 0.4);
      position: relative;
      overflow: hidden;
      transition: all 0.3s ease;
    }

    .wilayah-popup-badge::before {
      content: '';
      position: absolute;
      top: -50%;
      left: -50%;
      width: 200%;
      height: 200%;
      background: radial-gradient(circle, rgba(255, 255, 255, 0.3) 0%, transparent 70%);
      transform: rotate(0deg);
      transition: transform 0.5s ease;
    }

    .wilayah-popup-badge:hover::before {
      transform: rotate(180deg);
    }

    .wilayah-popup-badge.inactive {
      background: linear-gradient(135deg, #ef4444 0%, #f87171 100%);
      box-shadow: 0 4px 15px rgba(239, 68, 68, 0.4);
    }

    /* Footer with additional info */
    .wilayah-popup-footer {
      background: linear-gradient(to right, rgba(139, 92, 246, 0.05), rgba(99, 102, 241, 0.1));
      padding: 0.75rem 1.5rem;
      font-size: 0.8rem;
      color: #6366f1;
      text-align: center;
      font-weight: 500;
      border-top: 1px dashed rgba(139, 92, 246, 0.2);
    }

    /* Responsive adjustments */
    @media (max-width: 520px) {
      .leaflet-popup-content.wilayah-popup-content {
        min-width: 140px !important;
        max-width: 94vw !important;
        font-size: 0.96rem !important;
      }
    }

    .wilayah-popup-header {
      padding: 1.2rem 1.2rem 1.2rem 4rem;
      font-size: 1.1rem;
    }

    .wilayah-popup-header::before {
      left: 0.8rem;
      width: 2.5rem;
      height: 2.5rem;
    }

    .wilayah-popup-section {
      padding: 0.8rem 1.2rem;
    }

    .wilayah-popup-value {
      font-size: 0.95rem;
    }
    }

    .leaflet-popup-content-wrapper.pengukuran-popup {
      max-width: 95vw !important;
      min-width: 320px !important;
      border-radius: 20px;
      box-shadow: 0 10px 32px rgba(55, 142, 195, 0.11);
      padding: 0;
      font-family: 'Inter', sans-serif;
    }

    .leaflet-popup-content.pengukuran-popup-content {
      padding: 0.5rem 1.2rem;
      min-width: 240px;
      max-width: 480px;
      width: 100%;
      overflow-x: auto;
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


          <ul class="space-y-1 px-2">


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

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">


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

          <div class="relative">
            <label for="filterKota" class="block text-gray-700 text-sm font-medium mb-2">Kota/Kabupaten:</label>
            <select id="filterKota"
              class="block w-full bg-gray-50 border border-gray-300 text-gray-700 py-3 px-4 pr-8 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
              <option value="">Semua Kota</option>
              @foreach ($locations as $loc)
          <option value="{{ $loc->id }}">{{ $loc->kota }}</option>
        @endforeach
            </select>
          </div>

          <div class="relative">
            <label for="filterKotaPemancar" class="block text-gray-700 text-sm font-medium mb-2">Kota Pemancar:</label>
            <select id="filterKotaPemancar"
              class="block w-full bg-gray-50 border border-gray-300 text-gray-700 py-3 px-4 pr-8 rounded-lg">
              <option value="">Semua Kota</option>
              @foreach($lokasiPemancars->pluck('location_id')->unique() as $locId)
          <option value="{{ $locId }}">{{ $locations->firstWhere('id', $locId)->kota }}</option>
        @endforeach
            </select>
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
            <a href="https://maps.google.com/?q=-6.200000,106.816666" target="_blank"
              class="ml-4 px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg shadow transition inline-block">
              Lihat Alamat
            </a>
          </h2>


          <div class="flex space-x-3" id="toggleButtons">
            <button id="showMap"
              class="relative px-5 py-2.5 bg-[#EDBC1B] text-white rounded-lg transition-all duration-200 font-medium flex items-center shadow-md hover:shadow-lg transform hover:translate-y-[-2px] group"
              type="button">
              <x-heroicon-s-globe-alt class="w-5 h-5 mr-2" />
              Tampilkan Maps
              <!-- Tooltip -->
              <span
                class="absolute left-1/2 bottom-full mb-3 -translate-x-1/2 px-3 py-2 bg-black text-xs text-white rounded-md opacity-0 group-hover:opacity-100 transition pointer-events-none whitespace-nowrap z-20 shadow-lg">
                Visualisasi data gangguan di peta interaktif
              </span>
            </button>
            <button id="showTable"
              class="relative px-5 py-2.5 bg-[#006DB0] text-white rounded-lg transition-all duration-200 font-medium flex items-center shadow-md hover:shadow-lg transform hover:translate-y-[-2px] group"
              type="button">
              <x-heroicon-s-table-cells class="w-5 h-5 mr-2" />
              Tampilkan Data Tabel
              <!-- Tooltip -->
              <span
                class="absolute left-1/2 bottom-full mb-3 -translate-x-1/2 px-3 py-2 bg-black text-xs text-white rounded-md opacity-0 group-hover:opacity-100 transition pointer-events-none whitespace-nowrap z-20 shadow-lg">
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
            <h1 class="text-2xl md:text-3xl font-bold text-[#006DB0]">Data Pengukuran</h1>
            <div class="flex space-x-2">

            </div>
          </div>

          <div class="overflow-hidden rounded-xl shadow-md border border-gray-100">
            <div class="overflow-x-auto">
              <table class="w-full border-collapse">
                <thead>
                  <tr class="bg-gradient-to-r from-[#378EC3] to-[#70C1F3] text-white">
                    <th class="p-3 text-left font-semibold text-sm md:text-base">Nama Stasiun</th>
                    <th class="p-3 text-left font-semibold text-sm md:text-base">Frekuensi (MHz)</th>
                    <th class="p-3 text-left font-semibold text-sm md:text-base">Bandwidth</th>
                    <th class="p-3 text-left font-semibold text-sm md:text-base">Deviasi</th>

                    <th class="p-3 text-left font-semibold text-sm md:text-base hidden lg:table-cell">H-1</th>
                    <th class="p-3 text-left font-semibold text-sm md:text-base hidden xl:table-cell">H-2</th>
                    <th class="p-3 text-left font-semibold text-sm md:text-base">H-3</th>
                    <th class="p-3 text-center font-semibold text-sm md:text-base">Aksi</th>
                  </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                  @foreach ($pengukurans as $index => $item)
                  <tr class="hover:bg-blue-50 transition-colors {{ $index % 2 == 0 ? 'bg-white' : 'bg-gray-50' }}"
                  data-kota="{{ $item->pengukuranFrekuensi->location_id ?? '-' }}"
                  data-tahun="{{ \Carbon\Carbon::parse($item->created_at)->format('Y') }}">
                  <!-- Nomor ISR -->
                  <td class="p-3 text-sm text-gray-800">
                    <div class="font-medium text-gray-800">{{ $item->stasiunRadio->nama_penyelenggara ?? '-' }}</div>
                  </td>
                  @php
                $pengukuranPertama = $item->pengukuranFrekuensi ?? null;
              @endphp
                  <td class="p-3 text-sm text-gray-800">
                    <div class="font-medium text-blue-600">
                    {{ $item->PengukuranFrekuensi->frekuensi_terukur_mhz ?? '-' }}
                    </div>
                  </td>
                  <td class="p-3 text-sm text-gray-800">
                    <div>{{ $item->PengukuranFrekuensi->bandwidth_khz ?? '-' }} kHz</div>
                  </td>
                  <td class="p-3 text-sm text-gray-800">
                    <div>{{ $item->PengukuranFrekuensi->deviasi_frekuensi_khz ?? '-' }} kHz</div>
                  </td>

                  <td class="p-3 text-sm text-gray-800 hidden lg:table-cell">
                    <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-lg text-xs">
                    {{ $item->PengukuranFrekuensi->level_h1_dbm ?? '-' }} dBm
                    </span>
                  </td>
                  <td class="p-3 text-sm text-gray-800 hidden xl:table-cell">
                    <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-lg text-xs">
                    {{ $item->PengukuranFrekuensi->level_h2_dbm ?? '-' }} dBm
                    </span>
                  </td>
                  <td class="p-3 text-sm text-gray-800">
                    <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-lg text-xs">
                    {{ $item->PengukuranFrekuensi->level_h3_dbm ?? '-' }} dBm
                    </span>
                  </td>
                  <!-- Aksi -->
                  <td class="p-3 text-sm text-center">
                    <button onclick="showDetail(
              '{{ $item->data_isr->no_isr ?? '-' }}',
              '{{ $item->PengukuranFrekuensi->frekuensi_terukur_mhz ?? '-' }}',
              '{{ $item->PengukuranFrekuensi->bandwidth_khz ?? '-' }}',
              '{{ $item->PengukuranFrekuensi->output_power_tx ?? '-' }}',
              '{{ $item->PengukuranFrekuensi->latitude ?? '-' }}',    // ← ini “koordinat pengukuran”
            '{{ $item->PengukuranFrekuensi->longitude ?? '-' }}',  // ← ini “koordinat pengukuran”
            '{{ $item->LokasiPemancar->latitude ?? '-' }}',        // ← ini harus “koordinat pemancar”
            '{{ $item->LokasiPemancar->longitude ?? '-' }}',      // ← ini harus “koordinat pemancar”
              '{{ $item->PengukuranFrekuensi->level_h1_dbm ?? '-' }}',
              '{{ $item->PengukuranFrekuensi->level_h2_dbm ?? '-' }}',
              '{{ $item->PengukuranFrekuensi->level_h3_dbm ?? '-' }}',
              '{{ $item->LokasiPemancar->alamat ?? '-' }}',
              '{{ $item->LokasiPemancar->location_id ?? '-' }}',
              '{{ $item->LokasiPemancar->kecamatan ?? '-' }}',
              '{{ $item->LokasiPemancar->kelurahan ?? '-' }}',
              '{{ \Carbon\Carbon::parse($item->data_isr->tanggal)->translatedFormat("d F Y") ?? "-" }}',
              '{{ $item->PengukuranFrekuensi->field_strength ?? '-' }}',
              '{{ $item->PengukuranFrekuensi->deviasi_frekuensi_khz ?? '-' }}',
              '{{ $item->PengukuranFrekuensi->catatan ?? '-' }}'
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
            <div class="text-sm text-gray-600">Menampilkan 1-{{ count($pengukurans) }} dari {{ count($pengukurans) }}
              data
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
              <p class="text-xs text-gray-500">Jarak ke Lokasi Pemancar</p>
              <p class="font-medium" id="modalJarak"></p>
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
    document.addEventListener("DOMContentLoaded", () => {
      const filterKota = document.getElementById("filterKota");
      const filterTahun = document.getElementById("filterTahun");
      const rows = document.querySelectorAll("#tableContainer tbody tr");

      function applyTableFilter() {
        const tahun = (filterTahun?.value || "").trim();
        const kota = (filterKota?.value || "").trim();
        rows.forEach(row => {
          const rowTahun = (row.dataset.tahun || "").trim();
          const rowKota = (row.dataset.kota || "").trim();
          const show =
            (tahun === "" || rowTahun === tahun) &&
            (kota === "" || rowKota === kota);
          row.style.display = show ? "" : "none";
        });
      }

      // Trigger di awal dan saat filter berubah
      applyTableFilter();
      filterTahun?.addEventListener('change', applyTableFilter);
      filterKota?.addEventListener('change', applyTableFilter);
    });

    // ======================= MAP SECTION =======================
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

      // ========== ARRAY MARKER GLOBAL + FILTER SEKALI SAJA ==========
      window.allMarkers = [];

      function filterMapMarkers() {
        const kotaPengukuran = document.getElementById("filterKota")?.value.trim();
        const kotaPemancar = document.getElementById("filterKotaPemancar")?.value.trim();
        const tahun = document.getElementById("filterTahun")?.value.trim();

        window.allMarkers.forEach(marker => {
          let tampil = true;
          if (marker.options.type === 'pengukuran') {
            if (kotaPengukuran && String(marker.options.kota) !== kotaPengukuran) tampil = false;
            if (tahun && String(marker.options.tahun) !== tahun) tampil = false;
          }
          if (marker.options.type === 'lokasiPemancar') {
            if (kotaPemancar && String(marker.options.kota) !== kotaPemancar) tampil = false;
          }
          if (tampil) {
            if (!map.hasLayer(marker)) map.addLayer(marker);
          } else {
            if (map.hasLayer(marker)) map.removeLayer(marker);
          }
        });
      }

      document.getElementById("filterKota")?.addEventListener("change", filterMapMarkers);
      document.getElementById("filterTahun")?.addEventListener("change", filterMapMarkers);
      document.getElementById("filterKotaPemancar")?.addEventListener("change", filterMapMarkers);

      // --------- WILAYAH (selalu tampil, tidak masuk array allMarkers) -------------
      const wilayahList = [
        {
          nama: "SOREANG",
          kota_kab: "Kota A",
          koordinat: [-7.02694444444444, 107.516388888889],
          radius: 12000,
          warnaLingkaran: "#8B5CF6",
          warnaIsi: "#C4B5FD",
          LPP_RRI: "132, 158",
          LPP_RRI_Lokal_LPS: "8, 24, 75, 91, 162",
          status: "Aktif"
        },

        {
          nama: "CIAMIS",
          kota_kab: "Ciamis",
          koordinat: [-7.328055556, 108.3927778],
          radius: 12000, // default, bisa diubah kalau ada
          warnaLingkaran: "#8B5CF6", // default
          warnaIsi: "#C4B5FD", // default
          LPP_RRI: "132, 158",
          LPP_RRI_Lokal_LPS: "8, 24, 75, 91, 162",
          status: "Aktif" // default
        },
        {
          nama: "CIKONENG, SADANANYA, CIHAURBEUTI, SINDANGKASIH",
          kota_kab: "Ciamis", // Silakan update sesuai kab/kota aslinya
          koordinat: [-7.296111111, 108.2525],
          radius: 12000,
          warnaLingkaran: "#8B5CF6",
          warnaIsi: "#C4B5FD",
          LPP_RRI: "", // Kosong karena tidak ada di data mentah
          LPP_RRI_Lokal_LPS: "55, 122, 142",
          status: "Aktif"
        },
        {
          nama: "KAWALI, JATINAGARA, RAJADESA",
          kota_kab: "Ciamis",
          koordinat: [-7.185833333, 108.3697222],
          radius: 12000,
          warnaLingkaran: "#8B5CF6",
          warnaIsi: "#C4B5FD",
          LPP_RRI: "82",
          LPP_RRI_Lokal_LPS: "15",
          status: "Aktif"
        },
        {
          nama: "SUKADANA, RANCAH, TAMBAK SARI, CISAGA",
          kota_kab: "Ciamis", // *Kamu bisa update nama kabupaten/kota sesuai aslinya
          koordinat: [-7.263611111, 108.5266667],
          radius: 12000,
          warnaLingkaran: "#8B5CF6",
          warnaIsi: "#C4B5FD",
          LPP_RRI: "43",
          LPP_RRI_Lokal_LPS: "110, 177",
          status: "Aktif"
        },
        {
          nama: "AGRABINTA, LELES",
          kota_kab: "Cianjur",
          koordinat: [-7.413055556, 106.8994444],
          radius: 12000,
          warnaLingkaran: "#8B5CF6",
          warnaIsi: "#C4B5FD",
          LPP_RRI: "177",
          LPP_RRI_Lokal_LPS: "43, 110",
          status: "Aktif"
        },
        {
          nama: "CIANJUR, WARUNGKONDANG, CILAKU, CUGENANG, GEKBRONG",
          kota_kab: "Cianjur",
          koordinat: [-6.82, 107.0775],
          radius: 12000,
          warnaLingkaran: "#8B5CF6",
          warnaIsi: "#C4B5FD",
          LPP_RRI: "186, 198",
          LPP_RRI_Lokal_LPS: "63, 75, 87, 119, 131",
          status: "Aktif"
        },
        {
          nama: "CIBEBER, CAMPAKA",
          kota_kab: "Cianjur",
          koordinat: [-6.969722222, 107.1352778],
          radius: 12000,
          warnaLingkaran: "#8B5CF6",
          warnaIsi: "#C4B5FD",
          LPP_RRI: "",
          LPP_RRI_Lokal_LPS: "4, 68, 135",
          status: "Aktif"
        },
        {
          nama: "CIDAUN, NARINGGUL",
          kota_kab: "Cianjur",
          koordinat: [-7.400555556, 107.3316667],
          radius: 12000,
          warnaLingkaran: "#8B5CF6",
          warnaIsi: "#C4B5FD",
          LPP_RRI: "132",
          LPP_RRI_Lokal_LPS: "65",
          status: "Aktif"
        },
        {
          nama: "KARANGTENGAH, MANDE, SUKALUYU, CIKALONGKULON",
          kota_kab: "Cianjur",
          koordinat: [-6.748888889, 107.1952778],
          radius: 12000,
          warnaLingkaran: "#8B5CF6",
          warnaIsi: "#C4B5FD",
          LPP_RRI: "8, 52",
          LPP_RRI_Lokal_LPS: "16, 83, 150",
          status: "Aktif"
        },
        {
          nama: "SINDANGBARANG",
          kota_kab: "Cianjur",
          koordinat: [-7.463888889, 107.135],
          radius: 12000,
          warnaLingkaran: "#8B5CF6",
          warnaIsi: "#C4B5FD",
          LPP_RRI: "",
          LPP_RRI_Lokal_LPS: "61, 128",
          status: "Aktif"
        },
        {
          nama: "SUKANEGARA, TAKOKAK, KADUPANDAK",
          kota_kab: "Cianjur",
          koordinat: [-7.121388889, 107.0552778],
          radius: 12000,
          warnaLingkaran: "#8B5CF6",
          warnaIsi: "#C4B5FD",
          LPP_RRI: "12",
          LPP_RRI_Lokal_LPS: "79, 146",
          status: "Aktif"
        },
        {
          nama: "BABAKAN",
          kota_kab: "Cirebon",
          koordinat: [-6.862777778, 108.7072222],
          radius: 12000,
          warnaLingkaran: "#8B5CF6",
          warnaIsi: "#C4B5FD",
          LPP_RRI: "121",
          LPP_RRI_Lokal_LPS: "54, 188",
          status: "Aktif"
        },
        {
          nama: "PALIMANAN, ARJAWINANGUN, GEGESIK",
          kota_kab: "Cirebon",
          koordinat: [-6.653611111, 108.4455556],
          radius: 12000,
          warnaLingkaran: "#8B5CF6",
          warnaIsi: "#C4B5FD",
          LPP_RRI: "",
          LPP_RRI_Lokal_LPS: "11, 27, 94, 145, 161",
          status: "Aktif"
        },
        {
          nama: "SUMBER, PLUMBON, WERU",
          kota_kab: "Cirebon",
          koordinat: [-6.76, 108.4952778],
          radius: 12000,
          warnaLingkaran: "#8B5CF6",
          warnaIsi: "#C4B5FD",
          LPP_RRI: "73",
          LPP_RRI_Lokal_LPS: "43, 58, 110",
          status: "Aktif"
        },
        {
          nama: "BANJARWANGI, SINGAJAYA, CIHURIP",
          kota_kab: "Garut",
          koordinat: [-7.441111111, 107.9036111],
          radius: 12000,
          warnaLingkaran: "#8B5CF6",
          warnaIsi: "#C4B5FD",
          LPP_RRI: "186",
          LPP_RRI_Lokal_LPS: "52, 119",
          status: "Aktif"
        },
        {
          nama: "BUNGBULANG, MEKARMUKTI, CARINGIN",
          kota_kab: "Garut",
          koordinat: [-7.486666667, 107.5416667],
          radius: 12000,
          warnaLingkaran: "#8B5CF6",
          warnaIsi: "#C4B5FD",
          LPP_RRI: "107",
          LPP_RRI_Lokal_LPS: "",
          status: "Aktif"
        },
        {
          nama: "CIBATU, LIMBANGAN, CIBIUK",
          kota_kab: "Garut",
          koordinat: [-7.034722222, 107.9844444],
          radius: 12000,
          warnaLingkaran: "#8B5CF6",
          warnaIsi: "#C4B5FD",
          LPP_RRI: "79",
          LPP_RRI_Lokal_LPS: "12, 146",
          status: "Aktif"
        },
        {
          nama: "CIGEDUG, CILAWU, CIKAJANG",
          kota_kab: "Garut",
          koordinat: [-7.375277778, 107.8186111],
          radius: 12000,
          warnaLingkaran: "#8B5CF6",
          warnaIsi: "#C4B5FD",
          LPP_RRI: "83",
          LPP_RRI_Lokal_LPS: "16, 150",
          status: "Aktif"
        },
        {
          nama: "CISEWU, TALEGONG",
          kota_kab: "Garut",
          koordinat: [-7.292222222, 107.5305556],
          radius: 12000,
          warnaLingkaran: "#8B5CF6",
          warnaIsi: "#C4B5FD",
          LPP_RRI: "",
          LPP_RRI_Lokal_LPS: "66, 133",
          status: "Aktif"
        },
        {
          nama: "GARUT",
          kota_kab: "Garut",
          koordinat: [-7.200555556, 107.9063889],
          radius: 12000,
          warnaLingkaran: "#8B5CF6",
          warnaIsi: "#C4B5FD",
          LPP_RRI: "",
          LPP_RRI_Lokal_LPS: "28, 44, 95, 111, 162, 178",
          status: "Aktif"
        },
        {
          nama: "PAMEUNGPEUK, CISOMPET, CIBALONG, CIKELET",
          kota_kab: "Garut",
          koordinat: [-7.600555556, 107.7708333],
          radius: 12000,
          warnaLingkaran: "#8B5CF6",
          warnaIsi: "#C4B5FD",
          LPP_RRI: "",
          LPP_RRI_Lokal_LPS: "40, 59, 126, 174, 193",
          status: "Aktif"
        },
        {
          nama: "SAMARANG, PASIRWANGI, BAYONGBONG, CISURUPAN, SUKARESMI",
          kota_kab: "Garut",
          koordinat: [-7.2625, 107.8197222],
          radius: 12000,
          warnaLingkaran: "#8B5CF6",
          warnaIsi: "#C4B5FD",
          LPP_RRI: "",
          LPP_RRI_Lokal_LPS: "32, 99, 166",
          status: "Aktif"
        },
        {
          nama: "BALONGAN, INDRAMAYU, SINDANG, CANTIGI, LOH BENER, ARAHAN",
          kota_kab: "Indramayu",
          koordinat: [-6.326388889, 108.3219444],
          radius: 12000,
          warnaLingkaran: "#8B5CF6",
          warnaIsi: "#C4B5FD",
          LPP_RRI: "125",
          LPP_RRI_Lokal_LPS: "36, 103, 138, 154",
          status: "Aktif"
        },
        {
          nama: "BONGAS, ANJATAN, SUKRA, PATROL",
          kota_kab: "Indramayu",
          koordinat: [-6.335, 107.9494444],
          radius: 12000,
          warnaLingkaran: "#8B5CF6",
          warnaIsi: "#C4B5FD",
          LPP_RRI: "181",
          LPP_RRI_Lokal_LPS: "31, 47, 98, 114, 165",
          status: "Aktif"
        },
        {
          nama: "CIKEDUNG, LELEA, TRISI, TUKDANA, BANGODUA",
          kota_kab: "Indramayu",
          koordinat: [-6.512222222, 108.2138889],
          radius: 12000,
          warnaLingkaran: "#8B5CF6",
          warnaIsi: "#C4B5FD",
          LPP_RRI: "",
          LPP_RRI_Lokal_LPS: "134",
          status: "Aktif"
        },
        {
          nama: "HAURGEULIS, KROYA, GABUSWETAN, GANTAR",
          kota_kab: "Indramayu",
          koordinat: [-6.460277778, 107.9888889],
          radius: 12000,
          warnaLingkaran: "#8B5CF6",
          warnaIsi: "#C4B5FD",
          LPP_RRI: "16",
          LPP_RRI_Lokal_LPS: "83, 150",
          status: "Aktif"
        },
        {
          nama: "LOSARANG, KANDAHAUR",
          kota_kab: "Indramayu",
          koordinat: [-6.394166667, 108.1730556],
          radius: 12000,
          warnaLingkaran: "#8B5CF6",
          warnaIsi: "#C4B5FD",
          LPP_RRI: "",
          LPP_RRI_Lokal_LPS: "24",
          status: "Aktif"
        },
        {
          nama: "WIDASARI, KARANGAMPEL, JATIBARANG",
          kota_kab: "Indramayu",
          koordinat: [-6.480555556, 108.3502778],
          radius: 12000,
          warnaLingkaran: "#8B5CF6",
          warnaIsi: "#C4B5FD",
          LPP_RRI: "",
          LPP_RRI_Lokal_LPS: "4, 20, 71, 87, 170, 192",
          status: "Aktif"
        },
        {
          nama: "KARAWANG BARAT, TELUKJAMBE TIMUR, MAJALAYA, KARAWANG TIMUR, TELUKJAMBE BARAT",
          kota_kab: "Karawang",
          koordinat: [-6.297777778, 107.2980556],
          radius: 12000,
          warnaLingkaran: "#8B5CF6",
          warnaIsi: "#C4B5FD",
          LPP_RRI: "19",
          LPP_RRI_Lokal_LPS: "86, 153, 157, 199",
          status: "Aktif"
        },
        {
          nama: "KLARI, CIKAMPEK, JATISARI, TIRTAMULYA, LEMAHABANG, KOTA BARU, PURWASARI",
          kota_kab: "Karawang",
          koordinat: [-6.389722222, 107.4661111],
          radius: 12000,
          warnaLingkaran: "#8B5CF6",
          warnaIsi: "#C4B5FD",
          LPP_RRI: "44",
          LPP_RRI_Lokal_LPS: "66",
          status: "Aktif"
        },
        {
          nama: "RENGASDENGKLOK, KUTAWALUYA, RAWAMERTA, JAYAKERTA, CILEBAR",
          kota_kab: "Karawang",
          koordinat: [-6.182222222, 107.3144444],
          radius: 12000,
          warnaLingkaran: "#8B5CF6",
          warnaIsi: "#C4B5FD",
          LPP_RRI: "",
          LPP_RRI_Lokal_LPS: "121, 188",
          status: "Aktif"
        },
        {
          nama: "KOTA BANDUNG",
          kota_kab: "Kota Bandung",
          koordinat: [-6.921388889, 107.6072222],
          radius: 25000,
          warnaLingkaran: "#8B5CF6",
          warnaIsi: "#C4B5FD",
          LPP_RRI: "10, 85, 101",
          LPP_RRI_Lokal_LPS: "2, 6, 14, 18, 22, 26, 30, 34, 38, 42, 46, 50, 58, 62, 69, 73, 77, 81, 89, 93, 97, 109, 113, 117, 125, 129, 136, 140, 144, 148, 152, 156, 160, 164, 168, 172, 176, 180, 184, 188, 192, 196, 200",
          status: "Aktif"
        },
        {
          nama: "KOTA BANJAR",
          kota_kab: "Kota Banjar",
          koordinat: [-7.369444444, 108.5416667],
          radius: 12000,
          warnaLingkaran: "#8B5CF6",
          warnaIsi: "#C4B5FD",
          LPP_RRI: "12",
          LPP_RRI_Lokal_LPS: "32, 79, 99, 146, 166",
          status: "Aktif"
        },
        {
          nama: "KOTA CIMAHI",
          kota_kab: "Kota Cimahi",
          koordinat: [-6.873055556, 107.5422222],
          radius: 12000,
          warnaLingkaran: "#8B5CF6",
          warnaIsi: "#C4B5FD",
          LPP_RRI: "",
          LPP_RRI_Lokal_LPS: "54, 121",
          status: "Aktif"
        },
        {
          nama: "KOTA CIREBON",
          kota_kab: "Kota Cirebon",
          koordinat: [-6.706944444, 108.5580556],
          radius: 12000,
          warnaLingkaran: "#8B5CF6",
          warnaIsi: "#C4B5FD",
          LPP_RRI: "100",
          LPP_RRI_Lokal_LPS: "1, 17, 33, 68, 78, 84, 135, 151, 167, 177",
          status: "Aktif"
        },
        {
          nama: "KOTA SUKABUMI",
          kota_kab: "Kota Sukabumi",
          koordinat: [-6.921111111, 106.9258333],
          radius: 12000,
          warnaLingkaran: "#8B5CF6",
          warnaIsi: "#C4B5FD",
          LPP_RRI: "190",
          LPP_RRI_Lokal_LPS: "1, 32, 48, 56, 85, 94, 99, 115, 142, 166, 182",
          status: "Aktif"
        },
        {
          nama: "KOTA TASIKMALAYA",
          kota_kab: "Kota Tasikmalaya",
          koordinat: [-7.326666667, 108.2244444],
          radius: 12000,
          warnaLingkaran: "#8B5CF6",
          warnaIsi: "#C4B5FD",
          LPP_RRI: "106",
          LPP_RRI_Lokal_LPS: "4, 20, 36, 71, 87, 138, 154, 170",
          status: "Aktif"
        },
        {
          nama: "JALAKSANA, CILIMUS, CIGUGUR",
          kota_kab: "Kuningan",
          koordinat: [-6.904722222, 108.4894444],
          radius: 12000,
          warnaLingkaran: "#8B5CF6",
          warnaIsi: "#C4B5FD",
          LPP_RRI: "39",
          LPP_RRI_Lokal_LPS: "106, 173",
          status: "Aktif"
        },
        {
          nama: "KADUGEDE, GARAWANGI, KUNINGAN, KRAMATMULYA",
          kota_kab: "Kuningan",
          koordinat: [-6.980833333, 108.4927778],
          radius: 12000,
          warnaLingkaran: "#8B5CF6",
          warnaIsi: "#C4B5FD",
          LPP_RRI: "",
          LPP_RRI_Lokal_LPS: "23, 63, 90, 130, 157, 197",
          status: "Aktif"
        },
        {
          nama: "ARGAPURA, SUKAHAJI, RAJAGALUH",
          kota_kab: "Majalengka",
          koordinat: [-6.825277778, 108.3072222],
          radius: 12000,
          warnaLingkaran: "#8B5CF6",
          warnaIsi: "#C4B5FD",
          LPP_RRI: "183",
          LPP_RRI_Lokal_LPS: "49, 116",
          status: "Aktif"
        },
        {
          nama: "LEMAHSUGIH, BANTARUJEG, TALAGA, BANJARAN, MALAUSMA",
          kota_kab: "Majalengka",
          koordinat: [-6.964166667, 108.2425],
          radius: 12000,
          warnaLingkaran: "#8B5CF6",
          warnaIsi: "#C4B5FD",
          LPP_RRI: "194",
          LPP_RRI_Lokal_LPS: "60, 127",
          status: "Aktif"
        },
        {
          nama: "MAJALENGKA",
          kota_kab: "Majalengka",
          koordinat: [-6.835277778, 108.2277778],
          radius: 12000,
          warnaLingkaran: "#8B5CF6",
          warnaIsi: "#C4B5FD",
          LPP_RRI: "39, 141",
          LPP_RRI_Lokal_LPS: "56, 123, 190, 198",
          status: "Aktif"
        },
        {
          nama: "PANGANDARAN",
          kota_kab: "Pangandaran",
          koordinat: [-7.684722222, 108.6533333],
          radius: 12000,
          warnaLingkaran: "#8B5CF6",
          warnaIsi: "#C4B5FD",
          LPP_RRI: "107",
          LPP_RRI_Lokal_LPS: "40, 174",
          status: "Aktif"
        },
        {
          nama: "PARIGI, CIJULANG, CIMERAK, CIGUGUR",
          kota_kab: "Pangandaran",
          koordinat: [-7.715833333, 108.4427778],
          radius: 12000,
          warnaLingkaran: "#8B5CF6",
          warnaIsi: "#C4B5FD",
          LPP_RRI: "97",
          LPP_RRI_Lokal_LPS: "164, 189",
          status: "Aktif"
        },
        {
          nama: "DARANGDAN, WANAYASA, PASAWAHAN, BOJONG, PODOKSALAM, KIARAPEDES",
          kota_kab: "Purwakarta",
          koordinat: [-6.673611111, 107.4805556],
          radius: 12000,
          warnaLingkaran: "#8B5CF6",
          warnaIsi: "#C4B5FD",
          LPP_RRI: "",
          LPP_RRI_Lokal_LPS: "134",
          status: "Aktif"
        },
        {
          nama: "PLERED, MANIIS, SUKATANI, TEGALWARU",
          kota_kab: "Purwakarta",
          koordinat: [-6.641666667, 107.3902778],
          radius: 12000,
          warnaLingkaran: "#8B5CF6",
          warnaIsi: "#C4B5FD",
          LPP_RRI: "102",
          LPP_RRI_Lokal_LPS: "169",
          status: "Aktif"
        },
        {
          nama: "PURWAKARTA, CAMPAKA, JATILUHUR, BABAKANCIKAO, BUNGURSARI, CIBATU",
          kota_kab: "Purwakarta",
          koordinat: [-6.512222222, 107.4641667],
          radius: 12000,
          warnaLingkaran: "#8B5CF6",
          warnaIsi: "#C4B5FD",
          LPP_RRI: "3, 90",
          LPP_RRI_Lokal_LPS: "23, 27, 35, 56, 70, 94, 137, 161",
          status: "Aktif"
        },
        // SUBANG
        {
          nama: "CIASEM, BLANAKAN, PATOKBEUSI, SUKASARI",
          kota_kab: "Subang",
          koordinat: [-6.318333333, 107.6902778],
          radius: 12000,
          warnaLingkaran: "#8B5CF6",
          warnaIsi: "#C4B5FD",
          LPP_RRI: "118",
          LPP_RRI_Lokal_LPS: "51",
          status: "Aktif"
        },
        {
          nama: "CISALAK, TANJUNGSIANG, KASOMALANG",
          kota_kab: "Subang",
          koordinat: [-6.716388889, 107.7633333],
          radius: 12000,
          warnaLingkaran: "#8B5CF6",
          warnaIsi: "#C4B5FD",
          LPP_RRI: "",
          LPP_RRI_Lokal_LPS: "2",
          status: "Aktif"
        },
        {
          nama: "KALIJATI, PABUARAN, PURWADADI, CIPEUNDEUY, DAWUAN",
          kota_kab: "Subang",
          koordinat: [-6.495833333, 107.6583333],
          radius: 12000,
          warnaLingkaran: "#8B5CF6",
          warnaIsi: "#C4B5FD",
          LPP_RRI: "79",
          LPP_RRI_Lokal_LPS: "12, 146",
          status: "Aktif"
        },
        {
          nama: "PAGEDEN, BINONG, COMPRENG, CIPUNAGARA, TAMBAKDAHAN, PAGEDEN BARAT",
          kota_kab: "Subang",
          koordinat: [-6.434166667, 107.8313889],
          radius: 12000,
          warnaLingkaran: "#8B5CF6",
          warnaIsi: "#C4B5FD",
          LPP_RRI: "",
          LPP_RRI_Lokal_LPS: "130",
          status: "Aktif"
        },
        {
          nama: "PAMANUKAN, LEGONKULON",
          kota_kab: "Subang",
          koordinat: [-6.286388889, 107.8205556],
          radius: 12000,
          warnaLingkaran: "#8B5CF6",
          warnaIsi: "#C4B5FD",
          LPP_RRI: "",
          LPP_RRI_Lokal_LPS: "185",
          status: "Aktif"
        },
        {
          nama: "SAGALAHERANG, JALANCAGAK, SERANGPANAJANG, CIATER",
          kota_kab: "Subang",
          koordinat: [-6.673611111, 107.6525],
          radius: 12000,
          warnaLingkaran: "#8B5CF6",
          warnaIsi: "#C4B5FD",
          LPP_RRI: "194",
          LPP_RRI_Lokal_LPS: "60, 127",
          status: "Aktif"
        },
        {
          nama: "SUBANG, CIBOGO, CIJAMBE",
          kota_kab: "Subang",
          koordinat: [-6.563055556, 107.7616667],
          radius: 12000,
          warnaLingkaran: "#8B5CF6",
          warnaIsi: "#C4B5FD",
          LPP_RRI: "67, 107",
          LPP_RRI_Lokal_LPS: "8, 40, 75, 142, 174",
          status: "Aktif"
        },

        // SUKABUMI
        {
          nama: "BANTARGADUNG, JAMPANGTENGAH, WARUNGKIARA, CIKEMBAR",
          kota_kab: "Sukabumi",
          koordinat: [-7.008333333, 106.7527778],
          radius: 12000,
          warnaLingkaran: "#8B5CF6",
          warnaIsi: "#C4B5FD",
          LPP_RRI: "38",
          LPP_RRI_Lokal_LPS: "105, 172",
          status: "Aktif"
        },
        {
          nama: "CIBADAK, NAGRAK, PARUNGKUDA, CICURUG, CIDAHU, CIAMBAR",
          kota_kab: "Sukabumi",
          koordinat: [-6.813611111, 106.7691667],
          radius: 12000,
          warnaLingkaran: "#8B5CF6",
          warnaIsi: "#C4B5FD",
          LPP_RRI: "161",
          LPP_RRI_Lokal_LPS: "18, 27",
          status: "Aktif"
        },
        {
          nama: "CIDOLOG, TEGALBULEUD",
          kota_kab: "Sukabumi",
          koordinat: [-7.335833333, 106.8052778],
          radius: 12000,
          warnaLingkaran: "#8B5CF6",
          warnaIsi: "#C4B5FD",
          LPP_RRI: "163",
          LPP_RRI_Lokal_LPS: "29, 96",
          status: "Aktif"
        },
        {
          nama: "CIEMAS, CIRACAP",
          kota_kab: "Sukabumi",
          koordinat: [-7.276111111, 106.5027778],
          radius: 12000,
          warnaLingkaran: "#8B5CF6",
          warnaIsi: "#C4B5FD",
          LPP_RRI: "4, 48",
          LPP_RRI_Lokal_LPS: "15, 82, 149",
          status: "Aktif"
        },
        {
          nama: "CIKAKAK, CISOLOK",
          kota_kab: "Sukabumi",
          koordinat: [-6.918333333, 106.4661111],
          radius: 12000,
          warnaLingkaran: "#8B5CF6",
          warnaIsi: "#C4B5FD",
          LPP_RRI: "",
          LPP_RRI_Lokal_LPS: "35, 40, 102, 169",
          status: "Aktif"
        },
        {
          nama: "CIKIDANG, BOJONGGENTENG, PARAKANSALAK, KALAPANUNGGAL, KABANDUNGAN",
          kota_kab: "Sukabumi",
          koordinat: [-6.831388889, 106.6630556],
          radius: 12000,
          warnaLingkaran: "#8B5CF6",
          warnaIsi: "#C4B5FD",
          LPP_RRI: "44",
          LPP_RRI_Lokal_LPS: "111, 178",
          status: "Aktif"
        },
        {
          nama: "JAMPANGKULON, KALIBUNDER, SURADE",
          kota_kab: "Sukabumi",
          koordinat: [-7.269722222, 106.6252778],
          radius: 12000,
          warnaLingkaran: "#8B5CF6",
          warnaIsi: "#C4B5FD",
          LPP_RRI: "87, 154",
          LPP_RRI_Lokal_LPS: "20",
          status: "Aktif"
        },
        {
          nama: "KEBONPEDES, CIREUNGHAS, CISAAT, NYALINDUNG, GEGERBITUNG",
          kota_kab: "Sukabumi",
          koordinat: [-6.985555556, 106.9427778],
          radius: 12000,
          warnaLingkaran: "#8B5CF6",
          warnaIsi: "#C4B5FD",
          LPP_RRI: "",
          LPP_RRI_Lokal_LPS: "72, 139",
          status: "Aktif"
        },
        {
          nama: "PABUARAN, SAGARANTEN, CURUGKEMBAR",
          kota_kab: "Sukabumi",
          koordinat: [-7.218611111, 106.8858333],
          radius: 12000,
          warnaLingkaran: "#8B5CF6",
          warnaIsi: "#C4B5FD",
          LPP_RRI: "159",
          LPP_RRI_Lokal_LPS: "25, 92",
          status: "Aktif"
        },
        {
          nama: "PELABUHAN RATU, SIMPENAN",
          kota_kab: "Sukabumi",
          koordinat: [-7.036666667, 106.5733333],
          radius: 12000,
          warnaLingkaran: "#8B5CF6",
          warnaIsi: "#C4B5FD",
          LPP_RRI: "107",
          LPP_RRI_Lokal_LPS: "8, 174",
          status: "Aktif"
        },
        // SUMEDANG
        {
          nama: "CONGEANG, SURIAN, BUAHDUA, TANJUNGKERTA, TANJUNGMEDAR",
          kota_kab: "Sumedang",
          koordinat: [-6.71, 107.9155556],
          radius: 12000,
          warnaLingkaran: "#8B5CF6",
          warnaIsi: "#C4B5FD",
          LPP_RRI: "",
          LPP_RRI_Lokal_LPS: "158",
          status: "Aktif"
        },
        {
          nama: "SUMEDANG",
          kota_kab: "Sumedang",
          koordinat: [-6.837777778, 107.9275],
          radius: 12000,
          warnaLingkaran: "#8B5CF6",
          warnaIsi: "#C4B5FD",
          LPP_RRI: "91",
          LPP_RRI_Lokal_LPS: "52, 119, 186",
          status: "Aktif"
        },
        {
          nama: "WADO, JATINUNGGAL, DARMARAJA, CIBUGEL, CISITU, JATIGEDE",
          kota_kab: "Sumedang",
          koordinat: [-6.917777778, 108.0744444],
          radius: 12000,
          warnaLingkaran: "#8B5CF6",
          warnaIsi: "#C4B5FD",
          LPP_RRI: "",
          LPP_RRI_Lokal_LPS: "44, 64",
          status: "Aktif"
        },

        // TASIKMALAYA
        {
          nama: "BANTARKALONG, BOJONGGAMBIR, SODONGHILIR",
          kota_kab: "Tasikmalaya",
          koordinat: [-7.5425, 108.0441667],
          radius: 12000,
          warnaLingkaran: "#8B5CF6",
          warnaIsi: "#C4B5FD",
          LPP_RRI: "",
          LPP_RRI_Lokal_LPS: "1, 66, 135",
          status: "Aktif"
        },
        {
          nama: "CIAWI, PAGERAGEUNG",
          kota_kab: "Tasikmalaya",
          koordinat: [-7.158333333, 108.1472222],
          radius: 12000,
          warnaLingkaran: "#8B5CF6",
          warnaIsi: "#C4B5FD",
          LPP_RRI: "",
          LPP_RRI_Lokal_LPS: "68, 133",
          status: "Aktif"
        },
        {
          nama: "CIKALONG, PANCATENGAH, CIKATOMAS",
          kota_kab: "Tasikmalaya",
          koordinat: [-7.692777778, 108.2188889],
          radius: 12000,
          warnaLingkaran: "#8B5CF6",
          warnaIsi: "#C4B5FD",
          LPP_RRI: "129",
          LPP_RRI_Lokal_LPS: "62, 196",
          status: "Aktif"
        },
        {
          nama: "CIPATUJAH, KARANGNUNGGAL",
          kota_kab: "Tasikmalaya",
          koordinat: [-7.664444444, 108.0763889],
          radius: 12000,
          warnaLingkaran: "#8B5CF6",
          warnaIsi: "#C4B5FD",
          LPP_RRI: "103, 181",
          LPP_RRI_Lokal_LPS: "47, 114",
          status: "Aktif"
        },
        {
          nama: "SALAWU, CIGALONTANG",
          kota_kab: "Tasikmalaya",
          koordinat: [-7.382222222, 108.0572222],
          radius: 12000,
          warnaLingkaran: "#8B5CF6",
          warnaIsi: "#C4B5FD",
          LPP_RRI: "148",
          LPP_RRI_Lokal_LPS: "48, 115, 182",
          status: "Aktif"
        },
      ];

      wilayahList.forEach(wilayah => {
        const marker = L.marker(wilayah.koordinat, {
          icon: L.divIcon({
            className: 'wilayah-marker',
            iconSize: [24, 24],
            iconAnchor: [12, 12],
            html: `<div class="flex items-center justify-center w-6 h-6 bg-purple-600 rounded-full border-2 border-white shadow-lg pulse-animation"></div>`,
          }),
          type: 'wilayah',
          isAreaMarker: true
        }).addTo(map);

        L.circle(wilayah.koordinat, {
          radius: wilayah.radius,
          color: wilayah.warnaLingkaran,
          fillColor: wilayah.warnaIsi,
          fillOpacity: 0.2,
          weight: 2,
          dashArray: '5, 5',
          isAreaCircle: true
        }).addTo(map);

        marker.bindPopup(
          `<div class="wilayah-popup-card">
            <div class="wilayah-popup-header">
              ${wilayah.nama}
            </div>
            <div class="wilayah-popup-section">
              <span class="wilayah-popup-label">Kota/Kabupaten</span>
              <span class="wilayah-popup-value">${wilayah.kota_kab}</span>
            </div>
            <div class="wilayah-popup-section">
              <span class="wilayah-popup-label">Koordinat</span>
              <span class="wilayah-popup-value">${wilayah.koordinat[0].toFixed(6)}, ${wilayah.koordinat[1].toFixed(6)}</span>
            </div>
            <div class="wilayah-popup-section">
              <span class="wilayah-popup-label">LPP RRI</span>
              <span class="wilayah-popup-value">${wilayah.LPP_RRI}</span>
            </div>
            <div class="wilayah-popup-section">
              <span class="wilayah-popup-label">LPP RRI, Lokal, LPS</span>
              <span class="wilayah-popup-value">${wilayah.LPP_RRI_Lokal_LPS}</span>
            </div>
            <div class="wilayah-popup-section">
              <span class="wilayah-popup-badge ${wilayah.status.toLowerCase() !== 'aktif' ? 'inactive' : ''}">${wilayah.status}</span>
            </div>
          </div>`,
          {
            className: "wilayah-popup",
            maxWidth: 320
          }
        );
      });

      // ------------------- ICONS -------------------
      const defaultIcon = L.icon({
        iconUrl: 'https://unpkg.com/leaflet@1.9.4/dist/images/marker-icon.png',
        iconSize: [25, 41],
        iconAnchor: [12, 41],
        popupAnchor: [1, -34]
      });

      const pemancarIcon = L.icon({
        iconUrl: '/images/icon-pemancar.png',
        iconSize: [50, 50],
        iconAnchor: [14, 28],
        popupAnchor: [0, -26]
      });

      const highlightedDefaultIcon = L.icon({
        iconUrl: '/images/marker-icon2.png',
        iconSize: [60, 60],
        iconAnchor: [17, 51],
        popupAnchor: [1, -44]
      });

      const highlightedPemancarIcon = L.icon({
        iconUrl: '/images/icon-pemancar2.png',
        iconSize: [70, 70],
        iconAnchor: [19, 38],
        popupAnchor: [0, -36]
      });

      // -------------- MARKER GROUPS ---------------
      var markerGroups = {};

      // =============== PENGUKURAN MARKERS ===============
      @foreach($pengukurans as $item)
      @if($item->pengukuranFrekuensi && $item->pengukuranFrekuensi->latitude && $item->pengukuranFrekuensi->longitude)
      var lat = {{ $item->pengukuranFrekuensi->latitude }};
      var lng = {{ $item->pengukuranFrekuensi->longitude }};
      var groupId = {{ $item->lokasi_pemancar_id ?? 'null' }};
      if (groupId !== null) {
      var tahun = '{{ \Carbon\Carbon::parse($item->created_at)->format('Y') }}';

      var marker = L.marker([lat, lng], {
        kota: '{{ $item->pengukuranFrekuensi->location_id ?? "-" }}',
        tahun: tahun,
        originalIcon: defaultIcon,
        type: 'pengukuran',
        groupId: groupId // PENTING! agar highlightGroup() bisa dipanggil
      }).addTo(map);

      window.allMarkers.push(marker);

      if (!window.markersByTahun) window.markersByTahun = [];
      window.markersByTahun.push(marker);
      marker.setIcon(defaultIcon);

      var popupContent = `
      <div class="p-4 bg-gradient-to-br from-white to-blue-50 rounded-lg shadow-inner">
      <div class="flex items-center justify-between mb-3 pb-2 border-b border-blue-100">
      <h3 class="font-bold text-lg text-blue-700 flex items-center">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-500" viewBox="0 0 20 20" fill="currentColor">
      <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
      </svg>
      {{ $item->data_isr->no_isr ?? 'Tidak ada ISR' }}
      </h3>
      <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs font-semibold rounded-full">
      {{ \Carbon\Carbon::parse($item->created_at)->format('Y') }}
      </span>
      </div>
      <div class="grid grid-cols-2 gap-2 mb-3">
      <div class="bg-blue-50 rounded-lg p-2">
      <div class="text-xs text-blue-500 font-medium mb-1">Frekuensi</div>
      <div class="font-bold text-gray-800">{{ $item->PengukuranFrekuensi->frekuensi_terukur_mhz ?? '-' }} <span class="text-xs font-normal text-gray-500">MHz</span></div>
      </div>
      <div class="bg-blue-50 rounded-lg p-2">
      <div class="text-xs text-blue-500 font-medium mb-1">Bandwidth</div>
      <div class="font-bold text-gray-800">{{ $item->PengukuranFrekuensi->bandwidth_khz ?? '-' }} <span class="text-xs font-normal text-gray-500">kHz</span></div>
      </div>
      <div class="bg-blue-50 rounded-lg p-2">
      <div class="text-xs text-blue-500 font-medium mb-1">Daya</div>
      <div class="font-bold text-gray-800">{{ $item->PengukuranFrekuensi->output_power_tx ?? '-' }} <span class="text-xs font-normal text-gray-500">W</span></div>
      </div>
      <div class="bg-blue-50 rounded-lg p-2">
      <div class="text-xs text-blue-500 font-medium mb-1">Deviasi</div>
      <div class="font-bold text-gray-800">{{ $item->PengukuranFrekuensi->deviasi_frekuensi_khz ?? '-' }} <span class="text-xs font-normal text-gray-500">kHz</span></div>
      </div>
      </div>
      <div class="bg-gradient-to-r from-indigo-50 to-blue-50 rounded-lg p-3 mb-3">
      <div class="text-xs text-indigo-600 font-medium mb-2">Harmonisa</div>
      <div class="flex justify-between items-center">
      <div class="flex flex-col items-center">
      <span class="text-xs text-gray-500 mb-1">H-1</span>
      <span class="px-2 py-1 bg-indigo-100 text-indigo-700 rounded-md font-medium text-sm">{{ $item->PengukuranFrekuensi->level_h1_dbm ?? '-' }} dBm</span>
      </div>
      <div class="flex flex-col items-center">
      <span class="text-xs text-gray-500 mb-1">H-2</span>
      <span class="px-2 py-1 bg-indigo-100 text-indigo-700 rounded-md font-medium text-sm">{{ $item->PengukuranFrekuensi->level_h2_dbm ?? '-' }} dBm</span>
      </div>
      <div class="flex flex-col items-center">
      <span class="text-xs text-gray-500 mb-1">H-3</span>
      <span class="px-2 py-1 bg-indigo-100 text-indigo-700 rounded-md font-medium text-sm">{{ $item->PengukuranFrekuensi->level_h3_dbm ?? '-' }} dBm</span>
      </div>
      </div>
      </div>
      <div class="flex items-center justify-between mb-2">
      <div>
      <span class="text-xs text-gray-500">Kanal:</span>
      <span class="ml-1 font-medium">{{ $item->PengukuranFrekuensi->kanal ?? '-' }}</span>
      </div>
      </div>
      <button onclick="showDetail(
      '{{ $item->data_isr->no_isr ?? '-' }}',
      '{{ $item->PengukuranFrekuensi->frekuensi_terukur_mhz ?? '-' }}',
      '{{ $item->PengukuranFrekuensi->bandwidth_khz ?? '-' }}',
      '{{ $item->PengukuranFrekuensi->output_power_tx ?? '-' }}',
      '{{ $item->PengukuranFrekuensi->latitude ?? '-' }}', // baru!
      '{{ $item->PengukuranFrekuensi->longitude ?? '-' }}', // baru!
      '{{ $item->LokasiPemancar->latitude ?? '-' }}',
      '{{ $item->LokasiPemancar->longitude ?? '-' }}',
      '{{ $item->PengukuranFrekuensi->level_h1_dbm ?? '-' }}',
      '{{ $item->PengukuranFrekuensi->level_h2_dbm ?? '-' }}',
      '{{ $item->PengukuranFrekuensi->level_h3_dbm ?? '-' }}',
      '{{ $item->LokasiPemancar->alamat ?? '-' }}',
      '{{ $item->LokasiPemancar->location_id ?? '-' }}',
      '{{ $item->LokasiPemancar->kecamatan ?? '-' }}',
      '{{ $item->LokasiPemancar->kelurahan ?? '-' }}',
      '{{ \Carbon\Carbon::parse($item->data_isr->tanggal)->translatedFormat("d F Y") ?? "-" }}',
      '{{ $item->PengukuranFrekuensi->field_strength ?? '-' }}',
      '{{ $item->PengukuranFrekuensi->deviasi_frekuensi_khz ?? '-' }}',
      '{{ $item->PengukuranFrekuensi->catatan ?? '-' }}'
      )" class="w-full mt-2 px-4 py-2 bg-gradient-to-r from-blue-600 to-blue-500 text-white rounded-lg hover:from-blue-700 hover:to-blue-600 transition-all duration-200 font-medium flex items-center justify-center shadow-md">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" viewBox="0 0 20 20" fill="currentColor">
      <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
      <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
      </svg>
      Lihat Detail
      </button>
      </div>
      `;

      marker.bindPopup(popupContent, {
        className: "pengukuran-popup",
        maxWidth: 520,
        minWidth: 340,
        autoPan: true,
        autoPanPadding: [40, 40]
      });

      if (!markerGroups[groupId]) markerGroups[groupId] = [];
      markerGroups[groupId].push(marker);

      marker.on('click', function () {
        highlightGroup(this.options.groupId);
      });
      }
    @endif
    @endforeach

      // =============== LOKASI PEMANCAR MARKERS ===============
      @foreach ($lokasiPemancars as $lp)
      @if ($lp->latitude && $lp->longitude)
      var lpLat = {{ $lp->latitude }};
      var lpLng = {{ $lp->longitude }};
      var groupId = {{ $lp->id }};
      var lpMarker = L.marker([lpLat, lpLng], {
      groupId: groupId,
      kota: '{{ $lp->location_id }}',
      type: 'lokasiPemancar',
      originalIcon: pemancarIcon,
      tahun: '{{ \Carbon\Carbon::parse($lp->created_at)->format('Y') }}'
      }).addTo(map);

      lpMarker.setIcon(pemancarIcon);
      window.allMarkers.push(lpMarker);

      if (!window.markersByTahun) window.markersByTahun = [];
      window.markersByTahun.push(lpMarker);

      var lpPopup = `
      <div class="p-4 bg-gradient-to-br from-white to-red-50 rounded-lg shadow-inner">
      <div class="flex items-center justify-between mb-3 pb-2 border-b border-red-100">
      <h3 class="font-bold text-lg text-red-700 flex items-center">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-red-500" viewBox="0 0 20 20" fill="currentColor">
      <path d="M5.5 16a3.5 3.5 0 01-.369-6.98 4 4 0 117.753-1.977A4.5 4.5 0 1113.5 16h-8z" />
      </svg>
      Stasiun Pemancar
      </h3>
      <span class="px-2 py-1 bg-red-100 text-red-800 text-xs font-semibold rounded-full">
      {{ \Carbon\Carbon::parse($item->created_at)->format('Y') }}
      </span>
      </div>
      <div class="mb-3 bg-red-50 rounded-lg p-3">
      <div class="text-xs text-red-500 font-medium mb-1">Alamat Lengkap</div>
      <p class="font-medium text-gray-800">{{ $lp->alamat ?? '-' }}</p>
      </div>
      <div class="grid grid-cols-2 gap-2 mb-3">
      <div class="bg-red-50/70 rounded-lg p-2">
      <div class="text-xs text-red-500 font-medium mb-1">Kelurahan</div>
      <div class="font-bold text-gray-800">{{ $lp->kelurahan ?? '-' }}</div>
      </div>
      <div class="bg-red-50/70 rounded-lg p-2">
      <div class="text-xs text-red-500 font-medium mb-1">Kecamatan</div>
      <div class="font-bold text-gray-800">{{ $lp->kecamatan ?? '-' }}</div>
      </div>
      </div>
      <div class="grid grid-cols-2 gap-2">
      <div class="bg-red-50/70 rounded-lg p-2">
      <div class="text-xs text-red-500 font-medium mb-1">Koordinat</div>
      <div class="font-medium text-gray-800 flex items-center">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-red-500" viewBox="0 0 20 20" fill="currentColor">
      <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
      </svg>
      <span class="text-sm">{{ $lp->latitude }}, {{ $lp->longitude }}</span>
      </div>
      </div>
      <div class="bg-red-50/70 rounded-lg p-2">
      <div class="text-xs text-red-500 font-medium mb-1">Tinggi MDPL</div>
      <div class="font-bold text-gray-800 flex items-center">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-red-500" viewBox="0 0 20 20" fill="currentColor">
      <path fill-rule="evenodd" d="M5.293 9.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 7.414V15a1 1 0 11-2 0V7.414L6.707 9.707a1 1 0 01-1.414 0z" clip-rule="evenodd" />
      </svg>
      {{ $lp->tinggi_lokasi_mdpl ?? '-' }} m
      </div>
      </div>
      </div>
      </div>
      `;

      lpMarker.bindPopup(lpPopup);

      if (!markerGroups[groupId]) markerGroups[groupId] = [];
      markerGroups[groupId].push(lpMarker);

      lpMarker.on('click', function () {
      highlightGroup(this.options.groupId);
      });
    @endif
    @endforeach

      // =============== HIGHLIGHT FUNCTION ===============
      function highlightGroup(groupId) {
        // Reset all markers
        for (var id in markerGroups) {
          markerGroups[id].forEach(function (m) {
            m.setIcon(m.options.originalIcon);
          });
        }
        // Highlight the group
        if (markerGroups[groupId]) {
          markerGroups[groupId].forEach(function (m) {
            if (m.options.type === 'pengukuran') {
              m.setIcon(highlightedDefaultIcon);
            } else if (m.options.type === 'lokasiPemancar') {
              m.setIcon(highlightedPemancarIcon);
            }
          });
        }
      }

      // ==== Filter marker sekali setelah semua marker di-push ====
      filterMapMarkers();

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

      hideAllContainers();
      mapContainer.classList.remove("hidden");

      setTimeout(() => {
        document.querySelector('.loading-animation').style.display = 'none';
      }, 800);
    });

    // =============== DETAIL MODAL ===============
    function showDetail(
      noIsr, frekuensi, bandwidth, daya,
      pengukuranLat, pengukuranLng,     // baru
      lokasiPemancarLat, lokasiPemancarLng, // baru
      h1, h2, h3, alamat, kota, kecamatan, kelurahan, tanggalUkur, fieldStrength, deviasi, catatan
    ) {
      document.getElementById('modalNoISR').innerText = noIsr;
      document.getElementById('modalTanggalUkur').innerText = tanggalUkur;
      document.getElementById('modalAlamat').innerText = alamat;
      document.getElementById('modalKota').innerText = kota;
      document.getElementById('modalKecamatan').innerText = kecamatan;
      document.getElementById('modalKelurahan').innerText = kelurahan;
      document.getElementById('modalKoordinat').innerText =
        `Pengukuran: ${pengukuranLat}, ${pengukuranLng}  |  Pemancar: ${lokasiPemancarLat}, ${lokasiPemancarLng}`;
      document.getElementById('modalFrekuensi').innerText = `${frekuensi} MHz`;
      document.getElementById('modalBandwidth').innerText = `${bandwidth} kHz`;
      document.getElementById('modalDaya').innerText = `${daya} W`;
      document.getElementById('modalDeviasi').innerText = deviasi && deviasi !== '-' && deviasi !== null ? `${deviasi} kHz` : 'Tidak tersedia';
      document.getElementById('modalH1').innerText = `${h1} dBm`;
      document.getElementById('modalH2').innerText = `${h2} dBm`;
      document.getElementById('modalH3').innerText = `${h3} dBm`;
      const h1Value = parseFloat(h1);
      const h2Value = parseFloat(h2);
      const h3Value = parseFloat(h3);

      const minDbm = -120;
      const maxDbm = 0;
      const range = maxDbm - minDbm;

      const h1Percent = Math.min(100, Math.max(0, ((h1Value - minDbm) / range) * 100));
      const h2Percent = Math.min(100, Math.max(0, ((h2Value - minDbm) / range) * 100));
      const h3Percent = Math.min(100, Math.max(0, ((h3Value - minDbm) / range) * 100));

      document.getElementById('modalH1Bar').style.width = `${h1Percent}%`;
      document.getElementById('modalH2Bar').style.width = `${h2Percent}%`;
      document.getElementById('modalH3Bar').style.width = `${h3Percent}%`;

      document.getElementById('modalH1Bar').className = `progress-bar ${h1Percent > 70 ? 'high' : h1Percent > 40 ? 'medium' : 'low'}`;
      document.getElementById('modalH2Bar').className = `progress-bar ${h2Percent > 70 ? 'high' : h2Percent > 40 ? 'medium' : 'low'}`;
      document.getElementById('modalH3Bar').className = `progress-bar ${h3Percent > 70 ? 'high' : h3Percent > 40 ? 'medium' : 'low'}`;

      document.getElementById('modalCatatan').innerText = catatan || 'Tidak ada catatan';
      document.getElementById('detailModal').classList.remove('hidden');

      var lat1 = parseFloat(pengukuranLat);
      var lng1 = parseFloat(pengukuranLng);
      var lat2 = parseFloat(lokasiPemancarLat);
      var lng2 = parseFloat(lokasiPemancarLng);

      let jarakText = 'Tidak tersedia';

      if (!isNaN(lat1) && !isNaN(lng1) && !isNaN(lat2) && !isNaN(lng2)) {
        jarakText = haversine(lat1, lng1, lat2, lng2).toLocaleString('id-ID', { maximumFractionDigits: 0 }) + " meter";
      }

      document.getElementById('modalJarak').innerText = jarakText;

      // Rumus Haversine (jarak antara dua koordinat lat/lng, hasil meter)
      function haversine(lat1, lon1, lat2, lon2) {
        const R = 6371000; // radius Bumi dalam meter
        const dLat = (lat2 - lat1) * Math.PI / 180;
        const dLon = (lon2 - lon1) * Math.PI / 180;
        const a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
          Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) *
          Math.sin(dLon / 2) * Math.sin(dLon / 2);
        const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
        return R * c;
      }
    }

    function closeModal() {
      document.getElementById('detailModal').classList.add('hidden');
    }

  </script>


</body>

</html>