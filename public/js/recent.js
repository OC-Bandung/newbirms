$(document).ready(function(){
    var jqxhr = $.getJSON("api/v1/recent/perencanaan.json", function(data) {
        perencanaan(data);
    })
    
    .done(function() {
    })
    
    .fail(function() {
        console.log("error");
    })

    .always(function() {
    });
});

$("#load_perencanaan").click(function(e) {
    e.preventDefault();
    
    var jqxhr = $.getJSON("api/v1/recent/perencanaan.json", function(data) {
        perencanaan(data);
    })

    .done(function() {
    })

    .fail(function() {
        console.log("error");
    })

    .always(function() {
    });
});

$("#load_pengadaan").click(function(e) {
    e.preventDefault();
    
    var jqxhr = $.getJSON("api/v1/recent/pengadaan.json", function(data) {
        pengadaan(data);
    })

    .done(function() {
    })

    .fail(function() {
        console.log("error");
    })

    .always(function() {
    });
});

$("#load_pemenang").click(function(e) {
    e.preventDefault();
    
    var jqxhr = $.getJSON("api/v1/recent/pemenang.json", function(data) {
        pemenang(data);
    })

    .done(function() {
    })

    .fail(function() {
        console.log("error");
    })

    .always(function() {
    });
});

$("#load_kontrak").click(function(e) {
    e.preventDefault();

    var jqxhr = $.getJSON("api/v1/recent/kontrak.json", function(data) {
        kontrak(data);
    })

    .done(function() {
    })

    .fail(function() {
        console.log("error");
    })

    .always(function() {
    });
});

$("#load_implementasi").click(function(e) {
    e.preventDefault();

    var jqxhr = $.getJSON("api/v1/recent/implementasi.json", function(data) {
        implementasi(data);
    })

    .done(function() {
    })

    .fail(function() {
        console.log("error");
    })

    .always(function() {
    });
});


function perencanaan(data) {
    $("#recent_procurement_title").text("Perencanaan")
    html = "";

    for (i=0; i < data.length; i++) {
        json = data[i];

    if (i % 2 ==0) {
        html +=  '<div class="even">';
    } else {
        html +=  '<div class="odd">';
    }
   
    html += '<section class="mdc-card__primary">';
        html += '<h1 class="mdc-card__title mdc-card__title--large f300">';
        html += json.title;
        html += '</h1>';
        html += '<h2 class="mdc-card__subtitle">';
        html += 'Kota Bandung - ' + json.SKPD;
        html += '</h2>';
        html += '<h3 class="mdc-card__subtitle dark-gray">';
        html += 'SirupID: #' + json.sirupID;
        html += '</h3>'
    html += '</section>';
   
    html += '<section class="mdc-card__supporting-text ">';
        
        html += '<div class="procurement-card-container flex">';
            html += '<div class="procurement-card-details padding-small text-center">';
            html += '<img class="icon-large" src="img/icon-money.png">';
            html += '<div class="mdc-typography--subheading1"> Pagu </div>';
            html += '<div> <span class="mdc-typography--title f300"> ' + json.budget.amount.amount / 1000000 + ' </span> M</div>';
        html += '</div>';
    
        html += '<div class="procurement-card-details padding-small text-center">';
            html += '<img class="icon-large" src="img/icon-gov.png">';
            html += ' <div class="mdc-typography--subheading1"> Budget </div>';
            html += ' <div class="mdc-typography--title f300"> ' + json.budget.description + ' </div>';
        html += '</div>';

        html += '<div class="procurement-card-details padding-small text-center">';
            html += ' <img class="icon-large" src="img/icon-tender-start.png">';
            html += ' <div class="mdc-typography--subheading1"> Tender start </div>';
            html += '<div class="mdc-typography--title f300"> ' + moment(json.tender.startDate).format('ll') +  ' </div>';
        html += '</div>';

        html += '<div class="procurement-card-details padding-small text-center">';
            html += '<img class="icon-large" src="img/icon-tender-end.png">';
            html += ' <div class="mdc-typography--subheading1"> Tender end</div>';
            html += '<div class="mdc-typography--title f300"> ' +  moment(json.tender.endDate).format('ll') + ' </div>';
    html += ' </div>';
    
    html += ' <div class="procurement-card-details padding-small text-center ">';
            html += '<img class="icon-large" src="img/icon-contract-start.png">';
            html += '<div class="mdc-typography--subheading1">Contract start</div>';
            html += '<div class="mdc-typography--title f300">' +  moment(json.contract.startDate).format('ll') + '</div>';
    html += '</div>';
    
    html += ' <div class="procurement-card-details padding-small text-center">';
            html += '<img class="icon-large" src="img/icon-contract-end.png">';
            html += '<div class="mdc-typography--subheading1">Contract end</div>';
            html += ' <div class="mdc-typography--title f300">' +  moment(json.contract.endDate).format('ll')  +'</div>';
    html += '</div>';
   
    html += ' </div>';
    html += ' <div>';
    html += '<p>This contract is for <i> <u> ' +  json.mainProcurementCategory + '</u></i> in the program <u><i>' + json.project + '</u></i>. The procurement method is <u><i> ' + json.procurementMethodDetails  + ' </i></u>. The award criteria is <i> <u>'+  json.awardCriteria +'</u></i>.</p>';
    html += ' </div>';
    html += '</section>';

    html += '<section class="mdc-card__actions">';
    html += ' <button class="mdc-button mdc-button--compact mdc-card__action"> Apply in Sirup </button>';
    html += '<button class="mdc-button mdc-button--compact mdc-card__action"> Download </button>';
    html += ' <button class="mdc-button mdc-button--compact mdc-card__action">Email</button>';
    html += '</section>';
    html += '</div>';
  }

  $("#recent-from-api").html(html);
 
}


