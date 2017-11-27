$(document).ready(function(){
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
