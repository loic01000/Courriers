<?php
    error_log("supprimer.php");

    // === requires =============================
    require_once('lib/common.php');
    require_once('lib/mysql.php');
    require_once('lib/page.php');
    require_once('lib/session.php');
    require_once('lib/html.php');
    require_once('lib/errors.php');
    
    // ==========================================


    //$courrier_id = $_POST['courriers'][0];

    // foreach ($_POST['courriers'] as $key) {
    //     print($key);
    // }

    // === Init =================================
    $HTML = new HTML("Courriers - Connexion");

  // ==========================================
    
   
      if($errors->check($page->referer == "liste",32768) && $errors->check($session->check(),32768))
      {
        //=======Blocage modification si courrier a été envoyé======
        $db = new DB();
        $courrier_id = $_POST['courriers'][0];
        $sql = "SELECT `status` FROM courriers WHERE id=$courrier_id;";
        $status = $db->sql($sql);
        if($status[0][0]=="Envoye")
        {

          error_log("===============================");
         
          error_log("===============================");
            $test= false;
            $errors->check($test,8);
        }
        
        if ($errors->code == 0)
         {
        $ids = [];
         
          $db = new DB();

          /* ------------------------------------------------ */
          foreach ($_POST['courriers'] as $id) 
          {           
            array_push($ids,"id=$id");
          }
          $clause = implode(' OR ',$ids);
          /* ------------------------------------------------ */

          $sql= "UPDATE `courriers` SET `status`=\"Supprimé\" WHERE $clause;";
         
           $db->sql($sql);
           header("Location: liste.php?success=2");
          }

          if($errors->code != 0)
             {
                 error_log("\$errors->code = {$errors->code};");
                 error_log("\$errors->text = {$errors->text};");
        
                 $HTML->innerHTML("Erreur {$errors->code} :\n{$errors->text}");
       
        
                 header("Location: liste.php?error={$errors->code}");
             }
      }
