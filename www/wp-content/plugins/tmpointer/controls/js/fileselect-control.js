var fileselectItemView = elementor.modules.controls.BaseData.extend({
	
    onReady: function () {
		"use strict";
    	var file_input_id = this.$el.find( '.tmp-selected-fle-url' ).attr('id');

    	this.$el.find( '.tmp-select-file' ).on('click', function() {
	   	  	var tmp_file_uploader = wp.media({
	            title: 'Upload File',
	            button: {
	                text: 'Get Link'
	            },
	            multiple: false
	        })
	        .on('select', function() {
	            var attachment = tmp_file_uploader.state().get('selection').first().toJSON();
	            jQuery( '#' + file_input_id ).val( attachment.url );
	            jQuery( '#' + file_input_id ).trigger( 'input' );
	        })
	        .open();
	   	} );
	},
});

elementor.addControlView('tmp-file-select', fileselectItemView);