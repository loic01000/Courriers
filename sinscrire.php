<?php
error_log("utilisateur.php");

// === requires =============================
require_once('lib/mysql.php');
require_once('lib/page.php');
require_once('lib/html.php');
require_once('lib/common.php');

// === Init =================================
$HTML = new HTML("sinscrire");

// ==========================================



    $sql = "`titre`,`nom`,`prenom`,`telephone`,`email`,`adresse`,`code_postal`,`localite`,`identifiant`,`mot_de_passe`";
    
    $fields = extractFields($sql,"`");

    foreach ($fields as $f) 
    {
        eval("\$$f='';");
    }
    

    $HTML->form_('formUtilisateur', 'utilisateur_inscrire.php');

    $HTML->fieldSelect('titre', 'titre', ["Mme"=>"Madame", "Melle"=>"Mademoiselle", "M."=>"Monsieur"], $titre,["placeholder"=>"Titre"]);
    $HTML->fieldInput('prenom', 'prenom', 'text', $prenom, ["placeholder"=>"Prénom","title"=>"Votre prénom."]);
    $HTML->fieldInput('nom', 'nom', 'text', $nom, ["placeholder"=>"NOM","title"=>"Votre NOM de famille."]);
    $HTML->fieldInput('telephone', 'telephone', 'text', $telephone, ["placeholder"=>"Téléphone","title"=>"Votre numéro de téléphone."]);
    $HTML->fieldInput('email', 'email', 'text', $email, ["placeholder"=>"E-mail","title"=>"Votre adresse électronique."]);
    $HTML->fieldTextarea('adresse', 'adresse', $adresse, [ "placeholder" => "Adresse", "title"=>'Votre adresse postale.'] );
    $HTML->fieldInput('code_postal', 'code_postal', 'text', $code_postal, ["placeholder"=>"Code postal","title"=>"Le code postal de votre commune."]);
    $HTML->fieldInput('localite', 'localite', 'text', $localite, ["placeholder"=>"Localité","title"=>"Le nom de votre localité."]);
    $HTML->fieldInput('identifiant', 'identifiant', 'text', $identifiant, ["placeholder"=>"Identifiant","title"=>"Votre identifiant de connexion."]);
    $HTML->fieldInput('mot_de_passe ', 'mot_de_passe', 'password', $mot_de_passe, ["placeholder"=>"Mot de passe actuel","title"=>"Votre mot de passe"]);
    

    
        $HTML->submit('', 'Valider', "Valider vos informations pour vous inscrire.");
        $HTML->a('', "{$page->referer}.php", "Retour", "Retourner à la page de connexion.");
        $HTML->_form();
        $HTML->output();
    


