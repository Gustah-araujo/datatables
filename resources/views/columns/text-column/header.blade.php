<th class="cursor-pointer" wire:click="doSort('{{ $column->getName() }}')">
    {{ $column->getLabel() }}
    {!! $column->getName() != $this->sortColumn ? "<i class=\"fa-regular fa-square-caret-up\"></i>" : ($this->sortDirection === 'asc' ? "<i class=\"fa-solid fa-square-caret-up\"></i>" : "<i class=\"fa-solid fa-square-caret-down\"></i>") !!}
</th>