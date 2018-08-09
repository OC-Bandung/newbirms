@extends('frontend.layouts.main')

@section('header')
    @extends('frontend.layouts.nav')
@endsection

@section('content')
<div class="search-header" class="mdc-layout-grid">
        <div class="mdc-layout-grid__inner">
            <div class="mdc-layout-grid__cell--span-8">
                <h2 class="mdc-typography--display1">Hasil pencarian pengadaan </h2>
                <p>Terdapat <strong><span class="totalsearch"></span></strong> kontrak</p>
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
                    Insert Here
                    <div class="mdc-card procurement-card text-center">
                        <section class="mdc-card__primary">
                            <button class="mdc-button">view more</button>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('footer')
<script type="text/javascript"> 
    $.ajax({ 
    type: 'GET', 
    url: 'http://localhost/oc-bandung/newbirms_old/public/api/search?q=test&ta=2017', 
    data: { get_param: 'value' }, 
    dataType: 'json',
    success: function (data) { 
        $.each(data, function(index, element) {
            $('body').append($('<div>', {
                text: element.name
            }));
        });
    }
});
</script>
@endsection