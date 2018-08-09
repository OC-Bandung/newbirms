function load_parties(parties) {
	
	 var party = [];

    for (i = 0; i < parties.length; i++) {
        party[parties[i].roles] = parties[i].name
    }


    $("#parties-name-procuringEntity").text(party["procuringEntity"]);
    $("#parties-name-implementationUnit").text(party["implementationUnit"]);



}