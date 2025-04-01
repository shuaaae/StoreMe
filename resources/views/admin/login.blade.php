<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#0b2942] flex items-center justify-center h-screen">
    <div class="flex flex-col items-center">
    <img src="{{ asset('images/storeme-logo.png') }}" alt="StoreMe Logo" class="mx-auto mb-8 h-32">

        <div class="bg-[#1b4b66] p-8 rounded-xl shadow-lg w-96">
            <h2 class="text-white text-2xl font-semibold text-center mb-6">Admin Panel</h2>

            <form method="POST" action="{{ route('admin.login.submit') }}">
                @csrf
                <label class="text-white text-sm mb-1 block">Email</label>
                <input type="email" name="email" required class="w-full px-4 py-2 mb-4 rounded bg-blue-100 focus:outline-none focus:ring focus:border-blue-300">

                <label class="text-white text-sm mb-1 block">Password</label>
                <input type="password" name="password" required class="w-full px-4 py-2 mb-4 rounded bg-blue-100 focus:outline-none focus:ring focus:border-blue-300">

                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 rounded transition duration-200">
                    Login
                </button>
            </form>
        </div>
    </div>
</body>
</html>
