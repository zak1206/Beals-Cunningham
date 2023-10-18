$(function(){

    $.ajax({
        url: 'inc/mods/caffeine_chat/client.php?chataction=getchat',
        cache:false,
        success:function(chat){
            $('body').append(chat);
            $(".basecht").on('mouseover',function(){
                $(this).removeClass('bounceIn').addClass('pulse');
            })

            $(".basecht").on('mouseout',function(){
                $(this).removeClass('pulse').addClass('bounceIn');
            })
        }
    })


})