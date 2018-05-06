@if ($paginator->hasPages())
<div class="ui pagination menu small">
    @if ($paginator->onFirstPage())
        <div class="disabled item"><i class="fa fa-angle-left"></i></div>
    @else
        <a class="item" href="{{ $paginator->previousPageUrl() }}" rel="prev"><i class="fa fa-angle-left"></i></a>
    @endif

    {{-- Pagination Elements --}}
    @foreach ($elements as $element)
        {{-- "Three Dots" Separator --}}
        @if (is_string($element))
            <div class="disabled item">{{ $element }}</div>
        @endif

        {{-- Array Of Links --}}
        @if (is_array($element))
            @foreach ($element as $page => $url)
                @if ($page == $paginator->currentPage())
                    <a class="active item">{{ $page }}</a>
                @else
                    <a class="item" href="{{ $url }}">{{ $page }}</a>
                @endif
            @endforeach
        @endif
    @endforeach

    {{-- Next Page Link --}}
    @if ($paginator->hasMorePages())
        <a class="item" href="{{ $paginator->nextPageUrl() }}" rel="next"><i class="fa fa-angle-right"></i></a>
    @else
        <div class="disabled item"><i class="fa fa-angle-right"></i></div>
    @endif
</div>
@endif