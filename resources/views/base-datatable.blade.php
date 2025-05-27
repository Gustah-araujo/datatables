<div class="!w-full grid">

    <div @class([
        // Light Styles
        "bg-gray-200 text-black",
        // Dark Styles
        "dark:bg-gray-900 dark:text-white",
        "text-center rounded-tl-lg rounded-tr-lg p-2 text-xl font-bold",
    ])>
        &nbsp;
    </div>

    <table class="!w-full !min-w-full !max-w-full">
        <thead>
            <tr @class([
                // Light Styles
                "bg-gray-300 text-black",
                // Dark Styles
                "dark:bg-gray-600 dark:text-white",
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
                    "dark:odd:bg-gray-800 dark:even:bg-gray-900 dark:text-white dark:hover:bg-gray-700",
                ])>
                    @foreach ($this->columns() as $column)
                        {!! $column->renderRow($item) !!}
                    @endforeach
                </tr>
            @empty

            @endforelse
        </tbody>
    </table>

    <div @class([
        // Light Styles
        "bg-gray-300 text-black",
        // Dark Styles
        "dark:bg-gray-600 dark:text-white",
        "text-center rounded-bl-lg rounded-br-lg p-2 text-xl font-bold",
    ])>
        {!! $this->paginationLinks() !!}
    </div>

</div>
