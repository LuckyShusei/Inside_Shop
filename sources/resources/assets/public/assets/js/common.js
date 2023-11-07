// JavaScript Document

$(function(){
objectFitImages();
});


/* SLIDER */
$(function(){
$('.slider ul').slick({
    autoplay:true,
    autoplaySpeed:4000,
    dots: false,
	fade: true,
	arrows: false,
});
});




/* js-scroll */
$(function(){
	$('.scroll').jScrollPane();
//	$('.info-scr').jScrollPane();
});



/* MATCHHEIGHT */
$(function(){
    $('.mh').matchHeight();
    $('.shopArea .itemBox .txtBody').matchHeight();
	//$('.shopArea .itemBox .txtBody .catch').matchHeight();
});



