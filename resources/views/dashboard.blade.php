<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
            @foreach ($lockers as $locker)
                <div class="bg-white p-4 rounded-lg shadow-lg text-center transform transition duration-200 hover:scale-105">
                    <img 
                        src="{{ $locker->is_reserved ? asset('images/locker-reserved.png') : asset('images/locker-available.png') }}" 
                        alt="Locker Icon" 
                        class="w-20 h-20 object-contain mx-auto mb-2 cursor-pointer transition-transform duration-200 hover:scale-110"
                        onclick="openModal({{ $locker->id }}, '{{ $locker->name }}', {{ $locker->is_reserved ? 'true' : 'false' }}, '{{ $locker->reserved_at }}', '{{ $locker->reserved_until }}', '{{ $locker->user_id }}')"
                    >
                    <h3 class="mt-2 font-bold text-gray-800">{{ $locker->name }}</h3>
                    @if ($locker->is_reserved)
                        @if ($locker->user_id === Auth::id())
                            <p class="text-sm text-blue-600 font-semibold">Your Locker</p>
                            <form method="POST" action="{{ route('lockers.cancel', $locker->id) }}">
                                @csrf
                                @method('DELETE')
                                <button class="mt-2 px-3 py-1 text-sm bg-red-600 text-white rounded hover:bg-red-700">
                                    Cancel Reservation
                                </button>
                            </form>
                        @else
                            <p class="text-sm text-red-500">⛔ Reserved</p>
                        @endif
                    @else
                        <p class="text-sm text-green-600">✅ Available</p>
                        <button 
                            onclick="openModal({{ $locker->id }}, '{{ $locker->name }}', false, '', '{{ Auth::id() }}')"
                            class="mt-2 px-3 py-1 text-sm bg-blue-600 text-white rounded hover:bg-blue-700">
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

                <!-- Modal content containers -->
                <div id="reservationFormContainer">
                    <form id="reserveForm" method="POST">
                        @csrf
                        <label for="duration" class="block mb-2 text-sm font-medium">Reserve for (hours)</label>
                        <input type="number" name="duration" id="duration" min="1" max="24" class="w-full border border-gray-300 p-2 rounded mb-4" required>
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Confirm Reservation</button>
                    </form>
                </div>

                <div id="lockerInfoContainer" class="hidden">
                    <p class="mb-2"><strong>Reservation Ends:</strong> <span id="lockerReservedUntil"></span></p>
                    <p class="mb-2"><strong>Current Payment:</strong> ₱<span id="lockerPayment"></span></p>
                    <div class="flex gap-2 mt-4">
                    <form id="extendForm" method="POST">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="extend_hours" value="1">
                            <button type="submit" class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600">Extend +1 Hour</button>
                        </form>

                        <form id="cancelForm" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700">End Now</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
function openModal(lockerId, name, isReserved, reservedAt, reservedUntil, userId) {
    document.getElementById('lockerModal').classList.remove('hidden');
    document.getElementById('modalLockerName').textContent = name;
    document.getElementById('modalLockerStatus').textContent = isReserved
        ? `This locker is currently reserved until: ${reservedUntil}`
        : `This locker is available for reservation.`;

    const form = document.getElementById('reserveForm');
    const extendForm = document.getElementById('extendForm');
    const cancelForm = document.getElementById('cancelForm');

    form.action = `/lockers/${lockerId}/reserve`;
    extendForm.action = `/lockers/${lockerId}/extend`;
    cancelForm.action = `/lockers/${lockerId}/cancel`;

    const reservationContainer = document.getElementById('reservationFormContainer');
    const infoContainer = document.getElementById('lockerInfoContainer');

    // 🧠 Only show reservation details if the locker is reserved by the current user
    if (isReserved && parseInt(userId) === {{ Auth::id() }}) {
        reservationContainer.classList.add('hidden');
        infoContainer.classList.remove('hidden');

        document.getElementById('lockerReservedUntil').textContent = reservedUntil;

        // ✅ Calculate hours from reservedAt to reservedUntil
        const from = new Date(reservedAt);
        const to = new Date(reservedUntil);

        if (!isNaN(from.getTime()) && !isNaN(to.getTime())) {
            const hoursReserved = Math.ceil((to - from) / (1000 * 60 * 60));
            const price = hoursReserved > 0 ? hoursReserved * 10 : 10;
            document.getElementById('lockerPayment').textContent = price;
        } else {
            document.getElementById('lockerPayment').textContent = '0';
        }

    } else {
        reservationContainer.classList.remove('hidden');
        infoContainer.classList.add('hidden');
    }
}

function closeModal() {
    document.getElementById('lockerModal').classList.add('hidden');
}
</script>

</x-app-layout>
