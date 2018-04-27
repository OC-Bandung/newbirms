<section class="mdc-layout-grid  bg-white-transparent">

        <div>
          <div class="mdc-layout-grid__inner">
            <div class="mdc-layout-grid__cell mdc-layout-grid__cell--span-12">
                <div class="mdc-layout-grid__inner">
                    <div class="mdc-layout-grid__cell mdc-layout-grid__cell--span-3">
                            <div>
                                <div>Pengadaan Barang / Jasa</div>
                                <div class="padding-top-small ">
                                   <span class="padding-right-small">2018: </span>
                                   <span>{{MyGlobals::moneyDisplay($total_nilai_pengadaan) }}</span> 
                                </div>
                                <div>
                                   <span class="padding-right-small">2017: </span>
                                   <span>
                                    Rp. 1,43 T
                                    <!-- {{ MyGlobals::moneyDisplay($total_prev_nilai_pengadaan) }} --> </span> 
                                </div>
                            </div>
                    </div>

                    <div class="mdc-layout-grid__cell mdc-layout-grid__cell--span-2">

                        <div>
                                <div>Lelang Umum</div>
                                <div  class="padding-top-small">
                                   <span class="padding-right-small">2018: </span>
                                   <span>{{ $total_prev_paket_lelang }}</span> 
                                </div>
                                <div>
                                   <span class="padding-right-small">2017: </span>
                                   <span> 
                                    367 Paket
                                  <!--  {{ $total_prev_paket_pl }} -->
                                   </span> 
                                </div>
                            </div>
                    </div>

                     <div class="mdc-layout-grid__cell mdc-layout-grid__cell--span-3">

                        <div >
                                <div>Pengadaan Langsung</div>
                                <div class="padding-top-small">
                                   <span class="padding-right-small">2018:</span>
                                   <span>{{ $total_paket_pl }}</span> 
                                </div>
                                <div>
                                   <span class="padding-right-small">2017:</span>
                                   <span> 
                                    8.776 Paket
                                   <!-- {{ $total_prev_paket_pl }} -->
                                    </span> 
                                </div>
                            </div>
                    </div>

                     <div class="mdc-layout-grid__cell mdc-layout-grid__cell--span-4">

                        <div >
                                <div>Pengumuman Pengadaan Barang / Jasa </div>
                                <div class="padding-top-small">
                                   <span class="padding-right-small">2018:</span>
                                   <span>{{ MyGlobals::moneyDisplay($total_nilai_pengumuman_pl) }} </span> 
                                </div>
                                <div>
                                   <span class="padding-right-small">2017:</span>
                                   <span>
                                    Rp. 585,42 M
                                  <!--  {{ MyGlobals::moneyDisplay($total_prev_nilai_pengumuman_pl) }}  -->
                               </span> 
                                </div>
                            </div>
                    </div>
  

                </div> 
            </div>

           

          </div>
        </div>
 
    </section>