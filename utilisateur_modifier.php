<?php
    error_log("utilisateur_inscrire.php");

    // === requires =============================
    require_once('lib/common.php');
    require_once('lib/mysql.php');
    require_once('lib/page.php');
    require_once('lib/html.php');
    require_once('lib/session.php');
    
    // ==========================================
   
        eval(arrayToVars($_POST));  
       
        


       print("test");
        $db = new DB();
        $set= $db->arrayToSql($_POST);
        $set = str_replace("\"NULL\"","NULL",$set);
        error_log($set);
        $sql= "UPDATE `utilisateurs` SET $set  WHERE `id`={$_SESSION['uid']}";

       
        error_log($sql);
        $db->sql($sql);

        header("Location: liste.php");
