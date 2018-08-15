@extends('frontend.layouts.main')

@section('header')
    @include('frontend.layouts.nav')
@endsection

@section('content')

<section class="bg-primary">
    <div class="container">
      <div class="row">
        <form action="{{ url('search') }}" method="get">
        <div class="col-12 bg-primary bg-opacity p-4 mt-4">
          <h4><span class="font-weight-700">Cari</span> Tender dan kontrak</h4>
          <div class="input-group w-50">
            <input type="text" class="form-control" name="q" placeholder="Isikan kata yang dicari" value="{{ app('request')->input('q') }}" aria-label="Search" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false">
            <div class="input-group-append">
                <button class="btn btn-dark" type="submit">Cari</button>
            </div>
          </div>

          <div  class="pt-4">

            <div class="row">
              
              <div class="col">
                  <div class="form-group">
                     <h6> Tahun </h6>
                        <select class="form-control" name="tahun" id="tahun">
                            <option value="" disabled selected>Pilih Tahun</option>
                            @for ($i = date("Y"); $i >= 2013; $i--)
                                @if (app('request')->input('tahun') == $i)
                                    <option value="{{ $i }}" selected>{{ $i }}</option>
                                @else
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endif
                            @endfor
                        </select>
                  </div>
              </div>

              <div class="col">
                <div class="form-group">
                   <h6> Tahapan </h6>
                   <select class="form-control" name="tahap" id="tahap">
                        <option value="" disabled selected>Pilih Tahapan</option>
                        @if (app('request')->input('tahap') == '1')
                        <option value="1" selected>Perencanaan</option>
                        @else
                        <option value="1">Perencanaan</option>
                        @endif
                        @if (app('request')->input('tahap') == '2')
                        <option value="2" selected>Pengadaan</option>
                        @else
                        <option value="2">Pengadaan</option>
                        @endif
                        @if (app('request')->input('tahap') == '3')
                        <option value="3" selected>Pemenang</option>
                        @else
                        <option value="3">Pemenang</option>
                        @endif
                        @if (app('request')->input('tahap') == '4')
                        <option value="4" selected>Kontrak</option>
                        @else
                        <option value="4">Kontrak</option>
                        @endif
                        @if (app('request')->input('tahap') == '5')
                        <option value="5" selected>Implementasi</option>
                        @else
                        <option value="5">Implementasi</option>
                        @endif
                    </select>
                </div>
              </div>

              <div class="col">
                <div class="form-group">
                   <h6> Klasifikasi </h6>
                    <select class="form-control" name="klasifikasi" id="klasifikasi">
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
                </div>
              </div>

              <div class="col">
                <div class="form-group justify-content-between">
                   <h6> Pagu Anggaran / Nilai Kontrak </h6>
                   <div class="row">
                     <div class="col">
                       <input type="text" class="form-control" placeholder="Min">
                     </div>
                     <div class="col">
                       <input type="text" class="form-control" placeholder="Max">
                    </div>
                  </div>
                </div>
              </div>

            </div>

            <div class="row">
              <div class="col-6">
                <div class="form-group justify-content-between">
                   <h6>Tanggal</h6>
                   <div class="row">
                      <div class="col">
                        <input type="date" class="form-control" name="startdate" id="startdate" value="{{ app('request')->input('startdate') }}">
                      </div>
                      <div class="col">
                        <input type="date" class="form-control" name="enddate" id="enddate" value="{{ app('request')->input('enddate') }}">
                      </div>
                    </div>
                 </div>
               </div>
            </div>

          </div>
        </div>
        </form>
      </div>
    </div>
  </section>

  <section>
    <div class="container">
      <div class="row pt-3">
        <div class="col">
          <h3>Hasil Pencarian Pengadaan </h3>
          <p>Terdapat <strong>{{ $totalsearch }}</strong> kontrak, berdasarkan kata kunci <strong>{{ app('request')->input('q') }}</strong></p>
        </div>
      </div>

      <div class="row">
        <div class="col">
          <div id="search-results" class="list-group">
          @foreach($pengadaan as $row) 
            <a href="#" class="list-group-item list-group-item-action flex-column align-items-start">
              <span class="badge badge-dark">Perencanaan</span>
              <div class="d-flex w-100 justify-content-between pt-1">
                <span><h5 class="mb-1">{{ $row->namapekerjaan }}</h5></span>
                <span class="float-right"> {{ MyGlobals::moneyDisplay($row->anggaran,0,',','.') }} </span>
              </div>
             <div class="h6">Tanggal Rencana Pengadaan : @if (!empty($row->pilih_start))
                                            {{ date('d-m-Y', strtotime($row->pilih_start)) }} 
                                        @else
                                            &mdash;
                                        @endif  -  Klasifikasi: {{ $row->klasifikasi }}</div>
            </a>
          @endforeach
          </div>
        </div>
      </div>

      <div class="row">
          <div class="col pt-3 text-center">
          <?/*{{ $pengadaan->links() }}
              <button type="button" class="btn btn-outline-dark font-primary">Load more</button>*/?>
          </div>
      </div>


    </div>
  </section>

@endsection