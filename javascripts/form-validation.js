/**
 * Created by lkudo on 24/02/17.
 */

$(document).ready(function ($) {

    // hide messages
    $(".error").hide();
    $(".success").hide();

    $('#contactForm input').click(function (e) {
        $(".error").fadeOut();
    });

    // on submit...
    $("#contactForm #submit").click(function () {
        $(".error").hide();

        //required:

        //name
        var name = $("input#InputName").val();
        if (name == "") {
            //$("#error").fadeIn().text("Name required.");
            $('#fname').fadeIn('slow');
            $("input#InputName").focus();
            return false;
        }

        //email (check if entered anything)
        var email = $("input#InputEmail").val();
        //email (check if entered anything)
        if (email == "") {
            //$("#error").fadeIn().text("Email required");
            $('#fmail').fadeIn('slow');
            $("input#InputEmail").focus();
            return false;
        }

        //email (check if email entered is valid)

        if (email !== "") {  // If something was entered
            if (!isValidEmailAddress(email)) {
                $('#fmail').fadeIn('slow'); //error message
                $("input#email").focus();   //focus on email field
                return false;
            }
        }

        function isValidEmailAddress(emailAddress) {
            var pattern = new RegExp(/^(("[\w-+\s]+")|([\w-+]+(?:\.[\w-+]+)*)|("[\w-+\s]+")([\w-+]+(?:\.[\w-+]+)*))(@((?:[\w-+]+\.)*\w[\w-+]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][\d]\.|1[\d]{2}\.|[\d]{1,2}\.))((25[0-5]|2[0-4][\d]|1[\d]{2}|[\d]{1,2})\.){2}(25[0-5]|2[0-4][\d]|1[\d]{2}|[\d]{1,2})\]?$)/i);
            return pattern.test(emailAddress);
        };
        // comments
        var comments = $("#InputMessage").val();

        if (comments == "") {
            //$("#error").fadeIn().text("Email required");
            $('#fmsg').fadeIn('slow');
            $("input#InputMessage").focus();
            return false;
        }

        var postdata = $('#contactForm').serialize();
        $.ajax({
            type: 'POST',
            url: 'php/sendmail.php',
            data: postdata,
            dataType: 'json',
            success: function (json) {
                if (json.nameMessage != '') {
                    $('#InputName').append(' - <span class="status"> ' + json.nameMessage + '</span>');
                }
                if (json.emailMessage != '') {
                    $('#InputEmail').append(' - <span class="status"> ' + json.emailMessage + '</span>');
                }
                if (json.messageMessage != '') {
                    $('#InputMessage').append(' - <span class="status"> ' + json.messageMessage + '</span>');
                }
                if (json.nameMessage == '' && json.emailMessage == '' && json.messageMessage == '') {
                    $('input[type="text"],textarea').val('');
                    alert("E-mail enviado com sucesso.");
                }
            }
        });
        return false;
    });


    // on success...
    function success() {
        $("#success").fadeIn();
        $("#contactForm").fadeOut();
    }

    return false;
});

