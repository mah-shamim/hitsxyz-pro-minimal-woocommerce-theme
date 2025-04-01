var hits_loading_screen = {
	overlay: null
	,images: []
	,image_counter: 0
	,loaded_image_counter: 0
	,destroyed: false
	,create: function(){
		this.overlay = jQuery('<div class="hitslg-screen"></div>').css({
			width: '100%'
			,height: '100%'
			,backgroundColor: '#ffffff'
			,position: 'fixed'
			,zIndex: 9999999
			,top: 0
			,left: 0
		}).appendTo('html');
		
		var image_wrapper = jQuery('<span style="max-width: 120px; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); display: inline-block;"></span>');
		var image = jQuery('<img src="' + hits_loading_screen_opt.loading_image + '"  style="max-width: 120px;" />');
		image_wrapper.append(image).appendTo( this.overlay );
	}
	,get_images: function(){
		this.images = jQuery('body').find('img');
		if( this.images.length ){
			this.load_image_event();
		}
	}
	,load_image_event: function(){
		var win_height = jQuery(window).height();
		for( var i = 0, l = this.images.length; i < l; i++ ){
			if( !this.image_loaded(this.images[i]) ){
				var img = jQuery(this.images[i]);
				if( img.offset().top < win_height ){
					this.image_counter++;
					img.on('load', function(){
						hits_loading_screen.complete_loading_images();
					});
				}
			}
		}
	}
	,image_loaded: function( img ){
		return img.complete && img.naturalHeight !== 0;
	}
	,complete_loading_images: function(){
		this.loaded_image_counter++;
		if( this.image_counter <= this.loaded_image_counter ){
			this.destroy();
		}
	}
	,destroy: function(){
		if( !this.destroyed ){
			this.overlay.fadeOut(200, function(){
				hits_loading_screen.overlay.remove();
			});
			this.destroyed = true;
		}
	}
};

hits_loading_screen.create();

jQuery(function(){
	hits_loading_screen.get_images();
});

jQuery(window).on('load', function(){
	hits_loading_screen.destroy();
});