function pengadaan(data) {
    $("#recent_procurement_title").text("Pengadaan")

    html = "";

    for (i=0; i < data.length; i++) {
        json = data[i];

        if (i % 2 ==0) {
            html +=  '<div class="even">';
        } else {
            html +=  '<div class="odd">';
        }
   
        html += '<section class="mdc-card__primary">';
            html += '<h1 class="mdc-card__title mdc-card__title--large f300">';
            html += json.title;
            html += '</h1>';
            html += '<h2 class="mdc-card__subtitle">';
            html += 'Kota Bandung - ' + json.SKPD;
            html += '</h2>';
            html += '<h3 class="mdc-card__subtitle dark-gray">';
            html += 'SirupID: #' + json.sirupID;
            html += '</h3>'
        html += '</section>';
   
        html += '<section class="mdc-card__supporting-text ">';
            html += '<div class="procurement-card-container flex">';
                html += '<div class="procurement-card-details padding-small text-center">';
                html += '<img class="icon-large" src="img/icon-money.png">';
                html += '<div class="mdc-typography--subheading1"> Pagu </div>';
                html += '<div> <span class="mdc-typography--title f300"> ' + json.budget.amount.amount / 1000000 + ' </span> M</div>';
            html += '</div>';
    
            html += '<div class="procurement-card-details padding-small text-center">';
                html += '<img class="icon-large" src="img/icon-gov.png">';
                html += ' <div class="mdc-typography--subheading1"> Budget </div>';
                html += ' <div class="mdc-typography--title f300"> ' + json.budget.description + ' </div>';
            html += '</div>';

            html += '<div class="procurement-card-details padding-small text-center">';
                html += ' <img class="icon-large" src="img/icon-tender-start.png">';
                html += ' <div class="mdc-typography--subheading1"> Tender start </div>';
                html += '<div class="mdc-typography--title f300"> ' + moment(json.tender.startDate).format('ll') +  ' </div>';
            html += '</div>';

            html += '<div class="procurement-card-details padding-small text-center">';
                html += '<img class="icon-large" src="img/icon-tender-end.png">';
                html += ' <div class="mdc-typography--subheading1"> Tender end</div>';
                html += '<div class="mdc-typography--title f300"> ' +  moment(json.tender.endDate).format('ll') + ' </div>';
            html += '</div>';
    
            html += ' <div class="procurement-card-details padding-small text-center ">';
                    html += '<img class="icon-large" src="img/icon-contract-start.png">';
                    html += '<div class="mdc-typography--subheading1">Contract start</div>';
                    html += '<div class="mdc-typography--title f300">' +  moment(json.contract.startDate).format('ll') + '</div>';
            html += '</div>';
            
            html += ' <div class="procurement-card-details padding-small text-center">';
                    html += '<img class="icon-large" src="img/icon-contract-end.png">';
                    html += '<div class="mdc-typography--subheading1">Contract end</div>';
                    html += ' <div class="mdc-typography--title f300">' +  moment(json.contract.endDate).format('ll')  +'</div>';
            html += '</div>';
   
        html += ' </div>'; //???
    
        html += ' <div>';
        html += '<p>This contract is for <i> <u> ' +  json.mainProcurementCategory + '</u></i> in the program <u><i>' + json.project + '</u></i>. The procurement method is <u><i> ' + json.procurementMethodDetails  + ' </i></u>. The award criteria is <i> <u>'+  json.awardCriteria +'</u></i>.</p>';
        html += ' </div>';
    html += '</section>';

    html += '<section class="mdc-card__actions">';
        html += '<button class="mdc-button mdc-button--compact mdc-card__action"> Apply in Sirup </button>';
        html += '<button class="mdc-button mdc-button--compact mdc-card__action"> Download </button>';
        html += '<button class="mdc-button mdc-button--compact mdc-card__action">Email</button>';
    html += '</section>';
    html += '</div>';
  }

  $("#recent-from-api").html(html);
 
}


