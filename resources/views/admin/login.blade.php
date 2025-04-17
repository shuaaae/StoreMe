<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Add this in your <head> -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>
<body class="bg-[#0b2942] flex items-center justify-center h-screen">
    <div class="flex flex-col items-center">
    <img src="{{ asset('images/storeme-logo.png') }}" alt="StoreMe Logo" class="mx-auto mb-8 h-32">

        <div class="bg-[#1b4b66] p-8 rounded-xl shadow-lg w-96">
            <h2 class="text-white text-2xl font-semibold text-center mb-6">Admin Panel</h2>
            @if ($errors->any())
    <div class="mb-4 text-red-500 text-sm text-center">
        @foreach ($errors->all() as $error)
            <p>{{ $error }}</p>
        @endforeach
    </div>
@endif

            <form method="POST" action="{{ route('admin.login.submit') }}">
                @csrf
                <label class="text-white text-sm mb-1 block">Email</label>
                <div class="relative mb-4">
    <input 
        type="email" 
        name="email" 
        placeholder="Enter Admin Email"
        required 
        class="w-full bg-blue-300 text-white placeholder-white rounded px-4 py-2 pr-10 focus:outline-none"
        >
    </div>

                <label class="text-white text-sm mb-1 block">Password</label>
                <!-- Password Field with Toggle Button -->
                <div class="relative mb-5">
    <input 
        type="password" 
        name="password" 
        id="password" 
        placeholder="Enter Admin Password" 
        class="w-full bg-blue-300 text-white placeholder-white rounded px-4 py-2 pr-10 focus:outline-none" 
        required
    >

    <button 
        type="button" 
        onclick="togglePasswordVisibility()" 
        class="absolute inset-y-0 right-3 flex items-center text-white"
    >
        <i id="toggleIcon" class="fas fa-eye"></i>
    </button>
</div>



                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 rounded transition duration-200">
                    Login
                </button>
            </form>
        </div>
    </div>
    <script>
function togglePasswordVisibility() {
    const input = document.getElementById('password');
    const icon = document.getElementById('toggleIcon');

    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}
</script>


</body>
</html>
