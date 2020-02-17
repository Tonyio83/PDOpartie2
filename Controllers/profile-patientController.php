<?php
require_once '../Models/Patient.php';
if (empty($_GET['idPatient']) || !filter_input(INPUT_GET, 'idPatient', FILTER_VALIDATE_INT)) {
  header ('location: liste-patientsController.php');
  exit();
}
$patient = new Patient();
$patient->id = filter_input(INPUT_GET, 'idPatient', FILTER_SANITIZE_NUMBER_INT);
if (!$patient->getOneById()){
    echo 'Ce patient n\'existe pas';
    $sleep = 5;
  header('Refresh:'. $sleep .';http://www.pdopartie2.com/Controllers/liste-patientsController.php');
}
require_once '../Views/profile-patient.php';


