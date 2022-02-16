$(document).ready(function () {
    console.log($('.copyright').position().top);
    $('.site-menubar').css('height', $('.copyright').position().top - $('.header').height());
});