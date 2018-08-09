<section class="mt-5">
  <div class="container mt-5">
    <div class="row mt-5">
      <div class="col-3 bdg-summary  statistiktext">
         <div class="statistiktext_content bg-primary "> {{ date("Y") }} </div>
         <div class="h6"> Pengadaan Barang / Jasa </div>
         <span class="h3"> {{MyGlobals::moneyDisplay($total_nilai_pengadaan) }}</span>
      </div>
      <div class="col-2  bdg-summary">
        <div class="statistiktext_content bg-primary "> {{ date("Y") }} </div>
        <div class="h6"> Lelang Umum </div>
        <span class="h3"> {{ $total_prev_paket_lelang }} </span>   <span class="h5">Paket </span>
      </div>
      <div class="col-3  bdg-summary">
        <div class="statistiktext_content bg-primary "> {{ date("Y") }} </div>
        <div class="h6"> Pengadaan Langsung </div>
        <span class="h3"> {{ $total_paket_pl }} </span> <span class="h5">Paket </span>
      </div>
      <div class="col-4 bdg-summary">
        <div class="statistiktext_content bg-primary "> {{ date("Y") }} </div>
        <div class="h6" title="Pengumuman Pengadaan Barang / Jasa">Pengumuman PBJ </div>
        <span class="h3">{{ MyGlobals::moneyDisplay($total_nilai_pengumuman_pl) }}</span></div>
    </div>
  </div>
<section>
