<?php

namespace App\Livewire\Industry;

use App\Models\Industry;
use Livewire\Component;

class CreateIndustry extends Component
{
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
        $validated = $this->validate([
            'newIndustry.name' => 'required|string|max:255',
            'newIndustry.field' => 'required|string|max:255',
            'newIndustry.address' => 'required|string|max:255',
            'newIndustry.phone' => 'required|string|max:20',
            'newIndustry.email' => 'email|max:255',
            'newIndustry.website' => 'url|max:255',
        ]);

        Industry::create($validated['newIndustry']);

        return redirect()->route('industries')->with('success', 'Industry added successfully.');
    }
    public function render()
    {
        return view('livewire.industry.create-industry');
    }
}
