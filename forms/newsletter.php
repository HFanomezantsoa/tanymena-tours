<?php
// chemin correct vers la librairie
$php_email_form = '../assets/vendor/php-email-form/php-email-form.php';

if (file_exists($php_email_form)) {
  include($php_email_form);
} else {
  die('Unable to load the "PHP Email Form" Library!');
}

// Adresse de réception
$receiving_email_address = 'tanymenatours97@gmail.com';

$contact = new PHP_Email_Form;
$contact->ajax = true;

$contact->to = $receiving_email_address;
$contact->from_name = "Newsletter Subscription";
$contact->from_email = $_POST['email'];
$contact->subject = "New Subscription: " . $_POST['email'];

// Ajoute le message
$contact->add_message($_POST['email'], 'Email');

echo $contact->send();
?>