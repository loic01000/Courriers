<?php
    error_log("modifier.php");

    // === requires =============================
    require_once('lib/common.php');
    require_once('lib/mysql.php');
    require_once('lib/page.php');
    require_once('lib/session.php');
    require_once('lib/html.php');
    require_once('lib/errors.php');
    
    // ==========================================
    if($errors->check($page->referer == "destinataire_formulaire",32768) && $errors->check($session->check(),32768))
    {
        eval(arrayToVars($_POST));  
        
       
        $dest = $_SESSION["destinataire_id"];
        $uid = $_SESSION['uid'];

        $db = new DB();
        $set= $db->arrayToSql($_POST);
        $set = str_replace("\"NULL\"","NULL",$set);
        $sql= "UPDATE `destinataires` SET $set, `utilisateur_id` = \"$uid\"  WHERE `id`={$_SESSION["destinataire_id"]}";

        $db->sql($sql);

        header("Location: destinataire_liste.php?success=1");


    }

