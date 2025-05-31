<?php

namespace App\Livewire\Industry;

use App\Models\Industry;
use Livewire\Component;
use Livewire\WithPagination;

class ListIndustry extends Component
{
    use WithPagination;

    public $search;

    public function mount()
    {
        $this->search = '';
    }
    public function render()
    {
        $industries = Industry::where('name', 'like', '%' . $this->search . '%')
            ->paginate(15);

        return view('livewire.industry.list-industry', [
            'industries' => $industries,
        ]);
    }
}
