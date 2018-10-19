/**
 * Namespace for Shock Doctor
 *
 * @type {Object}
 */

var ShockDoctor = {};
/**
 * Validators
 *
 * @type {Object}
 */
ShockDoctor.Validate = {};

/**
 * validator for dates
 * @type {*}
 */
ShockDoctor.Validate.Date = Class.create();
ShockDoctor.Validate.Date.prototype = Object.extend(new Varien.DateElement(), {
    validate: function() {
        var errors = new Array();
        var rawDay = this.day.value.replace(/^0*/, '');
        var rawMonth = this.month.value.replace(/^0*/, '');
        var rawYear = this.year.value;
        var day = parseInt(rawDay) || 0;
        var month = parseInt(rawMonth) || 0;
        var year = parseInt(rawYear) || 0;

        if (!day && !month && !year) {
            if (this.required) {
                errors.push('This date is a required value.');
            } else {
                this.full.value = '';
            }
        } else {
            var date = new Date, countDaysInMonth ;
            date.setYear(year);
            date.setMonth(month-1);
            date.setDate(32);
            countDaysInMonth = 32 - date.getDate();
            if (!countDaysInMonth || countDaysInMonth > 31) {
                countDaysInMonth = 31;
            }

            var checkFullDate = true;
            if (rawDay != day || (day && (day < 1 || day > countDaysInMonth))) {
                errors.push('Please enter a valid day (1-%d).'.replace('%d', countDaysInMonth));
                checkFullDate = false;
            }
            if ((rawMonth != month) || (month && (month < 1 || month > 12))) {
                errors.push('Please enter a valid month (1-12).');
                checkFullDate = false;
            }
            var maxYear = (new Date).getFullYear() - 13;
            if (rawYear != year || (year && !(year >= 1900 && year <= maxYear))) {
                errors.push(this.validateDataErrorText.replace('%d', maxYear));
                checkFullDate = false;
            }
            if (checkFullDate) {
                this.full.value = this.format.replace(/%[mb]/i, this.month.value).replace(/%[de]/i, this.day.value).replace(/%y/i, this.year.value);
                //var testFull = this.month.value + '/' + this.day.value + '/'+ this.year.value;
                //var test = new Date(testFull);
                //if (isNaN(test)) {
            }
        }

        if (errors.length) {
            try {
                for (var i = 0; i < errors.length; i ++) {
                    errors[i] = Translator.translate(errors[i]);
                }
            } catch (e) {
            }

            this.advice.innerHTML = errors.join('<br />');
            this.advice.show();
            return false;
        }

        // fixing elements class
        this.day.removeClassName('validation-failed');
        this.month.removeClassName('validation-failed');
        this.year.removeClassName('validation-failed');

        this.advice.hide();
        return true;
    }
});

jQuery.noConflict();

jQuery(function() {
    menu();
    slider( 'feature-slider', 'feature-slider-slide', 8000, true );
    slider( 'featured-products', 'featured-products-group', false, true, featured_products_shop_all_link );
    featured_products_nav_width();
    slider( 'product-slider', 'product-slider-slide', 8000, true );
    slider( 'parts', 'parts-slide', false, true );
    slider( 'top-products', 'top-products-group' );
    slider( 'athlete-photos', 'athlete-photo', false, true );
    product_media();
    product_color_swatches();
    product_color_switcher();
    filter_color_swatches();
    twitter_popup();
    youtube_overlay();
});

function menu() {
    jQuery('li.level-top').click(function(){
        jQuery('.level-top').not(this).removeClass('open');
        jQuery(this).toggleClass('open');
    });
    jQuery(window).scroll(function(){
        jQuery('.level-top').removeClass('open');
    });
    jQuery('body').on('click',function(event){
        if (jQuery(event.target).closest('.level-top').length == 0) {
            jQuery('.level-top').removeClass('open');
        }
    });
}

