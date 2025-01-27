<?php

namespace App\Livewire;

use App\Models\PatientQueue;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
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

        $this->setTableWrapperAttributes([
            'class' => 'overflow-x-auto',
        ]);
        $this->setTheadAttributes([
            'class' => 'relative'
        ]);
    }

    // Add the refreshTable method
    public function refreshTable()
    {
        $this->emitSelf('refresh'); // Trigger the table refresh
    }

    public function builder(): Builder
    {
        $query = PatientQueue::query()
            ->whereNotIn('queue_status', ['Cancelled', 'Completed'])
            ->with(['patient', 'doctor', 'opd']); // Eager load the relationships

        $user = Auth::user();

        if ($user->role !== 'admin') {
            // Filter the queue based on the user's role
            // and queue status is not cancelled or completed
            $query->whereBelongsTo($user, $user->role);
        }

        return $query;
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
                        'Assessment Done' => 'bg-blue-500 text-white',
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
                    fn($row, Column $column) => view('components.livewire.action-columns.queue')->with(
                        [
                            'viewLinkOngoing' => route('queue.show', ['ulid' => $row->ulid]),
                            'viewLinkCompleted' => $row->medicalRecord
                                ? route('medical-record.show', ['ulid' => $row->medicalRecord->ulid])
                                : null,
                            'deleteLink' => route('queue.destroy', ['ulid' => $row->ulid]),
                            'id' => $row->id,
                            'queue_id' => $row->id,
                            'queue' => $row,
                        ]
                    )->render()
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
