
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
    $('#checkurl-tab').hide();

    // hashGen tab
    $("#hashGen-selector").click(function(){
        $('#copyButton').hide();
        $('#md5Brute-tab').hide();
        $('#hashBrute-tab').hide();
        $('#benchmark-tab').hide();
        $('#checkurl-tab').hide();
        $('#hashGen-tab').show();
        $('#inputString').focus();
        $('#hashMessage').hide();
        $('#stringHashed').hide();
    });

    // md5Brute tab
    $("#md5Brute-selector").click(function(){
        $('#hashGen-tab').hide();
        $('#hashBrute-tab').hide();
        $('#benchmark-tab').hide();
        $('#checkurl-tab').hide();
        $('.working').hide();
        $('#md5Brute-tab').show();
        $('#md5hash').focus();
        $('#md5Message').hide();
        $('.script-axe').hide();
        $('#md5axe').hide();
    });

    // hashBrute tab
    $("#hashBrute-selector").click(function(){
        $('#hashGen-tab').hide();
        $('#md5Brute-tab').hide();
        $('#benchmark-tab').hide();
        $('#checkurl-tab').hide();
        $('.working').hide();
        $('#hashBrute-tab').show();
        $('#hashBrute_input').focus();
        $('#hashBrute_message').hide();
        $('#hashBrute_string').hide();
        $('.script-axe').hide();
        $('#bruteaxe').hide();
    });

    // benchmark server tab
    $("#benchmark-selector").click(function(){
        $('#hashGen-tab').hide();
        $('#md5Brute-tab').hide();
        $('#hashBrute-tab').hide();
        $('#checkurl-tab').hide();
        $('#benchmark-tab').show();
        $('#targetTime').focus();
        $('#benchmark_message').hide();
        $('#targetTime_used').hide();
    });

    // URL checkout tab
    $("#checkurl-selector").click(function(){
        $('#copyButton2').hide();
        $('#hashGen-tab').hide();
        $('#md5Brute-tab').hide();
        $('#hashBrute-tab').hide();
        $('#benchmark-tab').hide();
        $('#checkurl-tab').show();
        $('#url').focus();
        $('.working').hide();
        $('#progressbar_checkurl').hide();
        $('#checkurlMessage').hide();
        $('#checkurl_div').hide();
    });

    // copy text to clipboard
    $('.copyButton').click (function() {
        if('#hashGen_div' == 'selected') {
            var text = document.getElementById('hashGen_div').innerText;
        } else {
            var text = document.getElementById('checkurl_div').innerText;
        }
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
        $.ajax({url: "assets/includes/ajaxRequest.php", type: "POST", data: {inputString: data, hashType: hashType},  success: function(result){
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
        $('#md5axe').show();
        $('#md5brute_submit').hide();
        $('#md5Message').hide();
        $('#md5brute_div').hide();
        $('#hashUsed').hide();
        var data = $('#md5hash').val();
        var timeLimit = $('#timeLimit').val();
        $.ajax({url: "assets/includes/ajaxRequest.php", type: "POST", data: {md5hash: data, timeLimit: timeLimit},  success: function(result){
            $('#md5Message').show();
            $("#hashUsed").html(data).show();
            $("#md5brute_div").html(result).show();
            $('#md5brute_submit').show();
            $('.working').hide();
            $('.script-axe').hide();
            $('#md5axe').show();
        }});
    });

    // hash Brute submission
    $("#stringBrute").click(function(event){
        event.preventDefault();
        $('.working').show();
        $('.script-axe').show();
        $('#bruteaxe').show();
        $('#stringBrute').hide();
        $('#hashBrute_message').hide();
        $('#hashBrute_div').hide();
        var data = $('#hashBrute_input').val();
        var hash = $('#SB_hashType').val();
        var timedBrute = $('#timedBrute').val();
        $.ajax({url: "assets/includes/ajaxRequest.php", type: "POST", data: {hashBrute: data, timedBrute: timedBrute, hashType: hash},  success: function(result){
            $('#hashBrute_message').show();
            $("#hashBrute_div").html(result).show();
            $('.working').hide();
            $('#stringBrute').show();
            $('.script-axe').hide();
            $('#bruteaxe').hide();
        }});
    });

    // Benchmark Server submission
    $("#benchmark_submit").click(function(event){
        event.preventDefault();
        var maxlen = $('#maxlen').val();
        var targetTime = $('#targetTime').val();
        $.ajax({url: "assets/includes/ajaxRequest.php", type: "POST", data: {maxlen: maxlen, targetTime: targetTime},  success: function(result){
            $('#benchmark_message').show();
            $("#targetTime_used").html(targetTime).show();
            $("#benchmark_div").html(result);
        }});
    });

    // URL checkout submission
    $("#checkurl").click(function(event){
        event.preventDefault();
        $('#checkurlMessage').hide();
        $('#checkurl').hide();
        $('#checkurl_div').hide();
        $('.working').show();
        $('#progressbar_checkurl').show();
        var url = $('#url').val();
        var filename = $('#filename').val();
        $.ajax({url: "assets/includes/ajaxRequest.php", type: "POST", data: {url: url, filename: filename},  success: function(result){
            $('.working').hide();
            $('#progressbar_checkurl').hide();
            $('#checkurlMessage').show();
            $('#checkurl').show();
            $('#checkurl_div').html(result).show();
            $('#copyButton2').show();
        }});
    });

    // killSwitch - stop execution of a long process
    $(".script-axe").click(function(event){
        event.preventDefault();
        var message = 'kill';
        $.ajax({url: "assets/includes/killswitch.php", type: "POST", data: {message: message},  success: function(result){
            alert(result);
        }});
        window.location.reload();
    });

});