<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Laporan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    // INDEX
    public function index(Request $request)
    {
        $query = Laporan::query();

        // Filter berdasarkan status
        if ($request->has('status') && $request->status !== null) {
            $query->where('status', $request->status);
        }

        // Filter tanggal tunggal
        if ($request->filled('tanggal')) {
            $query->whereDate('created_at', $request->tanggal);
        }

        // Filter tanggal range
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('created_at', [
                $request->start_date . ' 00:00:00',
                $request->end_date . ' 23:59:59'
            ]);
        }

        // Filter berdasarkan pencarian judul saja
if ($request->has('search') && !empty($request->search)) {
    $search = $request->search;
    $query->where('judul', 'like', "%{$search}%");
}

        // Eksekusi query
        $laporans = $query->latest()->paginate(10);

        return view('laporan.index', compact('laporans'));
    }

    // CREATE
    public function create()
    {
        return view('laporan.create');
    }

    // STORE
    public function store(Request $request)
{
    $request->validate([
        'judul' => 'required|string|max:255',
        'deskripsi' => 'required|string',
        'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    $fotoPath = null;
    if ($request->hasFile('foto')) {
        $fotoPath = $request->file('foto')->store('laporan_foto', 'public');
    }

    Laporan::create([
    'judul' => $request->judul,
    'deskripsi' => $request->deskripsi,
    'lokasi' => $request->lokasi,
    'foto' => $fotoPath,
    'status' => 'pending',
    'user_id' => Auth::id(),
]);

    return redirect()->route('laporan.index')->with('success', 'Laporan berhasil dikirim.');
}

    // SHOW
    public function show(Laporan $laporan)
    {
        // Pastikan kolom admin ada di model dan database
    return view('laporan.show', [
        'laporan' => $laporan
    ]);
    }

    // EDIT (Admin Only)
    public function edit(Laporan $laporan)
    {
        return view('laporan.edit', compact('laporan'));
    }

    // UPDATE (Admin Only)
    public function update(Request $request, Laporan $laporan)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'foto' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
        ]);

        $fotoPath = $laporan->foto;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('laporans', 'public');
        }

        $laporan->update([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'foto' => $fotoPath,
        ]);

        return redirect()->route('laporan.index')->with('success', 'Laporan berhasil diperbarui.');
    }
    

    // DESTROY (Admin Only)
    public function destroy(Laporan $laporan)
    {
        $laporan->delete();
        return redirect()->route('laporan.index')->with('success', 'Laporan berhasil dihapus.');
    }

    public function chartData()
{
    // contoh: hitung jumlah laporan per bulan
   $data = DB::table('laporans')
    ->selectRaw('MONTH(created_at) as bulan, COUNT(*) as total')
    ->groupBy('bulan')
    ->orderBy('bulan')
    ->pluck('total', 'bulan');


    // bikin array labels (Jan - Dec) + data
    $labels = [];
    $values = [];

    for ($i = 1; $i <= 12; $i++) {
        $labels[] = date("M", mktime(0, 0, 0, $i, 1));
        $values[] = $data[$i] ?? 0;
    }

    return response()->json([
        'labels' => $labels,
        'values' => $values
    ]);
}

public function exportPdf(Request $request)
{
    $laporans = Laporan::with('user')->get();

    $pdf = Pdf::loadView('laporan.pdf', compact('laporans'));
    return $pdf->download('laporan.pdf');
}
}
