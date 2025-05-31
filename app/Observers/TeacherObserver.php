<?php

namespace App\Observers;

use App\Models\Teacher;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class TeacherObserver
{
    /**
     * Handle the Teacher "created" event.
     */
    public function created(Teacher $teacher): void
    {
        if (!User::where('email', $teacher->email)->exists()) {
            try {
                $user = User::create([
                    'name' => $teacher->name,
                    'email' => $teacher->email,
                    'password' => Hash::make($teacher->nip),
                ]);
                $user->assignRole('teacher');
            } catch (\Exception $e) {
                \Log::error('User creation failed: ' . $e->getMessage());
            }
        }
    }

    /**
     * Handle the Teacher "updated" event.
     */
    public function updated(Teacher $teacher): void
    {
        $oldEmail = $teacher->getOriginal('email');
        $user = User::where('email', $oldEmail)->first();
        if ($user) {
            $user->name = $teacher->name;
            $user->email = $teacher->email;
            $user->save();
        }
    }

    /**
     * Handle the Teacher "deleted" event.
     */
    public function deleted(Teacher $teacher): void
    {
        User::where('email', $teacher->email)->delete();
    }

    /**
     * Handle the Teacher "restored" event.
     */
    public function restored(Teacher $teacher): void
    {
        //
    }

    /**
     * Handle the Teacher "force deleted" event.
     */
    public function forceDeleted(Teacher $teacher): void
    {
        //
    }
}
