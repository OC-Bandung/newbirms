<section>
        <div class="mdc-layout-grid">
            <div class="mdc-layout-grid__inner f300">
                <div class="mdc-layout-grid__cell mdc-layout-grid__cell--span-4">
                    <div class="mdc-typography--headline f300">
                      @lang('homepage.welcome_title')
                    </div>
                    @lang('homepage.welcome_text')
                </div>
                <div class="mdc-layout-grid__cell mdc-layout-grid__cell--span-8">
                    <section class="section section--nav" id="Zahi">
                        <span class="link-copy"></span>
                        <nav class="nav nav--zahi">
                            @foreach($article as $row)
                             <button class="{{ $loop->first? 'nav__item nav__item--current' : 'nav__item' }}" aria-label="article{{ $row->pst_id }}" slider-title="{{ $row->title }}" slider-subtitle="{{ $row->summary }}" img="{{ url('../assets/media') }}/{{$row->filename}}" a="{{ url('post')}}/{{ $row->pst_id }}"><span class="nav__item-title"> {{ date('d M Y', strtotime($row->created)) }}</span></button>
                            @endforeach
                           
                        </nav>
                        
                        <!-- Mockup slider for decorative purpose only -->
                        <div class="mockup-slider">
                            <img class="mockup-slider__image" src="{{ url('../assets/media') }}/{{$row->filename}}" alt="{{ $row->title }}" />
                            <a href="{{ url('post')}}/{{ $row->pst_id }}">
                            <h3 class="mockup-slider__title"> <span>{{ $row->title }}</span></h3>
                            <p class="mockup-slider__subtitle bg-primary">{{ $row->summary }} <span class="mdc-typography--caption"> - Baca Artikel</a></span></p>
                        </div>

                    </section>
                </div>
            </div>
        </div>
    </section>