@if ($paginator->lastPage() > 1)
<nav aria-label="Page navigation">
  <ul class="pagination pagination-sm">
    <li class="page-item"><a class="page-link" href="{{ $paginator->url(1) }}">@lang('pagination.previous')</a></li>
    @for ($i = 1; $i <= $paginator->lastPage(); $i++)
    <li class="page-item{{ ($paginator->currentPage() == $i) ? ' active' : '' }}"><a class="page-link" href="{{ $paginator->url($i) }}">{{ $i }}</a></li>
    @endfor
    <li class="page-item"><a class="page-link" href="{{ $paginator->url($paginator->currentPage()+1) }}">@lang('pagination.next')</a></li>
  </ul>
</nav>
@endif