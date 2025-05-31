<div>
    <div class="flex flex-col mr-auto p-4">
        <h2 class="text-zinc-800 dark:text-white font-semibold ">Your Internship Requests:</h2>
        <div class="flex flex-row items-center gap-5 mt-2">
            <div class="flex flex-col justify-center items-center w-1/3">
                <h1 class="text-3xl text-zinc-800 dark:text-white font-semibold">{{ $totalRequests }}</h1>
                <p class="text-sm text-zinc-400">Total</p>
            </div>
            <div class="flex flex-col justify-center items-center w-1/3">
                <h1 class="text-3xl text-zinc-800 dark:text-white font-semibold">{{ $totalPending }}</h1>
                <p class="text-sm text-zinc-400">Pending</p>
            </div><div class="flex flex-col justify-center items-center w-1/3">
                <h1 class="text-3xl text-zinc-800 dark:text-white font-semibold">{{ $totalReady }}</h1>
                <p class="text-sm text-zinc-400">Ready to Collect</p>
            </div>
            <div class="flex flex-col justify-center items-center w-1/3">
                <h1 class="text-3xl text-zinc-800 dark:text-white font-semibold">{{ $totalRejected }}</h1>
                <p class="text-sm text-zinc-400">Rejected</p>
            </div>
        </div>
    </div>
</div>
