/*
Template: Dustrix - Construction & Industry HTML Template
Author: Modina Theme
*/

(function($) {
    "use strict";

    $(document).ready( function() {
                
        $(".hero-slider-active").owlCarousel({        
            items: 1,     
            dots: false,
            loop: true,
            autoplayTimeout: 8000,
            autoplay:true,
            nav: true,          
            navText: ['<i class="fal fa-long-arrow-left"></i>', '<i class="fal fa-long-arrow-right"></i>'],
        });

        $(".service-gallery").owlCarousel({        
            items: 1,     
            dots: true,
            autoplayTimeout: 8000,
            autoplay:true,
            nav: true,          
            navText: ['<i class="fal fa-long-arrow-left"></i>', '<i class="fal fa-long-arrow-right"></i>'],
        });

        $(".about-featured-carousel").owlCarousel({        
            items: 1,     
            dots: true,
            autoplayTimeout: 5000,
            autoplay:true,
            loop: true,
        });

        $(".portfolio-item-grid-active").owlCarousel({         
            dots: true,
            autoplayTimeout: 5000,
            autoplay:true,
            loop: true,
            center: true,
            responsive : {
                // breakpoint from 0 up
                0 : {
                    items: 1,
                },
                700 : {
                    items: 2,
                    margin: 30,
                },                               
                // breakpoint from 992 up
                1199 : {
                    items: 3,
                    margin: 40,
                }
            }
        });

        $(".portfolio-carousel-wrapper").owlCarousel({ 
            center: true,      
            margin: 50,      
            dots: false,
            loop: true,
            items: 3,
            autoplayTimeout: 8000,
            autoplay:true,
            nav: false,
            responsive : {
                // breakpoint from 0 up
                0 : {
                    items: 1,
                },
                767 : {
                    items: 1
                },                
                991 : {
                    items: 2
                },                
                // breakpoint from 992 up
                1199 : {
                    items: 3
                }
            }
        });

        if( $('.portfolio-carousel-active').length > 0) {
            $('.portfolio-carousel-active').owlCarousel({                        
                items: 1,      
                dots: false,
                loop: true,
                autoplayTimeout: 8000,
                autoplay:true,
                nav: true,
                navText: ['<i class="fal fa-long-arrow-left"></i>', '<i class="fal fa-long-arrow-right"></i>'],
                navContainer: '.project-wrapper .project-carousel-nav',   
            });
        }

        $(".timeline-carousel-wrapper").owlCarousel({ 
            center: true,      
            margin: 50,      
            dots: false,
            loop: true,
            responsive : {
                // breakpoint from 0 up
                0 : {
                    items: 1,
                },
                767 : {
                    items: 2
                },                
                991 : {
                    items: 3
                },                
                // breakpoint from 992 up
                1199 : {
                    items: 4
                },
                
                1600 : {
                    items: 5
                }
            }
        });


        $(".brand-logo-grid").owlCarousel({  
            margin: 70,    
            dots: false,
            loop: true,
            autoplayTimeout: 8000,
            autoplay:true,  
            responsive : {
                // breakpoint from 0 up
                0 : {
                    items: 2,
                },
                767 : {
                    items: 2
                },                
                991 : {
                    items: 3
                },                
                // breakpoint from 992 up
                1191 : {
                    items: 4
                }
            }
        });

        /* =============================================
            # Magnific popup init
         ===============================================*/
        $(".popup-link").magnificPopup({
            type: 'image',
            fixedContentPos: false
        });

        $(".popup-gallery").magnificPopup({
            type: 'image',
            fixedContentPos: false,
            gallery: {
                enabled: true
            },
            // other options
        });

        $(".popup-video, .popup-vimeo, .popup-gmaps").magnificPopup({
            type: "iframe",
            mainClass: "mfp-fade",
            removalDelay: 160,
            preloader: false,
            fixedContentPos: false
        });
        
        /*==========================
           Scroll To Up Init
        ============================*/
        $.scrollUp({
            scrollName: 'scrollUp', // Element ID
            topDistance: '1110', // Distance from top before showing element (px)
            topSpeed: 2000, // Speed back to top (ms)
            animation: 'slide', // Fade, slide, none
            animationInSpeed: 300, // Animation in speed (ms)
            animationOutSpeed: 300, // Animation out speed (ms)
            scrollText: '<i class="fal fa-angle-up"></i>', // Text for element
            activeOverlay: false, // Set CSS color to display scrollUp active point, e.g '#00FFFF'
        });

        //# Smooth Scroll
        $('#responsive-menu a').on('click', function(event) {
            var $anchor = $(this);
            var headerH = '85';
            $('html, body').stop().animate({
                scrollTop: $($anchor.attr('href')).offset().top - headerH + "px"
            }, 1000, 'easeInOutExpo');
            event.preventDefault();
        });

        // Sticky Menu
        $(window).scroll(function() {
            var Width = $(document).width();

            if ($("body").scrollTop() > 100 || $("html").scrollTop() > 100) {
                if (Width > 767) {
                    $("header").addClass("sticky");
                }
            } else {
                $("header").removeClass("sticky");
            }
        });

        $('.container').imagesLoaded(function() {
            $('.portfolio-cat-filter').on('click', 'button', function() {
                var filterValue = $(this).attr('data-filter');
                $grid.isotope({ filter: filterValue });
            });

            var $grid = $('.grid').isotope({
                itemSelector: '.grid-item',
                percentPosition: true,
            });
        });

        var catButton = '.portfolio-cat-filter button';

        $(catButton).on('click', function(){
            $(catButton).removeClass('active');
            $(this).addClass('active');
        });


        $('#hamburger').on('click', function() {            
            $('.mobile-nav').addClass('show');
            $('.overlay').addClass('active');
        });

        $('.close-nav').on('click', function() {            
            $('.mobile-nav').removeClass('show');            
            $('.overlay').removeClass('active');          
        });

        $(".overlay").on("click", function () {
            $(".mobile-nav").removeClass("show");
            $('.overlay').removeClass('active');
        });

        $("#mobile-menu").metisMenu();

        new WOW().init();


        const counterUp = window.counterUp.default

        const callback = entries => {
            entries.forEach( entry => {
                const el = entry.target
                if ( entry.isIntersecting && ! el.classList.contains( 'is-visible' ) ) {
                    counterUp( el, {
                        duration: 3500,
                        delay: 15,
                    } )
                    el.classList.add( 'is-visible' )
                }
            } )
        }

        const IO = new IntersectionObserver( callback, { threshold: 1 } )

        const el = document.querySelectorAll( '.single-funfact-item h3, .our-experience h1, .single-fact .digit span, .digit-count span' );
        el.forEach((el) => {
            IO.observe(el);
        });


        $('.side-menu-toggle, .offcanvas-btn').on('click', function() {            
            $('.offset-menu').addClass('show');
        });

        $('#offset-menu-close-btn').on('click', function() {            
            $('.offset-menu').removeClass('show');
        });

        
    }); // end document ready function

    function loader() {
        $(window).on('load', function() {
            // Animate loader off screen
            $(".preloader").delay(700).fadeOut();                        
        });
    }

    loader();

})(jQuery); // End jQuery
