<?php
include_once __DIR__ . '/../views/mail.php';

if (!isset($_POST['sbn'])) {
    return;
}
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../config.php';

$mail = new PHPMailer();
$mail->isSMTP();
$mail->Host = MAILER_HOST;
$mail->Port = MAILER_PORT;
$mail->SMTPSecure = MAILER_SMTP_SECURE;
$mail->SMTPAuth = MAILER_SMTP_AUTH;
$mail->Username = MAILER_AUTH_USERNAME;
$mail->Password = MAILER_AUTH_PASSWORD;
$mail->setFrom(MAILER_AUTH_USERNAME);
$mail->addAddress($_POST['mailto']);
$mail->Subject =$_POST['title'];
$mail->msgHTML($_POST['body']);

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

if (!$mail->send()) {
    echo "Mailer Error: " . $mail->ErrorInfo;
} else {
    echo "Message sent!";
}