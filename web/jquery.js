/**
 * Created by Jyu Viole Grace on 6/15/2016.
 */

$(document).ready(function() {
    // Result texts
    var checking_html = 'Checking...';
    var available = false;
    var timer;
    var x;

    // After timer runs course checks username availability
    $("#userSignUp").keyup(function () {
        if (x) { x.abort() } // If there is an existing XHR, abort it.
        clearTimeout(timer); // Clear the timer so we don't end up with dupes.
        if($('#userSignUp').val().length >= 1) {
            $('#username_availability_result').html(checking_html);
            $('#username_availability_result').show();
            timer = setTimeout(function () { // assign timer a new timeout
                x = check_availability();// run ajax request and store in x variable (so we can cancel)
            }, 1000); // 2000ms delay, tweak for faster/slower
        }
    });

    //on username focus out shows check if username was valid
    $("#userSignUp").focusout(function () {
        //if available is true, username is available and add check upon focus out
        if (available) {
            $('#username_availability_result').hide();
            $('#valid_username').show();
        }else{
            $('#valid_username').hide();
        }
    });

    //checks if email is valid
    $('#emailSignUp').bind("keyup focusout", function(){
        if($('#emailSignUp').val().length >= 1) {
            if (check_email_req($('#emailSignUp').val())) {
                $('#invalid_email').hide();
                $('#valid_email').show();
                console.log("valid email");
            }
            else {
                $('#valid_email').hide();
                $('#invalid_email').show();
                console.log("invalid email");
            }
        }
    });

    //checks if password fulfills requirements
    $('#passSignUp').keyup(function(){
        if($('#passSignUp').val().length >= 1) {
            if (check_pass_req($('#passSignUp').val())) {
                $('#invalid_pass').hide();
                $('#valid_pass').show();
                console.log("valid pass");
            }
            else {
                $('#valid_pass').hide();
                $('#invalid_pass').show();
                console.log("invalid pass");
            }
        }
    });

    //shows password reqs on pass focus
    $('#passSignUp').focus(function(){
        $('#pswd_info').show();
    });

    //hides password reqs on focus out
    $('#passSignUp').focusout(function(){
        $('#pswd_info').hide();
    });

    //checks if password confirm matches password
    $('#passSignUpConfirm').keyup(function(){
        if($('#passSignUpConfirm').val().length >= 1) {
            if ($('#passSignUp').val() !== $('#passSignUpConfirm').val()) {
                $('#valid_passConfirm').hide();
                $('#invalid_passConfirm').show();
                console.log("invalid pass confirm");
            }
            else {
                $('#invalid_passConfirm').hide();
                $('#valid_passConfirm').show();
                console.log("valid pass confirm");
            }
        }
    });

    //validates sign up info, upon error doesn't allow submission and alerts
    $('#signUpSubmit').click(function(eSubmit) {
        var str = '';
        if (!available) {
            console.log("Username is not available");
            str += 'Username is not available\n';
        }

        if (!check_pass_req($('#passSignUp').val())) {
            console.log("Password does not meet requirements");
            str += 'Password does not meet requirements\n';
        }

        if (!check_email_req($('#emailSignUp').val())) {
            console.log("invalid email");
            str += 'Invalid email\n';
        }

        if ($('#passSignUp').val() !== $('#passSignUpConfirm').val()) {
            console.log("detected different passwords");
            str += 'Passwords do not match\n';
        }

        if (str !== '') {
            alert(str);
            eSubmit.preventDefault();
            return false;
        }
    });

    // Function to check username availability
    function check_availability(){
        // Get the username
        var username = $('#userSignUp').val();

        console.log('CHECKING USERNAME OF: '+ username);
        // Use ajax to run the check
        $.post("username_check.php", { username: username }, function(result){
            // If the result is 1
            console.log('RESULT OF REQUEST: '+ result);
            if(result == true){
                // Show that the username is available
                available = true;
                $('#username_availability_result').html(username + ' is available');
            }else{
                // Show that the username is NOT available
                $('#username_availability_result').html(username + ' is not available');
            }
        });
    }

    //checks if password is valid
    function check_pass_req(pass){
        var r1 = /[a-z]/; //uppercase
        var r2 = /[A-Z]/; //lowercase
        var r3 = /[0-9]/; //numbers
        var r4 = /\W/; // 'special char'

        if(r1.test(pass) < 1) return false;
        if(r2.test(pass) < 1) return false;
        if(r3.test(pass) < 1) return false;
        if(r4.test(pass) < 1) return false;

        return true;
    }

    //rudimentary email regex to check if email is valid
    function check_email_req(email){
        var testEmail = /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i;
        if (testEmail.test(email)){
            return true;
        }

        return false;
    }

});




