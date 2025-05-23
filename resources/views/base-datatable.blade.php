<div>

    @once
        <style>
            table {
                border-collapse: collapse;
                width: 100%;
            }

            table, th, td {
                border: 1px solid #444;
            }
        </style>
    @endonce

    This is a test datatable

    <table>
        <thead>
            <tr>
                @foreach ($this->columns() as $column)
                    {!! $column->renderHeader() !!}
                @endforeach
            </tr>
        </thead>

        <tbody>
            @forelse ($this->data as $item)
                <tr>
                    @foreach ($this->columns() as $column)
                        {!! $column->renderRow($item) !!}
                    @endforeach
                </tr>
            @empty

            @endforelse
        </tbody>
    </table>

</div>
