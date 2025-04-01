/* 	
 * Sticky Plugin v1.0.0 for jQuery
 * Author: Anthony Garand
 * Website: http://labs.anthonygarand.com/sticky
 */
(function($) {
  var defaults = {
      topSpacing: $('#wpadminbar').length ? $('#wpadminbar').height() : 0,
      bottomSpacing: 0,
	  topBegin: 0,
      className: 'is-sticky',
      wrapperClassName: 'sticky-wrapper',
      center: false,
      getWidthFrom: '',
	  scrollOnTop: function(){},
	  scrollOnBottom: function(){}
    },
    $window = $(window),
    $document = $(document),
    sticked = [],
    windowHeight = $window.height(),
    scroller = function() {
      var scrollTop = $window.scrollTop(),
        documentHeight = $document.height(),
        dwh = documentHeight - windowHeight,
        extra = (scrollTop > dwh) ? dwh - scrollTop : 0;

      for (var i = 0; i < sticked.length; i++) {
        var s = sticked[i],
          elementTop = s.stickyWrapper.offset().top,
          etse = elementTop - s.topSpacing - extra;
        if (scrollTop <= etse + s.topBegin) {
          if (s.currentTop !== null) {
			s.stickyElement.parent().removeClass(s.className);
			s.stickyElement
			.css('position', '')
			.css('top', '');
			s.scrollOnTop.call(this);
            s.currentTop = null;
			setTimeout(resizer, 100);
          }
        }
        else {
          var newTop = documentHeight - s.stickyElement.outerHeight()
            - s.topSpacing - s.bottomSpacing - scrollTop - extra;
          if (newTop < 0) {
            newTop = newTop + s.topSpacing;
          } else {
            newTop = s.topSpacing;
          }
          if (s.currentTop != newTop) {
            s.stickyElement
              .css('position', 'fixed')
              .css('top', newTop);

            if (typeof s.getWidthFrom !== 'undefined') {
              s.stickyElement.css('width', $(s.getWidthFrom).width());
            }

            s.stickyElement.parent().addClass(s.className);
			s.scrollOnBottom.call(this);
            s.currentTop = newTop;
          }
        }
      }
    },
    resizer = function() {
		windowHeight = $window.height();
	  
		for( var i = 0; i < sticked.length; i++ ){
			sticked[i].stickyWrapper.css('height', sticked[i].stickyElement.outerHeight());
			sticked[i].topSpacing = $('#wpadminbar').length ? $('#wpadminbar').height() : 0;
		}
    },
    methods = {
      init: function(options) {
        var o = $.extend(defaults, options);
        return this.each(function() {
          var stickyElement = $(this);

          var stickyId = stickyElement.attr('id');
          var wrapper = $('<div></div>')
            .attr('id', stickyId + '-sticky-wrapper')
            .addClass(o.wrapperClassName);
          stickyElement.wrapAll(wrapper);

          if (o.center) {
            stickyElement.parent().css({width:stickyElement.outerWidth(),marginLeft:"auto",marginRight:"auto"});
          }

          if (stickyElement.css("float") == "right") {
            stickyElement.css({"float":"none"}).parent().css({"float":"right"});
          }

          var stickyWrapper = stickyElement.parent();
          stickyWrapper.css('height', stickyElement.outerHeight());
          sticked.push({
            topSpacing: o.topSpacing,
            bottomSpacing: o.bottomSpacing,
			topBegin: o.topBegin,
            stickyElement: stickyElement,
            currentTop: null,
            stickyWrapper: stickyWrapper,
            className: o.className,
            getWidthFrom: o.getWidthFrom,
			scrollOnTop: o.scrollOnTop,
			scrollOnBottom: o.scrollOnBottom
          });
        });
      },
      update: scroller
    };

  if (window.addEventListener) {
    window.addEventListener('scroll', scroller, false);
    window.addEventListener('resize', resizer, false);
  } else if (window.attachEvent) {
    window.attachEvent('onscroll', scroller);
    window.attachEvent('onresize', resizer);
  }

  $.fn.mysticky = function(method) {
    if (methods[method]) {
      return methods[method].apply(this, Array.prototype.slice.call(arguments, 1));
    } else if (typeof method === 'object' || !method ) {
      return methods.init.apply( this, arguments );
    } else {
      $.error('Method ' + method + ' does not exist on jQuery.sticky');
    }
  };
  $(function() {
    setTimeout(scroller, 400);
  });
})(jQuery);