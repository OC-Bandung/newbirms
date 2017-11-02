@extends('frontend.layouts.main')

@section('content')
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
    <section>
        <div class="mdc-layout-grid">
            <div class="mdc-layout-grid__inner f300">
                <div class="mdc-layout-grid__cell mdc-layout-grid__cell--span-4">
                    <div class="mdc-typography--display1">@lang('homepage.welcome_title')</div>
                    @lang('homepage.welcome_text')
                </div>
                <div class="mdc-layout-grid__cell mdc-layout-grid__cell--span-8">
                    <section class="section section--nav" id="Zahi">
                        <span class="link-copy"></span>
                        <nav class="nav nav--zahi">
                            <button class="nav__item" aria-label="Item 7" slider-title="Integration" slider-subtitle="LEARN ABOUT OUR NEW API" img="images/API.jpg"><span class="nav__item-title"> Sept 2019</span></button>
                            <button class="nav__item" slider-title="Report" slider-subtitle="THE ANNUAL PROCUREMENT REPORT" img="images/report.jpg" aria-label="Report"><span class="nav__item-title">December 2016</span></button>
                            <button class="nav__item  nav__item--current" slider-title="Award" slider-subtitle="NATIONAL PROCUREMENT AWARD - read article" img="images/award.jpg" aria-label="Item 2"><span class="nav__item-title">August 2016</span></button>
                            <button class="nav__item" slider-title="Workshop" slider-subtitle="PROCUREMENT WORKSHOP AND CAPACITY BUILDING" img="images/workshop.jpg" aria-label="Item 3"><span class="nav__item-title">July 2016</span></button>
                            <button class="nav__item" slider-title="Engagement" slider-subtitle="CONVERSATION ON PROCUREMENT" img="images/engage.jpg" aria-label="Item 4"><span class="nav__item-title">Mei 2016</span></button>
                            <button class="nav__item" slider-title="TRANSPARENCY" slider-subtitle="OPEN CONTRACTING MEETING" img="images/open-contracting.jpg" aria-label="Item 5"><span class="nav__item-title">February 2016</span></button>
                            <button class="nav__item" slider-title="REPORT" slider-subtitle="PROGRESS REPORT" img="images/report.jpg" aria-label="Item 6"><span class="nav__item-title">January 2015</span></button>
                            <button class="nav__item" aria-label="Item 7" slider-title="PANEL" slider-subtitle="PANEL DISCUSSION" img="images/panel.jpg"><span class="nav__item-title"> 2012</span></button>
                        </nav>
                        <!-- Mockup slider for decorative purpose only -->
                        <div class="mockup-slider">
                            <img class="mockup-slider__image" src="images/award.jpg" alt="img04" />
                            <h3 class="mockup-slider__title">Award</h3>
                            <p class="mockup-slider__subtitle bg-primary">NATIONAL PROCUREMENT AWARD <span class="mdc-typography--caption"><a href="#"> - read article</a></span></p>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </section>
    <section>
        <div class="mdc-layout-grid procurement-grid">
            <div class="mdc-layout-grid__inner">
                <div class="mdc-layout-grid__cell--span-12">
                    <h3 class="mdc-typography--display1">@lang('homepage.procurement_title')</h3>
                </div>
                <div class="mdc-layout-grid__cell--span-3 ">
                    <ul id="load_recent-procurement" class="mdc-list mdc-list--two-line sticky">
                        <li id="load_planning" class="mdc-list-item list-planning active">
                            <span class="mdc-list-item__text">
                                <a href="#"> Planning</a>
                      <span class="mdc-list-item__text__secondary">see what's in our pipeline</span>
                            </span>
                        </li>
                        <li id="load_tender" class="mdc-list-item  list-tender  ">
                            <span class="mdc-list-item__text">
                       <a href="#">Tender</a>
                      <span class="mdc-list-item__text__secondary">prepare to bid</span>
                            </span>
                        </li>
                        <li id="load_award" class="mdc-list-item list-award">
                            <span class="mdc-list-item__text">
                       <a href="#">Award</a>
                      <span class="mdc-list-item__text__secondary">see who was awarded</span>
                            </span>
                        </li>
                        <li id="load_contract" class="mdc-list-item   list-contract">
                            <span class="mdc-list-item__text">
                       <a href="#">Contract</a>
                      <span class="mdc-list-item__text__secondary">view contract information</span>
                            </span>
                        </li>
                        <li id="load_implementation" class="mdc-list-item list-implementation">
                            <span class="mdc-list-item__text">
                       <a href="#">Implementation</a>
                      <span class="mdc-list-item__text__secondary">watch the progress</span>
                            </span>
                        </li>
                    </ul>
                </div>
                <div class="mdc-layout-grid__cell--span-9">
                    <div>
                        <span id="recent_procurement_title" class="mdc-typography--display1 f300"></span>
                        <i class="material-icons">sort</i>
                        <select class="mdc-select">
                            <option value="Sort By" default selected>Sort by</option>
                            <option value="grains">Amount</option>
                            <option value="vegetables">Dates</option>
                            <option value="dairy">Recently updated</option>
                            <option value="meat">Procuring Entity</option>
                            <option value="fats">Budget source</option>
                        </select>
                    </div>
                    <div id="recent-from-api">
                    </div>
                   <!--  <div class="mdc-card procurement-card">
                        <section class="mdc-card__primary">
                            <h1 class="mdc-card__title mdc-card__title--large f300">Belanja Modal Peralatan dan Mesin Pengadaan Mebelair</h1>
                            <h2 class="mdc-card__subtitle">Kota Bandung - RUMAH SAKIT KHUSUS IBU DAN ANAK</h2>
                            <h3 class="mdc-card__subtitle dark-gray">SirupID: #3662192 </h3>
                        </section>
                        <section class="mdc-card__supporting-text ">
                            <div class="procurement-card-container flex">
                                <div class="procurement-card-details padding-small text-center">
                                    <img class="icon-large" src="img/icon-money.png">
                                    <div class="mdc-typography--subheading1"> Pagu </div>
                                    <div> <span class="mdc-typography--title f300"> 2.8 </span> M</div>
                                </div>
                                <div class="procurement-card-details padding-small text-center">
                                    <img class="icon-large" src="img/icon-gov.png">
                                    <div class="mdc-typography--subheading1"> Budget </div>
                                    <div class="mdc-typography--title f300"> BLUD </div>
                                </div>
                                <div class="procurement-card-details padding-small text-center">
                                    <img class="icon-large" src="img/icon-tender-start.png">
                                    <div class="mdc-typography--subheading1"> Tender start </div>
                                    <div class="mdc-typography--title f300"> 01-Feb-2017 </div>
                                </div>
                                <div class="procurement-card-details padding-small text-center">
                                    <img class="icon-large" src="img/icon-tender-end.png">
                                    <div class="mdc-typography--subheading1"> Tender end</div>
                                    <div class="mdc-typography--title f300"> 01-Feb-2018 </div>
                                </div>
                                <div class="procurement-card-details padding-small text-center ">
                                    <img class="icon-large" src="img/icon-contract-start.png">
                                    <div class="mdc-typography--subheading1">Contract start</div>
                                    <div class="mdc-typography--title f300">02 March 1978</div>
                                </div>
                                <div class="procurement-card-details padding-small text-center">
                                    <img class="icon-large" src="img/icon-contract-end.png">
                                    <div class="mdc-typography--subheading1">Contract end</div>
                                    <div class="mdc-typography--title f300">02 March 1978</div>
                                </div>
                            </div>
                            <div>
                                <p>This contract is for <i> <u> Goods and Services</u></i> and will procured as <i> <u>Seleksi Sederhana</u></i>. You have <span class="mdc-typography--subheading1"> 10 days </span> to submit a bid. </p>
                            </div>
                        </section>
                        <section class="mdc-card__actions pull-right">
                            <button class="mdc-button mdc-button--compact mdc-card__action">
                                Apply in Sirup
                            </button>
                            <button class="mdc-button mdc-button--compact mdc-card__action">
                                Download
                            </button>
                            <button class="mdc-button mdc-button--compact mdc-card__action">Email</button>
                        </section>
                    </div>
                    <div class="mdc-card procurement-card even">
                        <section class="mdc-card__primary">
                            <h1 class="mdc-card__title mdc-card__title--large f300">Perawatan dan Pengoperasian Bus TMB Koridor 2 (Cicaheum-Cibeureum)</h1>
                            <h2 class="mdc-card__subtitle">Kota Bandung - DINAS KESEHATAN</h2>
                            <h3 class="mdc-card__subtitle dark-gray">SirupID: #3662192</h3>
                        </section>
                        <section class="mdc-card__supporting-text ">
                            <div class="procurement-card-container flex">
                                <div class="procurement-card-details padding-small text-center">
                                    <img class="icon-large" src="img/icon-money.png">
                                    <div class="mdc-typography--subheading1"> Pagu </div>
                                    <div> <span class="mdc-typography--title f300"> 5.3 </span> M</div>
                                </div>
                                <div class="procurement-card-details padding-small text-center">
                                    <img class="icon-large" src="img/icon-gov.png">
                                    <div class="mdc-typography--subheading1"> Budget </div>
                                    <div class="mdc-typography--title f300"> APBD </div>
                                </div>
                                <div class="procurement-card-details padding-small text-center">
                                    <img class="icon-large" src="img/icon-tender-start.png">
                                    <div class="mdc-typography--subheading1"> Tender start </div>
                                    <div class="mdc-typography--title f300"> 01-Feb-2012 </div>
                                </div>
                                <div class="procurement-card-details padding-small text-center">
                                    <img class="icon-large" src="img/icon-tender-end.png">
                                    <div class="mdc-typography--subheading1"> Tender end</div>
                                    <div class="mdc-typography--title f300"> 01-January-2018 </div>
                                </div>
                                <div class="procurement-card-details padding-small text-center ">
                                    <img class="icon-large" src="img/icon-contract-start.png">
                                    <div class="mdc-typography--subheading1">Contract start</div>
                                    <div class="mdc-typography--title f300">02-June-1978</div>
                                </div>
                                <div class="procurement-card-details padding-small text-center">
                                    <img class="icon-large" src="img/icon-contract-end.png">
                                    <div class="mdc-typography--subheading1">Contract end</div>
                                    <div class="mdc-typography--title f300">02 March 1978</div>
                                </div>
                            </div>
                            <div>
                                <p>This contract is for <i> <u> works</u></i> and will procured as <i> <u>Seleksi Sederhana</u></i>. You have <span class="mdc-typography--subheading1"> xx days </span> to submit a bid. </p>
                            </div>
                        </section>
                        <section class="mdc-card__actions pull-right">
                            <button class="mdc-button mdc-button--compact mdc-card__action">
                                Apply in Sirup
                            </button>
                            <button class="mdc-button mdc-button--compact mdc-card__action">
                                Download
                            </button>
                            <button class="mdc-button mdc-button--compact mdc-card__action">Email</button>
                        </section>
                    </div>
                    <div class="mdc-card procurement-card">
                        <section class="mdc-card__primary">
                            <h1 class="mdc-card__title mdc-card__title--large f300">Belanja Bahan Makanan Dan Minuman Pasien Bulan</h1>
                            <h2 class="mdc-card__subtitle">Kota Bandung - DINAS PEMUDA DAN OLAH RAGA</h2>
                            <h3 class="mdc-card__subtitle dark-gray">SirupID: #3662192</h3>
                        </section>
                        <section class="mdc-card__supporting-text ">
                            <div class="procurement-card-container flex">
                                <div class="procurement-card-details padding-small text-center">
                                    <img class="icon-large" src="img/icon-money.png">
                                    <div class="mdc-typography--subheading1"> Pagu </div>
                                    <div> <span class="mdc-typography--title f300"> 2.8 </span> M</div>
                                </div>
                                <div class="procurement-card-details padding-small text-center">
                                    <img class="icon-large" src="img/icon-gov.png">
                                    <div class="mdc-typography--subheading1"> Budget </div>
                                    <div class="mdc-typography--title f300"> BLUD </div>
                                </div>
                                <div class="procurement-card-details padding-small text-center">
                                    <img class="icon-large" src="img/icon-tender-start.png">
                                    <div class="mdc-typography--subheading1"> Tender start </div>
                                    <div class="mdc-typography--title f300"> 01-Feb-2017 </div>
                                </div>
                                <div class="procurement-card-details padding-small text-center">
                                    <img class="icon-large" src="img/icon-tender-end.png">
                                    <div class="mdc-typography--subheading1"> Tender end</div>
                                    <div class="mdc-typography--title f300"> 01-Feb-2018 </div>
                                </div>
                                <div class="procurement-card-details padding-small text-center ">
                                    <img class="icon-large" src="img/icon-contract-start.png">
                                    <div class="mdc-typography--subheading1">Contract start</div>
                                    <div class="mdc-typography--title f300">02 March 1978</div>
                                </div>
                                <div class="procurement-card-details padding-small text-center">
                                    <img class="icon-large" src="img/icon-contract-end.png">
                                    <div class="mdc-typography--subheading1">Contract end</div>
                                    <div class="mdc-typography--title f300">02 March 1978</div>
                                </div>
                            </div>
                            <div>
                                <p>This contract is for <i> <u> a consultancy</u></i> and will procured as <i> <u>Seleksi Sederhana</u></i>. You have <span class="mdc-typography--subheading1"> 10 days </span> to submit a bid. </p>
                            </div>
                        </section>
                        <section class="mdc-card__actions pull-right">
                            <button class="mdc-button mdc-button--compact mdc-card__action">
                                Apply in Sirup
                            </button>
                            <button class="mdc-button mdc-button--compact mdc-card__action">
                                Download
                            </button>
                            <button class="mdc-button mdc-button--compact mdc-card__action">Email</button>
                        </section>
                    </div>
                    <div class="mdc-card procurement-card even">
                        <section class="mdc-card__primary">
                            <h1 class="mdc-card__title mdc-card__title--large f300">Belanja Makanan dan Minuman Kegiatan Puslat Paskibra</h1>
                            <h2 class="mdc-card__subtitle">Kota Bandung - DINAS PEMUDA DAN OLAH RAGA</h2>
                            <h3 class="mdc-card__subtitle dark-gray">SirupID: #3662192</h3>
                        </section>
                        <section class="mdc-card__supporting-text ">
                            <div class="procurement-card-container flex">
                                <div class="procurement-card-details padding-small text-center">
                                    <img class="icon-large" src="img/icon-money.png">
                                    <div class="mdc-typography--subheading1"> Pagu </div>
                                    <div> <span class="mdc-typography--title f300"> 2.8 </span> M</div>
                                </div>
                                <div class="procurement-card-details padding-small text-center">
                                    <img class="icon-large" src="img/icon-gov.png">
                                    <div class="mdc-typography--subheading1"> Budget </div>
                                    <div class="mdc-typography--title f300"> BLUD </div>
                                </div>
                                <div class="procurement-card-details padding-small text-center">
                                    <img class="icon-large" src="img/icon-tender-start.png">
                                    <div class="mdc-typography--subheading1"> Tender start </div>
                                    <div class="mdc-typography--title f300"> 01-Feb-2017 </div>
                                </div>
                                <div class="procurement-card-details padding-small text-center">
                                    <img class="icon-large" src="img/icon-tender-end.png">
                                    <div class="mdc-typography--subheading1"> Tender end</div>
                                    <div class="mdc-typography--title f300"> 01-Feb-2018 </div>
                                </div>
                                <div class="procurement-card-details padding-small text-center ">
                                    <img class="icon-large" src="img/icon-contract-start.png">
                                    <div class="mdc-typography--subheading1">Contract start</div>
                                    <div class="mdc-typography--title f300">02 March 1978</div>
                                </div>
                                <div class="procurement-card-details padding-small text-center">
                                    <img class="icon-large" src="img/icon-contract-end.png">
                                    <div class="mdc-typography--subheading1">Contract end</div>
                                    <div class="mdc-typography--title f300">02 March 1978</div>
                                </div>
                            </div>
                            <div>
                                <p>This contract is for <i> <u> Goods and Services</u></i> and will procured as <i> <u>Seleksi Sederhana</u></i>. You have <span class="mdc-typography--subheading1"> 10 days </span> to submit a bid. </p>
                            </div>
                        </section>
                        <section class="mdc-card__actions pull-right">
                            <button class="mdc-button mdc-button--compact mdc-card__action">
                                Apply in Sirup
                            </button>
                            <button class="mdc-button mdc-button--compact mdc-card__action">
                                Download
                            </button>
                            <button class="mdc-button mdc-button--compact mdc-card__action">Email</button>
                        </section>
                    </div>
                    <div class="mdc-card procurement-card">
                        <section class="mdc-card__primary">
                            <h1 class="mdc-card__title mdc-card__title--large f300">Belanja Makanan dan Minuman Kegiatan Puslat Paskibra</h1>
                            <h2 class="mdc-card__subtitle">Kota Bandung - DINAS PEMUDA DAN OLAH RAGA</h2>
                            <h3 class="mdc-card__subtitle dark-gray">SirupID: #3662192</h3>
                        </section>
                        <section class="mdc-card__supporting-text ">
                            <div class="procurement-card-container flex">
                                <div class="procurement-card-details padding-small text-center">
                                    <img class="icon-large" src="img/icon-money.png">
                                    <div class="mdc-typography--subheading1"> Pagu </div>
                                    <div> <span class="mdc-typography--title f300"> 2.8 </span> M</div>
                                </div>
                                <div class="procurement-card-details padding-small text-center">
                                    <img class="icon-large" src="img/icon-gov.png">
                                    <div class="mdc-typography--subheading1"> Budget </div>
                                    <div class="mdc-typography--title f300"> BLUD </div>
                                </div>
                                <div class="procurement-card-details padding-small text-center">
                                    <img class="icon-large" src="img/icon-tender-start.png">
                                    <div class="mdc-typography--subheading1"> Tender start </div>
                                    <div class="mdc-typography--title f300"> 01-Feb-2017 </div>
                                </div>
                                <div class="procurement-card-details padding-small text-center">
                                    <img class="icon-large" src="img/icon-tender-end.png">
                                    <div class="mdc-typography--subheading1"> Tender end</div>
                                    <div class="mdc-typography--title f300"> 01-Feb-2018 </div>
                                </div>
                                <div class="procurement-card-details padding-small text-center ">
                                    <img class="icon-large" src="img/icon-contract-start.png">
                                    <div class="mdc-typography--subheading1">Contract start</div>
                                    <div class="mdc-typography--title f300">02 March 1978</div>
                                </div>
                                <div class="procurement-card-details padding-small text-center">
                                    <img class="icon-large" src="img/icon-contract-end.png">
                                    <div class="mdc-typography--subheading1">Contract end</div>
                                    <div class="mdc-typography--title f300">02 March 1978</div>
                                </div>
                            </div>
                            <div>
                                <p>This contract is for <i> <u> Goods and Services</u></i> and will procured as <i> <u>Seleksi Sederhana</u></i>. You have <span class="mdc-typography--subheading1"> 10 days </span> to submit a bid. </p>
                            </div>
                        </section>
                        <section class="mdc-card__actions pull-right">
                            <button class="mdc-button mdc-button--compact mdc-card__action">
                                Apply in Sirup
                            </button>
                            <button class="mdc-button mdc-button--compact mdc-card__action">
                                Download
                            </button>
                            <button class="mdc-button mdc-button--compact mdc-card__action">Email</button>
                        </section>
                    </div> -->
                    <div class="mdc-card procurement-card text-center">
                        <section class="mdc-card__primary">
                            <button class="mdc-button">view more</button>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section>
        <div class="mdc-layout-grid">
            <div class="mdc-layout-grid__inner">
                <div class="mdc-layout-grid__cell--span-12">
                    <div class="mdc-typography--display1">@lang('homepage.procurement_map_title')</div>
                </div>
                <div class="mdc-layout-grid__cell--span-6">
                    <div id="map"></div>
                </div>
                <div class="mdc-layout-grid__cell--span-6">
                    <nav id="icon-text-tab-bar" class="mdc-tab-bar mdc-tab-bar--icons-with-text">
                        <a class="mdc-tab mdc-tab--with-icon-and-text mdc-tab--active" href="#recents">
                        <i class="material-icons mdc-tab__icon" aria-hidden="true">fiber_new</i>
                        <span class="mdc-tab__icon-caption">Recent</span>
                      </a>
                        <a class="mdc-tab mdc-tab--with-icon-and-text" href="#byvalue">
                        <i class="material-icons mdc-tab__icon" aria-hidden="true">attach_money</i>
                        <span class="mdc-tab__icon-caption">Value</span>
                      </a>
                        <span class="mdc-tab-bar__indicator"></span>
                    </nav>
                    <div class="panels">
                        <p class="panel active" id="recents" role="tabpanel" aria-hidden="true">
                            <ul class="map-list mdc-list mdc-list--two-line">
                                <li class="mdc-list-item">
                                    <span class="mdc-list-item__text">
                                  <span>02.09.2017</span>
                                    <span>Belanja Modal Peralatan Dan Mesin-Pengadaan Meubeleir</span>
                                    <span class="mdc-list-item__text__secondary">KECAMATAN ASTANAANYAR</span>
                                    </span>
                                </li>
                                <li class="mdc-list-item">
                                    <span class="mdc-list-item__text">
                                 <span>02.08.2017</span>
                                    <span>Belanja Pengadaan Modal Dan Mesin-alat studio/Proyektor</span>
                                    <span class="mdc-list-item__text__secondary">KECAMATAN ASTANAANYAR</span>
                                    </span>
                                </li>
                                <li class="mdc-list-item">
                                    <span class="mdc-list-item__text">
                                 <span>02.10.2017</span>
                                    <span> Belanja Modal Peralatan Dan Mesin-Pengadaan Komputer</span>
                                    <span class="mdc-list-item__text__secondary">KECAMATAN ASTANAANYAR</span>
                                    </span>
                                </li>
                                <li class="mdc-list-item">
                                    <span class="mdc-list-item__text">
                                  <span>02.10.2017</span>
                                    <span>Belanja Pemeliharaan Bangunan</span>
                                    <span class="mdc-list-item__text__secondary">KECAMATAN ASTANAANYAR</span>
                                    </span>
                                </li>
                                <li class="mdc-list-item">
                                    <span class="mdc-list-item__text">
                                  <span>02.10.2017</span>
                                    <span>Belanja Pemeliharaan Ruangan Pelayanan</span>
                                    <span class="mdc-list-item__text__secondary">KECAMATAN ASTANAANYAR</span>
                                    </span>
                                </li>
                            </ul>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section>
        <div class="mdc-layout-grid">
            <div class="mdc-layout-grid__inner">
                <div class="mdc-layout-grid__cell mdc-layout-grid__cell--span-6">
                    <div class="mdc-typography--display1">@lang('homepage.statistic_title')</div>
                </div>
            </div>
        </div>
        <div class="mdc-layout-grid">
            <div class="mdc-layout-grid__inner">
                <div class="mdc-layout-grid__cell mdc-layout-grid__cell--span-6">
                    <div class="mdc-card demo-card">
                        <section class="mdc-card__primary">
                            <h1 class="mdc-card__title mdc-card__title--large f300">Lelang Umum vs Pengadaan Langsung</h1>
                            <h2 class="mdc-card__subtitle">Indikator Efektif</h2>
                            <select class="mdc-select homepage-chart">
                                <option value="" default selected>Pick a year</option>
                                <option value="a">all</option>
                                <option value="b">2016</option>
                                <option value="b">2015</option>
                                <option value="b">2014</option>
                            </select>
                        </section>
                        <div class="mdc-card__horizontal-block">
                            <div id="graph01" style="min-width: 70%; height: 400px; margin: 0 auto"></div>
                            <section class="stat-settings mdc-card__actions mdc-card__actions--vertical">
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
                                <div class="stat-settings-button">
                                    <!-- TODO(sgomes): Replace with icon buttons when we have those. -->
                                    <button class="mdc-button mdc-button--compact mdc-card__action">
                                        <i class="material-icons dark-gray">settings</i>
                                    </button>
                                    <button class="mdc-button mdc-button--compact mdc-card__action"><i class="material-icons dark-gray">share</i></button>
                                    <button class="mdc-button dark-gray">
                                        Get Data
                                    </button>
                                </div>
                            </section>
                        </div>
                    </div>
                </div>

                <div class="mdc-layout-grid__cell mdc-layout-grid__cell--span-6">
                    <div class="mdc-card demo-card">
                        <section class="mdc-card__primary">
                            <h1 class="mdc-card__title mdc-card__title--large f300">Top Pengadaan SKPD</h1>
                            <h2 class="mdc-card__subtitle">Indikator Efisiensi</h2>
                            <select class="mdc-select homepage-chart">
                                <option value="" default selected>Pick a year</option>
                                <option value="a">all</option>
                                <option value="b">2016</option>
                                <option value="b">2015</option>
                                <option value="b">2014</option>
                            </select>
                        </section>
                        <div class="mdc-card__horizontal-block">
                            <div id="graph02" style="min-width: 70%; height: 400px; margin: 0 auto"></div>
                            <section class="stat-settings mdc-card__actions mdc-card__actions--vertical">
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
                                <div class="stat-settings-button">
                                    <!-- TODO(sgomes): Replace with icon buttons when we have those. -->
                                    <button class="mdc-button mdc-button--compact mdc-card__action">
                                        <i class="material-icons dark-gray">settings</i>
                                    </button>
                                    <button class="mdc-button mdc-button--compact mdc-card__action"><i class="material-icons dark-gray">share</i></button>
                                    <button class="mdc-button dark-gray">
                                        Get Data
                                    </button>
                                </div>
                            </section>
                        </div>
                    </div>
                </div>

                <div class="mdc-layout-grid__cell mdc-layout-grid__cell--span-6">
                    <div class="mdc-card demo-card">
                        <section class="mdc-card__primary">
                            <h1 class="mdc-card__title mdc-card__title--large f300">Jenis Pengadaan</h1>
                            <h2 class="mdc-card__subtitle">Indikator Efektif</h2>
                            <select class="mdc-select homepage-chart">
                                <option value="" default selected>Pick a year</option>
                                <option value="a">all</option>
                                <option value="b">2016</option>
                                <option value="b">2015</option>
                                <option value="b">2014</option>
                            </select>
                        </section>
                        <div class="mdc-card__horizontal-block">
                            <div id="graph03" style="min-width: 70%; height: 400px; margin: 0 auto"></div>
                            <section class="stat-settings mdc-card__actions mdc-card__actions--vertical">
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
                                <div class="stat-settings-button">
                                    <!-- TODO(sgomes): Replace with icon buttons when we have those. -->
                                    <button class="mdc-button mdc-button--compact mdc-card__action">
                                        <i class="material-icons dark-gray">settings</i>
                                    </button>
                                    <button class="mdc-button mdc-button--compact mdc-card__action"><i class="material-icons dark-gray">share</i></button>
                                    <button class="mdc-button dark-gray">
                                        Get Data
                                    </button>
                                </div>
                            </section>
                        </div>
                    </div>
                </div>

                <div class="mdc-layout-grid__cell mdc-layout-grid__cell--span-6">
                    <div class="mdc-card demo-card">
                        <section class="mdc-card__primary">
                            <h1 class="mdc-card__title mdc-card__title--large f300">Total Paket Pengadaan</h1>
                            <h2 class="mdc-card__subtitle">Indikator Efisiensi</h2>
                            <select class="mdc-select homepage-chart">
                                <option value="" default selected>Pick a year</option>
                                <option value="a">all</option>
                                <option value="b">2016</option>
                                <option value="b">2015</option>
                                <option value="b">2014</option>
                            </select>
                        </section>
                        <div class="mdc-card__horizontal-block">
                            <div id="graph04" style="min-width: 70%; height: 400px; margin: 0 auto"></div>
                            <section class="stat-settings mdc-card__actions mdc-card__actions--vertical">
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
                                <div class="stat-settings-button">
                                    <!-- TODO(sgomes): Replace with icon buttons when we have those. -->
                                    <button class="mdc-button mdc-button--compact mdc-card__action">
                                        <i class="material-icons dark-gray">settings</i>
                                    </button>
                                    <button class="mdc-button mdc-button--compact mdc-card__action"><i class="material-icons dark-gray">share</i></button>
                                    <button class="mdc-button dark-gray">
                                        Get Data
                                    </button>
                                </div>
                            </section>
                        </div>
                    </div>
                </div>
            </div>

            
        </div>
        
    </section>
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
                <div class="mdc-layout-grid__cell mdc-layout-grid__cell--span-4 blog-1">
                    <div class="mdc-typography--title">Article Title</div>
                    <p> Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. </p>
                </div>
                <div class="mdc-layout-grid__cell mdc-layout-grid__cell--span-4 blog-2">
                    <div class="mdc-typography--title">Article Title</div>
                    <p> Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. </p>
                </div>
                <div class="mdc-layout-grid__cell mdc-layout-grid__cell--span-4 blog-3">
                    <div class="mdc-typography--title">Article Title</div>
                    <p> Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. </p>
                </div>
                <div class="mdc-layout-grid__cell mdc-layout-grid__cell--span-4 blog-4">
                    <div class="mdc-typography--title">Article Title</div>
                    <p> Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. </p>
                </div>
                <div class="mdc-layout-grid__cell mdc-layout-grid__cell--span-4 blog-1">
                    <div class="mdc-typography--title">Article Title</div>
                    <p> Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. </p>
                </div>
                <div class="mdc-layout-grid__cell mdc-layout-grid__cell--span-4 blog-2">
                    <div class="mdc-typography--title">Article Title</div>
                    <p> Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. </p>
                </div>
            </div>
        </div>
    </section>
    <section>
        <div class="mdc-layout-grid">
            <div class="mdc-layout-grid__inner">
                <div class="mdc-layout-grid__cell mdc-layout-grid__cell--span-6">
                    <div class="mdc-typography--display1"> <span class="color-primary">BIRMS</span><span class="f300">, a truly integrated system </span></div>
                </div>
            </div>
        </div>
        <div class="mdc-layout-grid">
            <div class="mdc-layout-grid__inner">
                <div class="mdc-layout-grid__cell mdc-layout-grid__cell--span-8">
                    <div class="mdc-grid-list">
                        <ul class="mdc-grid-list__tiles">
                            <li class="mdc-grid-tile">
                                <div class="mdc-grid-tile__primary">
                                    <img class="mdc-grid-tile__primary-content" src="images/apps/0.png" />
                                </div>
                                <span class="mdc-grid-tile__secondary">
                                <span class="mdc-grid-tile__title">Title</span>
                                </span>
                            </li>
                            <li class="mdc-grid-tile">
                                <a href="test">
                                    <div class="mdc-grid-tile__primary">
                                    <img class="mdc-grid-tile__primary-content" src="images/apps/1.png" />
                                </div>
                                <span class="mdc-grid-tile__secondary">
                                    <span class="mdc-grid-tile__title">SIMDA</span>
                                </span>
                                </a>
                            </li>
                            <li class="mdc-grid-tile">
                                <div class="mdc-grid-tile__primary">
                                    <img class="mdc-grid-tile__primary-content" src="images/apps/2.png" />
                                </div>
                                <span class="mdc-grid-tile__secondary">
                                <span class="mdc-grid-tile__title">SIRUP</span>
                                </span>
                            </li>
                            <li class="mdc-grid-tile">
                                <div class="mdc-grid-tile__primary">
                                    <img class="mdc-grid-tile__primary-content" src="images/apps/3.png" />
                                </div>
                                <span class="mdc-grid-tile__secondary">
                                <span class="mdc-grid-tile__title">Title</span>
                                </span>
                            </li>
                            <li class="mdc-grid-tile">
                                <div class="mdc-grid-tile__primary">
                                    <img class="mdc-grid-tile__primary-content" src="images/apps/4.png" />
                                </div>
                                <span class="mdc-grid-tile__secondary">
                                <span class="mdc-grid-tile__title">Title</span>
                                </span>
                            </li>
                            <li class="mdc-grid-tile">
                                <div class="mdc-grid-tile__primary">
                                    <img class="mdc-grid-tile__primary-content" src="images/apps/5.png" />
                                </div>
                                <span class="mdc-grid-tile__secondary">
                                <span class="mdc-grid-tile__title">Title</span>
                                </span>
                            </li>
                            <li class="mdc-grid-tile">
                                <div class="mdc-grid-tile__primary">
                                    <img class="mdc-grid-tile__primary-content" src="images/apps/6.png" />
                                </div>
                                <span class="mdc-grid-tile__secondary">
                                <span class="mdc-grid-tile__title">Title</span>
                                </span>
                            </li>
                            <li class="mdc-grid-tile">
                                <div class="mdc-grid-tile__primary">
                                    <img class="mdc-grid-tile__primary-content" src="images/apps/7.png" />
                                </div>
                                <span class="mdc-grid-tile__secondary">
                                <span class="mdc-grid-tile__title">Title</span>
                                </span>
                            </li>
                            <li class="mdc-grid-tile">
                                <div class="mdc-grid-tile__primary">
                                    <img class="mdc-grid-tile__primary-content" src="images/apps/8.png" />
                                </div>
                                <span class="mdc-grid-tile__secondary">
                                <span class="mdc-grid-tile__title">Title</span>
                                </span>
                            </li>
                            <li class="mdc-grid-tile">
                                <div class="mdc-grid-tile__primary">
                                    <img class="mdc-grid-tile__primary-content" src="images/apps/9.png" />
                                </div>
                                <span class="mdc-grid-tile__secondary">
                                <span class="mdc-grid-tile__title">Title</span>
                                </span>
                            </li>
                            <li class="mdc-grid-tile">
                                <div class="mdc-grid-tile__primary">
                                    <img class="mdc-grid-tile__primary-content" src="images/apps/10.png" />
                                </div>
                                <span class="mdc-grid-tile__secondary">
                                <span class="mdc-grid-tile__title">Title</span>
                                </span>
                            </li>
                            <li class="mdc-grid-tile">
                                <div class="mdc-grid-tile__primary">
                                    <img class="mdc-grid-tile__primary-content" src="images/apps/11.png" />
                                </div>
                                <span class="mdc-grid-tile__secondary">
                                <span class="mdc-grid-tile__title">Title</span>
                                </span>
                            </li>
                        </ul>
                    </div>
                    <br>
                    <div class="mdc-layout-grid__cell mdc-layout-grid__cell--span-12">
                        <div class="mdc-typography--subheading1"> PARTNERS</span>
                        </div>
                        <a href="http://lkpp.go.id" target="_blank" title="Lembaga Kebijakan Pengadaan Barang/Jasa Pemerintah"><img src="{{ url('images/partners/1lkpp.png') }}"></a>
                        <a href="http://www.bpkp.go.id/konten/433/SIMDA.bpkp" target="_blank" title="Program Aplikasi Komputer SIMDA

