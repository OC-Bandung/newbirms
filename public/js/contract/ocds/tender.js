function load_tender(data) {

  var tender = data.tender;
  $("#tender-section").removeClass("d-none");
  //ocds-afzrfb-s-2016-6124079

  var myUI = [

    {
      "name": "tender.title",
      "ui_element": "#page-title",
    },
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

  if (data.tender.tenderPeriod.endDate && data.tender.tenderPeriod && data.tender.tenderPeriod.startDate ) {
      $("#tender-tender-days-diff").text("Duration: " + moment(data.tender.tenderPeriod.endDate).diff( moment(data.tender.tenderPeriod.startDate), 'days') + " days");
      $("#tender-tender-days-diff-container").removeClass('d-none') ;
  }

  if (data.tender.contractPeriod.endDate && data.tender.contractPeriod && data.tender.contractPeriod.startDate ) {
     $("#tender-contract-days-diff").text("Duration: " +  moment(data.tender.contractPeriod.endDate).diff( moment(data.tender.contractPeriod.startDate), 'days') + " days" );
  }

  if ( data.planning.budget.amount.amount &&  data.planning.budget) {
      $("#tender-budget-amount").text(data.planning.budget.amount.amount/1000000);
      $("#tender-budget-amount-container").removeClass("d-none");
  }

  if ( data.tender.value &&  data.tender.value.amount) {
       $("#tender-value-amount").text(data.tender.value.amount/1000000);
       $("#tender-value-amount-container").removeClass("d-none");
   }

   if (data.planning.budget.amount.amount &&  data.tender.value && data.tender.value.amount) {

     console.log("test");

      var myBudget = data.planning.budget.amount.amount;
      var myTender = data.tender.value.amount;
      var diff_tb = myTender - myBudget;
      var diff_tb_perc = (myTender/myBudget * 100).toFixed(2) - 100;

      $("#tender-value-diff-container").removeClass("d-none");
      $("#vertical-chart-container").removeClass("d-none");
      $("#tender-value-diff-container").removeClass("d-none");

      if (diff_tb <= 0 ) {
        $("#tender-amount-flag").html('<span class="badge badge-pill badge-success">Tender is less than budget</span>');
      } else {
        $("#tender-amount-flag").html('<span class="badge badge-pill badge-danger">Tender is more than budget</span>');
      }

      $("#tender-value-diff").text( diff_tb /1000000);

      if (diff_tb_perc <= 0 ) {
        $("#tender-value-diff-percentage").append("<div class='text-success'><i class='material-icons'>arrow_downward</i>" + diff_tb_perc + " % </div>");
      } else {
        $("#tender-value-diff-percentage").append("<div class='text-danger'><i class='material-icons'>arrow_upward</i>" + diff_tb_perc + " % </div>");
      }

      var highest = Math.max(myBudget, myTender);

      var max = $("#vertical-chart").height();

      $("#expected").css('height', (myBudget/highest)*max);
      $("#actual").css('height', (myTender/highest)*max);


      $("li#expected").append('<span class="chart-label mt-5 h6 bg-dark text-white p-2" style="margin-left:-120px;"> Budget: ' + myBudget/1000000 + ' M<span>');
      $("li#actual").append( '<span class="chart-label mt-5 ml-5 h6 bg-dark text-white p-2"> Tender: ' + myTender/1000000 + ' M<span>');

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
                    html+= '<div class="h6">Due Date: ' + moment(data.tender.milestones[i].dueDate).format('ll')  + '</div>';
                    html+=  '<div class="h6">Date Met: ' + moment(data.tender.milestones[i].dateMet).format('ll')  + '</div>';
                html += '</div>';
                if (diff_milestone <=0) {
                  html += '<div class="col-6 h6 pt-3 text-success float-right">' +  diff_milestone +  '<small> days before deadline</small></div>';
                } else {
                  html += '<div class="col-6 h6 pt-3 text-danger float-right"> ' +  diff_milestone +  '<small> days after deadline</small> </div>';
                }

              html+= '</div>';
             html +='<div><button class="btn btn-sm btn-outline-secondary float-right" type="button" data-target="#t_details" data-toggle="collapse">Add to Calendar ▼</button>';
             html +='<div class="collapse bl-3px-black" id="t_details">';
               html +='<div class="p-2 small text-monospace">';
                 html +='<div><a href="#">add to Google Calendar</a></div>';
                html += '<div><a href="#">add to Outlook</a></div>';
                 html +='<div><a href="#">send by email</a></div>';
              html += '</div>';
           html +='</div>';
          html += '</div></div>';
         html +='</div>';
      html +=' </div>';

    $("#tender-milestones-cards").append(html);

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
