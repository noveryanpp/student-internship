<?php

namespace App\Livewire\Auth;

use App\Models\Student;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.auth')]
class Register extends Component
{

    public string $email = '';

    public string $password = '';

    public string $password_confirmation = '';

    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        $validated = $this->validate([
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class, 'exists:'.Student::class.',email'],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ],[
            'email.exists' => 'This email is not registered as a student.',
        ]);

        $validated['name'] = Student::where('email', $validated['email'])->first()->name;

        $validated['password'] = Hash::make($validated['password']);

        event(new Registered(($user = User::create($validated))));

        $user->assignRole('student');

        Auth::login($user);

        $this->redirect(route('dashboard', absolute: false), navigate: true);
    }
}
