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
                ->format(fn($value) => \Carbon\Carbon::parse($value)->format('M d, Y'))
                ->sortable()
                ->searchable(function (Builder $query, $term) {
                    $term = strtolower(trim($term));
            
                    $months = [
                        'jan' => '01', 'january' => '01',
                        'feb' => '02', 'february' => '02',
                        'mar' => '03', 'march' => '03',
                        'apr' => '04', 'april' => '04',
                        'may' => '05',
                        'jun' => '06', 'june' => '06',
                        'jul' => '07', 'july' => '07',
                        'aug' => '08', 'august' => '08',
                        'sep' => '09', 'september' => '09',
                        'oct' => '10', 'october' => '10',
                        'nov' => '11', 'november' => '11',
                        'dec' => '12', 'december' => '12',
                    ];
            
                    if (array_key_exists($term, $months)) {
                        $query->orWhereMonth('created_at', $months[$term]);
                    }
            
                    // Optional: also allow basic string matching (if users type 2025 or 01)
                    $query->orWhereDate('created_at', 'like', "%$term%");
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
