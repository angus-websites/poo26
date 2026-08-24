<footer aria-labelledby="footer-heading">
    <h2 id="footer-heading" class="sr-only">Footer</h2>
    <x-container class="pt-16 pb-8">
        <div class="border-t border-gray-200 dark:border-zinc-700 pt-8 md:flex md:items-center md:justify-between">
            <div class="flex gap-x-6 md:order-2 justify-center">
                <flux:tooltip content="Toggle dark mode">
                    <flux:button
                        square
                        variant="subtle"
                        x-data
                        x-on:click="$flux.dark = ! $flux.dark"
                    >
                        <flux:icon.moon
                            variant="solid"
                            x-show="! $flux.dark"
                        />
                        <flux:icon.sun
                            variant="solid"
                            x-cloak
                            x-show="$flux.dark"
                        />
                    </flux:button>
                </flux:tooltip>
            </div>
            <p x-data="{}" class="mt-8 text-base text-gray-500 md:order-1 md:mt-0 text-center">
                &copy; {{ date('Y') }} Bud |
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
        </div>
    </x-container>
</footer>
