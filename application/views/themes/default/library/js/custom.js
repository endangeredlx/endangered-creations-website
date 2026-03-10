$(document).ready(function(){
    $('#tiger_banner').aviaSlider({animationSpeed:5000});
    $('#recent_videos ul li img').hover(function(){ $(this).stop().animate({opacity:0.2}, 400); }, function(){ $(this).stop().animate({opacity: 1}, 400); });
});