// Navigation and animaiton of cross-fading or sliding slideshows.
function slider( container_class, slide_class, interval_length, cross_fade, show_slide_callback ) {
    jQuery( '.' + container_class ).each(function() {
        var container = this;
        var min_height = 0;
        var min_height_container;
        jQuery( this ).find( '.' + slide_class ).each(function() {
            var height = jQuery( this ).outerHeight();
            if ( height > min_height ) min_height = height;
            if ( !min_height_container ) min_height_container = jQuery( this ).parent();
            this.container = container;
            jQuery( this ).parents( '.' + container_class ).find( '.slider-nav-previous' ).append( jQuery( '<span/>' ).append( jQuery( '<a/>', { href: '#' + this.id } ).html( 'Previous' ) ) );
            jQuery( this ).parents( '.' + container_class ).find( '.slider-nav-next' ).append( jQuery( '<span/>' ).append( jQuery( '<a/>', { href: '#' + this.id } ).html( 'Next' ) ) );
            // When a nav link is clicked, show its slide.
            jQuery( '[href$="#' + this.id + '"]' ).each(function() {
                jQuery( this ).click(function(event) {
                    var id = this.href.split('#')[1];
                    jQuery( '#' + id )[0].show_slide();
                    event.preventDefault();
                }); 
            });
            // Attach the callback function, if present.
            if ( show_slide_callback ) this.callback = show_slide_callback;
            // Shows this slide and hides its siblings.
            this.show_slide = function( speed ) {
                // Cross fade or slide the slides.
                speed = ( speed != undefined ) ? speed : 'medium';
                if ( cross_fade ) {
                    jQuery( '.' + slide_class + ':not("#' + this.id + '")' ).fadeOut( speed );
                    jQuery( this ).fadeIn( speed );
                }
                else {
                    var move_left = 0;
                    jQuery( this ).prevAll().each(function() {
                        move_left += jQuery( this ).innerWidth();
                    })
                    jQuery( this ).parent().animate(
                        { 'margin-left': -move_left },
                        speed
                    );
                }
                // Highlight the nav links to this slide.
                jQuery( this.container ).find( '.nav-current' ).removeClass( 'nav-current' );
                jQuery( '[href$="#' + this.id + '"]' ).parent().addClass( 'nav-current' );
                if ( this.callback ) this.callback( this );
                // Show links to the previous or next slides.
                jQuery( this.container ).find( '.slider-nav-previous a, .slider-nav-next a' ).css( 'display', 'none' );
                jQuery( '.slider-nav-previous' ).find( '[href$="#' + jQuery( this ).prev().attr( 'id' ) + '"]' ).css( 'display', 'block' );
                jQuery( '.slider-nav-next' ).find( '[href$="#' + jQuery( this ).next().attr( 'id' ) + '"]' ).css( 'display', 'block' );
            }
        });
        // Set the min-height of the container to the height of the tallest slide.
        jQuery( min_height_container ).css( 'min-height', min_height + 'px' );
        // Show the first slide by default.
        var first_slide = jQuery( this ).find( '.' + slide_class )[0];
        if ( first_slide ) first_slide.show_slide( 0 );
        // Shows the next slide in this slider.
        this.next_slide = function() {
            var current_slide = jQuery( this ).find( '.' + slide_class + ':visible' )[0];
            var next_slide = jQuery( current_slide ).next()[0];
            if ( jQuery( current_slide ).is( ':last-child' ) ) next_slide = jQuery( current_slide ).siblings()[0];
            next_slide.show_slide();
        }
        // If there is an interval_length, rotate through the slides, but only if there is more than one slide.
        if ( jQuery( this ).find( '.' + slide_class ).length > 1 ) {
            if ( interval_length ) {
                // Automatically rotate through the slides.
                /* This breaks scope in IE:
                    this.interval = setInterval( function( slider ) { slider.next_slide(); }, interval_length, this );
                so for now, we must do this: */
                var slider = this;
                this.interval = setInterval( function() { slider.next_slide(); }, interval_length, this );
                // When the user clicks anywhere in the slider, stop the slide rotation.
                jQuery( this ).click(function() { clearInterval( this.interval ); })
            }
        }
        jQuery( this ).addClass( 'slider-initiated' );
    });
}

