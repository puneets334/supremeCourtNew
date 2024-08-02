$(function () {
    new WOW().init();
});


/* Main Menu Item Click Active This Tab JS Start */ 
jQuery(function($) {
  var path = window.location.href;
  $('.custom-nav li a').each(function() {
	if (this.href === path) {
	  $(this).addClass('active');
	}
  });
});
/* Main Menu Item Click Active This Tab JS Start */ 
