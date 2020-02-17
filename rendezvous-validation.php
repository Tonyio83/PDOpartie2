<?php
$formSubmitted = false;
$regexDate = '/^((20)[2-9][0-9])-(0[1-9]|1[0-2])-(0[1-9]|[12][0-9]|3[01])$/';
$regexTime = '/^([1][0-9]||[0][8-9]):([0-5][0-9])$/';
$errors = [];
$patient = $date = $time = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $formSubmitted = true;
    $patient = trim(filter_input(INPUT_POST,'patient',FILTER_SANITIZE_NUMBER_INT));
    if (empty($patient)) {
        $errors['patient'] = 'Veuillez selectionner un patient';
    } elseif (!filter_input(INPUT_POST, 'patient', FILTER_VALIDATE_INT)) {
        $errors['patient'] = 'Votre pays n\'existe pas !';
    }
    $date = trim(htmlspecialchars($_POST['dateAppointment']));
    if (empty($date)) {
        $errors['dateAppointment'] = 'Veuillez renseigner la date de rendez-vous';
    } elseif (!preg_match($regexDate, $date)) {
        $errors['dateAppointment'] = 'Veuillez renseigner une date valide !';
    }
    $time = trim(htmlspecialchars($_POST['timeAppointment']));
    if (empty($time)) {
        $errors['timeAppointment'] = 'Veuillez renseigner un horaire de rendez-vous';
    } elseif (!preg_match($regexTime, $time)) {
        $errors['timeAppointment'] = 'Veuillez renseigner un valide !';
    }
}