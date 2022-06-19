$(function () {
    $(".policies-button").click(function () {
        if ($(this).hasClass("open")) {
            $(this).removeClass("open");
            $(".mobile-policies-panel").removeClass("active");
            $(".wrap-panel-navigation").hide();
            $("body").css("position", "unset");
            $('body').css('overflow-y','scroll');
        } else {
            $(this).addClass("open");
            $(".wrap-panel-navigation").show();
            $(".mobile-policies-panel").addClass("active");
            // $("body").height() < $(window).height()
            //     ? $("body").css("position", "unset")
            //     : $("body").css("position", "fixed");
            $('body').css('overflow-y','hidden');
        }
    });



    $(".categories-button").click(function () {
        if ($(this).hasClass("open")) {
            $(this).removeClass("open");
            $(".mobile-categories-panel").removeClass("active");
            $(".wrap-panel-navigation").hide();
            $("body").css("position", "unset");
            $('body').css('overflow-y','scroll');
        } else {
            $(this).addClass("open");
            $(".wrap-panel-navigation").show();
            $(".mobile-categories-panel").addClass("active");
            // $("body").height() < $(window).height()
            //     ? $("body").css("position", "unset")
            //     : $("body").css("position", "fixed");
            $('body').css('overflow-y','hidden');
        }
    });



    $(".filter-button").click(function () {
        if ($(this).hasClass("open")) {
            $(this).removeClass("open");
            $(".mobile-filter-panel").removeClass("active");
            $(".wrap-panel-navigation").hide();
            $("body").css("position", "unset");
            $('body').css('overflow-y','scroll');
        } else {
            $(this).addClass("open");
            $(".wrap-panel-navigation").show();
            $(".mobile-filter-panel").addClass("active");
            // $("body").height() < $(window).height()
            //     ? $("body").css("position", "unset")
            //     : $("body").css("position", "fixed");
            $('body').css('overflow-y','hidden');
        }
    });
    $(".categories-panel-filter").click(function () {
        if ($(this).hasClass("open")) {
            $(this).removeClass("open");
            $(".mobile-categories-panel").removeClass("active");
            $(".wrap-panel-navigation").hide();
            $("body").css("position", "unset");
            $('body').css('overflow-y','scroll');
        } else {
            $(this).addClass("open");
            $(".wrap-panel-navigation").show();
            $(".mobile-categories-panel").addClass("active");
            // $("body").height() < $(window).height()
            //     ? $("body").css("position", "unset")
            //     : $("body").css("position", "fixed");
            $('body').css('overflow-y','hidden');
        }
    });

});
