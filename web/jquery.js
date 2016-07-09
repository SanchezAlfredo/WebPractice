/**
 * Created by Jyu Viole Grace on 6/15/2016.
 */

$(document).ready(function() {
    // Result texts
    var checking_html = 'Checking...';

    // When focus is lost on text box
    $('#userSignUp').focusout(function(){
        if($('#userSignUp').val().length >= 1){
            //show the checking_text and run the function to check
            $('#username_availability_result').html(checking_html);
            check_availability();
        }
    });
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
                $('#username_availability_result').show();
                $('#username_availability_result').html(username + ' is available');
            }else{
                // Show that the username is NOT available
                $('#username_availability_result').show();
                $('#username_availability_result').html(username + ' is not available');
            }
        });
}

