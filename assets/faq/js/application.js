/***************************************************
 As the page loads, cal these scripts
 ***************************************************/

jQuery(document).ready(function ($) {
    "use strict";

    // responsive videos with fitvids
    $('.fitvids').fitVids();
    $(".hero-image").backstretch("https://wish-fish.com/assets/faq/img/hero.jpg");
    $('.trigger-tooltio').tooltip()


}); /* end of as page load scripts */


/***************************************************
 Autocomplete Search
 ***************************************************/

// Load countries then initialize plugin:
jQuery.ajax({
    url: 'content/countries.txt',
    dataType: 'json'
}).done(function (source) {

    var countriesArray = jQuery.map(source, function (value, key) {
        return {value: value, data: key};
    }),
            countries = jQuery.map(source, function (value) {
                return value;
            });

    // Initialize autocomplete with custom appendTo:
    jQuery('#autocomplete-dynamic').autocomplete({
        lookup: countriesArray
    });

});

/***************************************************
 FAQ Pages
 ***************************************************/

jQuery(document).ready(function () {

    jQuery('.faq-accordion .faq-content').hide();

    jQuery('.faq-accordion .faq .entry-title').click(function () {
        if (jQuery(this).hasClass('faq-close')) {

            jQuery('.faq-open').removeClass('faq-open').addClass('faq-close');
            jQuery('.faq-content').slideUp();

            jQuery(this).parents('.faq').first().find('.faq-content').slideDown();
            jQuery(this).removeClass('faq-close').addClass('faq-open');

        } else {
            jQuery(this).parents('.faq').first().find('.faq-content').slideUp();
            jQuery(this).removeClass('faq-open').addClass('faq-close');
        }
    }).addClass('faq-close');

});


jQuery(document).ready(function ($) {

    $(function () {
        $('.faq-back-top').click(function () {
            $('body,html').animate({
                scrollTop: 0
            }, 800);
            return false;
        });
    });

});


jQuery().ready(function () {

    jQuery('.faq-category-list .faq-section-heading a, .faq-category-list .entry-title a').each(function () {

        var destination = '';

        jQuery(this).click(function () {

            var elementClicked = jQuery(this).attr('href');
            var elementOffset = jQuery('body').find(elementClicked).offset();
            destination = elementOffset.top;

            jQuery('html,body').animate({scrollTop: destination - 30}, 500);

            return false;
        });

    });

});

