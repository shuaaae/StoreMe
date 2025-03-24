<!-- resources/views/auth/login.blade.php -->

<x-guest-layout>
    <h2 class="text-center text-2xl font-bold mb-6">Welcome to StoreMe!</h2>
    @if (session('status'))
    <div class="mb-4 font-medium text-sm text-green-600">
        {{ session('status') }}
    </div>
@endif

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-sm">Enter your username</label>
            <input id="email" class="mt-1 block w-full rounded-md bg-blue-300 text-white border-none placeholder-white focus:ring-2 focus:ring-blue-300" type="email" name="email" :value="old('email')" required autofocus placeholder="Email" />
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-sm">Enter your password</label>
            <input id="password" class="mt-1 block w-full rounded-md bg-blue-300 text-white border-none placeholder-white focus:ring-2 focus:ring-blue-300" type="password" name="password" required placeholder="Password" />
        </div>

        <div class="flex flex-col gap-3 mt-6">
            <button class="w-full py-2 rounded-md bg-blue-600 hover:bg-blue-700 font-semibold">Log in</button>

            @if (Route::has('password.request'))
                <a class="block w-full text-center py-2 rounded-md bg-blue-500 hover:bg-blue-600 font-semibold" href="{{ route('password.request') }}">
                    Forgot Password
                </a>
            @endif

            <a class="block w-full text-center py-2 rounded-md bg-blue-500 hover:bg-blue-600 font-semibold" href="{{ route('register') }}">
                Sign up here
            </a>
        </div>
    </form>
</x-guest-layout>
