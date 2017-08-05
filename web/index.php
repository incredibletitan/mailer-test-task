<head>
    <script src="js/tinymce/tinymce.min.js"></script>
    <script>tinymce.init({ selector:'textarea' });</script>
</head>

<body>
<form enctype="multipart/form-data" method="POST">
     <input type="text" name="title"> <br/>
    <textarea name="body"></textarea> <br/>
    <input name="files[]" type="file" multiple="multiple"/><br/>
    <input name="sbn" type="submit" />
</form>
</body>



<?php


if (!isset($_POST['sbn'])) {
    return;
}

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
$mail->msgHTML($_POST['body']);
//Replace the plain text body with one created manually
$mail->AltBody = 'This is a plain-text message body';


if (isset($_FILES['files']) ){
    $factory = new FileUpload\FileUploadFactory(
        new FileUpload\PathResolver\Simple(__DIR__ . '/../uploads'),
        new FileUpload\FileSystem\Simple(),
        [
            new FileUpload\Validator\SizeValidator('3M')
        ]
    );

    $instance = $factory->create($_FILES['files'], $_SERVER);
    // Doing the deed
    list($files, $headers) = $instance->processAll();

    foreach($files as $file){
        if ($file->completed) {
            $mail->addAttachment($file->getRealPath());
        }
    }
}
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