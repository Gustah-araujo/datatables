<?php

namespace GustahAraujo\Datatables;

use GustahAraujo\Datatables\Traits\HasSorting;
use Illuminate\Contracts\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Contracts\Database\Query\Builder as QueryBuilder;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;

abstract class BaseDatatable extends Component
{
    use HasSorting, WithPagination;

    public string|null $sortColumn = null;
    public string $sortDirection = 'asc';

    public function mount(array|null $attributes = null)
    {

    }

    abstract public function query(): EloquentBuilder|QueryBuilder|array|Collection;
    abstract public function columns(): array;

    private function getData()
    {
        $query = $this->query();

        $this->applySorting($query);

        switch (true) {
            case $query instanceof EloquentBuilder || $query instanceof QueryBuilder:
                return $query->select("{$query->getModel()->getTable()}.*")->paginate(10)->onEachSide(2);
                break;

            case $query instanceof Collection:
                return $query->take(10);
                break;

            case is_array($query):
                return collect($query)->take(10);
                break;

            default:
                throw new \Exception("How did we get here?", 1);
                break;
        }
    }

    #[Computed]
    public function data()
    {
        return $this->getData();
    }


    public final function render()
    {
        return view('datatables::base-datatable');
    }
}
