$(function(){
    $('.images-container').click(function(){
        if($(this).hasClass('required')){
            $(this).removeClass('required');
            $(this).addClass('remove');
        }else if($(this).hasClass('remove')){
            $(this).removeClass('remove');
            $(this).addClass('required');
        }

    });
});
