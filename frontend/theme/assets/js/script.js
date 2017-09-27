function truncate(str, maxlength) {
	if (str.length > maxlength) {
		return str.slice(0, maxlength - 3) + '...';
		
	}
	
	return str;
}
$(document).ready(function(){
    $('.news-body').owlCarousel({
        items: 4,
        margin: 10,
		loop:true,
        nav: false,
        dots: true
    });
    $('.notifications-slider').owlCarousel({
        items: 1,
        margin: 10,
        loop:true,
        nav: false,
        dots: true
    });
});
