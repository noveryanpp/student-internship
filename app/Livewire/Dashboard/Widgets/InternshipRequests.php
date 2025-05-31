<?php

namespace App\Livewire\Dashboard\Widgets;

use App\Models\InternshipRequest;
use App\Models\Student;
use Livewire\Component;

class InternshipRequests extends Component
{
    public $totalRequests;
    public $totalPending;
    public $totalReady;
    public $totalRejected;

    public function mount()
    {
        $studentId = Student::where('email', auth()->user()->email)->value('id');
        $this->totalRequests = InternshipRequest::where('student_id', $studentId)->count();
        $this->totalPending = InternshipRequest::where('student_id', $studentId)->where('status', 'pending')->count();
        $this->totalReady = InternshipRequest::where('student_id', $studentId)->where('status', 'ready')->count();
        $this->totalRejected = InternshipRequest::where('student_id', $studentId)->where('status', 'rejected')->count();
    }
    public function render()
    {
        return view('livewire.dashboard.widgets.internship-requests');
    }
}
