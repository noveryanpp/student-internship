<?php

namespace App\Observers;

use App\Models\Industry;

class IndustryObserver
{
    /**
     * Handle the Industry "created" event.
     */
    public function created(Industry $industry): void
    {
        $industry->phone = ltrim($industry->phone, '0');
        if (!str_starts_with($industry->phone, '+62')) {
            $industry->phone = '+62' . $industry->phone;
        }
        $industry->save();
    }

    /**
     * Handle the Industry "updated" event.
     */
    public function updated(Industry $industry): void
    {
        if($industry->isDirty('phone')){
            $phone = ltrim($industry->phone, '0');
            if (!str_starts_with($phone, '+62')) {
                $phone = '+62' . $phone;
            }
            if($industry->phone != $phone){
                $industry->phone = $phone;
                $industry->save();
            }
        }
    }

    /**
     * Handle the Industry "deleted" event.
     */
    public function deleted(Industry $industry): void
    {
        //
    }

    /**
     * Handle the Industry "restored" event.
     */
    public function restored(Industry $industry): void
    {
        //
    }

    /**
     * Handle the Industry "force deleted" event.
     */
    public function forceDeleted(Industry $industry): void
    {
        //
    }
}
