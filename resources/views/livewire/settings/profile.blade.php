<section class="w-full">
    @include('partials.settings-heading')

    <x-settings.layout :heading="__('Profile')" :subheading="__('Update your name and email address')">
        <form wire:submit="updateProfileInformation" class="my-6 w-full space-y-6">
            <flux:input wire:model="name" :label="__('Name')" type="text" required autofocus autocomplete="name" />
            <flux:select wire:model="gender" :label="__('Gender')">
                <option value="M">{{ __('Male') }}</option>
                <option value="F">{{ __('Female') }}</option>
            </flux:select>
            <flux:input wire:model="nis" :label="__('Nis')" type="text" required autofocus autocomplete="nis" />
            <flux:input wire:model="address" :label="__('Address')" type="text" required autofocus autocomplete="address" />
            <flux:input wire:model="phone" :label="__('Phone')" type="text" required autofocus autocomplete="phone" />
            <div>
                <flux:input wire:model="email" :label="__('Email')" type="email" required autocomplete="email" />

                @if (auth()->user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail &&! auth()->user()->hasVerifiedEmail())
                    <div>
                        <flux:text class="mt-4">
                            {{ __('Your email address is unverified.') }}

                            <flux:link class="text-sm cursor-pointer" wire:click.prevent="resendVerificationNotification">
                                {{ __('Click here to re-send the verification email.') }}
                            </flux:link>
                        </flux:text>

                        @if (session('status') === 'verification-link-sent')
                            <flux:text class="mt-2 font-medium !dark:text-green-400 !text-green-600">
                                {{ __('A new verification link has been sent to your email address.') }}
                            </flux:text>
                        @endif
                    </div>
                @endif
            </div>
            <div>
                <flux:heading @class(['mb-2'])>{{ __('Profile Image :') }}</flux:heading>
                <div class="flex flex-row items-center gap-4">
                    @if($image)
                        <img src="{{ asset('storage/'.$image) }}" width="100">
                    @endif
                    <flux:input type="file" wire:model="newImage"/>
                </div>
            </div>
            @if($newImage)
                <flux:heading class="mt-6">{{ __('New Image Preview :') }}</flux:heading>
                <img src="{{ $newImage->temporaryUrl() }}" width="100">
            @endif


            <div class="flex items-center gap-4">
                <div class="flex items-center justify-end">
                    <flux:button variant="primary" type="submit" class="w-full">{{ __('Save') }}</flux:button>
                </div>

                <x-action-message class="me-3" on="profile-updated">
                    {{ __('Saved.') }}
                </x-action-message>
            </div>
        </form>

        <livewire:settings.delete-user-form />
    </x-settings.layout>
</section>
