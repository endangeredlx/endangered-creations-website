/*$.noConflict();*/
$(document).ready(function(){
   //activate the lightbox
   jQuery("a[rel^='prettyPhoto']").prettyPhoto({ theme: "light_square" });
   Cufon.replace('.entry h2, h1.pageTitle, .entry_single_title', { fontFamily : 'LeagueGothic' });
   setTimeout( 'doFadeIn()', 3000 );
});

var doFadeIn = function()
{
   $('.bigPicFade').fadeOut(1500);
   $('#featureslider').aviaSlider();
};

