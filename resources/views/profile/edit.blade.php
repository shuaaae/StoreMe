<x-app-layout>
    <x-slot name="header">
    <x-slot name="header">
    <div class="flex items-center gap-3">
        <h2 class="text-2xl font-semibold text-white">Profile Info</h2>
    </div>



    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

        {{-- ✅ Alerts Section (Success & Error) --}}
@if (session('status'))
    <div 
        x-data="{ show: true }"
        x-init="setTimeout(() => show = false, 5000)" 
        x-show="show"
        x-transition:leave="transition ease-in duration-500"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="flex items-start space-x-2 bg-green-50 border border-green-300 text-green-800 px-4 py-3 rounded-md shadow-sm mb-4"
        role="alert"
    >
        <svg class="w-5 h-5 text-green-600 mt-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
        </svg>
        <div class="text-sm">
            <span class="font-semibold">Update successful:</span> {{ session('status') }}
        </div>
    </div>
@endif

@if ($errors->any())
    <div 
        x-data="{ show: true }"
        x-init="setTimeout(() => show = false, 7000)" 
        x-show="show"
        x-transition:leave="transition ease-in duration-500"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="bg-red-50 border border-red-300 text-red-800 px-4 py-3 rounded-md shadow-sm mb-4"
        role="alert"
    >
        <div class="flex items-start space-x-2">
            <svg class="w-5 h-5 text-red-600 mt-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
            <div class="text-sm">
                <span class="font-semibold">Something went wrong:</span>
                <ul class="list-disc ml-5 mt-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endif


            <!-- ✅ Upload Profile Photo -->
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-photo-form')
                </div>
            </div>

            <!-- ✅ Update Basic Info -->
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <!-- ✅ Update Password -->
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <!-- ✅ Delete User -->
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
