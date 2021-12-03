<!DOCTYPE html>
<head>
    <title>Accueil</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="styles.css">
    <script src="script.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <section id="bonjour">
        <?php
            try {
                $bdd = new PDO('sqlite:EDTbis.db');     
            } catch(Exception $e) {
                die('Erreur : ' . $e->getMessage());
            }
            if (isset($_COOKIE['nom']) && isset($_COOKIE['prenom'])){
                $nom = $_COOKIE['nom'];
                $prenom = $_COOKIE['prenom'];
                echo "<p> Bonjour monsieur ".$nom." ".$prenom." </p>";
            } else {
                echo "Bonjour cher inconnu";
            }
        ?>
    </section>

    <!--<section id="ajouter">-->
    <div class="container-fluid">
        <div class="row">
            <div class="col-md">
                <select id = "selectAjout" onchange="selectAjout()">
                    <option value="promotion">Ajouter une promotion</option>
                    <option value="user">Ajouter un user</option>
                    <option value="matiere">Ajouter une matiere</option>
                    <option value="salle">Ajouter une salle</option>
                    <option value="crenaux">Ajouter un crenaux</option>
                </select>

                <select id = "selectAffiche" onchange="selectAffiche()">
                    <option value="">N'affiche rien</option>
                    <option value="affiche_cours">Affiche tous les cours</option>
                </select>

                <form id="recup_semaineX" method="POST">
                    <select name = "semaineX">
                        <option value="0"> Semaine du 08/03/2021 </option>
                        <option value="7"> Semaine du 15/03/2021 </option>
                    </select>
                </form>
            </div>

        <!-- Partie Promotion -->
            <?php
                if(isset($_POST['valider_promo'])){
                    if(!empty($_POST['nom_promo']) && !empty($_POST['eleve_dep'])){
                        $nom_promo = $_POST['nom_promo'];
                        $eleve_dep = $_POST['eleve_dep'];
                        $requete = $bdd ->prepare("INSERT INTO Promotion (nom_promo,departement) VALUES (?,?)");
                        $requete->execute([$nom_promo,$eleve_dep]);
                        header('Location:admin.php');
                    }
                }
            ?>

            <?php
                if(isset($_POST['clear_promo'])){
                    $clearPromotion = $bdd->query('DELETE FROM Promotion');
                }
            ?>

            <div class="col-md">
                <form id = "promotion" method="POST" action="">
                    <label for = "nom_promo"> Nom de la promo </label>
                    <input type="text" name = "nom_promo" placeholder="Nom de la promo">
                    <br><br>
                    <label for = "eleve_dep"> Choisis le département </label>
                    <select name = "eleve_dep">
                        <option value = "math">Math</option>
                        <option value = "info">Info</option>
                        <option value = "SVT">SVT</option>
                        <option value = "chimie">Chimie</option>
                    </select>
                    <br><br>
                    <input type="submit" name="valider_promo">
                    <input value ="clear" type = "submit" name = "clear_promo">
                </form>

                <!-- Partie User -->
                <?php
                    if(isset($_POST['valider_user'])){
                        if(!empty($_POST['nom_user']) && !empty($_POST['prenom_user']) && !empty($_POST['mdp_user']) && !empty($_POST['usager']) ){
                            $nom_user = $_POST['nom_user'];
                            $prenom_user = $_POST['prenom_user'];
                            $mdp_user = $_POST['mdp_user'];
                            $usager = $_POST['usager'];
                            $promo_eleve = $_POST['promo_eleve'];
                            $requete = $bdd ->prepare("INSERT INTO User (nom,prenom,mdp,usager,promo) VALUES (?,?,?,?,?)");
                            $requete->execute([$nom_user,$prenom_user,$mdp_user,$usager,$promo_eleve]);
                            header('Location:admin.php');
                        }else{
                            echo "Veuillez completer tous les champs requis";
                        }
                    }
                ?>
                <?php
                    if(isset($_POST['clear_user'])){
                        $clearUser = $bdd->query('DELETE FROM User');
                    }
                ?>

                <form id = "user"  method = "POST" style="display:none" action = "">
                    <label for = "nom_user"> Nom de l'utilisateur* </label>
                    <input type = "text" name = "nom_user" placeholder = "Nom de l'utilisateur'">
                    <br><br>
                    <label for = "prenom_user"> Prenom de l'utilisateur* </label>
                    <input type = "text" name = "prenom_user" placeholder = "Prenom de l'utilisateur'">
                    <br><br>
                    <label for = "mdp_user"> Mdp de l'utilisateur* </label>
                    <input type = "text" name = "mdp_user" placeholder = "Mdp de l'utilisateur'">
                    <br><br>
                    <label for = "usager"> Usager* </label>
                    <select name = "usager">
                        <option value = "admin">Administrateur</option>
                        <option value = "enseignant">Enseignant</option>
                        <option value = "eleve">Eleve</option>
                    </select>
                    <br><br>
                    <label for = "promo_eleve"> Promo de l'élève </label>
                    <select name = "promo_eleve">
                    <?php
                        $recupPromo = $bdd->query('SELECT * FROM Promotion');
                        echo '<option value=\'\'> Pas de promo </option>';
                        while($result = $recupPromo->fetch()){
                            echo '<option value='.$result['id'].'>'.$result['nom_promo'].'</option>';
                        }
                    ?>
                    </select>
                    <br><br>

                    <input type = "submit" name = "valider_user">
                    <input value ="clear" type = "submit" name = "clear_user">
                    <br>
                </form>

                
                <!-- Partie Matière -->
                <?php
                    if(isset($_POST['valider_matiere'])){
                        if(!empty($_POST['nom_matiere']) && !empty($_POST['matiere_ens'])){
                            $nom_matiere = $_POST['nom_matiere'];
                            $matiere_ens = $_POST['matiere_ens'];
                            $color = '#F7F7F7';
                            if(!empty($_POST['matiere_color'])){
                                $color = $_POST['matiere_color'];
                            }
                            $requete = $bdd ->prepare("INSERT INTO Matiere (nom_matiere,enseignant,couleur) VALUES (?,?,?)");
                            $requete->execute([$nom_matiere,$matiere_ens,$color]);
                            header('Location:admin.php');
                        }
                    }
                ?>
                <?php
                    if(isset($_POST['clear_matiere'])){
                        $clearMatiere = $bdd->query('DELETE FROM Matiere');
                    }
                ?>

                <form id = "matiere" method = "POST" style="display:none" action = "">
                    <label for = "nom_matiere"> Nom de la matière </label>
                    <input type = "text" name = "nom_matiere" placeholder="Nom de la matière">
                    <br><br>
                    <label for = "matiere_ens"> Enseignant de la matière </label>
                    <select name = "matiere_ens">
                    <?php
                        $recupEnseignant = $bdd->query('SELECT * FROM User WHERE usager=\'enseignant\'');
                        while($result = $recupEnseignant->fetch()){
                            echo '<option value='.$result['id'].'>'.$result['nom'].'.'.$result['prenom'].'</option>';
                        }
                    ?>
                    </select>
                    <br><br>
                    <label for = "matiere_color"> couleur de la matière </label>
                    <input type = "color" name = "matiere_color" placeholder = "couleur de la matiere">
                    <br><br>
                    <input type = "submit" name = "valider_matiere">
                    <input value ="clear" type = "submit" name = "clear_matiere">
                </form>

                <!-- Partie Salle -->
                <?php
                    if(isset($_POST['valider_salle'])){
                        if(!empty($_POST['num_salle'])){
                            $num_salle = $_POST['num_salle'];
                            $requete = $bdd ->prepare("INSERT INTO Salle (numero) VALUES (?)");
                            $requete->execute([$num_salle]);
                            header('Location:admin.php');
                        }
                    }
                ?>
                <?php
                    if(isset($_POST['clear_salle'])){
                        $clearSalle = $bdd->query('DELETE FROM Salle');
                    }
                ?>
                <form id = "salle" method="POST" style="display:none" action="">
                    <label for="num_salle"> Numero de la salle </label>
                    <input type="text" name="num_salle" placeholder="Numero de la salle">
                    <br><br>
                    <input type="submit" name="valider_salle">
                    <input value ="clear" type = "submit" name = "clear_salle">
                </form>

                <!-- Partie Crenaux -->
                <?php
                    if(isset($_POST['valider_cre'])){
                        if(!empty($_POST['jour_cre']) && !empty($_POST['heure_deb']) && !empty($_POST['heure_fin']) && !empty($_POST['matiere_cre']) && !empty($_POST['promo_cre']) && !empty($_POST['salle_cre']) && !empty($_POST['ens_cre']) ){
                            $jour_cre = $_POST['jour_cre'];
                            $heure_deb = $_POST['heure_deb'];
                            $heure_fin = $_POST['heure_fin'];
                            $matiere_cre = $_POST['matiere_cre'];
                            $promo_cre = $_POST['promo_cre'];
                            $salle_cre = $_POST['salle_cre'];
                            $ens_cre = $_POST['ens_cre'];

                            $requete = $bdd ->prepare("INSERT INTO Crenaux (jour,heure_deb,heure_fin,matiere,promo,salle,enseignant) VALUES (?,?,?,?,?,?,?)");
                            $requete->execute([$jour_cre,$heure_deb,$heure_fin,$matiere_cre,$promo_cre,$salle_cre,$ens_cre]);
                        }else{
                            echo "Veuillez completer tous les champs requis";
                        }
                    }
                ?>

                <form id = "crenaux" method="POST"  style="display:none" action="">
                    <label for="jour_cre"> Jour du cours </label>
                    <input type="date" name="jour_cre" placeholder="Jour du cours">
                    <br><br>
                    <label for="heure_deb"> Heure de début </label>
                    <input type="time" name="heure_deb" placeholder="Heure de début">
                    <br><br>
                    <label for="heure_fin"> Heure de fin </label>
                    <input type="time" name="heure_fin" placeholder="Heure de fin">
                    <br><br>
                    <label for="matiere_cre"> Matière </label>
                    <select name="matiere_cre">
                        <?php
                            $recupEnseignant = $bdd->query('SELECT * FROM Matiere');
                            while($result = $recupEnseignant->fetch()){
                                echo '<option value='.$result['id'].'>'.$result['nom_matiere'].'</option>';
                            }
                        ?>
                    </select>
                    <br><br>
                    <label for="promo_cre"> Promo </label>
                    <select name="promo_cre">
                        <?php
                            $recupEnseignant = $bdd->query('SELECT * FROM Promotion');
                            while($result = $recupEnseignant->fetch()){
                                echo '<option value='.$result['id'].'>'.$result['nom_promo'].'</option>';
                            }
                        ?>
                    </select>
                    <br><br>
                    <label for="salle_cre"> Salle </label>
                    <select name="salle_cre">
                        <?php
                            $recupEnseignant = $bdd->query('SELECT * FROM Salle');
                            while($result = $recupEnseignant->fetch()){
                                echo '<option value='.$result['id'].'>'.$result['numero'].'</option>';
                            }
                        ?>
                    </select>
                    <br><br>
                    <label for="ens_cre"> Enseignant </label>
                    <select name="ens_cre">
                        <?php
                            $recupEnseignant = $bdd->query('SELECT * FROM User WHERE usager=\'enseignant\'');
                            while($result = $recupEnseignant->fetch()){
                                echo '<option value='.$result['id'].'>'.$result['nom'].'.'.$result['prenom'].'</option>';
                            }
                        ?>
                    </select>
                    <br><br>
                    <input type="submit" name="valider_cre">
                    <input value ="clear" type = "submit" name = "clear_crenaux">
                </form>
                <?php
                    if(isset($_POST['clear_crenaux'])){
                        $clearCrenaux = $bdd->query('DELETE FROM Crenaux where id >= 0');
                    }
                ?>
            </div>
        </div>
    </div>
    <!--</section>-->
    <?php /*
        //teste des tables
        echo "Table test <br>";
        $recupAdmin = $bdd->query('SELECT * FROM Crenaux WHERE jour = \'08-03-2021\'');
        while($result = $recupAdmin->fetch()){
            $new_jour = DateTime::createFromFormat('d-m-Y',$result['jour']);
            $new_semaine = DateTime::createFromFormat('d-m-Y',$result['jour']);
            $new_semaine->modify('+7 day');
            echo 'Cours num '.$result['id'].' de : '.$result["matiere"].'<br>';
            echo 'Il se déroule le '.$new_jour->format('d-m-Y').'et la semaine d\'après ce sera le '.$new_semaine->format('d-m-Y');
            //$new_heure_deb = DateTime::createFromFormat('H:i',$result['heure_deb']);    
            //$test_h = DateTime::createFromFormat('H:i','10:00');
            //if ($new_heure_deb < $test_h){
                //echo 'de'.$new_heure_deb->format("H:i").' à '.$result['heure_fin'].'<br>';
            //} else {
               
            //}
        } */
        /*$recupLundi = $bdd->query('SELECT * FROM Crenaux');
        while($result = $recupLundi->fetch()){
        $new_hd = DateTime::createFromFormat('H:i',$result['heure_deb']);
        //$tnew_hd = strtotime($new_hd->format('H:i'),"%H:%M");
        $new_hf = DateTime::createFromFormat('H:i',$result['heure_fin']);
        $day = DateTime::createFromFormat('Y-m-d',$result['jour']);

        $duree = date_diff($new_hf,$new_hd);
        $duree_sec = $duree->format('%H')*60*60 + $duree->format('%i')*60;
        //echo 'looool : '.$result['jour']. '<br>';
        //echo $duree->get_class();
        //$duree = ($new_hf-$new_hd).total_seconds();
        //echo $duree_sec.'<br>';
        echo $result["matiere"].' : le '.$day->format('Y-m-d'). ' de '.$new_hd->format('H:i').' à '.$new_hf->format('H:i').'<br>';
        }*/

    ?>

    <section id = "affiche_EDT">
        <div class="EDT">
            <table>
                <tr>
                <TH> Heure </TH> 
                <TH> Lundi </TH> 
                <TH> Mardi </TH> 
                <TH> Mercredi </TH> 
                <TH> Jeudi </TH>
                <TH> Vendredi </TH> 
            
                </tr>
                <td id = "heure">
                </td>
                <td class = "jour_semaine" id = "lundi">
                    
                </td>
                <td class = "jour_semaine" id = "mardi ">
                
                </td>
                <td class = "jour_semaine" id = "mercredi">
                
                </td>
                <td class = "jour_semaine" id = "jeudi">
                
                </td>
                <td class = "jour_semaine" id = "vendredi">
                
                </td>
            </table>


            <?php
                //Jour de référence !
                $lundi = DateTime::createFromFormat('Y-m-d','2021-03-08');
                $mardi = DateTime::createFromFormat('Y-m-d','2021-03-09');
                $mercredi = DateTime::createFromFormat('Y-m-d','2021-03-10');
                $jeudi = DateTime::createFromFormat('Y-m-d','2021-03-11');
                $vendredi = DateTime::createFromFormat('Y-m-d','2021-03-12');
                //$value = $_POST['semaineX'];
                //echo $value;
            ?>


            <div id="affiche_cours" class="box_cours"  style='position:absolute; display:none'>
                <div id="cours1">
                    <?php 
                        $recupLundi = $bdd->query('SELECT * FROM Crenaux c, Matiere m,User u WHERE c.matiere = m.id AND c.enseignant=u.id AND jour =\''.$lundi->format('Y-m-d').'\'');
                        while($result = $recupLundi->fetch()){
                            $heure_8 = DateTime::createFromFormat('H:i','8:00');
                            $new_hd = DateTime::createFromFormat('H:i',$result['heure_deb']);
                            //$tnew_hd = strtotime($new_hd->format('H:i'),"%H:%M");
                            $new_hf = DateTime::createFromFormat('H:i',$result['heure_fin']);
                            $day = DateTime::createFromFormat('Y-m-d',$result['jour']);
                            $duree = date_diff($new_hf,$new_hd);
                            $duree_sec = ($duree->format('%H')*60*60 + $duree->format('%i')*60)*400/37800;
                            $dif_marge_top = date_diff($new_hd,$heure_8);
                            $marge_top = ($dif_marge_top->format('%H')*60*60 + $dif_marge_top->format('%i')*60)*400/37800;
                            echo '<div class=\'lundi1\' style="top:'.$marge_top.'px; height:'.$duree_sec.'px; background-color:'.$result['couleur'].'">';
                            echo $result["nom_matiere"].'<br>'.$new_hd->format('H:i').' à '.$new_hf->format('H:i').'<br>'.$result['nom'];
                            echo '</div>';
                        }
                    ?>
                </div>

                <div id="cours2">
                    <?php 
                        $recupMardi = $bdd->query('SELECT * FROM Crenaux c, Matiere m,User u WHERE c.matiere = m.id AND c.enseignant=u.id AND jour =\''.$mardi->format('Y-m-d').'\'');
                        while($result = $recupMardi->fetch()){
                            $heure_8 = DateTime::createFromFormat('H:i','8:00');
                            $new_hd = DateTime::createFromFormat('H:i',$result['heure_deb']);
                            //$tnew_hd = strtotime($new_hd->format('H:i'),"%H:%M");
                            $new_hf = DateTime::createFromFormat('H:i',$result['heure_fin']);
                            $day = DateTime::createFromFormat('Y-m-d',$result['jour']);
                            $duree = date_diff($new_hf,$new_hd);
                            $duree_sec = ($duree->format('%H')*60*60 + $duree->format('%i')*60)*400/37800;
                            $dif_marge_top = date_diff($new_hd,$heure_8);
                            $marge_top = ($dif_marge_top->format('%H')*60*60 + $dif_marge_top->format('%i')*60)*400/37800;
                            echo '<div class=\'mardi1\' style="top:'.$marge_top.'px; height:'.$duree_sec.'px; background-color:'.$result['couleur'].'">';
                            echo $result["nom_matiere"].'<br>'.$new_hd->format('H:i').' à '.$new_hf->format('H:i').'<br>'.$result['nom'];
                            echo '</div>';
                        }
                    ?>
                </div>

                <div id="cours3">
                    <?php 
                        $recupMercredi = $bdd->query('SELECT * FROM Crenaux c, Matiere m,User u WHERE c.matiere = m.id AND c.enseignant=u.id AND jour =\''.$mercredi->format('Y-m-d').'\'');
                        while($result = $recupMercredi->fetch()){
                            $heure_8 = DateTime::createFromFormat('H:i','8:00');
                            $new_hd = DateTime::createFromFormat('H:i',$result['heure_deb']);
                            //$tnew_hd = strtotime($new_hd->format('H:i'),"%H:%M");
                            $new_hf = DateTime::createFromFormat('H:i',$result['heure_fin']);
                            $day = DateTime::createFromFormat('Y-m-d',$result['jour']);
                            $duree = date_diff($new_hf,$new_hd);
                            $duree_sec = ($duree->format('%H')*60*60 + $duree->format('%i')*60)*400/37800;
                            $dif_marge_top = date_diff($new_hd,$heure_8);
                            $marge_top = ($dif_marge_top->format('%H')*60*60 + $dif_marge_top->format('%i')*60)*400/37800;
                            echo '<div class=\'mercredi1\' style="top:'.$marge_top.'px; height:'.$duree_sec.'px; background-color:'.$result['couleur'].'">';
                            echo $result["nom_matiere"].'<br>'.$new_hd->format('H:i').' à '.$new_hf->format('H:i').'<br>'.$result['nom'];
                            echo '</div>';
                        }
                    ?>
                </div>

                <div id="cours4">
                    <?php 
                        $recupJeudi = $bdd->query('SELECT * FROM Crenaux c, Matiere m,User u WHERE c.matiere = m.id AND c.enseignant=u.id AND jour =\''.$jeudi->format('Y-m-d').'\'');
                        while($result = $recupJeudi->fetch()){
                            $heure_8 = DateTime::createFromFormat('H:i','8:00');
                            $new_hd = DateTime::createFromFormat('H:i',$result['heure_deb']);
                            //$tnew_hd = strtotime($new_hd->format('H:i'),"%H:%M");
                            $new_hf = DateTime::createFromFormat('H:i',$result['heure_fin']);
                            $day = DateTime::createFromFormat('Y-m-d',$result['jour']);
                            $duree = date_diff($new_hf,$new_hd);
                            $duree_sec = ($duree->format('%H')*60*60 + $duree->format('%i')*60)*400/37800;
                            $dif_marge_top = date_diff($new_hd,$heure_8);
                            $marge_top = ($dif_marge_top->format('%H')*60*60 + $dif_marge_top->format('%i')*60)*400/37800;
                            echo '<div class=\'jeudi1\' style="top:'.$marge_top.'px; height:'.$duree_sec.'px; background-color:'.$result['couleur'].'">';
                            echo $result["nom_matiere"].'<br>'.$new_hd->format('H:i').' à '.$new_hf->format('H:i').'<br>'.$result['nom'];
                            echo '</div>';
                        }
                    ?>
                </div>

                <div id="cours5">
                    <?php 
                        $recupLundi = $bdd->query('SELECT * FROM Crenaux c, Matiere m,User u WHERE c.matiere = m.id AND c.enseignant=u.id AND jour =\''.$vendredi->format('Y-m-d').'\'');
                        while($result = $recupLundi->fetch()){
                            $heure_8 = DateTime::createFromFormat('H:i','8:00');
                            $new_hd = DateTime::createFromFormat('H:i',$result['heure_deb']);
                            //$tnew_hd = strtotime($new_hd->format('H:i'),"%H:%M");
                            $new_hf = DateTime::createFromFormat('H:i',$result['heure_fin']);
                            $day = DateTime::createFromFormat('Y-m-d',$result['jour']);
                            $duree = date_diff($new_hf,$new_hd);
                            $duree_sec = ($duree->format('%H')*60*60 + $duree->format('%i')*60)*400/37800;
                            $dif_marge_top = date_diff($new_hd,$heure_8);
                            $marge_top = ($dif_marge_top->format('%H')*60*60 + $dif_marge_top->format('%i')*60)*400/37800;
                            echo '<div class=\'vendredi1\' style="top:'.$marge_top.'px; height:'.$duree_sec.'px; background-color:'.$result['couleur'].'">';
                            echo $result["nom_matiere"].'<br>'.$new_hd->format('H:i').' à '.$new_hf->format('H:i').'<br>'.$result['nom'];
                            echo '</div>';
                        }
                    ?>
                </div>
            </div>
        </div>
    </section>
</body>