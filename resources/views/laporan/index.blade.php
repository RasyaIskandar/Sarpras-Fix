<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center flex-wrap gap-4">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Laporan
            </h2>

            <div class="flex flex-wrap gap-2">
                {{-- Tombol Tambah Laporan --}}
                <a href="{{ route('laporan.create') }}"
                   class="flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700 transition">
                    <i class="fa-solid fa-plus"></i>
                    <span>Tambah</span>
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-10 bg-gray-100 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-lg rounded-2xl p-6 border border-gray-100">

                <!-- Header -->
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800 mb-1">Laporan</h2>
                        <p class="text-sm text-gray-500">{{ $laporans->count() }} Laporan</p>
                    </div>
                </div>

                <!-- Filter & Date -->
<div class="flex flex-col gap-3 md:flex-row md:items-center justify-between flex-wrap mb-6">

    <!-- Status Filter -->
    <div class="flex flex-wrap gap-3 text-sm font-medium text-gray-500">
        <a href="{{ route('laporan.index', ['status' => null] + request()->except('status')) }}"
           class="flex items-center px-3 py-1 {{ request('status') === null ? 'border-b-2 border-blue-600 text-blue-600' : 'hover:text-blue-600' }}">
            <i class="fa-solid fa-list mr-1"></i> Semua
        </a>
        <a href="{{ route('laporan.index', ['status' => 'pending'] + request()->except('status')) }}"
           class="flex items-center px-3 py-1 {{ request('status') === 'pending' ? 'border-b-2 border-blue-600 text-blue-600' : 'hover:text-blue-600' }}">
            <i class="fa-solid fa-clock mr-1"></i> Pending
        </a>
        <a href="{{ route('laporan.index', ['status' => 'selesai'] + request()->except('status')) }}"
           class="flex items-center px-3 py-1 {{ request('status') === 'selesai' ? 'border-b-2 border-blue-600 text-blue-600' : 'hover:text-blue-600' }}">
            <i class="fa-solid fa-circle-check mr-1"></i> Selesai
        </a>
    </div>

    <!-- Search & Date Range Filter -->
    <form method="GET" action="{{ route('laporan.index') }}" 
          class="flex flex-wrap gap-2 items-center text-sm text-gray-600">
        <input type="hidden" name="status" value="{{ request('status') }}">

        <!-- Search Input -->
        <input type="text" name="search" value="{{ request('search') }}"
               placeholder="Cari Judul.."
               class="border border-gray-300 rounded-lg px-3 py-1 bg-white w-full sm:w-48">

        <!-- Date Filters -->
        <input type="date" name="start_date" value="{{ request('start_date') }}"
               class="border border-gray-300 rounded-lg px-3 py-1 bg-white w-full sm:w-auto">
        <span class="hidden sm:inline">s/d</span>
        <input type="date" name="end_date" value="{{ request('end_date') }}"
               class="border border-gray-300 rounded-lg px-3 py-1 bg-white w-full sm:w-auto">

        <div class="flex gap-2 mt-2 sm:mt-0">
            <button type="submit"
                    class="px-3 py-1 bg-blue-500 text-white rounded-lg">Filter</button>
            <a href="{{ route('laporan.index') }}"
               class="px-3 py-1 bg-gray-400 text-white rounded-lg">Reset</a>
        </div>
    </form>
</div>


                @php
                    $sorted = $laporans->sortByDesc(function($laporan) {
                        return $laporan->status === 'pending' ? now()->addYears(10) : $laporan->created_at;
                    });
                @endphp

                <!-- Table Desktop -->
                <div class="hidden sm:block overflow-x-auto">
                    <table class="min-w-full bg-white text-sm text-left border-separate border-spacing-y-2">
                        <thead class="text-gray-500 uppercase text-xs">
                            <tr>
                                <th class="px-6 py-3">No</th>
                                <th class="px-6 py-3">Judul</th>
                                <th class="px-6 py-3">Tanggal</th>
                                <th class="px-6 py-3">Status</th>
                                <th class="px-6 py-3">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($sorted as $laporan)
                                <tr class="group bg-white shadow-sm rounded-lg text-gray-700 
                                           hover:bg-blue-500 hover:text-white hover:shadow-md
                                           transform transition-all duration-300 hover:translate-x-10 hover:scale-105">
                                    <td class="px-6 py-4 rounded-l-lg border border-gray-300 border-r-0">
                                        {{ $loop->iteration }}
                                    </td>
                                    <td class="px-6 py-4 border-t border-b border-gray-300">
                                        {{ $laporan->judul }}
                                    </td>
                                    <td class="px-6 py-4 border-t border-b border-gray-300 text-gray-500">
                                        {{ $laporan->created_at->format('d M Y') }}
                                    </td>
                                    <td class="px-6 py-4 border-t border-b border-gray-300">
                                        @if ($laporan->status == 'pending')
                                            <span class="inline-flex items-center gap-2 px-3 py-1 text-xs font-semibold rounded-full 
                                                text-orange-500">
                                                <span class="w-2 h-2 rounded-full bg-orange-500"></span>
                                                Pending
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-2 px-3 py-1 text-xs font-semibold rounded-full 
                                                text-green-700">
                                                <span class="w-2 h-2 rounded-full bg-green-500"></span>
                                                Selesai
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 flex items-center space-x-2 rounded-r-lg border border-gray-300 border-l-0">
                                        <a href="{{ route('laporan.show', $laporan->id) }}"
                                           class="bg-transparent px-4 py-2 rounded-lg shadow flex items-center justify-center
                                                  group-hover:bg-blue-400">
                                            <i class="fa-solid fa-chevron-down text-base text-black group-hover:text-white"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-gray-500 py-6">
                                        Belum ada laporan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Mobile Card -->
                <div class="sm:hidden space-y-4">
                    @forelse($sorted as $laporan)
                        <div class="group bg-white border border-black shadow-sm rounded-lg p-4 text-gray-700
                                    hover:bg-blue-500 hover:text-white hover:shadow-md
                                    transform transition-all duration-300 hover:-translate-y-1 hover:scale-105">

                            <div class="flex justify-between items-center">
                                <div class="font-semibold text-lg">{{ $laporan->judul }}</div>
                                <div class="flex items-center space-x-2">
                                    <a href="{{ route('laporan.show', $laporan->id) }}"
                                       class="bg-transparent px-4 py-2 rounded-lg shadow flex items-center justify-center
                                              group-hover:bg-blue-400">
                                        <i class="fa-solid fa-chevron-down text-base text-black group-hover:text-white"></i>
                                    </a>
                                </div>
                            </div>

                            <div class="mt-2">
                                <div class="text-sm text-gray-500 group-hover:text-white">
                                    No: <span class="font-bold">#{{ $loop->iteration }}</span>
                                </div>
                                <div class="text-sm text-gray-500 group-hover:text-white">
                                    Tanggal: {{ $laporan->created_at->format('d M Y') }}
                                </div>
                            </div>

                            <div class="mt-2">
                                @if ($laporan->status == 'pending')
                                    <span class="inline-flex items-center gap-2 px-3 py-1 text-xs font-semibold rounded-full 
                                        text-orange-500">
                                        <span class="w-2 h-2 rounded-full bg-orange-500"></span>
                                        Pending
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-2 px-3 py-1 text-xs font-semibold rounded-full 
                                        text-green-700">
                                        <span class="w-2 h-2 rounded-full bg-green-500"></span>
                                        Selesai
                                    </span>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="text-center text-gray-500 py-6">
                            Belum ada laporan.
                        </div>
                    @endforelse
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
