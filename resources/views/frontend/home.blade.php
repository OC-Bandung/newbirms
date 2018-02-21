@extends('frontend.layouts.main')

@section('header')
    <svg class="hidden">
        <defs>
            <symbol id="icon-arrow" viewBox="0 0 24 24">
                <title>arrow</title>
                <polygon points="6.3,12.8 20.9,12.8 20.9,11.2 6.3,11.2 10.2,7.2 9,6 3.1,12 9,18 10.2,16.8 " />
            </symbol>
            <symbol id="icon-drop" viewBox="0 0 24 24">
                <title>drop</title>
                <path d="M12,21c-3.6,0-6.6-3-6.6-6.6C5.4,11,10.8,4,11.4,3.2C11.6,3.1,11.8,3,12,3s0.4,0.1,0.6,0.3c0.6,0.8,6.1,7.8,6.1,11.2C18.6,18.1,15.6,21,12,21zM12,4.8c-1.8,2.4-5.2,7.4-5.2,9.6c0,2.9,2.3,5.2,5.2,5.2s5.2-2.3,5.2-5.2C17.2,12.2,13.8,7.3,12,4.8z" />
                <path d="M12,18.2c-0.4,0-0.7-0.3-0.7-0.7s0.3-0.7,0.7-0.7c1.3,0,2.4-1.1,2.4-2.4c0-0.4,0.3-0.7,0.7-0.7c0.4,0,0.7,0.3,0.7,0.7C15.8,16.5,14.1,18.2,12,18.2z" />
            </symbol>
            <symbol id="icon-search" viewBox="0 0 24 24">
                <title>search</title>
                <path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z" />
            </symbol>
            <symbol id="icon-cross" viewBox="0 0 24 24">
                <title>cross</title>
                <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z" />
            </symbol>
        </defs>
    </svg>
    <div class="intro">
        <!--nav-->
        @include('frontend.layouts.pages-nav') 

        <!-- Search -->
        <main class="main-wrap">
            <div class="search">
                <button id="btn-search-close" class="btn btn--search-close" aria-label="Close search form">
                    <i class="material-icons">close</i>
                </button>
                <form class="search__form" action="{{ url('search') }}" method="get">
                    <button class="btn btn--search">
                        <svg class="icon icon--search">
                            <use xlink:href="#icon-search"></use>
                        </svg>
                    </button>
                    <input id="search-input" class="search__input" name="q" type="search" placeholder="Cari" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" />
                    <div class="mdc-layout-grid">
                        <div class="mdc-layout-grid__inner">
                            <div class="mdc-layout-grid__cell--span-3">
                                <div class="search-select mdc-select">
                                    <select class="mdc-select__surface" name="tahun" id="tahun" placeholder="Tahun">
                                        <option value="" disabled selected>- Tahun -</option>
                                        @for ($i = date("Y"); $i >= 2013; $i--)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                        @endfor
                                    </select>
                                    <div class="mdc-select__bottom-line"></div>
                                </div>
                            </div>
                            <div class="mdc-layout-grid__cell--span-9">
                                <div class="search-select mdc-select">
                                    <select class="mdc-select__surface" name="skpdID">
                                        <option value="" disabled selected>- SKPD -</option>
                                        @foreach($ref_skpd as $row)
                                        <option value="{{ $row->skpdID }}">{{ $row->unitID }} - {{ $row->nama }}</option>
                                        @endforeach
                                    </select>
                                    <div class="mdc-select__bottom-line"></div>
                                </div>
                            </div>
                            <div class="mdc-layout-grid__cell--span-4">
                                <div class="search-select mdc-select">                                
                                    <select class="mdc-select__surface" name="klasifikasi" id="klasifikasi">
                                        <option value="" disabled selected>- Klasifikasi -</option>
                                        <option value="01">Konstruksi</option>
                                        <option value="02">Pengadaan Barang</option>
                                        <option value="03">Jasa Konsultansi</option>
                                        <option value="04">Jasa Lainnya</option>
                                    </select>
                                    <div class="mdc-select__bottom-line"></div>
                                </div>    
                            </div>
                            <div class="mdc-layout-grid__cell--span-8">
                                <div class="search-select">
                                    <label for="min">Pagu Anggaran / Nilai Kontrak</label>
                                    <div class="mdc-text-field">
                                        <div class="mdc-layout-grid__inner">
                                            <div class="mdc-layout-grid__cell--span-6 padding-top-small">            
                                                <input type="text" id="min" name="min" class="mdc-text-field__input" placeholder="Min">
                                                <div class="mdc-text-field__bottom-line"></div>
                                            </div>
                                            <div class="mdc-layout-grid__cell--span-6 padding-top-small">            
                                                <input type="text" id="max" name="max" class="mdc-text-field__input" placeholder="Max">
                                                <div class="mdc-text-field__bottom-line"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mdc-layout-grid__cell--span-4">
                                <div class="search-select mdc-select">
                                    <select class="search-select mdc-select__surface" name="tahap" id="tahap" placeholder="Pilih Tahapan">
                                        <option value="" disabled selected>- Tahapan -</option>
                                        <option value="1">Perencanaan</option>
                                        <option value="2">Pengadaan</option>
                                        <option value="3">Pemenang</option>
                                        <option value="4">Kontrak</option>
                                        <option value="5">Implementasi</option>
                                    </select><i class="material-icons mdc-text-field__icon" tabindex="0">warning</i>
                                    <div class="mdc-select__bottom-line"></div>
                                </div>     
                            </div>
                            <div class="mdc-layout-grid__cell--span-8">
                                <div class="search-select">
                                    <label for="startdate">Tanggal <i class="material-icons mdc-text-field__icon" tabindex="0">warning</i></label>
                                    <div class="mdc-text-field">
                                        <div class="mdc-layout-grid__inner">
                                            <div class="mdc-layout-grid__cell--span-6 padding-top-small">   
                                                <input type="date" id="enddate" name="enddate" class="mdc-text-field__input"> 
                                                <div class="mdc-text-field__bottom-line"></div>
                                            </div>
                                            <div class="mdc-layout-grid__cell--span-6 padding-top-small">   
                                                <input type="date" id="enddate" name="enddate" class="mdc-text-field__input"> 
                                                <div class="mdc-text-field__bottom-line"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--
                            <div class="mdc-layout-grid__cell--span-4">
                                <select class="search-select mdc-select">
                                    <option value="default selected">Activitiy</option>
                                    <option value="a">L'activitiy</option>
                                    <option value="b">The Activitiy</option>
                                    <option value="c">Uno Activitiy</option>
                                    <option value="d">Activitiy Name</option>
                                    <option value="e">Activitiy Nama</option>
                                </select>
                            </div>
                            <div class="mdc-layout-grid__cell--span-4">
                                <select class="search-select mdc-select">
                                    <option value="default selected">Award Criteria</option>
                                    <option value="a">Sistem Gugur</option>
                                    <option value="b">Kualitas dan Biaya</option>
                                    <option value="c">Biaya Terendah</option>
                                    <option value="d">Pagu Anggaran</option>
                                    
                                </select>
                            </div>-->
                            
                            
                            <!--
                            <div class="mdc-layout-grid__cell--span-4">
                                <select class="search-select mdc-select">
                                    <option value="default selected">Method</option>
                                    <option value="a">Lelang Umum</option>
                                    <option value="b">Lelang Sederhana</option>
                                    <option value="c">Lelang Terbatas</option>
                                    <option value="d">Seleksi Umum </option>
                                    <option value="d">Seleksi Sederhana </option>
                                    <option value="e">Pemilihan Langsung</option>
                                    <option value="e">Penunjukan Langsung</option>
                                    <option value="e">Pengadaan Langsung</option>
                                    <option value="e">e-Purchasing</option>
                                    <option value="e">Sayembara Kontes</option>
                                </select>
                            </div>-->
                            

                           <div class="search-select mdc-layout-grid__cell--span-12 pull-right">
                              <button class="mdc-button mdc-button--stroked mdc-button--compact" type="submit" name="cari">Cari</button>
                              <button class="mdc-button mdc-button--stroked mdc-button--compact" onClick="close();" >Tutup</button>
                           </div>

                        </div>
                    </div>
                </form>
            </div>
        </main>
        <!-- /search -->
    </div>            
