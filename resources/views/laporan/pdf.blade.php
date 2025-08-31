<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Laporan Sarpras</title>
<style>
  body {
    font-family: Arial, sans-serif;
    font-size: 12px;
    margin: 20px 20px 120px 20px; /* Tambah margin-bottom untuk footer resmi */
  }
  h2 {
    text-align: center;
    margin-bottom: 25px;
    color: #2c3e50;
  }
  table {
    width: 100%;
    border-collapse: collapse;
    table-layout: auto; /* biar kolom menyesuaikan isi */
  }
  th, td {
    border: 1px solid #ddd;
    padding: 8px;
    word-wrap: break-word;
    white-space: normal;
  }
  th {
    background-color: #2c3e50;
    color: white;
    text-align: center;
    white-space: nowrap; /* cegah header pecah ke bawah */
  }

  /* Atur lebar kolom */
  th:nth-child(8), td:nth-child(8) { width: 12%; } /* Tanggal Laporan */
  th:nth-child(9), td:nth-child(9) { width: 12%; } /* Tanggal Selesai */

  tr:nth-child(even) {
    background-color: #f9f9f9;
  }
  tr:hover {
    background-color: #f1f1f1;
  }
  td {
    vertical-align: top;
  }
  .center {
    text-align: center;
  }
  /* Tentukan lebar kolom agar proporsional */
  th:nth-child(1), td:nth-child(1) { width: 5%; }
  th:nth-child(2), td:nth-child(2) { width: 10%; }
  th:nth-child(3), td:nth-child(3) { width: 25%; } /* Deskripsi */
  th:nth-child(4), td:nth-child(4) { width: 10%; }
  th:nth-child(5), td:nth-child(5) { width: 10%; }
  th:nth-child(6), td:nth-child(6) { width: 20%; } /* Deskripsi Tindakan */
  th:nth-child(7), td:nth-child(7) { width: 10%; }
  th:nth-child(8), td:nth-child(8) { width: 10%; }

  /* CSS untuk footer resmi */
  .footer {
    position: fixed;
    bottom: 20px; /* Jarak dari bawah halaman */
    right: 20px; /* Jarak dari kanan */
    width: 100%;
    text-align: right;
    font-size: 11px; /* Ukuran font sedikit lebih kecil */
    line-height: 1.5; /* Jarak antar baris */
    page-break-after: avoid; /* Hindari break di footer */
  }
  .footer .signature-space {
    height: 80px; /* Ruang kosong untuk tanda tangan dan cap */
    margin: 10px 0; /* Jarak atas-bawah */
  }
</style>
</head>
<body>
  <h2>Data Laporan Kerusakan Sarpras</h2>

  <table>
    <thead>
      <tr>
        <th>No</th>
        <th>Laporan</th>
        <th>Deskripsi</th>
        <th>Status</th>
        <th>Lokasi</th>
        <th>Deskripsi Tindakan</th>
        <th>User</th>
        <th>Tanggal Laporan Dibuat</th>
        <th>Tanggal Selesai</th>
      </tr>
    </thead>
    <tbody>
      @foreach($laporans as $laporan)
      <tr>
        <td class="center">{{ $loop->iteration }}</td>
        <td>{{ $laporan->judul }}</td>
        <td>{{ $laporan->deskripsi }}</td>
        <td class="center">{{ ucfirst($laporan->status) }}</td>
        <td>{{ $laporan->lokasi ?? '-' }}</td>
        <td>{{ $laporan->deskripsi_tindakan ?? '-' }}</td>
        <td>{{ $laporan->user->name ?? '-' }}</td>
        <td class="center">{{ $laporan->created_at->format('d-m-Y') }}</td>
        <td class="center">
          @if($laporan->status === 'selesai' && $laporan->updated_at)
            {{ $laporan->updated_at->format('d-m-Y') }}
          @else
            -
          @endif
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>

  <!-- Footer dengan format surat resmi -->
  <div class="footer">
      <p>{{ $startDate }}</p>
      <p>{{ $endDate }}</p>
      <p>Bogor, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
        <p>Petugas Pelaksana</p>

        <br><br><br> <!-- ruang untuk tanda tangan & stempel -->

        <p>{{ $admin ?? '' }}</p>
  </div>
</body>
</html>