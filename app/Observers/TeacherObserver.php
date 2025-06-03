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
        $teacher->phone = ltrim($teacher->phone, '0');
        if (!str_starts_with($teacher->phone, '+62')) {
            $teacher->phone = '+62' . $teacher->phone;
        }
        $teacher->save();
    }

    /**
     * Handle the Teacher "updated" event.
     */
    public function updated(Teacher $teacher): void
    {
        if($teacher->isDirty('phone')){
            $phone = ltrim($teacher->phone, '0');
            if (!str_starts_with($phone, '+62')) {
                $phone = '+62' . $phone;
            }
            if($teacher->phone != $phone){
                $teacher->phone = $phone;
                $teacher->save();
            }
        }
    }

    /**
     * Handle the Teacher "deleted" event.
     */
    public function deleted(Teacher $teacher): void
    {
//        User::where('email', $teacher->email)->delete();
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
