<?php
// Activer l'affichage des erreurs pour debug
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Adresse email qui reçoit le formulaire
$receiving_email_address = 'tanymenatours97@gmail.com';

// Chemin vers la librairie PHP_Email_Form
$php_email_form = '../assets/vendor/php-email-form/php-email-form.php';

if (!file_exists($php_email_form)) {
    die('Unable to load the "PHP Email Form" Library!');
}

include($php_email_form);

// Création de l'objet
$contact = new PHP_Email_Form;
$contact->ajax = true;

// Récupération sécurisée des champs POST
$contact->to = $receiving_email_address;
$contact->from_name  = isset($_POST['name']) ? htmlspecialchars($_POST['name']) : '';
$contact->from_email = isset($_POST['email']) ? filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) : '';
$contact->subject    = isset($_POST['subject']) ? htmlspecialchars($_POST['subject']) : 'No Subject';

// Ajout des messages
if (!empty($_POST['name']))    $contact->add_message(htmlspecialchars($_POST['name']), 'From');
if (!empty($_POST['email']))   $contact->add_message(htmlspecialchars($_POST['email']), 'Email');
if (!empty($_POST['phone']))   $contact->add_message(htmlspecialchars($_POST['phone']), 'Phone');
if (!empty($_POST['message'])) $contact->add_message(htmlspecialchars($_POST['message']), 'Message', 10);

// Envoi du mail et retour
echo $contact->send();
?>