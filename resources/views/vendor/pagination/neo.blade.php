@if ($paginator->hasPages())
    <nav class="neo-pagination flex flex-wrap gap-2 items-center" role="navigation" aria-label="{{ __('Pagination Navigation') }}">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <span class="px-3 py-1.5 border-2 border-black font-bold text-sm bg-white opacity-50 inline-flex items-center gap-1 cursor-default">
                ← Prev
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="neo-btn-secondary neo-btn-sm inline-flex items-center gap-1">
                ← Prev
            </a>
        @endif

        {{-- Pagination Elements --}}
        <div class="flex flex-wrap gap-2 items-center">
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <span class="px-3 py-1.5 border-2 border-black font-bold text-sm bg-white inline-flex items-center cursor-default">
                        {{ $element }}
                    </span>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span class="px-3 py-1.5 border-2 border-black font-bold text-sm bg-[#fee440] inline-flex items-center shadow-none translate-x-[2px] translate-y-[2px] cursor-default" aria-current="page">
                                {{ $page }}
                            </span>
                        @else
                            <a href="{{ $url }}" class="px-3 py-1.5 border-2 border-black font-bold text-sm bg-white inline-flex items-center shadow-[2px_2px_0px_0px_rgba(0,0,0,1)] hover:shadow-none hover:translate-x-[2px] hover:translate-y-[2px] transition-all duration-100">
                                {{ $page }}
                            </a>
                        @endif
                    @endforeach
                @endif
            @endforeach
        </div>

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="neo-btn-secondary neo-btn-sm inline-flex items-center gap-1">
                Next →
            </a>
        @else
            <span class="px-3 py-1.5 border-2 border-black font-bold text-sm bg-white opacity-50 inline-flex items-center gap-1 cursor-default">
                Next →
            </span>
        @endif
    </nav>
@endif
