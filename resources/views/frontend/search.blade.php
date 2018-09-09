@extends('frontend.layouts.main')

@section('header')
    @include('frontend.layouts.nav')
@endsection

@section('content')

<section class="bg-primary">
  <div class="container">
  <form action="{{ url('search') }}" method="get">
		{{ csrf_field() }}
          <div class="row">
            <div class="col-12 bg-primary bg-opacity p-3 mt-3">
            <h4><span class="font-weight-700">Cari</span> Tender dan kontrak</h4>
            <div class="input-group w-50">
            <input type="text" class="form-control" name="q" placeholder="Isikan kata yang dicari" value="{{ app('request')->input('q') }}" aria-label="Search" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false">
            <div class="input-group-append">
                <button class="btn btn-dark" type="submit">Cari</button>
            </div>
            </div>	
            </div>
      </div>
      <div class="row">
        <div class="col-4">
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
                <div class="col-4">
                  <div class="form-group">
                    <h6> Tahapan </h6>
                    <select class="form-control" name="tahap" id="tahap">
                                <option value="0">-Semua Tahapan-</option>
                                @if (app('request')->input('tahap') == '1')
                                <option value="1" selected>Perencanaan</option>
                                @else
                                <option value="1">Perencanaan</option>
                                @endif
                                @if (app('request')->input('tahap') == '2')
                                <option value="2" selected>Aktif</option>
                                @else
                                <option value="2">Aktif</option>
                                @endif
                                @if (app('request')->input('tahap') == '3')
                                <option value="3" selected>Gagal</option>
                                @else
                                <option value="3">Gagal</option>
                                @endif
                                @if (app('request')->input('tahap') == '4')
                                <option value="4" selected>Selesai</option>
                                @else
                                <option value="4">Selesai</option>
                                @endif
                            </select>
                  </div>
                </div>
                <div class="col-4">
                  <div class="form-group">
                    <h6> Klasifikasi </h6>
                    <select class="form-control" name="jenis_pengadaanID" id="jenis_pengadaanID">
                                <option value="0">-Semua Klasifikasi-</option>
                                @if (app('request')->input('jenis_pengadaanID') == '1')
                                <option value="1" selected>Pengadaan Barang</option>
                                @else
                                <option value="1">Pengadaan Barang</option>
                                @endif
                                @if (app('request')->input('jenis_pengadaanID') == '2')
                                <option value="2" selected>Pekerjaan Konstruksi</option>
                                @else
                                <option value="2">Pekerjaan Konstruksi</option>
                                @endif
                                @if (app('request')->input('jenis_pengadaanID') == '3')
                                <option value="3" selected>Jasa Konsultansi</option>
                                @else
                                <option value="3">Jasa Konsultansi</option>
                                @endif
                                @if (app('request')->input('jenis_pengadaanID') == '4')
                                <option value="4" selected>Jasa Lainnya</option>
                                @else
                                <option value="4">Jasa Lainnya</option>
                                @endif
                            </select>
                  </div>
                </div>	
      </div>
      <div class="row">
        <div class="col-12">
                    <div class="form-group justify-content-between">
                      <h6> Pagu Anggaran / Nilai Kontrak </h6>
                      <div class="row">
                        <div class="col">
                          <div class="input-group mb-3">
                            <div class="input-group-prepend">
                              <span class="input-group-text" id="cmin">Rp.</span>
                            </div>
                            <input type="text" class="form-control" placeholder="Min" name="min" id="min" aria-label="Min" aria-describedby="cmin" value="{{ app('request')->input('min') }}">
                          </div>
                        </div>
                        <div class="col">
                            <div class="input-group mb-3">
                              <div class="input-group-prepend">
                                <span class="input-group-text" id="cmax">Rp.</span>
                              </div>
                              <input type="text" class="form-control" placeholder="Max" name="max" id="max" aria-label="Max" aria-describedby="cmax" value="{{ app('request')->input('max') }}">
                            </div>
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
    </form>
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
            <a href="{{ url('contract?ocid='.$row->ocid) }}" class="list-group-item list-group-item-action flex-column align-items-start">
              <span class="badge badge-dark">{{ $row->tahapan }}</span>
              <small class="float-right">{{ $row->ocid }}</small>
              <div class="d-flex w-100 justify-content-between pt-1">
                <span><h5 class="mb-1">{{ $row->namapekerjaan }}</h5></span>
                <span class="float-right">Pagu: {{ MyGlobals::moneyDisplay($row->pagu_anggaran) }} </span>
              </div>
              <div>
                <h6>SKPD : {{ $row->namaskpd }}</h6>
                @if ($row->nilai_nego != 0)
                <span class="float-right">Kontrak: {{ MyGlobals::moneyDisplay($row->nilai_nego,0,',','.') }}</span>
                @endif
              </div>
             <div class="h6"><i class="material-icons">calendar_today</i> Rencana Pengadaan : @if (!empty($row->tanggal_awal_pengadaan))
                                            {{ date('d-m-Y', strtotime($row->tanggal_awal_pengadaan)) }} 
                                        @else
                                            &mdash;
                                        @endif  -  Klasifikasi: {{ $row->jenis_pengadaan }}</div>
            </a>
          @endforeach
          </div>
        </div>
      </div>

      <div class="row">
          <div class="col pt-3 text-center">
          {{ $pengadaan->links('pagination.limit_links') }}
          <?/*  <button type="button" class="btn btn-outline-dark font-primary">Load more</button>*/?>
          </div>
      </div>


    </div>
  </section>

@endsection