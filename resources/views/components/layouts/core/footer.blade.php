<footer aria-labelledby="footer-heading" >
    <h2 id="footer-heading" class="sr-only">Footer</h2>
    <x-container class="pt-16 pb-8">
        <div class="border-t border-gray-200 dark:border-zinc-700 pt-8 md:flex md:items-center md:justify-between">
            <div class="flex gap-x-6 md:order-2 justify-center">
                <flux:button x-data x-on:click="$flux.dark = ! $flux.dark" icon="moon" variant="subtle"
                             aria-label="Toggle dark mode"/>
            </div>
            <p class="mt-8 text-base text-gray-500 md:order-1 md:mt-0 text-center">
                &copy; {{ date('Y') }} Poo | Designed by Angus Goody
            </p>
        </div>
    </x-container>
</footer>
