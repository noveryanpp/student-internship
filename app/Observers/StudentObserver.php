<?php

namespace App\Observers;

use App\Models\Student;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class StudentObserver
{
    /**
     * Handle the Student "created" event.
     */
    public function created(Student $student): void
    {
        if (!User::where('email', $student->email)->exists()) {
            try {
                $user = User::create([
                    'name' => $student->name,
                    'email' => $student->email,
                    'password' => Hash::make($student->nis),
                ]);
                $user->assignRole('student');
            } catch (\Exception $e) {
                \Log::error('User creation failed: ' . $e->getMessage());
            }
        }
    }

    /**
     * Handle the Student "updated" event.
     */
    public function updated(Student $student): void
    {
        $oldEmail = $student->getOriginal('email');
        $user = User::where('email', $oldEmail)->first();
        if ($user) {
            $user->name = $student->name;
            $user->email = $student->email;
            $user->save();
        }
    }

    /**
     * Handle the Student "deleted" event.
     */
    public function deleted(Student $student): void
    {
        User::where('email', $student->email)->delete();
    }

    /**
     * Handle the Student "restored" event.
     */
    public function restored(Student $student): void
    {
        //
    }

    /**
     * Handle the Student "force deleted" event.
     */
    public function forceDeleted(Student $student): void
    {
        //
    }
}
