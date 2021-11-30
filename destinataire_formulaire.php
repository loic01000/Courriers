<?php

error_log("destinataire_formulaire.php");

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

$cmd = (isset($_GET['cmd'])) ? $_GET['cmd'] : '';



 if (count($_POST[destinataires])>1 && ($cmd == "modifier" || $cmd == "supprimer")) 
 {
     //print("trop");
 $errors->check($test,1);
 };

 if (count($_POST[destinataires])<1 && ($cmd == "modifier" || $cmd == "supprimer")) 
 {
    //print("Pas assez");
$errors->check($test,2);
 };

if ($errors->code == 0)
{
$db = new DB();
$destinataire_id = $_POST['destinataires'][0];
$_SESSION["destinataire_id"] = $destinataire_id;

$sql = "SELECT `titre`, `nom`, `prenom`, `fonction`, `denomination`, `adresse`, `code_postal`, `localite`, `telephone`, `email`, `commentaire` FROM destinataires WHERE id=$destinataire_id";


// ----------------------------------------------
if($cmd == "ajouter")
{
    $fields = extractFields($sql,"`");

    foreach ($fields as $f) 
    {
        eval("\$$f='';");
    }
}

// ----------------------------------------------
if($cmd == "modifier")
{
   

    $destinataire = $db->sql($sql, "ASSOC")[0];
    eval($db->fieldsToVars());
}
error_log("============================");
error_log($titre);
error_log("======================================");
// ----------------------------------------------
$header = new HTML();
if($cmd == "ajouter")
{$HTML->header("Creation destinataire");};
if($cmd == "modifier")
{$HTML->header("Modification destinataire");};

$HTML->form_('formUtilisateur', 'modifier.php','POST',["class"=>"formForm"]);
$HTML->div_("",['class'=>'container']);
    $HTML->div_("courrier",['class'=>'row']);
        $HTML->fieldSelect('titre', 'titre', ["Mme"=>"Madame", "Melle"=>"Mademoiselle", "M."=>"Monsieur"], $titre,["placeholder"=>"Titre", "style"=>"width : 150Px"]);
        $HTML->fieldInput('prenom', 'prenom', 'text', $prenom, ["placeholder"=>"Prenom","title"=>"Saisissez le prénom.", "style"=>"width : 250Px"]);
        $HTML->fieldInput('nom', 'nom', 'text', $nom, ["placeholder"=>"Nom","title"=>"Saisissez le nom.", "style"=>"width : 250Px"]);
    $HTML->_div();
    $HTML->div_("courrier",['class'=>'row']);
        $HTML->fieldInput('fonction', 'fonction', 'text', $fonction, ["placeholder"=>"Fonction","title"=>"Saisissez la fonction.", "style"=>"width : 300Px"]);
        $HTML->fieldInput('denomination', 'denomination', 'text', $denomination, ["placeholder"=>"Denomination","title"=>"Denomination.", "style"=>"width : 400Px"]);
    $HTML->_div();
    $HTML->div_("courrier",['class'=>'row']);
        $HTML->fieldInput('adresse', 'adresse', 'text', $adresse, ["placeholder"=>"Adresse","title"=>"Adresse.", "style"=>"width : 300Px"]);
        $HTML->fieldInput('code_postal', 'code_postal', 'text', $code_postal, ["placeholder"=>"Code postal","title"=>"Saisissez le code postal.", "style"=>"width : 100Px"]);
        $HTML->fieldInput('localite', 'localite', 'text', $localite, ["placeholder"=>"localite","title"=>"Saisissez la localite.", "style"=>"width : 300Px"]);
    $HTML->_div();
    $HTML->div_("courrier",['class'=>'row']);
        $HTML->fieldInput('telephone', 'telephone', 'text', $telephone, ["placeholder"=>"telephone","title"=>"Saisissez le téléphone.", "style"=>"width : 300Px"]);
        $HTML->fieldTextarea('commentaire', 'commentaire', $commentaire, ["placeholder"=>"Commentaire","title"=>"Saisissez un commentaire.", "style"=>"width : 300Px"]);
    $HTML->_div();
$HTML->_div();

// ----------------------------------------------
if($cmd == "ajouter")
{
    $HTML->submit('', 'Valider',["title" => "Valider vos informations pour vous inscrire.", "formaction"=>"destinataire_ajouter.php", 'class'=>'button']);
}

// ----------------------------------------------
if($cmd == "modifier")
{
    $HTML->submit('', 'Valider',["title" =>"Valider pour enregistrer vos modifications.", "formaction"=>"destinataire_modifier.php", 'class'=>'button']);
}

// ----------------------------------------------
$HTML->a('', "destinataire_liste.php", "Retour",["title" => "Retourner à la page de connexion.", "formaction"=>"destinataire_liste.php", 'class'=>'button']);

$HTML->_form();

$HTML->output();
}

