<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-white leading-tight tracking-wide flex items-center gap-2">
            <!-- Icon: Chat Bubble -->
            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-blue-400" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M8 10h.01M12 10h.01M16 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            {{ __('Contact Center') }}
        </h2>
    </x-slot>
  <!-- Success Message -->
    @if (session('status'))
    <div 
        x-data="{ show: true }" 
        x-init="setTimeout(() => show = false, 4000)" 
        x-show="show"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-2"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-300"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 translate-y-2"
        class="fixed top-6 left-1/2 transform -translate-x-1/2 z-50 bg-green-600 text-white px-6 py-3 rounded-lg shadow-lg flex items-center gap-2"
    >
        <!-- Success icon -->
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none"
            viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M5 13l4 4L19 7" />
        </svg>
        <span>{{ session('status') }}</span>
    </div>
@endif

    <div class="py-12 text-white bg-gradient-to-b from-[#0f172a] to-[#1e293b] min-h-screen">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-[#1b2a41] p-8 sm:p-10 rounded-2xl shadow-2xl space-y-12 border border-[#334155]">

                <!-- Ask for Help -->
                <div class="space-y-4">
                    <h3 class="text-lg font-bold text-blue-300 border-b border-gray-700 pb-2 flex items-center gap-2">
                        <!-- Icon: Question Mark Circle -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-yellow-300" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 10h.01M12 10h.01M16 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Ask for Help
                    </h3>
                    <form method="POST" action="{{ route('contact.help') }}" class="space-y-4">
                        @csrf
                        <label class="block text-white font-medium">Your concern about our service:</label>
                        <textarea name="help_message" rows="4" required
                            class="w-full p-4 rounded-lg bg-gray-100 text-black border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-400 resize-none shadow-sm"
                            placeholder="Let us know how we can assist you..."></textarea>
                        <button type="submit"
                            class="bg-blue-500 hover:bg-blue-600 transition px-6 py-3 rounded-lg text-white font-semibold shadow-md hover:shadow-lg flex items-center gap-2">
                            <!-- Icon: Paper Plane -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 19l9 2-9-18-9 18 9-2z" />
                            </svg>
                            Ask for Help
                        </button>
                    </form>
                </div>

                <!-- Feedback Form -->
                <div class="space-y-4">
                    <h3 class="text-lg font-bold text-blue-300 border-b border-gray-700 pb-2 flex items-center gap-2">
                        <!-- Icon: Pencil Alt -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-300" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 5H6a2 2 0 00-2 2v12a2 2 0 002 2h12a2 2 0 002-2v-5M18.5 2.5a2.121 2.121 0 113 3L12 15l-4 1 1-4 9.5-9.5z" />
                        </svg>
                        Give Feedback
                    </h3>
                    <form method="POST" action="{{ route('contact.feedback') }}" class="space-y-4">
                        @csrf
                        <div x-data="{ rating: 0 }" class="text-center">
                            <label class="block text-white font-medium mb-2 flex justify-center items-center gap-2">
                                <!-- Icon: Star -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-yellow-400" fill="currentColor"
                                    viewBox="0 0 24 24">
                                    <path
                                        d="M12 .587l3.668 7.431L24 9.753l-6 5.845L19.335 24 12 19.897 4.665 24 6 15.598 0 9.753l8.332-1.735z" />
                                </svg>
                                How would you rate our service?
                            </label>
                            <div class="flex justify-center space-x-2 mb-4">
                                <template x-for="star in 5" :key="star">
                                    <svg @click="rating = star; $refs.rating.value = star"
                                        :class="rating >= star ? 'text-yellow-400 scale-110' : 'text-gray-600'"
                                        class="w-10 h-10 cursor-pointer fill-current transition transform hover:scale-125"
                                        viewBox="0 0 24 24">
                                        <path
                                            d="M12 .587l3.668 7.431L24 9.753l-6 5.845L19.335 24 12 19.897 4.665 24 6 15.598 0 9.753l8.332-1.735z" />
                                    </svg>
                                </template>
                                <input type="hidden" name="rating" x-ref="rating" value="0" />
                            </div>
                        </div>

                        <label class="block text-white font-medium">Your feedback:</label>
                        <textarea name="feedback_message" rows="4" required
                            class="w-full p-4 rounded-lg bg-gray-100 text-black border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-400 resize-none shadow-sm"
                            placeholder="We’d love to hear your thoughts..."></textarea>
                        <button type="submit"
                            class="bg-blue-500 hover:bg-blue-600 transition px-6 py-3 rounded-lg text-white font-semibold shadow-md hover:shadow-lg flex items-center gap-2">
                            <!-- Icon: Chat Alt -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 10h.01M12 10h.01M16 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Give Feedback
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <!-- Alpine.js for star rating -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</x-app-layout>
