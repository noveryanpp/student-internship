<?php

namespace App\Livewire\InternshipRequests;

use App\Models\Industry;
use App\Models\Internship;
use App\Models\InternshipRequest;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class CancelInternship extends Component
{
    public $student;
    public $internship;

    public function remove()
    {
        try {
            DB::transaction(function () {
                if ($this->student && !$this->student->internship_status && !$this->internship) {
                    throw new \Exception('You don\'t have an internship.');
                }

                $this->internship->delete();
                $this->student->update(['internship_status' => 0]);
            });

            return redirect()->route('dashboard')->with('success', 'Internship cancelled successfully.');

        } catch (\Exception $e) {
            return redirect()->route('dashboard')->with('error', $e->getMessage());
        }
    }

    public function mount()
    {
        $this->student = Student::where('email', auth()->user()->email)->first();
        $this->internship = Internship::where('student_id', $this->student->id)->first();
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
        return view('livewire.internship-requests.cancel-internship');
    }
}
