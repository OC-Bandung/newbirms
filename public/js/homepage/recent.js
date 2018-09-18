$(".main-menu div a").click(function(e){

  // If this isn't already active
  if (!$(this).hasClass("active")) {
    // Remove the class from anything that is active
    $(".main-menu div.active").removeClass("active");
    // And make this active
    $(this).parent().addClass("active");
  }
});


$(document).ready(function(){
var jqxhr = $.getJSON("api/recent/perencanaan", function(data) {
        get_planning(data);
    });
});

$("#load_perencanaan").click(function(e) {

e.preventDefault();
var jqxhr = $.getJSON("api/recent/perencanaan", function(data) {
        get_planning(data);
    });
});

$("#load_pengadaan").click(function(e) {

e.preventDefault();

var jqxhr = $.getJSON("https://birms.bandung.go.id/beta/api/recent/pengadaan", function(data) {
    get_pengadaan(data);
    });
});


$("#load_pemenang").click(function(e) {

 e.preventDefault();

var jqxhr = $.getJSON("https://birms.bandung.go.id/beta/api/recent/pemenang", function(data) {
    get_award(data);
    });
});


$("#load_kontrak").click(function(e) {

e.preventDefault();

var jqxhr = $.getJSON("https://birms.bandung.go.id/beta/api/recent/kontrak", function(data) {
    get_contract(data);
    });
});


$("#load_implementasi").click(function(e) {

e.preventDefault();

var jqxhr = $.getJSON("https://birms.bandung.go.id/beta/api/recent/implementasi", function(data) {
    get_implementasi(data);
    });
});





function get_planning(data) {

 $("#recent_procurement_title").text("Perencanaan")

  html = "";
  html+= '<div class="container">'; 

  for (i=0; i < data.length; i++) {

    json = data[i];

    html+= '<a href="contract?ocid=' + json.ocid +'" class="list-group-item list-group-item-action flex-column align-items-start rounded-0">';
    html+= '<div class="row">'; 
    html+= '    <div class="col-8">';
    html+= '      <h5 class="mb-1">' + json.title + '</h5>';
    html+= '    </div>';
    html+= '    <div class="col text-right">';
    html+= '      <small>' + json.ocid + '</small>';
    html+= '    </div>';  
    html+= '</div>';

    html+= '<div class="row">'; 
    html+= '    <div class="col-8">';
    html+= '      <h6>Kota Bandung &mdash; SKPD : ' + json.SKPD + ' </h6>';
    html+= '    </div>'; 
    html+= '    <div class="col text-right">';
    html+= '      <small>SirupID: ' + json.sirupID + '</small>';
    html+= '    </div>';  
    html+= '</div>';

    html+= '<div class="row">'; 
    html+= '  <div class="col">'; 
    html+= '      <small class="text-muted"> Pagu Anggaran</small>';
    html+= '      <div class="h5 pt-1 font-weight-bold">' + json.budget.amount.currency + ' ' + json.budget.amount.amount / 1000000  + 'Jt </div>';
    html+= '    </div>'; 
    html+= '    <div class="col">'; 
    html+= '      <small class="text-muted"> Sumber Dana</small>';
    html+= '      <div class="h5 pt-1 font-weight-bold">' + json.budget.description  + '</div>';
    html+= '    </div>'; 
    html+= '    <div class="col">'; 
    html+= '      <small class="text-muted"> Pengumuman</small>';
    html+= '      <div class="h5 pt-1 font-weight-bold">' + moment(json.tender.startDate).format('ll')  + '</div>';
    html+= '    </div>'; 
    html+= '    <div class="col">'; 
    html+= '      <small class="text-muted"> Penetapan Pemenang</small>';
    html+= '      <div class="h5 pt-1 font-weight-bold">' + moment(json.tender.endDate).format('ll')  + '</div>';
    html+= '    </div>'; 
    html+= '    <div class="col">'; 
    html+= '      <small class="text-muted"> Mulai Kontrak/ Pekerjaan</small>';
    html+= '      <div class="h5 pt-1 font-weight-bold">' + moment(json.contract.startDate).format('ll')  + '</div>';
    html+= '    </div>'; 
    html+= '    <div class="col">'; 
    html+= '      <small class="text-muted"> Selesai Kontrak</small>';
    html+= '      <div class="h5 pt-1 font-weight-bold">' + moment(json.contract.endDate).format('ll')  + '</div>';
    html+= '    </div>'; 
    html+= '</div>';

    html+= '<div class="row">'; 
    html+= '  <div class="col">'; 
    html+= '      <small class="text-muted"> Klasifikasi</small>';
    html+= '      <div class="h5 pt-1 font-weight-bold">' + json.mainProcurementCategory  + '</div>';
    html+= '    </div>'; 
    html+= '  <div class="col">'; 
    html+= '      <small class="text-muted"> Metode Pengadaan</small>';
    html+= '      <div class="h5 pt-1 font-weight-bold">' + json.procurementMethodDetails + '</div>';
    html+= '    </div>'; 
    html+= '</div>';

    html+= '</a>';   
  }
  html+= '</div>'; 

  $("#recent-from-api").html(html);

}


