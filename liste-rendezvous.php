<?php
include 'header.php';
function connectDb() {
    require_once 'params.php';
    $dsn = 'mysql:dbname=' . DB . ';host=' . HOST;
    try {
        $db = new PDO($dsn, USER, PASSWORD);
        return $db;
    } catch (Exception $ex) {
        die('La connexion à la base de données a échoué !');
    }
}
$db = connectDb();
$query = 'SELECT DATE_FORMAT(`appointments`.`dateHour`, \'Le %d/%m/%Y à %k:%i\' ) AS dateHour, `appointments`.`id` AS `id` ,`patients`.`lastname` AS lastname, `patients`.`firstname` AS firstname '
        . 'FROM `patients` INNER JOIN `appointments` '
        . 'ON `patients`.`id` = `idPatients`';
$sth = $db->prepare($query);
$sth->execute();
$appointmentsList = $sth->fetchAll(PDO::FETCH_ASSOC);
?>
<h2 class="text-center my-4 ">Liste des rendez-vous</h2>
<div class="row justify-content-center">
    <table class="table table-striped table-bordered col-8">
        <thead class="thead-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Date de rendez-vous</th>
                <th scope="col">Patient</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($appointmentsList as $idAppointment => $appointment):
            ?>
        <tr>
            <td><?= $appointment['id'] ?></td>
            <td><?= $appointment['dateHour'] ?></td>
            <td><?= $appointment['lastname']. ' ' .$appointment['firstname'] ?></td>         
        </tr>
            <?php
            endforeach
            ?>
        </tbody>
    </table>
</div>
<div class="justify-content-center d-flex">
    <a href="ajout-patient.php" class="btn btn-lg btn-primary">Ajouter un rendez-vous</a>
</div>
<?php
include 'footer.php';