<section>
        <div class="mdc-layout-grid">
            <div class="mdc-layout-grid__inner">
                <div class="mdc-layout-grid__cell mdc-layout-grid__cell--span-6">
                    <div class="mdc-typography--headline f300">@lang('homepage.news_title')</div>
                </div>
            </div>
        </div>
        <div class="mdc-layout-grid">
            <div class="mdc-layout-grid__inner">
                @foreach ($article as $idx => $row)
                    <div class="mdc-layout-grid__cell">
                        <section class="mdc-layout__primary mdc-layout-grid__cell--span-4 blog-{{ $idx % 4 + 1 }}">
                          <div class="mdc-typography--subheading1"><a href='{{ url("post")}}/{{ $row->pst_id }}'>{{ $row->title }}</a></div>
                          <div class="mdc-typography--caption">{{ MyGlobals::indo_date($row->created) }}</div>
                          <div class="mdc-typography--body1" align="justify">{{ $row->summary }}</div>
                        </section>
                        <section class="mdc-layout__actions text-center">
                          <button class="mdc-button mdc-button--compact mdc-layout__action" onclick="javascript:location.href='post/{{ $row->pst_id }}'">Selengkapnya</button>
                        </section>
                      </div>    
 
                @endforeach
            </div>
        </div>
    </section>