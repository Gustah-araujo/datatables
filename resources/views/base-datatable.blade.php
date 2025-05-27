<div>

    @once
        <style>
            /* table {
                border-collapse: collapse;
                width: 100%;
            } */
        </style>
    @endonce

    <div class="grid gap-3">

        <table class="!w-full !min-w-full !max-w-full border">
            <thead>
                <tr @class([
                    // Light Styles
                    "bg-gray-400 text-black",
                    // Dark Styles
                    "dark:bg-gray-800 dark:text-white",
                ])>
                    @foreach ($this->columns() as $column)
                        {!! $column->renderHeader() !!}
                    @endforeach
                </tr>
            </thead>

            <tbody>
                @forelse ($this->data as $item)
                    <tr @class([
                        "transition",
                        // Light Styles
                        "odd:bg-gray-50 even:bg-gray-200 text-black hover:bg-gray-400",
                        // Dark Styles
                        "dark:odd:bg-gray-500 dark:even:bg-gray-700 dark:text-white dark:hover:bg-gray-900",
                    ])>
                        @foreach ($this->columns() as $column)
                            {!! $column->renderRow($item) !!}
                        @endforeach
                    </tr>
                @empty

                @endforelse
            </tbody>
        </table>

        <div>
            {!! $this->paginationLinks() !!}
        </div>
    </div>

</div>
