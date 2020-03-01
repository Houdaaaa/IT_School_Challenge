<?php  
    try
    {
        $bdd = new PDO('mysql:host=localhost;port=3308;dbname=it_school_challenge;charset=utf8', 'root','');
    }

    catch(Exception $e)
    {
        die('Erreur : '.$e->getMessage());
    }

    $query = $bdd->query('SELECT language
                          from language');   

    $languages = $query->fetchAll(PDO::FETCH_ASSOC);

    include("home.html");
    
?>