/* jshint browser: true, devel: true, indent: 2, curly: true, eqeqeq: true, futurehostile: true, latedef: true, undef: true, unused: true */
/* global $, jQuery, document, Modernizr */

function l(data) {
  'use strict';
  console.log(data);
}

var menuItemWidth;

jQuery(document).ready(function () {
  'use strict';
  l('Hola Globie');

	$('.expand input').on({
		focusin: function(){
			$(this).siblings('svg').find('.zigzag').attr('class', 'zigzag small-stroke');
		},
		focusout: function() {
			$(this).siblings('svg').find('.zigzag').attr('class', 'zigzag');
		}
	});

	function sizeUnderlines() {
		$('.js-svg-container').each(function() {
			menuItemWidth = $(this).children('a').width();
			$(this).css( 'width' , menuItemWidth );
		});
		$('.main-menu').css('visibility','visible');
	}

	sizeUnderlines();

	$('.menu-item svg').load(function() {
		sizeUnderlines();
	});

	$('.menu-item-archive').on({
		mouseenter: function() {
			$(this).siblings('svg').attr('class', 'underline flip');
		},
		mouseleave: function() {
			$(this).siblings('svg').attr('class', 'underline');
		}
	});

	$(window).on('resize', function() {
		sizeUnderlines();
	});
  
});