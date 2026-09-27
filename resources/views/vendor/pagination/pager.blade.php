@if ($paginator->hasPages())
    @if (! $paginator->onFirstPage())
        <a href="{{ $paginator->previousPageUrl() }}">‹</a>
    @else
        <span class="dots">‹</span>
    @endif

    @foreach ($elements as $element)
        @if (is_string($element))
            <span class="dots">{{ $element }}</span>
        @endif

        @if (is_array($element))
            @foreach ($element as $page => $url)
                @if ($page == $paginator->currentPage())
                    <span class="on">{{ $page }}</span>
                @else
                    <a href="{{ $url }}">{{ $page }}</a>
                @endif
            @endforeach
        @endif
    @endforeach

    @if ($paginator->hasMorePages())
        <a href="{{ $paginator->nextPageUrl() }}">›</a>
    @else
        <span class="dots">›</span>
    @endif
@endif