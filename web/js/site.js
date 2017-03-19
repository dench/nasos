$(function(){
    $('.block-link').click(function(){
        document.location.href = $(this).find('a').attr('href');
    });
});