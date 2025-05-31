<?php

namespace App\Livewire\Settings;

use App\Models\Student;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;

class Profile extends Component
{
    use WithFileUploads;

    public string $name = '';
    public string $email = '';
    public string $gender = '';
    public string $phone = '';
    public string $address = '';
    public string $nis = '';
    public $image;
    public $newImage;

    /**
     * Mount the component.
     */
    public function mount(): void
    {
        $this->name = Auth::user()->name;
        $this->email = Auth::user()->email;
        $student = Student::where('email', Auth::user()->email)->first();
        $this->gender = $student->gender;
        $this->phone = $student->phone;
        $this->address = $student->address;
        $this->nis = $student->nis;
        $this->image = $student->image;
    }

    /**
     * Update the profile information for the currently authenticated user.
     */
    public function updateProfileInformation(): void
    {
        $user = Auth::user();
        $student = Student::where('email', $user->email)->first();

        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],

            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($user->id),
            ],
        ]);

        $validatedStudentData = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'gender' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:20'],
            'address' => ['required', 'string', 'max:255'],
            'nis' => ['required', 'string', 'max:20'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($user->id),
            ],
        ]);

        $this->validate([
            'newImage' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if($this->newImage){
            $path = $this->newImage->store('images', 'public');
            $student->image = $path;
        }

        $student->fill($validatedStudentData);
        $user->fill($validated);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $student->save();
        $user->save();

        $this->dispatch('profile-updated', name: $user->name);
        $this->redirect(route('settings.profile', absolute: false), navigate: true);
    }

    /**
     * Send an email verification notification to the current user.
     */
    public function resendVerificationNotification(): void
    {
        $user = Auth::user();

        if ($user->hasVerifiedEmail()) {
            $this->redirectIntended(default: route('dashboard', absolute: false));

            return;
        }

        $user->sendEmailVerificationNotification();

        Session::flash('status', 'verification-link-sent');
    }
}
