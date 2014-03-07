<?php

    if (isset($_POST['user_id']) && isset($_POST['post_id']) && isset($_POST['vote_type'])) 
    {
        try 
        {
            $post_id = mysql_real_escape_string($_POST['post_id']);
            $user_id = mysql_real_escape_string($_POST['user_id']);

            $bdd = new PDO('mysql:host=localhost;dbname=wwyd', 'root', '', array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
           
            $query2 = $bdd->query('SELECT * FROM vote WHERE post_id = "'.$post_id.'" AND user_id = "'.$user_id.'"');
            $ans = $query2->fetch();
           
            if ($ans == null) 
            {
                if($_POST['vote_type'] == 'like')
                    $query = $bdd->query('INSERT INTO vote VALUES (default, "'.$post_id.'", "'.$user_id.'", TRUE)');
                if($_POST['vote_type'] == 'dislike')
                    $query = $bdd->query('INSERT INTO vote VALUES (default, "'.$post_id.'", "'.$user_id.'", FALSE)');
                
                if ($query == FALSE)
                    echo "Erreur: Requête invalide";
                else
                    echo "Vote bien pris en compte";
            } else
                echo "Vous avez déja voté";
               
        } catch ( Exception $e ) {
            echo 1;
        }
    }
    else
        echo "Erreur";
?>
