function load_contracts(data , award, awardID) {

 awardID.toString().indexOf(".") != -1 ?  awardParent = "#awards-id-" + awardID.split(".").join("") :  awardParent = "#awards-id-" + awardID;


 var cn = document.getElementById("awards-contracts-sample-container");
 var cn_copy = cn.cloneNode(true);



   if ( data.contracts ) {

     var thisAwardsContracts = getContractByAwardID( data.contracts, awardID);


   for ( myContract in thisAwardsContracts ) {

      contract_id =  thisAwardsContracts[myContract].id;

       var myContractUI = [
         {
           "name": "value.amount" ,
           "ui_element":  "div#contract-" + contract_id + " div.contracts-value-amount" ,
           "ui_container": "div#contract-" + contract_id +  " div.contracts-value-amount-container"
         },
         {
           "name": "period.startDate",
           "ui_element": "div#contract-" + contract_id +  " div.contracts-period-startDate" ,
           "ui_container":"div#contract-" + contract_id +  " div.contracts-period-startDate-container"
         },
         {
           "name": "period.endDate",
           "ui_element": "div#contract-" + contract_id +  " div.contracts-period-endDate" ,
           "ui_container":"div#contract-" + contract_id +  " div.contracts-period-endDate-container"
         },
         {
           "name": "period.endDate",
           "ui_element": "div#contract-" + contract_id +  " div.contracts-period-endDate" ,
           "ui_container": "div#contract-" + contract_id +  " div.contracts-period-endDate-container"
         },
         {
           "name": "status",
           "ui_element": "div#contract-" + contract_id +  " div.contracts-status" ,
           "ui_container":"div#contract-" + contract_id +  " div.contracts-status-container"
         },
         {
           "name": "dateSigned",
           "ui_element": "div#contract-" + contract_id +  " div.contracts-dateSigned" ,
           "ui_container": "div#contract-" + contract_id +  " div.contracts-dateSigned-container"
         }
       ];


      cn_copy.id = "contract-" + contract_id;
      $(awardParent).append(cn_copy);

      displayJsonInUI(myContractUI, thisAwardsContracts[myContract]);

      var items = thisAwardsContracts[myContract].items;
      var itemsParent = "div#contract-" + contract_id + " div.contract-items-container";

      for (myItem in items) {

        item_html= '<hr> <div class="row mt-2 ">';
          item_html += '<div class="col-12 ">';
            item_html +='<div class="badge badge-secondary h6">Item</div>';
            item_html +=  '<div class=" h5"> ' + items[myItem].description + '</div>';
          item_html +='</div>';
          item_html +='<div class="col ">';
          item_html   +='<div class="h6">Quantity</div>';
          item_html   +=  '<div class=" h5">' + items[myItem].quantity + '</div>';
          item_html +='</div>';
          item_html +='<div class="col ">';
            item_html +='<div class="h6">Unit</div>';
            item_html +='<div class=" h5">' + items[myItem].unit.unit + '</div>';
          item_html +='</div>';
        item_html +='</div>';


        $(itemsParent).append(item_html);

      }
    }
  }
}
