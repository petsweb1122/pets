$(function () {
    $(".left-menu").click(function () {
        if ($(this).hasClass("open")) {
            $(this).removeClass("open");
            $(".mobile-navigation-panel").removeClass("active");
            $(".wrap-panel-navigation").hide();
            $("body").css("position", "unset");
            $('body').css('overflow-y','scroll');
        } else {
            $(this).addClass("open");
            $(".wrap-panel-navigation").show();
            $(".mobile-navigation-panel").addClass("active");
            // $("body").height() < $(window).height()
            //     ? $("body").css("position", "unset")
            //     : $("body").css("position", "fixed");
            $('body').css('overflow-y','hidden');
        }
    });

    $(".close-navigation-panel , .wrap-panel-navigation").click(function () {
        $(".left-menu").removeClass("open");
        $(".policies-button").removeClass("open");
        $(".filter-button").removeClass("open");
        $(".categories-button").removeClass("open");
        $(".wrap-panel-navigation").hide();
        $(".mobile-navigation-panel").removeClass("active");
        $(".mobile-policies-panel").removeClass("active");
        $(".mobile-filter-panel").removeClass("active");
        $(".mobile-categories-panel").removeClass("active");
        $("body").css("position", "unset");
        $('body').css('overflow-y','scroll');
        //$('.mobile-filters-panel').removeClass('active');
        $('.m-size-guide-panel').removeClass('active');
        $(".wrap-panel-navigation").hide();
    });

    $('.main-search-button').click(function(){
        if($('.search-filter-main').hasClass('hide')){
            $('.search-filter-main').removeClass('hide');
        }else{
            $('.search-filter-main').addClass('hide');
        }
    });
});