// Swaps the "Shop All" link above the featured products groups when the user changes groups
function featured_products_shop_all_link( slide ) {
    var link = jQuery( slide ).find( '.featured-product-shop-all' )[0];
    var url = link.href.split('#')[0];
    var html = jQuery( link ).html();
    jQuery( '#featured-products-shop-all' ).attr( 'href', url ).html( html );
}

// Sets the widths on the featured products navigation so the bold hover state doesn't make them jump around.
function featured_products_nav_width() {
    jQuery( '.featured-products-nav li' ).each(function() {
       jQuery( this ).width( jQuery( this ).width() );
    });
}

// Media viewer for product details page.
// Switches the large image when a user clicks on a thumbnail.
// Looks for YouTube link in alt text of thumbnail and embeds YouTube video iframe when clicked.
// Highlights the current thumbnail.
function product_media() {
    var default_src = jQuery( '#product_image' ).attr('src');
    jQuery( '#product_images a[href="' + default_src + '"]' ).addClass( 'product-images-current' );
    jQuery( '#product_images a img[alt*="youtube."]' ).each(function() {
        jQuery( this ).parent( 'a' ).attr( 'href', this.alt ).addClass( 'product-video-thumb' );
    });
    jQuery( '#product_images a' ).click(function( event ) {
        jQuery( '#product_images .product-images-current' ).removeClass( 'product-images-current' );
        jQuery( this ).addClass( 'product-images-current' );
        var img = jQuery( this ).find( 'img' )[0];
        if ( img.alt.match( /youtube\./ ) ) {
            if ( !jQuery( '.product-video-player' )[0] ) {
                var video_id = img.alt.match( /v=([^&]+)/ )[1];
                var player = '<iframe class="product-video-player" type="text/html" width="640" height="435" src="//www.youtube.com/embed/' + video_id + '" frameborder="0"></iframe>';
                jQuery( player ).insertAfter( '#product_image' );
            }
        }
        else {
            jQuery( '#product_image' ).attr( 'src', this.href );
            jQuery( '#main-image' ).attr( 'href', img.title );
            jQuery( '.product-video-player' ).remove();
        }
        event.preventDefault();
    });
}

