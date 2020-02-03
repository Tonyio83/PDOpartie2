<?php
include 'header.php';
include 'validation.php';

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
$req = $db->prepare('SELECT * FROM `patients` WHERE `lastname` = ?');
$req->execute(array($_GET['nom']));
$patient = $req->fetch();
if ($formSubmitted && count($errors) == 0) {
    $db = connectDb();
    $modifPatients = $db->prepare('UPDATE `patients` SET lastname = :lastname, firstname = :firstname, birthdate = :birthdate, phone = :phone, mail = :mail WHERE id = :id');
    $modifPatients->execute(array(
        'id' => $_GET['id'],
        'lastname' => $lastname,
        'firstname' => $firstname,
        'birthdate' => $birthdate,
        'phone' => $phone,
        'mail' => $mail
    ));
    ?>
    <p class="text-center display-4">Les modifications ont bien été enregistrées !</p>
<?php } else { ?>
    <div class="container">
        <div class="justify-content-center row">
            <div class="col-6 border border-primary rounded p-5">
                <div class="justify-content-center row">            
                    <span class="display-1 col-2"><i class="fa fa-user" aria-hidden="true"></i></span>
                    <h2 class="text-center my-5 col-6">Profil Patient</h2>
                </div>
                <form method="post" novalidate>
                    <div class="form-group row">
                        <label for="lastname" class="col-sm-2 col-form-label col-form-label-lg font-weight-bold">Nom</label>
                        <div class="col-sm-10">
                            <input type="text"class="form-control form-control-lg" name="lastname" id="lastname" value="<?= $patient['lastname'] ?>" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="firstname" class="col-sm-2 col-form-label col-form-label-lg font-weight-bold">Prénom</label>
                        <div class="col-sm-10">
                            <input type="text"class="form-control form-control-lg" name="firstname" id="firstname" value="<?= $patient['firstname'] ?>" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="birthdate" class="col-sm-2 col-form-label col-form-label-lg font-weight-bold">Date de naissance</label>
                        <div class="col-sm-10">
                            <input type="date" class="form-control form-control-lg" name="birthdate" id="birthdate" value="<?= $patient['birthdate'] ?>" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="phone" class="col-sm-2 col-form-label col-form-label-lg font-weight-bold">Téléphone</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control form-control-lg" name="phone" id="phone" value="<?= $patient['phone'] ?>" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="mail" class="col-sm-2 col-form-label col-form-label-lg font-weight-bold">Email</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control form-control-lg" name="mail" id="mail" value="<?= $patient['mail'] ?>" required>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-outline-primary float-right mt-4">Envoyer les modifications</button>
                </form>
            </div>
        </div>
    </div>
<?php
}
include 'footer.php';
