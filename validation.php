<?php
$formSubmitted = false;
$regexName = '/^[A-Za-zéÉ][A-Za-záàâäãåçéèêëíìîïñóòôöõúùûüýÿæœ]+((-| )[A-Za-záàâäãåçéèêëíìîïñóòôöõúùûüýÿæœ]+)?$/';
$regexDate = '/^((?:19|20)[0-9]{2})-(0[1-9]|1[0-2])-(0[1-9]|[12][0-9]|3[01])$/';
$regexPhone = "/^0[1-7](\.[0-9]{2}){4}$/";
$errors = [];
$lastname = $firstname = $birthdate = $phone = $mail = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $formSubmitted = true;
    $lastname = trim(filter_input(INPUT_POST, 'lastname', FILTER_SANITIZE_STRING));
    if (empty($lastname)) {
        $errors['lastname'] = 'Veuillez renseigner votre nom';
    } elseif (!preg_match($regexName, $lastname)) {
        $errors['lastname'] = 'Votre nom contient des caractères non autorisés !';
    }
    $firstname = trim(filter_input(INPUT_POST, 'firstname', FILTER_SANITIZE_STRING));
    if (empty($firstname)) {
        $errors['firstname'] = 'Veuillez renseigner votre prénom';
    } elseif (!preg_match($regexName, $firstname)) {
        $errors['firstname'] = 'Votre prénom contient des caractères non autorisés !';
    }
    $birthdate = trim(htmlspecialchars($_POST['birthdate']));
    if (empty($birthdate)) {
        $errors['birthdate'] = 'Veuillez renseigner votre date de naissance';
    } elseif (!preg_match($regexDate, $birthdate)) {
        $errors['birthdate'] = 'Le format n\'est pas valide !';
    }
    $phone = trim(htmlspecialchars($_POST['phone']));
    if (empty($phone)) {
        $errors['phone'] = 'Veuillez renseigner votre téléphone';
    } elseif (!preg_match($regexPhone, $phone)) {
        $errors['phone'] = 'Le numéro de téléphone n\'est pas valide!';
    }
    $mail = trim(htmlspecialchars($_POST['mail']));
    if (empty($mail)) {
        $errors['mail'] = 'Veuillez renseigner votre email';
    } elseif (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
        $errors['mail'] = 'L\' email  n\'est pas valide!';
    }
}