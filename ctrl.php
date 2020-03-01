<?php

    try
    {
        $bdd = new PDO('mysql:host=localhost;port=3308;dbname=it_school_challenge;charset=utf8', 'root','');
    }

    catch(Exception $e)
    {
        die('Erreur : '.$e->getMessage());
    }

    $language = 'English'; //by default

    if ((!isset($_POST['validation'])) && (!isset($_GET['id'])))//Donc qd page principale
    {
        
        if(isset($_POST['languages']))
        {
            $language = $_POST['languages'];
        }

        $query = $bdd->query('SELECT ID, question FROM questiontranslation
                              INNER JOIN question
                                ON question.ID = questiontranslation.ID_question
                              WHERE questiontranslation.language="'.$language.'"');   

        $questions = $query->fetchAll(PDO::FETCH_ASSOC);
        include("questions.html");
        exit;
    }


    if (isset($_GET['id']))  //question.html && $_GET['language']
    {
        $question_id = $_GET['id'];
        $language = $_GET['language'];

        $query = $bdd->query('SELECT answertranslation.answer, is_right, answer.ID
                              FROM question
                              INNER JOIN answer
                                ON question.ID = answer.ID_question
                              INNER JOIN answertranslation
                                ON answer.ID = answertranslation.ID_answer
                              WHERE answer.ID_question="'.$question_id.'" AND answertranslation.language="'.$language.'" ');
        $answers = $query->fetchAll(PDO::FETCH_ASSOC);
       
        $query2 = $bdd->query('SELECT question, ID_question
                              FROM questiontranslation
                              WHERE questiontranslation.ID_question="'.$question_id.'" AND questiontranslation.language="'.$language.'" ');
                            
        $question = $query2->fetch(PDO::FETCH_ASSOC);

        //indice
        $query = $bdd->query('SELECT descriptiontranslation.hint
                          FROM question
                          INNER JOIN description
                            ON question.ID = description.ID_question
                          INNER JOIN descriptiontranslation
                            ON description.ID = descriptiontranslation.ID_description
                          WHERE descriptiontranslation.language="'.$language.'" AND question.ID="'.$question_id.'" ');
        $hint_array = $query->fetch(PDO::FETCH_ASSOC);
        $hint = $hint_array['hint'];

        include('question.html');
        exit;
    }
    
?>