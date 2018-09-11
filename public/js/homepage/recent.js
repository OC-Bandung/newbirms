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

var jqxhr = $.getJSON("api/v1/recent/pengadaan.json", function(data) {
    get_tender(data);
    });
});


$("#load_pemenang").click(function(e) {

 e.preventDefault();

var jqxhr = $.getJSON("api/v1/recent/pemenang.json", function(data) {
    get_award(data);
    });
});


$("#load_kontrak").click(function(e) {

e.preventDefault();

var jqxhr = $.getJSON("api/recent/kontrak", function(data) {
    get_contract(data);
    });
});


$("#load_implementasi").click(function(e) {

e.preventDefault();

var jqxhr = $.getJSON("api/v1/recent/implementasi.json", function(data) {
    get_implementasi(data);
    });
});





function get_planning(data) {

 $("#recent_procurement_title").text("Planning")

  html = "";

  for (i=0; i < data.length; i++) {

    json = data[i];

    html+= '<a href="contract?ocid=' + json.ocid +'" class="list-group-item list-group-item-action flex-column align-items-start rounded-0">';
    html+= '<div class="d-flex w-100 justify-content-between">';
    html+= '    <h5 class="mb-1">' + json.title + '</h5>';
    html+= '    <small>OCID: ' + json.ocid + '</small>';
    html+= '  </div>';

    html+= '  <div class="d-flex w-100 justify-content-between">';
    html+= '      <h6>SirupID: ' +  json.sirupID + ' &mdash; Kota Bandung: ' + json.SKPD + ' </h6>';
    html+= '  </div>';

    html+= '  <div class="d-flex justify-content-between pt-1">';
    html+= '    <div class="d-flex flex-column h6 text-center">';
    html+= '        <div class="font-weight-bold"> Pagu Anggaran </div>';
    html+= '        <div class="pt-1">' + json.budget.amount.amount / 1000000  + ' jt </div>';
    html+= '    </div>';

    html+= '    <div class="d-flex flex-column h6 text-center">';
    html+= '        <div class="font-weight-bold"> Sumber Dana </div>';
    html+= '        <div class="pt-1">' + json.budget.description + ' </div>';
    html+= '    </div>';

    html+= '    <div class="d-flex flex-column h6 text-center">';
    html+= '        <div class="font-weight-bold"> Pengumuman </div>';
    html+= '        <div class="pt-1">' + moment(json.tender.startDate).format('ll') + ' </div>';
    html+= '    </div>';

    html+= '    <div class="d-flex flex-column h6 text-center">';
    html+= '        <div class="font-weight-bold"> Penetapan Pemenang </div>';
    html+= '        <div class="pt-1">' + moment(json.tender.endDate).format('ll') + ' </div>';
    html+= '    </div>';

    html+= '    <div class="d-flex flex-column h6 text-center">';
    html+= '        <div class="font-weight-bold"> Mulai Kontrak / Pekerjaan  </div>';
    html+= '        <div class="pt-1">' + moment(json.contract.endDate).format('ll') + ' </div>';
    html+= '    </div>';

    html+= '    <div class="d-flex flex-column h6 text-center">';
    html+= '        <div class="font-weight-bold"> Selesai Kontrak / Pekerjaan </div>';
    html+= '        <div class="pt-1">' + moment(json.contract.endDate).format('ll') + ' </div>';
    html+= '    </div>';
    html+= '  </div>';

    html+= '  <div class="d-flex justify-content-between pt-1">';
    html+= '    <div class="mb-0"><span class="hammer">Program: </span>' + json.project + '' ;
    html+= '    </div>';
    html+= '  </div>';


    html+= '  <div class="d-flex w-100 justify-content-between">';
    html+= '    <div class="d-flex hammer">Klasifikasi: <span class="text-capitalize">' + json.mainProcurementCategory + '</span></div>';
    html+= '    <div class="d-flex hammer">Metode Pengadaan: <span>' + json.procurementMethodDetails + '</span></div>';
    html+= '    <div class="d-flex hammer">Award criteria: <span>' + json.awardCriteria + '</span></div>';

    html+= '  </div>';
    html+= '  </div>';

    html+= '</a>';
  }

  $("#recent-from-api").html(html);

}




