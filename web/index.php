<?php
require_once __DIR__ . '/../vendor/autoload.php';

//Create a new PHPMailer instance
$mail = new PHPMailer();
$mail->isSMTP();
$mail->SMTPDebug = 2;
$mail->Debugoutput = 'html';
$mail->Host = 'smtp.gmail.com';
$mail->Port = 587;
$mail->SMTPSecure = 'tls';
$mail->SMTPAuth = true;
$mail->Username = "100sbsh@gmail.com";
$mail->Password = "tqwpz3fE";
//Set who the message is to be sent from
$mail->setFrom('100sbsh@gmail.com', 'First Last');

//Set who the message is to be sent to
$mail->addAddress('100sbsh@gmail.com', 'John Doe');
//Set the subject line
$mail->Subject = 'PHPMailer GMail SMTP test';
//Read an HTML message body from an external file, convert referenced images to embedded,
//convert HTML into a basic plain-text alternative body
$mail->msgHTML('<h1>Hello guys</h1>', dirname(__FILE__));
//Replace the plain text body with one created manually
$mail->AltBody = 'This is a plain-text message body';
//Attach an image file
//send the message, check for errors
if (!$mail->send()) {
    echo "Mailer Error: " . $mail->ErrorInfo;
} else {
    echo "Message sent!";
    //Section 2: IMAP
    //Uncomment these to save your message in the 'Sent Mail' folder.
    #if (save_mail($mail)) {
    #    echo "Message saved!";
    #}
}