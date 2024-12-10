<?php

namespace App\Livewire;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\PreRegisteredPatient;
use Illuminate\Database\Eloquent\Builder;

class PreRegTable extends DataTableComponent
{
    protected $model = PreRegisteredPatient::class;

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
            Column::make("Code", "pre_registration_code")
                ->sortable()
                ->searchable(),

            Column::make("Full Name")
                ->label(fn($row) => "{$row->last_name}, {$row->first_name} {$row->middle_name}")
                ->sortable(fn($builder, $direction) => $builder->orderBy('last_name', $direction))
                ->searchable(
                    fn(Builder $query, $searchTerm) =>
                    $query->orWhere('first_name', 'like', '%' . trim($searchTerm) . '%')
                        ->orWhere('middle_name', 'like', '%' . trim($searchTerm) . '%')
                        ->orWhere('last_name', 'like', '%' . trim($searchTerm) . '%')
                ),

            Column::make("Birthdate", "birthdate")
                ->sortable()
                ->searchable(),

            Column::make("Sex", "sex")
                ->sortable()
                ->searchable(),

            Column::make('Action')
                ->label(
                    fn($row, Column $column) => view('components.livewire.datatables.action-column')->with(
                        [
                            'viewLink' => route('users.pre-reg.show', ['user_id' => $row->pre_registration_code]),
                            'editLink' => route('dashboard', $row),
                            'deleteLink' => route('users.pre-reg.destroy', ['user_id' => $row->pre_registration_code]), // Pass dynamic delete link
                            'user_id' => $row->pre_registration_code,
                        ]
                    )
                )->html(),
        ];
    }
}
