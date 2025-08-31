<x-app-layout>
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
<div x-data="{ sidebarOpen: false }" class="flex min-h-screen bg-gray-50 text-gray-800">
    <div x-cloak x-show="sidebarOpen" class="fixed inset-0 z-40 lg:hidden" role="dialog" aria-modal="true">
        <div @click="sidebarOpen = false" class="fixed inset-0 bg-black bg-opacity-40 transition-opacity"></div>
        <div class="relative flex-1 flex flex-col max-w-xs w-full bg-white shadow-lg">
            <div class="absolute top-0 right-0 -mr-12 pt-2">
                <button @click="sidebarOpen = false" type="button" class="ml-1 flex items-center justify-center h-10 w-10 rounded-full focus:outline-none focus:ring-2 focus:ring-inset focus:ring-gray-400">
                    <span class="sr-only">Close sidebar</span>
                    <svg class="h-6 w-6 text-gray-700" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div class="flex flex-col w-0 flex-1 overflow-hidden">
        <div class="lg:hidden flex items-center justify-between px-4 py-2 border-b border-gray-200 bg-white">
            <button @click="sidebarOpen = true" class="text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100">
                <span class="sr-only">Open sidebar</span>
                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" />
                </svg>
            </button>
            <h1 class="text-xl font-bold text-gray-900">Dashboard Admin</h1>
        </div>

        <main class="flex-1 p-4 sm:p-6 lg:p-8 bg-gray-100 relative overflow-hidden">
            <h2 class="text-xl sm:text-2xl font-bold mb-6 text-gray-800">Dashboard Admin</h2>

            <!-- Chart Section -->
            <div class="bg-white p-4 sm:p-6 rounded-2xl text-gray-800 shadow-lg border border-gray-200">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-2 mb-3">
                    <h2 class="text-base sm:text-lg font-semibold">Overview Laporan Tahunan</h2>
                    <select id="chartFilter" class="bg-gray-100 text-gray-800 text-xs sm:text-sm px-3 py-1 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-400">
                        <option value="total">Total</option>
                        <option value="pending">Pending</option>
                        <option value="selesai">Selesai</option>
                    </select>
                </div>
                <div class="w-full h-40 sm:h-56">
                    <canvas id="laporanChart"></canvas>
                </div>
            </div>

            <!-- Filter Section (DITAMBAHKAN) -->
            <div class="bg-white p-4 sm:p-6 rounded-2xl shadow-lg border border-gray-200 mt-8 max-w-5xl mx-auto">
                <form method="GET" action="{{ route('dashboard') }}" class="flex flex-wrap gap-4 items-end">
                    <!-- Search -->
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Cari Judul</label>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Masukkan judul"
                            class="border rounded-lg px-3 py-2 text-sm w-48">
                    </div>

                    <!-- Filter Status -->
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Status</label>
                        <select name="status" class="border rounded-lg px-3 py-2 text-sm w-40">
                            <option value="">Semua</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="diproses" {{ request('status') == 'diproses' ? 'selected' : '' }}>Diproses</option>
                            <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                        </select>
                    </div>
                    
                    <!-- Filter Range -->
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Dari</label>
                        <input type="date" name="start_date" value="{{ request('start_date') }}"
                            class="border rounded-lg px-3 py-2 text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Sampai</label>
                        <input type="date" name="end_date" value="{{ request('end_date') }}"
                            class="border rounded-lg px-3 py-2 text-sm">
                    </div>

                    <!-- Tombol -->
                    <div class="flex gap-2">
                        <button type="submit"
                            class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-700">
                            Terapkan
                        </button>
                        <a href="{{ route('dashboard') }}"
                            class="bg-gray-400 text-white px-4 py-2 rounded-lg text-sm hover:bg-gray-500">
                            Reset
                        </a>
                    </div>

                    {{-- Tombol Export PDF khusus admin --}}
                    @if(Auth::user()->role === 'admin')
                        {{-- Export laporan pekan ini --}}
                        <a href="{{ route('laporan.exportPdf', ['mode' => 'weekly']) }}"
                        class="flex items-center gap-2 px-4 py-2 bg-green-600 text-white rounded-lg shadow hover:bg-green-700 transition">
                            <i class="fa-solid fa-file-pdf"></i>
                            <span>Export PDF (Pekan Ini)</span>
                        </a>

                        {{-- Export laporan pekan ini --}}
                        <a href="{{ route('laporan.exportPdf', ['mode' => 'custom', 'start_date' => request('start_date'), 'end_date' => request('end_date')]) }}"
                        class="flex items-center gap-2 px-4 py-2 bg-yellow-600 text-white rounded-lg shadow hover:bg-yellow-700 transition">
                            <i class="fa-solid fa-file-pdf"></i>
                            <span>Export PDF (Tanggal Tertentu)</span>
                        </a>

                        {{-- Export semua laporan --}}
                        <a href="{{ route('laporan.exportPdf', ['mode' => 'all']) }}"
                        class="flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700 transition">
                            <i class="fa-solid fa-file-pdf"></i>
                            <span>Export PDF (Semua)</span>
                        </a>
                    @endif
                </form>
            </div>

            <!-- Table Section -->
            <div class="bg-white shadow-lg rounded-2xl overflow-hidden border border-gray-200 max-w-5xl mx-auto my-8">
                <div class="bg-gray-100 text-gray-800 p-4">
                    <h3 class="text-xl font-bold">Daftar Laporan Terbaru</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-gray-700">
                        <thead class="bg-gray-200 text-gray-700 uppercase text-xs font-semibold tracking-wider">
                            <tr>
                                <th class="px-6 py-4 text-left">No</th> {{-- Nomor urut --}}
                                <th class="px-6 py-4 text-left">Barang</th>
                                <th class="px-6 py-4 text-left">Status</th>
                                <th class="px-6 py-4 text-left hidden sm:table-cell">Tanggal</th>
                                <th class="px-6 py-4 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($laporans as $laporan)
                            <tr class="hover:bg-gray-50 transition-colors">
                                  <td class="px-6 py-4 font-medium">{{ $loop->iteration }}</td> {{-- Nomor urut otomatis --}}
                                <td class="px-6 py-4 font-medium">{{ $laporan->judul }}</td>
                                <td class="px-6 py-4">
                                    <span class="px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wide
                                        {{ $laporan->status === 'selesai' ? 'bg-green-100 text-green-700'
                                        : ($laporan->status === 'diproses' ? 'bg-yellow-100 text-yellow-700'
                                        : 'bg-red-100 text-red-700') }}">
                                        {{ ucfirst($laporan->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 hidden sm:table-cell">{{ $laporan->created_at->format('d M Y') }}</td>
                                <td class="px-6 py-4 text-right relative" x-data="{ open: false }">
                                    <button @click="open = !open" class="p-2 rounded-full hover:bg-gray-200 transition duration-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-300">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6h.01M12 12h.01M12 18h.01" />
                                        </svg>
                                    </button>
                                    <div x-show="open" @click.outside="open=false" x-transition class="absolute right-0 mt-2 w-40 bg-white border border-gray-200 rounded-lg shadow-lg z-50 py-1 text-sm overflow-hidden">
                                        @if($laporan->status === 'pending')
                                        <button type="button" onclick="openModal({{ $laporan->id }})" class="flex items-center gap-2 px-4 py-2 hover:bg-gray-100 w-full text-left transition duration-200 text-green-600">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                            </svg> Selesai
                                        </button>
                                        @endif
                                        <a href="{{ route('laporan.show', $laporan->id) }}" class="flex items-center gap-2 px-4 py-2 hover:bg-gray-100 transition duration-200 text-blue-600">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg> Detail
                                        </a>
                                        <button type="button" onclick="openDeleteModal({{ $laporan->id }})" class="flex items-center gap-2 px-4 py-2 hover:bg-gray-100 w-full text-left text-red-600 transition duration-200">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg> Hapus
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <!-- Modal selesai -->
                            <div id="modal-{{ $laporan->id }}" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
                                <div class="bg-white w-[90%] sm:w-full max-w-md p-6 rounded-2xl shadow-2xl">
                                    <h3 class="text-xl font-semibold mb-4 text-gray-800">Tandai Selesai</h3>
                                    <form action="{{ route('laporan.updateStatus', $laporan->id) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('PATCH')
                                        <div class="mb-4">
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Upload Bukti</label>
                                            <input type="file" name="bukti_selesai" accept="image/*" required class="w-full text-sm border border-gray-300 rounded-lg p-3 text-gray-800 bg-gray-50 focus:ring-2 focus:ring-green-400 focus:outline-none">
                                        </div>
                                        <div class="mb-4">
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                                            <textarea name="deskripsi_selesai" rows="4" required class="w-full border border-gray-300 rounded-lg p-3 text-sm text-gray-800 bg-gray-50 focus:ring-2 focus:ring-green-400 focus:outline-none"></textarea>
                                        </div>
                                        <div class="flex justify-end gap-3">
                                            <button type="button" onclick="closeModal({{ $laporan->id }})" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium px-5 py-2.5 rounded-lg">Batal</button>
                                            <button type="submit" class="bg-green-500 hover:bg-green-600 text-white font-medium px-5 py-2.5 rounded-lg">Kirim</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <!-- Modal hapus -->
                            <div id="delete-modal-{{ $laporan->id }}" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
                                <div class="bg-white w-[90%] sm:w-full max-w-md p-6 rounded-2xl shadow-2xl">
                                    <h3 class="text-xl font-semibold mb-4 text-gray-800">Hapus Laporan</h3>
                                    <p class="text-sm text-gray-600 mb-6">Apakah kamu yakin ingin menghapus laporan <strong>{{ $laporan->judul }}</strong>? Aksi ini tidak bisa dibatalkan.</p>
                                    <form action="{{ route('laporan.destroy', $laporan->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <div class="flex justify-end gap-3">
                                            <button type="button" onclick="closeDeleteModal({{ $laporan->id }})" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium px-5 py-2.5 rounded-lg">Batal</button>
                                            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-medium px-5 py-2.5 rounded-lg">Ya, Hapus</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center py-6 text-gray-500 italic">Belum ada laporan.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    function openDeleteModal(id) {
        document.getElementById('delete-modal-' + id).classList.remove('hidden');
    }
    function closeDeleteModal(id) {
        document.getElementById('delete-modal-' + id).classList.add('hidden');
    }
    function openModal(id) {
        let modal = document.getElementById(`modal-${id}`);
        modal.classList.remove("hidden");
        modal.classList.add("flex");
        let textarea = modal.querySelector("textarea");
        if (textarea) setTimeout(() => textarea.focus(), 200);
    }
    function closeModal(id) {
        let modal = document.getElementById(`modal-${id}`);
        modal.classList.add("hidden");
        modal.classList.remove("flex");
    }

    const dataTotal = [@foreach(range(1,12) as $m) {{ $laporans->whereBetween('created_at', [now()->startOfYear()->month($m)->startOfMonth(), now()->startOfYear()->month($m)->endOfMonth()])->count() }}, @endforeach];
    const dataPending = [@foreach(range(1,12) as $m) {{ $laporans->where('status','pending')->whereBetween('created_at', [now()->startOfYear()->month($m)->startOfMonth(), now()->startOfYear()->month($m)->endOfMonth()])->count() }}, @endforeach];
    const dataSelesai = [@foreach(range(1,12) as $m) {{ $laporans->where('status','selesai')->whereBetween('created_at', [now()->startOfYear()->month($m)->startOfMonth(), now()->startOfYear()->month($m)->endOfMonth()])->count() }}, @endforeach];

    const ctx = document.getElementById('laporanChart').getContext('2d');
    const laporanChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: [@foreach(range(1,12) as $m) "{{ \Carbon\Carbon::create()->month($m)->format('M') }}", @endforeach],
            datasets: [{
                label: 'Total',
                data: dataTotal,
                borderColor: 'rgb(59, 130, 246)',
                backgroundColor: 'rgba(59, 130, 246, 0.2)',
                tension: 0.4,
                fill: true,
                pointBackgroundColor: 'rgb(37, 99, 235)',
                pointRadius: 4,
                pointHoverRadius: 6,
            }]
        },
        options: {
            maintainAspectRatio: false,
            responsive: true,
            plugins: { legend: { display: false } },
            scales: {
                x: { grid: { display: false }, ticks: { color: '#4B5563', font: { size: 10 } } },
                y: { beginAtZero: true, grid: { color: 'rgba(0,0,0,0.1)' }, ticks: { color: '#4B5563', font: { size: 10 }, precision: 0 } }
            }
        }
    });

    document.getElementById('chartFilter').addEventListener('change', function () {
        let selected = this.value;
        let chartData, borderColor, backgroundColor, pointColor;
        if (selected === "total") {
            chartData = dataTotal; borderColor = "rgb(59, 130, 246)"; backgroundColor = "rgba(59, 130, 246, 0.2)"; pointColor = "rgb(37, 99, 235)";
        } else if (selected === "pending") {
            chartData = dataPending; borderColor = "rgb(250, 204, 21)"; backgroundColor = "rgba(250, 204, 21, 0.2)"; pointColor = "rgb(202, 138, 4)";
        } else if (selected === "selesai") {
            chartData = dataSelesai; borderColor = "rgb(34, 197, 94)"; backgroundColor = "rgba(34, 197, 94, 0.2)"; pointColor = "rgb(21, 128, 61)";
        }
        laporanChart.data.datasets[0].data = chartData;
        laporanChart.data.datasets[0].label = selected.charAt(0).toUpperCase() + selected.slice(1);
        laporanChart.data.datasets[0].borderColor = borderColor;
        laporanChart.data.datasets[0].backgroundColor = backgroundColor;
        laporanChart.data.datasets[0].pointBackgroundColor = pointColor;
        laporanChart.update();
    });
</script>
</x-app-layout>
