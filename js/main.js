/* jshint browser: true, devel: true, indent: 2, curly: true, eqeqeq: true, futurehostile: true, latedef: true, undef: true, unused: true */
/* global $, jQuery, document, Modernizr */

function l(data) {
  'use strict';
  console.log(data);
}

var 
	menuItemWidth;

jQuery(document).ready(function () {
  'use strict';
  l('Hola Globie');

$('svg').load(function() {
	$('.js-svg-container').each(function() {
		menuItemWidth = $(this).children('a').width();
		$(this).css( 'width' , menuItemWidth );
		console.log(menuItemWidth);
		$('.main-menu').css('visibility','visible');
	});
});
  
});