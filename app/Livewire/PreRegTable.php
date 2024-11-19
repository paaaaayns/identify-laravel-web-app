<?php

namespace App\Livewire;

use App\Models\PreRegisteredPatient;
use Livewire\Component;
use Livewire\WithPagination;

class PreRegTable extends Component
{
    use WithPagination;

    public $search = '';  // Search term

    // The number of items per page (optional)
    public $perPage = 10;

    public function render()
    {
        $list = PreRegisteredPatient::search($this->search)
            ->latest()
            ->paginate($this->perPage);

        dd($list);
        
        return view('livewire.pre-reg-table', [
            'list' => $list,
        ]);
    }
}