function get_tender(data) {

 $("#recent_procurement_title").text("Tender")

  html = "";

  for (i=0; i < data.length; i++) {

    json = data[i];

    html+= '<a href="contract?ocid=' + json.ocid +'" class="list-group-item list-group-item-action flex-column align-items-start rounded-0">';
    html+= '<div class="d-flex w-100 justify-content-between">';
    html+= '    <h5 class="mb-1">' + json.title + '</h5>';
    html+= '    <small>OCID: ' + json.ocid + '</small>';
    html+= '  </div>';

    html+= '  <div class="d-flex w-100 justify-content-between">';
    html+= '      <h6>SirupID: ' +  json.sirupID + ' &mdash; Kota Bandung: ' + json.SKPD + ' </h6>';
    html+= '  </div>';

    html+= '  <div class="d-flex justify-content-between pt-1">';
    html+= '    <div class="d-flex flex-column h6 text-center">';
    html+= '        <div class="font-weight-bold"> Tanggal Pengumuman </div>';
    html+= '        <div class="pt-1">' + json.anggaran + ' jt </div>';
    html+= '    </div>';

    html+= '    <div class="d-flex flex-column h6 text-center">';
    html+= '        <div class="font-weight-bold"> Metode </div>';
    html+= '        <div class="pt-1">' + json.anggaran + ' jt </div>';
    html+= '    </div>';

    html+= '    <div class="d-flex flex-column h6 text-center">';
    html+= '        <div class="font-weight-bold"> HPS </div>';
    html+= '        <div class="pt-1">' + json.anggaran + ' jt </div>';
    html+= '    </div>';

    html+= '    <div class="d-flex flex-column h6 text-center">';
    html+= '        <div class="font-weight-bold"> Jumlah Penawar </div>';
    html+= '        <div class="pt-1">' + json.anggaran + ' jt </div>';
    html+= '    </div>';

    html+= '    <div class="d-flex flex-column h6 text-center">';
    html+= '        <div class="font-weight-bold"> Nilai Penawar  </div>';
    html+= '        <div class="pt-1">' + json.anggaran + ' jt </div>';
    html+= '    </div>';

    html+= '    <div class="d-flex flex-column h6 text-center">';
    html+= '        <div class="font-weight-bold"> Terkoreksi </div>';
    html+= '        <div class="pt-1">' + json.anggaran + ' jt </div>';
    html+= '    </div>';

    html+= '    <div class="d-flex flex-column h6 text-center">';
    html+= '        <div class="font-weight-bold"> Evaluasi </div>';
    html+= '        <div class="pt-1">' + json.anggaran + ' jt </div>';
    html+= '    </div>';
    html+= '  </div>';

    html+= '  <div class="d-flex justify-content-between pt-1">';
    html+= '    <div class="d-flex flex-column h6">';
    html+= '        <div class="font-weight-bold"> Kegiatan </div>';
    html+= '      <div class="pt-1">' + json.activity + '' ;
    html+= '    </div>';
    html+= '    </div>';

    html+= '    <div class="d-flex flex-column h6 text-center">';
    html+= '        <div class="font-weight-bold"> # Suppliers </div>';
    html+= '        <div class="pt-1">' + json.suppliers.length + ' </div>';
    html+= '    </div>';

    html+= '  </div>';
    html+= '  </div>';

    html+= '</a>';
    /*html+= '<a href="#" class="list-group-item list-group-item-action flex-column align-items-start rounded-0">';
    html+= '<div class="d-flex w-100 justify-content-between">';
    html+= '    <h5 class="mb-1">' + json.title + '</h5>';
    html+= '    <small>3 days ago</small>';
    html+= '  </div>';

    html+= '  <div class="d-flex w-100 justify-content-between">';
    html+= '      <h6>SirupID: ' +  json.sirupID + ' - Kota Bandung: ' + json.SKPD + ' </h6>';
    html+= '  </div>';

    html+= '  <div class="d-flex w-100 justify-content-between pt-1">';

    html+= '    <span class="h6">';
    html+= '      <span class="font-weight-bold"> Anggaran  </span>';
    html+= '        <div class="h6 pt-1">' + json.anggaran / 1000000  + ' M</div>';
    html+= '    </span>';


    html+= '    <span class="h6">';
    html+= '       <span class="font-weight-bold"> Method </span>';
    html+= '      <div class="h6 pt-1">' +   json.procurementMethod + '</div>';
    html+= '    </span>';

    html+= '    <span class="h6">';
    html+= '    <span class="font-weight-bold"> HPS </span>';
    html+= '      <div class="h6 pt-1"> ' + json.hps / 1000000 + ' M</div>';
    html+= '    </span>';

    html+= '      <span class="h6">';
    html+= '      <span class="font-weight-bold">Nilai Penawaran </span>';
    html+= '      <div class="h6 pt-1">' + json.nilai_penawaran / 1000000  + ' M</div>';
    html+= '    </span>';

    html+= '    <span class="h6">';
    html+= '      <span class="font-weight-bold"> Nilai Nego</span>';
    html+= '      <div class="h6 pt-1">' + json.nilai_nego / 1000000 + ' M</div>';
    html+= '    </span>';

    html+= '    <span class="h6">';
    html+= '      <span class="font-weight-bold"> Date Signed </span>';
    html+= '      <div class="h6 pt-1">' + moment(json.dateSigned.endDate).format('ll') + '</div>';
    html+= '    </span>';
    html+= '  </div>';
    html+= '  <div class="d-flex w-100 justify-content-between pt-1">';

    html+= '    <span class="h6">';
    html+= '      <span class="font-weight-bold"> Activity </span>';
    html+= '      <div class="h6 pt-1">' + json.activity  + '</div>';
    html+= '    </span>';


    html+= '    <span class="h6">';
    html+= '      <span class="font-weight-bold"> # Suppliers </span>';
    html+= '      <div class="h6 pt-1 text-cetn">' + json.suppliers.length  + '</div>';
    html+= '    </span>';
    html+= '  </div>';

    html+= '</a>';*/


    // html += '<p>The activity is <i> <u> ' +  json.activity + '</u></i>. The following supplier(s) applied:   </p>';
    // html += '<ol>';
    // for (j=0; j< json.suppliers.length; j++) {
    //     html += '<li>' + json.suppliers[j].name + '</li>';
    // }
    // html += '</ol>';

  }

  $("#recent-from-api").html(html);

}




