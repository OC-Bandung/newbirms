@if ($paginator->lastPage() > 1)
<div class="mdc-card__actions">
            <div class="mdc-card__action-buttons">
<ul class="pagination vertical">
    <li class="{{ ($paginator->currentPage() == 1) ? ' disabled' : '' }}">
        <a href="{{ $paginator->url(1) }}"  class="mdc-button mdc-card__action mdc-card__action--button"><i class="material-icons mdc-button__icon">fast_rewind</i></a>
    </li>
    @for ($i = 1; $i <= $paginator->lastPage(); $i++)
        <li class="{{ ($paginator->currentPage() == $i) ? ' active' : '' }}">
            <a href="{{ $paginator->url($i) }}" class="mdc-button mdc-card__action mdc-card__action--button">{{ $i }}</a>
        </li>
    @endfor
    <li class="{{ ($paginator->currentPage() == $paginator->lastPage()) ? ' disabled' : '' }}">
        <a href="{{ $paginator->url($paginator->currentPage()+1) }}" class="mdc-button mdc-card__action mdc-card__action--button"><i class="material-icons mdc-button__icon">fast_forward</i></a>
    </li>
</ul>
	</div>
</div>	
@endif