<section>
        <div class="mdc-layout-grid">
            <div class="mdc-layout-grid__inner">
                <div class="mdc-layout-grid__cell mdc-layout-grid__cell--span-6">
                    <div class="mdc-typography--display1">@lang('homepage.news_title')</div>
                </div>
            </div>
        </div>
        <div class="mdc-layout-grid">
            <div class="mdc-layout-grid__inner">
                @foreach ($article as $idx => $row)
                    <div class="mdc-layout-grid__cell">
                        <section class="mdc-layout__primary mdc-layout-grid__cell--span-4 blog-{{ $idx % 4 + 1 }}">
                          <h2 class="mdc-layout__title mdc-layout__title--large"><a href='{{ url("post")}}/{{ $row->pst_id }}'>{{ $row->title }}</a></h2>
                          <h4 class="mdc-layout__subtitle">{{ MyGlobals::indo_date($row->created) }}</h4>
                          <p align="justify">{{ $row->summary }}</p>
                        </section>
                        <section class="mdc-layout__actions">
                          <button class="mdc-button mdc-button--compact mdc-layout__action" onclick="javascript:location.href='post/{{ $row->pst_id }}'">Selengkapnya</button>
                        </section>
                      </div>    
 
                @endforeach
            </div>
        </div>
    </section>