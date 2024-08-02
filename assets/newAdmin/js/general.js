/* Left Menu Toggle JS Start */
jQuery(document).ready(function () {
    $("#topnav-hamburger-icon").click(function () {
        $('.hamburger-icon').toggleClass("hide");
        $('.sidePanel').toggleClass("hide");
        $('.mainPanel').toggleClass("hide");

        if ($('.hamburger-icon').hasClass('hide')) {
            $('.hamburger-icon').closest('.mngmntHeader').addClass('side-menu-show');
        } else {
            $('.hamburger-icon').closest('.mngmntHeader').removeClass('side-menu-show');
        }
    });
  $(".main-menu-close").click(function () {
        $('.sidePanel').addClass("hide");
        $('.hamburger-icon').removeClass("hide");

        $('.hamburger-icon').closest('.mngmntHeader').removeClass('side-menu-show');
    });
});
/* Left Menu Toggle JS End */

/* Main Menu Item Click Active This Tab JS Start */ 
jQuery(function($) {
	var path = window.location.href;
	$('.dashboardLeftNav  li  a').each(function() {
	  if (this.href === path) {
		$(this).addClass('active');
	  }
	});
  });
  $(function($) {
    let url = window.location.href;
    $('.dashboardLeftNav  li  a').each(function() {
      if (this.href === url) {
        $(this).closest('.dashboardLeftNav .health').addClass('actve');
        $(this).closest('.dashboardLeftNav .submenu').addClass('show');
		
      }
    });
  });
  /* Main Menu Item Click Active This Tab JS Start */ 


