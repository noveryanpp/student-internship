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
        $student->phone = ltrim($student->phone, '0');
        if (!str_starts_with($student->phone, '+62')) {
            $student->phone = '+62' . $student->phone;
        }
        $student->save();
    }

    /**
     * Handle the Student "updated" event.
     */
    public function updated(Student $student): void
    {
        if($student->isDirty('phone')){
            $phone = ltrim($student->phone, '0');
            if (!str_starts_with($phone, '+62')) {
                $phone = '+62' . $phone;
            }
            if($student->phone != $phone){
                $student->phone = $phone;
                $student->save();
            }

        }

        if($student->isDirty('email')){
            $oldEmail = $student->getOriginal('email');
            $user = User::where('email', $oldEmail)->first();
            if ($user) {
                $user->name = $student->name;
                $user->email = $student->email;
                $user->save();
            }
        }
    }

    /**
     * Handle the Student "deleted" event.
     */
    public function deleted(Student $student): void
    {
//        User::where('email', $student->email)->delete();
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