// On the product details page, turns the color dropdown into swatches.
function product_color_swatches() {
    // IE8 and below don't get color swatches.
    if ( jQuery.browser.msie && jQuery.browser.version < 9 ) return false;
    // Create a UL, and fill it with a radio input and label for each color.
    var ul = jQuery( '<ul>' ).addClass( 'swatches' )[0];
    // This SPAN will hold the name of currently selected color.
    var span = jQuery( '<span>' ).html( '&nbsp;' ).addClass( 'swatch-name' )[0];
    jQuery( '#attribute168 option' ).each(function() {
        if ( !this.value ) return true;
        var color = jQuery( this ).text();
        var className = 'swatch-' + color.replace(/[^a-z0-9]/gi,'-').toLowerCase();
        var id = className.replace(/-/gi,'_');
        var input = jQuery( '<input>', { type: 'radio', id: id, name: 'color', value: this.value } )[0];
        input.option_element = this;
        this.swatch_element = input;
        input.span = span;
        jQuery( ul ).append(
            jQuery( '<li>' ).append(
                input,
                jQuery( '<label>', { 'for': id, 'class': className } ).append(
                    jQuery( '<span>' ).text( jQuery( this ).text() )
                )
            )
        );
    });
    var swatches_count = jQuery( ul ).find( 'li' ).length;
    if ( swatches_count > 10 ) {
        jQuery( '<br/>' ).insertAfter( jQuery( ul ).find( 'li' ).get( Math.floor( swatches_count/2 ) ) );
    }
    // Append the UL and SPAN before the color dropdown and hide the dropdown.
    jQuery( span ).insertBefore( '#attribute168' );
    jQuery( ul ).insertBefore( '#attribute168' );
    jQuery( '#attribute168' ).hide();
    
    // When the user clicks on a swatch, show the color's name and update the hidden color dropdown.
    jQuery( '.product-options .swatches' ).on( 'change', 'input', function() {
        if ( this.checked ) {
            jQuery( this.span ).text( jQuery( this ).next( 'label' ).text() );
            this.span.defaultText = this.span.textContent;
            // Trigger the change event for product_color_switcher() and the blur event for Magento (Prototype) validation.
            jQuery( '#attribute168' ).attr( 'value', this.value ).trigger( 'change' ).trigger( 'blur' );
            // Dispatch the change event for Magento (Prototype) configurable product options.
            dispatch_event( jQuery( '#attribute168' )[0], 'change' );
        }
    });
    
    // When the user mouses over a color, show its name.
    jQuery( '.product-options label[class*="swatch-"]' ).mouseover(function() {
        var span = jQuery( '.swatch-name' )[0];
        span.defaultText = span.textContent;
        span.textContent = this.textContent;
    });
    // When the user mouses away, show the selected color name.
    jQuery( '.product-options label[class*="swatch-"]' ).mouseout(function() {
        var span = jQuery( '.swatch-name' )[0];
        span.textContent = span.defaultText;
    });
    
    // If the color dropdown changes (which it shouldn't, because it's hidden), check the approproate swatch's input.
    jQuery( '#attribute168' ).change(function() {
        jQuery( this ).find( ':selected' ).each(function() {
            this.swatch_element.checked = 'checked';
        });
    });
    
    // Choose the first swatch by default.
    if ( jQuery( '.product-options .swatches' ).length ) {
        jQuery( '.product-options .swatches input' )[0].checked = 'checked';
        dispatch_event( jQuery( '.product-options .swatches input' )[0], 'change' );
    }
}

// Triggers an event in the browser's event system.
function dispatch_event( element, event_name ) {
    if( document.createEvent ){
        evt = document.createEvent( 'HTMLEvents' );
        evt.initEvent( event_name, true, true );
        return element.dispatchEvent(evt);
    } else {
      // dispatch for IE
      var evt = document.createEventObject();
      return element.fireEvent( 'on' + event_name, evt );
    }
}

// On the product detail page, when the user changes the color dropdown selection, update the product image to one of that color (if available).
function product_color_switcher() {
    if ( typeof alt_images !== 'undefined' ) {

        // Find the thumb that corresponds to the default image and the thumb that corresponds to the color images.
        var product_image = jQuery( '#product_image' )[0];
        // For each thumb, look through the alt_images for an image whose URL matches.
        jQuery( '#product_images a' ).each(function() {
            for ( i in alt_images ) {
                var image = alt_images[i];
                var fragment = image.large.match(/\/([^\/]+?)(_+\d*)?\.(png|jpg)$/);
                var re = new RegExp( fragment[1] + '_*\\d*\.(png|jpg)$' );
                if ( this.href == image.large || this.href.match( re ) ) {
                    if ( 'default' == i ) {
                        // Default thumb
                        product_image.default_thumb_link = this;
                        product_image.default_thumb_link.default_href = this.href;
                        product_image.default_thumb_img = jQuery( this ).find( 'img' )[0];
                        product_image.default_thumb_img.default_src = product_image.default_thumb_img.src;
                    }
                    else {
                        // Color thumb
                        product_image.color_thumb_link = this;
                        product_image.color_thumb_link.default_href = this.href;
                        product_image.color_thumb_img = jQuery( this ).find( 'img' )[0];
                        product_image.color_thumb_img.default_src = product_image.color_thumb_img.src;
                    }
                }
            }
            // If there was no color thumb, use the default thumb.
            if ( !product_image.color_thumb_link ) product_image.color_thumb_link = product_image.default_thumb_link;
            if ( !product_image.color_thumb_img ) product_image.color_thumb_img = product_image.default_thumb_img;
        });
        
        // When the user changes the color menu selection, change the main product image and the corresponding thumbnail.
        jQuery( '#attribute168' ).change(function() {
            var product_image = jQuery( '#product_image' )[0];
            var is_default = false;
            var new_image = alt_images[ jQuery( this.options[this.selectedIndex] ).text() ];
            if ( !new_image ) {
                new_image = alt_images['default'];
                is_default = true;
            }
            jQuery( '#product_images .product-images-current' ).removeClass( 'product-images-current' );
            product_image.src = new_image.large;
            if ( is_default ) {
                jQuery( product_image.default_thumb_link ).addClass( 'product-images-current' );
                if ( product_image.color_thumb_link.default_href ) {
                    product_image.color_thumb_link.href = product_image.color_thumb_link.default_href;
                    product_image.color_thumb_img.src = product_image.color_thumb_img.default_src;
                    jQuery( '#main-image' ).attr( 'href', new_image.original );
                }
            }
            else {
                jQuery( product_image.color_thumb_link ).find( 'img' ).attr({ src: new_image.thumb, title: new_image.original });
                jQuery( '#main-image' ).attr( 'href', new_image.original );
                jQuery( product_image.color_thumb_link ).attr( 'href', new_image.large ).addClass( 'product-images-current' );
            }
        });

    }
}

