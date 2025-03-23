<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
            @foreach ($lockers as $locker)
                <div 
                    class="bg-white p-4 rounded-lg shadow-lg text-center transform transition duration-200 hover:scale-105"
                >
                    <img 
                        src="{{ $locker->is_reserved ? asset('images/locker-reserved.png') : asset('images/locker-available.png') }}" 
                        alt="Locker Icon" 
                        class="w-20 h-20 object-contain mx-auto mb-2 cursor-pointer transition-transform duration-200 hover:scale-110"
                        onclick="openModal({{ $locker->id }}, '{{ $locker->name }}', {{ $locker->is_reserved ? 'true' : 'false' }}, '{{ $locker->reserved_until }}')"
                    >
                    <h3 class="mt-2 font-bold text-gray-800">{{ $locker->name }}</h3>
                    <p class="text-sm {{ $locker->is_reserved ? 'text-red-500' : 'text-green-600' }}">
                        {{ $locker->is_reserved ? '⛔ Reserved' : '✅ Available' }}
                    </p>
                    @if (!$locker->is_reserved)
                        <button class="mt-2 px-3 py-1 text-sm bg-blue-600 text-white rounded hover:bg-blue-700">
                            Reserve
                        </button>
                    @endif
                </div>
            @endforeach
        </div>
    </div>

    <!-- Modal -->
    <div id="lockerModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50">
        <div class="flex items-center justify-center min-h-screen">
            <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md relative">
                <button onclick="closeModal()" class="absolute top-2 right-2 text-gray-600 hover:text-black text-xl font-bold">&times;</button>
                <h2 id="modalLockerName" class="text-lg font-bold mb-2"></h2>
                <p id="modalLockerStatus" class="mb-4 text-sm text-gray-700"></p>
                <button id="modalReserveBtn" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    Reserve this Locker
                </button>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script>
        function openModal(id, name, isReserved, reservedUntil) {
            document.getElementById('lockerModal').classList.remove('hidden');
            document.getElementById('modalLockerName').textContent = name;
            document.getElementById('modalLockerStatus').textContent = isReserved
                ? `This locker is currently reserved until: ${reservedUntil}`
                : `This locker is available for reservation.`;

            const reserveBtn = document.getElementById('modalReserveBtn');
            reserveBtn.style.display = isReserved ? 'none' : 'inline-block';
        }

        function closeModal() {
            document.getElementById('lockerModal').classList.add('hidden');
        }
    </script>
</x-app-layout>
