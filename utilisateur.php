<?php
error_log("utilisateur.php");

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

    $utilisateur = $db->sql("SELECT titre,nom,prenom,telephone,email,adresse,code_postal,localite,identifiant FROM utilisateurs WHERE id={$_SESSION['uid']};");

    $titre          = $utilisateur[0][0];
    $nom            = $utilisateur[0][1];
    $prenom         = $utilisateur[0][2];
    $telephone      = $utilisateur[0][3];
    $email          = $utilisateur[0][4];
    $adresse        = htmlentities($utilisateur[0][5]);
    $code_postal    = $utilisateur[0][6];
    $localite       = $utilisateur[0][7];
    $identifiant    = $utilisateur[0][8];
    
    $header = new HTML();
    $HTML->header("Votre profil");

    $HTML->form_('formUtilisateur', 'utilisateur_modifier.php','POST',["class"=>"formForm"]);
    $HTML->div_("",['class'=>'container']);
        $HTML->div_("utilisateur",['class'=>'row']);
            $HTML->fieldSelect('titre', 'titre', ["Mme"=>"Madame", "Melle"=>"Mademoiselle", "M."=>"Monsieur"], $titre,["placeholder"=>"Titre", "style"=>"width : 150Px"]);
            $HTML->fieldInput('prenom', 'prenom', 'text', $prenom, ["placeholder"=>"Prénom","title"=>"Votre prénom.", "style"=>"width : 250Px"]);
            $HTML->fieldInput('nom', 'nom', 'text', $nom, ["placeholder"=>"NOM","title"=>"Votre NOM de famille.", "style"=>"width : 250Px"]);
        $HTML->_div();
        $HTML->div_("utilisateur",['class'=>'row']);
            $HTML->fieldInput('telephone', 'telephone', 'text', $telephone, ["placeholder"=>"Téléphone","title"=>"Votre numéro de téléphone.", "style"=>"width : 300Px"]);
            $HTML->fieldInput('email', 'email', 'text', $email, ["placeholder"=>"E-mail","title"=>"Votre adresse électronique.", "style"=>"width : 400Px"]);
        $HTML->_div();
        $HTML->div_("utilisateur",['class'=>'row']);
            $HTML->fieldTextarea('adresse', 'adresse', $adresse, [ "placeholder" => "Adresse", "title"=>'Votre adresse postale.', "style"=>"width : 300Px"]);
            $HTML->fieldInput('code_postal', 'code_postal', 'text', $code_postal, ["placeholder"=>"Code postal","title"=>"Le code postal de votre commune.", "style"=>"width : 100Px"]);
            $HTML->fieldInput('localite', 'localite', 'text', $localite, ["placeholder"=>"Localité","title"=>"Le nom de votre localité.", "style"=>"width : 300Px"]);
        $HTML->_div();
        $HTML->div_("utilisateur",['class'=>'row']);
            $HTML->fieldInput('identifiant', 'identifiant', 'text', $identifiant, ["placeholder"=>"Identifiant","title"=>"Votre identifiant de connexion.", "style"=>"width : 350Px"]);
            $HTML->fieldInput('mot_de_passe ', 'mot_de_passe', 'password', '', ["placeholder"=>"Nouveau pot de passe","title"=>"Nouveaua mot de passe.", "style"=>"width : 350Px"]);
        $HTML->_div();

    if (($page->referer == 'liste') && ($errors->check($session->check(), 32768))) {
        $HTML->submit('', 'Valider', "Valider vos informations pour les modifier.", ['class'=>'button']);
        //$HTML->a('', "liste.php", "Retour", "Retourner à la page de connexion.", ['class'=>'button']);
        $HTML->_form();
        $HTML->output();
    } else {
        $HTML->submit('', 'Valider',['class'=>'button']);
        $HTML->a('', "liste.php", "Retour", ['class'=>'button']);
        $HTML->_form();
        $HTML->output();
    }

