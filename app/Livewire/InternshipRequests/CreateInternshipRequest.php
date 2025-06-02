<?php

namespace App\Livewire\InternshipRequests;

use App\Models\Industry;
use App\Models\InternshipRequest;
use App\Models\Student;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class CreateInternshipRequest extends Component
{
    public $industries = [];
    public $industryId;
    public $startDate;
    public $endDate;
    public $newIndustry = [
        'name' => '',
        'field' => '',
        'address' => '',
        'phone' => '',
        'email' => '',
        'website' => '',
    ];

    public function save()
    {
        $validatedDate = $this->validate([
            'startDate' => 'required|date',
            'endDate' => 'required|date|after:startDate',
        ]);

        if ($this->industryId == 0) {
            $validatedNewIndustry = $this->validate([
                'newIndustry.name' => 'required|string|max:255',
                'newIndustry.field' => 'required|string|max:255',
                'newIndustry.address' => 'required|string|max:255',
                'newIndustry.phone' => 'required|string|max:20',
                'newIndustry.email' => 'email|max:255',
                'newIndustry.website' => 'url|max:255',
            ]);
        }

        try {
            DB::transaction(function () use (&$validatedNewIndustry, $validatedDate) {
                $student = Student::where('email', auth()->user()->email)->first();
                if ($student && $student->internship_status) {
                    throw new \Exception('You already have an internship.');
                }

                if ($this->industryId == 0) {
//                    $validatedNewIndustry = $this->validate([
//                        'newIndustry.name' => 'required|string|max:255',
//                        'newIndustry.field' => 'required|string|max:255',
//                        'newIndustry.address' => 'required|string|max:255',
//                        'newIndustry.phone' => 'required|string|max:20',
//                        'newIndustry.email' => 'required|email|max:255',
//                        'newIndustry.website' => 'required|url|max:255',
//                    ]);
                    $industry = Industry::create($validatedNewIndustry['newIndustry']);
                    $this->industryId = $industry->id;
                }

                $validatedIndustryId = $this->validate([
                    'industryId' => 'required|integer',
                ]);

                $data = [
                    'industry_id' => $validatedIndustryId['industryId'],
                    'student_id' => $student->id,
                    'start_date' => $validatedDate['startDate'],
                    'end_date' => $validatedDate['endDate'],
                ];

                InternshipRequest::create($data);
            });

            return redirect()->route('dashboard')->with('success', 'Internship request created successfully.');

        } catch (\Exception $e) {
            return redirect()->route('dashboard')->with('error', $e->getMessage());
        }
    }

    public function mount()
    {
        $this->industries = Industry::orderBy('name')->get();
    }

    public function render()
    {
        return view('livewire.internship-requests.create-internship-request');
    }
}