function pemenang(data) {
    $("#recent_procurement_title").text("Pemenang")

    html = "";

    for (i=0; i < data.length; i++) {
        json = data[i];

        if (i % 2 ==0) {
            html +=  '<div class="even">';
        } else {
            html +=  '<div class="odd">';
        }
   
        html += '<section class="mdc-card__primary">';
            html += '<h1 class="mdc-card__title mdc-card__title--large f300">';
            html += json.title;
            html += '</h1>';
            html += '<h2 class="mdc-card__subtitle">';
            html += 'Kota Bandung - ' + json.SKPD;
            html += '</h2>';
            html += '<h3 class="mdc-card__subtitle dark-gray">';
            html += 'SirupID: #' + json.sirupID;
            html += '</h3>'
        html += '</section>';
   
        html += '<section class="mdc-card__supporting-text ">';
            html += '<div class="procurement-card-container flex">';
                html += '<div class="procurement-card-details padding-small text-center">';
                html += '<img class="icon-large" src="img/icon-money.png">';
                html += '<div class="mdc-typography--subheading1"> Pagu </div>';
                html += '<div> <span class="mdc-typography--title f300"> ' + json.budget.amount.amount / 1000000 + ' </span> M</div>';
            html += '</div>';
    
            html += '<div class="procurement-card-details padding-small text-center">';
                html += '<img class="icon-large" src="img/icon-gov.png">';
                html += ' <div class="mdc-typography--subheading1"> Budget </div>';
                html += ' <div class="mdc-typography--title f300"> ' + json.budget.description + ' </div>';
            html += '</div>';

            html += '<div class="procurement-card-details padding-small text-center">';
                html += ' <img class="icon-large" src="img/icon-tender-start.png">';
                html += ' <div class="mdc-typography--subheading1"> Tender start </div>';
                html += '<div class="mdc-typography--title f300"> ' + moment(json.tender.startDate).format('ll') +  ' </div>';
            html += '</div>';

            html += '<div class="procurement-card-details padding-small text-center">';
                html += '<img class="icon-large" src="img/icon-tender-end.png">';
                html += ' <div class="mdc-typography--subheading1"> Tender end</div>';
                html += '<div class="mdc-typography--title f300"> ' +  moment(json.tender.endDate).format('ll') + ' </div>';
            html += '</div>';
    
            html += ' <div class="procurement-card-details padding-small text-center ">';
                    html += '<img class="icon-large" src="img/icon-contract-start.png">';
                    html += '<div class="mdc-typography--subheading1">Contract start</div>';
                    html += '<div class="mdc-typography--title f300">' +  moment(json.contract.startDate).format('ll') + '</div>';
            html += '</div>';
            
            html += ' <div class="procurement-card-details padding-small text-center">';
                    html += '<img class="icon-large" src="img/icon-contract-end.png">';
                    html += '<div class="mdc-typography--subheading1">Contract end</div>';
                    html += ' <div class="mdc-typography--title f300">' +  moment(json.contract.endDate).format('ll')  +'</div>';
            html += '</div>';
   
        html += ' </div>'; //???
    
        html += ' <div>';
        html += '<p>This contract is for <i> <u> ' +  json.mainProcurementCategory + '</u></i> in the program <u><i>' + json.project + '</u></i>. The procurement method is <u><i> ' + json.procurementMethodDetails  + ' </i></u>. The award criteria is <i> <u>'+  json.awardCriteria +'</u></i>.</p>';
        html += ' </div>';
    html += '</section>';

    html += '<section class="mdc-card__actions">';
        html += '<button class="mdc-button mdc-button--compact mdc-card__action"> Apply in Sirup </button>';
        html += '<button class="mdc-button mdc-button--compact mdc-card__action"> Download </button>';
        html += '<button class="mdc-button mdc-button--compact mdc-card__action">Email</button>';
    html += '</section>';
    html += '</div>';
  }

  $("#recent-from-api").html(html);
 
}

