<?php

namespace App\Livewire;

use App\Models\MedicalRecord;
use Carbon\Carbon;
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

        if ($user->role === 'admin') {
            // Return all records if the user is an admin
            return $query;
        }

        // Filter the queue based on the user's role
        return $query->whereBelongsTo($user, $user->role);
    }

    public function columns(): array
    {
        $patientName = fn($row) => $this->getPatientName($row);
        $doctorName = fn($row) => $this->getDoctorName($row);
        $columns = [
            Column::make("Date", "created_at")
                ->format(fn($value) => Carbon::parse($value)->format('Y-m-d')) // Format the date
                ->sortable(),

            // show doctor column if the user is a patient
            Column::make("Action")
                ->label(
                    fn($row, Column $column) => view('components.livewire.action-columns.medical-record')->with(
                        [
                            'viewLink' => route('medical-record.show', ['ulid' => $row->ulid]),
                            'id' => $row->id,
                        ]
                    )->render()
                )->html(),
        ];

        $user = Auth::user();
        // Add the "Doctor" column if the user is a patient
        if ($user->role === 'patient') {
            array_splice($columns, count($columns) - 1, 0, [
                Column::make("Doctor")
                    ->label($doctorName) // Display full name
                    ->sortable(fn($builder, $direction) => $builder->orderBy('last_name', $direction))
                    ->searchable(),
            ]);
        } else {
            array_splice($columns, count($columns) - 1, 0, [
                Column::make("Doctor")
                    ->label($doctorName) // Display full name
                    ->sortable(fn($builder, $direction) => $builder->orderBy('last_name', $direction))
                    ->searchable(),
                Column::make("Patient")
                    ->label($patientName) // Display full name
                    ->sortable(fn($builder, $direction) => $builder->orderBy('last_name', $direction))
                    ->searchable(),
            ]);
        }

        return $columns;
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
