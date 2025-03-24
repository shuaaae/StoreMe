<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Student ID -->
        <div>
    <x-input-label for="student_id" :value="__('Student ID')" class="text-white" />
    <input id="student_id" 
           class="block mt-1 w-full rounded-md bg-blue-300 text-white border-none placeholder-white focus:ring-2 focus:ring-blue-300"
           type="text" 
           name="student_id" 
           value="{{ old('student_id') }}" 
           required 
           autofocus 
           placeholder="e.g., 2021-12345" />

    {{-- Standard error message --}}
    <x-input-error :messages="$errors->get('student_id')" class="mt-2" />

    {{-- Custom user-friendly message for duplicate entry --}}
    @error('student_id')
        @if (Str::contains($message, 'already been taken'))
            <p class="text-sm text-red-500 mt-1">This Student ID is already registered. Please use a different one.</p>
        @endif
    @enderror
</div>


        <!-- Name -->
        <div class="mt-4">
            <x-input-label for="name" :value="__('Name')" class="text-white" />
            <input id="name" class="block mt-1 w-full rounded-md bg-blue-300 text-white border-none placeholder-white focus:ring-2 focus:ring-blue-300"
                   type="text" name="name" value="{{ old('name') }}" required placeholder="Name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Course, Year & Block -->
        <div class="mt-4">
            <x-input-label for="course_year_block" :value="__('Course, Year & Block')" class="text-white" />
            <input id="course_year_block" class="block mt-1 w-full rounded-md bg-blue-300 text-white border-none placeholder-white focus:ring-2 focus:ring-blue-300"
                   type="text" name="course_year_block" value="{{ old('course_year_block') }}" required placeholder="e.g., BSIT 3-1" />
            <x-input-error :messages="$errors->get('course_year_block')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" class="text-white" />
            <input id="email" class="block mt-1 w-full rounded-md bg-blue-300 text-white border-none placeholder-white focus:ring-2 focus:ring-blue-300"
                   type="email" name="email" value="{{ old('email') }}" required autocomplete="username" placeholder="Email" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" class="text-white" />
            <input id="password" class="block mt-1 w-full rounded-md bg-blue-300 text-white border-none placeholder-white focus:ring-2 focus:ring-blue-300"
                   type="password" name="password" required autocomplete="new-password" placeholder="Password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="text-white" />
            <input id="password_confirmation" class="block mt-1 w-full rounded-md bg-blue-300 text-white border-none placeholder-white focus:ring-2 focus:ring-blue-300"
                   type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Confirm Password" />
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
