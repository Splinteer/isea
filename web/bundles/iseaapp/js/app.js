$(document).ready(function(){
    //Menu
    $("#trigger-overlay").on('click', function(){
        $('.overlay').addClass('open');
    });
    $(".overlay-close").on('click', function(){
        $('.overlay').removeClass('open');
    });

    $('#rapidAccess').hide();
    $('#rapidAccessButton').on('click', function(){
        $('#rapidAccess').fadeIn();
    });
    function scrollToID(id, speed){
        var offSet = 50;
        var targetOffset = $(id).offset().top - offSet;
        var mainNav = $('#main-nav');
        $('html,body').animate({scrollTop:targetOffset}, speed);
        if (mainNav.hasClass("open")) {
            mainNav.css("height", "1px").removeClass("in").addClass("collapse");
            mainNav.removeClass("open");
        }
    }
    if($.trim( $('#scrollTo').html() ).length) {
        scrollToID('#scrollTo', 750);
    }
});