<div>
    <flux:modal name="create-industry" class="md:w-full">
        <div class="space-y-6">
            <div>
                <flux:heading size="xl">Add New Industry</flux:heading>
            </div>

            <form wire:submit.prevent="save" class="space-y-6">

                <flux:input label="Name" wire:model.lazy="newIndustry.name" />
                <flux:input label="Field" wire:model.lazy="newIndustry.field" />
                <flux:input label="Address" wire:model.lazy="newIndustry.address" />
                <flux:input label="Phone" wire:model.lazy="newIndustry.phone" />
                <flux:input label="Email" wire:model.lazy="newIndustry.email" />
                <flux:input label="Website" wire:model.lazy="newIndustry.website" />

                <div class="flex">
                    <flux:spacer />

                    <flux:button type="submit" variant="primary">Add Industry</flux:button>
                </div>
            </form>
        </div>
    </flux:modal>
</div>