"><img src="{{ url('images/partners/2simda.png') }}"></a>
                        <a href="https://www.open-contracting.org" target="_blank" title="Open Contracting Partnership"><img src="{{ url('images/partners/3oc.png') }}"></a>
                        <a href="http://www.worldbank.org" target="_blank" title="World Bank Group"><img src="{{ url('images/partners/2wb.png') }}"></a>
                    </div>
                </div>
                <div class="mdc-layout-grid__cell--span-4">
                    <div class="mdc-typography--subheading1">GET IN TOUCH</div>
                    <p>Sistem Pengelolaan Sumber Daya Pemerintahan Terintegrasi. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                    <div>
                        <div class="mdc-textfield mdc-textfield--fullwidth">
                            <input class="mdc-textfield__input" type="text" placeholder="Name" aria-label="Name">
                        </div>
                        <div class="mdc-textfield mdc-textfield--fullwidth">
                            <input class="mdc-textfield__input" type="text" placeholder="Email" aria-label="Email">
                        </div>
                        <div class="mdc-textfield mdc-textfield--multiline mdc-textfield--fullwidth">
                            <textarea class="mdc-textfield__input" placeholder="Message" rows="8" cols="40" aria-label="Message"></textarea>
                        </div>
                        <br>
                        <button class="mdc-button mdc-button--raised">
                            Send Message
                        </button>
                    </div>
                </div>
            </div>
    </section>
@endsection