/*$.noConflict();*/
$(document).ready(function(){
   //activate the lightbox
   jQuery("a[rel^='prettyPhoto']").prettyPhoto({ theme: "light_square" });
   $('#featureslider').aviaSlider();
   Cufon.replace('.entry h2, .entry_single_title', { fontFamily : 'LeagueGothic' });
});


