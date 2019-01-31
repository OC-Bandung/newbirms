function load_tender(data) {

  var tender = data.tender;
  $("#tender-section").removeClass("d-none");
  //ocds-afzrfb-s-2016-6124079

  var myUI = [

    {
      "name": "tender.status",
      "ui_element": "#tender-status",
      "ui_container": "#tender-status-container"
    },
    {
      "name": "tender.mainProcurementCategory",
      "ui_element": "#tender-mainProcurementCategory",
      "ui_container": "#tender-mainProcurementCategory-container"
    },
    {
      "name": "tender.procurementMethod",
      "ui_element": "#tender-procurementMethod",
      "ui_container": "#tender-procurementMethod-container"
    },
    {
      "name": "tender.numberOfTenderers",
      "ui_element": "#tender-numberOfTenderers",
      "ui_container": "#tender-numberOfTenderers-container"
    },
    {
      "name": "tender.tenderPeriod.startDate",
      "ui_element": "#tender-tenderPeriod-startDate",
      "ui_container": "#tender-tenderPeriod-startDate-container"
    },
    {
      "name": "tender.tenderPeriod.endDate",
      "ui_element": "#tender-tenderPeriod-endDate",
      "ui_container": "#tender-tenderPeriod-endDate-container"
    },
    {
      "name": "tender.contractPeriod.startDate",
      "ui_element": "#tender-contractPeriod-startDate",
      "ui_container": "#tender-contractPeriod-startDate-container"
    },
    {
      "name": "tender.contractPeriod.endDate",
      "ui_element": "#tender-contractPeriod-endDate",
      "ui_container": "#tender-contractPeriod-endDate-container"
    }
  ];

  displayJsonInUI (myUI , data);


  // custom if conditions for calculated fields
  $("#sirup-link").attr("href", "https://sirup.lkpp.go.id/sirup/rup/detailPaketPenyedia2018?idPaket=" + data.id + "");
  //$("#lpse-link").attr("href", "http://lpse.bandung.go.id/eproc4/lelang/" + data.tender.id + "/pengumumanlelang");
  //$("#birms-link").attr("href", "https://birms.bandung.go.id/econtract/index.php?fa=site.pengumuman&id=" + data.id + "&token=2ee26f554a683f4cefef30b86d39323c");
  if (data.tender.status == "planned") {
      $("#tender-status").text("Perencanaan");
  } else if (data.tender.status == "active") {
      $("#tender-status").text("Berjalan");
  } else if (data.tender.status == "unsuccesful") {
      $("#tender-status").text("Gagal");
  } else if (data.tender.status == "complete") {
      $("#tender-status").text("Selesai");
  } else {
      $("#tender-status").text("-");
  }
  //$("#tender-status").text(data.tender.status);

  if (data.tender.mainProcurementCategory == "goods") {
    $("#tender-mainProcurementCategory").text("Pengadaan Barang");
  } else if (data.tender.mainProcurementCategory == "works") {
    $("#tender-mainProcurementCategory").text("Konstruksi");
  } else if (data.tender.mainProcurementCategory == "services") {
    $("#tender-mainProcurementCategory").text("Konsultan / Jasa Lainnya");
  }
  //$("#tender-mainProcurementCategory").text(data.tender.mainProcurementCategory);

  if (data.tender.procurementMethod == "open") {
    $("#tender-procurementMethod").text("Tender");
  } else if (data.tender.procurementMethod == "limited") {
    $("#tender-procurementMethod").text("Limited");
  } if (data.tender.procurementMethod == "direct") {
    $("#tender-procurementMethod").text("Non Tender");
  }
  //$("#tender-procurementMethod").text(data.tender.procurementMethod);
  $("#tender-numberOfTenderers").text(data.tender.numberOfTenderers);

  if (data.tender.tenderPeriod) {
  	if (data.tender.tenderPeriod && data.tender.tenderPeriod.endDate && data.tender.tenderPeriod.startDate ) {
      $("#tender-tenderPeriod-endDate").text(moment(data.tender.tenderPeriod.endDate).format('ll'));
      $("#tender-tenderPeriod-startDate").text(moment(data.tender.tenderPeriod.startDate).format('ll'));
      
      $("#tender-tender-days-diff").text("Waktu: " + moment(data.tender.tenderPeriod.endDate).diff( moment(data.tender.tenderPeriod.startDate), 'days') + " hari");
    	$("#tender-tender-days-diff-container").removeClass('d-none') ;
      
        base_url = "https://calendar.google.com/calendar/r/eventedit";
        text = "?text=" + $("#page-title").text();
        due_date1 = moment(data.tender.tenderPeriod.startDate).format("YYYYMMDD") ;
        due_date2 = moment(data.tender.tenderPeriod.endDate).format("YYYYMMDD");
        dates = "&dates=" + due_date1 + "/" + due_date2 ;
        details = "&details=Tahapan: Tender dimulai<br> Untuk data lebih lanjut silahkan berkunjung ke : " + window.location.href;
        details += "&location="+data.tender.procuringEntity.name;
        calendar_url = base_url + text + dates + details ;

        $("#tender-tenderPeriod-add").attr("href", calendar_url);
  	}
  }

  if(data.tender.contractPeriod) {
  	if (data.tender.contractPeriod && data.tender.contractPeriod.endDate && data.tender.contractPeriod.startDate ) {
      $("#tender-contractPeriod-endDate").text(moment(data.tender.contractPeriod.endDate).format('ll'));
      $("#tender-contractPeriod-startDate").text(moment(data.tender.contractPeriod.startDate).format('ll'));

      $("#tender-contract-days-diff").text("Waktu: " +  moment(data.tender.contractPeriod.endDate).diff( moment(data.tender.contractPeriod.startDate), 'days') + " hari" );
     	//var Dates = data.tender.contractPeriod.startDate.replace(/-|:|\+\0000/g, "") + "/" + data.tender.contractPeriod.endDate.replace(/-|:|\+\0000/g, "");
     	//var Dates = moment(data.tender.contractPeriod.startDate).format("YYYYMMDD") + "/" + moment(data.tender.contractPeriod.endDate).format("YYYYMMDD");

       //$("#tender-contractPeriod-add").attr("href", "https://www.google.com/calendar/render?action=TEMPLATE&text=Tender+Mulai&dates="+Dates+"&details="+data.planning.budget.project+",+link+here:+https://birms.bandung.go.id&location="+data.tender.procuringEntity.name+"&sf=true&output=xml");
       base_url = "https://calendar.google.com/calendar/r/eventedit";
       text = "?text=" + $("#page-title").text();
       due_date1 = moment(data.tender.contractPeriod.startDate).format("YYYYMMDD") ;
       due_date2 = moment(data.tender.contractPeriod.endDate).add(1, 'days').format("YYYYMMDD");
       dates = "&dates=" + due_date1 + "/" + due_date2 ;
       details = "&details=Tahapan: Estimasi Pengerjaan Paket Pekerjaan<br> Untuk data lebih lanjut silahkan berkunjung ke : " + window.location.href;
       details += "&location="+data.tender.procuringEntity.name;
       calendar_url = base_url +  text + dates + details ;

     	$("#tender-contractPeriod-add").attr("href", calendar_url);
  	}
  }

  if ( data.planning.budget.amount.amount &&  data.planning.budget) {
      $("#tender-budget-amount").text(numberWithCommas(data.planning.budget.amount.amount));
      $("#tender-budget-amount-container").removeClass("d-none");
  }

  if ( data.tender.value &&  data.tender.value.amount) {
       $("#tender-value-amount").text(numberWithCommas(data.tender.value.amount));
       $("#tender-value-amount-container").removeClass("d-none");
   }

   if (data.planning.budget.amount.amount &&  data.tender.value && data.tender.value.amount) {

      var myBudget = data.planning.budget.amount.amount;
      var myTender = data.tender.value.amount;
      var diff_tb = myTender - myBudget;
      var diff_tb_perc = (myTender/myBudget * 100).toFixed(2) - 100;

      $("#tender-value-diff-container").removeClass("d-none");
      $("#vertical-chart-container").removeClass("d-none");
      $("#tender-value-diff-container").removeClass("d-none");

      if (diff_tb <= 0 ) {
        $("#tender-amount-flag").html('<span class="badge badge-pill badge-success">Tender kurang dari pagu anggaran</span>');
      } else {
        $("#tender-amount-flag").html('<span class="badge badge-pill badge-danger">Tender melebihi pagu anggaran</span>');
      }

      $("#tender-value-diff").text(numberWithCommas(diff_tb));

      if (diff_tb_perc <= 0 ) {
        $("#tender-value-diff-percentage").append("<div class='text-success'><i class='material-icons'>arrow_downward</i>" + numberWithCommas(diff_tb_perc.toFixed(2)) + " % </div>");
      } else {
        $("#tender-value-diff-percentage").append("<div class='text-danger'><i class='material-icons'>arrow_upward</i>" + numberWithCommas(diff_tb_perc.toFixed(2)) + " % </div>");
      }

      var highest = Math.max(myBudget, myTender);

      var max = $("#vertical-chart").height();

      $("#expected").css('height', (myBudget/highest)*max);
      $("#actual").css('height', (myTender/highest)*max);


      //$("li#expected").append('<span class="chart-label mt-5 h6 bg-dark text-white p-2" style="margin-left:-120px;"> Pagu Anggaran: Rp. ' + numberWithCommas(myBudget) + '<span>');
      //$("li#actual").append( '<span class="chart-label mt-5 ml-5 h6 bg-dark text-white p-2" style="margin-left:-120px;"> Penawaran: Rp. ' + numberWithCommas(myTender) + '<span>');
      $("li#expected").append('<span class="chart-label mt-1 ml-3 h6 bg-dark text-white p-2"> Pagu Anggaran: Rp.' + numberWithCommas(myBudget) + '<span>');
      $("li#actual").append('<span class="chart-label mt-5 ml-3 h6 bg-dark text-white p-2"> Penawaran: Rp.' + numberWithCommas(myTender) + '<span>');

   }

   if (data.tender.tenderers) {
     load_tenderers(data);
     $("#tender-registered-bidders-tab").removeClass('d-none');
   }





   for (i=0; i < data.tender.milestones.length  ; i++ ) {

     var numberMilestones = data.tender.milestones.length ;

     $("sup#tender-milestone-count").text("(" + numberMilestones + ")");
     $("#tender-milestones-tab").removeClass('d-none');


      diff_milestone = moment(data.tender.milestones[i].dateMet).diff( moment(data.tender.milestones[i].dueDate), 'days') ;
       html = '<div class="col-6 mt-2">';
          html +='<div class="card  shadow">';
           html +='<div class="card-body">';
           html+= '<div class="tender-timeline-counter text-center float-right">' + (i+1) + '</div>';
              html +='<h5 class="card-title">' +   data.tender.milestones[i].title +   '</h5>';
                html += '<div class="row">';
                html += '<div class="col-6">';
                    html+= '<div class="h6 cal-duedate">Batas Akhir: ' + moment(data.tender.milestones[i].dueDate).format('ll')  + '</div>';
                    html+=  '<div class="h6">Mulai : ' + moment(data.tender.milestones[i].dateMet).format('ll')  + '</div>';
                html += '</div>';
                if (diff_milestone <=0) {
                  html += '<div class="col-6 h6 pt-3 text-success float-right">' +  diff_milestone +  '<small> hari sebelum tenggat waktu</small></div>';
                } else {
                  html += '<div class="col-6 h6 pt-3 text-danger float-right"> ' +  diff_milestone +  '<small> hari sesudah tenggat waktu</small> </div>';
                }

              html+= '</div>';

              base_url = "https://calendar.google.com/calendar/r/eventedit";
              text = "?text=" + $("#page-title").text();
              due_date1 = moment(data.tender.milestones[i].dateMet ).format("YYYYMMDD") ;
              due_date2 = moment(data.tender.milestones[i].dueDate ).add(1, 'days').format("YYYYMMDD");
              dates = "&dates=" + due_date1 + "/" + due_date2 ;
              details = "&details=Milestone: " +  data.tender.milestones[i].title + ". <br> For more details please visit: " + window.location.href  ;
              calendar_url = base_url +  text + dates + details ;

             html +='<div><button class="btn btn-sm btn-outline-secondary float-right" type="button" data-target="#t_details" data-toggle="collapse">Tambahkan ke Kalender ▼</button>';
             html +='<div class="collapse bl-3px-black" id="t_details">';
               html +='<div class="p-2 small text-monospace">';
                 html +='<div><a  target="_blank" class="cal-addtocalendar" href="' + calendar_url + ' "><i class="material-icons small">add_box</i> ke Google Calendar</a></div>';
                //html += '<div><a href="#"><i class="material-icons small">add_box</i> ke Outlook</a></div>';
                 //html +='<div><a href="#"><i class="material-icons small">mail</i> kirim email</a></div>';
              html += '</div>';
           html +='</div>';
          html += '</div></div>';
         html +='</div>';
      html +=' </div>';

    load_document_link(data.ocid);

    $("#tender-milestones-cards").append(html);

   }
   function load_document_link(ocid) {
    // custom links based on ocid
    // if it has s: ocds-afzrfb-s-2016-6124079 - show sirup links
    // if it has b: show birms link ocds-afzrfb-b-2016-38800
    var the_link = "#";
     if (ocid.substring(12, 13) == "s") {
      $("#link-title").text("LPSE Link");
      the_link = "http://lpse.bandung.go.id/eproc4/lelang/" + data.tender.id + "/pengumumanlelang";
    }
     if (ocid.substring(12, 13) == "b") {
        $("#link-title").text("BIRMS Link");
        the_link = "https://birms.bandung.go.id/econtract/index.php?fa=site.pengumuman&id=" + data.id + "&token=2ee26f554a683f4cefef30b86d39323c";
    }
     $("#link-content").html('Lihat Data asli dari di <a  target="_blank" href="' +  the_link + '">this link</a>.');
  }
}

