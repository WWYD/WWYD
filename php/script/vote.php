<?php

header('Content-Type: text/html; charset=utf-8');

session_start();

    if (isset($_SESSION['user']) && isset($_POST['post_id']) && isset($_POST['vote_type'])) 
    {
        try 
        {
            $post_id = mysql_real_escape_string($_POST['post_id']);
            $user_id = mysql_real_escape_string($_SESSION['user']['id']);

            $bdd = new PDO('mysql:host=localhost;dbname=wwyd', 'root', '', array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
           
            $query2 = $bdd->query('SELECT * FROM vote WHERE post_id = "'.$post_id.'" AND user_id = "'.$user_id.'"');
            $ans = $query2->fetch();
           
            if ($ans == null) 
            {
                if($_POST['vote_type'] == 'like')
                    $query = $bdd->query('INSERT INTO vote VALUES (default, "'.$post_id.'", "'.$user_id.'", 1)');
                else if($_POST['vote_type'] == 'dislike')
                    $query = $bdd->query('INSERT INTO vote VALUES (default, "'.$post_id.'", "'.$user_id.'", -1)');
                else {
                    echo "Erreur : Type vote";
                    exit();
                }

                if ($query == FALSE)
                    echo "Erreur : Requête invalide";
                else
                    echo "Succès : Vote bien pris en compte";
            } else
                echo "Erreur : Vous avez déja voté";
               
        } catch ( Exception $e ) {
             echo "Erreur : BDD";
        }
    }
    else
        echo "Erreur : Connexion";
?>
