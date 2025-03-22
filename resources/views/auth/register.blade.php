<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" class="text-white" />
            <input id="name" class="block mt-1 w-full rounded-md bg-blue-300 text-white border-none placeholder-white focus:ring-2 focus:ring-blue-300"
                   type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" placeholder="Name"/>
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" class="text-white" />
            <input id="email" class="block mt-1 w-full rounded-md bg-blue-300 text-white border-none placeholder-white focus:ring-2 focus:ring-blue-300"
                   type="email" name="email" value="{{ old('email') }}" required autocomplete="username" placeholder="Email"/>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" class="text-white" />
            <input id="password" class="block mt-1 w-full rounded-md bg-blue-300 text-white border-none placeholder-white focus:ring-2 focus:ring-blue-300"
                   type="password" name="password" required autocomplete="new-password" placeholder="Password"/>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="text-white" />
            <input id="password_confirmation" class="block mt-1 w-full rounded-md bg-blue-300 text-white border-none placeholder-white focus:ring-2 focus:ring-blue-300"
                   type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Confirm Password"/>
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-6">
            <a class="underline text-sm text-white hover:text-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4 bg-blue-600 hover:bg-blue-700">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