function get_award(data){



$("#recent_procurement_title").text("Award")

html = "";


  for (i=0; i < data.length; i++) {

    json = data[i];


    html+= '<a href="contract?ocid=' + json.ocid +'" class="list-group-item list-group-item-action flex-column align-items-start rounded-0">';
    html+= '<div class="d-flex w-100 justify-content-between">';
    html+= '    <h5 class="mb-1">' + json.title + '</h5>';
    html+= '    <small>3 days ago</small>';
    html+= '</div>';

    html+= '  <div class="d-flex w-100 justify-content-between">';
    html+= '      <h6>SirupID: ' +  json.sirupID + ' - Kota Bandung: ' + json.SKPD + ' </h6>';
    html+= '  </div>';

    html+= '  <div class="d-flex w-100 justify-content-between pt-1">';

    html+= '    <span class="h6">';
    html+= '      <span class="font-weight-bold"> Value  </span>';
    html+= '        <div class="h6 pt-1">' + json.budget.value.amount / 1000000  + ' M</div>';
    html+= '    </span>';


    html+= '    <span class="h6">';
    html+= '       <span class="font-weight-bold"> Status </span>';
    html+= '      <div class="h6 pt-1">' +   json.status + '</div>';
    html+= '    </span>';

    html+= '    <span class="h6">';
    html+= '    <span class="font-weight-bold">  Decision Date </span>';
    html+= '      <div class="h6 pt-1"> ' + moment(json.date).format('ll') + ' M</div>';
    html+= '    </span>';

    html+= '      <span class="h6">';
    html+= '      <span class="font-weight-bold">Contract Start</span>';
    html+= '      <div class="h6 pt-1">' +  moment(json.contract.startDate).format('ll') + ' M</div>';
    html+= '    </span>';

    html+= '    <span class="h6">';
    html+= '      <span class="font-weight-bold"> Contract end </span>';
    html+= '      <div class="h6 pt-1">' +  moment(json.contract.endDate).format('ll') + ' M</div>';
    html+= '    </span>';

    if (json.hasOwnProperty("suppliers")) {
      html+= '    <span class="h6">';
      html+= '      <span class="font-weight-bold"> #Suppliers</span>';
      html+= '      <div class="h6 pt-1">' + json.suppliers.length + '</div>';
      html+= '    </span>';
    }
    html+= '  </div>';
    html+= '</a>';

  }

 $("#recent-from-api").html(html);

}


