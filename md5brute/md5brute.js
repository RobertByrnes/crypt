$( document ).ready(function() {
    $('#hashGen-tab').show();
    $('#brute1-tab').hide();
    $('#brute2-tab').hide();

    $("#hashGen").click(function(){
        $('#brute1-tab').hide();
        $('#brute2-tab').hide();
        $('#hashGen-tab').show();
    });
    $("#brute1").click(function(){
        $('#hashGen-tab').hide();
        $('#brute2-tab').hide();
        $('#brute1-tab').show();
    });
    $("#brute2").click(function(){
        $('#hashGen-tab').hide();
        $('#brute1-tab').hide();
        $('#brute2-tab').show();
    });
});