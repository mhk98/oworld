$(function () {

// slider 1
$('.slider1').slick({
  slidesToShow: 5,
  slidesToScroll: 1,
  autoplay: false,
  arrows: true,
  prevArrow: '.left',
  nextArrow: '.right',
  dots: false,
  speed: 2000,
  autoplaySpeed: 3500,
  centerPadding: '20px',
  responsive: [
    {
      breakpoint: 1930,
      settings: {
        slidesToShow: 8,
        slidesToScroll: 2,
        infinite: true,
        centerMode: false, // You can choose to enable or disable centerMode based on your design
      }
    },
    {
      breakpoint: 1600,
      settings: {
        slidesToShow: 6,
        slidesToScroll: 1,
        infinite: true,
        centerMode: false,
      }
    },
    {
      breakpoint: 1224,
      settings: {
        slidesToShow: 4,
        slidesToScroll: 1,
        infinite: true,
        centerMode: false,
      }
    },
    {
      breakpoint: 991,
      settings: {
        slidesToShow: 5,
        slidesToScroll: 1,
        centerMode: true,
        centerPadding: '20px', // Adjust the gap between items
      }
    },
    {
      breakpoint: 830,
      settings: {
        slidesToShow: 4,
        slidesToScroll: 2,
        centerMode: true,
        centerPadding: '20px',
      }
    },
    {
      breakpoint: 480,
      settings: {
        slidesToShow: 3,
        slidesToScroll: 1,
        centerMode: true,
        centerPadding: '20px',
      }
    }
  ]
});


  // slider 2
  $('.slider2').slick({
    slidesToShow: 1,
    slidesToScroll: 1,
    autoplay: true,
    arrows: true,
    prevArrow: '.left2',
    nextArrow: '.right2',
    dots: true,
    speed: 2000,
    autoplaySpeed: 3500,

  });

});