<?php
    error_log("liste.php");

    // === requires =============================
    require_once('lib/mysql.php');
    require_once('lib/page.php');
    require_once('lib/session.php');
    require_once('lib/html.php');
    require_once('lib/errors.php');

    // === Init =================================
    $HTML = new HTML("Courriers - Liste");
    
    // ==========================================
    global $success;


    if($errors->check($session->check(),32768))
    {
        // --------------------------------------
        $header = new HTML();
            $HTML->header("VOS COURRIERS");
            $header->a('','deconnecter.php','Déconnecter',['title'=>"Déconnecter la session et retourner à la page d'identification.", 'class'=>'nav']);
            $header->space();
            $header->a('','connection_profil.php',"Votre profil",['title'=>"Mes informations.", 'class'=>'nav']);
            $header->space();
            $header->a('', 'destinataire_liste.php',"Liste destinataires", ['title'=>'Liste des destinataires.', 'class'=>'nav']);
        $HTML->header($header->HTML);

         //============Erreurs selection
      $error = (isset($_GET['error'])) ? $_GET['error'] : 0;
      
      if($error > 0)
      {
          $HTML->p('',nl2br($errors->getMessages("formulaire",$error)),['class'=>'error']);
      }
      
      //==========Messages de succes=======================
      $mess = (isset($_GET['success'])) ? $_GET['success'] : 0;
      if($mess==1)
      {
      $HTML->p('',nl2br("Votre courrier a bien été modifié"),['class'=>'success']);
      }
      if($mess==2)
      {
      $HTML->p('',nl2br("Votre courrier a bien été supprime"),['class'=>'success']);
      }
      if($mess==3)
      {
      $HTML->p('',nl2br("Votre courrier a bien été ajouté"),['class'=>'success']);
      }
      

       //==============================

        $HTML->form_('','','POST',['class'=>'formList']);

        // --------------------------------------
        $main = new HTML();
            $db = new DB();
            $courriers = $db->sql("SELECT `id`,`date_modification`,`date_envoi`,CONCAT(`prenom`,' ',`nom`) AS `destinataire`,`denomination`,CONCAT(`code_postal`,' ',`localite`) AS `lieu`,`status` FROM `list_courriers` WHERE `utilisateur_id`={$_SESSION["uid"]} AND `status` <> \"Supprimé\" ORDER BY `date_modification` DESC, `date_envoi` DESC;");
            $main->tableFilled('courriers',['id','Modification','Envoi','Destinataire','Dénomination','Lieu','Status'],$courriers);
        $HTML->main($main->HTML);

        // --------------------------------------
        $footer = new HTML();

        $footer->submit('', 'Imprimer', ['title'=>'Imprimer les courriers sélectionnés.', 'class'=>'button','formaction'=>'pdf.php?out=I']);
        $footer->submit('', 'Imprimer et envoyer', ['title'=>'Imprimer et envoyer les courriers sélectionnés.', 'class'=>'button','formaction'=>'pdf.php?out=I&envoi=ok']);
        $footer->submit('', 'Télécharger', ['title'=>'Télécharger les courriers sélectionnés.', 'class'=>'button','formaction'=>'pdf.php?cmd=telecharger&out=D']);
        $footer->submit('', 'Ajouter', ['title'=>'Créer un nouveau courrier.', 'class'=>'button','formaction'=>'formulaire.php?cmd=ajouter']);
        $footer->submit('', 'Modifier', ['title'=>'Modifier les courriers sélectionnés.', 'class'=>'button','formaction'=>'formulaire.php?cmd=modifier']);
        $footer->submit('', 'Supprimer', ['title'=>'Supprimer les courriers sélectionnés.', 'class'=>'button','formaction'=>'supprimer.php']);

        $HTML->footer($footer->HTML,['class'=>'cmd']);
        $HTML->_form();
    }

    $HTML->output();
