jQuery(function($) {
    /**
    * Interactive menu on home page
    */
    $('body.home .nav-primary .genesis-nav-menu > .menu-item > .sub-menu').height(614);
    $('body.home .nav-primary .genesis-nav-menu > .menu-item:nth-child(2)').hover(
        function() {
            $('main').css('background-image', 'url(\''+bethel.siteurl+'/wp-content/themes/bethel-clydach/images/something-for-everyone.jpg\')')
            $('img.home-main').fadeOut('slow', function() {
                $(this).attr('src', bethel.siteurl+'/wp-content/themes/bethel-clydach/images/something-for-everyone.jpg');
                $(this).fadeIn();
            });
        }
    );
    $('body.home .nav-primary .genesis-nav-menu > .menu-item:first-child').hover(
        function() {
            $('main').css('background-image', 'url(\''+bethel.siteurl+'/wp-content/themes/bethel-clydach/images/everyone-welcome.jpg\')')
            $('img.home-main').fadeOut('slow', function() {
                $(this).attr('src', bethel.siteurl+'/wp-content/themes/bethel-clydach/images/everyone-welcome.jpg');
                $(this).fadeIn();
            });
        }
    );
    $('body.home .nav-primary .genesis-nav-menu > .menu-item:last-child').hover(
        function() {
            $('main').css('background-image', 'url(\''+bethel.siteurl+'/wp-content/themes/bethel-clydach/images/ordinary-people.jpg\')')
            $('img.home-main').fadeOut('slow', function() {
                $(this).attr('src', bethel.siteurl+'/wp-content/themes/bethel-clydach/images/ordinary-people.jpg');
                $(this).fadeIn();
            });
        }
    );
    $('body.home #menu-main').hover('', function() {
            $('main').css('background-image', 'url(\''+bethel.siteurl+'/wp-content/themes/bethel-clydach/images/people.jpg\')')
            $('img.home-main').fadeOut('slow', function() {
                $(this).attr('src', bethel.siteurl+'/wp-content/themes/bethel-clydach/images/people.jpg');
                $(this).fadeIn();
            });
    });
});