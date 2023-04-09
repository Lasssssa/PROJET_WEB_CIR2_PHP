<?php 
    session_start();
      if($_SESSION['identifiedAdmin'] == false || !isset($_SESSION['identifiedAdmin'])){
        header("Location: ../loginAdmin.php");
        exit;
      }
?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <link rel="shortcut icon" href="../images/favicon.ico" type="image/x-icon">
        <title>Page Administrateur </title>
        <link href="stylePersoAdmin.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
        <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@300&display=swap" rel="stylesheet">
        <script src="../script.js"></script>
    </head>
    
    <!-- A réadapter -->

    <body>
        <div id="header">
            <div id="logo">
                <a href ="persoAdmin.php"><img src="../images/logoIsen.png" alt="logo" width ="190px"></a>
            </div>
            <div id="enseignant">
                <a href="addingEnseignant.php">Enseignants</a>
            </div>
            <div id="etudiant">
                <a href="addingEtudiant.php">Étudiants</a>
            </div>
            <div id="cours">
                <a href="addingCours.php">Cours</a>
            </div>
            <div>
            
            </div>
            <div id="account">
            <?php echo '<div id="info"><a href="infoAdmin.php">'.$_SESSION['prenom'][0].'.'.$_SESSION['nom'].'    <span class="material-symbols-outlined">account_circle</span></a></div>'; ?>
            </div>
            <div id="deconnexion">
                <a href="../loginAdmin.php"><span class="material-symbols-outlined">logout</span></a>
            </div>
        </div>
        <div id ="board">
            <a href="addingEnseignant.php">Ajout</a>
            <a href="modifyEnseignant.php">Modification</a>
        </div>

        <?php
            if(isset($_POST['envoyer']) && isset($_POST['prenom']) && isset($_POST['nom']) && isset($_POST['email']) && isset($_POST['emailConfirmed']) && isset($_POST['password']) && isset($_POST['passwordConfirmed']) && isset($_POST['telephone'])){
                if($_POST['email']!= $_POST['emailConfirmed']){
                    echo '<div class="alert alert-danger" role="alert">
                    Les emails ne correspondent pas
                    </div>';
                }
                else if($_POST['password']!= $_POST['passwordConfirmed']){
                    echo '<div class="alert alert-danger" role="alert">
                    Les mots de passe ne correspondent pas
                    </div>';
                }
                else{
                    $prenom = $_POST['prenom'];
                    $nom = $_POST['nom'];
                    $email = $_POST['email'];
                    $telephone = $_POST['telephone'];
                    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
                    require_once('../database.php');
                    $db = dbConnect();
                    $isAddedProfessor = addProfessor($db, $prenom, $nom, $email, $password, $telephone);
                    if($isAddedProfessor){
                        echo '<div class="alert alert-success" role="alert">
                        L\'enseignant a bien été ajouté
                        </div>';
                    }
                    else{
                        echo '<div class="alert alert-danger" role="alert">
                        L\'enseignant n\'a pas été ajouté car il existe déjà ou il y a eu une erreur
                        </div>';
                    }
                }
            }
        ?>

        <div id="mainAdding">
            <div id="formAdding">
                <h2>Ajout d'un enseignant</h2>
                <form action="addingEnseignant.php" method="post">
                    <div class="row">
                        <div class="col">
                            <h4>Prénom</h4>
                            <input type="text" class="form-control" name ="prenom">
                        </div>
                        <div class="col">
                            <h4>Nom</h4>
                            <input type="text" class="form-control" name ="nom">
                        </div>
                    </div>
                    <br>
                    <div class="form-row">
                        <div class="form-group">
                            <h4>Email</h4>
                            <input type="email" class="form-control" id="inputEmail4" name ="email">
                            <h4>Confirmation email</h4>
                            <input type="email" class="form-control" id="inputEmail4" name ="emailConfirmed">
                        </div>
                        <br>
                        <div class="form-group">
                            <h4>Mot de passe</h4>
                            <input type="password" class="form-control" id="password" name="password">
                            <div class="form-check form-switch" id="ecarted">
                                <input class="form-check-input" type="checkbox" role="switch" id="showPassword" onchange="togglePassword()">
                                <label class="form-check-label" for="flexSwitchCheckChecked">Afficher votre mot de passe</label>
                            </div>
                            <h4>Confirmation mot de passe</h4>
                            <input type="password" class="form-control" id="password2" name="passwordConfirmed">
                            <div class="form-check form-switch" id="ecarted">
                                <input class="form-check-input" type="checkbox" role="switch" id="showPassword2" onchange="togglePassword2()">
                                <label class="form-check-label" for="flexSwitchCheckChecked">Afficher votre mot de passe</label>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col">
                            <h4>Numéro de téléphone</h4>
                            <input type="number" class="form-control" name = "telephone">
                        </div>
                    </div>
                    <br>
                    <button type="submit" class="btn btn-primary" name ="envoyer">Inscrire un nouvel enseignant</button>
                </form>
            </div>
        </div>
    </body>
</html>