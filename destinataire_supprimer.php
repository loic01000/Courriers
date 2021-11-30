<?php
    error_log("destinataire_supprimer.php");

    // === requires =============================
    require_once('lib/common.php');
    require_once('lib/mysql.php');
    require_once('lib/page.php');
    require_once('lib/session.php');
    require_once('lib/html.php');
    require_once('lib/errors.php');
    
   // === Init =================================
$HTML = new HTML("Courriers - Connexion");

// ==========================================

    $destinataire_id = $_POST['destinataires'];
   
  
    if($errors->check($page->referer == "destinataire_liste",32768) && $errors->check($session->check(),32768))
    {
      /////Verification avant suppression que destinataire n'est pas utilisé///////////
        $courriers = new DB();
        $liste_destinataires_utilises = $courriers->sql("SELECT `destinataire_id` FROM `courriers`");
        $courrier_sup_ko=0;
        foreach ($_POST['destinataires'] as $destinataires_a_supprimer) 
        {
          foreach ($liste_destinataires_utilises as $key) 
          {
            {
              if ($destinataires_a_supprimer == $key[0]) 
              {$courrier_sup_ko++;}
            
            }
          }
        }
        
        if ($courrier_sup_ko>0) 
        {
        
        $test = false;
        $errors->check($test,4);
        };
      
         if ($errors->code == 0)
         {

           eval(arrayToVars($_POST));  
           $ids=[];
           $db = new DB();
          
             /* ------------------------------------------------ */
           foreach ($_POST['destinataires'] as $id) 
           {           
             array_push($ids,"id=$id");
           
           }
           $clause = implode(' OR ',$ids);
           /* ------------------------------------------------ */
         
           print($sql);
           $sql= "UPDATE `destinataires` SET `status`=\"Supprimé\" WHERE $clause;";
           $db->sql($sql);
          
           
           header("Location: destinataire_liste.php?success=2");
         }
        if($errors->code != 0)
             {
                 error_log("\$errors->code = {$errors->code};");
                 error_log("\$errors->text = {$errors->text};");
        
                 $HTML->innerHTML("Erreur {$errors->code} :\n{$errors->text}");
       
        
                 header("Location: destinataire_liste.php?error={$errors->code}");
             }
        


    }

    //     error_log("destinataire_supprimer.php");

//     // === requires =============================
//     require_once('lib/common.php');
//     require_once('lib/mysql.php');
//     require_once('lib/page.php');
//     require_once('lib/session.php');
//     require_once('lib/html.php');
//     require_once('lib/errors.php');
    
//     // ==========================================

//     $destinataire_id = $_POST['destinataires'][0];
   
    
    
//       if($errors->check($page->referer == "destinataire_liste",32768) && $errors->check($session->check(),32768))
//       {
//         ////////////Test//////////////////////////////
//         $courriers = new DB();
//         $liste_destinataires_utilises = $courriers->sql("SELECT `destinataire_id` FROM `courriers`");
//         $ko=0;
//         foreach ($_POST['destinataires'] as $destinataires_a_supprimer) 
//             {
//             foreach ($liste_destinataires_utilises as $key) 
//             {
              
//               {
//                 if ($destinataires_a_supprimer == $key[0]) {$courrier_sup_ko++;}
                
//               }
//             }
//             }
          
//         if ($courrier_sup_ko) 
//         {
//             //print("trop");
//         $errors->check($test,128);
//         };
        
//         if ($errors->code == 0)
//         {
//          eval(arrayToVars($_POST));  
        
//          $db = new DB();
          
//              /* ------------------------------------------------ */
//            foreach ($_POST['destinataires'] as $id) 
//            {           
//              array_push($ids,"id=$id");
//            }
//           $clause = implode(' OR ',$ids);
//            /* ------------------------------------------------ */

//            $sql= "UPDATE `destinataires` SET `status`=\"Supprimé\" WHERE $clause;";
          
//             $db->sql($sql);
//             header("Location: destinataire_liste.php");
//         }

//         if($errors->code != 0)
//     {
//         error_log("\$errors->code = {$errors->code};");
//         error_log("\$errors->text = {$errors->text};");

//         $HTML->innerHTML("Erreur {$errors->code} :\n{$errors->text}");
// //        $HTML->output();

//         header("Location: destinataire_liste.php?error={$errors->code}");
//     }


//       }

