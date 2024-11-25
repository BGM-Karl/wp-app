( function( $ ) {
	"use strict";

	var count = 2;
	var total = ajax_blog_infinite_scroll_data.max_num;

	//console.log('totalNumber: ' + total);
	var flag = 1;

	$(window).on('scroll', function(){
	    if ( $(window).scrollTop() + $(window).height() >= $('.js-blog').offset().top + $('.js-blog').height() ) {
	        if ( count > total ) {
	            return false;
	        } else {
	        	if( flag == 1 ){
	        		//console.log('pageNumber: ' + count);
	            	loadContent(count);
	            }
	        }
	        if( flag == 1 ){
	        	flag = 0;
	        	count++;
	        }
	    }
	});

	function loadContent(pageNumber) {
	    $.ajax({
	        url: ajax_blog_infinite_scroll_data.url,
	        type:'POST',
	        data: "action=infinite_scroll_el&page_no="+ pageNumber + '&post_type=post' + '&page_id=' + ajax_blog_infinite_scroll_data.page_id + '&order_by=' + ajax_blog_infinite_scroll_data.order_by + '&order=' + ajax_blog_infinite_scroll_data.order + '&per_page=' + ajax_blog_infinite_scroll_data.per_page + '&source=' + ajax_blog_infinite_scroll_data.source + '&cat_ids=' + ajax_blog_infinite_scroll_data.cat_ids + '&items_per_row=' + ajax_blog_infinite_scroll_data.items_per_row + '&masonry=' + ajax_blog_infinite_scroll_data.masonry + '&sidebar=' + ajax_blog_infinite_scroll_data.siderbar,
	        success: function(html){
            var $html = $(html);
            var $container = $('.js-blog');

            $html.imagesLoaded(function(){
							$container.append($html);
							$container.isotope('appended', $html );
							$container.isotope('layout');
						});

            flag = 1;
	        }
	    });
	    return false;
	}
} )( jQuery );
