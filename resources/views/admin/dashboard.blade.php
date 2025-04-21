<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite('resources/css/app.css') {{-- If you're using Vite --}}
</head>
<body class="bg-[#0f172a] text-white min-h-screen font-sans">

    <!-- Header -->
    <header class="bg-[#1e293b] p-6 shadow-md flex justify-between items-center">
    <div class="flex items-center space-x-6">
        <h2 class="text-xl font-semibold text-white">Admin Panel</h2>

        {{-- Navigation links for admin --}}
        <a href="{{ route('admin.reservations') }}" class="text-white hover:underline text-sm">Reservation History</a>
    </div>

    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Admin dropdown using Alpine.js -->
    <div x-data="{ open: false }" class="relative">
        <button @click="open = !open" class="flex items-center space-x-1 focus:outline-none">
            <span class="text-white font-medium cursor-pointer">Admin</span>
            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
            </svg>
        </button>

        <!-- Logout Dropdown -->
        <div x-show="open" @click.away="open = false" x-transition
             class="absolute right-0 mt-2 w-44 bg-white text-[#0f172a] rounded-lg shadow-lg z-10"
             style="display: none;">
            <a href="{{ route('admin.logout') }}" 
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
               class="flex items-center px-4 py-2 hover:bg-gray-200 rounded space-x-2">
                <svg class="w-5 h-5 text-[#0f172a]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 12h4" />
                </svg>
                <span>Logout</span>
            </a>
            <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" class="hidden">
                @csrf
            </form>
        </div>
    </div>
</header>


    <!-- Main Content -->
    <main class="py-10 px-4">
        <div class="max-w-7xl mx-auto flex space-x-6">

            {{-- Locker List (Left Sidebar) --}}
            <div class="w-1/5 space-y-2">
            @foreach ($lockers as $locker)
    <div 
        class="locker-item text-[#0b2942] font-semibold py-2 px-4 rounded shadow text-center cursor-pointer hover:bg-blue-400 transition-colors duration-200
            {{ $locker->user_id ? 'bg-red-500 text-white border-2 border-red-700' : 'bg-blue-300' }}"
        data-locker-id="{{ $locker->id }}"
    >
        {{ $locker->user_id ? '🔒 Locker ' . $locker->number : 'Locker ' . $locker->number }}
    </div>
@endforeach

            </div>

            {{-- Overview Content --}}
            <div class="w-4/5 bg-[#1b2a41] p-6 rounded-xl shadow-lg space-y-8">
                <h1 class="text-2xl font-bold">Welcome, Admin!</h1>
                <p class="text-sm text-gray-300">Here's a quick overview of what's happening in StoreMe.</p>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

<!-- Total Users -->
<div class="bg-[#23395d] p-4 rounded text-center shadow">
    <!-- 👤 User Icon -->
    <svg class="mx-auto h-6 w-6 text-white mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M17 20h5v-2a4 4 0 00-3-3.87M9 20h6M9 20v-2a4 4 0 013-3.87M9 20H4v-2a4 4 0 013-3.87M12 14a4 4 0 100-8 4 4 0 000 8z"/>
    </svg>
    <h4 class="font-semibold">Total Users</h4>
    <p class="text-3xl mt-2">{{ \App\Models\User::count() }}</p>
</div>

<!-- Lockers Reserved -->
<div class="bg-[#23395d] p-4 rounded text-center shadow">
    <!-- 📦 Box Icon -->
    <svg class="mx-auto h-6 w-6 text-white mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M20 12V8a2 2 0 00-1-1.73l-7-4a2 2 0 00-2 0l-7 4A2 2 0 002 8v4m18 0v4a2 2 0 01-1 1.73l-7 4a2 2 0 01-2 0l-7-4A2 2 0 014 16v-4m16 0L12 8m0 0L4 12"/>
    </svg>
    <h4 class="font-semibold">Lockers Reserved</h4>
    <p class="text-3xl mt-2">{{ \App\Models\Locker::whereNotNull('user_id')->count() }}</p>
</div>

<!-- Feedback Received -->
<div class="bg-[#23395d] p-4 rounded text-center shadow">
    <!-- 💬 Chat Icon -->
    <svg class="mx-auto h-6 w-6 text-white mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M8 10h.01M12 10h.01M16 10h.01M21 12c0 4.418-4.03 8-9 8a9.77 9.77 0 01-4.39-1.026L3 20l1.568-4.108A7.963 7.963 0 013 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
    </svg>
    <h4 class="font-semibold">Feedback Received</h4>
    <p class="text-3xl mt-2">{{ \App\Models\Feedback::count() }}</p>
</div>

</div>

            </div>

        </div>
    </main>


    <!-- Locker Details Modal -->
    <div id="lockerModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-[#1b2a41] rounded-lg shadow-lg p-6 w-full max-w-md mx-4">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-bold text-white" id="modalTitle">Locker Details</h3>
                <button id="closeModal" class="text-white hover:text-gray-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            
            <div id="lockerDetails" class="text-white">
                <div class="text-center p-4 bg-[#23395d] rounded-lg mb-4">
                    <h4 id="lockerName" class="text-xl mb-2">Locker</h4>
                    <div id="reservationStatus" class="mb-2">Loading...</div>
                    <div id="timeRemaining" class="text-3xl font-bold mb-2 hidden">00:00:00</div>
                    <div id="price" class="text-xl hidden">₱0.00</div>
                </div>
                <div id="lockerNoteBox" class="mt-4">
  <h4 class="font-semibold text-sm mb-1">📦 Locker Note</h4>
  <p id="lockerNote" class="text-sm text-gray-200 bg-[#23395d] p-3 rounded">No note provided.</p>
</div>

               <!-- Approve Button (triggers form visibility) -->
<div id="approveTriggerBox" class="mt-4">
    <button id="showApproveForm" class="w-full bg-green-600 hover:bg-green-700 text-white py-2 px-4 rounded">
        Approve Reservation
    </button>
</div>

<!-- Hidden Approve Form -->
<div id="approveFormBox" class="hidden mt-4">
    <form action="{{ route('admin.lockers.approve', ['locker' => 0]) }}" method="POST" id="approveForm">
        @csrf
        <label for="hours" class="block text-sm font-medium mb-1">Set Reservation Duration (in hours)</label>
        <input type="number" name="hours" min="1" max="24" required class="w-full rounded p-2 text-black mb-3">

        <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white py-2 px-4 rounded">
            Confirm Approval
        </button>
    </form>
</div>
                <div id="controlButtons" class="space-y-2 hidden">
                </div>
                <div class="mt-4">
                    <button id="forceEndButton" class="w-full bg-red-700 hover:bg-red-800 text-white py-2 px-4 rounded transition-colors duration-200 hidden">
                    End Reservation
                    </button>
                </div>

                <!-- Mark as Paid Button -->
<div id="paymentBox" class="mt-4 hidden">
<form method="POST" id="markAsPaidForm" action="">
    @csrf
    @method('PATCH')
    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded">
        Mark as Paid
    </button>
</form>
</div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
document.addEventListener('DOMContentLoaded', function() {
    const lockerItems = document.querySelectorAll('.locker-item');
    const modal = document.getElementById('lockerModal');
    const closeModal = document.getElementById('closeModal');
    const modalTitle = document.getElementById('modalTitle');
    const lockerName = document.getElementById('lockerName');
    const reservationStatus = document.getElementById('reservationStatus');
    const timeRemaining = document.getElementById('timeRemaining');
    const price = document.getElementById('price');
    const controlButtons = document.getElementById('controlButtons');
    const forceEndButton = document.getElementById('forceEndButton');

    // Timer globals
    let timerInterval;
    let seconds = 0;
    let isRunning = false;

    // Clock functions
    function updateTimerDisplay() {
    if (seconds <= 0) {
        seconds = 0;
        timeRemaining.textContent = "Expired";
        timeRemaining.classList.add('text-red-500', 'font-semibold');
        return;
    }

    const hours = Math.floor(seconds / 3600);
    const minutes = Math.floor((seconds % 3600) / 60);
    const secs = Math.floor(seconds % 60);

    timeRemaining.textContent = 
        `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}:${secs.toString().padStart(2, '0')}`;
}


function startTimer() {
    clearInterval(timerInterval);
    timerInterval = setInterval(() => {
        if (seconds <= 0) {
            seconds = 0;
            updateTimerDisplay(); // this will show "Expired"
            clearInterval(timerInterval);
            return;
        }

        seconds--;
        updateTimerDisplay();
    }, 1000);
}


    // Modal interaction
    lockerItems.forEach(item => {
        item.addEventListener('click', function() {
            const lockerId = this.getAttribute('data-locker-id');
            openLockerModal(lockerId);
        });
    });

    closeModal.addEventListener('click', () => {
        modal.classList.add('hidden');
        clearInterval(timerInterval);
    });

    window.addEventListener('click', event => {
        if (event.target === modal) {
            modal.classList.add('hidden');
            clearInterval(timerInterval);
        }
    });

    // Fetch and open modal
    function openLockerModal(lockerId) {
        modal.setAttribute('data-current-locker', lockerId);
        // Reset approve form visibility
document.getElementById('approveFormBox').classList.add('hidden');
document.getElementById('approveTriggerBox').classList.remove('hidden');
document.getElementById('showApproveForm').addEventListener('click', function () {
    document.getElementById('approveTriggerBox').classList.add('hidden');
    document.getElementById('approveFormBox').classList.remove('hidden');
});


// Update form action with correct locker ID
const approveForm = document.getElementById('approveForm');
approveForm.action = `/admin/lockers/${lockerId}/approve`;

   // Set Mark As Paid Form Action (✅ this sets form action based on lockerId)
   const markAsPaidForm = document.getElementById('markAsPaidForm');
    if (markAsPaidForm) {
        markAsPaidForm.action = `/admin/lockers/${lockerId}/pay`;
    }
        // Reset UI
        timeRemaining.classList.add('hidden');
        price.classList.add('hidden');
        controlButtons.classList.add('hidden');
        forceEndButton.classList.add('hidden');
        reservationStatus.textContent = 'Loading...';
        clearInterval(timerInterval);

        fetch(`/admin/lockers/${lockerId}`)
            .then(response => response.json())
            .then(data => {
                modalTitle.textContent = `Locker ${data.number} Details`;
                lockerName.textContent = data.user ? `${data.user.name}'s Locker` : `Locker ${data.number}`;
                 // ⬇️ Add the note display line RIGHT HERE:
     // ✅ Add this line right after lockerName
     const lockerNoteBox = document.getElementById('lockerNote');
    if (lockerNoteBox) {
        lockerNoteBox.textContent = data.note && data.note.trim() !== '' ? data.note : 'No note provided.';
    }



                const approveTriggerBox = document.getElementById('approveTriggerBox');
const approveForm = document.getElementById('approveForm');

// ✅ If payment status is not paid and reservation is active
const paymentBox = document.getElementById('paymentBox');
            if (data.status === 'active' && data.payment_status !== 'Paid') {
                paymentBox.classList.remove('hidden'); // show "Mark as Paid" button
            } else {
                paymentBox.classList.add('hidden'); // hide if already paid or not active
            }

// Update approve form action
if (approveForm) {
    approveForm.action = `/admin/lockers/${lockerId}/approve`;
}

// ✅ FIXED CONDITION
if (data.status === 'pending') {
    approveTriggerBox.classList.remove('hidden');
    console.log('✅ Approve button is shown — status is:', data.status);
} else {
    approveTriggerBox.classList.add('hidden');
    console.log('❌ Approve button hidden — status is:', data.status);
}

// ✅ 
if (data.status === 'active') {
    forceEndButton.classList.remove('hidden'); // 🔓 Make button visible
    forceEndButton.disabled = false; // ✅ Ensure it's clickable
} else {
    forceEndButton.classList.add('hidden'); // 🙈 Hide if not active
}

                if (data.user) {
                    reservationStatus.textContent = `Reserved by ${data.user.name}`;
                    reservationStatus.classList.add('text-green-400');
                    reservationStatus.classList.remove('text-gray-400');

                    timeRemaining.classList.remove('hidden');
                    price.classList.remove('hidden');
                    controlButtons.classList.remove('hidden');
                    forceEndButton.classList.remove('hidden');

                    price.textContent = `₱${data.price.toFixed(2)}`;
seconds = Math.floor(data.time_remaining || 0);

// Only show countdown if ACTIVE
if (data.status === 'active') {
    if (seconds > 0) {
        updateTimerDisplay();
        startTimer();
    } else {
        timeRemaining.textContent = "Expired";
        timeRemaining.classList.add('text-red-500', 'font-semibold');
    }
} else if (data.status === 'pending') {
    timeRemaining.textContent = "⏳ Awaiting Approval";
    timeRemaining.classList.add('text-yellow-500', 'font-semibold');
}
                } else {
                    reservationStatus.textContent = 'Available';
                    reservationStatus.classList.remove('text-green-400');
                    reservationStatus.classList.add('text-gray-400');
                }

                modal.classList.remove('hidden');
            })
            .catch(error => {
                console.error('Error fetching locker details:', error);
                reservationStatus.textContent = 'Error loading locker details';
            });
    }

    forceEndButton.addEventListener('click', function() {
        if (confirm('Are you sure you want to end this reservation?')) {
            const lockerId = modal.getAttribute('data-current-locker');
            fetch(`/admin/lockers/${lockerId}/end`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    modal.classList.add('hidden');
                    location.reload();
                }
            });
        }
    });
});

