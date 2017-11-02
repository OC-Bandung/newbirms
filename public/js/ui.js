// When we click on the LI
$("#load_recent-procurement li").click(function(e){
  e.preventDefault();

  // If this isn't already active
  if (!$(this).hasClass("active")) {
    // Remove the class from anything that is active
    $("li.active").removeClass("active");
    // And make this active
    $(this).addClass("active");
  }
});