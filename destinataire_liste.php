<?php
    error_log("liste_destinataire.php");

    // === requires =============================
    require_once('lib/mysql.php');
    require_once('lib/page.php');
    require_once('lib/session.php');
    require_once('lib/html.php');
    require_once('lib/errors.php');

    // === Init =================================
    $HTML = new HTML("Destinataires - Liste");
    
    // ==========================================

    if($errors->check($session->check(),32768))
    {
        $uid = $_SESSION["uid"];
        // --------------------------------------
        $header = new HTML();
            $HTML->header("VOS DESTINATAIRES");
            $header->a('','deconnecter.php','Déconnecter',['title'=>"Déconnecter la session et retourner à la page d'identification.", 'class'=>'nav']);
            $header->space();
            $header->a('','connection_profil.php',"Votre profil",['title'=>"Mes informations.", 'class'=>'nav']);
            $header->a('', 'liste.php',"Liste courriers", ['title'=>'Liste destinataires.', 'class'=>'nav']);
        $HTML->header($header->HTML);

        //============Erreurs selection
      $error = (isset($_GET['error'])) ? $_GET['error'] : 0;
      
      if($error > 0)
      {
          $HTML->p('',nl2br($errors->getMessages("destinataire_formulaire",$error)),['class'=>'error']);
      }

      //==========Messages de succes=======================
      $mess = (isset($_GET['success'])) ? $_GET['success'] : 0;
      if($mess==1)
      {
      $HTML->p('',nl2br("Le destinataire a bien été modifié"),['class'=>'success']);
      }
      if($mess==2)
      {
      $HTML->p('',nl2br("Le destinataire a bien été supprime"),['class'=>'success']);
      }
      if($mess==3)
      {
      $HTML->p('',nl2br("Le destinataire a bien été ajouté"),['class'=>'success']);
      }
      
       //==============================

        $HTML->form_("","","POST", ["class"=>"formList"]);
        // --------------------------------------
        $main = new HTML();
            $db = new DB();
            $destinataires = $db->sql("SELECT `id`,`titre`,`prenom`,`nom`,`fonction`,`denomination`,`localite` FROM `destinataires` WHERE utilisateur_id = $uid AND `status` IS NULL;");
            $main->tableFilled('destinataires',['id','Titre','Prénom','Nom','Fonction','Dénomination','Localité'],$destinataires);
        $HTML->main($main->HTML);

        // --------------------------------------
        $footer = new HTML();

        $footer->submit('', 'Ajouter', ['title'=>'Créer un nouveau destinataire.', 'class'=>'button', "formaction"=>"destinataire_formulaire.php?cmd=ajouter"]);
        $footer->submit('', 'Modifier', ['title'=>'Modifier les destinataires sélectionnés.', 'class'=>'button', "formaction"=>"destinataire_formulaire.php?cmd=modifier"]);
        $footer->submit('', 'Supprimer', ['title'=>'Supprimer les destinataires sélectionnés.', 'class'=>'button', "formaction"=>"destinataire_supprimer.php"]);

        $HTML->footer($footer->HTML,['class'=>'cmd']);
        $HTML->_form();
    }

    $HTML->output();