// Force End Reservation
forceEndButton.addEventListener('click', function () {
    if (!confirm('Are you sure you want to force end this reservation?')) return;

    const lockerId = modal.getAttribute('data-current-locker');
    fetch(`/admin/lockers/${lockerId}/end`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Reservation ended successfully.');
            modal.classList.add('hidden');
            location.reload();
        } else {
            alert(data.message || 'Failed to end reservation.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Something went wrong.');
    });
});

</script>
<!-- ✅ Include SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- ✅ SweetAlert Confirmation Logic -->
<script>
document.getElementById('markAsPaidForm')?.addEventListener('submit', function(e) {
    e.preventDefault();
    const form = this;
    Swal.fire({
        title: 'Mark as Paid?',
        text: 'This will mark the reservation as fully paid.',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#2563eb',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, mark it!',
        background: '#1e293b',
        color: '#fff',
    }).then((result) => {
        if (result.isConfirmed) {
            form.submit();
        }
    });
});

document.getElementById('approveForm')?.addEventListener('submit', function(e) {
    e.preventDefault();
    const form = this;
    Swal.fire({
        title: 'Approve Reservation?',
        text: 'Confirm reservation duration before approving.',
        icon: 'info',
        showCancelButton: true,
        confirmButtonColor: '#22c55e',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, approve',
        background: '#1e293b',
        color: '#fff',
    }).then((result) => {
        if (result.isConfirmed) {
            form.submit();
        }
    });
});

document.getElementById('forceEndButton')?.addEventListener('click', function(e) {
    e.preventDefault();
    Swal.fire({
        title: 'End Reservation?',
        text: 'This will immediately end the current reservation.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Yes, end it',
        background: '#1e293b',
        color: '#fff',
    }).then((result) => {
        if (result.isConfirmed) {
            const lockerId = document.getElementById('lockerModal').getAttribute('data-current-locker');
            fetch(`/admin/lockers/${lockerId}/end`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        title: 'Ended!',
                        text: 'Reservation has been ended.',
                        icon: 'success',
                        background: '#1e293b',
                        color: '#fff',
                    });
                    document.getElementById('lockerModal').classList.add('hidden');
                    setTimeout(() => location.reload(), 1500);
                } else {
                    Swal.fire('Error', data.message || 'Something went wrong.', 'error');
                }
            })
            .catch(() => {
                Swal.fire('Oops!', 'Something went wrong.', 'error');
            });
        }
    });
});
</script>
</body>
</html>