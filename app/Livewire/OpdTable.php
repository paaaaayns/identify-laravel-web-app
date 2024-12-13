<?php

namespace App\Livewire;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Opd;
use Illuminate\Database\Eloquent\Builder;

class OpdTable extends DataTableComponent
{
    protected $model = Opd::class;

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
        return [
            Column::make("UID", "user_id")
                ->sortable()
                ->searchable(),

            // Combine first_name, middle_name, and last_name into a single "Full Name" column
            Column::make("Full Name")
                ->label(fn($row) => "{$row->last_name}, {$row->first_name} {$row->middle_name}")
                ->sortable(fn($builder, $direction) => $builder->orderBy('last_name', $direction))
                ->searchable(
                    fn(Builder $query, $searchTerm) =>
                    $query->orWhere('first_name', 'like', '%' . trim($searchTerm) . '%')
                        ->orWhere('middle_name', 'like', '%' . trim($searchTerm) . '%')
                        ->orWhere('last_name', 'like', '%' . trim($searchTerm) . '%')
                ),

            Column::make("Type", "Type")
                ->sortable()
                ->searchable(),

            Column::make('Action')
                ->label(
                    fn($row, Column $column) => view('components.livewire.datatables.action-column')->with(
                        [
                            'viewLink' => route('users.opd.show', ['ulid' => $row->ulid]), // Pass the ULID to the route
                            'deleteLink' => route('users.opd.destroy', ['user_id' => $row->user_id]), // Pass the USER_ID to the route
                            'id' => $row->id, 
                        ]
                    )
                )->html(),
        ];
    }
}
