@if ($paginator->hasPages())
<nav class="custom-pagination-nav" role="navigation">
    <ul class="custom-pagination">
        {{-- 前へ --}}
        @if ($paginator->onFirstPage())
        <li class="disabled"><span>&lt;</span></li>
        @else
        <li><a href="{{ $paginator->previousPageUrl() }}" rel="prev">&lt;</a></li>
        @endif

        {{-- ページ番号 --}}
        @foreach ($elements as $element)
        @if (is_string($element))
        <li class="disabled"><span>{{ $element }}</span></li>
        @endif

        @if (is_array($element))
        @foreach ($element as $page => $url)
        @if ($page == $paginator->currentPage())
        <li class="active"><span>{{ $page }}</span></li>
        @else
        <li><a href="{{ $url }}">{{ $page }}</a></li>
        @endif
        @endforeach
        @endif
        @endforeach

        {{-- 次へ --}}
        @if ($paginator->hasMorePages())
        <li><a href="{{ $paginator->nextPageUrl() }}" rel="next">&gt;</a></li>
        @else
        <li class="disabled"><span>&gt;</span></li>
        @endif
    </ul>
</nav>
@endif