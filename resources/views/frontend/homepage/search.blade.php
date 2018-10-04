<section id="search">
  <div class="container-fluid mt-2">
    <div class="row">
      <div class="col-12 bdg-city">
        <form action="{{ url('search') }}" method="get">
		 {{ csrf_field() }}
         <input type="hidden" name="per_page" value="10">
        <div class="img-bg" style="background-image:url('{{ url('img/bandung.png') }}')">
          <div class="row justify-content-md-center">
          	<div class="col-12 col-lg-6 bg-primary bg-opacity p-4 mt-2">
              <div class="row">
                  <div class="col"><h4><span class="font-weight-700">Cari</span> Tender dan Kontrak</h4></div>
                  <div class="col">
                    <div align="right">
                        OC Explorer
                    </div>
                  </div>
              </div>
            <div class="input-group">
              <input type="text" class="form-control" name="q" placeholder="Isikan kata yang dicari" aria-label="Search" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false">
              <div class="input-group-append">
                <button class="btn btn-dark" type="submit">Cari</button>
              </div>
            </div>

            <div class="pt-2">
              <span><small>* Gunakan <strong>Filter</strong> Tingkat Lanjut Untuk Pilihan lainnya <!-- Use advanced filters for more options.--></small></span>
              <div class="float-right">
              		<a class="h6 no-underline" href="#" data-toggle="collapse" data-target="#search-filters">Filter <i class="material-icons align-middle"> arrow_drop_down </i> </a>
				      </div>              
            </div>


            <div id="search-filters" class="pt-3 collapse">

              <div class="row">
                <div class="col">
                    <div class="form-group">
                       <h6> Tahun </h6>
                        <select class="form-control" name="tahun" id="tahun">
                          @for ($i = date("Y"); $i >= 2013; $i--)
                          <option value="{{ $i }}">{{ $i }}</option>
                          @endfor
                        </select>
                    </div>
                </div>
                <div class="col">
                  <div class="form-group">
                     <h6> Tahapan </h6>
                      <select class="form-control" name="tahap" id="tahap">
                        <option value="0">-Semua Tahapan-</option>
                        <option value="1">Perencanaan</option>
                        <option value="2">Aktif</option>
                        <option value="3">Gagal</option>
                        <option value="4">Selesai</option>
                      </select>
                  </div>
                </div>
                <div class="col">
                  <div class="form-group">
                     <h6> Klasifikasi </h6>
                      <select class="form-control" name="jenis_pengadaanID" id="jenis_pengadaanID">
                        <option value="0">-Semua Klasifikasi-</option>
                        <option value="1">Pengadaan Barang</option>
                        <option value="2">Pekerjaan Konstruksi</option>
                        <option value="3">Jasa Konsultansi</option>
                        <option value="4">Jasa Lainnya</option>
                      </select>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col">
                  <div class="form-group justify-content-between">
                     <h6> Pagu Anggaran / Nilai Kontrak </h6>
                     <div class="row">
                       <div class="col">
                        <div class="input-group mb-3">
                          <div class="input-group-prepend">
                            <span class="input-group-text" id="cmin">Rp.</span>
                          </div>
                          <input type="text" class="form-control" placeholder="Min" name="min" id="min" aria-label="Min" aria-describedby="cmin">
                        </div>
                       </div>
                       <div class="col">
                          <div class="input-group mb-3">
                            <div class="input-group-prepend">
                              <span class="input-group-text" id="cmax">Rp.</span>
                            </div>
                            <input type="text" class="form-control" placeholder="Max" name="max" id="max" aria-label="Max" aria-describedby="cmax">
                          </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col">
                  <div class="form-group justify-content-between">
                     <h6>Tanggal</h6>
                     <div class="row">
                       <div class="col">
                         <input type="date" class="form-control" name="startdate" id="startdate">
                       </div>
                        <div class="col">
                          <input type="date" class="form-control" name="enddate" id="enddate" >
                        </div>
                     </div>
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
  </div>
</section>

<section>
  <div class="container-fluid">
    <div class="row mb-0">
      <div id="bdg-secondary-nav" class="col-12 m-0 p-0" style="position: relative; z-index: 2;">
        <ul class="list-inline text-lowercase bg-dark  p-1 text-center text-uppercase">
          <li class="nav-item list-inline-item text-light"><a class="navbar-brand" href="http://birms.bandung.go.id/beta"><img src="img/birms-white.png"></a></li>
          <li class="nav-item list-inline-item"><a class="nav-link text-light" href="#search">Cari</a></li>
          <li class="nav-item list-inline-item"><a class="nav-link text-light" href="#about">Tentang birms</a></li>
          <li class="nav-item list-inline-item"><a class="nav-link text-light" href="#statistik">Statistik</a></li>
          <li class="nav-item list-inline-item"><a class="nav-link text-light" href="#currprocurement">Pengadaan Terkini</a></li>
          <li class="nav-item list-inline-item"><a class="nav-link text-light" href="#transparency">Transparansi</a></li>
          <li class="nav-item list-inline-item"><a class="nav-link text-light" href="#news">Berita</a></li>
          <li class="nav-item list-inline-item"><a class="nav-link text-light" href="#appsquestion">Kontak</a></li>
        </ul>
      </div>
    </div>
  </div>
</section>
