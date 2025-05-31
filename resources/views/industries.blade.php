<x-layouts.app :title="__('Industries')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <h2 class="text-2xl  font-bold text-zinc-800 dark:text-white mb-4">Industries</h2>
        <div class="relative h-full flex-1 rounded-xl border border-neutral-200 dark:border-neutral-700 bg-zinc-50 dark:bg-zinc-900">
            @livewire('industry.list-industry')
        </div>
        @livewire('internship-requests.create-internship-request')
        @livewire('industry.create-industry')
    </div>
</x-layouts.app>
