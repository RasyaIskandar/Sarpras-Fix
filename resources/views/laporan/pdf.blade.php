<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Laporan Sarpras</title>
<style>
  body {
    font-family: Arial, sans-serif;
    font-size: 12px;
    margin: 20px;
  }
  h2 {
    text-align: center;
    margin-bottom: 25px;
    color: #2c3e50;
  }
  table {
    width: 100%;
    border-collapse: collapse;
    table-layout: fixed; /* Supaya wrap bekerja */
  }
  th, td {
    border: 1px solid #ddd;
    padding: 8px;
    overflow-wrap: break-word;
    word-break: break-word;
    white-space: normal;
  }
  th {
    background-color: #2c3e50;
    color: white;
    text-align: center;
  }
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
</style>
</head>
<body>
<h2>Data Laporan Kerusakan Sarpras</h2>
<table>
  <thead>
    <tr>
      <th>No</th>
      <th>Judul</th>
      <th>Deskripsi</th>
      <th>Status</th>
      <th>Lokasi</th>
      <th>Deskripsi Tindakan</th>
      <th>User</th>
      <th>Tanggal</th>
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
    </tr>
    @endforeach
  </tbody>
</table>
</body>
</html>
