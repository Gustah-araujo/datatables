<div>
    @if ($paginator->hasPages())

        <div class="grid grid-cols-4 gap-3">

            <div>
                Mostrando {{ $paginator->firstItem() }} a {{ $paginator->lastItem() }} de {{ number_format($paginator->total(), 0, ',', '.') }} resultados
            </div>

            <div class="col-span-3">

                <div class="inline-flex rounded-md shadow-xs float-end" role="group">
                    <button
                        type="button"
                        {{ $paginator->onFirstPage() ? 'disabled' : '' }}
                        {{ $paginator->onFirstPage() ? '' : "wire:click=previousPage" }}
                        @class([
                            'px-4 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-s-lg hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:hover:text-white dark:hover:bg-gray-700 dark:focus:ring-blue-500 dark:focus:text-white',
                            'opacity-50 cursor-not-allowed' => $paginator->onFirstPage(),
                            'cursor-pointer' => !$paginator->onFirstPage(),
                        ])
                    >
                        <i class="fa-solid fa-angles-left"></i>
                    </button>

                    @foreach ($elements as $element)

                        {{-- "Three Dots" Separator --}}
                        @if (is_string($element))
                            <button type="button" class="px-4 py-2 text-sm font-medium text-gray-900 bg-white border-t border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700 dark:text-white">
                                {{ $element }}
                            </button>
                        @endif

                        {{-- Array Of Links --}}
                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                <button
                                    type="button"
                                    @class([
                                        "px-4 py-2 text-sm font-medium text-gray-900 bg-white border-t border-b border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:hover:text-white dark:hover:bg-gray-700 dark:focus:ring-blue-500 dark:focus:text-white",
                                        'opacity-50 cursor-not-allowed' => $page === $paginator->currentPage(),
                                        'cursor-pointer' => $page != $paginator->currentPage(),
                                    ])
                                    {{ $page == $paginator->currentPage() ? 'disabled' : '' }}
                                    {{ $page == $paginator->currentPage() ? '' : "wire:click=gotoPage($page)" }}
                                >
                                    {{ $page }}
                                </button>
                            @endforeach
                        @endif


                    @endforeach

                    <button
                        type="button"
                        {{ $paginator->onLastPage() ? 'disabled' : '' }}
                        {{ $paginator->onLastPage() ? '' : "wire:click=nextPage" }}
                        @class([
                            "px-4 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-e-lg hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:hover:text-white dark:hover:bg-gray-700 dark:focus:ring-blue-500 dark:focus:text-white",
                            'opacity-50 cursor-not-allowed' => $paginator->onLastPage(),
                            'cursor-pointer' => !$paginator->onLastPage(),
                        ])
                    >
                        <i class="fa-solid fa-angles-right"></i>
                    </button>
                </div>

            </div>

        </div>

    @endif
</div>