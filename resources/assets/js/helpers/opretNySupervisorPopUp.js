$( document ).ready(function() {
    $('.overlayMenu').click(function(target){
        $('.popUp-Opret').css('display','none');
        $('.overlayMenu').fadeOut(200);
        $('.overlayMenu').css("backgroundColor",'');
        $('.popUpContainer').css('display', 'block');
        $('.wrapper-section-popUp').css('display', 'none');
    });
});