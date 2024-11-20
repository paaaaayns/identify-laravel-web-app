<?php

namespace App\Livewire;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Opd;

class OpdTable extends DataTableComponent
{
    protected $model = Opd::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id')
            ->setDefaultSort('created_at', 'desc')
            ->setRefreshTime(60000) // Component refreshes every 60 seconds
            ->setPerPageAccepted([10, 25, 50, 100, -1]); // Options for pagination
    }

    public function columns(): array
    {
        return [
            Column::make("UID", "user_id")
                ->sortable()
                ->searchable(),

            Column::make("First Name", "first_name")
                ->sortable()
                ->searchable(),

            Column::make("Type", "Type")
                ->sortable()
                ->searchable(),

            Column::make('Action')
                ->label(
                    fn($row, Column $column) => view('components.livewire.datatables.action-column')->with(
                        [
                            'viewLink' => route('dashboard', $row),
                            'editLink' => route('dashboard', $row),
                            'deleteLink' => route('dashboard', $row),
                        ]
                    )
                )->html(),
        ];
    }
}
