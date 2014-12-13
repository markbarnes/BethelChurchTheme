jQuery(function($) {
    var gallery_urls=<?php global $bethel_gallery_urls; echo $bethel_gallery_urls; ?>;
    //Add a link to the thumbnails
    $('div.gallery-icon img.gallery-thumbnail').wrap(function() {
        return '<a class="gallery-link" id="link-'+$(this).attr('id')+'" href="#"></a>';
    });
    //Add a container div in the header
    $('header.entry-header').prepend('<div id="gallery-overlay"></div>');
    $('div#gallery-overlay').css('background-image', $('header.entry-header').css('background-image'));
    //Preload the images
    Object.keys(gallery_urls).forEach(function(key){
        $('<img />').attr('src', gallery_urls[key]);
    });
    
    //Click handler
    $('a.gallery-link').click(function() {
        var id="i"+($(this).attr('id').substr(22));
        var url=gallery_urls[id];
        $('header.entry-header').css('background-image', 'url(\''+url+'\')')
        $('div#gallery-overlay').fadeOut(1000, function() {
            $('div#gallery-overlay').css('background-image', 'url(\''+url+'\')');
            $('div#gallery-overlay').show();
        });
        return false;
    });
});