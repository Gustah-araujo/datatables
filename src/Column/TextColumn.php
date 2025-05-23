<?php

namespace GustahAraujo\Datatables\Column;

use Illuminate\Contracts\View\View as ViewView;
use Illuminate\Support\Facades\View;

class TextColumn extends BaseColumn
{
    public final function renderHeader(): string|ViewView
    {
        return View::first(
            [
                'datatables.columns.text-column.header',
                'datatables::columns.text-column.header',
            ],
            [
                'column' => $this,
            ]
        );
    }

    public final function renderRow($item): string|ViewView
    {
        return View::first(
            [
                'datatables.columns.text-column.row',
                'datatables::columns.text-column.row',
            ],
            [
                'column' => $this,
                'item' => $item,
            ]
        );
    }
}
