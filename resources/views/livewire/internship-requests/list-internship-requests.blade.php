<div class="flex flex-col w-full">
    <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
        <div class="inline-block min-w-full sm:px-6 lg:px-8">
            <div class="overflow-hidden">
                <div class="border-b border-zinc-800/10 dark:border-white/20 flex p-2">
                    <div class="flex items-center ml-2">
                        <h2 class="text-xl  font-medium text-zinc-800 dark:text-white">Your Internship Requests</h2>
                    </div>
                    <div class="ml-auto flex flex-row gap-2">
                        @if(session('error'))
                            <flux:button disabled icon="exclamation-circle">{{ session('error') }}</flux:button>
                        @endif
                        @if(session('success'))
                            <flux:button disabled icon="check-circle">{{ session('success') }}</flux:button>
                        @endif
                        <flux:modal.trigger name="create-internship-request">
                            <flux:button icon="plus">Create New Request</flux:button>
                        </flux:modal.trigger>
                        <flux:input icon="magnifying-glass" placeholder="Search" wire:model.live="search"/>
                    </div>
                </div>
                @if($internshipRequests)
                    <table class="min-w-full">
                        <thead>
                        <tr class="border-b border-zinc-800/10 dark:border-white/20">
                            <th scope="col" class="text-sm font-medium text-zinc-800 dark:text-white px-6 py-4 text-left">#</th>
                            <th scope="col" class="text-sm font-medium text-zinc-800 dark:text-white px-6 py-4 text-left">Industry</th>
                            <th scope="col" class="text-sm font-medium text-zinc-800 dark:text-white px-6 py-4 text-center">Status</th>
                            <th scope="col" class="text-sm font-medium text-zinc-800 dark:text-white px-6 py-4 text-center">Start Date</th>
                            <th scope="col" class="text-sm font-medium text-zinc-800 dark:text-white px-6 py-4 text-center">End Date</th>
                            <th scope="col" class="text-sm font-medium text-zinc-800 dark:text-white px-6 py-4 text-center">Confirm Industry Acceptance</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($internshipRequests as $index => $internshipRequest)
                                <tr class="border-b border-zinc-800/10 dark:border-white/20">
                                    <td class="text-sm text-zinc-500 dark:text-zinc-300 px-6 py-4 whitespace-nowrap text-left">{{ $index + 1 }}</td>
                                    <td class="text-sm text-zinc-500 dark:text-zinc-300 px-6 py-4 whitespace-nowrap text-left">{{ $internshipRequest->industry->name }}</td>
                                    <td class="text-sm text-zinc-500 dark:text-zinc-300 px-6 py-4 whitespace-nowrap text-center">
                                        @php
                                            $color = match($internshipRequest->status)
                                            {
                                                'pending' => 'yellow',
                                                'accepted' => 'green',
                                                'rejected' => 'red',
                                                'ready' => 'blue',
                                                default => 'gray'
                                            };
                                        @endphp
                                        <flux:badge :color="$color" class="ml-2">{{ $internshipRequest->status == 'ready' ? 'Collect at BKK': ucfirst($internshipRequest->status)  }}</flux:badge>
                                    </td>
                                    <td class="text-sm text-zinc-500 dark:text-zinc-300 px-6 py-4 whitespace-nowrap text-center">{{ $internshipRequest->start_date }}</td>
                                    <td class="text-sm text-zinc-500 dark:text-zinc-300 px-6 py-4 whitespace-nowrap text-center">{{ $internshipRequest->end_date }}</td>
                                    @if($internshipRequest->status == 'ready' && !$student->internship_status)
                                        <td class="text-sm text-zinc-500 dark:text-zinc-300 px-6 py-4 whitespace-nowrap text-center flex flex-row gap-2 justify-center">
                                            <flux:button icon="check" variant="filled" wire:click="internshipConfirmation({{ $internshipRequest->id }}, 'accepted')">Accepted</flux:button>
                                            <flux:button icon="x-mark" variant="danger" wire:click="internshipConfirmation({{ $internshipRequest->id }}, 'rejected')">Rejected</flux:button>
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="flex flex-col items-center justify-center p-4 gap-2">
                        <div class="bg-white dark:bg-zinc-800 text-zinc-800 dark:text-white border border-zinc-200 dark:border-transparent w-10 h-10 flex items-center justify-center rounded-full">
                            <flux:icon name="x-mark" size="6x" />
                        </div>
                        <p class="text-lg font-medium text-zinc-800 dark:text-white">You don't have any Internship Request yet.</p>
                    </div>
                @endif


            </div>
        </div>
    </div>
</div>
