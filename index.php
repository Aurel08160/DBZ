<?php 

/* DBZ FRONTAL CONTROLLER
** MVC CMS for database management */

// configuration
require_once("Config/config.script.php");

// connexion db
require_once("Classes/pdo.connexion.class.php");
$PDO = new Pdo_Connexion ($CONFIG['DB_INI_FILE']);

// model class
require_once("Classes/model.class.php");
$MODEL = new Model ($PDO->CNX);

// view class
require_once("Classes/view.class.php");

// html output increment
$OUTPUT = NULL;
// set the menu based on tabless
$OUTPUT .= View::MenuTable ($MODEL->Name_DB(), $MODEL->request("SHOW TABLES"));

if(isset($_GET["T"]) && isset($_GET["req"])){
    if($_GET['req'] == "Suppr"){
        if(isset($_GET["key"]) && isset($_GET["val"])){
            if(!$res = $MODEL->exec_request("DELETE FROM ".$_GET['T']." WHERE ".$_GET['key']."=".$_GET['val'])){
                $OUTPUT .= "Erreur SQL";
            }
            else{
                header("Location: index.php?T=".$_GET['T']."&req=List");
                exit();
            }
        }
        else{
            $OUTPUT .= "<p>Erreur d'arguments</p>";
        }
    }
    else{
        $OUTPUT .= View::liste($MODEL->request("SELECT * FROM " . $_GET["T"]));
    }
}
elseif(isset($_GET["T"])){
    $OUTPUT .= View::funclist();
}






// output echo screen rendering 
View::HTML($CONFIG['MODULE_NAME'], $OUTPUT);

?>
