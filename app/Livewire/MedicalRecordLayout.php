<?php

namespace App\Livewire;

use App\Models\MedicalRecord;
use Livewire\Component;

class MedicalRecordLayout extends Component
{
    public $record;

    protected $listeners = ['viewRecord' => 'loadRecord'];

    public function loadRecord($ulid)
    {
        $this->record = MedicalRecord::with(['doctor', 'patient'])->where('ulid', $ulid)->first();
    }

    public function render()
    {
        return view('components.livewire.forms.medical-record');
    }
}
