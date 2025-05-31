<?php

namespace App\Livewire\Dashboard\Widgets;

use App\Models\Student;
use App\Models\Internship;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class StudentInternship extends Component
{
    public $internship;

    public function mount()
    {
        $studentId = Student::where('email', auth()->user()->email)->value('id');
        $this->internship = Internship::where('student_id', $studentId)->first();
        if($this->internship) {
            $result = DB::selectOne("SELECT getInternshipPeriod(?, ?) as period",
                [
                    $this->internship->start_date,
                    $this->internship->end_date,
                ]);
            $this->internship->period = $result->period+1;
            $this->internship->start_date = Carbon::parse($this->internship->start_date)->format('d F Y');
            $this->internship->end_date = Carbon::parse($this->internship->end_date)->format('d F Y');
        };
    }
    public function render()
    {
        return view('livewire.dashboard.widgets.student-internship');
    }
}