function get_pengadaan(data) {

 $("#recent_procurement_title").text("Pemilihan")

  html = "";
  html+= '<div class="container">'; 

  for (i=0; i < data.length; i++) {

    json = data[i];

    html+= '<a href="contract?ocid=' + json.ocid +'" class="list-group-item list-group-item-action flex-column align-items-start rounded-0">';
    html+= '<div class="row">'; 
    html+= '    <div class="col-8">';
    html+= '      <h5 class="mb-1">' + json.title + '</h5>';
    html+= '    </div>';
    html+= '    <div class="col text-right">';
    html+= '      <small>' + json.ocid + '</small>';
    html+= '    </div>';
    html+= '</div>';


    html+= '<div class="row">'; 
    html+= '  <div class="col">'; 
    html+= '      <small class="text-muted"> Kode Rekening </small>';
    html+= '      <div class="h6 pt-1">' + json.koderekening  + '</div>';
    html+= '    </div>'; 
    html+= '  <div class="col">'; 
    html+= '      <small class="text-muted"> Kegiatan</small>';
    html+= '      <div class="h6 pt-1">' + json.namakegiatan  + '</div>';
    html+= '    </div>'; 
    html+= '</div>';

    html+= '<div class="row">'; 
    html+= '    <div class="col-8">';
    html+= '      <h6>Kota Bandung &mdash; SKPD : ' + json.SKPD + ' </h6>';
    html+= '    </div>'; 
    html+= '    <div class="col text-right">';
    html+= '      <small>SirupID: ' + json.sirupID + '</small>';
    html+= '    </div>';  
    html+= '</div>';

    html+= '<div class="row">'; 
    html+= '  <div class="col">'; 
    html+= '      <small class="text-muted"> Tanggal Pengumuman</small>';
    html+= '      <div class="h5 pt-1 font-weight-bold">' + moment(json.contract.startDate).format('ll')  + '</div>';
    html+= '    </div>'; 
    html+= '    <div class="col">'; 
    html+= '      <small class="text-muted"> Metode</small>';
    html+= '      <div class="h5 pt-1 font-weight-bold">' + json.procurementMethodDetails + '</div>';
    html+= '    </div>'; 
    html+= '    <div class="col">'; 
    html+= '      <small class="text-muted"> HPS</small>';
    html+= '      <div class="h5 pt-1 font-weight-bold">' + json.hps / 1000000  + 'Jt </div>';
    html+= '    </div>'; 
    html+= '    <div class="col">'; 
    html+= '      <small class="text-muted"> Jumlah Peserta</small>';
    html+= '      <div class="h5 pt-1 font-weight-bold">' +json.jumlah_peserta  + '</div>';
    html+= '    </div>'; 
    if(json.nilai_penawaran !== 0){
        html+= '    <div class="col">'; 
        html+= '      <small class="text-muted"> Nilai Penawar</small>';
        html+= '      <div class="h5 pt-1 font-weight-bold">' + json.nilai_penawaran / 1000000 + 'Jt </div>';
        html+= '    </div>'; 
    }
    html+= '</div>';

    html+= '</a>';
    

  }
  html+= '</div>'; 

  $("#recent-from-api").html(html);

}




function get_award(data){



$("#recent_procurement_title").text("Pemenang")

  html = "";
  html+= '<div class="container">'; 

  for (i=0; i < data.length; i++) {

    json = data[i];

    html+= '<a href="contract?ocid=' + json.ocid +'" class="list-group-item list-group-item-action flex-column align-items-start rounded-0">';
    html+= '<div class="row">'; 
    html+= '    <div class="col-8">';
    html+= '      <h5 class="mb-1">' + json.title + '</h5>';
    html+= '    </div>';
    html+= '    <div class="col text-right">';
    html+= '      <small>' + json.ocid + '</small>';
    html+= '    </div>';
    html+= '</div>';


    html+= '<div class="row">'; 
    html+= '  <div class="col">'; 
    html+= '      <small class="text-muted"> Kode Rekening </small>';
    html+= '      <div class="h6 pt-1">' + json.koderekening  + '</div>';
    html+= '    </div>'; 
    html+= '  <div class="col">'; 
    html+= '      <small class="text-muted"> Kegiatan</small>';
    html+= '      <div class="h6 pt-1">' + json.namakegiatan  + '</div>';
    html+= '    </div>'; 
    html+= '</div>';

    html+= '<div class="row">'; 
    html+= '    <div class="col-8">';
    html+= '      <h6>Kota Bandung &mdash; SKPD : ' + json.SKPD + ' </h6>';
    html+= '    </div>'; 
    html+= '    <div class="col text-right">';
    html+= '      <small>SirupID: ' + json.sirupID + '</small>';
    html+= '    </div>';  
    html+= '</div>';

    html+= '<div class="row">'; 
    html+= '    <div class="col">'; 
    html+= '      <small class="text-muted"> HPS</small>';
    html+= '      <div class="h5 pt-1 font-weight-bold">' + json.hps / 1000000 + 'Jt </div>';
    html+= '    </div>';
    html+= '    <div class="col">'; 
    html+= '      <small class="text-muted"> Nilai Kontrak</small>';
    html+= '      <div class="h5 pt-1 font-weight-bold">' + json.nilai_nego / 1000000 + 'Jt </div>';
    html+= '    </div>';
    if(json.tanggal_penetapan !== undefined){
        html+= '    <div class="col">'; 
        html+= '      <small class="text-muted"> Tanggal Penetapan</small>';
        html+= '      <div class="h5 pt-1 font-weight-bold">' + json.tanggal_penetapan + '</div>';
        html+= '    </div>'; 
    }
    html+= '</div>';
    html+= '<div class="row">';     
    html+= '    <div class="col">'; 
    html+= '      <small class="text-muted"> Nama Pemenang</small>';
    html+= '      <div class="h5 pt-1 font-weight-bold">' + json.perusahaannama + '</div>';
    html+= '    </div>'; 
    html+= '    <div class="col">'; 
    html+= '      <small class="text-muted"> Alamat</small>';
    html+= '      <div class="h5 pt-1 font-weight-bold">' + json.perusahaanalamat + '</div>';
    html+= '    </div>'; 
    html+= '    <div class="col">'; 
    html+= '      <small class="text-muted"> NPWP</small>';
    html+= '      <div class="h5 pt-1 font-weight-bold">' + json.perusahaannpwp + '</div>';
    html+= '    </div>'; 
    html+= '</div>';

    html+= '</a>';
    

  }
  html+= '</div>';

 $("#recent-from-api").html(html);

}


