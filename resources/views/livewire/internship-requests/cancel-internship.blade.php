<div>
    @if($internship)
        <flux:modal name="cancel-internship" class="md:w-full">
            <div class="space-y-6 text-center">
                <div>
                    <flux:heading size="xl">Are you sure you want to cancel your Internship?</flux:heading>
                    <flux:text class="mt-1" size="lg">{{ $internship->industry->name }}</flux:text>
                    <flux:text class="mt-1" size="lg">{{ $internship->start_date }} - {{ $internship->end_date }} ({{ $internship->period+1 }} days)</flux:text>
                </div>

    {{--            <form wire:submit.prevent="save" class="space-y-6">--}}
    {{--                <flux:heading size="lg">Industry</flux:heading>--}}
    {{--                --}}
    {{--                <flux:separator />--}}

    {{--                <flux:heading size="lg">Internship Details</flux:heading>--}}

    {{--                <flux:input label="Start Date" type="date" wire:model.lazy="startDate"/>--}}

    {{--                <flux:input label="Finish Date" type="date" wire:model.lazy="endDate"/>--}}

    {{--                <div class="flex">--}}
    {{--                    <flux:spacer />--}}

    {{--                </div>--}}
    {{--            </form>--}}
                <div class="flex justify-center flex-row gap-2 w-full">
                    <flux:button wire:click="remove" variant="danger" @class(['w-1/2'])>Yes</flux:button>
                    <div class="w-1/2">
                        <flux:modal.close>
                            <flux:button variant="primary" @class(['w-full']) >No</flux:button>
                        </flux:modal.close>
                    </div>
                </div>
            </div>
        </flux:modal>
    @endif
</div>
