(function (e) {
    "use strict";
    var n = window.JS || {};
    n.navigation = function () {
      //added arrow
        e("ul#primary-menu>li,div#primary-menu>ul>li").has("ul").addClass("down-arrow");
        e("ul#primary-menu>li>ul li,div#primary-menu>ul>li>ul li").has("ul").addClass("right-arrow");
    },
    n.mobileMenu = function () {
        e(document).on("click","#menu-icon",function(){

            e(".mobile-menu-section").addClass("show");
            e("#primary-nav-menu,#primary-menu").clone().appendTo(".mobile-menu");
            e(".mobile-menu ul li").has("ul").addClass("down-arrow");
            e("body").css("overflow-y","hidden");

            e('#mobile-close').focus();

        });


        e("#mobile-close").on("click",function(){
            e(".mobile-menu-section").removeClass("show");
            e(".mobile-menu #primary-nav-menu,.mobile-menu #primary-menu").remove();
            e(".mobile-menu ul li").has("ul").removeClass("down-arrow");
            e("body").css("overflow-y","scroll");
            e('#menu-icon button').focus();
        });

        e('.skip-link-menu-end').focus(function(){
            e('#mobile-close').focus();

        });

        e('.skip-link-menu-start').focus(function(){
            e('.mobile-menu ul li:last-child a').focus();
        });

        e(document).keyup(function(j) {
            if (j.key === "Escape") { // escape key maps to keycode `27`
                if ( e( '.mobile-menu-section' ).hasClass( 'show' ) ) {

                    e(".mobile-menu-section").removeClass("show");
                    e(".mobile-menu #primary-nav-menu,.mobile-menu #primary-menu").remove();
                    e(".mobile-menu ul li").has("ul").removeClass("down-arrow");
                    e("body").css("overflow-y","scroll");
                    e('#menu-icon button').focus();

                }
            }
        });

    },
    n.minHeight = function () {
        var footerHeight = e("#colophon").outerHeight();
        var windowHeight = e(window).height();
        var contentMinHeight = windowHeight  -  footerHeight;
        if( e(window).width() > 992){
            e(".min-height").css("minHeight",contentMinHeight);
        }
    },
    n.DataBackground = function () {
        var pageSection = e(".data-background");
        pageSection.each(function (indx) {

            if (e(this).attr("data-background")) {
                e(this).css("background-image", "url(" + e(this).data("background") + ")");
            }
        });
        e(".bg-image").each(function () {
            var src = e(this).children("img").attr("src");
            e(this).css("background-image", "url(" + src + ")").children("img").hide();
        });
    },
    n.slider = function() {
        var rtlStatus=false;
        if( e('body').hasClass('rtl')){
            rtlStatus = true;
        }
        e(".wp-block-gallery.columns-1,.wp-block-gallery.columns-1 .blocks-gallery-grid,.gallery-columns-1,.themename-photography-slider").slick({
            autoplay: true,
            infinite: false,
            speed: 300,
            arrow: false,
            dots: false,
            slidesToShow: 1,
            slidesToScroll: 1,
            rtl: rtlStatus
        });
        e(".blog-slider,.widget-slider").slick({
            autoplay: true,
            infinite: false,
            speed: 300,
            arrow: true,
            dots: true,
            slidesToShow: 1,
            slidesToScroll: 1,
            cssEase: "linear",
        });
        e(".themename-photography-slider").on("wheel", (function(ep) {
            ep.preventDefault();
            if (ep.originalEvent.deltaY < 0) {
              e(this).slick("slickNext");
            } else {
              e(this).slick("slickPrev");
            }
        }));
    },
    n.galleryMagnificPopUp = function () {
        e(".wp-block-gallery,.gallery").each(function () {
            e(this).magnificPopup({
                delegate: "a",
                type: "image",
                closeOnContentClick: false,
                closeBtnInside: false,
                mainClass: "mfp-with-zoom mfp-img-mobile",
                image: {
                    verticalFit: true,
                    titleSrc: function (item) {
                        return item.el.attr("title");
                    }
                },
                gallery: {
                    enabled: true
                },
                zoom: {
                    enabled: true,
                    duration: 300,
                    opener: function (element) {
                        return element.find("img");
                    }
                }
            });
        });
        e(".themename-photography-slider").each(function () {
            e(this).magnificPopup({
                delegate: ".photography-post>a",
                type: "image",
                closeOnContentClick: false,
                closeBtnInside: false,
                mainClass: "mfp-with-zoom mfp-img-mobile",
                image: {
                    verticalFit: true,
                    titleSrc: function (item) {
                        return item.el.attr("title");
                    }
                },
                gallery: {
                    enabled: true
                },
                zoom: {
                    enabled: true,
                    duration: 300,
                    opener: function (element) {
                        return element.find("img");
                    }
                }
            });
        });
    },
    n.ep_masonry = function () {
        if (e(window).width() > 600) {
            if (e(".masonry-blocks").length > 0) {
                var $blocks = e(".masonry-blocks").imagesLoaded(function () {
                    $blocks.masonry({
                        itemSelector: "article",
                    });
                });
            }
        }
    },
    n.galleryView = function() {
        e("#list-view").on("click",function(){
            e("#masonary-gallery").addClass("full-width-post").removeClass("post-with-bg-image");
            e(this).addClass("active").siblings().removeClass("active");
        });
        e("#grid-view").on("click",function(){
            e("#masonary-gallery").addClass("post-with-bg-image").removeClass("full-width-post");
            e(this).addClass("active").siblings().removeClass("active");
            n.ep_masonry();
        });
    },
    e(window).on("load", function () {
      e("#status").fadeOut();
      e("#preloader").delay(350).fadeOut("slow");
      e("body").delay(350).css({ "overflow": "visible" });
   });
    e(document).ready(function () {
        n.DataBackground(),n.mobileMenu(),n.slider(),n.ep_masonry(),n.minHeight(),n.galleryMagnificPopUp(),n.galleryView();
    });
    e(window).resize(function(){
        n.ep_masonry(),n.minHeight();
    });
})(jQuery);
