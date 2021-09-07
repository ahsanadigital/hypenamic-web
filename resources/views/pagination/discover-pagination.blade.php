@if ($paginator->hasPages())
{{-- For Mobile Nav --}}
<div class="d-flex d-lg-none justify-content-center">
    <ul class="pagination justify-content-center">
        @php
            $data = Request::except('page');
        @endphp
        <li class="page-item{{ $paginator->onFirstPage() ? ' disabled' : '' }}"><a href="{{ $paginator->onFirstPage() ? '#' : "{$paginator->previousPageUrl()}" }}" class="page-link"><i class="fas fa-chevron-left fa-fw"></i></a></li>
        <li class="page-item disabled"><span class="page-link">Halaman {{ $paginator->currentPage() }} dari {{ $paginator->lastPage() }}</span></li>
        <li class="page-item{{ $paginator->currentPage() == $paginator->lastPage() ? ' disabled' : '' }}"><a href="{{ $paginator->currentPage() == $paginator->lastPage() ? '#' : "{$paginator->nextPageUrl()}" }}" class="page-link"><i class="fas fa-chevron-right fa-fw"></i></a></li>
    </ul>
</div>

{{-- For Desktop Nav --}}
<div class="d-lg-flex d-none d-md-none justify-content-between">
    <div class="left-side">
        <p class="m-0">Menampilkan halaman {{ $paginator->currentPage() }} dari total {{ $paginator->lastPage() }} halaman.</p>
    </div>
    <div class="right-side">
        <nav  aria-label="Pagination for discover events">
            <ul class="pagination">
                {{-- Previous Page Link --}}
                @if ($paginator->onFirstPage())
                    <li data-id="1" class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                        <span class="page-link" aria-hidden="true"><i class="fas fa-chevron-left fa-fw"></i><span class="sr-only">Kembali</span></span>
                    </li>
                @else
                    <li data-id="2" class="page-item">
                        <a class="page-link" href="{{ "{$paginator->previousPageUrl()}" }}" rel="next" aria-label="@lang('pagination.next')"><i class="fas fa-chevron-left fa-fw"></i><span class="sr-only">Kembali</span></a>
                    </li>
                @endif

                {{-- Pagination Elements --}}
                @foreach ($elements as $element)
                    {{-- "Three Dots" Separator --}}
                    @if (is_string($element))
                        <li data-id="3" class="page-item disabled" aria-disabled="true"><span class="page-link">{{ $element }}</span></li>
                    @endif

                    {{-- Array Of Links --}}
                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <li data-id="4" class="page-item" aria-current="page"><span class="page-link active">{{ $page }}</span></li>
                            @else
                                <li data-id="5" class="page-item"><a class="page-link" href="{{ "{$url}" }}">{{ $page }}</a></li>
                            @endif
                        @endforeach
                    @endif
                @endforeach

                {{-- Next Page Link --}}
                @if ($paginator->hasMorePages())
                    <li data-id="6" class="page-item">
                        <a class="page-link" href="{{ "{$paginator->nextPageUrl()}" }}" rel="next" aria-label="@lang('pagination.next')"><span class="sr-only">Lanjut</span><i class="fas fa-chevron-right fa-fw"></i></a>
                    </li>
                @else
                    <li data-id="7" class="disabled page-item" aria-disabled="true" aria-label="@lang('pagination.next')">
                        <span class="page-link" aria-hidden="true"><span class="sr-only">Lanjut</span><i class="fas fa-chevron-right fa-fw"></i></span>
                    </li>
                @endif
            </ul>
        </nav>
    </div>
</div>
@else
@endif