@endsection

@section('content')
<section>
        <div class="mdc-layout-grid text-center">
          <div class="mdc-layout-grid__inner">
            <div class="mdc-layout-grid__cell mdc-layout-grid__cell--span-6">
                <div class="mdc-typography--title">Tahun Ini</div>
                <div class="mdc-layout-grid__inner">
                    <div class="mdc-layout-grid__cell mdc-layout-grid__cell--span-3">
                        <span class="mdc-typography--headline f300">  {{ MyGlobals::moneyDisplay($total_nilai_pengadaan) }}  </span>
                        <p> Pengadaan Barang / Jasa </p>
                    </div>

                    <div class="mdc-layout-grid__cell mdc-layout-grid__cell--span-3">
                        <span class="mdc-typography--headline f300">  {{ $total_paket_lelang }}  </span>
                        <span class="mdc-typography--title"> Paket </span>
                        <p>Lelang Umum</p>
                    </div>
                    <div class="mdc-layout-grid__cell mdc-layout-grid__cell--span-3">
                        <span class="mdc-typography--headline f300">{{ $total_paket_pl }}</span>
                        <span class="mdc-typography--title"> Paket </span>
                        <p>Pengadaan Langsung</p>
                    </div>
                    <div class="mdc-layout-grid__cell mdc-layout-grid__cell--span-3">
                        <span class="mdc-typography--headline f300">  {{ MyGlobals::moneyDisplay($total_nilai_pengumuman_pl) }}  </span>
                        <p>Pengumuman Pengadaan Barang / Jasa 
                        </p>
                    </div>  
                </div> 
            </div>
            <div class="mdc-layout-grid__cell mdc-layout-grid__cell--span-6">
                <div class="mdc-typography--title">Tahun Lalu ({{ date("Y")-1 }})</div>
                <div class="mdc-layout-grid__inner">
                    <div class="mdc-layout-grid__cell mdc-layout-grid__cell--span-3">
                        <span class="mdc-typography--headline f300">  {{ MyGlobals::moneyDisplay($total_prev_nilai_pengadaan) }}  </span>
                        <p> Pengadaan Barang / Jasa </p>
                    </div>

                    <div class="mdc-layout-grid__cell mdc-layout-grid__cell--span-3">
                        <span class="mdc-typography--headline f300">  {{ $total_prev_paket_lelang }}  </span>
                        <span class="mdc-typography--title"> Paket </span>
                        <p>Lelang Umum</p>
                    </div>
                    <div class="mdc-layout-grid__cell mdc-layout-grid__cell--span-3">
                        <span class="mdc-typography--headline f300">{{ $total_prev_paket_pl }}</span>
                        <span class="mdc-typography--title"> Paket </span>
                        <p>Pengadaan Langsung</p>
                    </div>
                    <div class="mdc-layout-grid__cell mdc-layout-grid__cell--span-3">
                        <span class="mdc-typography--headline f300">  {{ MyGlobals::moneyDisplay($total_prev_nilai_pengumuman_pl) }}  </span>
                        <p>Pengumuman Pengadaan Barang / Jasa 
                        </p>
                    </div>       
                </div> 
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
                            <?/*<h1 class="mdc-card__title mdc-card__title--large f300">Lelang Umum vs Pengadaan Langsung</h1>
                            <h2 class="mdc-card__subtitle">Indikator Efektif</h2>
                            <select class="mdc-select homepage-chart">
                                <option value="" default selected>Pick a year</option>
                                <option value="a">all</option>
                                <option value="b">2016</option>
                                <option value="b">2015</option>
                                <option value="b">2014</option>
                            </select>*/?>
                        </section>
                        <div class="mdc-card__horizontal-block">
                            <div id="graph01" style="min-width: 100%; height: 400px; margin: 0 auto"></div>
                            <? /*<section class="stat-settings mdc-card__actions mdc-card__actions--vertical">
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
                            </section>*/?>
                        </div>
                    </div>
                </div>

                <div class="mdc-layout-grid__cell mdc-layout-grid__cell--span-6">
                    <div class="mdc-card demo-card">
                        <section class="mdc-card__primary">
                            <?/*<h1 class="mdc-card__title mdc-card__title--large f300">Top Pengadaan SKPD</h1>
                            <h2 class="mdc-card__subtitle">Indikator Efisiensi</h2>
                            <select class="mdc-select homepage-chart">
                                <option value="" default selected>Pick a year</option>
                                <option value="a">all</option>
                                <option value="b">2016</option>
                                <option value="b">2015</option>
                                <option value="b">2014</option>
                            </select>*/?>
                        </section>
                        <div class="mdc-card__horizontal-block">
                            <div id="graph02" style="min-width: 100%; height: 400px; margin: 0 auto"></div>
                            <?/*<section class="stat-settings mdc-card__actions mdc-card__actions--vertical">
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
                            </section>*/?>
                        </div>
                    </div>
                </div>

                <div class="mdc-layout-grid__cell mdc-layout-grid__cell--span-6">
                    <div class="mdc-card demo-card">
                        <section class="mdc-card__primary">
                            <?/*<h1 class="mdc-card__title mdc-card__title--large f300">Jenis Pengadaan</h1>
                            <h2 class="mdc-card__subtitle">Indikator Efektif</h2>
                            <select class="mdc-select homepage-chart">
                                <option value="" default selected>Pick a year</option>
                                <option value="a">all</option>
                                <option value="b">2016</option>
                                <option value="b">2015</option>
                                <option value="b">2014</option>
                            </select>*/?>
                        </section>
                        <div class="mdc-card__horizontal-block">
                            <div id="graph03" style="min-width: 100%; height: 400px; margin: 0 auto"></div>
                            <?/*<section class="stat-settings mdc-card__actions mdc-card__actions--vertical">
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
                            </section>*/?>
                        </div>
                    </div>
                </div>

                <div class="mdc-layout-grid__cell mdc-layout-grid__cell--span-6">
                    <div class="mdc-card demo-card">
                        <section class="mdc-card__primary">
                            <?/*<h1 class="mdc-card__title mdc-card__title--large f300">Total Paket Pengadaan</h1>
                            <h2 class="mdc-card__subtitle">Indikator Efisiensi</h2>
                            <select class="mdc-select homepage-chart">
                                <option value="" default selected>Pick a year</option>
                                <option value="a">all</option>
                                <option value="b">2016</option>
                                <option value="b">2015</option>
                                <option value="b">2014</option>
                            </select>*/?>
                        </section>
                        <div class="mdc-card__horizontal-block">
                            <div id="graph04" style="min-width: 100%; height: 400px; margin: 0 auto"></div>
                            <?/*<section class="stat-settings mdc-card__actions mdc-card__actions--vertical">
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
                            </section>*/?>
                        </div>
                    </div>
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
                        <li id="load_perencanaan" class="mdc-list-item list-planning active">
                            <span class="mdc-list-item__text">
                                <a href="#">@lang('homepage.planning_title')</a>
                                <span class="mdc-list-item__secondary-text">@lang('homepage.planning_shortdesc')</span>
                            </span>
                        </li>
                        <li id="load_pengadaan" class="mdc-list-item  list-tender  ">
                            <span class="mdc-list-item__text">
                                <a href="#">@lang('homepage.tender_title')</a>
                                <span class="mdc-list-item__secondary-text">@lang('homepage.tender_shortdesc')</span>
                            </span>
                        </li>
                        <li id="load_pemenang" class="mdc-list-item list-award">
                            <span class="mdc-list-item__text">
                                <a href="#">@lang('homepage.award_title')</a>
                                <span class="mdc-list-item__secondary-text">@lang('homepage.award_shortdesc')</span>
                            </span>
                        </li>
                        <li id="load_kontrak" class="mdc-list-item   list-contract">
                            <span class="mdc-list-item__text">
                                <a href="#">@lang('homepage.contract_title')</a>
                                <span class="mdc-list-item__secondary-text">@lang('homepage.contract_shortdesc')</span>
                            </span>
                        </li>
                        <li id="load_implementasi" class="mdc-list-item list-implementation">
                            <span class="mdc-list-item__text">
                                <a href="#">@lang('homepage.implementation_title')</a>
                                <span class="mdc-list-item__secondary-text">@lang('homepage.implementation_shortdesc')</span>
                            </span>
                        </li>
                    </ul>
                </div>
                <div class="mdc-layout-grid__cell--span-9">
                    <div>
                        <span id="recent_procurement_title" class="mdc-typography--display1 f300"></span>
                        <i class="material-icons">sort</i>
                        <!--<select class="mdc-select">
                            <option value="Sort By" default selected>Sort by</option>
                            <option value="grains">Amount</option>
                            <option value="vegetables">Dates</option>
                            <option value="dairy">Recently updated</option>
                            <option value="meat">Procuring Entity</option>
                            <option value="fats">Budget source</option>
                        </select>-->
                    </div>
                    <div id="recent-from-api">
                    </div>
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
                    <div id="map-controls" class="nicebox">
                        <div id="filter">
                            <label class="mdc-typography--subheading1">@lang('homepage.show_contract_by')</label>
                            <span>
                                <select class="mdc-select" id="map-variable">
                                    <option value="count">Jumlah Paket Pekerjaan</option>
                                    <option value="value">Pagu Anggaran</option>
                                </select>
                            </span>
                        </div>
                        <div id="legend">
                            <div id="map-min">Min</div>
                            <div class="color-key"><span id="data-caret">&#x25c6;</span></div>
                            <div id="map-max">Maks</div>
                        </div>
                    </div>
                    <div id="map"></div>
                </div> 
                <div class="mdc-layout-grid__cell--span-6">
                    <div id="data-box">
                        <label id="data-label" for="data-value"></label>
                        <span id="data-value"></span>
                    </div>    
                </div>   

                
                <!--    <nav id="icon-text-tab-bar" class="mdc-tab-bar mdc-tab-bar--icons-with-text">
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
                                    <span class="mdc-list-item__secondary-text">KECAMATAN ASTANAANYAR</span>
                                    </span>
                                </li>
                                <li class="mdc-list-item">
                                    <span class="mdc-list-item__text">
                                 <span>02.08.2017</span>
                                    <span>Belanja Pengadaan Modal Dan Mesin-alat studio/Proyektor</span>
                                    <span class="mdc-list-item__secondary-text">KECAMATAN ASTANAANYAR</span>
                                    </span>
                                </li>
                                <li class="mdc-list-item">
                                    <span class="mdc-list-item__text">
                                 <span>02.10.2017</span>
                                    <span> Belanja Modal Peralatan Dan Mesin-Pengadaan Komputer</span>
                                    <span class="mdc-list-item__secondary-text">KECAMATAN ASTANAANYAR</span>
                                    </span>
                                </li>
                                <li class="mdc-list-item">
                                    <span class="mdc-list-item__text">
                                  <span>02.10.2017</span>
                                    <span>Belanja Pemeliharaan Bangunan</span>
                                    <span class="mdc-list-item__secondary-text">KECAMATAN ASTANAANYAR</span>
                                    </span>
                                </li>
                                <li class="mdc-list-item">
                                    <span class="mdc-list-item__text">
                                  <span>02.10.2017</span>
                                    <span>Belanja Pemeliharaan Ruangan Pelayanan</span>
                                    <span class="mdc-list-item__secondary-text">KECAMATAN ASTANAANYAR</span>
                                    </span>
                                </li>
                            </ul>
                        </p>
                    </div>-->
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

                    <?/*<div class="mdc-layout-grid__cell mdc-layout-grid__cell--span-4 blog-{{ $idx % 4 + 1 }}">
                    <div class="mdc-typography--title">{{ $row->title }}</div>
                        <p align="justify">{{ $row->summary }}</p>
                    </div>
                    <div class="mdc-layout-grid">
                        <button class="mdc-button mdc-button--compact mdc-card__action">Selengkapnya...</button>
                    </div>*/?>
                @endforeach
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
                            @foreach($app as $rowapp)
                            <li class="mdc-grid-tile">
                                <a href="{{ $rowapp['Link'] }}" title="{{ $rowapp['Title'] }}">
                                <div class="mdc-grid-tile__primary">
                                    <img class="mdc-grid-tile__primary-content" src="{{ url('images/apps/'.$rowapp['Iconimg']) }}" />
                                </div>
                                <span class="mdc-grid-tile__secondary">
                                    <span class="mdc-grid-tile__title">{{ $rowapp['Title'] }}</span>
                                </span>
                                </a>
                            </li>
                            @endforeach
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
                    <div class="mdc-typography--display1">@lang('homepage.contact_title')</div>
                    @lang('homepage.contact_text')
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