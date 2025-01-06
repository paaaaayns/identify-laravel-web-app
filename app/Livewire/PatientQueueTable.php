<?php

namespace App\Livewire;

use App\Models\PatientQueue;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

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
        $patientName = fn($row) => $this->getPatientName($row);
        $doctorName = fn($row) => $this->getDoctorName($row);
        return [
            Column::make("Queue Id", "queue_id")
                ->sortable()
                ->searchable(),

            Column::make("Patient Name")
                ->label($patientName) // Display full name
                ->sortable(fn($builder, $direction) => $builder->orderBy('last_name', $direction))
                ->searchable(), // TODO: Implement the search functionality

            Column::make("Doctor Name")
                ->label($doctorName) // Display full name
                ->sortable(fn($builder, $direction) => $builder->orderBy('last_name', $direction))
                ->searchable(), // TODO: Implement the search functionality


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
                            'viewLink' => route('queue.show', ['ulid' => $row->ulid]),
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
