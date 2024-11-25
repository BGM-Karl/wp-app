( function( $ ) {
    "use strict";
    $( window ).on( 'elementor/frontend/init', function() {
          var EF = elementorFrontend,
              EM = elementorModules;
  
          var ExtensionHandler = EM.frontend.handlers.Base.extend({
              onInit: function() {
                EM.frontend.handlers.Base.prototype.onInit.apply(this, arguments);
                this.initCursor();
              },
              getConfig: function(key) {
                return this.getElementSettings('tmp_' + key);
              },
              initCursor: function() {
                var dataid = this.getID(),
                custom_cursor = this.getConfig('custom_cursor') || 'disable',
                cursor_style = this.getConfig('cursor_style') || 'tm-pointer-simple',
                icon = 'disable',
                icon_class = this.getConfig('icon_class') || 'fas fa-mouse-pointer',
                image = 'disable',
                image_url = this.getConfig('cursor_image') || '',
                highlight_element = this.getConfig('highlight_element') || 'disable',
                highlight = this.getConfig('highlight') || '',
                click_anim = this.getConfig('click_anim') || 'none',
                hide_mode = this.getConfig('hide_mode') || 'disable',
                hide_timing = this.getConfig('hide_timing') || 3000,
                native = this.getConfig('native') || 'disable',
                cursor = this.getConfig('cursor') || 'enable',
                cursor_velocity = this.getConfig('cursor_velocity') || 1,
                node = this.getConfig('node') || 'enable',
                node_velocity = this.getConfig('node_velocity') || 0.1;
  
                this.$element.each(function () {
                    if (custom_cursor == 'enable') {
                        var wrapper = $('[data-id="' + dataid + '"]');
                        if( $('body').hasClass('elementor-editor-active') && !preview){
                            return;
                        }
                        if (cursor_style === 'tm-pointer-icon') {
                            icon = icon_class;
                        }
                        if (cursor_style === 'tm-pointer-img') {
                            image = image_url;
                        }
                        if (highlight_element === 'enable') {
                            highlight_element = highlight.split(',');
                            highlight_element = Array.from(highlight_element);
                        }
                        wrapper.tmpointer({
                            id: dataid,
                            icon: icon,
                            image: image,
                            click_anim: click_anim,
                            cursor: cursor,
                            cursor_class: 'tm-cursor ' + cursor_style,
                            node: node,
                            node_class: 'tm-node ' + cursor_style,
                            cursor_velocity: cursor_velocity,
                            node_velocity: node_velocity,
                            native_cursor: native,
                            hide_mode: hide_mode,
                            hide_timing: parseInt(hide_timing),
                            elements_to_hover: highlight_element
                        });
                    }
                });
              }
          });
          EF.hooks.addAction( 'frontend/element_ready/global', function( $scope ) {
              EF.elementsHandler.addHandler( ExtensionHandler, { $element: $scope });
          });
          });
  } )( jQuery );