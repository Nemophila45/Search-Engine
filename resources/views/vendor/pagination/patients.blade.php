@if ($paginator->hasPages())
    <div class="border-t border-slate-100 bg-white px-4 py-4 sm:px-6">
        <div class="flex flex-col gap-3 text-sm text-slate-600 sm:flex-row sm:items-center sm:justify-between">
            <div>
                @if ($paginator->firstItem())
                    Showing
                    <span class="font-semibold text-slate-900">{{ $paginator->firstItem() }}</span>
                    to
                    <span class="font-semibold text-slate-900">{{ $paginator->lastItem() }}</span>
                    of
                    <span class="font-semibold text-slate-900">{{ $paginator->total() }}</span>
                    results
                @else
                    Showing <span class="font-semibold text-slate-900">{{ $paginator->count() }}</span> results
                @endif
            </div>

            <nav aria-label="Pagination" class="inline-flex overflow-hidden rounded-2xl border border-slate-200 bg-white text-sm font-semibold text-slate-600 shadow-sm">
                {{-- Previous Page Link --}}
                @if ($paginator->onFirstPage())
                    <span class="px-3 py-2 text-slate-300">‹</span>
                @else
                    <a
                        href="{{ $paginator->previousPageUrl() }}"
                        class="px-3 py-2 transition hover:bg-slate-50"
                        rel="prev"
                    >‹</a>
                @endif

                {{-- Pagination Elements --}}
                @foreach ($elements as $element)
                    {{-- "Three Dots" Separator --}}
                    @if (is_string($element))
                        <span class="border-l border-slate-200 px-3 py-2 text-slate-400">{{ $element }}</span>
                    @endif

                    {{-- Array Of Links --}}
                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <span class="border-l border-slate-200 bg-indigo-500 px-3 py-2 text-white">{{ $page }}</span>
                            @else
                                <a
                                    href="{{ $url }}"
                                    class="border-l border-slate-200 px-3 py-2 text-slate-700 transition hover:bg-slate-50"
                                >{{ $page }}</a>
                            @endif
                        @endforeach
                    @endif
                @endforeach

                {{-- Next Page Link --}}
                @if ($paginator->hasMorePages())
                    <a
                        href="{{ $paginator->nextPageUrl() }}"
                        class="border-l border-slate-200 px-3 py-2 transition hover:bg-slate-50"
                        rel="next"
                    >›</a>
                @else
                    <span class="border-l border-slate-200 px-3 py-2 text-slate-300">›</span>
                @endif
            </nav>
        </div>
    </div>
@endif
