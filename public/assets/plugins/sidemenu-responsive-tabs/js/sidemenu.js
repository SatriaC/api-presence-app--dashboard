(function () {
	"use strict";

	var slideMenu = $('.side-menu');
	
	// Toggle Sidebar
	$(document).on("click", '#mainSidebarToggle', function(event) {
		event.preventDefault();
		$('body').toggleClass('main-sidebar-hide');
		$('body').removeClass('main-sidebar-hide2');
	});
	$(document).on("click", ".main-sidebar-hide .main-header-menu-icon", function(event) {
		event.preventDefault();
		$('body').toggleClass('main-sidebar-hide1');
	});
	$(document).on("click", ".main-sidebar-hide .resp-tab-item", function(event) {
		event.preventDefault();
		$('body').addClass('main-sidebar-hide2');
		$('body').removeClass('main-sidebar-hide1');
		$('body').removeClass('main-sidebar-hide');
	});
	
	//mobile  Toggle Sidebar
	if ( $(window).width() < 767) { 
		$(document).on("click", '#mainSidebarToggle', function(event) {
			event.preventDefault();
			$('body').toggleClass('sidenav-mobile');
		});
		
		$(document).on("click", ".sidenav-mobile .resp-tab-item", function(event) {
			event.preventDefault();
			$('body').toggleClass('main-sidebar-hide1');
			$('body').toggleClass('main-sidebar-hide');
		});
	}
	

	// Set initial active toggle
	$("[data-toggle='slide.'].is-expanded").parent().toggleClass('is-expanded');

	//Activate bootstrip tooltips
	$("[data-toggle='tooltip']").tooltip();
	
	
	
	const ps13 = new PerfectScrollbar('.first-sidemenu', {
		useBothWheelAxes:true,
		suppressScrollX:true,
	});
	const ps14 = new PerfectScrollbar('.second-sidemenu', {
		useBothWheelAxes:true,
		suppressScrollX:true,
	});
	
	
	// ______________sticky-header
	function updateScroll() {
		if ($(window).scrollTop() >= 30) {
			$(".main-header-fixed").addClass('fixed-header');
		} else {
			$(".main-header-fixed").removeClass("fixed-header");
		}
	}
	$(function() {
		$(window).scroll(updateScroll);
		updateScroll();
	});
	
	
})();