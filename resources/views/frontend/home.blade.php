@extends('frontend.layouts.main')

@section('content')
	<!--dashboard-->
    <section>
        <div class="mdc-layout-grid text-center">
            <div class="mdc-layout-grid__inner">
                <div class="mdc-layout-grid__cell mdc-layout-grid__cell--span-3">
                    <span class="mdc-typography--title">  Rp. </span>
                    <span class="mdc-typography--display1 f300">  561,56  </span>
                    <span class="mdc-typography--title"> M </span>
                    <p> Pengadaan Barang / Jasa </p>
                </div>
                <div class="mdc-layout-grid__cell mdc-layout-grid__cell--span-3">
                    <span class="mdc-typography--display1 f300">  169  </span>
                    <span class="mdc-typography--title"> Paket</span>
                    <p>Lelang Umum</p>
                </div>
                <div class="mdc-layout-grid__cell mdc-layout-grid__cell--span-3">
                    <span class="mdc-typography--display1 f300">3.031 </span>
                    <span class="mdc-typography--title">  Paket</span>
                    <p>Pengadaan Langsung</p>
                </div>
                <div class="mdc-layout-grid__cell mdc-layout-grid__cell--span-3">
                    <span class="mdc-typography--title">  Rp. </span>
                    <span class="mdc-typography--display1 f300">  200,08  </span>
                    <span class="mdc-typography--title"> M </span>
                    <p>Pengumuman Pengadaan Barang / Jasa</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Front End Content -->
    <section>
        <div class="mdc-layout-grid">
            <div class="mdc-layout-grid__inner">
                <div class="mdc-layout-grid__cell mdc-layout-grid__cell--span-4">
                    <div class="mdc-typography--display1">@lang('homepage.section_title')</div>
                    @lang('homepage.section_text')
                </div>
                <div class="mdc-layout-grid__cell mdc-layout-grid__cell--span-8">
                    <section class="section section--nav" id="Zahi">
                        <span class="link-copy"></span>
                        <nav class="nav nav--zahi">
                            <button class="nav__item" aria-label="Item 1"><span class="nav__item-title">December 2016</span></button>
                            <button class="nav__item nav__item--current" aria-label="Item 2"><span class="nav__item-title">August 2016</span></button>
                            <button class="nav__item" aria-label="Item 3"><span class="nav__item-title">July 2016</span></button>
                            <button class="nav__item" aria-label="Item 4"><span class="nav__item-title">Mei 2016</span></button>
                            <button class="nav__item" aria-label="Item 5"><span class="nav__item-title">February 2016</span></button>
                            <button class="nav__item" aria-label="Item 6"><span class="nav__item-title">January 2015</span></button>
                            <button class="nav__item" aria-label="Item 7"><span class="nav__item-title">Mei 2012</span></button>
                            <button class="nav__item" aria-label="Item 8"><span class="nav__item-title">Mei 2012</span></button>
                        </nav>
                        <!-- Mockup slider for decorative purpose only -->
                        <div class="mockup-slider">
                            <img src="{{ url('images/national-procurement-award.jpeg') }}" alt="img04" />
                            <h3 class="mockup-slider__title">Award</h3>
                            <p class="mockup-slider__subtitle">NATIONAL PROCUREMENT AWARD <i class="mdc-typography--caption"><a href="#">- read article</a></i></p>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </section>

    <!-- Key Statistic-->
    <section>
        <div class="mdc-layout-grid">
            <div class="mdc-layout-grid__inner">
                <div class="mdc-layout-grid__cell mdc-layout-grid__cell--span-6">
                    <div class="mdc-typography--display1">Key Statistics</div>
                </div>
            </div>
        </div>
        <div class="mdc-layout-grid">
            <div class="mdc-layout-grid__inner">
                <div class="mdc-layout-grid__cell mdc-layout-grid__cell--span-6">
                    <div class="mdc-card demo-card">
                        <section class="mdc-card__primary">
                            <h1 class="mdc-card__title mdc-card__title--large">Competitive vs Direct Procurement</h1>
                            <h2 class="mdc-card__subtitle">Effective indicator</h2>
                            <select class="mdc-select homepage-chart">
                                <option value="" default selected>Pick a year</option>
                                <option value="a">all</option>
                                <option value="b">2016</option>
                                <option value="b">2015</option>
                                <option value="b">2014</option>
                            </select>
                        </section>
                        <div class="mdc-card__horizontal-block">
                            <img class="img-chart" src="images/funky-bar-chart.png">
                            <section class="mdc-card__actions mdc-card__actions--vertical">
                                <div class="mdc-form-field">
                                    <div class="mdc-radio" data-demo-no-js="">
                                        <input class="mdc-radio__native-control" type="radio" id="ex1-radio1" checked="" name="ex1">
                                        <div class="mdc-radio__background">
                                            <div class="mdc-radio__outer-circle"></div>
                                            <div class="mdc-radio__inner-circle"></div>
                                        </div>
                                    </div>
                                    <label id="ex1-radio1-label" for="ex1-radio1">By Value</label>
                                </div>
                                <div class="mdc-form-field">
                                    <div class="mdc-radio" data-demo-no-js="">
                                        <input class="mdc-radio__native-control" type="radio" id="ex1-radio2" name="ex1">
                                        <div class="mdc-radio__background">
                                            <div class="mdc-radio__outer-circle"></div>
                                            <div class="mdc-radio__inner-circle"></div>
                                        </div>
                                    </div>
                                    <label id="ex1-radio2-label" for="ex1-radio2">By Count</label>
                                </div>
                                <!-- TODO(sgomes): Replace with icon buttons when we have those. -->
                                <button class="mdc-button mdc-button--compact mdc-card__action">
                                    <i class="material-icons">settings</i>
                                </button>
                                <button class="mdc-button mdc-button--compact mdc-card__action"><i class="material-icons">share</i></button>
                                <button class="mdc-button mdc-button--raised">
                                    Get Data
                                </button>
                            </section>
                        </div>
                    </div>
                </div>
                <div class="mdc-layout-grid__cell mdc-layout-grid__cell--span-6">
                    <div class="mdc-card demo-card">
                        <section class="mdc-card__primary">
                            <h1 class="mdc-card__title mdc-card__title--large">Best Performance SKPD</h1>
                            <h2 class="mdc-card__subtitle">Effective indicator</h2>
                            <select class="mdc-select homepage-chart">
                                <option value="" default selected>Pick a year</option>
                                <option value="a">all</option>
                                <option value="b">2016</option>
                                <option value="b">2015</option>
                                <option value="b">2014</option>
                            </select>
                        </section>
                        <div class="mdc-card__horizontal-block">
                            <img class="img-chart" src="images/line-chart.png">
                            <section class="mdc-card__actions mdc-card__actions--vertical">
                                <div class="mdc-form-field">
                                    <div class="mdc-radio" data-demo-no-js="">
                                        <input class="mdc-radio__native-control" type="radio" id="ex1-radio1" checked="" name="ex1">
                                        <div class="mdc-radio__background">
                                            <div class="mdc-radio__outer-circle"></div>
                                            <div class="mdc-radio__inner-circle"></div>
                                        </div>
                                    </div>
                                    <label id="ex1-radio1-label" for="ex1-radio1">By Value</label>
                                </div>
                                <div class="mdc-form-field">
                                    <div class="mdc-radio" data-demo-no-js="">
                                        <input class="mdc-radio__native-control" type="radio" id="ex1-radio2" name="ex1">
                                        <div class="mdc-radio__background">
                                            <div class="mdc-radio__outer-circle"></div>
                                            <div class="mdc-radio__inner-circle"></div>
                                        </div>
                                    </div>
                                    <label id="ex1-radio2-label" for="ex1-radio2">By Count</label>
                                </div>
                                <!-- TODO(sgomes): Replace with icon buttons when we have those. -->
                                <button class="mdc-button mdc-button--compact mdc-card__action">
                                    <i class="material-icons">settings</i>
                                </button>
                                <button class="mdc-button mdc-button--compact mdc-card__action"><i class="material-icons">share</i></button>
                                <button class="mdc-button mdc-button--raised">
                                    Get Data
                                </button>
                            </section>
                        </div>
                    </div>
                </div>
                <div class="mdc-layout-grid__cell mdc-layout-grid__cell--span-6">
                    <div class="mdc-card demo-card">
                        <section class="mdc-card__primary">
                            <h1 class="mdc-card__title mdc-card__title--large">Procurement Category</h1>
                            <h2 class="mdc-card__subtitle">Effective indicator</h2>
                            <select class="mdc-select homepage-chart">
                                <option value="" default selected>Pick a year</option>
                                <option value="a">all</option>
                                <option value="b">2016</option>
                                <option value="b">2015</option>
                                <option value="b">2014</option>
                            </select>
                        </section>
                        <div class="mdc-card__horizontal-block">
                            <img class="img-chart" src="images/pie-chart.png">
                            <section class="mdc-card__actions mdc-card__actions--vertical">
                                <div class="mdc-form-field">
                                    <div class="mdc-radio" data-demo-no-js="">
                                        <input class="mdc-radio__native-control" type="radio" id="ex1-radio1" checked="" name="ex1">
                                        <div class="mdc-radio__background">
                                            <div class="mdc-radio__outer-circle"></div>
                                            <div class="mdc-radio__inner-circle"></div>
                                        </div>
                                    </div>
                                    <label id="ex1-radio1-label" for="ex1-radio1">By Value</label>
                                </div>
                                <div class="mdc-form-field">
                                    <div class="mdc-radio" data-demo-no-js="">
                                        <input class="mdc-radio__native-control" type="radio" id="ex1-radio2" name="ex1">
                                        <div class="mdc-radio__background">
                                            <div class="mdc-radio__outer-circle"></div>
                                            <div class="mdc-radio__inner-circle"></div>
                                        </div>
                                    </div>
                                    <label id="ex1-radio2-label" for="ex1-radio2">By Count</label>
                                </div>
                                <!-- TODO(sgomes): Replace with icon buttons when we have those. -->
                                <button class="mdc-button mdc-button--compact mdc-card__action">
                                    <i class="material-icons">settings</i>
                                </button>
                                <button class="mdc-button mdc-button--compact mdc-card__action"><i class="material-icons">share</i></button>
                                <button class="mdc-button mdc-button--raised">
                                    Get Data
                                </button>
                            </section>
                        </div>
                    </div>
                </div>
                <div class="mdc-layout-grid__cell mdc-layout-grid__cell--span-6">
                    <div class="mdc-card demo-card">
                        <section class="mdc-card__primary">
                            <h1 class="mdc-card__title mdc-card__title--large">Top 5 Sectors</h1>
                            <h2 class="mdc-card__subtitle">Effective indicator</h2>
                            <select class="mdc-select homepage-chart">
                                <option value="" default selected>Pick a year</option>
                                <option value="a">all</option>
                                <option value="b">2016</option>
                                <option value="b">2015</option>
                                <option value="b">2014</option>
                            </select>
                        </section>
                        <div class="mdc-card__horizontal-block">
                            <img class="img-chart" src="images/bar-chart.png">
                            <section class="mdc-card__actions mdc-card__actions--vertical">
                                <div class="mdc-form-field">
                                    <div class="mdc-radio" data-demo-no-js="">
                                        <input class="mdc-radio__native-control" type="radio" id="ex1-radio1" checked="" name="ex1">
                                        <div class="mdc-radio__background">
                                            <div class="mdc-radio__outer-circle"></div>
                                            <div class="mdc-radio__inner-circle"></div>
                                        </div>
                                    </div>
                                    <label id="ex1-radio1-label" for="ex1-radio1">By Value</label>
                                </div>
                                <div class="mdc-form-field">
                                    <div class="mdc-radio" data-demo-no-js="">
                                        <input class="mdc-radio__native-control" type="radio" id="ex1-radio2" name="ex1">
                                        <div class="mdc-radio__background">
                                            <div class="mdc-radio__outer-circle"></div>
                                            <div class="mdc-radio__inner-circle"></div>
                                        </div>
                                    </div>
                                    <label id="ex1-radio2-label" for="ex1-radio2">By Count</label>
                                </div>
                                <!-- TODO(sgomes): Replace with icon buttons when we have those. -->
                                <button class="mdc-button mdc-button--compact mdc-card__action">
                                    <i class="material-icons">settings</i>
                                </button>
                                <button class="mdc-button mdc-button--compact mdc-card__action"><i class="material-icons">share</i></button>
                                <button class="mdc-button mdc-button--raised">
                                    Get Data
                                </button>
                            </section>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Articles -->
    <section>
        <div class="mdc-layout-grid">
            <div class="mdc-layout-grid__inner">
                <div class="mdc-layout-grid__cell mdc-layout-grid__cell--span-6">
                    <div class="mdc-card demo-card">
                        <section class="mdc-card__primary">
                            <h1 class="mdc-card__title mdc-card__title--large">Article Title goes here</h1>
                            <h2 class="mdc-card__subtitle">Subtitle here</h2>
                        </section>
                        <section class="mdc-card__supporting-text">
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                        </section>
                        <section class="mdc-card__actions">
                            <button class="mdc-button mdc-button--compact mdc-card__action">Action 1</button>
                            <button class="mdc-button mdc-button--compact mdc-card__action">Action 2</button>
                        </section>
                    </div>
                </div>
                <div class="mdc-layout-grid__cell mdc-layout-grid__cell--span-6">
                </div>
                <div class="mdc-layout-grid__cell mdc-layout-grid__cell--span-6">
                </div>
                <div class="mdc-layout-grid__cell mdc-layout-grid__cell--span-6">
                </div>
                <div class="mdc-layout-grid__cell mdc-layout-grid__cell--span-6">
                </div>
            </div>
        </div>
    </section>
@endsection