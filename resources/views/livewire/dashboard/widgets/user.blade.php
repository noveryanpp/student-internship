<div>
    <div class="p-4 flex flex-row items-center gap-2">
        <div class="bg-white dark:bg-zinc-800 text-zinc-800 dark:text-white border border-zinc-200 dark:border-transparent w-10 h-10 flex items-center justify-center rounded-full overflow-hidden">
            @if($studentImage)
                <img src="{{ asset('storage/'.$studentImage) }}" width="auto">
            @else
                {{ auth()->user()->initials() }}
            @endif
        </div>
        <div class="flex flex-col mr-auto">
            <h2 class="text-zinc-800 dark:text-white font-semibold ">Welcome,</h2>
            <p class="text-sm text-zinc-400">{{ auth()->user()->name }}</p>
        </div>
        <div>
            <flux:button icon="arrow-left-end-on-rectangle" wire:click="logOut">Log Out</flux:button>
        </div>
    </div>
</div>
