<?php
include 'header.php';
include 'RDVvalidation.php';

$dateOfDay = date('Y-m-d');
$currentHours = date('H:i');
function connectDb() {
    require_once 'params.php';
    $dsn = 'mysql:dbname=' . DB . ';host=' . HOST;
    try {
        $db = new PDO($dsn, USER, PASSWORD);
        return $db;
    } catch (Exception $exc) {
        die('La connexion à la base de données a échoué !');
    }
}

$db = connectDb();
$query = 'SELECT `lastname`, `firstname`, `id` FROM `patients` ORDER BY `lastName` ASC';
$patientsQueryStat = $db->query($query);
$patientsList = $patientsQueryStat->fetchAll(PDO::FETCH_OBJ);
if ($formSubmitted && count($errors) == 0){
$req = $db->prepare('INSERT INTO appointments(idPatients, dateHour) VALUES(:idPatients, :dateHour)');
$req->execute(array(
	'idPatients' => $patient,
	'dateHour' => $date. ' ' .$time. ':00'
	));
?>
<p class="text-center display-4">Le rendez-vous a bien été enregistré</p>
<?php
}else{
?>
<div class="container my-4">
    <div class="row justify-content-center">
        <div class="col-6 border p-4">
            <h2 class="text-center my-5">Enregistrement nouveau rendez-vous</h2>
            <form class="needs-validation" method="post" action="#" novalidate>
                <div class="form-group">
                    <label for="patient">Patient</label>
                    <select class="form-control" id="patient" name="patient" required>
                        <option selected>Selectionnez un patient</option>
                        <?php foreach ($patientsList as $patient): ?>
                        <option value="<?= $patient->id ?>"><?= $patient->lastname. ' ' .$patient->firstname ?></option>
                        <?php endforeach ?>
                    </select>
                </div>
                <p>Date et Horaires de rendez-vous</p>
                    <div class="form-group row">
                        <label for="dateAppointment" class="col-sm-1 col-form-label">Date</label>
                        <input type="date" class="form-control col-3 ml-5" id="dateAppointment" min="<?= $dateOfDay ?>" max="2030-12-31" value="<?= $dateOfDay ?>" name="dateAppointment" required>
                        <label for="timeAppointment" class="col-sm-1 col-form-label">Horaire</label>
                        <input type="time" class="form-control col-2 ml-5" id="time" min="08:00" max="20:00" value="8:30" name="timeAppointment" required>
                    </div>
                <button type="submit" class="btn btn-outline-primary float-right my-4">Envoyer</button>
            </form>
        </div>
    </div>
</div>
<?php }