function load_tenderers (data) {

  if (data.tender.tenderers) {
    $("sup#tender-registered-bidders-counter").text("(" + data.tender.tenderers.length + ")");

    //pagination and tenderers
    $(function() {
      (function(name) {
        var container = $('#' + name );
        var navcontainer = $("#navcontainer");
        var sources = function () {
          var result = [];
          //only show specific values, not whole array that includes things like contact phone and email
          for (i=0; i< data.tender.tenderers.length; i++) {
            let strAddress = "";
            
            if ( data.tender.tenderers[i].address && data.tender.tenderers[i].address.streetAddress ) {
              strAddress = data.tender.tenderers[i].address.streetAddress;
            }

            tenderers_fields =  [ (i+1),   data.tender.tenderers[i].id  ,  data.tender.tenderers[i].name  , strAddress ];
            result.push(tenderers_fields);
          }
          return result;
        }();
        var options = {
          dataSource: sources,
          pageSize: 10,
          callback: function (response, pagination) {
            var dataHtml = '';
            $.each(response, function (index, item) {
              dataHtml += '<tr>';
              for (i=0; i< item.length; i++) {
                dataHtml += '<td class="h6">' + item[i] + '</td>';
              }
               dataHtml += '</tr>';
            });
            navcontainer.prev().find('tbody').html(dataHtml);
          }
        };
        navcontainer.pagination(options);
      })('tender-tenderers-list');

    })
  } else {
    $("#tender-tenderers-tab").addClass("d-none");
  }

}
