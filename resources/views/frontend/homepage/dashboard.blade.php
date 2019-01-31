<section>
  <div class="container mt-2">
    <ul class="nav nav-tabs">
        <li class="nav-item">
          <a class="nav-link{{ $prevyear }}" data-toggle="tab" href="#tahunlalu">Tahun Lalu</a>
        </li>
        <li class="nav-item">
          <a class="nav-link{{ $curryear }}" data-toggle="tab" href="#tahunini">Tahun Ini</a>
        </li>
    </ul>

    <div class="tab-content">
      <div class="tab-pane {{ $prevyear }} container" id="tahunlalu">
          <div class="row">
              <!--<div class="col-sm-2">
                <div class="card text-center">
                  <div class="card-body">
                  <div class="statistiktext_content bg-primary "> {{ date("Y")-1 }} </div>
                    <h5 class="card-title">Belanja</h5>
                    <span class="h3">xxx</span> <span class="h5"> paket</span>
                    <div class="dropdown-divider"></div>
                    <span class="h3">xxx</span>
                  </div>
                </div>
              </div>-->
        
              <div class="col-sm-3">
                <div class="card text-center">
                  <div class="card-body">
                  <div class="statistiktext_content bg-primary "> {{ date("Y")-1 }} </div>
                    <h5 class="card-title">RENCANA PAKET</h5>
                    <span class="h3">{{ $total_prev_paket_sirup }}</span> <span class="h5"> paket</span>
                    <div class="dropdown-divider"></div>
                    <span class="h3">{{ MyGlobals::moneyDisplay($total_prev_nilai_sirup) }}</span>
                  </div>
                </div>
              </div>

              <div class="col-sm-3">
                  <div class="card text-center">
                    <div class="card-body">
                    <div class="statistiktext_content bg-primary "> {{ date("Y")-1 }} </div>
                      <h5 class="card-title">TENDER</h5>
                      <span class="h3">{{ $total_prev_paket_tender }}</span> <span class="h5"> paket</span>
                      <div class="dropdown-divider"></div>
                      <span class="h3">{{MyGlobals::moneyDisplay($total_prev_nilai_tender) }}</span>
                      <!--<div class="dropdown-divider"></div>
                      Peminat/ Penawar-->
                      </div>
                  </div>
                </div>

                <div class="col-sm-3">
                    <div class="card text-center">
                      <div class="card-body">
                      <div class="statistiktext_content bg-primary "> {{ date("Y")-1 }} </div>
                        <h5 class="card-title">NON-TENDER</h5>
                        <span class="h3">{{ $total_prev_paket_nontender }}</span> <span class="h5"> paket</span>
                        <div class="dropdown-divider"></div>
                        <span class="h3">{{MyGlobals::moneyDisplay($total_prev_nilai_nontender) }}</span>
                        <!--<div class="dropdown-divider"></div>
                        Penawar-->
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-3">
                    <div class="card text-center">
                      <div class="card-body">
                      <div class="statistiktext_content bg-primary "> {{ date("Y")-1 }} </div>
                        <h5 class="card-title">KONTRAK</h5>
                        <span class="h3">{{ $total_prev_paket_kontrak }}</span> <span class="h5"> paket</span>
                        <div class="dropdown-divider"></div>
                        <span class="h3">{{MyGlobals::moneyDisplay($total_prev_nilai_kontrak) }}</span>
                      </div>
                    </div>
                  </div>
              
              
            </div> {{-- END ROW --}}

      </div>
      <div class="tab-pane {{ $curryear }} container" id="tahunini">

          <div class="row">
              <!--<div class="col-sm-2">
                <div class="card text-center">
                  <div class="card-body">
                  <div class="statistiktext_content bg-primary "> {{ date("Y") }} </div>
                    <h5 class="card-title">Belanja</h5>
                    <span class="h3">xxx</span> <span class="h5"> paket</span>
                    <div class="dropdown-divider"></div>
                    <span class="h3">xxx</span>
                  </div>
                </div>
              </div>-->
        
              <div class="col-sm-3">
                <div class="card text-center">
                  <div class="card-body">
                  <div class="statistiktext_content bg-primary "> {{ date("Y") }} </div>
                    <h5 class="card-title">RENCANA PAKET</h5>
                    <span class="h3">{{ $total_paket_sirup}}</span> <span class="h5"> paket</span>
                    <div class="dropdown-divider"></div>
                    <span class="h3">{{MyGlobals::moneyDisplay($total_nilai_sirup) }}</span>
                  </div>
                </div>
              </div>
              <div class="col-sm-3">
                <div class="card text-center">
                  <div class="card-body">
                  <div class="statistiktext_content bg-primary "> {{ date("Y") }} </div>
                    <h5 class="card-title">TENDER</h5>
                    <span class="h3">{{ $total_paket_tender }}</span> <span class="h5"> paket</span>
                    <div class="dropdown-divider"></div>
                    <span class="h3">{{MyGlobals::moneyDisplay($total_nilai_tender) }}</span>
                    <!--<div class="dropdown-divider"></div>
                    Peminat/ Penawar-->
                    </div>
                </div>
              </div>
              <div class="col-sm-3">
                <div class="card text-center">
                  <div class="card-body">
                  <div class="statistiktext_content bg-primary "> {{ date("Y") }} </div>
                    <h5 class="card-title">NON-TENDER</h5>
                    <span class="h3">{{ $total_paket_nontender }}</span> <span class="h5"> paket</span>
                    <div class="dropdown-divider"></div>
                    <span class="h3">{{MyGlobals::moneyDisplay($total_nilai_nontender) }}</span>
                    <!--<div class="dropdown-divider"></div>
                    Penawar-->
                  </div>
                </div>
              </div>
              <div class="col-sm-3">
                <div class="card text-center">
                  <div class="card-body">
                  <div class="statistiktext_content bg-primary "> {{ date("Y") }} </div>
                    <h5 class="card-title">KONTRAK</h5>
                    <span class="h3">{{ $total_paket_kontrak }}</span> <span class="h5"> paket</span>
                    <div class="dropdown-divider"></div>
                    <span class="h3">{{MyGlobals::moneyDisplay($total_nilai_kontrak) }}</span>
                  </div>
                </div>
              </div>
              
            </div> {{-- END ROW --}}

      </div>
    </div>

    
  </div>
<section>
