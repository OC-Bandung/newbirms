@extends('frontend.layouts.main')

@section('header')
    @extends('frontend.layouts.nav')
@endsection

@section('content')
<div class="search-header" class="mdc-layout-grid">
        <div class="mdc-layout-grid__inner">
            <div class="mdc-layout-grid__cell--span-8">
                <h2 class="mdc-typography--display1">Hasil pencarian pengadaan </h2>
                <p>Terdapat <strong>{{ $totalsearch }}</strong> kontrak</p>
            </div>
        </div>
    </div>
    <section>
        <div class="search-content mdc-layout-grid procurement-grid">
            <div class="mdc-layout-grid__inner ">
                <div class="mdc-layout-grid__cell--span-3 sticky">
                    <form action="{{ url('search') }}" method="get">
                    <h3>Filter pencarian</h3>
                    <div class="mdc-text-field">
                        <label for="min">Pagu Anggaran / Kontrak</label>
                        <div class="mdc-text-field mdc-text-field--box">
                            <input type="text" id="q" name="q" class="mdc-text-field__input" placeholder="Cari" value="{{ app('request')->input('q') }}"> 
                            <div class="mdc-text-field__bottom-line"></div>
                        </div>                       
                    </div>
                    <div class="mdc-select">
                        <select class="mdc-select__surface" name="tahun" id="tahun" placeholder="Tahun">
                            <option value="" disabled selected>- Tahun -</option>
                            @for ($i = date("Y"); $i >= 2013; $i--)
                                @if (app('request')->input('tahun') == $i)
                                    <option value="{{ $i }}" selected>{{ $i }}</option>
                                @else
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endif
                            @endfor
                        </select>
                        <div class="mdc-select__bottom-line"></div>
                    </div>
                    <div class="mdc-select">
                        <select class="mdc-select__surface" name="skpdID">
                            <option value="" disabled selected>- SKPD -</option>
                            @foreach($ref_skpd as $row)
                                @if (app('request')->input('skpdID') == $row->skpdID)
                                    <option value="{{ $row->skpdID }}" selected>{{ $row->unitID }} - {{ $row->nama }}</option>
                                @else
                                    <option value="{{ $row->skpdID }}">{{ $row->unitID }} - {{ $row->nama }}</option>
                                @endif
                            @endforeach
                        </select>
                        <div class="mdc-select__bottom-line"></div>
                    </div>
                    <div class="mdc-select">                                
                        <select class="mdc-select__surface" name="klasifikasi" id="klasifikasi">
                            <option value="" disabled selected>- Klasifikasi -</option>
                            @if (app('request')->input('klasifikasi') == '01')
                            <option value="01" selected>Konstruksi</option>
                            @else
                            <option value="01">Konstruksi</option>
                            @endif
                            @if (app('request')->input('klasifikasi') == '02')
                            <option value="02" selected>Pengadaan Barang</option>
                            @else
                            <option value="02">Pengadaan Barang</option>
                            @endif
                            @if (app('request')->input('klasifikasi') == '03')
                            <option value="03" selected>Jasa Konsultansi</option>
                            @else
                            <option value="03">Jasa Konsultansi</option>
                            @endif
                            @if (app('request')->input('klasifikasi') == '04')
                            <option value="04" selected>Jasa Lainnya</option>
                            @else
                            <option value="04">Jasa Lainnya</option>
                            @endif
                        </select>
                        <div class="mdc-select__bottom-line"></div>
                    </div>
                    <div class="mdc-text-field">
                        <label for="min">Pagu Anggaran / Kontrak</label>
                        <div class="mdc-text-field mdc-text-field--box">
                            @if (!empty(app('request')->input('min')))
                            <input type="text" id="min" name="min" class="mdc-text-field__input" placeholder="Min" value="{{ app('request')->input('min') }}">
                            @else
                            <input type="text" id="min" name="min" class="mdc-text-field__input" placeholder="Min">
                            @endif
                            <div class="mdc-text-field__bottom-line"></div>
                        </div>
                        <div class="mdc-text-field mdc-text-field--box">
                            @if (!empty(app('request')->input('max')))
                            <input type="text" id="max" name="max" class="mdc-text-field__input" placeholder="Max" value="{{ app('request')->input('max') }}">
                            @else
                            <input type="text" id="max" name="max" class="mdc-text-field__input" placeholder="Maks">
                            @endif
                            <div class="mdc-text-field__bottom-line"></div>
                        </div> 
                    </div>                                                
                    <div class="mdc-select">
                        <select class="mdc-select__surface" name="tahap" id="tahap" placeholder="Pilih Tahapan">
                            <option value="" disabled selected>- Tahapan -</option>
                            <option value="1">Perencanaan</option>
                            <option value="2">Pengadaan</option>
                            <option value="3">Pemenang</option>
                            <option value="4">Kontrak</option>
                            <option value="5">Implementasi</option>
                        </select>
                        <i class="material-icons mdc-text-field__icon" tabindex="0">warning</i>
                        <div class="mdc-select__bottom-line"></div>
                    </div>     
                    <div class="mdc-text-field">
                        <label for="startdate">Tanggal <i class="material-icons mdc-text-field__icon" tabindex="0">warning</i></label>
                        <div class="mdc-text-field">
                            <div class="mdc-layout-grid__inner">
                                <div class="mdc-layout-grid__cell--span-12 padding-top-small">   
                                    <input type="date" id="startdate" name="startdate" class="mdc-text-field  mdc-text-field--box"> 
                                    <input type="date" id="enddate" name="enddate" class="mdc-text-field  mdc-text-field--box"> 
                                </div>
                            </div>
                        </div>
                    </div>
                    <button class="mdc-button mdc-button--stroked mdc-button--compact" type="submit" name="cari">Cari</button>
                    </form>
                </div>
                <div class="mdc-layout-grid__cell--span-9">
                    @foreach($pengadaan as $row) 
                    <div class="mdc-card procurement-card">
                        <section class="mdc-card__primary">
                            <h1 class="mdc-card__title mdc-card__title--large f300">{{ $row->namapekerjaan}}</h1>
                            <h2 class="mdc-card__subtitle">Pemerintah Kota Bandung - {{ $row->namaskpd}}</h2>
                            <h3 class="mdc-card__subtitle dark-gray">SirupID: #{{ $row->sirupID }} </h3>
                        </section>
                        <section class="mdc-card__supporting-text ">
                            <div class="procurement-card-container flex">
                                <div class="procurement-card-details padding-small text-center">
                                    <img class="icon-large" src="img/icon-money.png">
                                    <div class="mdc-typography--subheading1"> Anggaran </div>
                                    <div> <span class="mdc-typography--title f300"> {{ MyGlobals::moneyDisplay($row->anggaran,0,',','.') }}</span></div>
                                </div>
                                <div class="procurement-card-details padding-small text-center">
                                    <img class="icon-large" src="img/icon-gov.png">
                                    <div class="mdc-typography--subheading1"> Sumber Dana </div>
                                    <div class="mdc-typography--title f300"> {{ $row->sumberdana }} </div>
                                </div>
                                <div class="procurement-card-details padding-small text-center">
                                    <img class="icon-large" src="img/icon-tender-start.png">
                                    <div class="mdc-typography--subheading1"> Rencana Pengadaan Mulai</div>
                                    <div class="mdc-typography--title f300"> 
                                        @if (!empty($row->pilih_start))
                                            {{ date('d-m-Y', strtotime($row->pilih_start)) }} 
                                        @else
                                            &mdash;
                                        @endif    
                                    </div>
                                </div>
                                <div class="procurement-card-details padding-small text-center">
                                    <img class="icon-large" src="img/icon-tender-end.png">
                                    <div class="mdc-typography--subheading1"> Rencana Pengadaan Selesai</div>
                                    <div class="mdc-typography--title f300">
                                        @if (!empty($row->pilih_end))
                                            {{ date('d-m-Y', strtotime($row->pilih_end)) }} 
                                        @else
                                            &mdash;
                                        @endif 
                                    </div>
                                </div>
                                <div class="procurement-card-details padding-small text-center ">
                                    <img class="icon-large" src="img/icon-contract-start.png">
                                    <div class="mdc-typography--subheading1">Pelaksanaan Mulai</div>
                                    <div class="mdc-typography--title f300">
                                        @if (!empty($row->laksana_start))
                                            {{ date('d-m-Y', strtotime($row->laksana_start)) }} 
                                        @else
                                            &mdash;
                                        @endif
                                    </div>
                                </div>
                                <div class="procurement-card-details padding-small text-center">
                                    <img class="icon-large" src="img/icon-contract-end.png">
                                    <div class="mdc-typography--subheading1">Pelaksanaan Selesai</div>
                                    <div class="mdc-typography--title f300">
                                        @if (!empty($row->laksana_end))
                                            {{ date('d-m-Y', strtotime($row->laksana_end)) }} 
                                        @else
                                            &mdash;
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div>
                                <p>Klasifikasi Pengadaan ini untuk <i> <u> {{ $row->klasifikasi }}</u></i> menggunakan metode <i> <u>{{ $row->metodepengadaan }}</u></i>.</p>
                            </div>
                        </section>
                        <!-- <section class="mdc-card__actions pull-right">
                            <button class="mdc-button mdc-button--compact mdc-card__action">
                                Apply in Sirup 1
                            </button>
                            <button class="mdc-button mdc-button--compact mdc-card__action">
                                Download
                            </button>
                            <button class="mdc-button mdc-button--compact mdc-card__action">Email</button>
                        </section>-->
                    </div>
                    @endforeach
                    <div class="mdc-card procurement-card text-center">
                        <section class="mdc-card__primary">
                            {{ $pengadaan->links() }}
                            <button class="mdc-button">view more</button>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection