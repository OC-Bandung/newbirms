<section class="bg-primary">
  <div class="container pt-5">
    <div class="row">
      <div class="col-4">
        <h3 class="color-white">@lang('homepage.procurement_map_title')</h3>
      </div>
      <div class="col-8">
        <p>@lang('homepage.procurement_map_shortdesc')</p>
      </div>

      <div class="containter mt-5 mb-5">
        <div class="row no-gutter">

          <div class="col-9 bg-light pt-5 pb-5 pl-5">
              <div class="row no-gutter">
                  <div class="col-5">
                    <div id="map-controls">
                        <div id="filter">
                            <h5>@lang('homepage.procurement_map_title')</h5>
                            <div class="select-style">
                                <select id="map-variable">
                                    <option value="count">Jumlah Paket Pekerjaan</option>
                                    <option value="value">Pagu Anggaran</option>
                                </select>
                            </div>
                        </div>
                   </div>
                 </div>

                 <div class="col">
                   <h5> Number </h5>
                   <h2> 2000 </h2>
                 </div>

                 <div class="col">
                   <h5> Nilai Kontrak </h5>
                   <span class="h4"> Rp. </span> <span id="data-value"></span> </h4>
                 </div>

               </div>

                 <div class="row no-gutter">
                  <div id="map" class="pt-3">
                  </div>
                </div>

          </div>

          <div class="col-3 bg-light  pt-5">
            <div> <span class="h5">Recent transactions </span>   <span class="float-right"> <small > |  <a href="#"> VIEW ALL  </a> </small> <span> </div>

            <div class="list-group">

              <a href="#" class="list-group-item list-group-item-action flex-column align-items-start">
                <span class="badge badge-dark">Planning</span>
                <div class="d-flex w-100 justify-content-between">
                  <h5 class="mb-1">PEMBANGUNAN PJL Gg. Campaka IX, VIII, Gg. Karang Tineung</h5>
                </div>

                <small class="text-muted">Today</small> | <small class="text-muted">View</small>
              </a>

                <a href="#" class="list-group-item list-group-item-action flex-column align-items-start">
                  <span class="badge badge-dark">Contract</span>
                  <div class="d-flex w-100 justify-content-between">
                    <h5 class="mb-1">Narasumber</h5>
                  </div>

                  <small class="text-muted">1 day ago</small> | <small class="text-muted">View</small>
                </a>


                <a href="#" class="list-group-item list-group-item-action flex-column align-items-start">
                  <span class="badge badge-dark">Tender</span>
                  <div class="d-flex w-100 justify-content-between">
                    <h5 class="mb-1">Belanja Modal Peralatan dan Mesin Pengadaan Mebelair - 2000 USD</h5>
                  </div>

                  <small class="text-muted">2 days ago</small> | <small class="text-muted">View</small>
                </a>
                <a href="#" class="list-group-item list-group-item-action flex-column align-items-start">
                  <span class="badge badge-dark">Tender</span>
                  <div class="d-flex w-100 justify-content-between">
                    <h5 class="mb-1">Belanja Modal Peralatan dan Mesin Pengadaan Mebelair - 2000 USD</h5>
                  </div>

                  <small class="text-muted">2 days ago</small> | <small class="text-muted">View</small>
                </a>
              </div>

            <!-- <div id="data-box">
                <label id="data-label" for="data-value"></label>
                <div> Nilai kontrak </div>
                <div id="data-value">2000M Rp</div>
                <a href="#"><u>View List</u></a> | <a href="#"><u>Access data</u></a>
              </div> -->
          </div>

        </div>
      </div>

    </div>
  </div>

</section>