function kontrak(data){
    $("#recent_procurement_title").text("Kontrak")
    
    html = "";

    for (i=0; i < data.length; i++) {
        json = data[i];

    if (i % 2 ==0) {
        html +=  '<div class="even">';
    } else {
        html +=  '<div class="odd">';
    }
   
    html += '<section class="mdc-card__primary">';
        html += '<h1 class="mdc-card__title mdc-card__title--large f300">';
        html += json.title;
        html += '</h1>';
        html += '<h2 class="mdc-card__subtitle">';
        html += 'Kota Bandung - ' + json.SKPD;
        html += '</h2>';
        html += '<h3 class="mdc-card__subtitle dark-gray">';
        html += 'SirupID: #' + json.sirupID;
        html += '</h3>'
    html += '</section>';
   
    html += '<section class="mdc-card__supporting-text ">';
        
        html += '<div class="procurement-card-container flex">';
            html += '<div class="procurement-card-details padding-small text-center">';
            html += '<img class="icon-large" src="img/icon-money.png">';
            html += '<div class="mdc-typography--subheading1"> Anggaran </div>';
            html += '<div> <span class="mdc-typography--title f300"> ' + json.anggaran / 1000000 + ' </span> M</div>';
        html += '</div>';
    
        html += '<div class="procurement-card-details padding-small text-center">';
            html += '<img class="icon-large" src="img/icon-RP.png">';
            html += ' <div class="mdc-typography--subheading1"> HPS </div>';
            html += ' <div class="mdc-typography--title f300"> ' + json.hps / 1000000  + ' </div>';
        html += '</div>';

        html += '<div class="procurement-card-details padding-small text-center">';
            html += ' <img class="icon-large" src="img/icon-offer.png">';
            html += ' <div class="mdc-typography--subheading1"> Nilai Penawaran </div>';
            html += '<div class="mdc-typography--title f300"> ' +  json.nilai_penawaran  / 1000000  +  ' </div>';
        html += '</div>';

        html += '<div class="procurement-card-details padding-small text-center">';
            html += '<img class="icon-large" src="img/icon-negotiation.png">';
            html += ' <div class="mdc-typography--subheading1"> Nilai Negotiation</div>';
            html += '<div class="mdc-typography--title f300"> ' +  json.nilai_nego / 1000000  + ' </div>';
    html += ' </div>';
    
    html += ' <div class="procurement-card-details padding-small text-center ">';
            html += '<img class="icon-large" src="img/icon-contract-start.png">';
            html += '<div class="mdc-typography--subheading1">Contract start</div>';
            html += '<div class="mdc-typography--title f300">' +  moment(json.contract.startDate).format('ll') + '</div>';
    html += '</div>';
    
    html += ' <div class="procurement-card-details padding-small text-center">';
            html += '<img class="icon-large" src="img/icon-contract-end.png">';
            html += '<div class="mdc-typography--subheading1">Contract end</div>';
            html += ' <div class="mdc-typography--title f300">' +  moment(json.contract.endDate).format('ll')  +'</div>';
    html += '</div>';
   
    html += ' </div>';
    html += ' <div>';
    html += '<p>This contract was awarded to <i> <u> ' +  json.suppliers[0].name + '</u></i> ';
    html += 'and it was signed on <i> <u> ' +  moment(json.dateSigned).format('ll') + '</u></i> . ';
    html += 'The award criteria was <i><u>' + json.awardCriteria + '</u></i> , '; 
    html += 'The procurement method is <i><u>' + json.procurementMethodDetails + '</u></i>.'; 
    html += '</p>'; 
    html += ' </div>';
    html += '</section>';

    html += '<section class="mdc-card__actions">';
    html += ' <button class="mdc-button mdc-button--compact mdc-card__action"> Apply in Sirup </button>';
    html += '<button class="mdc-button mdc-button--compact mdc-card__action"> Download </button>';
    html += ' <button class="mdc-button mdc-button--compact mdc-card__action">Email</button>';
    html += '</section>';
    html += '</div>';
  }

 $("#recent-from-api").html(html);

}

