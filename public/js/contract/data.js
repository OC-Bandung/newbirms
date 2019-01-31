function getParameterByName(name, url) {
    if (!url) url = window.location.href;
    name = name.replace(/[\[\]]/g, '\\$&');
    var regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)'),
        results = regex.exec(url);
    if (!results) return null;
    if (!results[2]) return '';
    return decodeURIComponent(results[2].replace(/\+/g, ' '));
}

function getPartyByID(party, param) {
    return party.filter(
        function(party) { return party.id == param }
    );
}

function getContractByAwardID(contracts, param) {
    return contracts.filter(
        function(contracts) { return contracts.awardID == param }
    );
}

function findPartyByRole(party, role) {
  for (i = 0; i < party.length  ; i++) {
      for (j = 0; j < party[i].roles.length  ; j++) {
          if (party[i].roles[j] == role) {
            return (party[i]);
          }
      }
  }
}

// function load_parties(party) {
//
//     for (i = 0; i < party.length  ; i++) {
//         for (j = 0; j < party[i].roles.length  ; j++) {
//             if (party[i].roles[j] == "procuringEntity") {
//               $("#parties-name-procuringEntity").append(party[i].name);
//             }
//
//             if (party[i].roles[j] == "buyer") {
//               $("#parties-name-buyer").text(party[i].name);
//               $("#parties-address-buyer").text(party[i].address.streetAddress);
//             }
//
//         }
//     }
//
// }

function custom_sort(a, b) {
    return new Date(a.dueDate).getTime() - new Date(b.dueDate).getTime();
}


var url="https://birms.bandung.go.id/beta/api/newcontract/"+getParameterByName("ocid");
var callback_url=url+"?callback=?";

  $("a#oc-json").attr("href", url);


var jqxhr = $.getJSON(callback_url, function(data) {
        load_data(data);
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

function load_data(data) {

    var stage;
    var parties;

    planning = data.planning;
    tender = data.tender;
    awards = data.awards;
    contracts = data.contracts;


    // order is important
    if (data.hasOwnProperty('planning')) {
        stage = "planning";
        stageID = "Perencanaan";
        load_planning(data);
    }


    if (data.hasOwnProperty('tender') ) {
        stage = "tender";
        stageID = "Pemilihan";
        load_planning(data);
        load_tender(data);

        //buildTimeline(tender, stage);

    }

    if (data.hasOwnProperty('awards') && data.awards.length > 0 ) {
        stage = "award";
        stageID = "Pemenang";
        load_awards(data);

    }



    // load_parties(data.parties);

    $("#ocid").text(data.ocid);
    $("#stage").text(stageID);
    $("#ocdate").text(moment(data.date).format(("ll")));


}