if($errors->code != 0)
    {
        error_log("\$errors->code = {$errors->code};");
        error_log("\$errors->text = {$errors->text};");

        $HTML->innerHTML("Erreur {$errors->code} :\n{$errors->text}");
//        $HTML->output();

        header("Location: destinataire_liste.php?error={$errors->code}");
    }

// error_log("destinataire_formulaire.php");

// // === requires =============================
// require_once('lib/common.php');
// require_once('lib/mysql.php');
// require_once('lib/page.php');
// require_once('lib/session.php');
// require_once('lib/html.php');
// require_once('lib/errors.php');

// // === Init =================================
// $HTML = new HTML("Forulaire - Destinataire");

// // ==========================================

// $cmd = (isset($_GET['cmd'])) ? $_GET['cmd'] : '';

// $db = new DB();

// $sql = "SELECT `titre`,`prenom`,`nom`,`fonction`,`denomination`,`adresse`, `code_postal`, `localite`, `telephone`, `email`, `commentaire` FROM destinataires WHERE id=1;";
// //"SELECT `titre`,`prenom`,`nom`,`fonction`,`denomination`,`localite` FROM `destinataires` WHERE utilisateur_id = $uid;"
// // ----------------------------------------------
// if($cmd == "ajouter")
// {
//     $fields = extractFields($sql,"`");

//     foreach ($fields as $f) 
//     {
//         eval("\$$f='';");
//     }
// }

// // ----------------------------------------------
// if($cmd == "modifier")
// {
   

//     $courrier = $db->sql($sql, "ASSOC")[0];
//     eval($db->fieldsToVars());
// }

// // ----------------------------------------------
// $sql = "SELECT id, CONCAT(`prenom`,' ',`nom`) AS identite FROM destinataires WHERE utilisateur_id={$_SESSION['uid']} ORDER BY nom ASC, prenom ASC;";

// $destinataires = $db->sql($sql);
// $destinataires_select = [];
// foreach ($destinataires as $record) 
// {
//     $destinataires_select[$record[0]] = $record[1];
// }

// $HTML->form_('formUtilisateur', 'modifier.php');
// $HTML->fieldSelect('destinataire', 'destinataire', $destinataires_select, $courrier["destinataire_id"],["placeholder"=>"Destinataire","title"=>"Destinataire."]);
// $HTML->fieldInput('nosref', 'nosref', 'text', $nosref, ["placeholder"=>"Nos reférences","title"=>"Saisissez votre référence."]);
// $HTML->fieldInput('vosref', 'vosref', 'text', $vosref, ["placeholder"=>"Vos références","title"=>"Saisissez la référence de l'utilisateur."]);
// $HTML->fieldInput('objet', 'objet', 'text', $objet, ["placeholder"=>"Objet","title"=>"Objet du message."]);
// $HTML->fieldInput('offre', 'offre', 'text', $offre, ["placeholder"=>"Offre","title"=>"Numéro de l'offre."]);
// $HTML->fieldInput('date_envoi', 'date_envoi', 'date', $date_envoi, ["placeholder"=>"Date de creation","title"=>"Saisissez la date de création."]);
// $HTML->fieldInput('date_relance', 'date_relance', 'date', $date_relance, ["placeholder"=>"Date de relance","title"=>"Saisissez la date de relance."]);
// $HTML->fieldTextarea('paragraphe1', 'paragraphe1', $paragraphe1, ["placeholder"=>"Paragraphe 1","title"=>"Saisissez votre premier paragraphe."]);
// $HTML->fieldTextarea('paragraphe2', 'paragraphe2', $paragraphe2, ["placeholder"=>"Paragraphe 2","title"=>"Saisissez votre deuxieme paragraphe."]);
// $HTML->fieldTextarea('paragraphe3', 'paragraphe3', $paragraphe3, ["placeholder"=>"Paragraphe 3","title"=>"Saisissez votre troisieme paragraphe."]);
// $HTML->fieldTextarea('paragraphe4', 'paragraphe4', $paragraphe4, ["placeholder"=>"Paragraphe 4","title"=>"Saisissez votre quatrieme paragraphe."]);

// // ----------------------------------------------
// if($cmd == "ajouter")
// {
//     $HTML->submit('', 'Valider',["title" => "Valider vos informations pour vous inscrire.", "formaction"=>"destinataire_ajouter.php"]);
// }

// // ----------------------------------------------
// if($cmd == "modifier")
// {
//     $HTML->submit('', 'Valider',["title" =>"Valider pour enregistrer vos modifications.", "formaction"=>"modifier.php"]);
// }

// // ----------------------------------------------
// $HTML->a('', "{$page->referer}.php", "Retour",["title" => "Retourner à la page de connexion.", "formaction"=>"liste.php"]);

// $HTML->_form();

// $HTML->output();