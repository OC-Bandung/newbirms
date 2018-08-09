$(document).ready(function(){

var jqxhr = $.getJSON("api/v1/recent/perencanaan.json", function(data) {
        get_planning(data);
    });
});

$("#load_perencanaan").click(function(e) {

e.preventDefault();
var jqxhr = $.getJSON("api/v1/recent/perencanaan.json", function(data) {
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

var jqxhr = $.getJSON("api/v1/recent/kontrak.json", function(data) {
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

    if (i % 2 ==0) {
         html +=  '<div class="even padding-small">';
    } else
    {
         html +=  '<div class="odd padding-small">';
    }
   
    html += '<section class="mdc-card__primary">';
        html += '<div class="mdc-typography--title">';
        html += json.title;
        html += '</div>';
        html += '<div class="mdc-card__subtitle mdc-typography--subheading1">';
        html += 'SirupID: #' + json.sirupID + ' -  Kota Bandung: ' + json.SKPD;
        html += '</div>';
    
    html += '</section>';
   
    html += '<section class="mdc-card__supporting-text ">';
        
        html += '<div class="procurement-card-container flex">';
            html += '<div class="procurement-card-details padding-small text-center">';
            html += '<div class="mdc-typography--subheading1"> <img class="icon-medium  padding-right-xs" src="img/icon-money.png">Pagu </div>';
            html += '<div> <span class="mdc-typography--title f300"> ' + json.budget.amount.amount / 1000000 + ' </span> M</div>';
        html += '</div>';
    
        html += '<div class="procurement-card-details padding-small text-center">';
            html += ' <div class="mdc-typography--subheading1"> <img class="icon-medium padding-right-xs" src="img/icon-gov.png">Budget </div>';
            html += ' <span class="mdc-typography--title f300"> ' + json.budget.description + ' </span>';
        html += '</div>';

        html += '<div class="procurement-card-details padding-small text-center">';
            html += ' ';
            html += ' <div class="mdc-typography--subheading1"> <img class="icon-medium padding-right-xs" src="img/icon-tender-start.png"> Tender start </div>';
            html += '<span class="mdc-typography--title f300"> ' + moment(json.tender.startDate).format('ll') +  ' </span>';
        html += '</div>';

        html += '<div class="procurement-card-details padding-small text-center">';
            html += ' <div class="mdc-typography--subheading1"> <img class="icon-medium  padding-right-xs" src="img/icon-tender-end.png"> Tender end</div>';
            html += '<span class="mdc-typography--title f300"> ' +  moment(json.tender.endDate).format('ll') + ' </span>';
    html += ' </div>';
    
    html += ' <div class="procurement-card-details padding-small text-center ">';
           
            html += '<div class="mdc-typography--subheading1"><img class="icon-medium  padding-right-xs" src="img/icon-contract-start.png">Contract start</div>';
            html += '<span class="mdc-typography--title f300">' +  moment(json.contract.startDate).format('ll') + '</span>';
    html += '</div>';
    
    html += ' <div class="procurement-card-details padding-small text-center">';
        
            html += '<div class="mdc-typography--subheading1"><img class="icon-medium  padding-right-xs" src="img/icon-contract-end.png">Contract end</div>';
            html += ' <span class="mdc-typography--title f300">' +  moment(json.contract.endDate).format('ll')  +'</span>';
    html += '</div>';
   
    html += ' </div>';
    html += ' <div class="mdc-typography--caption">';
    html += 'This contract is for <i> <u> ' +  json.mainProcurementCategory + '</u></i> in the program <u><i>' + json.project + '</u></i>. The procurement method is <u><i> ' + json.procurementMethodDetails  + ' </i></u>. The award criteria is <i> <u>'+  json.awardCriteria +'</u></i>.';
    html += ' </div>';
    html += '</section>';

    html += '<section class="mdc-card__actions">';
    html += ' <button class="mdc-button mdc-button--compact mdc-card__action"> APPLY </button>';
    html += '<button class="mdc-button mdc-button--compact mdc-card__action"> Download </button>';
    html += ' <button class="mdc-button mdc-button--compact mdc-card__action">Email</button>';
    html += '</section>';
    html += '</div>';




  }

  $("#recent-from-api").html(html);
 
}




function get_tender(data) {

 $("#recent_procurement_title").text("Tender")

  html = "";

  for (i=0; i < data.length; i++) {

    json = data[i];

    if (i % 2 ==0) {
         html +=  '<div class="even padding-small">';
    } else
    {
         html +=  '<div class="odd padding-small">';
    }
   


    html += '<section class="mdc-card__primary">';
        html += '<div class="mdc-typography--title">';
        html += json.title;
        html += '</div>';
        html += '<div class="mdc-card__subtitle mdc-typography--subheading1">';
        html += 'SirupID: #' + json.sirupID + ' -  Kota Bandung: ' + json.SKPD;
        html += '</div>';
    
    html += '</section>';
   
    html += '<section class="mdc-card__supporting-text ">';
        
        html += '<div class="procurement-card-container flex">';
            html += '<div class="procurement-card-details padding-small text-center">';
            html += '<div class="mdc-typography--subheading1"><img class="icon-medium padding-right-xs" src="img/icon-money.png">Anggaran</div>';
            html += '<div> <span class="mdc-typography--subheading1 f300"> ' + json.anggaran / 1000000 + ' </span> M</div>';
        html += '</div>';
    
        html += '<div class="procurement-card-details padding-small text-center">'; 
            html += ' <div class="mdc-typography--subheading1"><img class="icon-medium padding-right-xs" src="img/icon-status.png">Method </div>';
            html += ' <div class="mdc-typography--subheading1 f300"> ' + json.procurementMethod + ' </div>';
        html += '</div>';

        html += '<div class="procurement-card-details padding-small text-center">'; 
            html += ' <div class="mdc-typography--subheading1"><img class="icon-medium padding-right-xs" src="img/icon-money.png">HPS</div>';
            html += '<div class="mdc-typography--subheading1 f300"> ' + json.hps / 1000000 +  ' M </div>';
        html += '</div>';

        html += '<div class="procurement-card-details padding-small text-center">'; 
            html += ' <div class="mdc-typography--subheading1"><img class="icon-medium padding-right-xs" src="img/icon-money.png">Nilai Penawaran</div>';
            html += '<div class="mdc-typography--subheading1 f300"> ' +  json.nilai_penawaran / 1000000 + ' M </div>';
    html += ' </div>';
    
    html += ' <div class="procurement-card-details padding-small text-center ">'; 
            html += '<div class="mdc-typography--subheading1"><img class="icon-medium padding-right-xs" src="img/icon-money.png">Nilai Nego</div>';
            html += '<div class="mdc-typography--subheading1 f300">' + json.nilai_nego / 1000000 + ' M </div>';
    html += '</div>';
    
    html += ' <div class="procurement-card-details padding-small text-center">'; 
            html += '<div class="mdc-typography--subheading1"><img class="icon-medium padding-right-xs" src="img/icon-contract-end.png"> Date Signed</div>';
            html += ' <div class="mdc-typography--subheading1 f300">' +  moment(json.dateSigned.endDate).format('ll')  +'</div>';
    html += '</div>';

     html += ' <div class="procurement-card-details padding-small text-center ">'; 
            html += '<div class="mdc-typography--subheading1"><img class="icon-medium padding-right-xs" src="img/icon-number.png"> Suppliers</div>';
            html += '<div class="mdc-typography--subheading1 f300">' +  json.suppliers.length + '</div>';
    html += '</div>';

   
    html += ' </div>';
    html += ' <div>';
    html += '<p>The activity is <i> <u> ' +  json.activity + '</u></i>. The following supplier(s) applied:   </p>';
    html += '<ol>';
    for (j=0; j< json.suppliers.length; j++) {
        html += '<li>' + json.suppliers[j].name + '</li>';
    }
    html += '</ol>';
    html += ' </div>';
    html += '</section>';

    html += '<section class="mdc-card__actions">';
    html += ' <button class="mdc-button mdc-button--compact mdc-card__action"> APPLY </button>';
    html += '<button class="mdc-button mdc-button--compact mdc-card__action"> Download </button>';
    html += ' <button class="mdc-button mdc-button--compact mdc-card__action">Email</button>';
    html += '</section>';
    html += '</div>';




  }

  $("#recent-from-api").html(html);
 
}




function get_award(data){

 

$("#recent_procurement_title").text("Award")

html = "";

  for (i=0; i < data.length; i++) {

    json = data[i];

    if (i % 2 ==0) {
         html +=  '<div class="even padding-small">';
    } else
    {
         html +=  '<div class="odd padding-small">';
    }
   
    html += '<section class="mdc-card__primary">';
        html += '<div class="mdc-typography--title">';
        html += json.title;
        html += '</div>';
        html += '<div class="mdc-card__subtitle mdc-typography--subheading1">';
        html += 'SirupID: #' + json.sirupID + ' -  Kota Bandung: ' + json.SKPD;
        html += '</div>';
    
    html += '</section>';
   
    html += '<section class="mdc-card__supporting-text ">';
        
     html += '<div class="procurement-card-container flex">';
        html += '<div class="procurement-card-details padding-small text-center">';
        html += '<div class="mdc-typography--subheading1"><img class="icon-medium padding-right-xs" src="img/icon-money.png">Value </div>';
        html += '<div> <span class="mdc-typography--title f300"> ' + json.budget.value.amount / 1000000 + ' M </span></div>';
    html += '</div>';


    html += '<div class="procurement-card-container flex">';
        html += '<div class="procurement-card-details padding-small text-center">';
        html += '<div class="mdc-typography--subheading1"><img class="icon-medium padding-right-xs" src="img/icon-status.png"> Status </div>';
        html += '<div> <span class="mdc-typography--title f300"> ' + json.status + ' </span></div>';
    html += '</div>';

      
    html += ' <div class="procurement-card-details padding-small text-center ">';
            html += '<div class="mdc-typography--subheading1"><img class="icon-medium padding-right-xs" src="img/icon-decision.png"> Decision Date</div>';
            html += '<div class="mdc-typography--title f300">' +  moment(json.date).format('ll') + '</div>';
    html += '</div>';


     if (json.hasOwnProperty("contract")) {
    html += ' <div class="procurement-card-details padding-small text-center ">';
            html += '<div class="mdc-typography--subheading1"><img class="icon-medium padding-right-xs" src="img/icon-contract-start.png">Contract Start</div>';
            html += '<div class="mdc-typography--title f300">' + moment(json.contract.startDate).format('ll') + '</div>';
    html += '</div>';
    
    html += ' <div class="procurement-card-details padding-small text-center">';
            html += '<div class="mdc-typography--subheading1"><img class="icon-medium padding-right-xs" src="img/icon-contract-end.png">Contract end</div>';
            html += ' <div class="mdc-typography--title f300">' +  moment(json.contract.endDate).format('ll')  +'</div>';
    html += '</div>';
    }

   
    html += '</div> </div>';
    html += ' <div class="mdc-typography--caption">';
   
    html += 'This contract was awarded to  ';
    
    if (json.hasOwnProperty("suppliers")) {
      for (j = 0 ; j< json.suppliers.length; j++ ) {
        html += '<i> <u>' + json.suppliers[0].name + '</u></i>  ,';
        }  
    }
    

     html += 'The award criteria was <i><u>' + json.awardCriteria + '</u></i> , '; 
    html += 'The procurement method is <i><u>' + json.procurementMethodDetails + '</u></i>.'; 
    html += ' </div>';
    html += '</section>';

    html += '<section class="mdc-card__actions">';
    html += ' <button class="mdc-button mdc-button--compact mdc-card__action"> APPLY </button>';
    html += '<button class="mdc-button mdc-button--compact mdc-card__action"> Download </button>';
    html += ' <button class="mdc-button mdc-button--compact mdc-card__action">Email</button>';
    html += '</section>';
    html += '</div>';




  }

 $("#recent-from-api").html(html);

}


function get_contract(data){

$("#recent_procurement_title").text("Contract")

html = "";

  for (i=0; i < data.length; i++) {

    json = data[i];

    if (i % 2 ==0) {
         html +=  '<div class="even">';
    } else
    {
         html +=  '<div class="odd">';
    }
   
    html += '<section class="mdc-card__primary">';
        html += '<div class="mdc-card__title mdc-card__title--large f300">';
        html += json.title;
        html += '</div>';
        html += '<div class="mdc-card__subtitle">';
        html += 'Kota Bandung - ' + json.SKPD;
        html += '</div>';
        html += '<div class="mdc-card__subtitle dark-gray">';
        html += 'SirupID: #' + json.sirupID;
        html += '</div>'
    html += '</section>';
   
    html += '<section class="mdc-card__supporting-text ">';
        
        html += '<div class="procurement-card-container flex">';
            html += '<div class="procurement-card-details padding-small text-center">';
            html += '<img class="icon-medium" src="img/icon-money.png">';
            html += '<div class="mdc-typography--subheading1"> Anggaran </div>';
            html += '<div> <span class="mdc-typography--title f300"> ' + json.anggaran / 1000000 + ' </span> M</div>';
        html += '</div>';
    
        html += '<div class="procurement-card-details padding-small text-center">';
            html += '<img class="icon-medium" src="img/icon-RP.png">';
            html += ' <div class="mdc-typography--subheading1"> HPS </div>';
            html += ' <div class="mdc-typography--title f300"> ' + json.hps / 1000000  + ' </div>';
        html += '</div>';

        html += '<div class="procurement-card-details padding-small text-center">';
            html += ' <img class="icon-medium" src="img/icon-offer.png">';
            html += ' <div class="mdc-typography--subheading1"> Nilai Penawaran </div>';
            html += '<div class="mdc-typography--title f300"> ' +  json.nilai_penawaran  / 1000000  +  ' </div>';
        html += '</div>';

        html += '<div class="procurement-card-details padding-small text-center">';
            html += '<img class="icon-medium" src="img/icon-negotiation.png">';
            html += ' <div class="mdc-typography--subheading1"> Nilai Negotiation</div>';
            html += '<div class="mdc-typography--title f300"> ' +  json.nilai_nego / 1000000  + ' </div>';
    html += ' </div>';
    
    html += ' <div class="procurement-card-details padding-small text-center ">';
            html += '<img class="icon-medium" src="img/icon-contract-start.png">';
            html += '<div class="mdc-typography--subheading1">Contract start</div>';
            html += '<div class="mdc-typography--title f300">' +  moment(json.contract.startDate).format('ll') + '</div>';
    html += '</div>';
    
    html += ' <div class="procurement-card-details padding-small text-center">';
            html += '<img class="icon-medium" src="img/icon-contract-end.png">';
            html += '<div class="mdc-typography--subheading1">Contract end</div>';
            html += ' <div class="mdc-typography--title f300">' +  moment(json.contract.endDate).format('ll')  +'</div>';
    html += '</div>';
   
    html += ' </div>';
    html += ' <div>';
   
    html += '<p>This contract was awarded to  ';
    
    for (j = 0 ; j< json.suppliers.length; j++ ) {
        html += '<i> <u>' + json.suppliers[0].name + '</u></i>  ,';
    }

    html += 'and it was signed on <i> <u> ' +  moment(json.dateSigned).format('ll') + '</u></i> . ';
    html += 'The award criteria was <i><u>' + json.awardCriteria + '</u></i> , '; 
    html += 'The procurement method is <i><u>' + json.procurementMethodDetails + '</u></i>.'; 
    html += '</p>'; 
    html += ' </div>';
    html += '</section>';

    html += '<section class="mdc-card__actions">';
    html += ' <button class="mdc-button mdc-button--compact mdc-card__action"> APPLY </button>';
    html += '<button class="mdc-button mdc-button--compact mdc-card__action"> Download </button>';
    html += ' <button class="mdc-button mdc-button--compact mdc-card__action">Email</button>';
    html += '</section>';
    html += '</div>';




  }

 $("#recent-from-api").html(html);

}
