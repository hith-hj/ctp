@if ($paginator->hasPages())
    <div class="toolbox toolbox-pagination justify-content-between">
        <p class="showing-info mb-2 mb-sm-0">
            Showing {{$paginator->count()}} of {{$paginator->total()}} items
        </p>
        <ul class="pagination">
            @if ($paginator->onFirstPage())
                <li class="prev disabled">
                    <a href="#" aria-label="Previous" tabindex="-1" aria-disabled="true">
                        <i class="w-icon-long-arrow-left px-4"> > </i>
                    </a>
                </li>
            @else
                <li class="prev">
                    <a href="{{$paginator->previousPageUrl()}}" aria-label="Previous" tabindex="-1" aria-disabled="true">
                        <i class="w-icon-long-arrow-left px-4"> > </i>
                    </a>
                </li>
            @endif
            @foreach($elements as $element)
                @if (is_string($element))
                        <li class="page-item active">
                            <a class="page-link" href="#">{{$element}}</a>
                        </li>
                @endif
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                                <li class="page-item active">
                                    <a class="page-link" href="#">{{$page}}</a>
                                </li>
                        @else
                                <li class="page-item">
                                    <a class="page-link" href="{{ $url }}">{{$page}}</a>
                                </li>
                        @endif
                    @endforeach
                @endif
            @endforeach
            @if ($paginator->hasMorePages())
                <li class="next">
                    <a href="{{$paginator->nextPageUrl()}}" aria-label="Next">
                        <i class="w-icon-long-arrow-right px-4"> > </i>
                    </a>
                </li>
            @else
                <li class="next disabled">
                    <a aria-label="Next">
                        <i class="w-icon-long-arrow-right px-4"> > </i>
                    </a>
                </li>
            @endif
        </ul>
    </div>
@endif