function filter_color_swatches() {
    jQuery( '<span/>' ).addClass( 'swatch-name' ).html( '&nbsp;' ).insertAfter( '.narrow-by-color' );
    jQuery( 'ol.narrow-by-color a[class*="swatch-"]' ).each(function() {
        this.span = jQuery( '.swatch-name' )[0];
    }).mouseover(function() {
        jQuery( this.span ).html( jQuery( this ).text() );
    }).mouseout(function() {
        jQuery( this.span ).html( '&nbsp;' );
    });
}

function twitter_popup() {
    jQuery('a[href*="twitter.com/share"]').click(function(event) {
        var width  = 575,
            height = 400,
            left   = (jQuery(window).width()  - width)  / 2,
            top    = (jQuery(window).height() - height) / 2,
            url    = this.href,
            opts   = 'status=1' +
                     ',width='  + width  +
                     ',height=' + height +
                     ',top='    + top    +
                     ',left='   + left;
        window.open(url, '', opts);
        event.preventDefault();
    });
}

// Play YouTube videos in an overlay.
function youtube_overlay() {
    jQuery( '.modules, .list-products-360, .parts' ).find( 'a[href*="youtube.com/watch"]' ).addClass( 'video-link' ).click(function(event) {
        if ( this.player ) {
            this.player.start();
        }
        else {
            var video_id = this.href.match( /v=([^&]+)/ )[1];
            this.player = jQuery( '<div/>' ).addClass( 'video-player' )[0];
            this.player.overlay =  jQuery( '<div/>' ).addClass( 'overlay' )[0];
            this.player.overlay.player = this.player;
            this.player.close =  jQuery( '<button/>' ).text( 'Close' ).addClass( 'close-x' ).appendTo( this.player )[0];
            this.player.close.player = this.player;
            
            this.player.start = function() {
                jQuery( [ this, this.overlay ] ).show();
                this.iframe = jQuery( '<iframe/>', {
                    type: 'text/html',
                    width: '640',
                    height: '435',
                    frameborder: '0',
                    src: '//www.youtube.com/embed/' + video_id
                }).appendTo( this )[0];
            }
            this.player.stop = function() {
                jQuery( [ this, this.overlay ] ).hide();
                jQuery( this.iframe ).remove();
            }
            
            jQuery( [ this.player.overlay, this.player.close ] ).click( function() {
                this.player.stop();
            })
            
            jQuery( document.body ).append( this.player.overlay, this.player );
            this.player.start();
        }
        event.preventDefault();
    });
    jQuery( document.body ).keyup(function(event) {
        if ( event.keyCode == 27 ) jQuery( '.video-player' ).each(function() { this.stop() });
    });
}
