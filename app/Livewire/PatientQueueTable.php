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
            ->setDefaultSort('queued_at', 'desc')
            ->setRefreshTime(60000) // Component refreshes every 60 seconds
            ->setPerPageAccepted([10, 25, 50, 100, -1]) // Options for pagination
            ->setAdditionalSelects(['*']) // Additional columns to select
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
                ->searchable(), // TODO: Fix search

            Column::make("Doctor Name")
                ->label(fn($row) => $this->getDoctorName($row)) // Display full name
                ->sortable() // TODO: Fix search
                ->searchable(
                    fn(Builder $query, $searchTerm) =>
                    $query->orWhereHas(
                        'doctor',
                        fn($query) =>
                        $query->where('first_name', 'like', '%' . trim($searchTerm) . '%')
                            ->orWhere('middle_name', 'like', '%' . trim($searchTerm) . '%')
                            ->orWhere('last_name', 'like', '%' . trim($searchTerm) . '%')
                    )
                ),


            Column::make("Status", "queue_status")
                ->sortable()
                ->searchable()
                ->label(function ($row) {
                    $statusColors = [
                        'Waiting' => 'bg-yellow-500 text-white',
                        'Vitals Taken' => 'bg-blue-500 text-white',
                        'Consulting' => 'bg-orange-500 text-white',
                        'Completed' => 'bg-green-500 text-white',
                        'Cancelled' => 'bg-red-500 text-white',
                    ];

                    $status = $row->queue_status;
                    $colorClass = $statusColors[$status] ?? 'bg-gray-500 text-white';

                    return '<span class="px-2 py-1 rounded ' . $colorClass . '">' . ucfirst($status) . '</span>';
                })
                ->html(),

            Column::make('Action') // TODO: Implement the action column
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

    // Get the patient's name
    public function getPatientName($row)
    {
        // Retrieve the patient using the relationships
        $patient = $row->patient;

        // Check if patient exist
        if ($patient) {
            return "{$patient->last_name}, {$patient->first_name} {$patient->middle_name}";
        }

        return 'N/A'; // Default value if no names found
    }

    // Get the doctor's name
    public function getDoctorName($row)
    {
        // Retrieve the doctor using the relationships
        $doctor = $row->doctor;

        // Check if doctor exist
        if ($doctor) {
            return "{$doctor->last_name}, {$doctor->first_name} {$doctor->middle_name}";
        }

        return 'N/A'; // Default value if no names found
    }
}
