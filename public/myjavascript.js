
$("#choix3").css('display', 'none');
$("#choix4").css('display', 'none');
$("#choix5").css('display', 'none');

$("#addchoice4").css('display', 'none');
$("#addchoice5").css('display', 'none');

$("#addchoice3").click(function() {
    $(this).css('display', 'none');
    $("#choix3").css('display', 'block');
    $("#addchoice4").css('display', 'inline');
});
$("#addchoice4").click(function() {
    $(this).css('display', 'none');
    $("#choix4").css('display', 'block');
    $("#addchoice5").css('display', 'inline');
});
$("#addchoice5").click(function() {
    $(this).css('display', 'none');
    $("#choix5").css('display', 'block');
});
