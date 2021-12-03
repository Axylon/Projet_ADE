<?php
if(isset($_POST['valider'])){
    if(!empty($_POST['prenom']) && !empty($_POST['nom'])){
        $prenom = $_POST['prenom'];
        $nom = $_POST['nom'];
        setCookie('prenom',$prenom);
        setCookie('nom',$nom);
        header("Location: admin.php");
    }
}else{
    echo "Veuillez completer tout les champs requis";
}
?>

<!DOCTYPE html>
<head>
<title>Accueil</title>
</head>
<body>

    <form method="POST" action="">
        <label for="prenom"> Prenom </label>
        <input type="text" name="prenom" placeholder="Ton Prenom">
        <br><br>
        <label for="nom"> Nom </label>
        <input type="nom" name="nom" placeholder="Ton Nom">
        <br><br>
        <input type="submit" name="valider">
    </form>

</body>