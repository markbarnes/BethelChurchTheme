jQuery(function($) {
    /**
    * Interactive menu on home page
    */
    function is_tiny_viewport() {
        if ($(window).width() < 568) {
            return true;
        };
        return false;
    }

    function get_it_done() {
        var height = $('body.home main.content img').height();
        $('main.content').height(height);
        if (!is_tiny_viewport()) {
            $('body.home .nav-primary .genesis-nav-menu > .menu-item > .sub-menu').height(height-1);
            if (!window.events_are_bound) {
                bind_events();
            }
        } else {
            $('body.home .nav-primary .genesis-nav-menu > .menu-item > .sub-menu').css('height', 'auto');
            if (window.events_are_bound) {
                unbind_events();
            }
        }
    }
    
    window.events_are_bound = false;
    
    get_it_done();

    $(window).resize( function() {
        get_it_done();
    })


    function bind_events() {
        $('body.home .nav-primary .genesis-nav-menu > .menu-item:nth-child(2)').on ('mouseenter',
            function() {
                $('main').css('background-image', 'url(\''+bethel.siteurl+'/wp-content/themes/bethel-clydach/images/something-for-everyone.jpg\')')
                $('img.home-main').fadeOut('slow', function() {
                    $(this).attr('src', bethel.siteurl+'/wp-content/themes/bethel-clydach/images/something-for-everyone.jpg');
                    $(this).fadeIn();
                });
            }
        );
        $('body.home .nav-primary .genesis-nav-menu > .menu-item:first-child').on ('mouseenter',
            function() {
                $('main').css('background-image', 'url(\''+bethel.siteurl+'/wp-content/themes/bethel-clydach/images/everyone-welcome.jpg\')')
                $('img.home-main').fadeOut('slow', function() {
                    $(this).attr('src', bethel.siteurl+'/wp-content/themes/bethel-clydach/images/everyone-welcome.jpg');
                    $(this).fadeIn();
                });
            }
        );
        $('body.home .nav-primary .genesis-nav-menu > .menu-item:last-child').on ('mouseenter',
            function() {
                $('main').css('background-image', 'url(\''+bethel.siteurl+'/wp-content/themes/bethel-clydach/images/ordinary-people.jpg\')')
                $('img.home-main').fadeOut('slow', function() {
                    $(this).attr('src', bethel.siteurl+'/wp-content/themes/bethel-clydach/images/ordinary-people.jpg');
                    $(this).fadeIn();
                });
            }
        );
        $('body.home #menu-main').on ('mouseleave',
            function() {
                $('main').css('background-image', 'url(\''+bethel.siteurl+'/wp-content/themes/bethel-clydach/images/people.jpg\')')
                $('img.home-main').fadeOut('slow', function() {
                    $(this).attr('src', bethel.siteurl+'/wp-content/themes/bethel-clydach/images/people.jpg');
                    $(this).fadeIn();
                });
            }
        );
        window.events_are_bound = true;
    }
    
    function unbind_events() {
        $('body.home .nav-primary .genesis-nav-menu > .menu-item:nth-child(2)').off ('mouseenter');
        $('body.home .nav-primary .genesis-nav-menu > .menu-item:first-child').off ('mouseenter');
        $('body.home .nav-primary .genesis-nav-menu > .menu-item:last-child').off ('mouseenter')
        $('body.home #menu-main').off ('mouseleave');
        window.events_are_bound = false;
    }
});