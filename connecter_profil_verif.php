<?php
    error_log("connecter.php");

    // === requires =============================
    require_once('lib/mysql.php');
    require_once('lib/page.php');
    require_once('lib/session.php');
    require_once('lib/html.php');
    require_once('lib/errors.php');

    // === Init =================================
    $HTML = new HTML("Courriers - Connexion");

    // ==========================================


    $db = new DB();
    $motdepassebase = $db->sql("SELECT `mot_de_passe` FROM `utilisateurs`  WHERE id={$_SESSION['uid']};");
    $motdepassesaisi = $_POST['motdepasse'];

    if($motdepassebase[0][0] == $motdepassesaisi)
    {
        error_log("8888888888888888888888888888888888888888888888888888");
        header("Location: utilisateur.php");
    }
    else
    {
        header("Location: connection_profil.php?connectko=4");
    }



        
       