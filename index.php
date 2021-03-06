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
            if(!$res = $MODEL->Exec_request("DELETE FROM ".$_GET['T']." WHERE ".$_GET['key']."=".$_GET['val'])){
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
    elseif($_GET["req"]=="Modif"){
        if(isset($_GET["key"]) && isset($_GET["val"])){
            $OUTPUT .= View::Modif_form($MODEL->Request("SELECT * FROM ".$_GET['T']." WHERE ".$_GET['key']."=".$_GET['val']));
        }
        elseif(isset($_POST["Modif"])){
            $sql = "UPDATE ".$_GET['T']." SET ";
            $first_key = null;
            $first_val = null;
            $first_get = false;
            foreach($_POST as $key => $value){
                if($key!="Modif"){
                    if(!$first_get) {
                        $first_key = $key;
                        $first_val = $value;
                        $first_get = true;
                    }

                    $val = intval($value);
                    if(gettype($value)=="string" && strval($val)!=$value){
                        $sql .= "$key = '$value', ";
                    }
                    else{
                        $sql .= "$key = $value, ";
                    }
                }
            }
            $sql = rtrim($sql,", ");
            $sql .= " WHERE $first_key = $first_val";
            $MODEL->Exec_request($sql);
            header("Location: index.php?T=".$_GET['T']."&req=List");
            exit();
        }
    }
    elseif($_GET["req"]=="Add"){
        if(isset($_POST["Ajout"])){
            $sql = "INSERT INTO ".$_GET['T']." VALUES(";
            foreach($_POST as $key => $value){
                if($key!="Ajout") {
                    if (empty($value)) $value = "";
                    $val = intval($value);
                    if (strval($val) != $value) $sql .= "'$value', ";
                    else $sql .= $value.", ";
                }
            }
            $sql = rtrim($sql, ", ");
            $sql .= ")";
            $MODEL->Exec_request($sql);
            header("Location: index.php?T=".$_GET['T']."&req=List");
            exit();
        }
        else $OUTPUT .= View::Add_row($MODEL->request("DESCRIBE ".$_GET['T']));
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
