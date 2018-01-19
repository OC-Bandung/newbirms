<!-- Search -->
<main class="main-wrap">
            <div class="search">
                <button id="btn-search-close" class="btn btn--search-close" aria-label="Close search form">
                    <i class="material-icons">close</i>
                </button>
                <form class="search__form" action="">
                    <button class="btn btn--search">
                        <svg class="icon icon--search">
                            <use xlink:href="#icon-search"></use>
                        </svg>
                    </button>
                    <input id="search-input" class="search__input" name="search" type="search" placeholder="" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" />
                    <div class="mdc-layout-grid">
                        <div class="mdc-layout-grid__inner">
                            <div class="mdc-layout-grid__cell--span-4">
                                <select class="search-select  mdc-select ">
                                    <option value="default selected">Pilih Tahapan</option>
                                    <option value="1">Perencanaan</option>
                                    <option value="2">Lelang</option>
                                    <option value="3">Pemenang</option>
                                    <option value="4">Kontrak</option>
                                    <option value="5">Implementasi</option>
                                </select>
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
                            <div class="mdc-layout-grid__cell--span-4">
                                <select class="search-select mdc-select">
                                    <option value="">Pilih Kategori</option>
                                    <option value="01">Konstruksi</option>
                                    <option value="02">Pengadaan Barang</option>
                                    <option value="03">Jasa Konsultansi</option>
                                    <option value="04">Jasa Lainnya</option>
                                </select>
                            </div>
                            <div class="mdc-layout-grid__cell--span-8">
                                <select class="search-select mdc-select">
                                    <option value="default selected">Pilih SKPD</option>
                                    @foreach($ref_skpd as $row)
                                    <option value="{{ $row->unitID }}">{{ $row->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
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
                          
                             <div class="search-select mdc-layout-grid__cell--span-12 ">
                                <label>Nilai Anggaran</label>
                                <div class="mdc-layout-grid__cell--span-12 padding-top-small">
                                    <input type="text" placeholder="Min"  class="mdc-textfield__input">
                                    <input type="text" placeholder="Maks "  class="mdc-textfield__input">
                                </div>
                            </div>

                            <div class="search-select mdc-layout-grid__cell--span-12">
                                <label>Tanggal</label>
                                 <div class="mdc-layout-grid__cell--span-12 padding-top-small">   
                                    <input type="date" class="search-select"> 
                                    <input type="date" class="search-select"> 
                                </div>
                            </div>

                           <div class="search-select mdc-layout-grid__cell--span-12 pull-right">
                              <button class="mdc-button mdc-button--stroked mdc-button--compact">Cari</button>
                              <button class="mdc-button mdc-button--stroked mdc-button--compact" onClick="close();" >Tutup</button>
                           </div>

                        </div>
                    </div>
                </form>
                 
            </div>
        </main>            <!-- /search -->