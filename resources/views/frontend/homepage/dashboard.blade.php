<section class="mt-5">
  <div class="container mt-5">
    <div class="row">
      <div class="col-sm-3">
        <div class="card text-center">
          <div class="card-body">
          <div class="statistiktext_content bg-primary "> {{ date("Y") }} </div>
            <h5 class="card-title">PAKET</h5>
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
      
    </div>
  </div>
<section>
