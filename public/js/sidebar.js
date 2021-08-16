jQuery(document).ready(function() {
	$('.dismiss').on('click', function() {
        $('.sidebar').removeClass('active');
    });

    $('.open-menu').on('click', function(e) {
    	e.preventDefault();
        $('.sidebar').addClass('active');
        // close opened sub-menus
        $('.collapse.show').toggleClass('show');
        $('a[aria-expanded=true]').attr('aria-expanded', 'false');
    });
	/* replace the default browser scrollbar in the sidebar, in case the sidebar menu has a height that is bigger than the viewport */
	$('.sidebar').mCustomScrollbar({
		theme: "minimal-dark"
	});
});
