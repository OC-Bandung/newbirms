function getParameterByName(name, url) {
    if (!url) url = window.location.href;
    name = name.replace(/[\[\]]/g, '\\$&');
    var regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)'),
        results = regex.exec(url);
    if (!results) return null;
    if (!results[2]) return '';
    return decodeURIComponent(results[2].replace(/\+/g, ' '));
}


var url="https://birms.bandung.go.id/beta/api/newcontract/"+getParameterByName("ocid");
var callback_url=url+"?callback=?";

  $("a#oc-json").attr("href", url);


var jqxhr = $.getJSON(callback_url, function(data) {
      scan(data.planning);
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


    var scan = (function(){
      var stack = [];
      var result = [];
      // var bail = false;
      return function map(data, key){
        if (!$.isArray(data) && !$.isPlainObject(data) ) {
          result.push(key + ":" + data);
          console.log(key + ":" + data);
          return false
        }

        $.each(data, function(i, v){
          if (key) stack.push(key);
          map(v, i);
          stack.pop();
        });
        return result;
      };
    })();
