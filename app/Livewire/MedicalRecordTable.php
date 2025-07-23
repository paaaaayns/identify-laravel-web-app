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

    public function builder(): Builder
    {
        $query = MedicalRecord::query()
            ->with(['patient', 'doctor', 'opd']);

        $user = Auth::user();

        if ($user->role === 'admin') {
            return $query;
        }

        return $query->whereBelongsTo($user, $user->role);
    }

    public function columns(): array
    {
        $patientName = fn($row) => $this->getPatientName($row);
        $doctorName = fn($row) => $this->getDoctorName($row);
        $columns = [
            Column::make("Date", "created_at")
                ->format(fn($value) => \Carbon\Carbon::parse($value)->format('M d, Y'))
                ->sortable()
                ->searchable(function (Builder $query, $term) {
                    $term = strtolower(trim($term));

                    $months = [
                        'jan' => '01',
                        'january' => '01',
                        'feb' => '02',
                        'february' => '02',
                        'mar' => '03',
                        'march' => '03',
                        'apr' => '04',
                        'april' => '04',
                        'may' => '05',
                        'jun' => '06',
                        'june' => '06',
                        'jul' => '07',
                        'july' => '07',
                        'aug' => '08',
                        'august' => '08',
                        'sep' => '09',
                        'september' => '09',
                        'oct' => '10',
                        'october' => '10',
                        'nov' => '11',
                        'november' => '11',
                        'dec' => '12',
                        'december' => '12',
                    ];

                    if (array_key_exists($term, $months)) {
                        $query->orWhereMonth('created_at', $months[$term]);
                    }

                    $query->orWhereDate('created_at', 'like', "%$term%");
                }),

            Column::make("Action")
                ->label(
                    fn($row, Column $column) => view('components.livewire.action-columns.medical-record')->with(
                        [
                            "record_ulid" => $row->ulid,
                        ]
                    )->render()
                )->html(),
        ];

        $user = Auth::user();

        if ($user->role === 'patient') {
            array_splice($columns, count($columns) - 1, 0, [
                Column::make("Doctor")
                    ->label($doctorName)
                    ->searchable(function (Builder $query, string $searchTerm) {
                        $searchTerm = "%{$searchTerm}%";
                        $query->orWhereHas('patient', function (Builder $q) use ($searchTerm) {
                            $q->where('first_name', 'like', $searchTerm)
                                ->orWhere('middle_name', 'like', $searchTerm)
                                ->orWhere('last_name', 'like', $searchTerm);
                        });
                    }),
            ]);
        } else {
            array_splice($columns, count($columns) - 1, 0, [
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
            ]);
        }

        return $columns;
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
