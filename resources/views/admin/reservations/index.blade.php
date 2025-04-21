@extends('layouts.admin') {{-- Change if your layout file has a different name --}}
@section('content')

<div class="max-w-7xl mx-auto p-6 bg-[#1e293b] text-white rounded-xl">
    <h1 class="text-2xl font-bold mb-4">📜 Reservation History</h1>

    <!-- FILTER FORM -->
    <form method="GET" class="mb-6 grid grid-cols-1 md:grid-cols-4 gap-4 text-sm">
        <input type="text" name="user" placeholder="Search user..." value="{{ request('user') }}"
               class="p-2 rounded bg-[#23395d] text-white placeholder:text-gray-400">
        <select name="status" class="p-2 rounded bg-[#23395d] text-white">
            <option value="">All Status</option>
            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
            <option value="ended" {{ request('status') == 'ended' ? 'selected' : '' }}>Ended</option>
            <option value="declined" {{ request('status') == 'declined' ? 'selected' : '' }}>Declined</option>
        </select>
        <input type="date" name="from" value="{{ request('from') }}"
               class="p-2 rounded bg-[#23395d] text-white">
        <input type="date" name="to" value="{{ request('to') }}"
               class="p-2 rounded bg-[#23395d] text-white">
        <button type="submit"
                class="col-span-1 md:col-span-4 bg-blue-600 hover:bg-blue-700 text-white py-2 rounded">
            Filter
        </button>
    </form>

    <!-- Download PDF Button -->
<a href="{{ route('admin.reservations.export.pdf') }}"
   class="inline-block mb-4 px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded shadow">
    ⬇️ Download PDF
</a>

    <!-- TABLE -->
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-white">
            <thead class="bg-[#23395d]">
                <tr>
                    <th class="p-2 text-left">User</th>
                    <th class="p-2 text-left">Locker</th>
                    <th class="p-2 text-left">Date</th>
                    <th class="p-2 text-left">Duration</th>
                    <th class="p-2 text-left">Payment</th>
                    <th class="p-2 text-left">Status</th>
                    <th class="p-2 text-left">Payment Status</th>
                </tr>
            </thead>
            <tbody>
    @forelse($reservations as $res)
    @php
    $start = $res->reserved_at ? \Carbon\Carbon::parse($res->reserved_at) : null;
    $end = $res->reserved_until ? \Carbon\Carbon::parse($res->reserved_until) : null;
    $status = $res->status;

    if ($start && $end && $status !== 'pending') {
        $hours = ceil(abs($end->floatDiffInHours($start))); // always positive
        $durationDisplay = $hours . ' hr' . ($hours > 1 ? 's' : '');
        $payment = '₱' . ($hours * 10);
    } else {
        $durationDisplay = 'N/A';
        $payment = '₱N/A';
    }

    $paymentStatus = $res->payment_status ?? 'Unpaid';
    $paymentClass = $paymentStatus === 'Paid' ? 'text-green-400 font-semibold' : 'text-red-400 font-semibold';
@endphp

        <tr class="border-b border-gray-600 hover:bg-[#2e3b55] transition">
            <td class="p-2">{{ $res->user->name ?? 'N/A' }}</td>
            <td class="p-2">Locker #{{ $res->locker->number ?? 'N/A' }}</td>
            <td class="p-2">{{ $start ? $start->format('M d, Y h:i A') : 'N/A' }}</td>
            <td class="p-2">{{ $durationDisplay }}</td>
            <td class="p-2">{{ $payment }}</td>
            <td class="p-2">{{ ucfirst($status) }}</td>
            <td class="p-2">
                <span class="{{ $paymentClass }}">{{ $paymentStatus }}</span>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="7" class="text-center text-gray-400 py-4">No reservations found.</td>
        </tr>
    @endforelse
</tbody>
        </table>
    </div>

    <!-- PAGINATION -->
    <div class="mt-6">
        {{ $reservations->withQueryString()->links() }}
    </div>
</div>

@endsection
