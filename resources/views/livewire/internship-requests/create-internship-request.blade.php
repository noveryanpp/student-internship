<div>
    <flux:modal name="create-internship-request" class="md:w-full">
        <div class="space-y-6">
            <div>
                <flux:heading size="xl">Create New Internship Request</flux:heading>
                <flux:text class="mt-1" size="lg">{{ auth()->user()->name }}</flux:text>
            </div>

            <form wire:submit.prevent="save" class="space-y-6">
                <flux:heading size="lg">Industry</flux:heading>

                <flux:select wire:model.live="industryId" placeholder="Choose industry...">
                    <flux:select.option value="">-- Select Industry --</flux:select.option>
                    @foreach ($industries as $industry)
                        <flux:select.option value="{{ $industry->id }}">{{ $industry->name }}</flux:select.option>
                    @endforeach
                    <flux:select.option value="0">Other</flux:select.option>
                </flux:select>

                @if ($industryId === '0')
                    <flux:input label="Name" wire:model.lazy="newIndustry.name" />
                    <flux:input label="Field" wire:model.lazy="newIndustry.field" />
                    <flux:input label="Address" wire:model.lazy="newIndustry.address" />
                    <flux:input label="Phone" wire:model.lazy="newIndustry.phone" />
                    <flux:input label="Email" wire:model.lazy="newIndustry.email" />
                    <flux:input label="Website" wire:model.lazy="newIndustry.website" />
                @endif

                <flux:separator />

                <flux:heading size="lg">Internship Details</flux:heading>

                <flux:input label="Start Date" type="date" wire:model.lazy="startDate"/>

                <flux:input label="Finish Date" type="date" wire:model.lazy="endDate"/>

                <div class="flex">
                    <flux:spacer />

                    <flux:button type="submit" variant="primary">Create Request</flux:button>
                </div>
            </form>
        </div>
    </flux:modal>
</div>
