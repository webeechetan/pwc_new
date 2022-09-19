AOS.init({
    duration: 1200,
    once: true
});
$(window).on('load', function () {
    AOS.refresh();
});

// Animated Counters
var a = 0;
/*
$(window).scroll(function () {
    var oTop = $('.counters').offset().top - window.innerHeight;
    if (a == 0 && $(window).scrollTop() > oTop) {
        $('.counters-value').each(function () {
            var $this = $(this),
                countTo = $this.attr('data-count');
            $({
                countNum: $this.text()
            }).animate({
                    countNum: countTo
                },
                {
                    duration: 2000,
                    easing: 'swing',
                    step: function () {
                        $this.text(Math.floor(this.countNum));
                    },
                    complete: function () {
                        $this.text(this.countNum);
                        //alert('finished');
                    }

                });
        });
        a = 1;
    }
});
*/

// Slick Slider
$('.events').slick({
    slidesToShow: 3,
    slidesToScroll: 1,
    dots: true,
    arrows: false,
    responsive: [
        {
            breakpoint: 992,
            settings: {
              arrows: false,
              centerMode: true,
              centerPadding: '150px',
              slidesToShow: 1
            }
        },
        {
            breakpoint: 768,
            settings: {
              arrows: false,
              centerMode: true,
              centerPadding: '70px',
              slidesToShow: 1
            }
        },
        {
            breakpoint: 576,
            settings: {
              arrows: false,
              centerMode: true,
              centerPadding: '30px',
              slidesToShow: 1
            }
        }
    ]
});

// Sidebar
$(document).ready(function () {
	$(".has-dropdown").click(function () {
		$(this).toggleClass("open");
	});
	$("#filter").click(function () {
		$(this).toggleClass("open");
		$('.sidebar-inner').toggleClass("open");
	});
});
$(document).ready(function () {
	var path = window.location.href;
	$('#main-nav ul li a').each(function () {
		if (this.href === path) {
			$(this).addClass('active');
		}
	});
});