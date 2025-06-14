<?php

namespace GustahAraujo\Datatables;

use GustahAraujo\Datatables\Traits\HasSorting;
use Illuminate\Contracts\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Contracts\Database\Query\Builder as QueryBuilder;
use Illuminate\Pagination\LengthAwarePaginator;
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

    public function ensureSortColumnIsSet()
    {
        if (is_null($this->sortColumn)) {

            if (method_exists($this, 'getDefaultSortColumn')) {
                $this->sortColumn = $this->getDefaultSortColumn();
            } else {
                $firstColumn = $this->columns()[ array_key_first($this->columns()) ];
                $this->sortColumn = $firstColumn->getName();
            }

        }
    }

    #[Computed]
    public function data()
    {
        return $this->getData();
    }

    public function paginationLinks()
    {
        $data = $this->data();

        switch (true) {
            case $data instanceof LengthAwarePaginator:
                return $data->links('datatables::pagination.query-pagination');
                break;

            default:
                # code...
                break;
        }
    }

    public final function render()
    {
        $this->ensureSortColumnIsSet();

        return view('datatables::base-datatable');
    }
}
