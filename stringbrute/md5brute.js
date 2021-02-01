
$( document ).ready(function() {
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })
    // tab handling
    $('#hashGen-tab').show();
    $('#inputString').focus();
    $('#hashMessage').hide();
    $('#stringHashed').hide();
    $('#md5Brute-tab').hide();
    $('#hashBrute-tab').hide();
    $('#benchmark-tab').hide();
    $('#copyButton').hide();

    $("#hashGen-selector").click(function(){
        $('#copyButton').hide();
        $('#md5Brute-tab').hide();
        $('#hashBrute-tab').hide();
        $('#benchmark-tab').hide();
        $('#hashGen-tab').show();
        $('#inputString').focus();
        $('#hashMessage').hide();
        $('#stringHashed').hide();
    });

    $("#md5Brute-selector").click(function(){
        $('#hashGen-tab').hide();
        $('#hashBrute-tab').hide();
        $('#benchmark-tab').hide();
        $('.working').hide();
        $('#md5Brute-tab').show();
        $('#md5hash').focus();
        $('#md5Message').hide();
        $('.script-axe').hide();
    });

    $("#hashBrute-selector").click(function(){
        $('#hashGen-tab').hide();
        $('#md5Brute-tab').hide();
        $('#benchmark-tab').hide();
        $('.working').hide();
        $('#hashBrute-tab').show();
        $('#hashBrute_input').focus();
        $('#hashBrute_message').hide();
        $('#hashBrute_string').hide();
        $('.script-axe').hide();
    });

    $("#benchmark-selector").click(function(){
        $('#hashGen-tab').hide();
        $('#md5Brute-tab').hide();
        $('#hashBrute-tab').hide();
        $('#benchmark-tab').show();
        $('#targetTime').focus();
        $('#benchmark_message').hide();
        $('#targetTime_used').hide();
    });

    // copy text to clipboard
    $('.copyButton').click (function() {
        var text = document.getElementById('hashGen_div').innerText;
        var elem = document.createElement("textarea");
        document.body.appendChild(elem);
        elem.value = text;
        elem.select();
        document.execCommand("copy");
        document.body.removeChild(elem);
    });

    // #hashGen submission
    $("#hashGen_submit").click(function(event){
        event.preventDefault();
        var data = $('#inputString').val();
        var hashType = $('#hashType').val();
        $.ajax({url: "ajaxRequest.php", type: "POST", data: {inputString: data, hashType: hashType},  success: function(result){
            $('#hashMessage').show();
            $('#stringHashed').html(data).show();
            $("#hashGen_div").html(result);
            $('#copyButton').show();
        }});
    });

    // md5 Brute submission
    $("#md5brute_submit").click(function(event){
        event.preventDefault();
        $('.working').show();
        $('.script-axe').show();
        $('#md5brute_submit').hide();
        $('#md5Message').hide();
        $('#md5brute_div').hide();
        $('#hashUsed').hide();
        var data = $('#md5hash').val();
        var timeLimit = $('#timeLimit').val();
        $.ajax({url: "ajaxRequest.php", type: "POST", data: {md5hash: data, timeLimit: timeLimit},  success: function(result){
            $('#md5Message').show();
            $("#hashUsed").html(data).show();
            $("#md5brute_div").html(result).show();
            $('#md5brute_submit').show();
            $('.working').hide();
            $('.script-axe').hide();

        }});
    });

    // hash Brute submission
    $("#stringBrute").click(function(event){
        event.preventDefault();
        $('.working').show();
        $('.script-axe').show();
        $('#stringBrute').hide();
        $('#hashBrute_message').hide();
        $('#hashBrute_div').hide();
        var data = $('#hashBrute_input').val();
        var hash = $('#SB_hashType').val();
        $.ajax({url: "ajaxRequest.php", type: "POST", data: {hashBrute: data, hashType: hash},  success: function(result){
            $('#hashBrute_message').show();
            $("#hashBrute_div").html(result).show();
            $('.working').hide();
            $('#stringBrute').show();
            $('.script-axe').hide();
        }});
    });

    // Benchmark Server submission
    $("#benchmark_submit").click(function(event){
        event.preventDefault();
        var targetTime = $('#targetTime').val();
        $.ajax({url: "ajaxRequest.php", type: "POST", data: {targetTime: targetTime},  success: function(result){
            $('#benchmark_message').show();
            $("#targetTime_used").html(targetTime).show();
            $("#benchmark_div").html(result);
        }});
    });

    // Benchmark Server submission
    $("#script-axe").click(function(event){
        event.preventDefault();
        window.location.href = window.location.href
    });
});