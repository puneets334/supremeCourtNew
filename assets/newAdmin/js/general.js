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
// Theme JS Start

function setTheme(theme) {
  sessionStorage.setItem('theme', theme);
}

function getTheme() {
  return sessionStorage.getItem('theme');
}

  function applyStoredTheme() {
      var storedTheme = getTheme();
      if (storedTheme === 'blue') {
          jQuery('body').addClass('blue-theme');
      } else if (storedTheme === 'black') {
          jQuery('body').addClass('black-theme');
      }
  }

// Apply stored theme when the DOM is ready
  jQuery(document).ready(function() {
      applyStoredTheme();
  });

// Event handler for the blue theme
  jQuery('.whitebg').on('click', function() {
      jQuery('body').addClass('blue-theme');
      jQuery('body').removeClass('black-theme');
      setTheme('blue');
  });

// Event handler for the black theme
  jQuery('.blackbg').on('click', function() {
      jQuery('body').addClass('black-theme');
      jQuery('body').removeClass('blue-theme');
      setTheme('black');
  });
// Theme JS End

