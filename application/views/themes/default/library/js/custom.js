$(document).ready(function(){
    $('#tiger_banner').aviaSlider({animationSpeed:5000});
    Cufon.replace('#menu li a, .video_area_text, #slider .feature_excerpt strong, .entry > a h1, a.read_more, .client_item', { fontFamily : 'LeagueGothic' });
    $('#recent_videos ul li img').hover(function(){ $(this).stop().animate({opacity:0.2}, 400); }, function(){ $(this).stop().animate({opacity: 1}, 400); });
});
