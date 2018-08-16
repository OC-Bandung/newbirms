<section class="bg-primary">
  <div class="container pt-5">
    <div class="row">
      <div class="col-4">
        <h3 class="color-white">@lang('homepage.procurement_map_title')</h3>
      </div>
      <div class="col-8">
        <p>@lang('homepage.procurement_map_shortdesc')</p>
      </div>

      <div class="container mt-5 mb-5">
        <div class="row no-gutter">
          <div class="col-12 bg-light pt-5 pb-5 pl-5">
            <div class="row no-gutter">
              <div class="col-6">
                    <div id="map-controls">
                        <div class="form-group" id="filter">
                              <h5 for="map-variable">Filter Berdasarkan</h5>
                              <select class="custom-select" id="map-variable">
                                    <option value="count">Paket Pekerjaan</option>
                                    <option value="value">Pagu Anggaran</option>
                              </select>
                        </div> 
                    </div>
              </div>
              <div class="col-6">
                    <div id="data-box">
                        <div class="form-group" id="filter" for="data-value">
                              <h5 id="data-label" for="data-value">Nilai Kontrak</h5>
                              <div id="data-value"></div>
                        </div> 

                        <a href="#"><u>Lihat Data List</u></a> | <a href="#"><u>Access data</u></a>

                        <div id="legend">
                            <div id="map-min">Min</div>
                            <div class="color-key"><span id="data-caret">&#x25c6;</span></div>
                            <div id="map-max" class="padding-right-small">Maks</div>
                        </div>
                    </div>
              </div>
            </div>
          </div>
        </div>

        <div class="row no-gutter">
          <div class="col-12 bg-light pt-5 pb-5 pl-5">
              <div id="map" class="pt-3">
              </div>  
          </div>
        </div>
      </div>
    </div>
  </div>

</section>