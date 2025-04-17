<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-[#0f172a] text-white min-h-screen font-sans">

    {{-- Top Navigation --}}
    <header class="bg-[#1e293b] p-6 shadow-md flex justify-between items-center">
        <div class="flex items-center gap-6">
            <h1 class="text-xl font-bold text-white">Admin Panel</h1>
            <a href="{{ route('admin.dashboard') }}" class="text-white hover:underline">Dashboard</a>
            <a href="{{ route('admin.reservations') }}" class="text-white hover:underline">Reservation History</a>
        </div>
    </header>

    {{-- Page Content --}}
    <main class="p-6">
        @yield('content')
    </main>

</body>
</html>
