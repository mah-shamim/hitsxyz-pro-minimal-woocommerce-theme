/* global redux, wp, redux_custom_field_l10, ajaxurl */

(function ( $ ) {
  'use strict';

  var l10n;
  var reduxObject;
  var ajaxDone = false;

  redux.field_objects              = redux.field_objects || {};
  redux.field_objects.custom_field = redux.field_objects.custom_field || {};

  redux.field_objects.custom_field.init = function ( selector ) {
    //If no selector is passed, grab one from the HTML.
    if ( ! selector ) {
      selector = $( document ).find('#hitsxyz_theme_options-hits_custom_font_ttf');
    }

    redux.field_objects.custom_field.modInit(selector);
  };

  redux.field_objects.custom_field.modInit = function ( el ) {
    // Upload media button.
    el.find( '.media_add_font' ).off().on('click', function ( event ) {
      redux.field_objects.custom_field.add_font( el, event, $( this ).parents( 'fieldset.redux-field:first' ) );
    });

    // Remove the image button.
    el.find( '.remove-font' ).off('click' ).on('click', function () {
        redux.field_objects.custom_field.remove_font( el, $( this ).parents( 'fieldset.redux-field:first' ) );
    });

    el.find( '.fontDelete' ).on('click', function ( e ) {
        var data;
        e.preventDefault();
        el.find( '.spinner' ).show();
        data        = $( this ).data();
        data.action = 'redux_custom_field';
        data.nonce  = el.find( '.media_add_font' ).data('nonce');
        data.type   = 'delate';
        data.name   = el.find( '#namefont' ).val();

        $.post(ajaxurl, data, function ( response ) {
            response = JSON.parse( response );
            console.log(response);
            el.find( '.spinner' ).hide();
        });
        return false;
    });
  };

  redux.field_objects.custom_field.add_font = function ( el, event, selector ) {
    var frame;
    event.preventDefault();

    // If the media frame already exists, reopen it.
    if ( frame ) {
      frame.open();
      return;
    }

    // Create the media frame.
    frame = wp.media(
      {
        multiple: false,
        library: {type: ['application', 'font']},
        title: 'Custom Fonts',
        button: {
          text: 'Select Fonts'
        }
      }
    );

    // When an image is selected, run a callback.
    frame.on('select', async function () {
        var nonce;
        var data;
        var status;
        // Grab the selected attachment.
        var attachment = frame.state().get('selection').first();
        frame.close();
        if ( 'application' !== attachment.attributes.type && 'font' !== attachment.attributes.type ) {
          return;
        }

        nonce = $( selector ).find( '.media_add_font' ).data( 'nonce' );

        data = {
          action: 'redux_custom_field',
          nonce: nonce,
          attachment_id: attachment.id,
          title: attachment.attributes.title,
          mime: attachment.attributes.mime,
          filename: attachment.attributes.filename
        };
        el.find( '.spinner' ).show();
        await $.post(ajaxurl, data, function ( response ) {            
            response = JSON.parse( response );
            if ( 'success' === response.type ) {
              $(selector).find( '.upload' ).val(response.urlfont);
              window.onbeforeunload = '';
              $(selector).find( '#namefont' ).val(response.name);
            }
            el.find( '.spinner' ).hide();
            ajaxDone = true;
        });
        
      }
    );
    // Finally, open the modal.
    frame.open();
  };

  redux.field_objects.custom_field.remove_font = function ( el, selector ) {
    el = null;
    selector.find('.upload').val('');
    // This shouldn't have been run...
    if ( ! selector.find( '.remove-font' ).addClass( 'hide' ) ) {
      return;
    }
  };


})( jQuery );
