jQuery(document).ready(function () {
    "use strict";

    /*===================================================================================*/
    /*	OWL CAROUSEL
    /*===================================================================================*/
    jQuery(function () {
        var dragging = true;
        var owlElementID = "#owl-main";

        function fadeInReset() {
            if (!dragging) {
                jQuery(owlElementID + " .caption .fadeIn-1, " + owlElementID + " .caption .fadeIn-2, " + owlElementID + " .caption .fadeIn-3").stop().delay(800).animate({
                    opacity: 0
                }, {
                    duration: 400,
                    easing: "easeInCubic"
                });
            } else {
                jQuery(owlElementID + " .caption .fadeIn-1, " + owlElementID + " .caption .fadeIn-2, " + owlElementID + " .caption .fadeIn-3").css({
                    opacity: 0
                });
            }
        }

        function fadeInDownReset() {
            if (!dragging) {
                jQuery(owlElementID + " .caption .fadeInDown-1, " + owlElementID + " .caption .fadeInDown-2, " + owlElementID + " .caption .fadeInDown-3").stop().delay(800).animate({
                    opacity: 0,
                    top: "-15px"
                }, {
                    duration: 400,
                    easing: "easeInCubic"
                });
            } else {
                jQuery(owlElementID + " .caption .fadeInDown-1, " + owlElementID + " .caption .fadeInDown-2, " + owlElementID + " .caption .fadeInDown-3").css({
                    opacity: 0,
                    top: "-15px"
                });
            }
        }

        function fadeInUpReset() {
            if (!dragging) {
                jQuery(owlElementID + " .caption .fadeInUp-1, " + owlElementID + " .caption .fadeInUp-2, " + owlElementID + " .caption .fadeInUp-3").stop().delay(800).animate({
                    opacity: 0,
                    top: "15px"
                }, {
                    duration: 400,
                    easing: "easeInCubic"
                });
            } else {
                $(owlElementID + " .caption .fadeInUp-1, " + owlElementID + " .caption .fadeInUp-2, " + owlElementID + " .caption .fadeInUp-3").css({
                    opacity: 0,
                    top: "15px"
                });
            }
        }

        function fadeInLeftReset() {
            if (!dragging) {
                jQuery(owlElementID + " .caption .fadeInLeft-1, " + owlElementID + " .caption .fadeInLeft-2, " + owlElementID + " .caption .fadeInLeft-3").stop().delay(800).animate({
                    opacity: 0,
                    left: "15px"
                }, {
                    duration: 400,
                    easing: "easeInCubic"
                });
            } else {
                jQuery(owlElementID + " .caption .fadeInLeft-1, " + owlElementID + " .caption .fadeInLeft-2, " + owlElementID + " .caption .fadeInLeft-3").css({
                    opacity: 0,
                    left: "15px"
                });
            }
        }

        function fadeInRightReset() {
            if (!dragging) {
                jQuery(owlElementID + " .caption .fadeInRight-1, " + owlElementID + " .caption .fadeInRight-2, " + owlElementID + " .caption .fadeInRight-3").stop().delay(800).animate({
                    opacity: 0,
                    left: "-15px"
                }, {
                    duration: 400,
                    easing: "easeInCubic"
                });
            } else {
                jQuery(owlElementID + " .caption .fadeInRight-1, " + owlElementID + " .caption .fadeInRight-2, " + owlElementID + " .caption .fadeInRight-3").css({
                    opacity: 0,
                    left: "-15px"
                });
            }
        }

        function fadeIn() {
            jQuery(owlElementID + " .active .caption .fadeIn-1").stop().delay(500).animate({
                opacity: 1
            }, {
                duration: 800,
                easing: "easeOutCubic"
            });
            jQuery(owlElementID + " .active .caption .fadeIn-2").stop().delay(700).animate({
                opacity: 1
            }, {
                duration: 800,
                easing: "easeOutCubic"
            });
            jQuery(owlElementID + " .active .caption .fadeIn-3").stop().delay(1000).animate({
                opacity: 1
            }, {
                duration: 800,
                easing: "easeOutCubic"
            });
        }

        function fadeInDown() {
            jQuery(owlElementID + " .active .caption .fadeInDown-1").stop().delay(500).animate({
                opacity: 1,
                top: "0"
            }, {
                duration: 800,
                easing: "easeOutCubic"
            });
            jQuery(owlElementID + " .active .caption .fadeInDown-2").stop().delay(700).animate({
                opacity: 1,
                top: "0"
            }, {
                duration: 800,
                easing: "easeOutCubic"
            });
            jQuery(owlElementID + " .active .caption .fadeInDown-3").stop().delay(1000).animate({
                opacity: 1,
                top: "0"
            }, {
                duration: 800,
                easing: "easeOutCubic"
            });
        }

        function fadeInUp() {
            jQuery(owlElementID + " .active .caption .fadeInUp-1").stop().delay(500).animate({
                opacity: 1,
                top: "0"
            }, {
                duration: 800,
                easing: "easeOutCubic"
            });
            jQuery(owlElementID + " .active .caption .fadeInUp-2").stop().delay(700).animate({
                opacity: 1,
                top: "0"
            }, {
                duration: 800,
                easing: "easeOutCubic"
            });
            jQuery(owlElementID + " .active .caption .fadeInUp-3").stop().delay(1000).animate({
                opacity: 1,
                top: "0"
            }, {
                duration: 800,
                easing: "easeOutCubic"
            });
        }

        function fadeInLeft() {
            jQuery(owlElementID + " .active .caption .fadeInLeft-1").stop().delay(500).animate({
                opacity: 1,
                left: "0"
            }, {
                duration: 800,
                easing: "easeOutCubic"
            });
            jQuery(owlElementID + " .active .caption .fadeInLeft-2").stop().delay(700).animate({
                opacity: 1,
                left: "0"
            }, {
                duration: 800,
                easing: "easeOutCubic"
            });
            jQuery(owlElementID + " .active .caption .fadeInLeft-3").stop().delay(1000).animate({
                opacity: 1,
                left: "0"
            }, {
                duration: 800,
                easing: "easeOutCubic"
            });
        }

        function fadeInRight() {
            jQuery(owlElementID + " .active .caption .fadeInRight-1").stop().delay(500).animate({
                opacity: 1,
                left: "0"
            }, {
                duration: 800,
                easing: "easeOutCubic"
            });
            jQuery(owlElementID + " .active .caption .fadeInRight-2").stop().delay(700).animate({
                opacity: 1,
                left: "0"
            }, {
                duration: 800,
                easing: "easeOutCubic"
            });
            jQuery(owlElementID + " .active .caption .fadeInRight-3").stop().delay(1000).animate({
                opacity: 1,
                left: "0"
            }, {
                duration: 800,
                easing: "easeOutCubic"
            });
        }

        jQuery(owlElementID).owlCarousel({

            autoPlay: 5000,
            stopOnHover: true,
            navigation: true,
            pagination: true,
            singleItem: true,
            addClassActive: true,
            transitionStyle: "fade",
            lazyLoad: true,
            navigationText: ["<i class='icon fa fa-angle-left'></i>", "<i class='icon fa fa-angle-right'></i>"],

            afterInit: function () {
                fadeIn();
                fadeInDown();
                fadeInUp();
                fadeInLeft();
                fadeInRight();
            },

            afterMove: function () {
                fadeIn();
                fadeInDown();
                fadeInUp();
                fadeInLeft();
                fadeInRight();
            },

            afterUpdate: function () {
                fadeIn();
                fadeInDown();
                fadeInUp();
                fadeInLeft();
                fadeInRight();
            },

            startDragging: function () {
                dragging = true;
            },

            afterAction: function () {
                fadeInReset();
                fadeInDownReset();
                fadeInUpReset();
                fadeInLeftReset();
                fadeInRightReset();
                dragging = false;
            }

        });

        if (jQuery(owlElementID).hasClass("owl-one-item")) {
            jQuery(owlElementID + ".owl-one-item").data('owlCarousel').destroy();
        }

        jQuery(owlElementID + ".owl-one-item").owlCarousel({
            singleItem: true,
            navigation: false,
            pagination: false
        });




        jQuery('.home-owl-carousel').each(function () {

            var owl = $(this);
            var itemPerLine = owl.data('item');
            if (!itemPerLine) {
                itemPerLine = 4;
            }
            owl.owlCarousel({
                items: itemPerLine,
                itemsDesktop: [1300, 3],
                itemsDesktopSmall: [1180, 2],
                itemsTablet: [768, 2],
                navigation: true,
                pagination: false,

                navigationText: ["", ""],

            });
        });

        jQuery('.home-owl-carousel1').each(function () {

            var owl = $(this);
            var itemPerLine = owl.data('item');
            if (!itemPerLine) {
                itemPerLine = 2;
            }
            owl.owlCarousel({
                items: itemPerLine,
                itemsDesktop: [1300, 2],
                itemsDesktopSmall: [1180, 1],
                itemsTablet: [768, 1],
                navigation: true,
                pagination: false,

                navigationText: ["", ""]





            });
        });

        jQuery('.homepage-owl-carousel').each(function () {

            var owl = $(this);
            var itemPerLine = owl.data('item');


            var autoplay_hover_pause = owl.data('autoplay-hover-pause');
            var loop = owl.data('loop');
            var items_general = owl.data('items');
            var margin = owl.data('margin');
            var autoplay = owl.data('autoplay');
            var autoplayTimeout = owl.data('autoplay-timeout');
            var smartSpeed = owl.data('smart-speed');
            var nav_general = owl.data('nav');
            var navSpeed = owl.data('nav-speed');
            var xxs_items = owl.data('xxs-items');
            var xxs_nav = owl.data('xxs-nav');
            var xs_items = owl.data('xs-items');
            var xs_nav = owl.data('xs-nav');
            var sm_items = owl.data('sm-items');
            var sm_nav = owl.data('sm-nav');
            var md_items = owl.data('md-items');
            var md_nav = owl.data('md-nav');
            var lg_items = owl.data('lg-items');
            var lg_nav = owl.data('lg-nav');
            var center = owl.data('center');
            var dots_global = owl.data('dots');
            var xxs_dots = owl.data('xxs-dots');
            var xs_dots = owl.data('xs-dots');
            var sm_dots = owl.data('sm-dots');
            var md_dots = owl.data('md-dots');
            var lg_dots = owl.data('lg-dots');
            if (!itemPerLine) {
                itemPerLine = 9;
            }
            owl.owlCarousel({
                items: itemPerLine,
                itemsTablet: [768, 3],
                itemsDesktop: [1300, 7],
                itemsDesktopSmall: [1180, 5],
                navigation: true,
                pagination: false,

                navigationText: ["", ""],
                // responsive: {
                //     0: {
                //         items: (xxs_items ? xxs_items : (items_general ? items_general : 1)),
                //         nav: (xxs_nav ? xxs_nav : (nav_general ? nav_general : false)),
                //         dots: (xxs_dots ? xxs_dots : (dots_global ? dots_global : false))
                //     },
                //     480: {
                //         items: (xs_items ? xs_items : (items_general ? items_general : 1)),
                //         nav: (xs_nav ? xs_nav : (nav_general ? nav_general : false)),
                //         dots: (xs_dots ? xs_dots : (dots_global ? dots_global : false))
                //     },
                //     768: {
                //         items: (sm_items ? sm_items : (items_general ? items_general : 1)),
                //         nav: (sm_nav ? sm_nav : (nav_general ? nav_general : false)),
                //         dots: (sm_dots ? sm_dots : (dots_global ? dots_global : false))
                //     },
                //     992: {
                //         items: (md_items ? md_items : (items_general ? items_general : 1)),
                //         nav: (md_nav ? md_nav : (nav_general ? nav_general : false)),
                //         dots: (md_dots ? md_dots : (dots_global ? dots_global : false))
                //     },
                //     1199: {
                //         items: (lg_items ? lg_items : (items_general ? items_general : 1)),
                //         nav: (lg_nav ? lg_nav : (nav_general ? nav_general : false)),
                //         dots: (lg_dots ? lg_dots : (dots_global ? dots_global : false))
                //     }
                // }
            });
        });

        jQuery(".blog-slider").owlCarousel({
            items: 4,
            itemsTablet: [979, 2],
            itemsDesktopSmall: [1180, 2],
            itemsDesktop: [1300, 3],
            navigation: true,
            slideSpeed: 300,
            pagination: false,
            navigationText: ["", ""]
        });

        jQuery(".coupons-deal").owlCarousel({
            items: 2,
            navigation: true,
            itemsDesktopSmall: [979, 2],
            itemsDesktop: [1199, 2],
            slideSpeed: 300,
            pagination: false,
            paginationSpeed: 400,
            navigationText: ["", ""]
        });

        jQuery(".sidebar-carousel").owlCarousel({
            items: 1,
            itemsTablet: [768, 2],
            itemsDesktopSmall: [979, 2],
            itemsDesktop: [1199, 1],
            navigation: true,
            slideSpeed: 300,
            pagination: false,
            paginationSpeed: 400,
            navigationText: ["", ""]
        });

        jQuery(".brand-slider").owlCarousel({
            items: 5,
            navigation: true,
            slideSpeed: 300,
            pagination: false,
            paginationSpeed: 400,
            navigationText: ["", ""]
        });
        jQuery("#advertisement").owlCarousel({
            items: 1,
            itemsDesktopSmall: [979, 2],
            itemsDesktop: [1199, 1],
            navigation: true,
            slideSpeed: 300,
            pagination: true,
            paginationSpeed: 400,
            navigationText: ["", ""]
        });



    });

    /*===================================================================================*/
    /*  LAZY LOAD IMAGES USING ECHO
    /*===================================================================================*/
    jQuery(function () {
        echo.init({
            offset: 100,
            throttle: 250,
            unload: false
        });
    });

    /*===================================================================================*/
    /*  RATING
    /*===================================================================================*/

    jQuery(function () {
        jQuery('.rating').rateit({
            max: 5,
            step: 1,
            value: 4,
            resetable: false,
            readonly: true
        });
    });

    /*===================================================================================*/
    /* PRICE SLIDER
    /*===================================================================================*/
    jQuery(function () {

        // Price Slider
        if (jQuery('.price-slider').length > 0) {
            jQuery('.price-slider').slider({
                min: 100,
                max: 700,
                step: 10,
                value: [200, 500],
                handle: "square"

            });

        }

    });


    /*===================================================================================*/
    /* SINGLE PRODUCT GALLERY
    /*===================================================================================*/
    jQuery(function () {
        jQuery('#owl-single-product').owlCarousel({
            items: 1,
            itemsTablet: [768, 3],
            itemsDesktop: [1199, 1],
            itemsTablet: [992, 1],
            itemsDesktopSmall: [768, 3]

        });

        jQuery('#owl-single-product-thumbnails').owlCarousel({
            items: 4,
            pagination: true,
            rewindNav: true,
            itemsTablet: [992, 4],
            itemsDesktopSmall: [768, 4],
            itemsDesktop: [992, 1]
        });

        jQuery('#owl-single-product2-thumbnails').owlCarousel({
            items: 6,
            pagination: true,
            rewindNav: true,
            itemsTablet: [768, 4],
            itemsDesktop: [1199, 3]
        });

        jQuery('.single-product-slider').owlCarousel({
            stopOnHover: true,
            rewindNav: true,
            singleItem: true,
            pagination: true
        });


    });





    /*===================================================================================*/
    /*  WOW 
    /*===================================================================================*/

    jQuery(function () {
        new WOW().init();
    });


    /*===================================================================================*/
    /*  TOOLTIP 
    /*===================================================================================*/
    jQuery("[data-toggle='tooltip']").tooltip();




})
