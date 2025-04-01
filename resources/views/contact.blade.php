<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Contact Center') }}
        </h2>
    </x-slot>

    <div class="py-12 text-white">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-[#1b2a41] p-6 rounded-xl shadow-lg space-y-8">
                
                <!-- Ask for Help -->
                <form method="POST" action="{{ route('contact.help') }}">
                    @csrf
                    <label class="block text-white font-semibold mb-2">Ask us your concern about our service:</label>
                    <textarea name="help_message" rows="4" required
                        class="w-full p-3 rounded text-black resize-none"
                        placeholder="Ask us your concern about our service..."></textarea>
                    <button type="submit"
                        class="mt-2 bg-blue-500 hover:bg-blue-600 px-4 py-2 rounded text-white font-semibold">
                        Ask for help
                    </button>
                </form>

                <!-- Star Rating + Feedback -->
                <form method="POST" action="{{ route('contact.feedback') }}">
                    @csrf
                    <div x-data="{ rating: 0 }" class="text-center">
                        <label class="block text-white font-semibold mb-2">How would you rate our service?</label>
                        <div class="flex justify-center space-x-1 mb-4">
                            <template x-for="star in 5" :key="star">
                                <svg @click="rating = star"
                                     @click="$refs.rating.value = star"
                                     :class="rating >= star ? 'text-blue-400' : 'text-blue-900'"
                                     class="w-8 h-8 cursor-pointer fill-current transition"
                                     viewBox="0 0 24 24">
                                    <path d="M12 .587l3.668 7.431L24 9.753l-6 5.845L19.335 24 12 19.897 4.665 24 6 15.598 0 9.753l8.332-1.735z"/>
                                </svg>
                            </template>
                            <input type="hidden" name="rating" x-ref="rating" value="0" />
                        </div>
                    </div>

                    <label class="block text-white font-semibold mb-2">Send us your thoughts about our service:</label>
                    <textarea name="feedback_message" rows="4" required
                        class="w-full p-3 rounded text-black resize-none"
                        placeholder="Send us your thoughts about our service..."></textarea>
                    <button type="submit"
                        class="mt-2 bg-blue-500 hover:bg-blue-600 px-4 py-2 rounded text-white font-semibold">
                        Give feedback
                    </button>
                </form>

            </div>
        </div>
    </div>

    <!-- Alpine.js for star rating -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</x-app-layout>
