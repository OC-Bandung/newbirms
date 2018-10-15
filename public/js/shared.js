function displayJsonInUI(myUIMap, data) {

  for (let item of myUIMap) {
        var path = item.name.split(".");
          for(let node of path) {
            if (data.hasOwnProperty(node)) {
              content = data[node];
              //format date.
              if(moment(content,  moment.ISO_8601, true).isValid()) content = moment(content).format('ll');
                $(item.ui_element).html(content);
                $(item.ui_container).removeClass("d-none");

             }
          }
      }
}


function genUniqueListCode() {
  return new Date().valueOf();
}

function getOCLocalStorage(){
  if(localStorage && localStorage.getItem('ocds-birms-watchlist')){
    return JSON.parse(localStorage.getItem('ocds-birms-watchlist'));
  }
}

function getListByListCode(data, param) {
    return data.filter(
        function(data) { return data.listCode == param }
    );
}

function getListByListName(data, param) {
    return data.filter(
        function(data) { return data.listName == param }
    );
}

function findOCID(data, param) {
     console.log(data);

}


function addListToLocalStorage(listCode, listName) {

  var myList =
      [{
        "listCode": listCode,
        "listName": listName,
        "listItems":[
        ]
      }];

  if(localStorage && localStorage.getItem('ocds-birms-watchlist')) {
     var watchList = JSON.parse(localStorage.getItem('ocds-birms-watchlist'));
     if (getListByListName(watchList, listName).length > 0) {
       $("div#watch-list-input-container div.alert").removeClass("d-none");
       return false;
     } else {
       watchList.push(myList[0]);
       localStorage.setItem("ocds-birms-watchlist" , JSON.stringify(watchList) );
       return true;
     }
  }


    if(localStorage && !localStorage.getItem('ocds-birms-watchlist')) {
      localStorage.setItem("ocds-birms-watchlist" , JSON.stringify(myList) );
      return true;
    }

}

function addItemsToListInLocalStorage(listCode, items) {
  let data = JSON.parse(localStorage.getItem('ocds-birms-watchlist'));
  let sel = getListByListCode(data, listCode)
  sel[0].listItems.push(items);
  console.log("---");
  console.log(items);
  console.log("---");
  localStorage.setItem("ocds-birms-watchlist" , JSON.stringify(data) );
}
