<x-app-layout>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-pap5..." crossorigin="anonymous" referrerpolicy="no-referrer" />

    <div class="p-4 sm:p-8 bg-gray-100 min-h-screen flex items-center justify-center">
        <div class="bg-white p-6 sm:p-8 rounded-xl shadow-lg w-full max-w-4xl">
            <div class="flex justify-between text-center text-sm text-gray-400 mb-6 sm:mb-8">
                <div class="text-blue-600 font-semibold">Form Laporan</div>
            </div>

            @if ($errors->any())
                <div class="mb-6 bg-red-100 border border-red-400 text-red-700 rounded-lg p-4 text-sm">
                    <ul class="list-disc pl-5 space-y-1 text-left">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

           <form action="{{ route('laporan.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="flex flex-col md:flex-row gap-4 sm:gap-6">
        <!-- Judul -->
        <div class="flex-1">
            <label class="block text-sm font-medium text-gray-700">Judul</label>
            <input type="text" name="judul" placeholder="Judul laporan"
                class="mt-1 w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                required>
        </div>

        <!-- Lokasi -->
        <div class="flex-1">
            <label class="block text-sm font-medium text-gray-700">Lokasi</label>
            <input type="text" name="lokasi" placeholder="Lokasi kejadian"
                class="mt-1 w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                required>
        </div>

        <!-- Upload Media -->
        <div class="flex-1 flex flex-col items-center justify-center mt-4 md:mt-0">
            <label
                class="w-24 h-24 sm:w-28 sm:h-28 bg-blue-100 rounded-full flex items-center justify-center cursor-pointer 
                hover:bg-blue-200 hover:scale-105 transition-all duration-300 ease-in-out">
                <i class="fas fa-camera text-blue-500 text-3xl sm:text-4xl" id="camera-icon"></i>
                <input type="file" name="foto" accept="image/*,video/*" class="hidden"
                    id="media-input" required>
            </label>
            <span class="mt-2 text-sm text-gray-700 text-center">Add Photo/Video</span>
            <img id="preview" class="mt-4 w-32 h-32 sm:w-36 sm:h-36 object-cover rounded-lg hidden" />
        </div>
    </div>

    <!-- Deskripsi -->
    <div class="mt-4 sm:mt-6">
        <label class="block text-sm font-medium text-gray-700">Deskripsi</label>
        <textarea name="deskripsi" rows="4" placeholder="Deskripsi"
            class="mt-1 w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 resize-none"
            required></textarea>
    </div>

    <!-- Tombol Submit -->
    <div class="flex justify-center mt-4 sm:mt-6">
        <button type="submit"
            class="w-3/4 sm:w-1/2 py-2.5 bg-blue-500 hover:bg-blue-600 text-white font-semibold rounded-md shadow-md transition transform hover:scale-105 block">
            Kirim Laporan
        </button>
    </div>
</form>

        </div>
    </div>

    <script>
        const input = document.getElementById('media-input');
        const preview = document.getElementById('preview');
        const cameraIcon = document.getElementById('camera-icon');

        input.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.classList.remove('hidden');
                    cameraIcon.style.display = 'none';
                }
                reader.readAsDataURL(file);
            } else {
                preview.src = '';
                preview.classList.add('hidden');
                cameraIcon.style.display = 'block';
            }
        });
    </script>
</x-app-layout>