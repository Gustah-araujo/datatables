<td
    @class([
        "px-4 py-2 text-black dark:text-white",
        "group/last-row:last:rounded-br-2xl group/last-row:first:rounded-tl-2xl",
    ])
>
    {{ data_get($item, $column->getName()) }}
</td>