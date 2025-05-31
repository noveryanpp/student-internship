<?php

namespace App\Livewire\InternshipRequests;

use App\Models\Internship;
use App\Models\InternshipRequest;
use App\Models\Student;
use Livewire\Component;
use Illuminate\Contracts\View\View;

class ListInternshipRequests extends Component
{
    public $internshipRequests;
    public $student;
    public $search;

    protected $listeners = ['internshipConfirmation'];

    public function internshipConfirmation($id, $status)
    {
        $internshipRequest = InternshipRequest::findOrFail($id);

        if ($status == 'accepted') {
            if(!$this->student->internship_status){
                Internship::create($internshipRequest->makeHidden('status')->toArray());
                $this->student->update(['internship_status' => 1]);
                $internshipRequest->update(['status' => $status]);
            } else {
                session()->flash('error', 'You already have an internship.');
            }
        } elseif ($status == 'rejected') {
            $internshipRequest->update(['status' => $status]);
        }

        $this->redirect(route('dashboard'));
    }

    public function mount()
    {
        //
    }

    public function render()
    {
        $this->student = Student::where('email', auth()->user()->email)->first();
        $requests = InternshipRequest::where('student_id', $this->student->id)
            ->when($this->search, function ($query, $search) {
                $query->whereHas('industry', function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%');
                });
            })
            ->latest()->get();
        $this->internshipRequests = $requests->isEmpty() ? null : $requests;
        return view('livewire.internship-requests.list-internship-requests', [
            'internshipRequests' => $this->internshipRequests,
        ]);
    }
}
