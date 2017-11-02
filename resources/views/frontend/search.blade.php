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
                                    <option value="default selected">Stage</option>
                                    <option value="a">Planning</option>
                                    <option value="b">Tender</option>
                                    <option value="c">Award</option>
                                    <option value="d">Contract</option>
                                    <option value="e">Implementation</option>
                                </select>
                            </div>
                            <div class="mdc-layout-grid__cell--span-4">
                                <select class="search-select mdc-select">
                                    <option value="default selected">SKPD</option>
                                    <option value="a">SKPD Name</option>
                                    <option value="b">SKPD Nama</option>
                                    <option value="c">Le SKPD</option>
                                    <option value="d">La SKPD</option>
                                    <option value="e">The SKPD</option>
                                </select>
                            </div>
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
                            </div>
                            <div class="mdc-layout-grid__cell--span-4">
                                <select class="search-select mdc-select">
                                    <option value="default selected">Category</option>
                                    <option value="a">Barang</option>
                                    <option value="b">Pekerjaan Konstruksi</option>
                                    <option value="c">Jasa Konsultansi</option>
                                    <option value="d">Jasa Konsultansi</option>
                                    <option value="e">Other</option>
                                </select>
                            </div>
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
                            </div>

   
     
                            
                             <div class="search-select mdc-layout-grid__cell--span-12 ">
                                <label>Value</label>
                                <div class="mdc-layout-grid__cell--span-12 padding-top-small">
                                    <input type="text" placeholder="Min"  class="mdc-textfield__input">
                             
                                    <input type="text" placeholder="Max "  class="mdc-textfield__input">
                                </div>
                            </div>

                            <div class="search-select mdc-layout-grid__cell--span-12">
                                <label>Date</label>
                                 <div class="mdc-layout-grid__cell--span-12 padding-top-small">   
                                    <input type="date" class="search-select"> 
                                    <input type="date" class="search-select"> 
                                </div>
                            </div>

                           <div class="search-select mdc-layout-grid__cell--span-12 pull-right">
                              <button class="mdc-button mdc-button--stroked mdc-button--compact">Search</button>
                              <button class="mdc-button mdc-button--stroked mdc-button--compact" >CLOSE</button>
                           </div>

                        </div>
                    </div>
                </form>
                 
            </div>
        </main>            <!-- /search -->