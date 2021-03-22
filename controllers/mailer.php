<?php

declare(strict_types=1);

namespace Controllers;

require 'C:\xampp\composer\vendor\autoload.php';
final class Mailer
{
    function sendMail(string $destination, string $subject, string $body): void
    {
        $mail = new \PHPMailer\PHPMailer\PHPMailer(TRUE);

        /* Open the try/catch block. */
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->Port = 587;
            $mail->SMTPAuth = true;
            $mail->SMTPSecure = 'tls';

            /* Username (email address). */
            $mail->Username = 'maturskimatovicljubomir@gmail.com';

            /* Google account password. */
            $mail->Password = 'dbowbwbwktxqebuc';
            /* Set the mail sender. */
            $mail->setFrom('maturskimatovicljubomir@gmail.com', 'Ljubomir');

            /* Add a recipient. */
            $mail->addAddress($destination);

            /* Set the subject. */
            $mail->Subject = $subject;

            /* Set the mail message body. */
            $mail->Body = $body;

            /* Finally send the mail. */
            $mail->send();
        } catch (\PHPMailer\PHPMailer\Exception $e) {
            /* PHPMailer exception. */
            echo $e->errorMessage();
        } catch (\Exception $e) {
            /* PHP exception (note the backslash to select the global namespace Exception class). */
            echo $e->getMessage();
        }
    }
}
