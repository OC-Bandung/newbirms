function load_awards(data) {

awards = data.awards;
$("#award-section").removeClass('d-none');

$("#awards-count").text(awards.length );

// dynamically create UI.
// dynamically create the json array//
// display json in UI
 for (award in awards) {

   awards[award].id.toString().indexOf(".") != -1 ? element_id  = "awards-id-" + awards[award].id.split(".").join("") : element_id  = "awards-id-" + awards[award].id ;

   $(".awards-sample-container").clone().addClass('awards-actual').attr("id" , element_id ).removeClass('d-none').removeClass('awards-sample-container').appendTo("#awards-parent-container");

          var  myAwardsUI = [
             {
               "name": "id" ,
               "ui_element":  "div#" + element_id +  " .awards-id",
               "ui_container": "div#" + element_id + " .awards-id-container"
             },
             {
               "name": "status",
               "ui_element": "div#" + element_id + " .awards-status",
               "ui_container":"div#" + element_id +  " .awards-status-container"
             },
             {
               "name": "title",
               "ui_element": "div#" + element_id + " .awards-title",
               "ui_container": "div#" + element_id + " .awards-title-container"
             },
             {
               "name": "date",
               "ui_element": "div#" + element_id + " .awards-date",
               "ui_container": "div#" + element_id + " .awards-date-container"
             },
             {
               "name": "value.amount",
               "ui_element": "div#" + element_id + " .awards-value-amount",
               "ui_container": "div#" + element_id + " .awards-value-amount-container"
             }
           ];

         awardParent = "div#" + element_id + " div.awards-suppliers-parent-container";

         displayJsonInUI(myAwardsUI, awards[award]);
        
         console.log(numberWithCommas(awards[award].value.amount));

         //if ( awards[award].value &&  awards[award].value.amount) {
          $("div#" + element_id + "#awards-value-amount").text(numberWithCommas(awards[award].value.amount));
          //$("div#" + element_id + "#awards-value-amount-container").removeClass("d-none");
        //}

         var suppliers =  awards[award].suppliers;

         var eln = document.getElementById("awards-suppliers-sample-container");
         var eln_copy =eln.cloneNode(true);

         for ( supplier in suppliers) {

           suppliers[supplier].id ?  supplier_id =  suppliers[supplier].id.split(".").join("").split("-").join("") :  supplier_id =  "supplier-fake-" + Math.floor(Math.random() * 100);


           var mySupplierUI = [
             {
               "name": "id" ,
               "ui_element":  awardParent + " div#awarded-supplier-" + supplier_id + " .awards-suppliers-id" ,
               "ui_container": awardParent + " div#awarded-supplier-" + supplier_id + " div.awards-suppliers-id-container"
             },
             {
               "name": "name",
               "ui_element":  awardParent + " div#awarded-supplier-" + supplier_id + " .awards-suppliers-name" ,
               "ui_container": awardParent + " div#awarded-supplier-" + supplier_id + " div.awards-suppliers-name-container"
             }
           ];

           eln_copy.id = "awarded-supplier-" + supplier_id;

           $(awardParent).html(eln_copy);

           displayJsonInUI(mySupplierUI, suppliers[supplier]);

         }
         // end supplier loop

         load_contracts(data, awards[award], awards[award].id);


    }
    // end each award


}
