<?php 
function sanitize_my_email($field) {
    $field = filter_var($field, FILTER_SANITIZE_EMAIL);
    if (filter_var($field, FILTER_VALIDATE_EMAIL)) {
        return true;
    } else {
        return false;
    }
}
$to_email = 'edgar.guzman21@gmail.com';
$subject = 'Testing PHP Mail';
$message = 'This mail is sent using the PHP mail from domain capitaldieselsas.com';
$headers = 'From: noreply@capitaldieselsas.com';
//check if the email address is invalid $secure_check
$secure_check = sanitize_my_email($to_email);
if ($secure_check == false) {
    echo "Invalid input";
} else { //send email 
    mail($to_email, $subject, $message, $headers);
    echo $message;
}
?>