$("#open-data-planning").click(function(e) {

	e.preventDefault();

	var json;
	 
	var jqxhr = $.getJSON("api/v1/recent/perencanaan.json", function(data) {
        json = data;
        var fields = Object.keys(json[0])
    	var replacer = function(key, value) { return value === null ? '' : value } 
		var csv = json.map(function(row){
		  return fields.map(function(fieldName){
		    return JSON.stringify(row[fieldName], replacer)
		  }).join(',')
		})
		csv.unshift(fields.join(',')) // add header column

		console.log(csv.join('\r\n'))

		  

		    });
				 


});
