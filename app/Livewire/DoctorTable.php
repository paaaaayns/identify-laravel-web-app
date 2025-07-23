<?php

namespace App\Livewire;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Doctor;
use Illuminate\Database\Eloquent\Builder;

class DoctorTable extends DataTableComponent
{
    protected $model = Doctor::class;

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

    public function columns(): array
    {
        return [
            Column::make("UID", "user_id")
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

            Column::make("Type", "Type")
                ->sortable()
                ->searchable(),

            Column::make("Room", "room")
                ->sortable()
                ->searchable(),

            Column::make('Action')
                ->label(
                    fn($row, Column $column) => view('components.livewire.action-columns.default')->with(
                        [
                            'viewLink' => route('users.doctor.show', ['ulid' => $row->ulid]),
                            'deleteLink' => route('users.doctor.destroy', ['user_id' => $row->user_id]),
                            'id' => $row->id,
                        ]
                    )
                )->html(),
        ];
    }
}
