<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-3">
            <div class="bg-yellow-400 p-2 rounded-full">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-black" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M20 12v7a2 2 0 01-2 2H6a2 2 0 01-2-2v-7M4 8h16M4 8a4 4 0 014-4 4 4 0 014 4m0 0a4 4 0 014-4 4 4 0 014 4" />
                </svg>
            </div>
            <h2 class="font-semibold text-xl text-white leading-tight">
                {{ __('Loyalty Reward') }}
            </h2>
        </div>
    </x-slot>

    @php
        $user = Auth::user();
        $userPoints = $user->loyalty_points ?? 0;
        $followed = json_encode($user->followed_platforms ?? []);
    @endphp

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <div class="py-12 text-white">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gradient-to-br from-[#1b2a41] to-[#0f172a] p-8 rounded-2xl shadow-2xl space-y-6">

                <div class="text-center">
                    <h3 class="text-2xl font-bold text-yellow-400">Coming Soon!</h3>
                    <p class="text-lg mt-2 text-gray-300">Stay tuned for exciting perks and benefits. 🎁</p>
                </div>

                <div class="bg-[#0f172a] p-4 rounded-xl border border-yellow-400">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-sm text-gray-400">Your Points</p>
                            <p class="text-3xl font-bold text-yellow-300" id="pointsDisplay">{{ $userPoints }}</p>
                        </div>
                    </div>

                    <div class="mt-4">
                        <p class="text-sm text-gray-400 mb-1">Progress to next reward</p>
                        <div class="w-full bg-gray-700 rounded-full h-3">
                            <div id="progressBar" class="bg-yellow-400 h-3 rounded-full" style="width: {{ $userPoints }}%"></div>
                        </div>
                    </div>
                </div>

                <div class="mt-8">
                    <h3 class="text-xl font-bold text-yellow-400 mb-4">Follow Us and Earn Points! 🏅</h3>
                    <p class="text-sm text-gray-300 mb-6">
                        Get <span class="text-yellow-300 font-semibold">+25 points</span> for following each of our official social media accounts.
                    </p>

                    <div class="grid md:grid-cols-3 gap-4">
                        <a href="#" class="follow-button flex items-center bg-[#1877f2] hover:bg-[#145dbf] text-white px-4 py-3 rounded-lg shadow-md transition" data-points="25" data-platform="facebook">
                            Facebook
                        </a>
                        <a href="#" class="follow-button flex items-center bg-gradient-to-r from-pink-500 to-yellow-500 hover:opacity-90 text-white px-4 py-3 rounded-lg shadow-md transition" data-points="25" data-platform="instagram">
                            Instagram
                        </a>
                        <a href="#" class="follow-button flex items-center bg-black hover:bg-gray-800 text-white px-4 py-3 rounded-lg shadow-md transition" data-points="25" data-platform="tiktok">
                            TikTok
                        </a>
                    </div>

                    <div class="mt-6 text-sm text-center text-yellow-300 font-medium">
                        ✅ Earn bonus points when you follow us <span class="text-white font-bold">AND</span> complete an 8-hour locker rent!
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        let points = {{ $userPoints }};
        const clickedPlatforms = new Set({!! $followed !!});
        const pointsDisplay = document.getElementById('pointsDisplay');
        const progressBar = document.getElementById('progressBar');
        const followButtons = document.querySelectorAll('.follow-button');

        followButtons.forEach(button => {
            const platform = button.getAttribute('data-platform');

            if (clickedPlatforms.has(platform)) {
                button.classList.add('opacity-50', 'cursor-not-allowed');
                button.setAttribute('disabled', true);
            }

            button.addEventListener('click', function (e) {
                e.preventDefault();
                if (clickedPlatforms.has(platform)) return;

                const pointsToAdd = parseInt(button.getAttribute('data-points'));
                points += pointsToAdd;
                if (points > 100) points = 100;

                fetch('{{ route('loyalty.update') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        platform: platform,
                        points: points
                    })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        clickedPlatforms.add(platform);
                        pointsDisplay.textContent = data.points;
                        progressBar.style.width = `${data.points}%`;

                        button.classList.add('opacity-50', 'cursor-not-allowed');
                        button.setAttribute('disabled', true);

                        const links = {
                            facebook: 'https://www.facebook.com/profile.php?id=61573419869087&mibextid=LQQJ4d',
                            instagram: 'https://www.instagram.com/hellostoreme?igsh=YzljYTk1ODg3Zg==',
                            tiktok: 'https://www.tiktok.com/@storeme51?_t=ZS-8u3sThzEqX4&_r=1'
                        };

                        if (links[platform]) {
                            window.open(links[platform], '_blank');
                        }
                    }
                });
            });
        });
    });
    </script>
</x-app-layout>