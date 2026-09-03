{{-- Custom paginator view styled to match the Kindi template's own
     ".page-nav-wrap" / ".page-numbers" markup (see public/project.html),
     instead of Laravel's default Tailwind pagination partial. --}}
@if ($paginator->hasPages())
    <div class="page-nav-wrap text-center">
        <ul>
            @if ($paginator->onFirstPage())
                <li class="disabled"><span class="page-numbers style-2"><i class="fa-solid fa-arrow-left"></i></span></li>
            @else
                <li><a class="page-numbers style-2" href="{{ $paginator->previousPageUrl() }}"><i class="fa-solid fa-arrow-left"></i></a></li>
            @endif

            @foreach ($elements as $element)
                @if (is_string($element))
                    <li class="disabled"><span class="page-numbers">{{ $element }}</span></li>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="active"><span class="page-numbers">{{ $page }}</span></li>
                        @else
                            <li><a class="page-numbers" href="{{ $url }}">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            @if ($paginator->hasMorePages())
                <li><a class="page-numbers style-2" href="{{ $paginator->nextPageUrl() }}"><i class="fa-solid fa-arrow-right"></i></a></li>
            @else
                <li class="disabled"><span class="page-numbers style-2"><i class="fa-solid fa-arrow-right"></i></span></li>
            @endif
        </ul>
    </div>
@endif
