(function( window, undefined ) {
    var
        History = window.History,
        $ = window.jQuery,
        document = window.document;

    // Check to see if History.js is enabled for our Browser
    if ( !History.enabled ) {
        return false;
    }

    // Wait for Document
    $( function() {
        // Prepare Variables
        var
            // Application Specific Variables
            contentSelector = '#page-content',
            $content = $( contentSelector ).filter(':first'),
            contentNode = $content.get( 0 ),

            // Application Generic Variables
            $body = $( document.body ),
            rootUrl = History.getRootUrl();

        // Ensure Content
        if ( $content.length === 0 ) {
            $content = $body;
        }

        // Internal Helper
        $.expr[':'].internal = function( obj, index, meta, stack ) {
            // Prepare
            var
                $this = $( obj ),
                url = $this.attr( 'href' ) || $this.attr( 'data-url' ) || '',
                isInternalLink;

            // Check link
            isInternalLink = (url != '') && ( (url.indexOf( ':' ) === -1) || (url.substring( 0, rootUrl.length ) === rootUrl) );

            // Ignore or Keep
            return isInternalLink;
        };

        // HTML Helper
        var documentHtml = function(html){
            // Prepare
            var result = String(html)
                .replace(/<\!DOCTYPE[^>]*>/i, '')
                .replace(/<(html|head|body|title|meta|script)([\s\>])/gi,'<div class="document-$1"$2')
                .replace(/<\/(html|head|body|title|meta|script)\>/gi,'</div>')
            ;

            // Return
            return result;
        };

        // Ajaxify Helper
        $.fn.ajaxify = function(){
            // Prepare
            var $this = $(this);

            // Ajaxify
            $this.find( 'a:internal:not(.no-hist-ajax,[href^="#"]), article:internal:not(.no-hist-ajax)' ).click( function( event ) {
                // Prepare
                var
                    $this = $( this ),
                    url = $this.attr( 'href' ) || $this.attr( 'data-url' ),
                    title = $this.attr( 'title' ) || null;

                if ($this.parent().hasClass('no-hist-ajax')) {
                    return true;
                }
                
                console.info('history.js: change url: ' + url);

                // Continue as normal for cmd clicks etc
                if ( event.which == 2 || event.metaKey ) { return true; }

                // Ajaxify this link
                History.pushState( { referrer: document.location.href }, title, url );
                event.preventDefault();
                return false;
            });

            // Chain
            return $this;
        };

        // Ajaxify our Internal Links
        $body.ajaxify();

        // Hook into State Changes
        $( window ).bind( 'statechange', function() {
            // Prepare Variables
            var
                State = History.getState(),
                url = State.url,
                relativeUrl = url.replace(rootUrl,''),
                referrer = State.data.referrer;

            // Set Loading
            // TODO pb: add loader animation
            $body.addClass('loading');

            // Start Fade Out
            // Will animate opacity to 0 using css transition.
            $content.addClass('hide');

            // Ajax Request the Traditional Page
            $.ajax({
                url: url,
                headers: { "X-Hist-Referer": referrer },
                success: function( data, textStatus, jqXHR ) {
                    
                    var
                        $data = $(documentHtml(data)),
                        $dataBody = $data.find('.document-body:first'),
                        $dataContent = $dataBody.find(contentSelector).filter(':first'),
                        $menuChildren, contentHtml, $scripts;

                    // Fetch the scripts
                    $scripts = $dataContent.find('.document-script');
                    if ( $scripts.length ) {
                        $scripts.detach();
                    }

                    // Fetch the content
                    contentHtml = $dataContent.html() || $data.html();
                    if ( !contentHtml ) {
                        document.location.href = url;
                        return false;
                    }

                    // Update the content
                    $content.stop(true,true);
                    $content.html( contentHtml ).ajaxify();

                    // Apply show animation using css.
                    var
                        transEndEventNames = {
                            'WebkitTransition' : 'webkitTransitionEnd',
                            'MozTransition'    : 'transitionend',
                            'OTransition'      : 'oTransitionEnd',
                            'msTransition'     : 'msTransitionEnd', // maybe?
                            'transition'       : 'transitionEnd'
                        },
                        transitionStyle = Modernizr.prefixed('transition'),
                        transEndEventName = transEndEventNames[ transitionStyle ],
                        $animatedElements = $content.find('article.show-ani');

                    $animatedElements.css({ opacity: 0 });

                    $content.trigger( 'contentLoaded' );
                    $.later( 250, this, function() {
                        $content.removeClass('hide');
                        $animatedElements.bind( transEndEventName, function() {
                            var $this = $(this);
                            $this.unbind( transEndEventName );
                            // Remove the inline transition style to enable rollovers.
                            var props = {};
                            props[ Modernizr.prefixed('transition') ] = '';
                            $this.css( props );
                        });
                        $animatedElements.each( function( ix, el ) {
                            var delay = (ix + 1) * 0.4;
                            var cssProps = { opacity: 1 };
                            cssProps[ transitionStyle ] = 'opacity 0.3s ease-in ' + delay + 's';
                            $( this ).css( cssProps );
                        });
                    });

                    // Update the title
                    document.title = $data.find('.document-title:first').text();
                    try {
                        document.getElementsByTagName( 'title' )[0].innerHTML = document.title.replace( '<', '&lt;' )
                                .replace( '>', '&gt;' ).replace( ' & ', ' &amp; ' );
                    }
                    catch ( Exception ) { }

                    // Add the scripts
                    $scripts.each( function() {
                        var $script = $( this ), scriptText = $script.text(), scriptNode = document
                                .createElement( 'script' );
                        scriptNode.appendChild( document.createTextNode( scriptText ) );
                        contentNode.appendChild( scriptNode );
                    });

                    // Complete the change
                    $( 'html,body' ).animate( { scrollTop: 0 }, 'swing' );

                    $body.removeClass('loading');

                    // Inform Google Analytics of the change
                    if ( typeof window._gaq !== 'undefined' ) {
                        if (template_paths.site_type !== 'undefined') {
                            window._gaq.push(['_setCustomVar', 1, 'SiteType', template_paths.site_type, 3]);
                        }
                        window._gaq.push(['_trackPageview']);
                    }

                },
                error: function( jqXHR, textStatus, errorThrown ) {
                    log('history error: ', errorThrown);
                    document.location.href = url;
                    return false;
                }
            }); // end ajax

        }); // end onStateChange

    }); // end onDomLoad

})( window ); // end closure