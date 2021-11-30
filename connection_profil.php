<?php
    error_log("index.php");
    
    // === requires =============================
    require_once('lib/mysql.php');
    require_once('lib/page.php');
    require_once('lib/session.php');
    require_once('lib/html.php');
    require_once('lib/errors.php');

    // === Init =================================
    $HTML = new HTML("Courriers");
    
    // ==========================================

    $main = new HTML();
        $header = new HTML();
            $HTML->header("MODIFICATION PROFIL");
            $header->a('','deconnecter.php','Déconnecter',['title'=>"Déconnecter la session et retourner à la page d'identification.", 'class'=>'nav']);
            $header->space();
            $header->a('', 'destinataire_liste.php',"Liste destinataires", ['title'=>'Liste des destinataires.', 'class'=>'nav']);
            $header->a('', 'liste.php',"Liste courriers", ['title'=>'Liste destinataires.', 'class'=>'nav']);
        $HTML->header($header->HTML);

        //=================Message echec de connection au profil=========================
        $mess = (isset($_GET['connectko'])) ? $_GET['connectko'] : 0;
        if($mess==4)
        {
        $HTML->p('',nl2br("Votre mot de passe est erroné"),['class'=>'error']);
}

        $main->form_('formLogin','connecter_profil_verif.php','POST',['class'=>'formForm']);
            $main->fieldInput('motdepasse', 'motdepasse', 'password', '', ['placeholder'=>"Mot de passe", 'title'=>"Votre mot de passe.", 'required'=>"required"]);

            $main->hr();
            $main->div_('cmd',['class'=>'cmd']);
                $main->submit('', 'Confirmer', ['title'=>'Envoyer les informations de connexion.', 'class'=>'button']);
                $main->_div();
        $main->_form();
        $error = (isset($_GET['error'])) ? $_GET['error'] : 0;
        if($error > 0)
        {
            $main->p('',nl2br("Erreur : \n".$errors->getMessages("connecter",$error)),['class'=>'error']);
        }
    $HTML->main($main->HTML, ['style'=>"height: calc(100vh - 50px);"]);

    $HTML->output();