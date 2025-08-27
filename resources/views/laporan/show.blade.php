<x-app-layout>
    <div class="p-8 bg-gray-100 min-h-screen flex items-center justify-center">
        <div class="bg-white p-10 rounded-xl shadow-lg flex flex-col md:flex-row gap-8 w-full max-w-6xl">

            {{-- Media Utama --}}
            <div class="flex-1 bg-white border-2 border-dashed border-blue-400 rounded-lg p-6 flex flex-col items-center justify-center text-center space-y-4">
                @if ($laporan->foto)
                    <img src="{{ asset('storage/' . $laporan->foto) }}" alt="Foto Laporan"
                        class="w-full h-auto rounded-xl shadow-lg border transition transform hover:scale-[1.02] hover:shadow-xl">
                @else
                    <p class="text-gray-400 italic">Tidak ada foto dilampirkan.</p>
                @endif
            </div>

            {{-- Info Detail --}}
            <div class="flex-1 space-y-6">
                <h2 class="text-2xl font-bold text-gray-800">Info Detail</h2>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Judul</label>
                    <input type="text" value="{{ $laporan->judul }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        readonly>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                    <textarea rows="4" readonly
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 resize-none">{{ $laporan->deskripsi }}</textarea>
                </div>

                @if ($laporan->lokasi)
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Lokasi Kejadian</label>
                        <input type="text" value="{{ $laporan->lokasi }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                            readonly>
                    </div>
                @endif

                <div class="flex flex-col sm:flex-row gap-6">
                    <div class="flex-1 space-y-2">
                        <span class="block text-sm font-medium text-gray-700">Tanggal Dibuat</span>
                        <input type="text"
                            value="{{ $laporan->created_at->format('d M Y, H:i') }}" readonly
                            class="w-full text-black rounded-lg px-4 py-2 text-sm font-medium text-center cursor-default" />
                    </div>
                </div>

                <div class="flex-1 space-y-2">
                    <span class="block text-sm font-medium text-gray-700">Status</span>
                    <input type="text"
                        value="{{ ucfirst($laporan->status) }}" readonly
                        class="w-full text-sm font-medium text-center rounded-lg px-4 py-2 cursor-default
                        {{ $laporan->status === 'pending'
                            ? 'bg-yellow-100 text-yellow-800 border border-yellow-300'
                            : ($laporan->status === 'diproses'
                                ? 'bg-blue-100 text-blue-800 border border-blue-300'
                                : 'bg-green-100 text-green-800 border border-green-300') }}" />
                </div>

                {{-- Jika laporan selesai, tampilkan tindakan admin --}}
                @if($laporan->status === 'selesai')
                    <div class="space-y-4 pt-4 border-t border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-800">Tindakan Admin</h3>

                        <div>
                            <span class="block text-sm font-medium text-gray-700">Tanggal Selesai</span>
                            <input type="text"
                                value="{{ $laporan->updated_at->format('d M Y, H:i') }}" readonly
                                class="w-full text-black rounded-lg px-4 py-2 text-sm font-medium text-center cursor-default" />
                        </div>

                        @if($laporan->deskripsi_tindakan)
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Tindakan</label>
                                <textarea rows="3" readonly
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 resize-none">{{ $laporan->deskripsi_tindakan }}</textarea>
                            </div>
                        @endif

                        @if($laporan->bukti)
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Bukti Penyelesaian</label>
                                <img src="{{ asset('storage/' . $laporan->bukti) }}" alt="Bukti Penyelesaian"
                                    class="w-full max-w-md rounded-xl shadow-lg border transition transform hover:scale-[1.02] hover:shadow-xl">
                            </div>
                        @endif
                    </div>
                @endif

                <div class="flex justify-end pt-4">
                    <a href="{{ route('laporan.index') }}"
                        class="bg-blue-500 text-white px-6 py-2 rounded-lg font-medium shadow-sm hover:bg-blue-600 transition flex items-center space-x-2">
                        <span>Close</span>
                        <i class="fa-solid fa-xmark w-4 h-4 text-white"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
