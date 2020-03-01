<?php
try
{
    $bdd = new PDO('mysql:host=localhost;port=3308;dbname=it_school_challenge;charset=utf8', 'root','');
}

catch(Exception $e)
{
    die('Erreur : '.$e->getMessage());
}

$language = $_GET['language'];

//correction
if ((isset($_POST['answer'])) && (isset($_POST['validation'])))  // ou validation?
{
    //$answer = htmlentities($_POST['answer']);     //On securise les variables 
    $correction = '';
    $question_id = $_GET['id']; 
    $answer_id_selected = $_POST['answer'];

    $query = $bdd->query('SELECT answer.ID
                        FROM answer
                        INNER JOIN question
                            ON question.ID = answer.ID_question
                        WHERE answer.ID_question="'.$question_id.'" AND answer.is_right=1'); // affiche tous les id_answer corrects

    $answers_right = $query->fetchAll(PDO::FETCH_ASSOC);
    $answer_id_right = array();

    foreach($answers_right as $answer_right){

        array_push($answer_id_right, $answer_right['ID']);
    }      

    if ($answer_id_right == $answer_id_selected)
    {
        
        $query = $bdd->query('SELECT descriptiontranslation.description
                            FROM question
                            INNER JOIN description
                                ON question.ID = description.ID_question
                            INNER JOIN descriptiontranslation
                                ON description.ID = descriptiontranslation.ID_description
                            WHERE descriptiontranslation.language="'.$language.'" AND question.ID="'.$question_id.'" ');

        $hint_description = $query->fetch(PDO::FETCH_ASSOC);
        $description = $hint_description['description'];

        $correction = 'Correct !';
        include("corrections.html");
        exit;
    }

    else 
    {
        $correction = 'Faux ! Réessaye ';
        include("corrections.html");
        exit;
    }
}

else if (isset($_POST['validation']))
{
    $correction = 'Copie blanche ! ';
    include("corrections.html");
    exit;
}


?>