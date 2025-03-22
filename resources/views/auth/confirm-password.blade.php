<x-guest-layout>
    <div class="mb-4 text-sm text-white">
        {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
    </div>

    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Password')" class="text-white" />

            <input id="password" class="block mt-1 w-full rounded-md bg-blue-300 text-white border-none placeholder-white focus:ring-2 focus:ring-blue-300"
                   type="password" name="password" required autocomplete="current-password" placeholder="Enter your password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex justify-end mt-6">
            <x-primary-button class="bg-blue-600 hover:bg-blue-700">
                {{ __('Confirm') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
