<?php

namespace App\Livewire;

use App\Models\MedicalRecord;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

class PatientHistoryTable extends DataTableComponent
{
    protected $model = MedicalRecord::class;

    public $patient_id;

    public function configure(): void
    {
        $this->setPrimaryKey('id')
            ->setDefaultSort('created_at', 'desc')
            ->setRefreshTime(60000) // Component refreshes every 60 seconds
            ->setPerPageAccepted([10, 25, 50, 100, -1]) // Options for pagination
            ->setAdditionalSelects(['*']) // Additional columns to select
            ->setTrimSearchStringEnabled() // Will trim whitespace from either end of search strings
        ;

        $this->setTableWrapperAttributes([
            'class' => 'overflow-x-auto',
        ]);
        $this->setTheadAttributes([
            'class' => 'relative'
        ]);
    }

    public function mount(string $patient_id)
    {
        $this->patient_id = $patient_id;
    }

    public function builder(): Builder
    {
        return MedicalRecord::query()
            ->with(['doctor']) // Eager load relationships
            ->where('patient_id', $this->patient_id); // Filter records for the specific patient
    }


    public function columns(): array
    {
        $doctorName = fn($row) => $this->getDoctorName($row);
        $columns = [
            Column::make("Date", "created_at")
                ->format(fn($value) => Carbon::parse($value)->format('Y-m-d'))
                ->sortable(),
            Column::make("Doctor")
                ->label($doctorName)
                ->sortable(fn($builder, $direction) => $builder->orderBy('last_name', $direction))
                ->searchable(),
            Column::make("Action")
                ->label(
                    fn($row, Column $column) => view('components.livewire.action-columns.patient-history')->with(
                        [
                            "record_ulid" => $row->ulid,
                        ]
                    )->render()
                )->html(),
        ];

        return $columns;
    }

    public function getDoctorName($row)
    {
        $doctor = $row->doctor;

        if ($doctor) {
            return "{$doctor->last_name}, {$doctor->first_name} {$doctor->middle_name}";
        }

        return 'N/A';
    }
}
