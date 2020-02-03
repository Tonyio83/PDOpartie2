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
$query = 'SELECT * FROM `patients`';
$patientsQueryStat = $db->query($query);
$patientsList = $patientsQueryStat->fetchAll(PDO::FETCH_ASSOC);
?>
<h2 class="text-center my-4 ">Liste des patients</h2>
<div class="row justify-content-center">
    <table class="table table-striped table-bordered col-8">
        <thead class="thead-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Nom</th>
                <th scope="col">Prénom</th>
                <th scope="col">Profil</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($patientsList as $patient):
            ?>
        <tr>
            <td><?= $patient['id'] ?></td>
            <td><?= $patient['lastname'] ?></td>
            <td><?= $patient['firstname'] ?></td>
            <td><a href="profil-patient.php?id=<?= $patient['id'] ?>&amp;nom=<?= $patient['lastname'] ?>&amp;prénom=<?= $patient['firstname'] ?>"class="btn btn-sm btn-primary" >Voir le profil</a></td>          
        </tr>
            <?php
            endforeach
            ?>
        </tbody>
    </table>
</div>
<div class="justify-content-center d-flex">
    <a href="ajout-patient.php" class="btn btn-lg btn-primary">Ajouter des patients</a>
</div>
<?php
include 'footer.php';