<x-layouts.app :title="__('Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <h2 class="text-2xl  font-bold text-zinc-800 dark:text-white mb-4">Dashboard</h2>
        <div class="grid auto-rows-min gap-4 md:grid-cols-3">
            <div class="relative overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 bg-zinc-50 dark:bg-zinc-900">
                @livewire('dashboard.widgets.user')
            </div>
            <div class="relative overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 bg-zinc-50 dark:bg-zinc-900">
                @livewire('dashboard.widgets.student-internship')
            </div>
            <div class="relative overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 bg-zinc-50 dark:bg-zinc-900">
                @livewire('dashboard.widgets.internship-requests')
            </div>
        </div>
        <div class="relative h-full flex-1 rounded-xl border border-neutral-200 dark:border-neutral-700 bg-zinc-50 dark:bg-zinc-900">
            @livewire('internship-requests.list-internship-requests')
        </div>
        @livewire('internship-requests.create-internship-request')
        @livewire('internship-requests.report-internship')
        @livewire('internship-requests.cancel-internship')
    </div>
</x-layouts.app>
