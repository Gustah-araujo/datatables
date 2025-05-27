<th
    wire:click="doSort('{{ $column->getName() }}')"
    @class([
        "cursor-pointer px-4 py-2",
    ])
>
    {{ $column->getLabel() }}
    {!! $column->getName() != $this->sortColumn ? "<i class=\"fa-regular fa-square-caret-up\"></i>" : ($this->sortDirection === 'asc' ? "<i class=\"fa-solid fa-square-caret-up\"></i>" : "<i class=\"fa-solid fa-square-caret-down\"></i>") !!}
</th>