$(function () {
  $('[data-toggle="tooltip"]').tooltip()
})

$("#bdg-feedback-form").click(function() {
  var lnk = "https://docs.google.com/forms/d/e/1FAIpQLScs-1715tHTn60Ncj85_1zW7TQg8vzTWjwajCJCEdBGEmSfJw/viewform?usp=pp_url";
  var lnk = "https://docs.google.com/forms/d/e/1FAIpQLSetaf51Okqj1_k-aN8wQhxNlGyk0LeQgCKP1Mv-2D5M08XHvQ/viewform?usp=pp_url";
  
  lnk += "&entry.1257443447=" + $("#ocid").text();
  lnk += "&entry.1070094881=" +   $("#page-title").text() ;
  $(this).attr("href", lnk);
});

$(document).on('click', '[id^="watch-list-"]', function(e) {
  e.preventDefault();
  ocid = $("#ocid").text();
  if (! $(this).hasClass('added')) {
  var clickedList = $(this).attr("id");
   if(localStorage && localStorage.getItem('ocds-birms-watchlist')){
     var watchList = JSON.parse(localStorage.getItem('ocds-birms-watchlist'));
     watchListSel =  getListByListCode(watchList, clickedList)[0]["listCode"];
     newdata = [
       { "ocid": ocid ,
         "stage": $("#stage").text(),
         "numberOfTenderers": $("#tender-numberOfTenderers").text(),
         "title": $("#page-title").text()
       }
     ];
     addItemsToListInLocalStorage(watchListSel, newdata[0] );
     $(this).addClass('added');
     $(this).html('<i class="material-icons small pr-2">check</i>' + $(this).text());
     //var myList = getListByListCode(watchList, clickedList);
   }
    // if(localStorage && localStorage.getItem('ocds-birms-watchlist')){
    //     var watchList = JSON.parse(localStorage.getItem('ocds-birms-watchlist'));
    //     var myList = getListByListCode(watchList, clickedList);
    //     listItems = watchList[0]["listItems"];
    //     newdata = [{ "ocid": ocid}];
    //     listItems.push(newdata[0]);
    //     myList.push(listItems[0]);
    //     // console.log(myList);
    //     localStorage.setItem("ocds-birms-watchlist" , JSON.stringify(watchList) );
    //     $(this).html('<i class="material-icons small pr-2">check</i>' + $(this).text());
    //
    // }
  }
});



$("#add-to-watchlist").click(function(e) {
    e.preventDefault();
    $("#notificationList").toggleClass("d-none");
});

$("#addNewList-submit").click(function(event) {
    myListCode = "watch-list-" + genUniqueListCode();
    myListName = $("input#watch-list-name").val();
    if (addListToLocalStorage(myListCode, myListName) == true ) {
      $('#addNewList').modal('hide');
      var eln = document.getElementById("list-group-item-sample").cloneNode(true);
      eln.id =  myListCode;
      $("ul#notificationList").prepend(eln);
      $("ul#notificationList li#" + myListCode ).text(  myListName );

    }


});

$("#addNewList").click(function() {
  $("#watch-list-name").val('');
});

// $(document).ready(function() {
//   load_list();
// });

$( window ).on( "load", function() {
  load_list();

 })

function load_list() {
  let myList = getOCLocalStorage();
  if(myList) {
    for ( item in myList) {
      var eln = document.getElementById("list-group-item-sample").cloneNode(true);
      eln.id =  myList[item].listCode;
      $("ul#notificationList").prepend(eln);

      ocid = $("#ocid").text();
        $("ul#notificationList li#" + myList[item].listCode ).text( myList[item].listName);
      // check if ocid already in list
      for (j in  myList[item].listItems ) {
        if (myList[item].listItems[j].ocid == ocid) {
          $("ul#notificationList li#" + myList[item].listCode ).html( '<i class="material-icons small pr-2">check</i>' +  myList[item].listName);
          $("ul#notificationList li#" + myList[item].listCode ).addClass("added");
      }
}
     }
  }
}
