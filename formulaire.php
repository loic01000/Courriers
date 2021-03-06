<?php

error_log("formulaire.php");

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

$uid = $_SESSION['uid'];
$test==false;
$courrier_id = $_POST['courriers'][0];
$courrier_status = $_POST['courriers'][0];
$_SESSION["courrier_id"] = $courrier_id;

$cmd = (isset($_GET['cmd'])) ? $_GET['cmd'] : '';


//=======Erreur si modification plusieurs courriers à la fois======
if (count($_POST[courriers])>1 && ($cmd == "modifier"))  
{
$errors->check($test,1);
};


//=======Erreur si aucun courrier n'a été selectionné======
if (count($_POST[courriers])<1 && ($cmd == "modifier"))  
{
$errors->check($test,2);
};

//=======Blocage modification si courrier a été envoyé======
$db = new DB();
$sql = "SELECT `status` FROM courriers WHERE id=$courrier_id;";
$status = $db->sql($sql);
if($status[0][0]=="Envoye")
{
    $errors->check($test,4);
}
            


if ($errors->code == 0)
{
$db = new DB();

$sql = "SELECT `objet`, `offre`, `date_envoi`, `date_relance`, `paragraphe1`, `paragraphe2`, `paragraphe3`, `paragraphe4`, `nosref`, `vosref`, `annonce`, `destinataire_id`, `status` FROM courriers WHERE id=$courrier_id;";



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
    $courrier = $db->sql($sql, "ASSOC")[0];
    eval($db->fieldsToVars());
}

// ----------------------------------------------
$sql = "SELECT id, CONCAT(`prenom`,' ',`nom`) AS identite FROM destinataires WHERE utilisateur_id={$_SESSION['uid']} ORDER BY nom ASC, prenom ASC;";
$destinataires = $db->sql($sql);
$destinataires_select = [];
foreach ($destinataires as $record) 
{
    $destinataires_select[$record[0]] = $record[1];
}

// ----------------------------------------------
$sql = "SELECT `id`, `libelle` FROM `_status`;";
$status_ = $db->sql($sql);
$status_select = [];
foreach ($status_ as $record) 
{
    if ($record[1]=="Brouillon" || $record[1]=="Selectionné") 
    $status_select[$record[1]] = $record[1];
}

// $status_select[0][1] = $status_[0][1];
// $status_select[0][1] = $status_[1][1];

$header = new HTML();
if($cmd == "ajouter")
{$HTML->header("Creation courrier");};
if($cmd == "modifier")
{$HTML->header("Modification courrier");};

$HTML->form_('formUtilisateur', 'modifier.php','POST',["class"=>"formForm"]);
$HTML->fieldInput('utilisateur_id','utilisateur_id',"hidden",$_SESSION['uid']);
$HTML->div_("",['class'=>'container']);
    $HTML->div_("courrier",['class'=>'row']);
        $HTML->fieldSelect('status', 'status',$status_select,$status,["placeholder"=>"Status","title"=>"Status", "style"=>"width : 150Px"]);
        $HTML->fieldTextarea('annonce','annonce',$annonce ,["placeholder"=>"Annonce","title"=>"Annonce"]);
        $HTML->fieldSelect('destinataire_id', 'destinataire_id', $destinataires_select, $courrier["destinataire_id"],["placeholder"=>"Destinataire","title"=>"Destinataire."]);
    $HTML->_div();
    $HTML->div_("courrier",['class'=>'row']);
        $HTML->fieldInput('nosref', 'nosref', 'text', $nosref, ["placeholder"=>"Nos reférences","title"=>"Saisissez votre référence.", "style"=>"width : 150Px"]);
        $HTML->fieldInput('vosref', 'vosref', 'text', $vosref, ["placeholder"=>"Vos références","title"=>"Saisissez la référence de l'utilisateur.", "style"=>"width : 150Px"]);
        $HTML->fieldInput('objet', 'objet', 'text', $objet, ["placeholder"=>"Objet","title"=>"Objet du message.", "style"=>"width : 150Px"]);
    $HTML->_div();   
    $HTML->div_("courrier",['class'=>'row']);
            $HTML->fieldInput('offre', 'offre', 'text', $offre, ["placeholder"=>"Offre","title"=>"Numéro de l'offre.", "style"=>"width : 150Px"]);
        if($cmd == 'modifier')
        {
            $HTML->fieldInput('date_envoi', 'date_envoi', 'date', $date_envoi, ["placeholder"=>"Date d'envoi","title"=>"Saisissez la date d'envoi'.", "style"=>"width : 150Px"]);
        }
        $HTML->fieldInput('date_relance', 'date_relance', 'date', $date_relance, ["placeholder"=>"Date de relance prévue","title"=>"Saisissez la date de relance prévue.", "style"=>"width : 150Px"]);
    $HTML->_div();
    $HTML->div_("courrier",['class'=>'row']);
        $HTML->fieldTextarea('paragraphe1', 'paragraphe1', $paragraphe1, ["placeholder"=>"Paragraphe 1","title"=>"Saisissez votre premier paragraphe.", "style"=>"width : 350Px"]);
        $HTML->fieldTextarea('paragraphe2', 'paragraphe2', $paragraphe2, ["placeholder"=>"Paragraphe 2","title"=>"Saisissez votre deuxieme paragraphe.", "style"=>"width : 350Px"]);
    $HTML->_div();
    $HTML->div_("courrier",['class'=>'row']);
        $HTML->fieldTextarea('paragraphe3', 'paragraphe3', $paragraphe3, ["placeholder"=>"Paragraphe 3","title"=>"Saisissez votre troisieme paragraphe.", "style"=>"width : 350Px"]);
        $HTML->fieldTextarea('paragraphe4', 'paragraphe4', $paragraphe4, ["placeholder"=>"Paragraphe 4","title"=>"Saisissez votre quatrieme paragraphe.", "style"=>"width : 350Px"]);
    $HTML->_div();
$HTML->_div();
// ----------------------------------------------
if($cmd == "ajouter")
{
    $HTML->submit('', 'Valider',["title" => "Valider vos informations pour vous inscrire.", "formaction"=>"ajouter.php", 'class'=>'button']);
}

// ----------------------------------------------
if($cmd == "modifier")
{
    $HTML->submit('', 'Valider',["title" =>"Valider pour enregistrer vos modifications.", "formaction"=>"modifier.php", 'class'=>'button']);

}

// ----------------------------------------------
$HTML->a('', "liste.php", "Retour",["title" => "Retourner à la page de connexion.", "formaction"=>"liste.php", 'class'=>'button']);

$HTML->_form();

$HTML->output();
}

if($errors->code != 0)
    {
        error_log("\$errors->code = {$errors->code};");
        error_log("\$errors->text = {$errors->text};");

        $HTML->innerHTML("Erreur {$errors->code} :\n{$errors->text}");
//        $HTML->output();

        header("Location: liste.php?error={$errors->code}");
    }