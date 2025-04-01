<x-app-layout>
    <div class="py-12">
    <div class="max-w-7xl mx-auto px-4 grid grid-cols-6 gap-4 auto-rows-max">

            @php
                $userLocker = $lockers->firstWhere('user_id', Auth::id());
                $otherLockers = $lockers->filter(fn($locker) => $locker->user_id !== Auth::id());
            @endphp

            {{-- User's Reserved Locker First --}}
           @if (!is_null($userLocker) && isset($userLocker->id))

    @php
        $reservedUntil = \Carbon\Carbon::parse($userLocker->reserved_until);
        $now = \Carbon\Carbon::now();
        $gracePeriodMinutes = 15;
        $diffInMinutes = $now->diffInMinutes($reservedUntil, false); // negative if passed
        $isGracePeriod = $diffInMinutes <= 0 && $diffInMinutes >= -$gracePeriodMinutes;
        $isExpired = $diffInMinutes < -$gracePeriodMinutes;
    @endphp

    <div class="col-span-6 grid grid-cols-2 gap-4">
        <!-- Reserved Locker Display -->
        <div class="p-6 rounded-lg shadow-lg text-left border-4 transform transition hover:shadow-2xl relative flex justify-between items-start"
             style="background-color: {{ $userLocker->background_color ?? '#f0f4ff' }}; min-height: 100%;" id="reservedLockerCard">

            <div>
                <!-- Locker Header with Name, Edit & Color -->
                <div class="flex items-center gap-2 relative">
    <h2 class="text-lg font-bold text-gray-800" id="lockerNameDisplay">
        Locker {{ $userLocker->id }} - {{ $userLocker->name }}
    </h2>
    <button onclick="toggleLockerNameEdit()" class="text-blue-600 hover:text-blue-800 text-sm">✏️</button>
    
    <!-- 🎨 ICON with dropdown -->
    <div class="relative">
        <button onclick="toggleColorDropdown()" class="text-xl hover:scale-110 transition">🎨</button>
        
        <!-- Dropdown floating near the icon -->
        <div id="colorDropdown" class="hidden absolute top-6 right-0 z-10 bg-white border border-gray-300 rounded shadow-md">
            <form method="POST" action="{{ route('lockers.color', $userLocker->id) }}">
                @csrf
                @method('PATCH')
                <select name="background_color" onchange="this.form.submit()"
                        class="text-sm px-2 py-1 w-36 rounded focus:outline-none">
                    <option value="#f0f4ff" {{ $userLocker->background_color == '#f0f4ff' ? 'selected' : '' }}>Sky Blue</option>
                    <option value="#ffe4ec" {{ $userLocker->background_color == '#ffe4ec' ? 'selected' : '' }}>Blush Pink</option>
                    <option value="#e0ffe4" {{ $userLocker->background_color == '#e0ffe4' ? 'selected' : '' }}>Mint Green</option>
                    <option value="#fff4d1" {{ $userLocker->background_color == '#fff4d1' ? 'selected' : '' }}>Sunny Yellow</option>
                </select>
            </form>
        </div>
    </div>
</div>




                <!-- Locker Image -->
                <img src="{{ asset('images/locker-reserved.png') }}" alt="Locker Icon"
                     class="w-24 h-24 object-contain mb-4">

                <!-- Reservation Info -->
                <p class="mb-2 text-sm"><strong>Reservation Ends:</strong> <span id="lockerReservedUntil">{{ $userLocker->reserved_until }}</span></p>
                <p class="mb-2 text-sm">
                    <strong>Time Left:</strong>
                    <span id="lockerCountdown" class="{{ $isGracePeriod ? 'text-orange-500' : ($isExpired ? 'text-red-600' : 'text-green-600') }} font-semibold">
                        {{ $isExpired ? 'Expired' : 'Calculating...' }}
                    </span>
                </p>
                <p class="mb-4 text-sm"><strong>Current Payment:</strong> ₱<span id="lockerPayment">Loading...</span></p>

                @if ($isGracePeriod)
                    <div class="bg-yellow-100 text-yellow-800 text-xs p-2 rounded mb-3 border border-yellow-300">
                        ⚠️ Your reservation has ended. You have <strong>15 minutes</strong> to extend before it's auto-released.
                    </div>
                @endif

                <!-- Extend and Cancel -->
                <div class="flex flex-col sm:flex-row sm:items-center gap-2 justify-start">
                    <form id="extendForm" method="POST" action="{{ route('lockers.extend', $userLocker->id) }}"
                          class="flex flex-col sm:flex-row gap-2 w-full sm:w-auto">
                        @csrf
                        @method('PATCH')
                        <input type="number" name="extend_hours" min="1" max="24"
                               placeholder="Extend (hours)"
                               class="border border-gray-300 p-2 rounded w-full sm:w-40" required
                               {{ $isExpired ? 'disabled' : '' }}>
                        <button type="submit" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600 w-full sm:w-auto"
                                {{ $isExpired ? 'disabled' : '' }}>
                            Extend
                        </button>
                    </form>

                    <form id="cancelForm" method="POST" action="{{ route('lockers.cancel', $userLocker->id) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 min-w-[100px] h-[42px]">
    End Now
</button>
                    </form>
                </div>
            </div>

            <!-- Note Section -->
            <div class="ml-6 w-1/2">
                <form method="POST" action="{{ route('lockers.note', $userLocker->id) }}">
                    @csrf
                    @method('PATCH')
                    <label for="locker_note" class="block text-sm font-semibold mb-2">Note (What’s inside your locker):</label>
                    <textarea name="note" id="locker_note" rows="6"
                              class="w-full border border-gray-300 rounded px-3 py-2 text-sm resize-none"
                              placeholder="Ex: Books, PE uniform, charger...">{{ $userLocker->note }}</textarea>
                    <button type="submit"
                            class="mt-2 bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 text-sm float-right">
                        Save Note
                    </button>
                </form>
            </div>
        </div>

        <!-- Reservation History -->
        <div class="bg-white p-4 rounded-lg shadow">
            <h4 class="font-semibold text-sm mb-2 text-gray-700">🔁 Reservation History</h4>
            <div class="overflow-x-auto">
                <table class="text-xs w-full">
                <thead>
                    <tr class="text-gray-600 text-left">
                        <th class="py-1 pr-3">Date</th>
                        <th class="py-1 pr-3">Duration</th>
                        <th class="py-1 pr-3">Payment</th>
                        <th class="py-1">Status</th>
                    </tr>
                </thead>
                    <tbody>
                    @forelse ($userReservations as $res)
                    @php
    $start = \Carbon\Carbon::parse($res->reserved_at);
    $end = \Carbon\Carbon::parse($res->reserved_until);
    $hours = ceil(abs($end->floatDiffInHours($start))); // 👈 abs() added here
    $payment = $hours * 10;
@endphp
<tr class="text-gray-700">
    <td class="py-1 pr-3">{{ $start->format('M d, Y h:i A') }}</td>
    <td class="py-1 pr-3">{{ $hours }} hr{{ $hours > 1 ? 's' : '' }}</td>
    <td class="py-1 pr-3">₱{{ $payment }}</td>
    <td class="py-1">
        <span class="{{ $res->payment_status === 'Paid' ? 'text-green-600 font-semibold' : 'text-red-500 font-medium' }}">
            {{ $res->payment_status ?? 'Unpaid' }}
        </span>
    </td>
</tr>

@empty
    <tr>
        <td colspan="4" class="text-gray-400 py-2 italic">No recent reservations.</td>
    </tr>
@endforelse

                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endif



                {{-- Other Lockers --}}
                @foreach ($otherLockers as $locker)
                    <div class="bg-white p-4 rounded-lg shadow-lg text-center transition duration-200 hover:scale-105 transform">
                        <img src="{{ $locker->is_reserved ? asset('images/locker-reserved.png') : asset('images/locker-available.png') }}"
                            alt="Locker Icon"
                            class="w-20 h-20 object-contain mx-auto mb-2 cursor-pointer transition-transform duration-200 hover:scale-110"
                            onclick="openModal({{ $locker->id }}, '{{ $locker->user_id === Auth::id() ? $locker->name : '' }}', {{ $locker->is_reserved ? 'true' : 'false' }}, '{{ $locker->reserved_until }}', '{{ $locker->user_id }}', '{{ optional($reservations[$locker->id] ?? null)->reserved_at }}')"
                            <h3 class="mt-2 font-bold text-gray-800">
    @if ($locker->user_id === Auth::id())
        {{ $locker->name }}
    @else
        Locker {{ $locker->id }}
    @endif
</h3>

                        @if ($locker->is_reserved)
                            <p class="text-sm text-red-500">⛔ Reserved</p>
                        @else
                            @if (!$userLocker)
                                <p class="text-sm text-green-600">✅ Available</p>
                                <button onclick="openModal({{ $locker->id }}, '{{ $locker->name }}', false, '', '{{ Auth::id() }}')"
                                        class="mt-2 px-3 py-1 text-sm bg-blue-600 text-white rounded hover:bg-blue-700">
                                    Reserve
                                </button>
                            @else
                                <p class="text-sm text-yellow-600 font-medium">You already reserved another locker</p>
                            @endif
                        @endif
                    </div>
                @endforeach
            </div>
        </div>

        <script>
    function openModal(lockerId, name, isReserved, reservedUntil, userId, reservedAt = null, note = '') {
        const modal = document.getElementById('lockerModal');
        const modalBox = document.getElementById('lockerModalBox');
        const reservedUntilElem = document.getElementById('lockerReservedUntil');
        const reservedUntilDisplay = document.getElementById('modalLockerStatus');

        const form = document.getElementById('reserveForm');
        const extendForm = document.getElementById('extendForm');
        const cancelForm = document.getElementById('cancelForm');
        const noteForm = document.getElementById('noteForm');
        const noteField = document.getElementById('locker_note');

        const isOwner = parseInt(userId) === {{ Auth::id() }};

        // Show name only if owner
        document.getElementById('modalLockerName').textContent = isOwner ? name : `Locker ${lockerId}`;

        form.action = `/lockers/${lockerId}/reserve`;
        extendForm.action = `/lockers/${lockerId}/extend`;
        cancelForm.action = `/lockers/${lockerId}/cancel`;
        noteForm.action = `/lockers/${lockerId}/note`;

        modal.classList.remove('hidden');

        const reservedUntilDate = new Date(reservedUntil);
        const now = new Date();
        const diff = reservedUntilDate - now;

        if (isReserved && isOwner) {
            // Owner's reserved locker view
            document.getElementById('reservationFormContainer').classList.add('hidden');
            document.getElementById('lockerInfoContainer').classList.remove('hidden');
            modalBox.classList.replace('max-w-xl', 'max-w-4xl');

            reservedUntilElem.textContent = reservedUntil;
            reservedUntilDisplay.textContent = `This locker is currently reserved until: ${reservedUntil}`;
            noteField.value = note || '';

            if (reservedAt) {
                const reservedAtDate = new Date(reservedAt);
                const totalHours = Math.ceil((reservedUntilDate - reservedAtDate) / (1000 * 60 * 60));
                document.getElementById('lockerPayment').textContent = totalHours * 10;
            } else {
                document.getElementById('lockerPayment').textContent = "Unknown";
            }

        } else if (isReserved && !isOwner) {
            // Non-owner viewing a reserved locker
            document.getElementById('reservationFormContainer').classList.add('hidden');
            document.getElementById('lockerInfoContainer').classList.add('hidden');
            modalBox.classList.replace('max-w-4xl', 'max-w-xl');

            if (diff > 0) {
                let h = Math.floor(diff / (1000 * 60 * 60));
                let m = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
                let s = Math.floor((diff % (1000 * 60)) / 1000);
                reservedUntilDisplay.textContent = `This locker is reserved. Available in: ${h}h ${m}m ${s}s`;
            } else {
                reservedUntilDisplay.textContent = "This locker is now available for reservation.";
                document.getElementById('reservationFormContainer').classList.remove('hidden');
            }

        } else {
            // Available locker
            document.getElementById('reservationFormContainer').classList.remove('hidden');
            document.getElementById('lockerInfoContainer').classList.add('hidden');
            modalBox.classList.replace('max-w-4xl', 'max-w-xl');
            reservedUntilDisplay.textContent = "This locker is available for reservation.";
        }
    }

    function closeModal() {
        document.getElementById('lockerModal').classList.add('hidden');
    }

    const reservedAt = '{{ $reservedAtValue }}';
    const reservedUntil = new Date(document.getElementById('lockerReservedUntil')?.textContent);

    if (reservedAt && reservedUntil && document.getElementById('lockerPayment')) {
        const reservedAtDate = new Date(reservedAt);
        const totalHours = Math.ceil((reservedUntil - reservedAtDate) / (1000 * 60 * 60));
        document.getElementById('lockerPayment').textContent = totalHours * 10;
    }

    const countdownSpan = document.getElementById('lockerCountdown');
    if (countdownSpan && reservedUntil) {
        const updateCountdown = () => {
            const now = new Date();
            const diff = reservedUntil - now;

            if (diff <= 0) {
                countdownSpan.textContent = "Expired";
                countdownSpan.className = "text-red-600 font-bold";
                return;
            }

            const hours = Math.floor(diff / (1000 * 60 * 60));
            const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((diff % (1000 * 60)) / 1000);

            countdownSpan.textContent = `${hours}h ${minutes}m ${seconds}s`;

            if (hours >= 1) {
                countdownSpan.className = "text-green-600 font-medium";
            } else if (minutes >= 30) {
                countdownSpan.className = "text-yellow-500 font-medium";
            } else {
                countdownSpan.className = "text-red-600 font-semibold";
            }
        };

        updateCountdown();
        setInterval(updateCountdown, 1000);
    }

    function toggleLockerNameEdit() {
        document.getElementById('lockerNameDisplay').classList.add('hidden');
        document.getElementById('lockerNameForm').classList.remove('hidden');
    }

    function cancelLockerNameEdit() {
        document.getElementById('lockerNameForm').classList.add('hidden');
        document.getElementById('lockerNameDisplay').classList.remove('hidden');
    }

    function previewBackgroundColor(select) {
        const previewColor = select.value;
        const lockerCard = document.getElementById('reservedLockerCard');
        lockerCard.style.backgroundColor = previewColor;
    }

    function toggleColorDropdown() {
        const dropdown = document.getElementById('colorDropdown');
        dropdown.classList.toggle('hidden');
    }
</script>



    <!-- Modal for Reservation/Locker Details -->
<!-- Modal for Reservation/Locker Details -->
<div id="lockerModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50">
    <div class="flex items-center justify-center min-h-screen">
    <div id="lockerModalBox" class="bg-white p-6 rounded-lg shadow-lg w-full max-w-4xl relative transition-all duration-300">

            <button onclick="closeModal()" class="absolute top-2 right-2 text-gray-600 hover:text-black text-xl font-bold">&times;</button>
            <h2 id="modalLockerName" class="text-lg font-bold mb-4"></h2>
            <p id="modalLockerStatus" class="mb-4 text-sm text-gray-700"></p>

            <div id="modalContent" class="space-y-4">
    <!-- Reservation Section -->
    <div id="reservationFormContainer" class="space-y-4">
        <form id="reserveForm" method="POST">
            @csrf
            <label for="duration" class="block mb-1 text-sm font-medium">Reserve for (hours)</label>
            <input type="number" name="duration" id="duration" min="1" max="24"
                   class="w-full border border-gray-300 p-2 rounded mb-2" required>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Confirm Reservation
            </button>
        </form>
    </div>

    <!-- Info and Actions: Only shows when locker is reserved -->
    <div id="lockerInfoContainer" class="hidden space-y-3 text-sm">
        <p><strong>Reservation Ends:</strong> <span id="lockerReservedUntil"></span></p>
        <p><strong>Current Payment:</strong> ₱<span id="lockerPayment"></span></p>

        <div class="flex flex-col gap-2 sm:flex-row">
            <form id="extendForm" method="POST" class="flex items-center gap-2 w-full">
                @csrf
                @method('PATCH')
                <input type="number" name="extend_hours" min="1" max="24"
                       placeholder="Extend (hours)"
                       class="border border-gray-300 p-2 rounded w-full text-sm" required>
                <button type="submit" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">
                    Extend
                </button>
            </form>

            <form id="cancelForm" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 w-full">
                    End Now
                </button>
            </form>
        </div>

        <!-- Note Field -->
        <form id="noteForm" method="POST">
            @csrf
            @method('PATCH')
            <label for="locker_note" class="block font-semibold text-sm mt-4 mb-1">Note (What’s inside your locker):</label>
            <textarea name="note" id="locker_note" rows="4"
                class="w-full p-2 rounded border border-gray-300 resize-none"
                placeholder="Ex: Books, PE uniform, charger..."></textarea>
            <button type="submit"
                    class="mt-2 bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 w-full text-sm">
                Save Note
            </button>
        </form>
    </div>
</div>


            </div>
        </div>
    </div>
</div>


</x-app-layout>
