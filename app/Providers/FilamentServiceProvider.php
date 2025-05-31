<?php

namespace App\Providers;

use Filament\Support\Enums\Alignment;
use Filament\Support\Enums\VerticalAlignment;
use Illuminate\Support\ServiceProvider;
use Filament\Notifications\Livewire\Notifications;

class FilamentServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Notifications::alignment(Alignment::Right);
        Notifications::verticalAlignment(VerticalAlignment::End);
    }
}
