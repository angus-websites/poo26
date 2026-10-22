<footer aria-labelledby="footer-heading">
    <h2 id="footer-heading" class="sr-only">Footer</h2>
    <x-container class="pt-16 pb-8">
        <div class="border-t border-gray-200 dark:border-zinc-700 pt-8 flex items-center justify-between gap-6">
            <!-- System Info (Far Left) -->
            <x-layouts.core.footer.system-info-link/>

            <!-- Branding Section -->
            <p class="text-base text-gray-500 dark:text-zinc-100/60 flex-1">
                &copy; {{ date('Y') }} {{ config('app.name') }} |
                <span class="inline-flex items-center gap-2">Made by
                    <a
                        class="text-pink-500 dark:text-pink-400 inline-flex items-center gap-1"
                        target="_blank"
                        href="https://berrybits.dev"
                    >
                        <flux:icon.berry class="w-4 h-4"/>
                        BerryBits
                    </a>
                </span>
            </p>

            <!-- Dark Mode Toggle (Far Right) -->
            <x-layouts.core.footer.dark-mode-toggle/>
        </div>
    </x-container>
</footer>
