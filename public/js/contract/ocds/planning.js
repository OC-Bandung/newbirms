const numberWithCommas = (x) => {
    var parts = x.toString().split(".");
    parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    return parts.join(".");
  }

function load_planning(data) {
    

    planning = data.planning;

    // if there is a buyer id in data.buyer, then go to parties and lookup the information to show
    // sometimes data.id doesn't exist but the role of buyer is still there, so in the else statement, try to loop and see if there is a buyer.


    if (data.buyer.name) {
      $("#parties-buyer-name").text(data.buyer.name);
      $("#parties-buyer-name-container").removeClass("d-none");
    }

    if ( data.buyer.id ) {
      $("#parties-buyer-address").text(getPartyByID(data.parties, data.buyer.id)[0].address.streetAddress);
    } else {
        buyer = findPartyByRole(data.parties, "buyer");
        if (found.address) {
            $("#parties-buyer-address").text(buyer.address.streetAddress);
        }
    }

    procuringEntity = findPartyByRole(data.parties, "procuringEntity");
    if (procuringEntity) {
        if (procuringEntity.name) {
          if (procuringEntity.name != data.buyer.name) {
            $("#parties-proc-name").text(procuringEntity.name);
            $("#parties-proc-name-container").removeClass("d-none");
              if (procuringEntity.address.streetAddress) {
                $("#parties-proc-address").text(procuringEntity.address.streetAddress);
                $("#parties-proc-address").removeClass("d-none");

              }
          }
        }

    }


    if (planning.hasOwnProperty('budget')) {
        $("#page-title").text(planning.budget.project);

        $("#planning-budget-project-name").text(planning.budget.project);

        $("#planning-budget-amount-amount").text(numberWithCommas(planning.budget.amount.amount));

        $("#planning-budget-id-container").removeClass("d-none");
        $("#planning-budget-id").text(planning.budget.id);

        $("#planning-budget-description").text(planning.budget.description);

        $("#planning-budget-project-name-container").hide();
    }

}
