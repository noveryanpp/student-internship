<div class="flex flex-col w-full h-full">
    <div class="overflow-x-auto sm:-mx-6 lg:-mx-8 h-full">
        <div class="inline-block min-w-full h-full sm:px-6 lg:px-8">
            <div class="overflow-hidden flex flex-col h-full">
                <div class="border-b border-zinc-800/10 dark:border-white/20 flex p-2">
                    {{ $industries->links('vendor.pagination.custom') }}
                    <div class="ml-auto flex flex-row gap-2">
                        @if(session('error'))
                            <flux:button disabled icon="exclamation-circle">{{ session('error') }}</flux:button>
                        @endif
                        @if(session('success'))
                            <flux:button disabled icon="check-circle">{{ session('success') }}</flux:button>
                        @endif
                        <flux:modal.trigger name="create-industry">
                            <flux:button icon="plus">Add New Industry</flux:button>
                        </flux:modal.trigger>
                        <flux:input icon="magnifying-glass" placeholder="Search" wire:model.live="search" />
                    </div>
                </div>
                @if($industries)
                    <table class="min-w-full">
                        <thead>
                        <tr class="border-b border-zinc-800/10 dark:border-white/20">
                            <th scope="col" class="text-sm font-medium text-zinc-800 dark:text-white px-6 py-4 text-left">#</th>
                            <th scope="col" class="text-sm font-medium text-zinc-800 dark:text-white px-6 py-4 text-left">Name</th>
                            <th scope="col" class="text-sm font-medium text-zinc-800 dark:text-white px-6 py-4 text-center">Field</th>
                            <th scope="col" class="text-sm font-medium text-zinc-800 dark:text-white px-6 py-4 text-center">Address</th>
                            <th scope="col" class="text-sm font-medium text-zinc-800 dark:text-white px-6 py-4 text-center">Phone</th>
                            <th scope="col" class="text-sm font-medium text-zinc-800 dark:text-white px-6 py-4 text-center">Email</th>
                            <th scope="col" class="text-sm font-medium text-zinc-800 dark:text-white px-6 py-4 text-center">Website</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach ($industries as $index => $industry)
                                <tr class="border-b border-zinc-800/10 dark:border-white/20">
                                    <td class="text-sm text-zinc-500 dark:text-zinc-300 px-6 py-4 whitespace-nowrap text-left">{{ $index+1 }}</td>
                                    <td class="text-sm text-zinc-500 dark:text-zinc-300 px-6 py-4 whitespace-nowrap text-left">{{ $industry->name }}</td>
                                    <td class="text-sm text-zinc-500 dark:text-zinc-300 px-6 py-4 whitespace-nowrap text-center">{{ $industry->field }}</td>
                                    <td class="text-sm text-zinc-500 dark:text-zinc-300 px-6 py-4 whitespace-nowrap text-center">{{ $industry->address }}</td>
                                    <td class="text-sm text-zinc-500 dark:text-zinc-300 px-6 py-4 whitespace-nowrap text-center">{{ $industry->phone }}</td>
                                    <td class="text-sm text-zinc-500 dark:text-zinc-300 px-6 py-4 whitespace-nowrap text-center">{{ $industry->email }}</td>
                                    <td class="text-sm text-zinc-500 dark:text-zinc-300 px-6 py-4 whitespace-nowrap text-center">{{ $industry->website }}</td>
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

