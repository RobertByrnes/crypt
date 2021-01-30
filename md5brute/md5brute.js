$( document ).ready(function() {
    $('#hashGen-tab').show();
    $('#brute1-tab').hide();
    $('#brute2-tab').hide();
    $('#benchmark-tab').hide();

    $("#hashGen").click(function(){
        $('#brute1-tab').hide();
        $('#brute2-tab').hide();
        $('#benchmark-tab').hide();
        $('#hashGen-tab').show();
    });
    $("#brute1").click(function(){
        $('#hashGen-tab').hide();
        $('#brute2-tab').hide();
        $('#benchmark-tab').hide();
        $('#brute1-tab').show();
    });
    $("#brute2").click(function(){
        $('#hashGen-tab').hide();
        $('#brute1-tab').hide();
        $('#benchmark-tab').hide();
        $('#brute2-tab').show();
    });
    $("#bench").click(function(){
        $('#hashGen-tab').hide();
        $('#brute1-tab').hide();
        $('#brute2-tab').hide();
        $('#benchmark-tab').show();
    });
    $('.copyButton').click (function() {
        var text = document.getElementById('text').innerText;
        var elem = document.createElement("textarea");
        document.body.appendChild(elem);
        elem.value = text;
        elem.select();
        document.execCommand("copy");
        document.body.removeChild(elem);
    });
    $("#stringBrute").click(function(){
        var data = $('#stringBruteText').val();
        var hash = $('#SB_hashType').val();
        $.ajax({url: "ajaxRequest.php", type: "POST", data: {stringBrute: data, hashType: hash},  success: function(result){
            alert(result);
            // $("#stringBrute").html(result);
        }});
    });

});
