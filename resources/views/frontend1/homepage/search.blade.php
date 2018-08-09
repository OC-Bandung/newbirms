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
                            <div class="mdc-layout-grid__cell--span-4">
                                <div class="search-select">
                                    <select  name="tahun" id="tahun" placeholder="Tahun">
                                        <option value="" disabled selected>- Tahun -</option>
                                        @for ($i = date("Y"); $i >= 2013; $i--)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                        @endfor
                                    </select>
                                   
                                </div>
                            </div>
                            <div class="mdc-layout-grid__cell--span-8">
                                <div class="search-select">
                                    <select   name="skpdID">
                                        <option value="" disabled selected>- SKPD -</option>
                                        @foreach($ref_skpd as $row)
                                        <option value="{{ $row->skpdID }}">{{ $row->unitID }} - {{ $row->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            
                             <div class="mdc-layout-grid__cell--span-4">
                                <div class="search-select">
                                    <select class="search-select__surface" name="tahap" id="tahap" placeholder="Pilih Tahapan">
                                        <option value="" disabled selected>- Tahapan -</option>
                                        <option value="1">Perencanaan</option>
                                        <option value="2">Pengadaan</option>
                                        <option value="3">Pemenang</option>
                                        <option value="4">Kontrak</option>
                                        <option value="5">Implementasi</option>
                                    </select> 
                                    
                                </div>     
                            </div>

                            <div class="mdc-layout-grid__cell--span-4">
                                <div class="search-select">                                
                                    <select name="klasifikasi" id="klasifikasi">
                                        <option value="" disabled selected>- Klasifikasi -</option>
                                        <option value="01">Konstruksi</option>
                                        <option value="02">Pengadaan Barang</option>
                                        <option value="03">Jasa Konsultansi</option>
                                        <option value="04">Jasa Lainnya</option>
                                    </select> 
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
                            
                            <div class="mdc-layout-grid__cell--span-8">
                                <div class="search-select">
                                    <label for="startdate">Tanggal</label>
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