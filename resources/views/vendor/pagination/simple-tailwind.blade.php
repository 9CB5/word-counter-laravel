@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="flex gap-4 justify-start">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <span class="relative inline-flex items-center p-4 text-gray-500 bg-cyan-200 cursor-pointer leading-5 rounded-xl">
                {!! __('pagination.previous') !!}
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="relative inline-flex items-center p-4 text-gray-500 bg-cyan-200 cursor-pointer leading-5 rounded-xl">
                {!! __('pagination.previous') !!}
            </a>
        @endif

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="relative inline-flex items-center p-4 text-gray-500 bg-cyan-200 cursor-pointer leading-5 rounded-xl">
                {!! __('pagination.next') !!}
            </a>
        @else
            <span class="relative inline-flex items-center p-4 text-gray-500 bg-cyan-200 cursor-pointer leading-5 rounded-xl">
                {!! __('pagination.next') !!}
            </span>
        @endif
    </nav>
@endif
