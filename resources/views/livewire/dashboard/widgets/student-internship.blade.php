<div class="flex flex-row">
    <div class="flex flex-col mr-auto p-4 flex-2/3">
        <h2 class="text-zinc-800 dark:text-white font-semibold ">Your Internship :</h2>
        @if($internship)
            <p class="text-sm text-zinc-800 dark:text-white"><span class="text-zinc-400">Industry :</span> {{ $internship->industry->name }}</p>
            <p class="text-sm text-zinc-800 dark:text-white"><span class="text-zinc-400">Teacher :</span>
                @if ($internship->teacher?->name)
                    {{ $internship->teacher->name }}
                @else
                    <span class="text-zinc-400">No assigned teacher yet</span>
                @endif
            </p>
            <p class="text-sm text-zinc-800 dark:text-white"><span class="text-zinc-400">Period :</span> {{ $internship->start_date }} - {{ $internship->end_date }} ({{ $internship->period }} days)</p>
        @else
            <p class="text-sm text-zinc-800 dark:text-white"><span class="text-zinc-400">You don't have an accepted Internship yet.</span></p>
            <flux:modal.trigger name="report-internship">
                <flux:button class="mt-2">Report Internship</flux:button>
            </flux:modal.trigger>
        @endif
    </div>
    @if($internship)
        <div class="flex flex-col pt-2 pr-4">
            <flux:modal.trigger name="cancel-internship">
                <flux:button size="sm" icon="x-mark" class="mt-2">Cancel</flux:button>
            </flux:modal.trigger>
        </div>
    @endif
</div>