function implementasi(data) {
    $("#recent_procurement_title").text("Implementasi")

    html = "";

    for (i=0; i < data.length; i++) {
        json = data[i];

        if (i % 2 ==0) {
            html +=  '<div class="even">';
        } else {
            html +=  '<div class="odd">';
        }
   
        html += '<section class="mdc-card__primary">';
            html += '<h1 class="mdc-card__title mdc-card__title--large f300">';
            html += json.title;
            html += '</h1>';
            html += '<h2 class="mdc-card__subtitle">';
            html += 'Kota Bandung - ' + json.SKPD;
            html += '</h2>';
            html += '<h3 class="mdc-card__subtitle dark-gray">';
            html += 'SirupID: #' + json.sirupID;
            html += '</h3>'
        html += '</section>';
   
        html += '<section class="mdc-card__supporting-text ">';
            html += '<div class="procurement-card-container flex">';
                html += '<div class="procurement-card-details padding-small text-center">';
                html += '<img class="icon-large" src="img/icon-money.png">';
                html += '<div class="mdc-typography--subheading1"> Pagu </div>';
                html += '<div> <span class="mdc-typography--title f300"> ' + json.budget.amount.amount / 1000000 + ' </span> M</div>';
            html += '</div>';
    
            html += '<div class="procurement-card-details padding-small text-center">';
                html += '<img class="icon-large" src="img/icon-gov.png">';
                html += ' <div class="mdc-typography--subheading1"> Budget </div>';
                html += ' <div class="mdc-typography--title f300"> ' + json.budget.description + ' </div>';
            html += '</div>';

            html += '<div class="procurement-card-details padding-small text-center">';
                html += ' <img class="icon-large" src="img/icon-tender-start.png">';
                html += ' <div class="mdc-typography--subheading1"> Tender start </div>';
                html += '<div class="mdc-typography--title f300"> ' + moment(json.tender.startDate).format('ll') +  ' </div>';
            html += '</div>';

            html += '<div class="procurement-card-details padding-small text-center">';
                html += '<img class="icon-large" src="img/icon-tender-end.png">';
                html += ' <div class="mdc-typography--subheading1"> Tender end</div>';
                html += '<div class="mdc-typography--title f300"> ' +  moment(json.tender.endDate).format('ll') + ' </div>';
            html += '</div>';
    
            html += ' <div class="procurement-card-details padding-small text-center ">';
                    html += '<img class="icon-large" src="img/icon-contract-start.png">';
                    html += '<div class="mdc-typography--subheading1">Contract start</div>';
                    html += '<div class="mdc-typography--title f300">' +  moment(json.contract.startDate).format('ll') + '</div>';
            html += '</div>';
            
            html += ' <div class="procurement-card-details padding-small text-center">';
                    html += '<img class="icon-large" src="img/icon-contract-end.png">';
                    html += '<div class="mdc-typography--subheading1">Contract end</div>';
                    html += ' <div class="mdc-typography--title f300">' +  moment(json.contract.endDate).format('ll')  +'</div>';
            html += '</div>';
   
        html += ' </div>'; //???
    
        html += ' <div>';
        html += '<p>This contract is for <i> <u> ' +  json.mainProcurementCategory + '</u></i> in the program <u><i>' + json.project + '</u></i>. The procurement method is <u><i> ' + json.procurementMethodDetails  + ' </i></u>. The award criteria is <i> <u>'+  json.awardCriteria +'</u></i>.</p>';
        html += ' </div>';
    html += '</section>';

    html += '<section class="mdc-card__actions">';
        html += '<button class="mdc-button mdc-button--compact mdc-card__action"> Apply in Sirup </button>';
        html += '<button class="mdc-button mdc-button--compact mdc-card__action"> Download </button>';
        html += '<button class="mdc-button mdc-button--compact mdc-card__action">Email</button>';
    html += '</section>';
    html += '</div>';
  }

  $("#recent-from-api").html(html);
 
}
