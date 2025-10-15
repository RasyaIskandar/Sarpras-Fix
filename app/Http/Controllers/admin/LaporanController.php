<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Laporan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class LaporanController extends Controller
{
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

    // Filter pencarian berdasarkan judul
    if ($request->has('search') && !empty($request->search)) {
        $search = $request->search;
        $query->where('judul', 'like', "%{$search}%");
    }

    // Urutan custom berdasarkan status lalu created_at
    $query->orderByRaw("
        CASE 
            WHEN status = 'pending' THEN 1
            WHEN status = 'proses' THEN 2
            WHEN status = 'selesai' THEN 3
        END
    ")->orderBy('created_at', 'desc');

    // Eksekusi query dengan pagination
    $laporans = $query->paginate(10);

    return view('dashboard', compact('laporans'));
}


    // Update status & upload bukti
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'deskripsi_selesai' => 'required|string',
            'bukti_selesai' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $laporan = Laporan::findOrFail($id);

        $file = $request->file('bukti_selesai');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $path = $file->storeAs('bukti_selesai', $fileName, 'public');

        $laporan->update([
            'status' => 'selesai',
            'deskripsi_tindakan' => $request->deskripsi_selesai,
            'bukti' => $path,
        ]);

        return redirect()->back()->with('success', 'Laporan berhasil diperbarui.');
    }

    // DESTROY (Admin Only)
public function destroy(Laporan $laporan)
{
    $laporan->delete();
    return redirect()->route('dashboard')->with('success', 'Laporan berhasil dihapus.');
}

public function exportPdf($mode = 'all')
{
    Carbon::setLocale('id');

    if ($mode === 'weekly') {
        $laporans = Laporan::with('user')
            ->whereBetween('created_at', [
                Carbon::now()->startOfWeek(),
                Carbon::now()->endOfWeek()
            ])
            ->get();
    } elseif ($mode === 'custom') {
        $startDate = Carbon::parse(request()->start_date)->startOfDay();
        $endDate = Carbon::parse(request()->end_date)->endOfDay();

        $laporans = Laporan::with('user')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->get();
    } else {
        $laporans = Laporan::with('user')->get();
    }

    $pdf = Pdf::loadView('laporan.pdf', [
        'laporans' => $laporans,
        'startDate' => $startDate ?? null,
        'endDate' => $endDate ?? null,
        'admin' => Auth::user()->name ?? 'Admin',
        'tanggal_cetak' => now()->format('d-m-Y H:i'),
    ])->setPaper('a4', 'landscape');

    return $pdf->download("laporan-{$mode}.pdf");
}

}