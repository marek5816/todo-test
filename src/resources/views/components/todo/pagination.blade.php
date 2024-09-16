<nav aria-label="Page navigation example" class="mt-4">
    <ul class="pagination">
        @php
            $query = request()->except('page');
            $queryString = http_build_query($query);
        @endphp

        @if ($collection->onFirstPage())
            <li class="page-item disabled"><span class="page-link">Previous</span></li>
        @else
            <li class="page-item"><a class="page-link" href="{{ $collection->previousPageUrl() }}{{ $queryString ? '&' . $queryString : '' }}">Previous</a></li>
        @endif

        @for ($i = 1; $i <= $collection->lastPage(); $i++)
            <li class="page-item {{ $collection->currentPage() == $i ? 'active disabled' : '' }}">
                <a class="page-link" href="{{ $collection->url($i) }}{{ $queryString ? (strpos($collection->url($i), '?') === false ? '?' : '&') . $queryString : '' }}">{{ $i }}</a>
            </li>
        @endfor

        @if ($collection->hasMorePages())
            <li class="page-item"><a class="page-link" href="{{ $collection->nextPageUrl() }}{{ $queryString ? '&' . $queryString : '' }}">Next</a></li>
        @else
            <li class="page-item disabled"><span class="page-link">Next</span></li>
        @endif
    </ul>
</nav>
