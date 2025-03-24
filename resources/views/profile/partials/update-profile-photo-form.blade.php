<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Profile Photo') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Update your profile picture. Accepted formats: jpg, png, max 2MB.") }}
        </p>
    </header>

    <form method="POST" action="{{ route('profile.update.photo') }}" enctype="multipart/form-data" class="mt-6 space-y-6">
        @csrf
        @method('PATCH')

        <div class="flex items-center gap-4">
            @if (Auth::user()->profile_picture)
                <img src="{{ asset('storage/' . Auth::user()->profile_picture) }}"
                     alt="Profile Photo"
                     class="w-16 h-16 rounded-full object-cover">
            @else
                <img src="{{ asset('default-avatar.png') }}"
                     alt="Default Avatar"
                     class="w-16 h-16 rounded-full object-cover">
            @endif

            <!-- 👇 Missing file input -->
            <input type="file" name="photo" accept="image/*" class="text-white">
        </div>

        @error('photo')
            <p class="text-sm text-red-500 mt-2">{{ $message }}</p>
        @enderror

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'photo-updated')
                <p x-data="{ show: true }" x-show="show" x-transition 
                   x-init="setTimeout(() => show = false, 2000)" 
                   class="text-sm text-green-500">
                    {{ __('Saved.') }}
                </p>
            @endif
        </div>
    </form>
</section>
