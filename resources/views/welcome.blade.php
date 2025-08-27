<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>LaporinAja</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <!-- Force light mode -->
    <style>
        :root {
            color-scheme: light;
        }
    </style>

    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>

<body class="bg-[#FDFDFC] text-[#1b1b18] min-h-screen flex flex-col p-6 lg:p-8">

    <!-- Header -->
    <header class="w-full lg:max-w-6xl max-w-[335px] text-sm mx-auto">
        <div class="flex justify-between items-center w-full">
            <h1 class="text-2xl font-bold">
                LaporinAja
            </h1>

            @if (Route::has('login'))
                <nav class="flex items-center gap-4">
                    @if(Auth::check() && Auth::user()->hasVerifiedEmail())
                        <a href="{{ url('/dashboard') }}"
                           class="inline-block px-5 py-1.5 text-black border border-[#19140035] hover:border-[#1915014a] rounded-sm text-sm leading-normal">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                           class="inline-block px-5 py-1.5 text-[#1b1b18] border border-transparent hover:border-[#19140035] rounded-sm text-sm leading-normal">
                            Log in
                        </a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}"
                               class="inline-block px-5 py-1.5 border-[#19140035] hover:border-[#1915014a] text-[#1b1b18] rounded-sm text-sm leading-normal">
                                Register
                            </a>
                        @endif
                    @endif
                </nav>
            @endif
        </div>
    </header>

    <!-- Konten Utama -->
    <main class="mt-16 lg:mt-24 flex flex-col justify-center items-center text-center px-4">
        <h3 class="text-lg font-medium mb-2">Selamat Datang</h3>
        <h1 class="text-2xl lg:text-4xl font-bold mb-4 max-w-2xl">
            Layanan Pengaduan Kerusakan Sarana & Prasarana
        </h1>
        <p class="text-sm text-gray-600 max-w-xl">
            Sampaikan laporan kerusakan dengan mudah dan cepat agar kenyamanan bersama tetap terjaga.
        </p>
    </main>

    <!-- Langkah-langkah -->
   <section class="mt-20 w-full max-w-6xl mx-auto px-4 relative">
    <!-- Garis horizontal penghubung (desktop) -->
    <div class="hidden lg:block absolute top-9 left-0 right-0 h-px bg-gray-300 z-0"></div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 text-center relative z-10">
        <!-- Langkah 1 -->
        <div class="flex flex-col items-center">
            <div class="bg-white text-black shadow-lg rounded-full p-4 mb-4 
                        hover:bg-blue-500 hover:text-white transition-all duration-300 ease-in-out">
                <i class="fas fa-pen-to-square text-xl"></i>
            </div>
            <h4 class="font-semibold text-lg mb-1">Tulis Laporan</h4>
            <p class="text-sm text-gray-600">
                Laporkan keluhan atau aspirasi Anda dengan jelas dan lengkap
            </p>
        </div>

        <!-- Langkah 2 -->
        <div class="flex flex-col items-center">
            <div class="bg-white text-black shadow-lg rounded-full p-4 mb-4 
                        hover:bg-blue-500 hover:text-white transition-all duration-300 ease-in-out">
                <i class="fas fa-clipboard-check text-xl"></i>
            </div>
            <h4 class="font-semibold text-lg mb-1">Proses Verifikasi</h4>
            <p class="text-sm text-gray-600">
                Dalam 3 hari, laporan Anda akan diverifikasi dan diteruskan ke instansi berwenang
            </p>
        </div>

        <!-- Langkah 3 -->
        <div class="flex flex-col items-center">
            <div class="bg-white text-black shadow-lg rounded-full p-4 mb-4 
                        hover:bg-blue-500 hover:text-white transition-all duration-300 ease-in-out">
                <i class="fas fa-share text-xl"></i>
            </div>
            <h4 class="font-semibold text-lg mb-1">Proses Tindak Lanjut</h4>
            <p class="text-sm text-gray-600">
                Dalam 5 hari, instansi akan menindaklanjuti dan membalas laporan Anda
            </p>
        </div>

        <!-- Langkah 4 -->
        <div class="flex flex-col items-center">
            <div class="bg-white text-black shadow-lg rounded-full p-4 mb-4 
                        hover:bg-blue-500 hover:text-white transition-all duration-300 ease-in-out">
                <i class="fas fa-check text-xl"></i>
            </div>
            <h4 class="font-semibold text-lg mb-1">Selesai</h4>
            <p class="text-sm text-gray-600">
                Laporan Anda akan terus ditindaklanjuti hingga terselesaikan
            </p>
        </div>
    </div>
</section>
 

    @if (Route::has('login'))
        <div class="h-14 hidden lg:block"></div>
    @endif

</body>
</html>
