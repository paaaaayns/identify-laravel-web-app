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

    protected $listeners = ['refreshTable' => '$refresh'];

    public function configure(): void
    {
        $this->setPrimaryKey('id')
            ->setDefaultSort('created_at', 'desc')
            ->setRefreshTime(60000)
            ->setPerPageAccepted([10, 25, 50, 100, -1])
            ->setAdditionalSelects(['*'])
            ->setTrimSearchStringEnabled()
        ;

        $this->setTableWrapperAttributes([
            'class' => 'overflow-x-auto',
        ]);

        $this->setTheadAttributes([
            'class' => 'relative'
        ]);
    }

    public function refreshTable()
    {
        $this->emitSelf('refresh');
    }

    public function builder(): Builder
    {
        $query = PatientQueue::query()
            ->whereNotIn('queue_status', ['Cancelled', 'Completed'])
            ->with(['patient', 'doctor', 'opd']);

        $user = Auth::user();

        if ($user->role !== 'admin') {
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

            Column::make("Patient")
                ->label($patientName)
                ->searchable(function (Builder $query, string $searchTerm) {
                    $searchTerm = "%{$searchTerm}%";
                    $query->orWhereHas('patient', function (Builder $q) use ($searchTerm) {
                        $q->where('first_name', 'like', $searchTerm)
                            ->orWhere('middle_name', 'like', $searchTerm)
                            ->orWhere('last_name', 'like', $searchTerm);
                    });
                }),
            Column::make("Doctor")
                ->label($doctorName)
                ->searchable(function (Builder $query, string $searchTerm) {
                    $searchTerm = "%{$searchTerm}%";
                    $query->orWhereHas('doctor', function (Builder $q) use ($searchTerm) {
                        $q->where('first_name', 'like', $searchTerm)
                            ->orWhere('middle_name', 'like', $searchTerm)
                            ->orWhere('last_name', 'like', $searchTerm);
                    });
                }),

            Column::make("Status", "queue_status")
                ->searchable(function (Builder $query, $term) {
                    $query->orWhere('queue_status', 'like', '%' . $term . '%');
                })
                ->label(function ($row) {
                    $statusColors = [
                        'Awaiting Doctor Selection' => 'bg-yellow-500 text-white',
                        'Awaiting Assessment' => 'bg-amber-400 text-white',
                        'Assessing' => 'bg-blue-500 text-white',
                        'Awaiting Consultation' => 'bg-cyan-500 text-white',
                        'Consulting' => 'bg-orange-500 text-white',
                        'Completed' => 'bg-green-500 text-white',
                        'Cancelled' => 'bg-red-500 text-white',
                    ];

                    $status = $row->queue_status;
                    $colorClass = $statusColors[$status] ?? 'bg-gray-500 text-white';

                    return '<span class="px-2 py-1 rounded ' . $colorClass . '">' . e($status) . '</span>';
                })
                ->html(),

            Column::make('Action')
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

    public function getPatientName($row)
    {
        $patient = $row->patient;

        if ($patient) {
            return "{$patient->last_name}, {$patient->first_name} {$patient->middle_name}";
        }

        return 'N/A';
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
