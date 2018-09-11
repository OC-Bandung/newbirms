var md = window.markdownit();

function load_the_file(filepath) {
  fetch(filepath) // Call the fetch function passing the url of the API as a parameter
  .then(response => response.text())
    .then(text => renderMD(text))
  .catch(function() {
    renderMD("### We had an error loading documentation, please come back later or contact us");
  });
}

function renderMD(text) {
  var result = md.render(text);
  document.getElementById("documentation-content").innerHTML = result;
}

$(document).ready(function() {
    load_the_file(  $('.list-group-item.active').attr("doc") );
});

$(".list-group-item").click(function(e) {
  e.preventDefault();
  $('.list-group-item.active').removeClass('active');
  $(this).addClass("active");
  load_the_file($(this).attr("doc") );
});
