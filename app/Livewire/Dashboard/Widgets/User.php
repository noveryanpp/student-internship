<?php

namespace App\Livewire\Dashboard\Widgets;

use App\Models\Student;
use Filament\Notifications\Notification;
use Livewire\Component;

class User extends Component
{
    public $studentImage;

    public function logOut()
    {
        auth()->logout();
        $this->redirect('/');
    }

    public function mount()
    {
        $student = Student::where('email', auth()->user()->email)->first();
        $this->studentImage = $student->image;
    }
    public function render()
    {
        return view('livewire.dashboard.widgets.user');
    }
}
