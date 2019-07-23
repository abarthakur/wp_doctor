$(document).ready(function($){
    var $root = $('html, body');
	var parent_link=window.location.origin + window.location.pathname;
	if (parent_link[parent_link.length-1]=="/"){
		parent_link=parent_link.substring(0,parent_link.length-1);
	}
    $('.post-container a[href^="'+parent_link+'#"]').click(function() {
        var href_parts = $.attr(this, 'href').split("#");
		var moveTo="#"+href_parts[href_parts.length-1];
        $root.animate({
            scrollTop: $(moveTo).offset().top
        }, 500, function () {
            window.location.hash = moveTo;
        });
        return false;
    });
});