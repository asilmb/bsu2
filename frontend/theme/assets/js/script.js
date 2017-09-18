function truncate(str, maxlength) {
	if (str.length > maxlength) {
		return str.slice(0, maxlength - 3) + '...';
		
	}
	
	return str;
}
var options = {
	horizontal: 1,
	itemNav: 'basic',
	speed: 500,
	mouseDragging: 1,
	touchDragging: 1
};
$('.news-body').sly(options);