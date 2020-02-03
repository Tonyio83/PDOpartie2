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
if ($formSubmitted && count($errors) == 0){
$db =connectDb();
$req = $db->prepare('INSERT INTO patients(lastname, firstname, birthdate, phone, mail) VALUES(:lastname, :firstname, :birthdate, :phone, :mail)');
$req->execute(array(
	'lastname' => $lastname,
	'firstname' => $firstname,
	'birthdate' => $birthdate,
	'phone' => $phone,
	'mail' => $mail
	));
?>
<p class="text-center display-4">Le patient a bien été enregistré</p>
<?php
}else{
?>
<div class="container my-4">
    <div class="row justify-content-center">
        <div class="col-6 border p-4">
            <h2 class="text-center my-5">Enregistrement nouveau patient</h2>
            <form class="needs-validation" method="post" action="#" novalidate>
                <div class="form-group">
                    <label for="lastname">Nom</label>
                    <input type="text" class="form-control" name="lastname" id="lastname" placeholder="Dupont" required>
                    <span class="invalid-feedback"><?= ($errors['lastname']) ?? '' ?></span>
                </div>
                <div class="form-group">
                    <label for="firstname">Prénom</label>
                    <input type="text" class="form-control" name="firstname" id="firstname" placeholder="Jean" required>
                    <span class="invalid-feedback"><?= ($errors['firstname']) ?? '' ?></span>             
                </div>
                <div class="form-group">
                    <label for="birthdate">Date de naissance</label>
                    <input type="date" class="form-control" name="birthdate" id="birthdate" required>
                    <span class="invalid-feedback"><?= ($errors['birthdate']) ?? '' ?></span>
                </div>
                <div class="form-group">
                    <label for="phone">Téléphone</label>
                    <input type="text" class="form-control" name="phone" id="phone" placeholder="06.55.88.66.54" required>
                    <span class="invalid-feedback"><?= ($errors['phone']) ?? '' ?></span>
                </div>
                <div class="form-group">
                    <label for="mail">Email</label>
                    <input type="text" class="form-control" name="mail" id="mail" placeholder="dupont.jean@exemple.com" required>
                    <span class="invalid-feedback"><?= ($errors['mail']) ?? '' ?></span>
                </div>
                <button type="submit" class="btn btn-outline-primary float-right my-2">Envoyer</button>
            </form>
        </div>
    </div>
</div>
<?php
}
include 'footer.php';