function get_contract(data){

$("#recent_procurement_title").text("Kontrak")

html = "";
  html+= '<div class="container">'; 

  for (i=0; i < data.length; i++) {

    json = data[i];

    html+= '<a href="contract?ocid=' + json.ocid +'" class="list-group-item list-group-item-action flex-column align-items-start rounded-0">';
    html+= '<div class="row">'; 
    html+= '    <div class="col-8">';
    html+= '      <h5 class="mb-1">' + json.title + '</h5>';
    html+= '    </div>';
    html+= '    <div class="col text-right">';
    html+= '      <small>' + json.ocid + '</small>';
    html+= '    </div>';
    html+= '</div>';


    html+= '<div class="row">'; 
    html+= '  <div class="col">'; 
    html+= '      <small class="text-muted"> SPPBJ </small>';
    html+= '      <div class="h6 pt-1">' + json.koderekening  + '</div>';
    html+= '    </div>'; 
    html+= '  <div class="col">'; 
    html+= '      <small class="text-muted"> Kegiatan</small>';
    html+= '      <div class="h6 pt-1">' + json.namakegiatan  + '</div>';
    html+= '    </div>'; 
    html+= '</div>';

    html+= '<div class="row">'; 
    html+= '    <div class="col-8">';
    html+= '      <h6>Kota Bandung &mdash; SKPD : ' + json.SKPD + ' </h6>';
    html+= '    </div>'; 
    html+= '    <div class="col text-right">';
    html+= '      <small>SirupID: ' + json.sirupID + '</small>';
    html+= '    </div>';  
    html+= '</div>';

    html+= '<div class="row">'; 
    html+= '    <div class="col">'; 
    html+= '      <small class="text-muted"> SPPBJ</small>';
    html+= '      <div class="h5 pt-1 font-weight-bold">' + json.hps / 1000000 + 'Jt </div>';
    html+= '    </div>';
    html+= '    <div class="col">'; 
    html+= '      <small class="text-muted"> Tanda Tangan Kontrak Kontrak</small>';
    html+= '      <div class="h5 pt-1 font-weight-bold">' + json.nilai_nego / 1000000 + 'Jt </div>';
    html+= '    </div>';
    html+= '    <div class="col">'; 
    html+= '      <small class="text-muted"> Nilai Kontrak</small>';
    html+= '      <div class="h5 pt-1 font-weight-bold">' + json.nilai_nego / 1000000 + '</div>';
    html+= '    </div>'; 
    html+= '</div>';
    html+= '<div class="row">';     
    html+= '    <div class="col">'; 
    html+= '      <small class="text-muted"> Periode Kontrak</small>';
    html+= '      <div class="h5 pt-1 font-weight-bold">' + json.perusahaannama + '</div>';
    html+= '    </div>'; 
    html+= '    <div class="col">'; 
    html+= '      <small class="text-muted"> Mulai Pekerjaan</small>';
    html+= '      <div class="h5 pt-1 font-weight-bold">' + json.perusahaanalamat + '</div>';
    html+= '    </div>'; 
    html+= '    <div class="col">'; 
    html+= '      <small class="text-muted"> Selesai Pekerjaan</small>';
    html+= '      <div class="h5 pt-1 font-weight-bold">' + json.perusahaannpwp + '</div>';
    html+= '    </div>'; 
    html+= '</div>';

    html+= '</a>';
    

  }
  html+= '</div>';

 $("#recent-from-api").html(html);

}
