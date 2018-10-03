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

$("#show-search-filters").click(function() {
    $("#search-filters").removeClass("d-none");
    $(this).hide();
});
	
$(window).on('scroll', function() {
  var $anchor = $("#bdg-secondary-nav");
  var st = $(window).scrollTop();
 var ot = $anchor.offset().top;
  if (st > ot ) {
     $("#bdg-secondary-nav").css( {
       position: "fixed",
       "z-index": 2,
       top: 0
     });
   }
    if (st == 0) {
     $("#bdg-secondary-nav").css( {
       position: "relative",
       "z-index": 2,
       top: ""
     });
   }
   console.log("st: " + st);
   console.log("ot: " + ot);
});