<!DOCTYPE html>
<html>
<head>
    <title>Laporan Gangguan Frekuensi</title>
    <style>
        /* Base Styles */
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 12px;
            color: #333;
            margin: 0;
            padding: 20px;
        }

        /* Header Styles */
        .header {
            border-bottom: 3px solid #378EC3;
            padding-bottom: 15px;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
        }

        .logo {
            width: 80px;
            margin-right: 20px;
        }

        .header-text {
            flex-grow: 1;
        }

        .title {
            color: #378EC3;
            font-size: 24px;
            margin: 0;
            letter-spacing: 2px;
        }

        .subtitle {
            color: #666;
            font-size: 14px;
            margin: 5px 0 0 0;
        }

        /* Metadata Section */
        .metadata {
            background: #F0F9FF;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 25px;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
        }

        .meta-item strong {
            color: #006DB0;
            display: block;
            margin-bottom: 5px;
        }

        /* Table Styles */
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            page-break-inside: avoid;
        }

        th {
            background: #378EC3;
            color: white;
            padding: 10px;
            text-align: left;
            font-weight: bold;
        }

        td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
            vertical-align: top;
        }

        tr:nth-child(even) {
            background-color: #f8f9fa;
        }

        .severity {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 12px;
            font-size: 10px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .severity-high { background: #fee2e2; color: #dc2626; }
        .severity-medium { background: #fef3c7; color: #d97706; }
        .severity-low { background: #dcfce7; color: #16a34a; }

        /* Footer Styles */
        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            text-align: center;
            padding: 10px;
            border-top: 1px solid #ddd;
            background: white;
            font-size: 10px;
            color: #666;
        }

        /* Utility Classes */
        .text-center { text-align: center; }
        .page-number:before { content: "Halaman " counter(page); }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <img src="{{ public_path('images/logo_kominfo.png') }}" class="logo">
        <div class="header-text">
            <h1 class="title">LAPORAN GANGGUAN FREKUENSI</h1>
            <p class="subtitle">Balai Monitoring Spektrum Frekuensi Radio Kelas 1 Bandung</p>
        </div>
    </div>

    <!-- Metadata -->
    <div class="metadata">
        <div class="meta-item">
            <strong>Tanggal Generate</strong>
            {{ date('d F Y H:i') }}
        </div>
        <div class="meta-item">
            <strong>Total Gangguan</strong>
            {{ count($gangguan) }} Kasus
        </div>
        <div class="meta-item">
            <strong>Periode Laporan</strong>
            {{ $gangguan->min('waktu_kejadian') }} s/d {{ $gangguan->max('waktu_kejadian') }}
        </div>
    </div>

    <!-- Main Table -->
    <table>
        <thead>
            <tr>
                <th width="3%">No</th>
                <th width="12%">Nama Client</th>
                <th width="8%">Lokasi</th>
                <th width="6%">Frekuensi</th>
                <th width="7%">No ST</th>
                <th width="5%">VIC</th>
                <th width="8%">No Laporan</th>
                <th width="6%">Band</th>
                <th width="8%">Jenis Gangguan</th>
                <th width="8%">Severity</th>
                <th width="10%">Waktu Kejadian</th>
                <th width="15%">Uraian</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($gangguan as $key => $item)
            <tr>
                <td class="text-center">{{ $key + 1 }}</td>
                <td>{{ $item->nama_client }}</td>
                <td>{{ optional($item->location)->kota ?? 'N/A' }}</td>
                <td>{{ $item->frekuensi }} MHz</td>
                <td>{{ $item->no_st }}</td>
                <td>{{ $item->vic }}</td>
                <td>{{ $item->no_laporan }}</td>
                <td>{{ $item->band_frekuensi }}</td>
                <td>{{ $item->jenis_gangguan }}</td>
                <td>
                    <span class="severity severity-{{ strtolower($item->severity) }}">
                        {{ $item->severity }}
                    </span>
                </td>
                <td>{{ \Carbon\Carbon::parse($item->waktu_kejadian)->format('d M Y H:i') }}</td>
                <td>{{ Str::limit($item->uraian_gangguan, 50) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Footer -->
    <div class="footer">
        <span class="page-number"></span> • 
        Dokumen ini dihasilkan secara otomatis oleh Sistem Monitoring Frekuensi
    </div>
</body>
</html>