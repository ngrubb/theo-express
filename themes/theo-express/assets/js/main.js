/* ---------------------------------------------------------------------
Global Js
Target Browsers: All
------------------------------------------------------------------------ */

var NG = (function(NG, $) {

    /* ---------------------------------------------------------------------
    Global
    Small scripts
    ------------------------------------------------------------------------ */

    NG.Global = {
        init: function()
        {
            var self = this;
            self.globalSetup();
        },

		globalSetup: function() {			

    	}

    };// NG. Global End


	NG.Menu = {
		init: function()
		{
            var self = this;
			self.MenuItem();
		},

		MenuItem: function(){

			$('.sub-menu').parent().addClass('has-submenu');

			var $menu = $('.menu'),
			  //$menulink = $('.menu-link span'),
			  $menuTrigger = $('.has-submenu > a span');

			$menuTrigger.click(function(e) {
				e.preventDefault();
				var $this = $(this);
				$this.toggleClass('active').parent().next('ul').toggleClass('active');
				$this.parent().toggleClass('active').parent().toggleClass('active');
			});

			$('.menu-toggle').click(function () {
              var $this = $(this),
                  isActive = $this.hasClass('active');
			});

		},
 	};  // NG. Menu End

    /**
     * Force External Links to open in new window.
     * @type {Object}
     */
    NG.ExternalLinks = {
        init: function() {
            $('a:not([href^="'+NG.siteurl+'"]):not([href^="#"]):not([href^="/"])')
                .addClass('external')
                .attr('target', '_blank');
        }
    }


    /**
     * Custom Social Share icons open windows
     * @type {Object}
     */
    NG.Social = {
        init: function() {
            $(".js-social-share").on("click", this.open);
        },

        open: function(event) {
          event.preventDefault();

          NG.Social.windowPopup($(this).attr("href"), 500, 300);
        },

        windowPopup: function (url, width, height) {
            // Calculate the position of the popup so
            // it’s centered on the screen.
            var left = (screen.width / 2) - (width / 2),
                top = (screen.height / 2) - (height / 2);

            window.open(
                url,
                "",
                "menubar=no,toolbar=no,resizable=yes,scrollbars=yes,width=" + width + ",height=" + height + ",top=" + top + ",left=" + left
            );
        }
    }


    /**
     * ImAHuman
     * Hidden Captchas for forms
     * @type {Object}
     */
    NG.ImAHuman = {
        num: "0xFF9481",
        forms: void 0,

        init: function() {
            this.setup()
        },

        setup: function() {
            this.forms = document.getElementsByTagName("form");
            this.bind();
        },

        bind: function() {
            for (var i = 0; this.forms.length > i; i++) {
                $(this.forms[i]).on("focus click", this.markAsHuman);
            }
        },

        markAsHuman: function() {
            $(this).find('.imahuman, [name="imahuman"]').attr("value", parseInt(NG.ImAHuman.num, 16))
        }
    }


    /**
     * Affix
     * Fixes sticky items on scroll
     * @type {Object}
     */
    NG.Affix = {
        windowHeight: 0,

        init: function() {
            this.windowHeight = $(window).height();
            this.bind();
        },

        bind: function(e) {
            $(window).on('scroll', this.scroll);
            $(window).on('resize', this.updateWindowHeight);
        },

        scroll: function(e) {
            var scrolltop = $(this).scrollTop(),
                fixPoint = NG.Affix.windowHeight - $('#masthead').height();


            if(scrolltop >= fixPoint) {
                $('body').addClass('affix-head');
            } else {
                $('body').removeClass('affix-head');
            }
        },

        updateWindowHeight: function(e) {
            NG.Affix.windowHeight = $(window).height();
        }
    };


    /**
     * NG.Parallax
     * Parallax effect for images
     * @type {Object}
     */
    NG.Parallax = {
        init: function() {
            this.bind();
        },

        bind: function() {
            $(window).scroll(this.scroll);
        },

        scroll: function(e) {
            $('[parallax]').each(function(){

                var $this = $(this),
                    $speed = $this.data('speed') || 6,
                    $window = $(window);

                // Scroll the background at var speed
                // the yPos is a negative value because we're scrolling it UP!
                var yPos = -($window.scrollTop() / $speed);

                // Put together our final background position
                var coords = 'center '+ yPos + 'px';

                // Move the background
                $this.css({ backgroundPosition: coords });

            });
        }
    };


    /**
     * NG.SmoothAnchors
     * Smoothly Scroll to Anchor ID
     * @type {Object}
     */
    NG.SmoothAnchors = {
        init: function() {
            this.bind();
        },

        bind: function() {
            $('a[href^=#]').on('click', this.scrollToSmooth);
        },

        scrollToSmooth: function(event) {
            if(location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'')
                && location.hostname == this.hostname
            ){
                var $target = $(this.hash);

                $target = $target.length && $target || $('[name=' + this.hash.slice(1) +']');

                if ($target.length)
                {
                    var targetOffset = $target.offset().top;
                    $('html,body').animate({scrollTop: targetOffset}, 600);

                    return false;
                }
            }
        }
    }



    /**
     * Tab Content
     * @type {Object}
     */
    NG.Tabs = {
        init: function() {
            $('.tabs__nav').on('click touchstart', 'a', this.switchTab)
        },

        switchTab: function(event) {
            event.preventDefault();

            var $this = $(this),
                tab   = $($this.attr('href'));

            $this.parent()
                 .addClass('active')
                 .siblings()
                 .removeClass('active');

            tab.addClass('active')
               .siblings()
               .removeClass('active');

            NG.Sidebar.toggle($this);
        }
    }


    /* ---------------------------------------------------------------------
    Slick Slider
    ------------------------------------------------------------------------ */

	NG.SlickSlider = {
		init: function()
		{
			if($('.slick-slider').length) {
				this.bind();
			}
		},

		bind: function()
		{

			$('.slick-slider').slick({
			  autoplay: true,
			  arrows: false,
			  dots: true,
			  infinite: true,
			  autoplaySpeed: 6000,
			  speed: 500,
			  fade: true,
			  cssEase: 'linear',
			  adaptiveHeight: true
			});

            $('.recent-slider').slick({
              autoplay: false,
              arrows: true,
              dots: false,
              infinite: true,
              slidesToShow: 4,
              slidesToScroll: 4
            });
			
			 $('.recent-slider2').slick({
              autoplay: false,
              arrows: true,
              dots: false,
              infinite: true,
              slidesToShow: 4,
              slidesToScroll: 4,
			  responsive: [ {
			   breakpoint: 480,
				  settings: {
					slidesToShow: 1,
					slidesToScroll: 1
				  }
			 }
			  ]
            });

		},

	};  // NG. Slick Slider End
	
	
	/* ---------------------------------------------------------------------
        Mainobile - Main Nav Toggles
        ------------------------------------------------------------------------ */
        $('#menu-primary').after('<span class="main-menu-toggle icon-menu"></span>');

        $('.main-menu-toggle').click( function() {
            $('#menu-primary').toggleClass('active');
        });

        /* ---------------------------------------------------------------------
            Mobile - Subnav Menu Toggles
        ------------------------------------------------------------------------ */
        $('.nav--primary li.menu-item-has-children > a, .nav--primary li.menu-item-type-custom > a, .menu--tools .menu li.menu-item-has-children > a, .industry-menu > ul > li.menu-item-has-children > a').after('<span class="sub-menu-toggle icon-chevron-thin-down desk--hide"></span>');


        $('.sub-menu-toggle').click( function() {
            var $this = $(this),
                $parent = $this.parent("li"),
                $wrap = $parent.children(".sub-menu");
            $wrap.toggleClass("toggled");
            $parent.toggleClass("toggled");
            $this.toggleClass("toggled");
        });


    /**
     * Doc Ready
     */
    $(function() {

		NG.Menu.init();
        NG.Global.init();
        NG.ImAHuman.init();
		NG.SlickSlider.init();
        NG.Social.init();

    });

    return NG;
}(NG || {}, jQuery));