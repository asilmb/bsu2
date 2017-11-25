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
	ymaps.ready(init);
	var myMap,
		myPlacemark;

	function init(){
		myMap = new ymaps.Map("map", {
			center: [46.840128, 74.977176],
			zoom: 16
		});

		myPlacemark = new ymaps.Placemark([46.840128, 74.977176], {
			hintContent: 'Москва!',
			balloonContent: 'Столица России'
		});

		myMap.geoObjects.add(myPlacemark);
	}
});
