<?php

namespace bin\epaphrodite\api\email;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class send_mail
{

    private $mail;
    /**
     * *******************************************************************************************
     * Instantiation and passing `true` enables exceptions
     */
    function __construct()
    {
        $this->mail = new PHPMailer(true);
    }


    /**
     * *******************************************************************************************
     * email setting
     * @return void
     */
    private function settings()
    {

        try {

            $this->mail->SMTPDebug = SMTP::DEBUG_SERVER;
            $this->mail->isSMTP();
            $this->mail->Host       = 'smtp-fr.securemail.pro';
            $this->mail->SMTPAuth   = true;
            $this->mail->Username   = 'adresse_mail';
            $this->mail->Password   = 'mot_de_passe';
            $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $this->mail->Port       = 587;
            $this->mail->setFrom('ne-pas-repondre@epaphrodite.com', 'ADMINISTRATEUR EPAPHRODITE');

            return true;
        } catch (Exception $e) {

            return false;
        }
    }

    /**
     * *******************************************************************************************
     * Send messages
     *
     * @param array $contacts|null
     * @param string $msg_header|null
     * @param string $msg_content|null
     * @param string $file|null
     * @return void
     */
    public function send_email(?array $contacts = null, ?string $msg_header = null, ?string $msg_content = null, ?string $file = null)
    {

        if ($this->settings() === true) {
            //Recipients
            foreach ($contacts as $k => $value) {
                $this->mail->addAddress($contacts[$k]);
            }

            //$this->mail->addReplyTo('info@example.com', 'Information');
            //$this->mail->addCC('cc@example.com');
            //$this->mail->addBCC('bcc@example.com');

            // Attachments
            //$this->mail->addAttachment('/var/tmp/file.tar.gz');
            if ($file != null) {
                $this->mail->addAttachment(_DIR_FILES_, $file);
            }

            // Chrager le contenu du mail
            $this->content($msg_header, $msg_content);

            // Verifier l'envoi du mail
            if ($this->mail->send()) {
                return true;
            } else {

                return false;
            }
        }
    }

    /**
     * *******************************************************************************************
     * Get content of header and content of email
     *
     * @param string $msg_header
     * @param string $msg_content
     * @return void
     */
    private function content(string $msg_header, string $msg_content)
    {

        $this->mail->isHTML(true);
        $this->mail->Subject = $msg_header;
        $this->mail->Body    = $msg_content;
        //$this->mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    }
}
