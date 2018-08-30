function DisplayList() {
  var myList = getOCLocalStorage();
  $("#watch-list-container").html("");
  if(myList) {
    for ( item in myList) {
      var listCode = myList[item].listCode;
      var eln = document.getElementById("watch-list-sample").cloneNode(true);
      eln.id =  listCode;
      $("#watch-list-container").append(eln);
      $("div#" + listCode + " div.watch-list-title").html(myList[item].listName);
      $("div#" + listCode).removeClass("d-none");
        for (itm in myList[item]["listItems"]) {
          ocid = myList[item]["listItems"][itm].ocid;
          title = myList[item]["listItems"][itm].title;
          stage = myList[item]["listItems"][itm].stage;
          numberOfTenderers = myList[item]["listItems"][itm].numberOfTenderers;
            el_html = '<li id="' + ocid + '" class="list-group-item">';
            el_html += '<span class="badge badge-pill badge-dark mr-2">' + stage + '</span>' ;
            el_html += '<span class="h6 pr-2"><a target="_blank" href="contract?ocid=' + ocid + '">' + title + '</a></span>'  ;
            el_html +=  '<span class="tenderers h6 float-right"># Tenderers: ' + numberOfTenderers +  '</span>';
            el_html += '</li>';
             $("div#" + listCode + ' ul.watch-list-ocid').append(el_html);
        }

    }
  }
}

$(document).ready(function() {
    DisplayList();


    url = 'https://webhooks.mongodb-stitch.com/api/client/v2.0/app/birms-cvrbm/service/query-birms/incoming_webhook/find-releases?secret=6WkBFKh6SS4ibE2O0Fm5UHGEQWv8hQbj&q=';
    trending_url = url + '{"tender.numberOfTenderers":{"$gt":20}}&limit=5';

  var jqxhr = $.getJSON(trending_url, function(data) {
          load_trending(data);
      })
      .done(function() {
          console.log("done");
      })
      .fail(function() {
          console.log("fail");
      })
      .always(function() {
          console.log("always");
      });
});

$("a#watch-list-create").click(function(e) {
    e.preventDefault();
    $("#watch-list-input").val("");
    $("#watch-list-input-container").toggleClass("d-none");
});

$("#watch-list-input-submit").click(function(e) {
    e.preventDefault();
    myListCode = "watch-list-" + genUniqueListCode();
    myListName = $("#watch-list-input").val();
    addListToLocalStorage(myListCode, myListName);
    DisplayList();
    $("#watch-list-input-container").addClass("d-none");
});

$(document).on('click', '[id^="watch-list-"]', function(e) {

   $(this).children('.watch-list-content').removeClass("d-none");

});

$(document).on('click', '.fetch-update', function(e) {

   $('.lds-dual-ring').removeClass('d-none');

   $(this).closest('[id^="watch-list-"]').removeClass("d-none");

   let fetchList = $(this).closest('[id^="watch-list-"]').attr("id");

   $("div#" + fetchList + ' div.watch-list-content ul.watch-list-ocid li').each(function(i) {
      fetchOCID = $(this).attr('id'); // This is your rel value
      let element = $("div#" + fetchList + ' div.watch-list-content ul.watch-list-ocid li#' + fetchOCID);
      stage = element.children('.badge').text();
      nbre = element.children('.numberOfTenderers').text();
      fetch_and_update(fetchOCID,element, stage, nbre);
    });

    $('.lds-dual-ring').addClass('d-none');

});

function fetch_and_update(ocid , element , stage, nbre) {


  let fetchURL ="https://birms.bandung.go.id/beta/api/newcontract/"+ fetchOCID;
  var fetchCallback_url=fetchURL+"?callback=?";

  var jqxhr = $.getJSON(fetchCallback_url, function(fetchedData) {
          if (fetchedData.planning ) {
            newstage = "planning";
            newnbre = "";
          }
        if (fetchedData.tender ) {
          newstage = "tender";
          newnbre = fetchedData.tender.numberOfTenderers;
        }
       if (fetchedData.awards && fetchedData.awards.length > 0 ) {
         newstage = "award";
       }
       if (fetchedData.contracts && fetchedData.contracts.length > 0 ) {
         newstage = "contract";
       }

       element.children('.badge').html(stage);
       if (newstage != stage) {
         element.children('.badge').text(newstage);
         element.children('.badge').removeClass('badge-dark');
         element.children('.badge').addClass('badge-success');
       }

       if (newnbre != nbre) {
         element.children('.tenderers').text(newnbre);
         element.children('.tenderers').addClass('text-success');
         element.children('.tenderers').text("# Tenderers: " + fetchedData.tender.numberOfTenderers);
       }



      })
      .done(function() {
          console.log("done");
      })
      .fail(function() {
          console.log("fail");
      })
      .always(function() {
          console.log("always");
      });
}

function load_trending(data) {
  el = document.getElementById("trending-tender-sample");

  for ( item in data ) {

   tender = data[item];
   tender_id =  data[item].tender.id

   var el_copy = el.cloneNode(true);
   el_copy.id = "trending-tender-id-" + tender_id;
   $(el_copy).removeClass("d-none");

   myUI = [
     {
       "name": "ocid",
       "ui_element": "div#trending-tender-id-" + tender_id +  " div.trending-tender-subtitle "
     },
     {
       "name": "tender.title",
       "ui_element": "div#trending-tender-id-" + tender_id +  " div.trending-tender-title",
        "ui_container": "div#trending-tender-id-" + tender_id +  " div.trending-tender-title-container"
     },
     {
       "name": "tender.status",
       "ui_element": "div#trending-tender-id-" + tender_id +  " div.trending-tender-status",
       "ui_container": "div#trending-tender-id-" + tender_id +  " div.trending-tender-status-container"
     },
     {
       "name": "tender.mainProcurementCategory",
       "ui_element": "div#trending-tender-id-" + tender_id +  " div.trending-tender-mainProcurementCategory",
       "ui_container": "div#trending-tender-id-" + tender_id +  " div.trending-tender-mainProcurementCategory-container"
     },
     {
       "name": "tender.numberOfTenderers",
       "ui_element": "div#trending-tender-id-" + tender_id +  " div.trending-tender-numberOfTenderers",
       "ui_container": "div#trending-tender-id-" + tender_id +  " div.trending-tender-numberOfTenderers-container"
     },
     {
       "name": "tender.value.amount",
       "ui_element": "div#trending-tender-id-" + tender_id +  " div.trending-tender-value-amount",
       "ui_container": "div#trending-tender-id-" + tender_id +  " div.trending-tender-amount-value-container"
     },
     {
       "name": "tender.tenderPeriod.endDate",
       "ui_element": "div#trending-tender-id-" + tender_id +  " div.trending-tender-tenderPeriod-endDate",
       "ui_container": "div#trending-tender-id-" + tender_id +  " div.trending-tender-tenderPeriod-endDate-container"
     }
   ];

   $("#trending-tender-container").append(el_copy);

   href = "contract?ocid=" + data[item].ocid;

   $("#trending-tender-id-" + tender_id).find('a').attr("href" , href );
   $("#trending-tender-id-" + tender_id).find('a').attr("target" , "_blank" );

   displayJsonInUI(myUI, tender);

   // clone

   // change id //


   // title = tender.title;
   // status = tender.status;
   // mainProcurementCategory = tender.mainProcurementCategory;
   // numberOfTenderers = tender.numberOfTenderers;
   // procurementMethod = tender.procurementMethod;
   // procuringEntity = tender.procuringEntity.name;
   // console.log(title);
  }



}
