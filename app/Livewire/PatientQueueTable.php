<?php

namespace App\Livewire;

use App\Models\Doctor;
use App\Models\Patient;
use App\Models\PatientQueue;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Illuminate\Database\Eloquent\Builder;

class PatientQueueTable extends DataTableComponent
{
    protected $model = PatientQueue::class;

    protected $listeners = ['refreshTable' => '$refresh'];  // Listen for the event and refresh the table

    public function configure(): void
    {
        $this->setPrimaryKey('id')
            ->setDefaultSort('created_at', 'desc')
            ->setRefreshTime(60000) // Component refreshes every 60 seconds
            ->setPerPageAccepted([10, 25, 50, 100, -1]) // Options for pagination
            ->setAdditionalSelects(['id', 'patient_id', 'opd_id', 'doctor_id']) // Additional columns to select
            ->setTrimSearchStringEnabled() // Will trim whitespace from either end of search strings
        ;
    }

    // Add the refreshTable method
    public function refreshTable()
    {
        $this->emitSelf('refresh'); // Trigger the table refresh
    }

    public function columns(): array
    {
        return [
            Column::make("Queued At", "queued_at")
                ->sortable()
                ->searchable(),

            Column::make("Patient Name")
                ->label(fn($row) => $this->getPatientName($row)) // Display full name
                ->searchable(), // Make it searchable if needed

                Column::make("Doctor Name")
                ->label(fn($row) => $this->getDoctorName($row)) // Display full name
                ->searchable(fn(Builder $query, $searchTerm) => $query->where(function ($query) use ($searchTerm) {
                    $query->where('first_name', 'like', "%{$searchTerm}%")
                          ->orWhere('middle_name', 'like', "%{$searchTerm}%")
                          ->orWhere('last_name', 'like', "%{$searchTerm}%");
                })),

            Column::make("Status", "queue_status")
                ->sortable()
                ->searchable(),

            Column::make('Action')
                ->label(
                    fn($row, Column $column) => view('components.livewire.datatables.action-column')->with(
                        [
                            'viewLink' => route('dashboard', $row),
                            'editLink' => route('dashboard', $row),
                            'queue_id' => $row->id,
                        ]
                    )
                )->html(),
        ];
    }

    // Get the patient's information
    public function getPatientName($row)
    {
        // Retrieve the patient using the relationships
        $patient = $row->patient;

        // Check if patient exist
        if ($patient) {
            return $patient->first_name . ' ' . $patient->middle_name . ' ' . $patient->last_name;
        }

        return 'N/A'; // Default value if no names found
    }

    // Get the doctor's information
    public function getDoctorName($row)
    {
        // Retrieve the doctor using the relationships
        $doctor = $row->doctor;

        // Check if doctor exist
        if ($doctor) {
            return $doctor->first_name . ' ' . $doctor->middle_name . ' ' . $doctor->last_name;
        }

        return 'N/A'; // Default value if no names found
    }
}
