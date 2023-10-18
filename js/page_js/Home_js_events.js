//javascript events for this page go here//
let showMFImg = x => {
	console.log('in');
  	x.style.visibility = "hidden";
}
let hideMFImg = x => {
	console.log('out');
  	x.style.visibility = "visible";
}
$('#myModal').on('shown.bs.modal', function () {
  $('#myInput').trigger('focus')
});

$( document ).ready(function() {
$('.carousel').carousel();
$(function() {
    $('.carousel.lazy').bind('slide.bs.carousel', function (e) {
        var image = $(e.relatedTarget).find('img[data-src]');
        image.attr('src', image.data('src'));
        image.removeAttr('data-src');
    });
});
  
  const observer = lozad('.lozad', {
    rootMargin: '10px 0px', // syntax similar to that of CSS Margin
    threshold: 0.1 // ratio of element convergence
});
  
     const backgroundObserver = lozad('.lozad-background', {
        threshold: 0.1
    })
  
  
  observer.observe();
  backgroundObserver.observe();
  
  
      console.log( "ready!" );
});

/* Code that was already here, so if it breaks maybe check this! */
$('.slick').slick({
  infinite: true,
  slidesToShow: 4,
  slidesToScroll: 4,
    responsive: [
      {
        breakpoint: 500,
        settings: {
        slidesToShow: 1,
        slidesToScroll: 1,
        }
      }
    ]
});

 $('a[data-slide]').click(function(e) {
   e.preventDefault();
   var slideno = $(this).data('slide');
   $('.slider-nav').slick('slickGoTo', slideno - 1);
 });
$('.autoplay').slick({
  slidesToScroll: 1,
  autoplay: true,
  autoplaySpeed: 2000,
});

/* particlesJS.load(@dom-id, @path-json, @callback (optional)); */
particlesJS.load('particles-js', 'js/particles.json', function() {
  console.log('callback - particles.js config loaded');
});
