<?php

namespace App\Livewire;

use App\Models\MedicalRecord;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

class MedicalRecordTable extends DataTableComponent
{
    protected $model = MedicalRecord::class;

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

    public function builder(): Builder
    {
        $query = MedicalRecord::query()
            ->with(['patient', 'doctor', 'opd']); // Eager load the relationships

        $user = Auth::user();

        if ($user->role === 'patient') {
            // Filter the queue based on the user's role
            $query->whereBelongsTo($user, $user->role);
        }

        return $query;
    }

    public function columns(): array
    {
        // $patientName = fn($row) => $this->getPatientName($row);
        $doctorName = fn($row) => $this->getDoctorName($row);
        return [
            Column::make("Date", "created_at")
                ->sortable(),

            Column::make("MRID", "medical_record_id")
                ->sortable(),

            Column::make("Doctor")
                ->label($doctorName) // Display full name
                ->sortable(fn($builder, $direction) => $builder->orderBy('last_name', $direction))
                ->searchable(), // TODO: Implement the search functionality

            Column::make('Action') // TODO: Implement the action column
                ->label(
                    fn($row, Column $column) => view('components.livewire.action-columns.medical-record')->with(
                        [
                            'viewLink' => route('queue.show', ['ulid' => $row->ulid]),
                            'deleteLink' => route('queue.destroy', ['ulid' => $row->ulid]),
                            'id' => $row->id,
                            'queue_id' => $row->id,
                        ]
                    )->render()
                )->html(),
        ];
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
