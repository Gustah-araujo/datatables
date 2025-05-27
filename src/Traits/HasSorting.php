<?php

namespace GustahAraujo\Datatables\Traits;

use Illuminate\Support\Collection;
use Illuminate\Contracts\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Contracts\Database\Query\Builder as QueryBuilder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @mixin \GustahAraujo\Datatables\BaseDatatable
 */
trait HasSorting
{
    public function doSort(string $column)
    {
        if ($this->sortColumn === $column) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
        }

        $this->sortColumn = $column;
    }

    public function applySorting(EloquentBuilder|QueryBuilder|array|Collection $query)
    {
        switch (true) {
            case $query instanceof EloquentBuilder:
                $this->applySortingToEloquentBuilder($query);
                break;

            case $query instanceof QueryBuilder:
                $this->applySortingToQueryBuilder($query);
                break;

            case $query instanceof Collection:
                $this->applySortingToCollection($query);
                break;

            case is_array($query):
                $query = collect($query);
                $this->applySortingToCollection($query);
                break;

            default:
                throw new \Exception("How did we get here?", 1);
                break;
        }
    }

    private function applySortingToEloquentBuilder(EloquentBuilder $query)
    {
        $parts = explode('.', $this->sortColumn);
        $baseModel = $query->getModel();
        $baseTable = $baseModel->getTable();

        $currentModel = $query->getModel();
        $lastAlias = $baseTable;

        $column = array_pop($parts);

        if (!empty($parts)) {
            foreach ($parts as $index => $part) {

                $relation = $currentModel->{$part}();
                $relatedModel = $relation->getRelated();
                $relatedTable = $relatedModel->getTable();

                $alias = $relatedModel->getTable() . '_' . $index;

                switch (true) {
                    case $relation instanceof BelongsTo:
                        // BelongsTo: parent_table.local_key = child_table.foreign_key
                        $query->leftJoin(
                            "{$relatedTable} as {$alias}",
                            "{$lastAlias}.{$relation->getForeignKeyName()}",
                            '=',
                            "{$alias}.{$relation->getOwnerKeyName()}"
                        );
                        break;

                    case $relation instanceof HasOne || $relation instanceof HasMany:
                        // HasOne/HasMany: parent_table.local_key = child_table.foreign_key
                        $query->leftJoin(
                            "{$relatedTable} as {$alias}",
                            "{$lastAlias}.{$relation->getLocalKeyName()}",
                            '=',
                            "{$alias}.{$relation->getForeignKeyName()}"
                        );
                        break;

                    case $relation instanceof BelongsToMany:
                        // BelongsToMany requires joining through pivot table
                        $pivotTable = $relation->getTable();
                        $pivotAlias = $pivotTable . '_pivot_' . $index;

                        // Join pivot table
                        $query->leftJoin(
                            "{$pivotTable} as {$pivotAlias}",
                            "{$lastAlias}.{$relation->getParentKeyName()}",
                            '=',
                            "{$pivotAlias}.{$relation->getForeignPivotKeyName()}"
                        );

                        // Join related table
                        $query->leftJoin(
                            "{$relatedTable} as {$alias}",
                            "{$pivotAlias}.{$relation->getRelatedPivotKeyName()}",
                            '=',
                            "{$alias}.{$relation->getRelatedKeyName()}"
                        );
                        break;
                    default:
                        throw new \Exception("How did we get here?", 1);

                        break;
                }

                $lastAlias = $alias;
                $currentModel = $relatedModel;
            }

            $query->orderBy("{$lastAlias}.{$column}", $this->sortDirection);
        } else {
            $query->orderBy("{$query->getModel()->getTable()}.{$this->sortColumn}", $this->sortDirection);
        }
    }

    private function applySortingToQueryBuilder(QueryBuilder $query)
    {
        $query->orderBy("{$query->getTable()}.{$this->sortColumn}", $this->sortDirection);
    }

    private function applySortingToCollection(Collection $collection)
    {
        $collection->sortBy($this->sortColumn, SORT_REGULAR, $this->sortDirection === 'desc');
    }
}