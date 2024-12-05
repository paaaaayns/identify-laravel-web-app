<?php

namespace App\Livewire;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Doctor;

class DoctorTable extends DataTableComponent
{
    protected $model = Doctor::class;

    protected $listeners = ['refreshTable' => '$refresh'];  // Listen for the event and refresh the table

    public function configure(): void
    {
        $this->setPrimaryKey('id')
            ->setDefaultSort('created_at', 'desc')
            ->setRefreshTime(60000) // Component refreshes every 60 seconds
            ->setPerPageAccepted([10, 25, 50, 100, -1]) // Options for pagination
            ->setAdditionalSelects(['first_name', 'middle_name', 'last_name']) // Additional columns to select
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
            Column::make("UID", "user_id")
                ->sortable()
                ->searchable(),

            // Combine first_name, middle_name, and last_name into a single "Full Name" column
            Column::make("Full Name")
                ->label(fn($row) => "{$row->first_name} {$row->middle_name} {$row->last_name}")
                ->searchable(
                    fn($builder, $term) => $builder->where(function ($query) use ($term) {
                        $query->where('first_name', 'like', "%{$term}%")
                            ->orWhere('middle_name', 'like', "%{$term}%")
                            ->orWhere('last_name', 'like', "%{$term}%");
                    })
                )
                ->sortable(fn($builder, $direction) => $builder->orderBy('last_name', $direction)),

            Column::make("Type", "Type")
                ->sortable()
                ->searchable(),

            Column::make("Room", "room")
                ->sortable()
                ->searchable(),

            Column::make('Action')
                ->label(
                    fn($row, Column $column) => view('components.livewire.datatables.action-column')->with(
                        [
                            'viewLink' => route('dashboard', $row),
                            'editLink' => route('dashboard', $row),
                            'deleteLink' => route('users.doctor.destroy', ['user_id' => $row->user_id]), // Pass dynamic delete link
                            'user_id' => $row->user_id,
                        ]
                    )
                )->html(),


        ];
    }
}