function get_contract(data){

$("#recent_procurement_title").text("Contract")

html = "";

  for (i=0; i < data.length; i++) {

    json = data[i];


    html+= '<a href="contract?ocid=' + json.ocid +'" class="list-group-item list-group-item-action flex-column align-items-start rounded-0">';
    html+= '<div class="d-flex w-100 justify-content-between">';
    html+= '    <h5 class="mb-1">' + json.title + '</h5>';
    html+= '    <small>3 days ago</small>';
    html+= '  </div>';

    html+= '  <div class="d-flex w-100 justify-content-between">';
    html+= '      <h6>SirupID: ' +  json.sirupID + ' - Kota Bandung: ' + json.SKPD + ' </h6>';
    html+= '  </div>';

    html+= '  <div class="d-flex w-100 justify-content-between pt-1">';
    html+= '    <span class="h6">';
    html+= '      <span class="font-weight-bold"> Anggaran  </span>';
    html+= '        <div class="h6 pt-1">' + json.anggaran / 1000000  + '</div>';
    html+= '    </span>';


    html+= '    <span class="h6">';
    html+= '       <span class="font-weight-bold"> HPS </span>';
    html+= '      <div class="h6 pt-1">' +   json.hps / 1000000   + '</div>';
    html+= '    </span>';

    html+= '    <span class="h6">';
    html+= '    <span class="font-weight-bold"> Nilai Penawaran </span>';
    html+= '      <div class="h6 pt-1"> ' + json.nilai_penawaran  / 1000000  + ' M</div>';
    html+= '    </span>';

    html+= '      <span class="h6">';
    html+= '      <span class="font-weight-bold"> Tender end </span>';
    html+= '      <div class="h6 pt-1">' +    json.nilai_nego / 1000000  + 'M</div>';
    html+= '    </span>';
    html+= '    <span class="h6">';
    html+= '      <span class="font-weight-bold"> Contract start </span>';
    html+= '      <div class="h6 pt-1">' +  moment(json.contract.startDate).format('ll') + '</div>';
    html+= '    </span>';
    html+= '    <span class="h6">';
    html+= '      <span class="font-weight-bold"> Contract end </span>';
    html+= '      <div class="h6 pt-1">' +   moment(json.contract.endDate).format('ll') + '</div>';
    html+= '    </span>';
    html+= '  </div>';

    html+= '</a>';

  }

 $("#recent-from-api").html(html);

}
