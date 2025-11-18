<?php
/**
 * Simple PHP Email Form Library
 * Version : 1.1
 * Author  : Fanomezantsoa
 */

class PHP_Email_Form {
    public $to = '';
    public $from_name = '';
    public $from_email = '';
    public $subject = '';
    public $messages = array();
    public $ajax = false;
    public $smtp = false; // SMTP config array if needed

    /**
     * Ajouter un champ au message
     * @param string $content Contenu du champ
     * @param string $label Étiquette (facultative)
     * @param bool|int $newline Ajouter un saut de ligne après
     */
    public function add_message($content, $label = '', $newline = true) {
        $entry = ($label ? "$label: " : '') . $content;
        if ($newline) {
            $entry .= "\n";
        }
        $this->messages[] = $entry;
    }

    /**
     * Envoi du mail
     * @return string "OK" si réussi, sinon message d'erreur
     */
    public function send() {
        // Vérification des champs obligatoires
        if (empty($this->to) || empty($this->from_email) || empty($this->subject)) {
            return "ERROR: Missing required fields";
        }

        $email_text = implode("", $this->messages);

        // Construction des headers
        $headers  = "From: " . $this->from_name . " <" . $this->from_email . ">\r\n";
        $headers .= "Reply-To: " . $this->from_email . "\r\n";
        $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

        // Si SMTP est configuré
        if ($this->smtp && is_array($this->smtp)) {
            return $this->send_via_smtp($email_text, $headers);
        }

        // Sinon envoi via mail()
        if (mail($this->to, $this->subject, $email_text, $headers)) {
            return "OK";
        } else {
            return "ERROR: Unable to send email. Check your server configuration.";
        }
    }

    /**
     * Envoi via SMTP (optionnel)
     * @param string $body Contenu du mail
     * @param string $headers Headers
     * @return string Message d'erreur car non implémenté
     */
    private function send_via_smtp($body, $headers) {
        // Ici tu peux intégrer PHPMailer ou autre librairie SMTP
        return "ERROR: SMTP sending not implemented in this simple version.";
    }
}
?>